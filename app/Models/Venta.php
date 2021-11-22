<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['id_vendedor','id_empresaria','factura_identificacion','factura_nombres','direccion_envio','codigo_postal','observaciones','id_pedidos','cantidad_total','total_venta','total_p_empresaria','estado'];
}
