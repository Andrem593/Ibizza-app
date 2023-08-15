<?php

namespace App\Http\Livewire;

use App\Empresaria;
use App\Models\Pedidos_pendiente;
use App\Models\Separado;
use App\Producto;
use Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PedidosReservados extends Component
{
    public $alert = false, $detalle=false, $cliente;
    public $detalles_pedido,$fecha;
    public $desde, $hasta;
    public $search;
    public $id_pedido = 0;
    
    public function render()
    {
        $separado = Separado::with(['empresaria','usuario']);
        if ($this->desde != "" && $this->hasta != "") {
            // $separado = $separado->whereDate('created_at', '>=', $this->desde)
            // ->whereDate('created_at', '<=', $this->hasta);
            $separado = $separado->orWhere(function ($query) {
                $query->whereDate('created_at', '>=', $this->desde)
                ->whereDate('created_at', '<=', $this->hasta);
            });
        }
        if ($this->search != "") {
            $separado = $separado->orWhere('nombre_cliente', 'like', '%' . $this->search . '%')->orWhereHas('empresaria', function ($query) {
                $query->where('nombres', 'like', '%' . $this->search . '%');
            })->orWhereHas('usuario', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orWhereHas('empresaria', function ($query) {
                $query->where('tipo_cliente', 'like', '%' . $this->search . '%');
            });
        }
        if(Auth::user()->role != 'ADMINISTRADOR'){
            $separado = $separado->where('id_usuario',Auth::user()->id)->get();
        }else{
            $separado = $separado->get();
        }
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
        $this->id_pedido = $id;        
        $this->detalles_pedido = Pedidos_pendiente::where('id_separados',$id)->select('pedidos_pendientes.*','productos.descripcion','productos.imagen_path','productos.color','productos.talla')
        ->join('productos','pedidos_pendientes.id_producto','=','productos.id')->get();    
        if (Auth::user()->role != 'Empresaria') {   
            $this->cliente =  Separado::find($id);            
        }
    }
    public function recuperarPedido($productos){                
        foreach ($productos as $producto) {            
            $products = Producto::find($producto['id_producto']);
            $nuevo_stock = $products->stock + $producto['cantidad'];
            Producto::find($producto['id_producto'])->update([
                'stock'=>$nuevo_stock
            ]);
            Cart::add($producto['id_producto'], 
            $products->descripcion, $producto['cantidad'], $producto['precio'], ['image' => $producto['imagen_path'] , 
            'color'  => $producto['color'] , 'talla' => $producto['talla'], 'descuento' => $producto['descuento'], 'pCatalogo' => $producto['precio_empresaria'],
            'dataEnvio' => $producto['direccion_envio']
            ])->associate('App\Models\Producto');
        }
        $id = $productos[0]['id_separados'];        
        $emp = Empresaria::find($this->cliente->id_empresaria);        
        Pedidos_pendiente::where('id_separados',$id)->delete();  
        Separado::find($id)->delete();
        
        return redirect()->to(route('venta.pedido', ['empresaria' => $emp->id]));
    }
}
