<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DireccionVenta extends Model
{
    use HasFactory;

    protected $table = 'direccion_ventas';

    protected $fillable = [
        'nombre',
        'telefono',
        'ciudad_id',
        'direccion',
        'referencia',        
    ];

    public $timestamps = false;

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class);
    }
}
