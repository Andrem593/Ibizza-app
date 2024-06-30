<?php

namespace App\Models;

use App\Producto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservarCambiosDetalle extends Model
{
    use HasFactory;

    protected $table = 'reservar_cambios_detalles';

    protected $fillable = [
        'id_reservar_cambio_pedido',
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
        'cantidad_producto_venta'
    ];

    protected $timestamp = false;


    public function product()
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id');
    }

    public function reserveChangesOrder()
    {
        return $this->belongsTo(ReservarCambiosPedido::class, 'id_reservar_cambio_pedido', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id');
    }


}
