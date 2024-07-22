<?php

namespace App\Traits;


trait FilesUploadTrait
{

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
}
