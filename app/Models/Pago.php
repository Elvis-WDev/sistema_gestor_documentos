<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_factura',
        'Archivos',
        'FechaPago',
        'Total',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'id_factura');
    }
}
