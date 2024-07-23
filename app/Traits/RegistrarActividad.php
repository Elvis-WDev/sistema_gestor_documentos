<?php

namespace App\Traits;

use App\Models\Actividad;

trait RegistrarActividad
{

    public function Actividad(Int $id_usuario, String $Accion, String $Detalles)
    {
        Actividad::create([
            'id_usuario' => $id_usuario,
            'Accion' => $Accion,
            'Detalles' => $Detalles,
        ]);
    }
}
