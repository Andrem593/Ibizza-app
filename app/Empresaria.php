<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

/**
 * Class Empresaria
 *
 * @property $id
 * @property $cedula
 * @property $nombres
 * @property $apellidos
 * @property $fecha_nacimiento
 * @property $direccion
 * @property $tipo_cliente
 * @property $estado
 * @property $telefono
 * @property $id_ciudad
 * @property $vendedor
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Empresaria extends Model
{
    
    static $rules = [
		'cedula' => ['required', 'max:13','unique:empresarias'],
		'nombres' => 'required',
    'apellidos' => 'required',
    'tipo_cliente' => 'required',
    'id_ciudad' => 'required',
    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    'password' => ['required', 'string', 'min:8']
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['cedula','nombres','apellidos','fecha_nacimiento','direccion','referencia','direccion_envio','referencia_envio','tipo_cliente','email','password','estado','telefono','id_ciudad','vendedor','id_user'];



}
