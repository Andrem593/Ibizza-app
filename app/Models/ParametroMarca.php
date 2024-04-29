<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametroMarca extends Model
{
    protected $table = 'parametros_marca';

    protected $fillable = ['nombre','tipo_empresaria', 'marcas','condicion', 'operador','cantidad', 'descuento','estado' ];

    public $timestamps = false;
}
