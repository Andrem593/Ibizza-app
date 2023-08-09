<?php

namespace App;

use App\Models\ParametroCatalogo;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Catalogo
 *
 * @property $id
 * @property $nombre
 * @property $descripcion
 * @property $foto_path
 * @property $pdf_path
 * @property $fecha_publicacion
 * @property $fecha_fin_catalogo
 * @property $estado
 * @property $premio_id
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Catalogo extends Model
{
    
    static $rules = [
		'nombre' => 'required',
    'descripcion' => 'required',
    'pdf_path' => 'mimes:pdf|max:100000'
    ];

    protected $attributes = [
      'estado' => 'SIN PUBLICAR',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','descripcion','foto_path','pdf_path','fecha_publicacion','fecha_fin_catalogo','estado','premio_id'];


    public function parametros()
    {
        return $this->hasMany(ParametroCatalogo::class, 'catalogo_id', 'id');
    }



}
