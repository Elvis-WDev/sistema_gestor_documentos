<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FilesUploadTrait
{

    public function uploadFile($request, $inputName, $path)
    {
        $fileInfo = [];

        if ($request->hasFile($inputName)) {
            $file = $request->file($inputName);

            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $baseName = pathinfo($originalName, PATHINFO_FILENAME);
            $shortName = substr($baseName, 0, 15);
            $currentDate = date('Ymd');

            $fileName = uniqid() . '_' . $shortName . '_' . $currentDate . '.' . $extension;

            // Guardar el archivo en storage/public/<path>
            $filePath = $file->storeAs($path, $fileName, 'public');

            // Agregar la ruta y la extensión del archivo al array
            $fileInfo[] = $filePath;
            $fileInfo[] = $extension;
        }

        return $fileInfo;
    }

    public function uploadMultiFile($request, $inputName, $path)
    {
        $filePaths = [];

        if ($request->hasFile($inputName)) {
            $files = $request->file($inputName);

            foreach ($files as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $baseName = pathinfo($originalName, PATHINFO_FILENAME);
                $shortName = substr($baseName, 0, 15);
                $currentDate = date('Ymd');

                $fileName = uniqid() . '_' . $shortName . '_' . $currentDate . '.' . $extension;

                // Guardar el archivo en storage/uploads/facturas
                $filePath = $file->storeAs($path, $fileName, 'public');

                // Agregar el nombre del archivo a la lista de rutas
                $filePaths[] = $path . '/' . $fileName;
            }

            return $filePaths;
        }
        return $filePaths;
    }

    public function updateMultiFile($request, $inputName, $path, $old_archivos_txt)
    {
        // Mover archivos antiguos a la carpeta de "trash" si hay nuevos archivos
        if ($request->filled($old_archivos_txt)) {
            $old_archivos = json_decode($request->old_archivos, true);

            foreach ($old_archivos as $old_archivo) {
                $trashPath = 'uploads/trash/pagos/' . basename($old_archivo);
                Storage::disk('public')->move($old_archivo, $trashPath);
            }
        }

        // Subir nuevos archivos y actualizar el campo Archivos
        $archivos = $this->uploadMultiFile($request, $inputName, $path);

        return json_encode($archivos);
    }
}
