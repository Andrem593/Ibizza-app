<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Producto;
use Cart;

class TomarPedido extends Component
{
    public $estilo, $colores,$tallas,$message, $color, $talla,$cantidad;
    public $imagen = 'https://www.bicifan.uy/wp-content/uploads/2016/09/producto-sin-imagen.png';
    protected $listeners = ['change' => 'buscarColor'];

    public function render()
    {
        return view('livewire.tomar-pedido');
    }
    public function buscarEstilo()
    {
        
        try {            
            $estilo = $this->estilo;
            $colores = Producto::where('estilo', $estilo)->groupBy('color')->get();
            $tallas = Producto::where('estilo', $estilo)
            ->join('marcas','marcas.id','=', 'productos.marca_id')
            ->select('productos.*','marcas.nombre AS nombre_marca')
            ->where('color', $colores[0]->color)->get();        
            $this->colores = $colores;
            $this->tallas = $tallas;
            $this->color = $colores[0]->color;
            $this->talla = $tallas[0]->talla;
            $this->imagen = './storage/images/productos/'.$colores[0]->imagen_path;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->message= 'CODIGO INGRESADO NO ES CORRECTO'; 
            $this->reset(['colores','tallas','imagen']); 
        }
    }
    public function buscarColor()
    {        
        try {        
            $estilo = $this->estilo;
            $tallas = Producto::where('estilo', $estilo)
            ->join('marcas','marcas.id','=', 'productos.marca_id')
            ->select('productos.*','marcas.nombre AS nombre_marca')
            ->where('color', $this->color)->get();        
            $this->tallas = $tallas;
            $this->talla = $tallas[0]->talla;
            $this->imagen = './storage/images/productos/'.$tallas[0]->imagen_path;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->message= 'CODIGO INGRESADO NO ES CORRECTO'; 
            $this->reset(['colores','tallas','imagen']); 
        }
    }
    public function addCart()
    {   
        if ($this->cantidad > 0) {            
            $producto = Producto::where('estilo', $this->estilo)->where('color',$this->color)->where('talla', $this->talla)->first();
            $precio = $producto->precio_empresaria;
            if (!empty($producto->descuento)) {
                $precio = number_format(($producto->precio_empresaria-($producto->precio_empresaria * ($producto->descuento /100))), 2);
            }
            Cart::add($producto->id, $producto->nombre_mostrar, $this->cantidad, number_format($precio, 2), ['image' => $producto->imagen_path])->associate('App\Models\Producto');
            $this->reset(['colores','tallas','imagen','color','talla','cantidad']); 
        }else{
            $this->message= 'INGRESE LA CANTIDAD QUE DESEA'; 
        }
    }
    public function eliminarItem($id)
    {
        Cart::remove($id);
    }
}
