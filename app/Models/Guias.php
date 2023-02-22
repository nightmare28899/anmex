<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guias extends Model
{
    use HasFactory;

    protected $table = 'guias';

    protected $fillable = [
        'id',
        'id_cliente',
        'id_externo',
        'id_domicilio',
        'estatus_entrega',
        'fecha_entrega',
        'guia_prepago',
        'status',
    ];
}
