<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoEmision extends Model
{
    use HasFactory;

    protected $table = 'puntos_emision'; // Añadir esto para consistencia con la convención de nombres
    protected $primaryKey = 'id'; // Añadir esto si la clave primaria es diferente de 'id'

    protected $fillable = [
        'establecimiento_id',
        'nombre',
    ];

    public function establecimiento()
    {
        return $this->belongsTo(Establecimiento::class, 'establecimiento_id');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'punto_emision_id');
    }
}
