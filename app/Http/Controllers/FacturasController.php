<?php

namespace App\Http\Controllers;

use App\DataTables\Facturas\AnuladasFacturasDataTable;
use App\DataTables\Facturas\AbonadasFacturasDataTable;
use App\DataTables\Facturas\PagadasFacturasDataTable;
use App\DataTables\Facturas\TodasFacturasDataTable;
use App\Models\Establecimiento;
use App\Models\Factura;
use App\Models\PuntoEmision;
use App\Rules\UniqueSecuencial;
use App\Traits\FilesUploadTrait;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class FacturasController extends Controller
{
    use FilesUploadTrait, RegistrarActividad;

    public function index(TodasFacturasDataTable $TodasFacturasDataTable)
    {
        try {
            return $TodasFacturasDataTable->render('pages.facturas.index');
        } catch (Exception $e) {
            Log::error('Error al renderizar todas las facturas', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar la información. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard');
        }
    }

    public function FacturasPagadas_index(PagadasFacturasDataTable $PagadasFacturasDataTable)
    {
        try {
            return $PagadasFacturasDataTable->render('pages.facturas.pagadas');
        } catch (Exception $e) {
            Log::error('Error al renderizar facturas pagadas', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar la información. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard');
        }
    }

    public function FacturasAbonada_index(AbonadasFacturasDataTable $AbonadasFacturasDataTable)
    {
        try {
            return $AbonadasFacturasDataTable->render('pages.facturas.abonadas');
        } catch (Exception $e) {
            Log::error('Error al renderizar facturas abonadas', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar la información. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard');
        }
    }

    public function FacturasAnulada_index(AnuladasFacturasDataTable $AnuladasFacturasDataTable)
    {
        try {
            return $AnuladasFacturasDataTable->render('pages.facturas.anuladas');
        } catch (Exception $e) {
            Log::error('Error al renderizar facturas anuladas', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar la información. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard');
        }
    }


    public function create()
    {
        try {
            return view('pages.facturas.create');
        } catch (Exception $e) {
            Log::error('Error al renderizar la vista de creación de factura');
            Alert::error('Hubo un problema al cargar la página de creación de factura. Por favor, inténtalo de nuevo.');
            return redirect()->route('facturas.index');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
            'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
            'FechaEmision' => 'required|date',
            'establecimiento_id' => 'required|integer',
            'punto_emision_id' => 'required|integer',
            'Prefijo' => ['required', 'regex:/^\d{1,8}$/'],
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
        try {
            $retenciones = $request->RetencionIva + $request->RetencionFuente;

            $Saldo =  $request->Total - $retenciones;

            if ($request->Total < $retenciones) {

                Alert::error('Retenciones exceden el total de la factura');

                return redirect()->route('crear-factura');
            }

            $archivos = $this->uploadMultiFile($request, 'Archivos', 'uploads/facturas');

            Factura::create([
                'FechaEmision' => $request->FechaEmision,
                'establecimiento_id' => $request->establecimiento_id,
                'punto_emision_id' => $request->punto_emision_id,
                'Secuencial' => $request->Secuencial,
                'Prefijo' => $request->Prefijo,
                'RazonSocial' => $request->RazonSocial,
                'RetencionIva' => $request->RetencionIva,
                'RetencionFuente' => $request->RetencionFuente,
                'Total' => $request->Total,
                'Estado' => $Saldo == 0 ? 1 : 4,
                'Archivos' => json_encode($archivos, JSON_UNESCAPED_SLASHES),
            ]);

            $this->Actividad(
                Auth::user()->id,
                "Ha registrado una factura",
                "Factura #: " . Establecimiento::findOrFail($request->establecimiento_id)->nombre . PuntoEmision::findOrFail($request->punto_emision_id)->nombre . $request->Secuencial
            );

            toast('Factura registrada correctamente!', 'success');

            return redirect()->route('facturas');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al registrar la factura', ['exception' => $e]);
            Alert::error('Hubo un problema al registrar la factura. Por favor, inténtalo de nuevo.');
            return redirect()->route('crear-factura')->withInput();
        }
    }

    public function edit(int $id)
    {
        try {
            $Factura = Factura::with(['establecimiento', 'puntoEmision'])->findOrFail($id);

            return view('pages.facturas.edit', compact('Factura'));
        } catch (ModelNotFoundException $e) {
            // Manejo del caso en que la factura no se encuentre
            Log::error('Factura no encontrada', ['id' => $id, 'exception' => $e]);
            Alert::error('La factura que estás tratando de editar no existe.');
            return redirect()->route('facturas.index');
        } catch (Exception $e) {
            // Manejo de cualquier otro tipo de excepción
            Log::error('Error al intentar editar la factura', ['id' => $id, 'exception' => $e]);
            Alert::error('Hubo un problema al intentar editar la factura. Por favor, inténtalo de nuevo.');
            return redirect()->route('facturas.index');
        }
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
            'Prefijo' => ['required', 'regex:/^\d{1,8}$/'],
            'Secuencial' => [
                'required',
                'digits:9',
                'regex:/^\d{9}$/',
                new UniqueSecuencial($request->input('establecimiento_id'), $request->input('punto_emision_id'), $request->input('id'))
            ],
            'RazonSocial' => 'required|string|max:255',
        ]);

        try {

            $factura = Factura::with(['establecimiento', 'puntoEmision'])->findOrFail($request->id);

            if ($request->hasFile('Archivos')) {

                $archivos = $this->updateMultiFile($request, 'Archivos', 'uploads/facturas', 'old_archivos', 'uploads/trash/facturas/', "Archivos eliminados al editar factura con prefijo: # " . $request->Prefijo);

                $factura->Archivos = $archivos;
            } elseif ($request->filled('old_archivos')) {
                $factura->Archivos = $request->old_archivos;
            } else {
                $factura->Archivos = null;
            }

            $factura->Prefijo = $request->Prefijo;
            $factura->FechaEmision = $request->FechaEmision;
            $factura->establecimiento_id = $request->establecimiento_id;
            $factura->punto_emision_id = $request->punto_emision_id;
            $factura->Secuencial = $request->Secuencial;
            $factura->RazonSocial = $request->RazonSocial;

            $factura->save();

            $this->Actividad(
                Auth::user()->id,
                "Ha editado una factura",
                "Factura #: " .  $factura->establecimiento->nombre . $factura->puntoEmision->nombre . $factura->Secuencial
            );

            toast('Factura actualizada correctamente!', 'success');

            return redirect()->route('facturas');
        } catch (ModelNotFoundException $e) {
            // Manejo del caso en que la factura no se encuentre
            Log::error('Factura no encontrada para actualizar', ['id' => $request->id, 'exception' => $e]);
            Alert::error('La factura que intentas actualizar no existe.');
            return redirect()->route('facturas');
        } catch (Exception $e) {
            // Manejo de cualquier otro tipo de excepción
            Log::error('Error al actualizar factura', ['id' => $request->id, 'exception' => $e]);
            Alert::error('Hubo un problema al intentar actualizar la factura. Por favor, inténtalo de nuevo.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(int $id)
    {

        try {
            $factura = Factura::with(['establecimiento', 'puntoEmision'])->findOrFail($id);

            $tempFactura = $factura;

            $this->DestroyFiles($factura->Archivos, 'uploads/trash/facturas/', 'Archivos eliminados al eliminar una factura: # ' . $tempFactura->establecimiento->nombre . $tempFactura->puntoEmision->nombre . $tempFactura->Secuencial);

            $factura->abonos()->delete();

            $factura->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado una factura",
                "Factura #: " . $tempFactura->establecimiento->nombre . $tempFactura->puntoEmision->nombre . $tempFactura->Secuencial
            );

            return response()->json(['status' => 'success', 'message' => 'Factura eliminada correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'Hubo un problema al intentar eliminar la factura. Por favor, inténtalo de nuevo.']);
        }
    }

    public function anular_factura(int $id)
    {

        DB::beginTransaction();

        try {
            $factura = Factura::findOrFail($id);

            if ($factura->Estado == 1) {
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'No se puede anular una factura que ya está pagada.']);
            }

            // Obtener el último abono de la factura
            $ultimoAbono = AbonosController::UltimoAbono($factura->id_factura);

            if ($ultimoAbono) {

                $saldo = $ultimoAbono->saldo_factura;
                $saldo += $factura->RetencionIva;
                $saldo += $factura->RetencionFuente;
                // Actualizar el campo ValorAnulado
                $factura->ValorAnulado = $saldo; //Sumarle el valor de retencionIva yretencionFuente
            } else {
                $saldo = $factura->Total;

                $factura->ValorAnulado = $saldo;
            }

            // Actualizar el estado de la factura a anulada
            $factura->update(['Estado' => 2]);

            $this->Actividad(
                Auth::user()->id,
                "Ha anulado una factura",
                "Factura #: " . $factura->establecimiento->nombre . $factura->puntoEmision->nombre . $factura->Secuencial
            );
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Factura anulada correctamente.']);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Hubo un problema al intentar anular la factura. Por favor, inténtalo de nuevo.']);
        }
    }

    public function get_punto_emision(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:establecimientos,id',
        ]);

        try {

            $PuntoEmision = PuntoEmision::where('establecimiento_id', $request->id)->get();
            return $PuntoEmision;
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al obtener puntos de emisión', ['id' => $request->id, 'exception' => $e]);

            return response()->json([
                'error' => 'Hubo un problema al intentar obtener los puntos de emisión.'
            ], 500);
        }
    }
}
