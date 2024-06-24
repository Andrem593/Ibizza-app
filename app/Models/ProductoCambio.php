<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoCambio extends Model
{
    use HasFactory;

    protected $table = 'productos_cambio';


    protected $fillable = [

        'id_cambio',
        'id_producto',
        'cantidad',
        'diferencia',
        'fecha',
        'hora',
        'id_pedido',
        'precio',
        'precio_catalogo',
        'total',
        'descuento'
    ];

    protected $timestamp = false;
}
