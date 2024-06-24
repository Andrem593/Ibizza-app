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
        'id_vendedor',
        'fecha',
        'id_empresaria',
        'motivo',
        'descripcion',
        'f_nombre',
        'f_cedula',
        'f_telefono',
        'f_correo',
        'e_nombre',
        'e_cedula',
        'e_telefono',
        'e_provincia',
        'e_ciudad',
        'e_direccion',
        'obervaciones',
        'e_pedido',
        'envio',
        'id_venta',
        'id_pedido'
    ];


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


}
