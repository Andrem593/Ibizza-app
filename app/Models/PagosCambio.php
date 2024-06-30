<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagosCambio extends Model
{
    use HasFactory;

    protected $table = 'pagos_cambios';

    protected $fillable = [
        'id_cambio',
        'id_usuario',
        'valor_pagar',
        'valor_recaudado',
        'valor_pendiente',
        'fecha_pago',
        'comprobante',
        'tipo_pago',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function getTipoPagoAttribute($value)
    {
        switch ($value) {
            case "SF":
                return "SALDO A FAVOR";
                break;
            case "CP":
                return "CAMBIO SE VA CON PEDIDO";
                break;
            case "TR":
                return "TRANSFERENCIA";
                break;
            case "TC":
                return "TARJETA DE CRÉDITO";
                break;
            case "LI":
                return "PAGO LOCAL IBIZZA";
                break;
            case "CL":
                return "CAMBIO LOCAL IBIZZA";
                break;
        }

    }
}
