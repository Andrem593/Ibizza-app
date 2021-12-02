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
    'sku' => 'required',
    'nombre_producto' => 'required',
    'valor_venta' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['sku','imagen_path', 'nombre_producto', 'descripcion', 'marca_id', 'grupo', 'seccion', 'clasificacion', 'proveedor_id', 'estilo', 'color', 'talla', 'cantidad_inicial', 'stock', 'valor_venta', 'ultima_venta', 'estado', 'nombre_mostrar', 'categoria', 'subcategoria', 'descuento', 'precio_empresaria'];






    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    // public function marca()
    // {
    //     return $this->hasOne('App\Marca', 'id', 'marca_id');
    // }
    

}
