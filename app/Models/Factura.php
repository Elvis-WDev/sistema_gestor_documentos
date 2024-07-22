<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $table = 'facturas';
    protected $primaryKey = 'id_factura';

    protected $fillable = [

        'Archivos',
        'FechaEmision',
        'establecimiento_id',
        'punto_emision_id',
        'RetencionIva',
        'RetencionFuente',
        'Secuencial',
        'Prefijo',
        'RazonSocial',
        'Abono',
        'Total',
        'Estado',
    ];

    public function establecimiento()
    {
        return $this->belongsTo(Establecimiento::class);
    }

    public function puntoEmision()
    {
        return $this->belongsTo(PuntoEmision::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_factura', 'id_factura');
    }
    public function abonos()
    {
        return $this->hasMany(Abonos::class, 'factura_id', 'id_factura');
    }
}
