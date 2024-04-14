<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo_has_Premio extends Model
{
    use HasFactory;

    protected $table = 'parametros_catalogo';

    protected $fillable = ['catalogo_id','tipo_empresaria','condicion', 'operador', 'cantidad', 'valor'];

    protected $timestamp = false;
}
