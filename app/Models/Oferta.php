<?php

namespace App\Models;

use App\Catalogo;
use App\Models\Marca;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Oferta extends Model
{
    use HasFactory;

    protected $table = 'ofertas';

    protected $fillable = [
        'oferta',
        'catalogo_id',
        'marca_id',
        'tipo_oferta',
        'productos',
        'desde',
        'valor',
        'tipo_premio',
        'premios',
        'estado',
        'clasificacion'
    ];

    public $with = ['catalogo', 'marca'];

    public function catalogo()
    {
        return $this->belongsTo(Catalogo::class, 'catalogo_id');
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }    
}
