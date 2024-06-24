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
        'id_vendedor',
        'id_usuario',
        'fecha',
        'id_empresaria',
        'motivo',
        'descripcion',
        'f_nombre',
        'f_cedula',
        'e_telefono',
        'e_provincia',
        'e_ciudad',
        'e_direccion',
        'obervaciones',
        'envio',
        'id_venta',
        'id_pedido',
    ];

    protected $timestamp = false;


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function businesswoman()
    {
        return $this->hasOne(Empresaria::class, 'id', 'id_empresaria');
    }
}
