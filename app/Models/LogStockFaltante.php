<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogStockFaltante extends Model
{
    use HasFactory;

    protected $fillable = ['estilo','color','talla','stock_requerido'];
}
