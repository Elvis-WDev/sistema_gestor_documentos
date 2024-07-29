<?php

namespace App\Http\Controllers;

use App\DataTables\EstablecimientosDataTable;
use App\Models\Establecimiento;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class EstablecimientosController extends Controller
{

    use RegistrarActividad;

    /**
     * Display a listing of the FileType.
     *
     * @param EstablecimientosDataTable $EstablecimientosDataTable
     * @return Response
     */
    public function index(EstablecimientosDataTable $EstablecimientosDataTable)
    {
        try {

            return $EstablecimientosDataTable->render('pages.facturas.establecimiento.index');
        } catch (Exception $e) {
            Log::error('Error al cargar DataTable de establecimientos', ['exception' => $e]);
            flash()->error('Hubo un problema al cargar la información. Por favor, inténtalo de nuevo.');
            return redirect()->route('dashboard');
        }
    }
    public function create()
    {
        try {
            return view('pages.facturas.establecimiento.create');
        } catch (Exception $e) {
            // Manejar cualquier excepción que pueda ocurrir
            Log::error('Error al renderizar la vista de creación', ['exception' => $e]);
            flash()->error('Hubo un problema al cargar la página de creación. Por favor, inténtalo de nuevo.');
            return redirect()->route('establecimientos');
        }
    }
    public function store(Request $request)
    {

        $request->validate([
            'nombre' => ['required', 'string', 'max:255', 'unique:' . Establecimiento::class],
        ]);

        try {

            Establecimiento::create([
                'nombre' => $request->nombre,
            ]);

            $this->Actividad(
                Auth::user()->id,
                "Ha registrado un establecimiento",
                "Establecimiento: " .  $request->nombre
            );

            flash('Establecimiento registrado correctamente!');

            return redirect()->route('establecimientos');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al registrar establecimiento', ['exception' => $e]);
            flash()->error('Hubo un problema al registrar el establecimiento. Por favor, inténtalo de nuevo.');
            return redirect()->back()->withInput();
        }
    }

    public function edit(int $id)
    {
        try {
            $Establecimiento = Establecimiento::findOrFail($id);

            return view('pages.facturas.establecimiento.edit', compact('Establecimiento'));
        } catch (ModelNotFoundException $e) {
            // Manejar el caso en que el establecimiento no se encuentra
            Log::error('Establecimiento no encontrado', ['id' => $id, 'exception' => $e]);
            flash()->error('El establecimiento solicitado no fue encontrado.');
            return redirect()->route('establecimientos');
        } catch (Exception $e) {
            // Manejar cualquier otra excepción que pueda ocurrir
            Log::error('Error al renderizar la vista de edición', ['exception' => $e]);
            flash()->error('Hubo un problema al cargar la página de edición. Por favor, inténtalo de nuevo.');
            return redirect()->route('establecimientos');
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'nombre' => ['required', 'string', 'max:255', Rule::unique('establecimientos')->ignore($request->id)],

        ]);
        try {
            $Establecimiento = Establecimiento::findOrFail($request->id);

            $Establecimiento->nombre = $request->nombre;

            $Establecimiento->save();

            $this->Actividad(
                Auth::user()->id,
                "Ha editado un establecimiento",
                "Establecimiento: " .  $request->nombre
            );

            flash('Establecimiento actualizado correctamente!');

            return redirect()->route('establecimientos');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al actualizar establecimiento', ['exception' => $e]);
            flash()->error('Hubo un problema al actualizar el establecimiento. Por favor, inténtalo de nuevo.');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {

            $establecimiento = Establecimiento::findOrFail($id);
            $tempEstablecimiento = $establecimiento;
            $establecimiento->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado un establecimiento",
                "Establecimiento: " .  $tempEstablecimiento->nombre
            );

            flash('Establecimiento eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Establecimiento eliminado correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'No se puede eliminar el establecimiento porque tiene relaciones asociadas.']);
        } catch (Exception $e) {

            return response()->json(['status' => 'error', 'message' => 'Hubo un problema al eliminar el establecimiento. Por favor, inténtalo de nuevo.']);
        }
    }
}
