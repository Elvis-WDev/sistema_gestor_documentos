<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\ArchivoModuloPersonalizado;
use App\Models\ModuloPersonalizado;
use App\Traits\FilesUploadTrait;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ArchivosController extends Controller
{
    use FilesUploadTrait;

    public function index(int $id)
    {
        $Carpeta = ModuloPersonalizado::findOrFail($id);
        return view('pages.modulospesonalizados.archivos.index', compact('Carpeta'));
    }

    public function create(int $id)
    {
        $Carpeta = ModuloPersonalizado::findOrFail($id);
        return view('pages.modulospesonalizados.archivos.create', compact('Carpeta'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'Archivo' => 'file|mimes:' . config('config_general')['archivos']['archivos_permitidos'] . '|max:' . (config('config_general')['archivos']['tamano_maximo_permitido']) * 1024,
            'id_modulo' => 'required|integer',
            'id_usuario' => 'required|integer',
            'Nombre' => ['required', 'string', 'unique:' . ArchivoModuloPersonalizado::class]
        ]);

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

        flash('Archivo subido registrada correctamente!');

        return redirect()->route('carpeta', $request->id_modulo);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id_archivo' => 'required|integer',
            ]);

            $archivo = ArchivoModuloPersonalizado::findOrFail($request->id_archivo);

            $archivo->Estado = 2;

            $archivo->save();

            flash('Eliminado correctamente!');

            return response()->json(['status' => 'success', 'message' => 'Eliminado correctamente.']);
        } catch (QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Error al eliminar archivo.']);
        }
    }
}
