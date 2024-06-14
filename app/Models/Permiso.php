<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    protected $table = 'permisos';

    protected $fillable = [
        'id_rol',
        'Permiso_facturas',
        'Permiso_pagos',
        'Permiso_NotasCredito',
        'Permiso_CartasAfiliacion',
        'Permiso_Retenciones',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
