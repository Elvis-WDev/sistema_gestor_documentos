<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'user_id',
        'Accion',
        'Detalles',
        'FechaHora',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
