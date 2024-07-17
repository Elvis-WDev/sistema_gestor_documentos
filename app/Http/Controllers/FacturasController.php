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
            'Prefijo' => ['required', 'digits:8', 'regex:/^\d{8}$/'],
            'Secuencial' => [
                'required',
                'digits:9',
                'regex:/^\d{9}$/',
                new UniqueSecuencial($request->input('establecimiento_id'), $request->input('punto_emision_id'))
            ],
            'RetencionIva' => 'required|numeric|gte:0',
            'RetencionFuente' => 'required|numeric|gte:0',
            'RazonSocial' => 'required|string|max:255',
            'Total' => 'required|numeric|gt:0',
        ]);

        $retenciones = $request->RetencionIva + $request->RetencionFuente;

        if ($request->Total < $retenciones) {

            flash()->error('Retenciones exceden el total de la factura');

            return redirect()->route('crear-factura');
        }

        // Procesamiento de archivos utilizando uploadMultiFile
        $archivos = $this->uploadMultiFile($request, 'Archivos', 'uploads/facturas');

        Factura::create([
            'FechaEmision' => $request->FechaEmision,
            'establecimiento_id' => $request->establecimiento_id,
            'punto_emision_id' => $request->punto_emision_id,
            'Secuencial' => $request->Secuencial,
            'RazonSocial' => $request->RazonSocial,
            'RetencionIva' => $request->RetencionIva,
            'RetencionFuente' => $request->RetencionFuente,
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
            'Prefijo' => ['required', 'digits:8', 'regex:/^\d{8}$/'],
            'Secuencial' => [
                'required',
                'digits:9',
                'regex:/^\d{9}$/',
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

    public function anular_factura(int $id)
    {
        try {
            $factura = Factura::findOrFail($id);

            // Verificar si la factura ya está pagada
            if ($factura->Estado == 1) {
                return response()->json(['status' => 'error', 'message' => 'No se puede anular una factura que ya está pagada.']);
            }

            // Obtener el último abono de la factura
            $ultimoAbono = Abonos::where('factura_id', $factura->id_factura)
                ->orderBy('fecha_abonado', 'desc')
                ->orderBy('id', 'desc') // Ordenar también por id para asegurar el orden correcto
                ->first();

            if ($ultimoAbono) {
                // Calcular el saldo de la factura basado en el último abono
                $saldo = $ultimoAbono->saldo_factura;
                $saldo += $factura->RetencionIva;
                $saldo += $factura->RetencionFuenta;
                // Actualizar el campo ValorAnulado
                $factura->ValorAnulado = $saldo; //Sumarle el valor de retencionIva yretencionFuente
            } else {
                $saldo = $factura->Total;

                $factura->ValorAnulado = $saldo;
            }

            // Actualizar el estado de la factura a anulada
            $factura->update(['Estado' => 2]);

            flash('Factura anulada.');

            return response()->json(['status' => 'success', 'message' => 'Factura anulada correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al anular la factura.']);
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
}
