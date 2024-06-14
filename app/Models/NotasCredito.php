<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotasCredito extends Model
{
    use HasFactory;

    protected $table = 'notas_credito';
    protected $primaryKey = 'id';

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
