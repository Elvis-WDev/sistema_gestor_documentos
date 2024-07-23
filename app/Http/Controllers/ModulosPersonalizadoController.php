<?php

namespace App\Http\Controllers;

use App\DataTables\ModuloPersonalizadoDataTable;
use App\Models\ModuloPersonalizado;
use App\Traits\RegistrarActividad;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ModulosPersonalizadoController extends Controller
{

    use RegistrarActividad;

    public function index()
    {
        return view('pages.modulospesonalizados.index');
    }
    public function create()
    {
        return view('pages.modulospesonalizados.create');
    }
    public function store(Request $request)
    {

        $request->validate([
            'NombreModulo' => ['required', 'string', 'max:255',   Rule::unique('modulos_personalizados')->where(function ($query) {
                return $query->where('Estado', 'Activo');
            }),],
            'id_usuario' => ['required', 'integer']
        ]);

        ModuloPersonalizado::create([
            'NombreModulo' => $request->NombreModulo,
            'id_usuario' => $request->id_usuario,
            'Estado' => 1,
        ]);

        $this->Actividad(
            Auth::user()->id,
            "Ha creado una carpeta",
            "Carpeta: " .  $request->NombreModulo
        );

        flash('Carpeta creada correctamente!');

        return redirect()->route('custom-module');
    }

    public function edit(int $id)
    {

        $Modulo = ModuloPersonalizado::findOrFail($id);

        return view('pages.modulospesonalizados.edit', compact('Modulo'));
    }

    public function update(Request $request)
    {

        $request->validate([
            'id_modulo' => ['required', 'integer'],
            'NombreModulo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('modulos_personalizados', 'NombreModulo')->ignore($request->id_modulo, 'id_modulo')
            ],
        ]);


        $modulo = ModuloPersonalizado::findOrFail($request->id_modulo);

        $modulo->NombreModulo = $request->NombreModulo;

        $modulo->save();

        $this->Actividad(
            Auth::user()->id,
            "Ha editado una carpeta",
            "Carpeta: " .  $request->NombreModulo
        );

        flash('Carpeta actualizada correctamente!');

        return redirect()->route('custom-module');
    }

    public function chage_status(Request $request)
    {
        try {
            $request->validate([
                'id_module' => 'required|integer',
            ]);

            $module = ModuloPersonalizado::findOrFail($request->id_module);

            $module->Estado = 2;

            $module->save();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado una carpeta",
                "Carpeta: " .  $module->NombreModulo
            );

            flash('Eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Eliminado correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al eliminar carpeta.']);
        }
    }
}
