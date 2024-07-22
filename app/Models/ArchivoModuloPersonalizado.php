<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivoModuloPersonalizado extends Model
{
    use HasFactory;

    protected $table = 'archivos_modulos_personalizados';
    protected $primaryKey = 'id_archivo';
    protected $fillable = [
        'id_modulo',
        'id_usuario',
        'Archivo',
        'Nombre',
        'extension',
    ];

    public function moduloPersonalizado()
    {
        return $this->belongsTo(ModuloPersonalizado::class, 'id_modulo');
    }
    public function User()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
