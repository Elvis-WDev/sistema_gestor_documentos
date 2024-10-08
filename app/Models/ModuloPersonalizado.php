<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloPersonalizado extends Model
{
    use HasFactory;

    protected $table = 'modulos_personalizados';
    protected $primaryKey = 'id_modulo';
    protected $fillable = [
        'NombreModulo',
        'id_usuario',
        'Estado',
    ];

    public function archivos()
    {
        return $this->hasMany(ArchivoModuloPersonalizado::class, 'id_modulo');
    }
    public function user()
    {
        return $this->belongsTo(user::class, 'id_usuario');
    }
}
