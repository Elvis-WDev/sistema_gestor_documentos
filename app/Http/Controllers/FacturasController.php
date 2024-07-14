<?php

namespace App\Http\Controllers;

use App\DataTables\Facturas\AnuladasFacturasDataTable;
use App\DataTables\Facturas\AbonadasFacturasDataTable;
use App\DataTables\Facturas\PagadasFacturasDataTable;
use App\DataTables\Facturas\TodasFacturasDataTable;
use App\Models\Abonos;
use App\Models\Establecimiento;
use App\Models\Factura;
use App\Models\PuntoEmision;
use App\Rules\UniqueSecuencial;
use App\Traits\FilesUploadTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;

class FacturasController extends Controller
{
    use FilesUploadTrait;

    public function index(TodasFacturasDataTable $TodasFacturasDataTable)
    {
        return $TodasFacturasDataTable->render('pages.facturas.index');
    }
    public function FacturasPagadas_index(PagadasFacturasDataTable $PagadasFacturasDataTable)
    {
        return $PagadasFacturasDataTable->render('pages.facturas.pagadas');
    }
    public function FacturasAbonada_index(AbonadasFacturasDataTable $AbonadasFacturasDataTable)
    {
        return $AbonadasFacturasDataTable->render('pages.facturas.abonadas');
    }
    public function FacturasAnulada_index(AnuladasFacturasDataTable $AnuladasFacturasDataTable)
    {
        return $AnuladasFacturasDataTable->render('pages.facturas.anuladas');
    }

    public function create()
    {
        return view('pages.facturas.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
            'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
            'FechaEmision' => 'required|date',
            'establecimiento_id' => 'required|integer',
            'punto_emision_id' => 'required|integer',
            'Secuencial' => [
                'required',
                'string',
                'max:9',
                new UniqueSecuencial($request->input('establecimiento_id'), $request->input('punto_emision_id'))
            ],
            'RazonSocial' => 'required|string|max:255',
            'Total' => 'required|numeric|gt:0',
        ]);


        // Procesamiento de archivos utilizando uploadMultiFile
        $archivos = $this->uploadMultiFile($request, 'Archivos', 'uploads/facturas');

        Factura::create([
            'FechaEmision' => $request->FechaEmision,
            'establecimiento_id' => $request->establecimiento_id,
            'punto_emision_id' => $request->punto_emision_id,
            'Secuencial' => $request->Secuencial,
            'RazonSocial' => $request->RazonSocial,
            'Total' => $request->Total,
            'Estado' => 4,
            'Archivos' => json_encode($archivos, JSON_UNESCAPED_SLASHES),
        ]);


        flash('Factura registrada correctamente!');

        return redirect()->route('facturas');
    }

    public function edit(int $id_factura)
    {
        $Factura = Factura::findOrFail($id_factura);

        return view('pages.facturas.edit', compact('Factura'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
            'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
            'old_archivos' => 'string|max:1000',
            'FechaEmision' => 'required|date',
            'establecimiento_id' => 'required|string|max:255',
            'punto_emision_id' => 'required|string|max:255',
            'Secuencial' => [
                'required',
                'string',
                'max:9',
                new UniqueSecuencial($request->input('establecimiento_id'), $request->input('punto_emision_id'), $request->input('id'))
            ],
            'RazonSocial' => 'required|string|max:255',
        ]);

        $factura = Factura::findOrFail($request->id);

        if ($request->hasFile('Archivos')) {
            // Mover archivos antiguos a la carpeta de "trash" si hay nuevos archivos
            if ($request->filled('old_archivos')) {
                $old_archivos = json_decode($request->old_archivos, true);

                foreach ($old_archivos as $old_archivo) {
                    $trashPath = 'uploads/trash/facturas/' . basename($old_archivo);
                    Storage::disk('public')->move($old_archivo, $trashPath);
                }
            }

            // Subir nuevos archivos y actualizar el campo Archivos
            $archivos = $this->uploadMultiFile($request, 'Archivos', 'uploads/facturas');
            $factura->Archivos = json_encode($archivos);
        } elseif ($request->filled('old_archivos')) {
            // Si no hay nuevos archivos pero se especificaron archivos antiguos, mantener los archivos antiguos
            $factura->Archivos = $request->old_archivos;
        } else {
            // Si no hay nuevos archivos ni archivos antiguos, limpiar el campo Archivos
            $factura->Archivos = null;
        }

        $factura->FechaEmision = $request->FechaEmision;
        $factura->establecimiento_id = $request->establecimiento_id;
        $factura->punto_emision_id = $request->punto_emision_id;
        $factura->Secuencial = $request->Secuencial;
        $factura->RazonSocial = $request->RazonSocial;

        $factura->save();

        flash('Factura actualizada correctamente!');

        return redirect()->route('facturas');
    }


    public function anular_factura(int $id)
    {

        try {
            $factura = Factura::findOrFail($id);

            if (!is_null($factura->Archivos)) {
                $archivos = json_decode($factura->Archivos, true);

                foreach ($archivos as $archivo) {
                    $trashPath = 'uploads/trash/facturas/' . basename($archivo);
                    Storage::disk('public')->move($archivo, $trashPath);
                }
            }

            // Eliminar abonos relacionados
            $factura->abonos()->delete();

            $factura->update(['Estado' => 2]);

            flash('Factura anulada.');

            return response()->json(['status' => 'success', 'message' => 'Factura anulada correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'Error al anular la factura.']);
        }
    }
    public function destroy(int $id)
    {

        try {
            $factura = Factura::findOrFail($id);

            if (!is_null($factura->Archivos)) {
                $archivos = json_decode($factura->Archivos, true);

                foreach ($archivos as $archivo) {
                    $trashPath = 'uploads/trash/facturas/' . basename($archivo);
                    Storage::disk('public')->move($archivo, $trashPath);
                }
            }

            // Eliminar abonos relacionados
            $factura->abonos()->delete();

            $factura->delete();

            flash('Factura eliminada correctamente.');

            return response()->json(['status' => 'success', 'message' => 'Factura eliminada correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'Error al eliminar la factura.']);
        }
    }

    public function get_punto_emision(Request $request)
    {
        $PuntoEmision = PuntoEmision::where('establecimiento_id', $request->id)->get();
        return $PuntoEmision;
    }

    public function reportes()
    {

        $facturas = Factura::select(
            DB::raw('DATE_FORMAT(FechaEmision, "%Y-%m-%d") as FechaEmision'),
            DB::raw('SUM(Total) as value')
        )->groupBy('FechaEmision')->get();

        // Convert the collection to an array
        $facturas = $facturas->map(function ($item) {
            return [
                'FechaEmision' => $item->FechaEmision,
                'value' => $item->value
            ];
        })->toArray();

        return view('pages.facturas.reportes.index', compact('facturas'));
    }

    public function generar_reportes(Request $request)
    {
        // Validar las fechas
        $request->validate([
            'txt_fecha_reporte_inicio' => 'required|date',
            'txt_fecha_reporte_final' => 'required|date|after_or_equal:txt_fecha_reporte_inicio',
        ]);

        $fechaInicio = Carbon::parse($request->input('txt_fecha_reporte_inicio'));
        $fechaFinal = Carbon::parse($request->input('txt_fecha_reporte_final'));

        // Consulta SQL para obtener la suma total de las facturas que no están anuladas
        $totalFacturasNoAnuladas = DB::table('facturas')
            ->select(DB::raw('SUM(Total) AS total_facturas_no_anuladas'))
            ->where('FechaEmision', '>=', $fechaInicio)
            ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
            ->where('Estado', '<>', 'Anulada')
            ->first();

        // Consulta SQL para obtener la suma total de las facturas anuladas
        $totalFacturasAnuladas = DB::table('facturas')
            ->select(DB::raw('SUM(Total) AS total_facturas_anuladas'))
            ->where('FechaEmision', '>=', $fechaInicio)
            ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
            ->where('Estado', '=', 'Anulada')
            ->first();

        // Consulta SQL para obtener la suma de los abonos realizados de todas las facturas
        $totalAbonos = DB::table('abonos')
            ->select(DB::raw('SUM(valor_abono) AS total_abonos'))
            ->whereIn('factura_id', function ($query) use ($fechaInicio, $fechaFinal) {
                $query->select('id_factura')
                    ->from('facturas')
                    ->where('FechaEmision', '>=', $fechaInicio)
                    ->where('FechaEmision', '<', $fechaFinal->copy()->addDay());
            })
            ->first();

        // Consulta SQL para obtener la suma de RetencionIva de todas las facturas que no están anuladas
        $totalRetencionIva = DB::table('facturas')
            ->select(DB::raw('SUM(RetencionIva) AS total_retencion_iva'))
            ->where('FechaEmision', '>=', $fechaInicio)
            ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
            ->where('Estado', '<>', 'Anulada')
            ->first();

        // Consulta SQL para obtener la suma de RetencionFuente de todas las facturas que no están anuladas
        $totalRetencionFuente = DB::table('facturas')
            ->select(DB::raw('SUM(RetencionFuente) AS total_retencion_fuente'))
            ->where('FechaEmision', '>=', $fechaInicio)
            ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
            ->where('Estado', '<>', 'Anulada')
            ->first();

        // Consulta SQL para obtener la suma total de los saldos de los abonos realizados
        $totalSaldoAbonos = DB::table('abonos as a')
            ->join(DB::raw('(SELECT factura_id, MAX(fecha_abonado) as max_fecha_abonado, MAX(id) as max_id FROM abonos GROUP BY factura_id) as b'), function ($join) {
                $join->on('a.factura_id', '=', 'b.factura_id')
                    ->on('a.fecha_abonado', '=', 'b.max_fecha_abonado')
                    ->on('a.id', '=', 'b.max_id');
            })
            ->whereIn('a.factura_id', function ($query) use ($fechaInicio, $fechaFinal) {
                $query->select('id_factura')
                    ->from('facturas')
                    ->where('FechaEmision', '>=', $fechaInicio)
                    ->where('FechaEmision', '<', $fechaFinal->copy()->addDay());
            })
            ->sum('a.saldo_factura');

        // Si no se encontraron facturas, establecer total en 0
        $totalFacturasNoAnuladas = $totalFacturasNoAnuladas->total_facturas_no_anuladas ?? 0;
        $totalFacturasAnuladas = $totalFacturasAnuladas->total_facturas_anuladas ?? 0;
        $totalAbonos = $totalAbonos->total_abonos ?? 0;
        $totalRetencionIva = $totalRetencionIva->total_retencion_iva ?? 0;
        $totalRetencionFuente = $totalRetencionFuente->total_retencion_fuente ?? 0;
        $totalSaldoAbonos = $totalSaldoAbonos ?? 0;

        // Formatear las fechas
        $fechaInicioFormatted = $fechaInicio->isoFormat('D [de] MMMM');
        $fechaFinalFormatted = $fechaFinal->isoFormat('D [de] MMMM');

        // Determinar el título del mes
        $mesInicio = $fechaInicio->isoFormat('MMMM');
        $mesFinal = $fechaFinal->isoFormat('MMMM');
        $tituloMes = $mesInicio === $mesFinal ? $mesInicio : "$mesInicio - $mesFinal";

        // Obtener todos los establecimientos
        $establecimientos = Establecimiento::all();
        $reportesPorEstablecimiento = [];

        foreach ($establecimientos as $establecimiento) {
            $reportesPorEstablecimiento[$establecimiento->nombre] = [
                'totalFacturasNoAnuladas' => DB::table('facturas')
                    ->select(DB::raw('SUM(Total) AS total_facturas_no_anuladas'))
                    ->where('FechaEmision', '>=', $fechaInicio)
                    ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
                    ->where('Estado', '<>', 'Anulada')
                    ->where('establecimiento_id', $establecimiento->id)
                    ->first()->total_facturas_no_anuladas ?? 0,
                'totalFacturasAnuladas' => DB::table('facturas')
                    ->select(DB::raw('SUM(Total) AS total_facturas_anuladas'))
                    ->where('FechaEmision', '>=', $fechaInicio)
                    ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
                    ->where('Estado', '=', 'Anulada')
                    ->where('establecimiento_id', $establecimiento->id)
                    ->first()->total_facturas_anuladas ?? 0,
                'totalAbonos' => DB::table('abonos')
                    ->select(DB::raw('SUM(valor_abono) AS total_abonos'))
                    ->whereIn('factura_id', function ($query) use ($fechaInicio, $fechaFinal, $establecimiento) {
                        $query->select('id_factura')
                            ->from('facturas')
                            ->where('FechaEmision', '>=', $fechaInicio)
                            ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
                            ->where('establecimiento_id', $establecimiento->id);
                    })
                    ->first()->total_abonos ?? 0,
                'totalRetencionIva' => DB::table('facturas')
                    ->select(DB::raw('SUM(RetencionIva) AS total_retencion_iva'))
                    ->where('FechaEmision', '>=', $fechaInicio)
                    ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
                    ->where('Estado', '<>', 'Anulada')
                    ->where('establecimiento_id', $establecimiento->id)
                    ->first()->total_retencion_iva ?? 0,
                'totalRetencionFuente' => DB::table('facturas')
                    ->select(DB::raw('SUM(RetencionFuente) AS total_retencion_fuente'))
                    ->where('FechaEmision', '>=', $fechaInicio)
                    ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
                    ->where('Estado', '<>', 'Anulada')
                    ->where('establecimiento_id', $establecimiento->id)
                    ->first()->total_retencion_fuente ?? 0,
                'totalSaldoAbonos' => DB::table('abonos as a')
                    ->join(DB::raw('(SELECT factura_id, MAX(fecha_abonado) as max_fecha_abonado, MAX(id) as max_id FROM abonos GROUP BY factura_id) as b'), function ($join) {
                        $join->on('a.factura_id', '=', 'b.factura_id')
                            ->on('a.fecha_abonado', '=', 'b.max_fecha_abonado')
                            ->on('a.id', '=', 'b.max_id');
                    })
                    ->whereIn('a.factura_id', function ($query) use ($fechaInicio, $fechaFinal, $establecimiento) {
                        $query->select('id_factura')
                            ->from('facturas')
                            ->where('FechaEmision', '>=', $fechaInicio)
                            ->where('FechaEmision', '<', $fechaFinal->copy()->addDay())
                            ->where('establecimiento_id', $establecimiento->id);
                    })
                    ->sum('a.saldo_factura') ?? 0,
            ];
        }

        $data = [
            'tituloMes' => $tituloMes,
            'fechaInicio' => $fechaInicioFormatted,
            'fechaFinal' => $fechaFinalFormatted,
            'totalFacturasNoAnuladas' => $totalFacturasNoAnuladas,
            'totalFacturasAnuladas' => $totalFacturasAnuladas,
            'totalAbonos' => $totalAbonos,
            'totalRetencionIva' => $totalRetencionIva,
            'totalRetencionFuente' => $totalRetencionFuente,
            'totalSaldoAbonos' => $totalSaldoAbonos,
            'reportesPorEstablecimiento' => $reportesPorEstablecimiento,
        ];

        $pdf = PDF::loadView('pages.facturas.reportes.pdf.reporte_general', $data);

        return $pdf->stream('Reporte_general_facturas.pdf');
    }
}
