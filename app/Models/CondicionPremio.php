<?php

namespace App\Models;

use App\Catalogo;
use App\Premio;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CondicionPremio extends Model
{
    use HasFactory;

    protected $table = 'condicion_premios';

    protected $fillable = ['premio_id','tipo_empresaria','nivel','rango_desde','rango_hasta','acumular'];

    public function prize()
    {
        return $this->belongsTo(Premio::class, 'premio_id');
    }

}
