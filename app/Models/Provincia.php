<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provincia extends Model
{
    use HasFactory;

    protected $table = 'provincias';

    protected $fillable = [
        'descripcion',
        'estado'        
    ];

    public $timestamps = false;
}
