<?php

namespace App\Models;

use App\Empresaria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambioPedido extends Model
{
    use HasFactory;

    protected $table = 'cambios_pedidos';

    protected $fillable = [
        'n_factura',
        'n_factura_carga',
        'id_vendedor',
        'id_usuario',
        'fecha',
        'id_empresaria',
        'motivo',
        'descripcion',

        'f_nombre',
        'f_cedula',
        'f_tipo_id',
        'f_telefono',
        'f_correo',

        'e_nombre',
        'e_cedula',
        'e_telefono',
        'e_provincia',
        'e_ciudad',
        'e_direccion',
        'e_tipo_id',
        'e_pedido',
        'provincia_id',
        'ciudad_id',

        'referencia',

        'envio',
        'id_venta',
        'id_pedido',
        'precio_producto_venta',
        'descuento_venta',
        'cantidad_producto_venta',
        'total',
        'total_pagar',
        'estado'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function businesswomen()
    {
        return $this->belongsTo(Empresaria::class, 'id_empresaria');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    public function requestedChanges()
    {
        return $this->hasMany(ProductoCambio::class, 'id_cambio');

    }

    public function province()
    {
        return $this->belongsTo(Provincia::class, 'provincia_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id', 'id');
    }


}
