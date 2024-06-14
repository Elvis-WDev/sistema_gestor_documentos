<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudAfiliados extends Model
{
    use HasFactory;

    protected $table = 'solicitud_afiliados';
    protected $primaryKey = 'id_solicitudAfiliados';

    protected $fillable = [
        'Archivo',
        'Prefijo',
        'NombreCliente',
    ];
}
