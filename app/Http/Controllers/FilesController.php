<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{

    public function download($path)
    {
        if (!Auth::check()) {
            abort(403, 'Acceso no autorizado');
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('public')->path($path);
        return response()->file($file);
    }
}
