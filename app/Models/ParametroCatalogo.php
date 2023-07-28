<?php

namespace App\Models;

use App\Catalogo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParametroCatalogo extends Model
{
    use HasFactory;

    protected $table = 'parametros_catalogo';

    protected $fillable = ['catalogo_id','tipo_empresaria','condicion', 'operador', 'cantidad', 'valor', 'estado'];

    public $timestamps = false;

    public function catalogo()
    {
        return $this->hasOne(Catalogo::class, 'id', 'catalogo_id');
    }
}
