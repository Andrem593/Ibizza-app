<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['id_vendedor','id_catalogo','id_empresaria','factura_identificacion','factura_nombres','direccion_envio','codigo_postal'
    ,'envio','email','telefono'
    ,'observaciones','n_factura','n_guia','id_pedidos','cantidad_total','total_venta','total_p_empresaria','estado'];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_venta');
    }
}
