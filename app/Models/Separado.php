<?php

namespace App\Models;

use App\Empresaria;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Separado extends Model
{
    use HasFactory;

    protected $fillable = ['id_usuario','id_empresaria','nombre_cliente','cantidad_total','total_venta','total_p_empresaria', 'created_at', 'updated_at'];

    public function usuario()
    {
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }

    public function empresaria()
    {
        return $this->hasOne(Empresaria::class, 'id', 'id_empresaria');
    }
}
