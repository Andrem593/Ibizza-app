<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo_has_Premio extends Model
{
    use HasFactory;

    protected $table = 'catalogo_has_premios';

    protected $fillable = ['catalogo_id','premio_id'];
}
