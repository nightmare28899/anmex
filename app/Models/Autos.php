<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autos extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula',
        'color',
        'modelo',
        'marca',
        'tarjeta_circulacion',
        'idChofer',
        'fechaActual'
    ];
}
