<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedidos_pendiente extends Model
{
    use HasFactory;

    protected $fillable = ['id_separados','id_producto','cantidad','precio','total','estado','usuario'];
}
