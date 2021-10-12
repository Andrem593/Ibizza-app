<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Validation\Rule;

/**
 * Class Marca
 *
 * @property $id
 * @property $nombre
 * @property $imagen
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Marca extends Model
{
    
    static $rules = [
		'nombre' => 'required|unique:marcas|max:255',
    'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    'estado' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','imagen','estado'];



}
