<?php

namespace App\Http\Controllers;

use App\DataTables\PuntosEmisionDataTable;
use App\Models\PuntoEmision;
use App\Rules\UniqueEstablecimientoPuntoEmision;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use RealRashid\SweetAlert\Facades\Alert;

class PuntosEmisionController extends Controller
{

    use RegistrarActividad;

    /**
     * Display a listing of the FileType.
     *
     * @param PuntosEmisionDataTable $PuntosEmisionDataTable
     * @return Response
     */
    public function index(PuntosEmisionDataTable $PuntosEmisionDataTable)
    {
        try {

            return $PuntosEmisionDataTable->render('pages.facturas.punto_emision.index');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al renderizar el DataTable de puntos de emisión', ['exception' => $e]);
            Alert::erorr('Hubo un problema al mostrar los puntos de emisión.');
            return redirect()->route('dashboard');
        }
    }
    public function create()
    {
        try {
            return view('pages.facturas.punto_emision.create');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al renderizar la vista de punto emisión', ['exception' => $e]);
            return redirect()->route('dashboard');
        }
    }
    public function store(Request $request)
    {

        $request->validate([

            'establecimiento_id' => 'required|integer',
            'nombre' => [
                'required',
                'regex:/^\d{1,4}$/',
                new UniqueEstablecimientoPuntoEmision($request->input('establecimiento_id'))
            ],

        ]);

        try {

            PuntoEmision::create([
                'establecimiento_id' => $request->establecimiento_id,
                'nombre' => $request->nombre,
            ]);

            $this->Actividad(
                Auth::user()->id,
                "Ha registrado un punto emisión",
                "Punto emisión: " .  $request->nombre
            );

            toast('Punto emision registrado correctamente!', 'success');

            return redirect()->route('punto_emision');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al registrar punto de emisión', ['exception' => $e]);
            Alert::erorr('Hubo un problema al registrar el punto de emisión.');
        }
    }

    public function edit(int $id)
    {
        try {

            $PuntoEmision = PuntoEmision::findOrFail($id);

            return view('pages.facturas.punto_emision.edit', compact('PuntoEmision'));
        } catch (ModelNotFoundException $e) {
            // Manejo de error si el punto de emisión no se encuentra
            Log::error('Punto de emisión no encontrado', ['id' => $id, 'exception' => $e]);
            Alert::erorr('El punto de emisión solicitado no existe.');
            return redirect()->route('puntos_emision');
        } catch (Exception $e) {
            // Manejo de cualquier otro error general
            Log::error('Error al cargar el punto de emisión para edición', ['id' => $id, 'exception' => $e]);
            Alert::erorr('Hubo un problema al cargar el punto de emisión.');
            return redirect()->route('puntos_emision');
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'establecimiento_id' => 'required|integer|max:255',
            'nombre' => [
                'required',
                'string',
                'regex:/^\d{1,4}$/',
                new UniqueEstablecimientoPuntoEmision($request->input('establecimiento_id'), $request->input('id'))
            ],

        ]);

        try {

            $PuntoEmision = PuntoEmision::findOrFail($request->id);


            $PuntoEmision->establecimiento_id = $request->establecimiento_id;
            $PuntoEmision->nombre = $request->nombre;


            $PuntoEmision->save();

            $this->Actividad(
                Auth::user()->id,
                "Ha editado un punto emisión",
                "Punto emisión: " .  $request->nombre
            );

            toast('Punto emisión actualizado correctamente!', 'success');

            return redirect()->route('punto_emision');
        } catch (ModelNotFoundException $e) {
            // Manejo de error si el punto de emisión no se encuentra
            Log::error('Punto de emisión no encontrado', ['id' => $request->id, 'exception' => $e]);
            Alert::erorr('El punto de emisión solicitado no existe.');
            return redirect()->route('punto_emision');
        } catch (Exception $e) {
            // Manejo de cualquier otro error general
            Log::error('Error al actualizar el punto de emisión', ['id' => $request->id, 'exception' => $e]);
            Alert::erorr('Hubo un problema al actualizar el punto de emisión.');
            return redirect()->route('punto_emision');
        }
    }

    public function destroy(string $id)
    {
        try {
            $PuntoEmision = PuntoEmision::findOrFail($id);
            $tempPuntoEmision =  $PuntoEmision;
            $PuntoEmision->delete();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado un punto emisión",
                "Punto emisión: " .  $tempPuntoEmision->nombre
            );

            return response()->json(['status' => 'success', 'message' => 'Punto de emisión eliminado correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'No se puede eliminar el punto de emisión porque tiene facturas asociadas.']);
        }
    }
}
