<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
		'cedula' => 'required',
		'nombres' => 'required',
		'apellidos' => 'required',
		'estado' => 'required',
		'id_ciudad' => 'required',
		'vendedor' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['cedula','nombres','apellidos','fecha_nacimiento','direccion','tipo_cliente','estado','telefono','id_ciudad','vendedor'];



}
