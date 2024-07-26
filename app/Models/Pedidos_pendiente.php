<?php

namespace App\Models;

use App\Producto;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedidos_pendiente extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_separados', 'id_producto', 'cantidad', 'precio', 'descuento', 'precio_empresaria', 'total', 'direccion_envio', 'estado', 'usuario',
        'promo',
        'tipo',
        'premio',
        'oferta',
        'marca',
        'tipo_premio',
        'tipo_oferta'
    ];


    public function producto()
    {
        return $this->hasOne(Producto::class, 'id', 'id_producto');
    }
}
