<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Separado extends Model
{
    use HasFactory;

    protected $fillable = ['id_usuario','cantidad_total','total_venta','total_p_empresaria'];
}
