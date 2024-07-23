<?php

namespace App\Http\Controllers;

use App\DataTables\EstablecimientosDataTable;
use App\Models\Establecimiento;
use App\Traits\RegistrarActividad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // $this->isSuperAdmin();
        return $EstablecimientosDataTable->render('pages.facturas.establecimiento.index');
    }
    public function create()
    {

        return view('pages.facturas.establecimiento.create');
    }
    public function store(Request $request)
    {

        $request->validate([

            'nombre' => ['required', 'string', 'max:255', 'unique:' . Establecimiento::class],

        ]);

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
    }

    public function edit(int $id)
    {
        $Establecimiento = Establecimiento::findOrFail($id);

        return view('pages.facturas.establecimiento.edit', compact('Establecimiento'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'nombre' => ['required', 'string', 'max:255', Rule::unique('establecimientos')->ignore($request->id)],

        ]);

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
        }
    }
}