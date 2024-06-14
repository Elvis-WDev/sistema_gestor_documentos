<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloPersonalizado extends Model
{
    use HasFactory;

    protected $table = 'modulos_personalizados';

    protected $fillable = [
        'NombreModulo',
    ];

    public function columnasPersonalizadas()
    {
        return $this->hasMany(ColumnaPersonalizada::class, 'id_modulo');
    }

    public function archivos()
    {
        return $this->hasMany(ArchivoModuloPersonalizado::class, 'id_modulo');
    }
}