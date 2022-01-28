<?php

namespace App\Http\Livewire;

use App\Models\Pedidos_pendiente;
use App\Models\Separado;
use App\Producto;
use Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PedidosReservados extends Component
{
    public $alert = false, $detalle=false;
    public $detalles_pedido,$fecha;
    
    public function render()
    {
        $separado = Separado::where('id_usuario',Auth::user()->id)->get();
        return view('livewire.pedidos-reservados',compact('separado'));
    }
    public function eliminarReserva($id)
    { 
        $pedidos = Pedidos_pendiente::where('id_separados',$id)->get();
        foreach ($pedidos as $pedido) {   
            $producto = Producto::find($pedido->id_producto);
            $nuevo_stock = $producto->stock + $pedido->cantidad;
            Producto::find($pedido->id_producto)->update([
                'stock'=>$nuevo_stock
            ]);
        }
        Pedidos_pendiente::where('id_separados',$id)->delete();  
        Separado::find($id)->delete();      
        $this->alert = true;
    }
    public function verDetalle($id)
    {
        $this->detalle = true;
        $this->detalles_pedido = Pedidos_pendiente::where('id_separados',$id)->join('productos','pedidos_pendientes.id_producto','=','productos.id')->get();        
    }
    public function recuperarPedido($productos){                
        foreach ($productos as $producto) {
            Cart::add($producto['id_producto'], $producto['nombre_mostrar'], $producto['cantidad'], $producto['precio'], ['image' => $producto['imagen_path'] , 'color'  => $producto['color'] , 'talla' => $producto['talla'] ])->associate('App\Models\Producto');
        }
        $id = $productos[0]['id_separados'];
        Pedidos_pendiente::where('id_separados',$id)->delete();  
        Separado::find($id)->delete();      
        return redirect()->to(route('web.tomar-pedido'));
    }
}
