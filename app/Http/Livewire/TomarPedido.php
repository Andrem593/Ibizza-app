<?php

namespace App\Http\Livewire;

use App\Models\Pedidos_pendiente;
use App\Models\Separado;
use Livewire\Component;
use App\Producto;
use Cart;
use Illuminate\Support\Facades\Auth;

class TomarPedido extends Component
{
    public $estilo, $colores,$tallas,$message, $color, $talla,$cantidad, $alert;
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
            $this->imagen = '../storage/images/productos/'.$colores[0]->imagen_path;
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
            $this->imagen = '../storage/images/productos/'.$tallas[0]->imagen_path;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->message= 'CODIGO INGRESADO NO ES CORRECTO'; 
            $this->reset(['colores','tallas','imagen']); 
        }
    }
    public function addCart()
    {   
        $this->message = '';
        if ($this->cantidad > 0 && !empty($this->estilo) && !empty($this->color) && !empty($this->talla) ) {            
            $producto = Producto::where('estilo', $this->estilo)->where('color',$this->color)->where('talla', $this->talla)->first();
            if($producto->stock >= $this->cantidad){
                $precio = $producto->precio_empresaria;
                if (!empty($producto->descuento)) {
                    $precio = number_format(($producto->precio_empresaria-($producto->precio_empresaria * ($producto->descuento /100))), 2);
                }
                Cart::add($producto->id, $producto->nombre_mostrar, $this->cantidad, number_format($precio, 2), ['image' => $producto->imagen_path , 'color'  => $producto->color , 'talla' => $producto->talla ])->associate('App\Models\Producto');
                $this->reset(['colores','tallas','imagen','color','talla','cantidad']);
            }else{
                $this->message= 'NO HAY STOCK DISPONIBLE'; 
            }             
        }else{
            $this->message= 'VERIFIQUE QUE ESTEN TODOS LOS CAMPOS LLENOS'; 
        }
    }
    public function eliminarItem($id)
    {
        Cart::remove($id);
    }
    public function GuardarPedidos()
    {
        if (Cart::count() > 0) {
            try {
                $flag = 0;
                $text = '';
                foreach (Cart::content() as $item) {
                    $pro = Producto::where('id', $item->id)->first();
                    $nuevo_stock = $pro->stock - $item->qty;
                    if($nuevo_stock < 0){
                        $flag = 1;
                        $text .= $item->name.' >> '. $pro->stock . ' en stock, ';
                    }
                }

                if(!$flag){
                    $separado = Separado::create([
                        'id_usuario'=>Auth::user()->id,
                        'cantidad_total'=>Cart::count(),
                        'total_venta'=>Cart::total(),
                        'total_p_empresaria'=>number_format(Cart::total() * 0.30,2),
                    ]);
                    foreach (Cart::content() as $item) {
                        Pedidos_pendiente::create([
                            'id_separados'=>$separado->id,
                            'id_producto'=>$item->id,
                            'cantidad' => $item->qty,
                            'precio' => $item->price,
                            'total' => number_format(($item->price * $item->qty), 2),
                            'estado' => 'SEPARADO',
                            'usuario' => Auth::user()->id,
                        ]);
                        $pro = Producto::where('id', $item->id)->first();
                        $nuevo_stock = $pro->stock - $item->qty;
                        Producto::where('id', $item->id)->update(['stock' => $nuevo_stock]);
                    }
                    Cart::destroy();
                    $this->alert = true; 
                }else{
                    $this->message= 'No hay stock disponible de los siguientes productos: '.substr($text, 0, -2);
                }
                
            } catch (\Throwable $th) {
                $this->message= 'ERROR AL GUARDAR PEDIDO, CONTACTE CON SISTEMAS ERROR:'.$th; 
            }

        }else{
            $this->message= 'NO PUEDE GUARDAR UN PEDIDO SIN PRODUCTOS'; 
        }
    }
}
