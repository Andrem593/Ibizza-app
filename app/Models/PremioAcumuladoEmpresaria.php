<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremioAcumuladoEmpresaria extends Model
{
    use HasFactory;

    protected $table = 'premios_acumulados_empresaria';


    protected $fillable = [
        //catalogo_id hace referencia al catalogo antiguo
        'catalogo_id',
        'empresaria_id',
        'condicion_premio_id',
        'venta_id',
        'estado'
    ];

}
