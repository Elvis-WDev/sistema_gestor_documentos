<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'Rol',
    ];

    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }

    public function permisos()
    {
        return $this->hasMany(Permiso::class, 'id_rol');
    }
}
