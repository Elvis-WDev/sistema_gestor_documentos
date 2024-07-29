<?php

namespace App\Http\Controllers;

use App\DataTables\PagosDataTable;
use App\Models\Pago;
use App\Traits\FilesUploadTrait;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PagosController extends Controller
{
    use FilesUploadTrait, RegistrarActividad;
    /**
     * Display a listing of the FileType.
     *
     * @param PagosDataTable $PagosDataTable
     * @return Response
     */
    public function index(PagosDataTable $PagosDataTable)
    {
        try {
            return $PagosDataTable->render('pages.pagos.index');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al renderizar la tabla de pagos', ['exception' => $e]);
            flash()->error('Hubo un problema al cargar la lista de pagos. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard'); // Asegúrate de tener una ruta 'error.page' o redirige a la página adecuada
        }
    }

    public function create()
    {
        try {

            return view('pages.pagos.create');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al renderizar la vista de módulos personalizados', ['exception' => $e]);
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'id_factura' => 'required|numeric',
                'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
                'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
                'FechaPago' => 'required|date',
                'Total' => 'required|numeric|gte:0',
            ]);

            // Procesamiento de archivos utilizando uploadMultiFile
            $archivos = $this->uploadMultiFile($request, 'Archivos', 'uploads/pagos');

            Pago::create([
                'id_factura' => $request->id_factura,
                'Archivos' => json_encode($archivos, JSON_UNESCAPED_SLASHES),
                'Total' => $request->Total,
                'FechaPago' => $request->FechaPago,
            ]);

            $this->Actividad(
                Auth::user()->id,
                "Ha registrado un pago",
                "Monto: $" . $request->Total
            );

            flash('Pago registrado correctamente!');

            return redirect()->route('pagos');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al registrar el pago', ['exception' => $e]);
            flash()->error('Hubo un problema al registrar el pago. Por favor, inténtalo de nuevo.');
            return redirect()->back()->withInput();
        }
    }

    public function edit(int $id)
    {
        try {

            $Pago = Pago::with(['factura'])->findOrFail($id);

            return view('pages.pagos.edit', compact('Pago'));
        } catch (ModelNotFoundException $e) {
            // Manejo de errores cuando no se encuentra el registro
            Log::error('Pago no encontrado', ['exception' => $e]);
            flash()->error('El pago que intentas editar no existe.');
            return redirect()->route('pagos');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al cargar el formulario de edición de pago', ['exception' => $e]);
            flash()->error('Hubo un problema al cargar el formulario de edición. Por favor, inténtalo de nuevo.');
            return redirect()->route('pagos');
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id_pago' => 'required|integer',
                'old_archivos' => 'required|string|max:1000',
                'id_factura' => 'required|numeric',
                'Archivos.*' => 'file|mimes:' . config('config_general')['general']['archivos_permitidos'] . '|max:' . (config('config_general')['general']['tamano_maximo_permitido']) * 1024,
                'Archivos' => 'max:' . config('config_general')['general']['cantidad_permitidos'],
                'FechaPago' => 'required|date',
                'Total' => 'required|numeric|gt:0',
            ]);

            $Pago = Pago::findOrFail($request->id_pago);

            if ($request->hasFile('Archivos')) {

                $archivos = $this->updateMultiFile($request, 'Archivos', 'uploads/pagos', 'old_archivos', 'uploads/trash/pagos/', "Archivos eliminados al editar un pago de $" . $request->Total);

                $Pago->Archivos = $archivos;
            } elseif ($request->filled('old_archivos')) {

                $Pago->Archivos = $request->old_archivos;
            } else {

                $Pago->Archivos = null;
            }

            $Pago->id_factura = $request->id_factura;
            $Pago->FechaPago = $request->FechaPago;
            $Pago->Total = $request->Total;
            $Pago->save();

            $this->Actividad(
                Auth::user()->id,
                "Ha editado un pago",
                "Monto: $" . $request->Total
            );

            flash('Pago actualizado correctamente!');

            return redirect()->route('pagos');
        } catch (ModelNotFoundException $e) {
            // Manejo específico para no encontrar el pago
            Log::error('Pago no encontrado', ['exception' => $e]);
            flash()->error('El pago que intentas editar no existe.');
            return redirect()->route('pagos');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al actualizar el pago', ['exception' => $e]);
            flash()->error('Hubo un problema al actualizar el pago. Por favor, inténtalo de nuevo.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Int $id)
    {
        try {

            $Pago = Pago::findOrFail($id);

            $tempPago = $Pago;

            $this->DestroyFiles($Pago->Archivos, 'uploads/trash/pagos/', 'Archivos eliminados al eliminar un pago: $' . $tempPago->Total);

            $Pago->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado un pago",
                "Monto: $" .  $tempPago->Total
            );

            flash('Pago eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Pago eliminado correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Hubo un problema al eliminar el pago. Por favor, inténtalo de nuevo.']);
        }
    }
}
