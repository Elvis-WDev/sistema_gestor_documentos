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

        'Archivo',
        'FechaEmision',
        'Establecimiento',
        'PuntoEmision',
        'Secuencial',
        'RazonSocial',
        'Total',
        'Estado',
        'Abono',
        'RetencionIva',
        'RetencionFuente',
    ];

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_factura', 'id_factura');
    }
}
