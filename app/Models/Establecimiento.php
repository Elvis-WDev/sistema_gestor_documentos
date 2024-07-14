<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    use HasFactory;

    protected $table = 'establecimientos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nombre',
    ];

    public function puntosEmision()
    {
        return $this->hasMany(PuntoEmision::class, 'establecimiento_id');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'establecimiento_id');
    }
}
