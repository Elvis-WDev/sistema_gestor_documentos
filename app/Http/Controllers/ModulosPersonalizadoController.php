<?php

namespace App\Http\Controllers;

use App\Models\ModuloPersonalizado;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ModulosPersonalizadoController extends Controller
{

    use RegistrarActividad;

    public function index()
    {
        try {
            return view('pages.modulospesonalizados.index');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al renderizar la vista de módulos personalizados', ['exception' => $e]);
            return redirect()->route('dashboard');
        }
    }

    public function create()
    {
        try {
            return view('pages.modulospesonalizados.create');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al renderizar la vista de módulos personalizados', ['exception' => $e]);
            return redirect()->route('dashboard');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'NombreModulo' => ['required', 'string', 'max:255',   Rule::unique('modulos_personalizados')->where(function ($query) {
                return $query->where('Estado', 'Activo');
            }),],
            'id_usuario' => ['required', 'integer']
        ]);

        try {

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
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al crear un módulo personalizado', ['exception' => $e]);
            flash('Hubo un problema al crear la carpeta. Por favor, inténtalo de nuevo.')->error();
            return redirect()->back()->withInput();
        }
    }

    public function edit(int $id)
    {

        try {

            $Modulo = ModuloPersonalizado::findOrFail($id);

            return view('pages.modulospesonalizados.edit', compact('Modulo'));
        } catch (ModelNotFoundException $e) {
            // Manejo de errores cuando el módulo no se encuentra
            Log::error('Módulo personalizado no encontrado', ['id' => $id, 'exception' => $e]);
            flash('El módulo personalizado solicitado no existe.')->error();
            return redirect()->route('custom-module');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al intentar editar el módulo personalizado', ['exception' => $e]);
            flash('Hubo un problema al intentar acceder al módulo personalizado. Por favor, inténtalo de nuevo.')->error();
            return redirect()->route('custom-module');
        }
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

        try {

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
        } catch (ModelNotFoundException $e) {
            // Manejo de errores cuando el módulo no se encuentra
            Log::error('Módulo personalizado no encontrado', ['id_modulo' => $request->id_modulo, 'exception' => $e]);
            flash('El módulo personalizado solicitado no existe.')->error();
            return redirect()->route('custom-module');
        } catch (Exception $e) {
            Log::error('Error al intentar actualizar el módulo personalizado', ['exception' => $e]);
            flash('Hubo un problema al intentar actualizar el módulo personalizado. Por favor, inténtalo de nuevo.')->error();
            return redirect()->route('custom-module');
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'NombreModulo' => ['nullable', 'string', 'max:255'],
        ]);

        $searchTerm = $request->input('NombreModulo', '');

        $Carpetas_encontradas = ModuloPersonalizado::where('Estado', 'Activo')
            ->where('NombreModulo', 'LIKE', "%{$searchTerm}%")
            ->get();

        return view('pages.modulospesonalizados.index', compact('Carpetas_encontradas'));
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
