<?php

namespace App;

use App\Models\User;
use App\Models\Venta;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\Rule;

/**
 * Class Empresaria
 *
 * @property $id
 * @property $cedula
 * @property $nombres
 * @property $apellidos
 * @property $fecha_nacimiento
 * @property $direccion
 * @property $campaña_anterior
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

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo_id','cedula','nombres','apellidos','fecha_nacimiento','direccion','referencia','direccion_envio','referencia_envio','tipo_cliente','email','password','estado','telefono','id_ciudad','vendedor','id_user','observacion', 'campaña_anterior', 'tipo_usuario'];


    protected $appends  = ['nombre_completo'];

    public function pedidos()
    {
        return $this->hasMany(Venta::class, 'id_empresaria', 'id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public static function getRules()
    {
        $today = Carbon::today();
        $minAgeDate = $today->subYears(18)->format('Y-m-d');

        return [
            'nombres' => 'required',
            'fecha_nacimiento' => [
                'required',
                'date',
                'before_or_equal:' . $minAgeDate,                
            ],
            'apellidos' => 'required',
            'id_ciudad' => 'required',
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email' => ['required','email', 'string', 'max:255'],
            //'password' => ['required', 'string', 'min:8']
        ];
    }
    
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }

}
