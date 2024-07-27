<?php

namespace App\Traits;

use App\Models\Papelera;

trait MovePapelera
{

    public function MoveToPapelera($Archivos, $Detalle)
    {
        Papelera::create([
            'Archivos' => $Archivos,
            'Detalle' => $Detalle,
        ]);
    }
}
