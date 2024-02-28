<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $table = 'precios'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'idListaPrecio',
        'idProducto',
        'Precio',
        'fecha',
    ];
}
