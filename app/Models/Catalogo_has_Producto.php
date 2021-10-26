<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo_has_Producto extends Model
{
    use HasFactory;

    protected $table = 'catalogo_has_productos';

    protected $fillable = ['catalogo_id','producto_id','estilo'];
}
