<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColumnaPersonalizada extends Model
{
    use HasFactory;

    protected $table = 'columnas_personalizadas';

    protected $fillable = [
        'id_modulo',
        'NombreColumna',
        'TipoDato',
    ];

    public function moduloPersonalizado()
    {
        return $this->belongsTo(ModuloPersonalizado::class, 'id_modulo');
    }
}