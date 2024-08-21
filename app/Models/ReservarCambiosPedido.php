<?php

namespace App\Models;

use App\Empresaria;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservarCambiosPedido extends Model
{
    use HasFactory;

    protected $table = 'reservar_cambios_pedidos';



    protected $fillable = [
        'n_factura',
        'id_vendedor',
        'id_usuario',
        'fecha',
        'fecha_vencimiento',
        'id_empresaria',
        'motivo',
        'descripcion',

        'f_nombre',
        'f_cedula',
        'f_tipo_id',
        'f_telefono',
        'f_correo',

        'e_telefono',
        'e_provincia',
        'e_ciudad',
        'e_direccion',
        'e_tipo_id',
        'e_pedido',
        'e_cedula',
        'e_nombre',
        'provincia_id',
        'ciudad_id',

        'e_referencia',
        'envio',
        'id_venta',
        'id_pedido',
        'precio_producto_venta',
        'descuento_venta',
        'cantidad_producto_venta',
        'total',
        'total_pagar',

        // Activo: 1. Inactivo: 0 , Procesado 3
        'estado'
    ];

    protected $timestamp = false;

    protected $appends = ['estado_descripcion'];


    public function getEstadoDescripcionAttribute()
    {
        $status = [
            [
                'tipo' => 1,
                'descripcion' => 'ACTIVO',
            ],
            [
                'tipo' => 0,
                'descripcion' => 'INACTIVO',
            ],
            [
                'tipo' => 2,
                'descripcion' => 'PROCESADO',
            ],
            [
                'tipo' => 3,
                'descripcion' => 'ACTIVO',
            ],
            [
                'tipo' => 4,
                'descripcion' => 'DEVUELTO',
            ],
        ];
        $status = collect($status) ;

        $status = $status->where('tipo', $this->estado)->first() ;
        return $status ? $status['descripcion'] : '';
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function businesswoman()
    {
        return $this->hasOne(Empresaria::class, 'id', 'id_empresaria');
    }

    public function reservedChangeDetail()
    {
        return $this->hasMany(ReservarCambiosDetalle::class, 'id_reservar_cambio_pedido', 'id');
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
