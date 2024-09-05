<?php

namespace App\Http\Controllers;

use App\DataTables\ConfiguracionesGeneralesDatatables;
use App\Models\configuraciones_generales;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ConfiguracionesGeneralesController extends Controller
{
    use RegistrarActividad;
    /**
     * Display a listing of the FileType.
     *
     * @param ConfiguracionesGeneralesDatatables $ConfiguracionesGeneralesDatatables
     * @return Response
     */
    public function index(ConfiguracionesGeneralesDatatables $ConfiguracionesGeneralesDatatables)
    {
        try {
            return $ConfiguracionesGeneralesDatatables->render('pages.config_general.index');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al cargar la DataTable de configuraciones generales', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar las configuraciones generales. Por favor, inténtalo de nuevo.');
            return redirect()->route('configuraciones.generales.index');
        }
    }
    public function create()
    {
        try {
            return view('pages.config_general.edit');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al cargar la vista de configuración general', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar la página de configuración. Por favor, inténtalo de nuevo.');
            return redirect()->route('configuraciones.index');
        }
    }

    public function edit(int $id)
    {

        try {
            if (!is_numeric($id) || $id <= 0) {
                Alert::error('ID de configuración inválido.');
                return redirect()->route('configuraciones.index');
            }

            $Config_generales = configuraciones_generales::findOrFail($id);

            return view('pages.config_general.edit', compact('Config_generales'));
        } catch (ModelNotFoundException $e) {
            // Manejar el caso en que no se encuentra el modelo
            Alert::error('Configuración general no encontrada.');
            return redirect()->route('configuraciones.index');
        } catch (Exception $e) {
            // Manejar cualquier otro tipo de excepción
            Log::error('Error al cargar la configuración general para edición', ['exception' => $e]);
            Alert::error('Hubo un problema al cargar la configuración general. Por favor, inténtalo de nuevo.');
            return redirect()->route('configuraciones.index');
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'id' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'archivos_permitidos.*' => 'required',
            'cantidad_permitidos' => 'required|integer',
            'tamano_maximo_permitido' => 'required|integer',
        ]);

        try {

            if (!$request->archivos_permitidos) {
                Alert::error('Campos incompletos!');
                return redirect()->route('configuraciones');
            }

            // Formateo de arreglo a campo que acepta VFalidation doc,pdf,etc
            $mimesPermitidos = '';

            foreach ($request->archivos_permitidos as $key => $value) {
                $mimesPermitidos .= $value . ',';
            }

            $mimesPermitidos = substr($mimesPermitidos, 0, -1);

            $configuracion = configuraciones_generales::findOrFail($request->id);

            $configuracion->nombre = $request->nombre;
            $configuracion->archivos_permitidos = $mimesPermitidos;
            if ($request->id != 2) {
                $configuracion->cantidad_permitidos = $request->cantidad_permitidos;
            }
            $configuracion->tamano_maximo_permitido = $request->tamano_maximo_permitido;

            $configuracion->save();

            $this->Actividad(
                Auth::user()->id,
                "Ha modificado la configuración",
                "Archivos permitidos: " . $mimesPermitidos . " Tamaño: " . $request->tamano_maximo_permitido
            );

            toast('Configuracion general actualizada correctamente!', 'success');

            return redirect()->route('configuraciones');
        } catch (ModelNotFoundException $e) {
            // Manejar caso cuando no se encuentra la configuración
            Log::error('Configuración no encontrada', ['exception' => $e]);
            Alert::error('La configuración solicitada no fue encontrada.');
            return redirect()->route('configuraciones');
        } catch (\Exception $e) {
            // Manejar cualquier otro error
            Log::error('Error al actualizar configuración', ['exception' => $e]);
            Alert::error('Ocurrió un problema al actualizar la configuración. Por favor, inténtalo de nuevo.');
            return redirect()->route('configuraciones');
        }
    }
}
