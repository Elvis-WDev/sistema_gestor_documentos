<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Papelera extends Model
{
    use HasFactory;

    protected $table = 'papelera';
    protected $primaryKey = 'id';

    protected $fillable = [
        'Archivos',
        'Detalle',
    ];
}
