<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premio_has_Producto extends Model
{
    use HasFactory;

    protected $table = 'premio_has_productos';

    protected $fillable = ['premio_id','producto_id','estilo'];
}
