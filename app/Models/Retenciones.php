<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retenciones extends Model
{
    use HasFactory;

    protected $table = 'retenciones';

    protected $fillable = [
        'Archivo',
        'FechaEmision',
        'Establecimiento',
        'PuntoEmision',
        'Secuencial',
        'RazonSocial',
        'Total',
    ];
}
