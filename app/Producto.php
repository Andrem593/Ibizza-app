<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $categoria_id
 * @property $marca_id
 * @property $descripcion
 * @property $linea
 * @property $color
 * @property $nombre_color
 * @property $precio
 * @property $descuento
 * @property $sku
 * @property $cantidad
 * @property $stock_inicial
 * @property $coleccion
 * @property $fecha_entrega
 * @property $status_fabrica
 * @property $vigencia
 * @property $observacion
 * @property $pvp
 * @property $imagen
 * @property $status_imagen
 * @property $precio_mayorista
 * @property $modelo
 * @property $numero_pedido
 * @property $proveedor_id
 * @property $clasificacion
 * @property $created_at
 * @property $updated_at
 *
 * @property Marca $marca
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{
    
    static $rules = [
		'categoria_id' => 'required',
		'marca_id' => 'required',
		'descripcion' => 'required',
		'linea' => 'required',
		'color' => 'required',
		'nombre_color' => 'required',
		'precio' => 'required',
		'descuento' => 'required',
		'sku' => 'required',
		'cantidad' => 'required',
		'stock_inicial' => 'required',
		'coleccion' => 'required',
		'fecha_entrega' => 'required',
		'status_fabrica' => 'required',
		'vigencia' => 'required',
		'observacion' => 'required',
		'pvp' => 'required',
		'imagen' => 'required',
		'status_imagen' => 'required',
		'precio_mayorista' => 'required',
		'modelo' => 'required',
		'numero_pedido' => 'required',
		'proveedor_id' => 'required',
		'clasificacion' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['categoria_id','marca_id','descripcion','linea','color','nombre_color','precio','descuento','sku','cantidad','stock_inicial','coleccion','fecha_entrega','status_fabrica','vigencia','observacion','pvp','imagen','status_imagen','precio_mayorista','modelo','numero_pedido','proveedor_id','clasificacion'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function marca()
    {
        return $this->hasOne('App\Marca', 'id', 'marca_id');
    }
    

}
