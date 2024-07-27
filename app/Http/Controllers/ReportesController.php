<?php

namespace App\Http\Controllers;

use App\Models\Establecimiento;
use App\Models\Factura;
use App\Traits\RegistrarActividad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\PdfParser\StreamReader;
use setasign\Fpdi\Tcpdf\Fpdi;

class ReportesController extends Controller
{
    use RegistrarActividad;

    public function generar_reportes(Request $request)
    {
        $request->validate([
            'txt_fecha_reporte_inicio' => 'required|date',
            'txt_fecha_reporte_final' => 'required|date|after_or_equal:txt_fecha_reporte_inicio',
        ]);

        $fechaInicio = Carbon::parse($request->input('txt_fecha_reporte_inicio'));
        $fechaFinal = Carbon::parse($request->input('txt_fecha_reporte_final'))->endOfDay();

        $reportData = $this->getReportData($fechaInicio, $fechaFinal);

        // Formatear las fechas
        $fechaInicioFormatted = $fechaInicio->isoFormat('D [de] MMMM');
        $fechaFinalFormatted = $fechaFinal->isoFormat('D [de] MMMM');

        // Determinar el título del mes
        $tituloMes = $this->getTitleMonth($fechaInicio, $fechaFinal);

        // Obtener todos los establecimientos y sus respectivos reportes
        $reportesPorEstablecimiento = $this->getReportsPorEstablecimiento($fechaInicio, $fechaFinal);

        $data = array_merge($reportData, [
            'fechaInicio' => $fechaInicioFormatted,
            'fechaFinal' => $fechaFinalFormatted,
            'tituloMes' => $tituloMes,
            'reportesPorEstablecimiento' => $reportesPorEstablecimiento,
        ]);

        $pdf = PDF::loadView('pages.facturas.reportes.pdf.reporte_general', $data);

        $this->Actividad(
            Auth::user()->id,
            "Ha generado un reporte general",
            "Modúlo facturas: " . $fechaInicioFormatted . " a " . $fechaFinalFormatted
        );

        return $pdf->stream('Reporte_general_facturas.pdf', array('Attachment' => 0));
    }

    private function getReportData($fechaInicio, $fechaFinal)
    {
        return [
            'totalFacturado' => $this->getTotalFacturas($fechaInicio, $fechaFinal, 'no_anuladas'),
            'totalFacturasAnuladas' => $this->getTotalFacturas($fechaInicio, $fechaFinal, 'anuladas'),
            'totalAbonos' => $this->getTotalAbonos($fechaInicio, $fechaFinal),
            'totalRetencionIva' => $this->getTotalRetencion($fechaInicio, $fechaFinal, 'RetencionIva'),
            'totalRetencionFuente' => $this->getTotalRetencion($fechaInicio, $fechaFinal, 'RetencionFuente'),
            'totalCuentasPorCobrar' => $this->getCuentasPorCobrar($fechaInicio, $fechaFinal),
        ];
    }

    private function getTotalFacturas($fechaInicio, $fechaFinal, $tipo)
    {
        $query = DB::table('facturas')
            ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal]);

        if ($tipo == 'no_anuladas') {

            $totalNoAnuladas =  $query->where('Estado', '<>', 'Anulada')->sum('Total');

            // Sumar ambos resultados
            return $totalNoAnuladas;
        } else {
            $query->where('Estado', '=', 'Anulada');
            return $query->sum('ValorAnulado');
        }
    }

    private function getTotalAbonos($fechaInicio, $fechaFinal)
    {
        return DB::table('abonos')
            ->whereIn('factura_id', function ($query) use ($fechaInicio, $fechaFinal) {
                $query->select('id_factura')
                    ->from('facturas')
                    ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal]);
            })
            ->sum('valor_abono');
    }

    private function getTotalRetencion($fechaInicio, $fechaFinal, $campo)
    {
        return DB::table('facturas')
            ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal])
            ->where('Estado', '<>', 'Anulada')
            ->sum($campo);
    }

    private function getCuentasPorCobrar($fechaInicio, $fechaFinal)
    {
        $facturas = DB::table('facturas')
            ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal])
            ->whereNotIn('Estado', ['Anulada', 'Pagada'])
            ->get();

        $totalCuentasPorCobrar = 0;

        foreach ($facturas as $factura) {

            $ultimoAbono = DB::table('abonos')
                ->where('factura_id', $factura->id_factura)
                ->orderBy('fecha_abonado', 'desc')
                ->orderBy('id', 'desc')
                ->first();

            if ($ultimoAbono) {
                $saldo = $ultimoAbono->saldo_factura;
            } else {
                $saldo = $factura->Total;
                // Restar retenciones
                $saldo -= $factura->RetencionIva;
                $saldo -= $factura->RetencionFuente;
            }

            // Asegurar que el saldo no sea negativo
            $saldo = max(0, $saldo);

            $totalCuentasPorCobrar += $saldo;
        }

        return $totalCuentasPorCobrar;
    }

    private function getTitleMonth($fechaInicio, $fechaFinal)
    {
        $mesInicio = $fechaInicio->isoFormat('MMMM');
        $mesFinal = $fechaFinal->isoFormat('MMMM');
        return $mesInicio === $mesFinal ? $mesInicio : "$mesInicio - $mesFinal";
    }

    private function getReportsPorEstablecimiento($fechaInicio, $fechaFinal)
    {
        $establecimientos = Establecimiento::all();
        $reportes = [];

        foreach ($establecimientos as $establecimiento) {
            $reportes[$establecimiento->nombre] = [
                'totalFacturado' => $this->getTotalFacturasPorEstablecimiento($fechaInicio, $fechaFinal, $establecimiento->id, 'no_anuladas'),
                'totalFacturasAnuladas' => $this->getTotalFacturasPorEstablecimiento($fechaInicio, $fechaFinal, $establecimiento->id, 'anuladas'),
                'totalAbonos' => $this->getTotalAbonosPorEstablecimiento($fechaInicio, $fechaFinal, $establecimiento->id),
                'totalRetencionIva' => $this->getTotalRetencionPorEstablecimiento($fechaInicio, $fechaFinal, $establecimiento->id, 'RetencionIva'),
                'totalRetencionFuente' => $this->getTotalRetencionPorEstablecimiento($fechaInicio, $fechaFinal, $establecimiento->id, 'RetencionFuente'),
                'totalCuentasPorCobrar' => $this->getCuentasPorCobrarPorEstablecimiento($fechaInicio, $fechaFinal, $establecimiento->id),
            ];
        }

        return $reportes;
    }

    private function getTotalFacturasPorEstablecimiento($fechaInicio, $fechaFinal, $establecimientoId, $tipo)
    {
        $query = DB::table('facturas')
            ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal])
            ->where('establecimiento_id', $establecimientoId);

        if ($tipo == 'no_anuladas') {

            $totalNoAnuladas = $query->where('Estado', '<>', 'Anulada')->sum('Total');

            // Sumar ambos resultados
            return $totalNoAnuladas;
        } else {
            $query->where('Estado', '=', 'Anulada');
            return $query->sum('ValorAnulado');
        }
    }

    private function getTotalAbonosPorEstablecimiento($fechaInicio, $fechaFinal, $establecimientoId)
    {
        return DB::table('abonos')
            ->whereIn('factura_id', function ($query) use ($fechaInicio, $fechaFinal, $establecimientoId) {
                $query->select('id_factura')
                    ->from('facturas')
                    ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal])
                    ->where('establecimiento_id', $establecimientoId);
            })
            ->sum('valor_abono');
    }

    private function getTotalRetencionPorEstablecimiento($fechaInicio, $fechaFinal, $establecimientoId, $campo)
    {
        return DB::table('facturas')
            ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal])
            ->where('Estado', '<>', 'Anulada')
            ->where('establecimiento_id', $establecimientoId)
            ->sum($campo);
    }

    private function getCuentasPorCobrarPorEstablecimiento($fechaInicio, $fechaFinal, $establecimientoId)
    {
        $facturas = DB::table('facturas')
            ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal])
            ->where('establecimiento_id', $establecimientoId)
            ->whereNotIn('Estado', ['Anulada', 'Pagada'])
            ->get();

        $totalCuentasPorCobrar = 0;

        foreach ($facturas as $factura) {

            $ultimoAbono = AbonosController::UltimoAbono($factura->id_factura);

            if ($ultimoAbono) {
                $saldo = $ultimoAbono->saldo_factura;
            } else {
                $saldo = $factura->Total;
                // Restar retenciones
                $saldo -= $factura->RetencionIva;
                $saldo -= $factura->RetencionFuente;
            }

            // Asegurar que el saldo no sea negativo
            $saldo = max(0, $saldo);

            $totalCuentasPorCobrar += $saldo;
        }

        return $totalCuentasPorCobrar;
    }

    // Reportes Anuladas
    public function generar_reportes_anuladas(Request $request)
    {
        $request->validate([
            'txt_fecha_reporte_inicio' => 'required|date',
            'txt_fecha_reporte_final' => 'required|date|after_or_equal:txt_fecha_reporte_inicio',
        ]);

        $fechaInicio = Carbon::parse($request->input('txt_fecha_reporte_inicio'));
        $fechaFinal = Carbon::parse($request->input('txt_fecha_reporte_final'))->endOfDay();

        $fechaInicioFormatted = $fechaInicio->isoFormat('D [de] MMMM');
        $fechaFinalFormatted = $fechaFinal->isoFormat('D [de] MMMM');

        $allFacturas = Factura::with(['establecimiento', 'puntoEmision'])
            ->where('Estado', 'Anulada')
            ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal])
            ->get();

        if ($allFacturas->isEmpty()) {
            flash()->error('No hay facturas anuladas en estas fechas');
            return redirect()->route('facturas-anuladas');
        }

        $totalValorAnulados = Factura::where('Estado', 'Anulada')
            ->whereBetween('FechaEmision', [$fechaInicio, $fechaFinal])
            ->sum('ValorAnulado');

        $pdfFiles = [];
        $chunkedFacturas = $allFacturas->chunk(100);

        foreach ($chunkedFacturas as $index => $facturasChunk) {
            $pdfContent = view('pages.facturas.reportes.pdf.reporte_anuladas', [
                'Facturas' => $facturasChunk,
                'TotalValorAnulados' => $totalValorAnulados,
                'fechaInicio' => $fechaInicioFormatted,
                'fechaFinal' => $fechaFinalFormatted,
                'loop' => (object) ['first' => $index === 0]  // Determina si es el primer chunk
            ])->render();

            $pdf = PDF::loadHTML($pdfContent);
            $pdfFiles[] = $pdf->output();
        }

        $combinedPdf = new Fpdi();

        foreach ($pdfFiles as $pdfFile) {
            $pageCount = $combinedPdf->setSourceFile(StreamReader::createByString($pdfFile));

            for ($i = 1; $i <= $pageCount; $i++) {
                $tplId = $combinedPdf->importPage($i);
                $combinedPdf->AddPage();
                $combinedPdf->useTemplate($tplId);
            }
        }

        $this->Actividad(
            Auth::user()->id,
            "Ha generado un reporte de anulaciones",
            "Modúlo facturas: " . $fechaInicioFormatted . " a " . $fechaFinalFormatted
        );

        return response($combinedPdf->Output('Reporte_total_anuladas.pdf'), 200)
            ->header('Content-Type', 'application/pdf');
    }
}
