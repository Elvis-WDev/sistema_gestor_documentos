<?php

namespace App\Traits;

use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{


    public function uploadImage(Request $request, $inputName, $path)
    {
        if ($request->hasFile($inputName)) {

            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;

            $image->move(public_path($path), $imageName);

            return $path . '/' . $imageName;
        }
    }


    public function uploadMultiImage(Request $request, $inputName, $path)
    {
        $imagePaths = [];

        if ($request->hasFile($inputName)) {

            $images = $request->{$inputName};

            foreach ($images as $image) {

                $ext = $image->getClientOriginalExtension();
                $imageName = 'media_' . uniqid() . '.' . $ext;

                $image->move(public_path($path), $imageName);

                $imagePaths[] =  $path . '/' . $imageName;
            }

            return $imagePaths;
        }
    }


    public function updateImage(Request $request, $inputName, $path, $oldPath = null)
    {
        if ($request->hasFile($inputName)) {
            // Eliminar la imagen antigua si existe
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Obtener el archivo de la solicitud
            $image = $request->file($inputName);
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_' . uniqid() . '.' . $ext;

            // Almacenar la imagen en storage/app/public/$path
            $storedPath = $image->storeAs($path, $imageName, 'public');

            // Devolver la ruta donde se almacena la imagen
            return $storedPath;
        }
    }
    // public function updateImage(Request $request, $inputName, $path, $oldPath = null)
    // {
    //     if ($request->hasFile($inputName)) {
    //         if (File::exists(public_path($oldPath))) {
    //             File::delete(public_path($oldPath));
    //         }

    //         $image = $request->{$inputName};
    //         $ext = $image->getClientOriginalExtension();
    //         $imageName = 'media_' . uniqid() . '.' . $ext;

    //         $image->move(public_path($path), $imageName);

    //         return $path . '/' . $imageName;
    //     }
    // }

    /** Handle Delte File */
    public function deleteImage(string $path)
    {
        if (File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
