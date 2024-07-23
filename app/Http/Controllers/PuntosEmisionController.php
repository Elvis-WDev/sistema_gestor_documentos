<?php

namespace App\Http\Controllers;

use App\DataTables\PuntosEmisionDataTable;
use App\Models\PuntoEmision;
use App\Rules\UniqueEstablecimientoPuntoEmision;
use App\Traits\RegistrarActividad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        // $this->isSuperAdmin();
        return $PuntosEmisionDataTable->render('pages.facturas.punto_emision.index');
    }
    public function create()
    {

        return view('pages.facturas.punto_emision.create');
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

        PuntoEmision::create([
            'establecimiento_id' => $request->establecimiento_id,
            'nombre' => $request->nombre,
        ]);

        $this->Actividad(
            Auth::user()->id,
            "Ha registrado un punto emisión",
            "Punto emisión: " .  $request->nombre
        );

        flash('Punto emision registrado correctamente!');

        return redirect()->route('punto_emision');
    }

    public function edit(int $id)
    {
        $PuntoEmision = PuntoEmision::findOrFail($id);

        return view('pages.facturas.punto_emision.edit', compact('PuntoEmision'));
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

        $PuntoEmision = PuntoEmision::findOrFail($request->id);


        $PuntoEmision->establecimiento_id = $request->establecimiento_id;
        $PuntoEmision->nombre = $request->nombre;


        $PuntoEmision->save();

        $this->Actividad(
            Auth::user()->id,
            "Ha editado un punto emisión",
            "Punto emisión: " .  $request->nombre
        );

        flash('Punto emisión actualizado correctamente!');

        return redirect()->route('punto_emision');
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

            flash('Punto emisión eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Punto de emisión eliminado correctamente.']);
        } catch (QueryException $e) {

            return response()->json(['status' => 'error', 'message' => 'No se puede eliminar el punto de emisión porque tiene facturas asociadas.']);
        }
    }
}
