<?php

namespace App\Models;

use App\Producto;
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
        'descuento',
        'precio_producto_venta',
        'descuento_venta',
        'cantidad_producto_venta',
        'precio_u_venta',
        'precio_catalogo_producto_venta'
    ];

    protected $timestamp = false;

    public function product()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id');
    }

    public function changeOrder()
    {
        return $this->belongsTo(ProductoCambio::class, 'id_cambio', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id');
    }

}
