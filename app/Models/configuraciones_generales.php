<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class configuraciones_generales extends Model
{
    use HasFactory;

    protected $table = 'config_generales';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
        'archivos_permitidos',
        'cantidad_permitidos',
        'tamano_maximo_permitido',
    ];
}