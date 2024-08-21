<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = ['id_vendedor','id_empresaria', 'factura_identificacion',
    'factura_nombres','direccion_envio','codigo_postal',
    'id_catalogo', 
    'usuario_validacion', 
    'fecha_validacion', 
    'usuario_facturacion', 
    'fecha_facturacion',
    'estado_validacion',
    'estado_facturacion',
    'envio',
    'email',
    'telefono',
    'observaciones','n_factura','n_guia','id_pedidos','cantidad_total',
    'total_venta','total_p_empresaria',
    'n_transferencia',
    'factura_estado_empresaria'];

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_venta');
    }
}
