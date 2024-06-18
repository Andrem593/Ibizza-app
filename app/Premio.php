<?php

namespace App;

use App\Models\CondicionPremio;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Premio
 *
 * @property $id
 * @property $condicion
 * @property $descripcion
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Premio extends Model
{

    static $rules = [
		'descripcion' => 'required',
    'catalogo_id' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['condicion','descripcion','catalogo_id', 'monto_minimo_acumulado'];


    public function catalogue()
    {
        return $this->belongsTo(Catalogo::class, 'catalogo_id');
    }

    public function prizeCondition()
    {
        return $this->hasMany(CondicionPremio::class, 'premio_id', 'id');
    }



}
