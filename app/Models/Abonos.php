<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abonos extends Model
{
    use HasFactory;


    protected $table = 'abonos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'factura_id',
        'valor_abono',
        'total_factura',
        'saldo_factura',
        'fecha_abonado',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
