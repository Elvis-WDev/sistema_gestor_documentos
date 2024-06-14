<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoModuloPersonalizado extends Model
{
    use HasFactory;

    protected $table = 'archivos_modulos_personalizados';

    protected $fillable = [
        'id_modulo',
        'Archivo',
        'Fecha',
        'TipoArchivo',
    ];

    public function moduloPersonalizado()
    {
        return $this->belongsTo(ModuloPersonalizado::class, 'id_modulo');
    }
}