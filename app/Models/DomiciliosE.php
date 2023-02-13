<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomiciliosE extends Model
{
    use HasFactory;

    protected $table = 'domicilio_entregar';

    protected $fillable = [
        'id',
        'domicilio',
        'cp',
        'telefono',
        'observaciones',
        'cliente_id',
        'fechaActual',
    ];
}
