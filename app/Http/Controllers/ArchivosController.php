<?php

namespace App\Http\Controllers;

use App\Models\ArchivoModuloPersonalizado;
use App\Models\ModuloPersonalizado;
use App\Traits\FilesUploadTrait;
use App\Traits\RegistrarActividad;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use InvalidArgumentException;

class ArchivosController extends Controller
{
    use FilesUploadTrait, RegistrarActividad;

    public function index(int $id)
    {
        try {

            if (!is_numeric($id) || $id <= 0) {
                throw new InvalidArgumentException('ID de factura inválido.');
            }

            $Carpeta = ModuloPersonalizado::findOrFail($id);
            return view('pages.modulospesonalizados.archivos.index', compact('Carpeta'));
        } catch (ModelNotFoundException $e) {
            // Manejo del error cuando el módulo personalizado no se encuentra
            flash()->error('El módulo personalizado no fue encontrado.');
            return redirect()->route('modulos.personalizados.index');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al acceder al módulo personalizado', ['exception' => $e]);
            flash()->error('Hubo un problema al acceder al módulo personalizado. Por favor, inténtalo de nuevo.');
            return redirect()->route('modulos.personalizados.index');
        }
    }

    public function create(int $id)
    {
        try {

            if (!is_numeric($id) || $id <= 0) {
                throw new InvalidArgumentException('ID de factura inválido.');
            }

            $Carpeta = ModuloPersonalizado::findOrFail($id);
            return view('pages.modulospesonalizados.archivos.create', compact('Carpeta'));
        } catch (ModelNotFoundException $e) {
            // Manejo del error cuando el módulo personalizado no se encuentra
            flash()->error('El módulo personalizado no fue encontrado.');
            return redirect()->route('modulos.personalizados.index');
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al acceder al módulo personalizado para crear archivo', ['exception' => $e]);
            flash()->error('Hubo un problema al acceder al módulo personalizado. Por favor, inténtalo de nuevo.');
            return redirect()->route('modulos.personalizados.index');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'Archivo' => 'required|file|mimes:' . config('config_general')['archivos']['archivos_permitidos'] . '|max:' . (config('config_general')['archivos']['tamano_maximo_permitido']) * 1024,
            'id_modulo' => 'required|integer',
            'id_usuario' => 'required|integer',
            'Nombre' => ['required', 'string',  Rule::unique('archivos_modulos_personalizados')->where(function ($query) {
                return $query->where('Estado', 'Activo');
            })]
        ]);

        try {

            // Procesamiento de archivos utilizando uploadMultiFile
            $filePath = $this->uploadFile($request, 'Archivo', 'uploads/archivos');

            ArchivoModuloPersonalizado::create([
                'id_modulo' => $request->id_modulo,
                'id_usuario' => $request->id_usuario,
                'Nombre' => $request->Nombre,
                'Archivo' => $filePath[0],
                'extension' =>  $filePath[1],
                'Estado' => 1,
            ]);

            $this->Actividad(
                Auth::user()->id,
                "Ha creado un archivo",
                $request->Nombre
            );

            flash('Archivo subido registrada correctamente!');

            return redirect()->route('carpeta', $request->id_modulo);
        } catch (Exception $e) {
            Log::error('Error al procesar la solicitud', ['exception' => $e]);
            return redirect()->back()->withErrors(['error' => 'Hubo un problema al procesar tu solicitud. Por favor, inténtalo de nuevo.']);
        }
    }

    public function update(Request $request)
    {

        $request->validate([
            'id_archivo' => 'required|integer',
        ]);
        try {

            $archivo = ArchivoModuloPersonalizado::findOrFail($request->id_archivo);

            $archivo->Estado = 2;

            $archivo->save();

            $this->Actividad(
                Auth::user()->id,
                "Ha eliminado un archivo",
                $archivo->Nombre
            );

            flash('Eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Eliminado correctamente.']);
        } catch (QueryException $e) {

            Log::error('Error al eliminar archivo', ['exception' => $e]);
            return response()->json(['status' => 'error', 'message' => 'Error al eliminar archivo.'], 500);
        } catch (Exception $e) {

            Log::error('Error inesperado', ['exception' => $e]);
            return response()->json(['status' => 'error', 'message' => 'Ocurrió un problema al procesar tu solicitud. Por favor, inténtalo de nuevo.'], 500);
        }
    }
}
