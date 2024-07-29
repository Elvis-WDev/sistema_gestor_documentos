<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{

    public function download($path)
    {
        if (!Auth::check()) {
            abort(403, 'Acceso no autorizado');
        }

        if (preg_match('/\.\.\//', $path)) {
            abort(400, 'Ruta inválida.');
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        try {

            $file = Storage::disk('public')->path($path);
            return response()->file($file);
        } catch (Exception $e) {
            // Manejo de errores generales
            Log::error('Error al descargar el archivo', ['path' => $path, 'exception' => $e]);

            return response()->json([
                'error' => 'Hubo un problema al intentar descargar el archivo.'
            ], 500);
        }
    }
}
