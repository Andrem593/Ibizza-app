<?php

namespace App\Http\Livewire;

use App\Empresaria;
use App\Models\LogStockFaltante;
use App\Models\Pedidos_pendiente;
use App\Models\Separado;
use App\Models\Venta;
use Livewire\Component;
use App\Producto;
use Cart;
use Illuminate\Support\Facades\Auth;

class TomarPedido extends Component
{
    public $estilo, $colores, $tallas, $message, $color, $talla, $cantidad, $alert, $stock, $cliente, $similitudes, $click = false;

    public $venta, $user, $empresarias, $tipoEmpresaria, $click2 = false, $marca, $id_empresaria, $emp;

    public $imagen = 'https://catalogoibizza.com/img/imagen-no-disponible.jpg';
    protected $listeners = ['change' => 'buscarColor'];

    public function render()
    {
        $venta = Venta::orderBy('id', 'desc')->first();
        $this->venta = sprintf('%06d', $venta->id + 1);
        $this->user = Auth::user();
        if ($this->id_empresaria != null && !$this->click2) {
            $emp = Empresaria::with('pedidos')->find($this->id_empresaria);
            $this->cliente = $emp->nombres . ' ' . $emp->apellidos;
            $this->tipoEmpresaria = $emp->tipo_cliente;
            $this->click2 = true;
        }
        if (!empty($this->cliente) && !$this->click2) {
            $this->empresarias = Empresaria::with('pedidos')->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->cliente . '%')
                    ->orWhere('cedula', 'like', '%' . $this->cliente . '%');
            })->get();
        }

        if (!empty($this->estilo) && !$this->click) {
            $this->similitudes = Producto::distinct()->where('estilo', 'like', '%' . $this->estilo . '%')->select('estilo')->get();
        }
        return view('livewire.tomar-pedido');
    }
    public function clickSimilitud($similitud)
    {
        $this->estilo = $similitud;
        $this->similitudes = [];
        $this->click = true;
        $this->buscarEstilo();
    }
    public function clickEmpresaria($emp, $tipo)
    {
        $this->cliente = $emp['nombres'] . ' ' . $emp['apellidos'];
        $this->id_empresaria = $emp['id'];
        $this->emp = Empresaria::with('pedidos')->find($this->id_empresaria);
        $this->empresarias = [];
        $this->click2 = true;
        $this->tipoEmpresaria = $tipo;
    }
    public function clearEmpresaria()
    {
        $this->cliente = '';
        $this->empresarias = [];
        $this->id_empresaria = null;
        $this->click2 = false;
        $this->tipoEmpresaria = '';
        $this->emp = null;
    }
    public function buscarEstilo()
    {

        try {
            $estilo = $this->estilo;
            $colores = Producto::where('estilo', $estilo)->groupBy('color')->get();
            $tallas = Producto::where('estilo', $estilo)
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca')
                ->where('color', $colores[0]->color)->get();
            $this->colores = $colores;
            $this->tallas = $tallas;
            $this->color = $colores[0]->color;
            $this->marca = $tallas[0]->nombre_marca;
            $this->talla = $tallas[0]->talla;
            $this->stock = $tallas[0]->stock;
            $this->imagen = empty($colores[0]->imagen_path) ?  $this->imagen : '../storage/images/productos/' . $colores[0]->imagen_path;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->click = false;
            $this->message = 'CODIGO INGRESADO NO ES CORRECTO';
            $this->reset(['colores', 'tallas', 'imagen']);
        }
    }
    public function buscarColor()
    {
        try {
            $estilo = $this->estilo;
            $tallas = Producto::where('estilo', $estilo)
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca')
                ->where('color', $this->color)->get();
            $this->tallas = $tallas;
            $this->talla = $tallas[0]->talla;
            $this->marca = $tallas[0]->nombre_marca;
            $this->stock = $tallas[0]->stock;
            $this->imagen = empty($tallas[0]->imagen_path) ?  $this->imagen : '../storage/images/productos/' . $tallas[0]->imagen_path;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->click = false;
            $this->message = 'CODIGO INGRESADO NO ES CORRECTO';
            $this->reset(['colores', 'tallas', 'imagen']);
        }
    }
    public function addCart()
    {
        $this->click = false;
        $this->message = '';
        if ($this->cantidad > 0 && !empty($this->estilo) && !empty($this->color) && !empty($this->talla)) {
            $producto = Producto::where('estilo', $this->estilo)->where('color', $this->color)->where('talla', $this->talla)
                ->with('marca')
                ->first();
            if ($producto->stock >= $this->cantidad) {
                $precio = $producto->precio_empresaria;

                if (!empty($producto->descuento)) {
                    $precio = number_format(($producto->precio_empresaria - ($producto->precio_empresaria * ($producto->descuento / 100))), 2);
                }
                try {
                    Cart::add(
                        $producto->id,
                        $producto->nombre_producto,
                        $this->cantidad,
                        number_format($producto->precio_empresaria, 2),
                        ['image' => $producto->imagen_path, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
                        'descuento'=> 0, 'pCatalogo'=>$producto->precio_empresaria ]
                    )
                        ->associate('App\Models\Producto');
                    $this->reset(['colores', 'tallas', 'imagen', 'color', 'talla', 'cantidad']);
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }
            } else {
                LogStockFaltante::create([
                    'nombre_mostrar' => $producto->descripcion,
                    'estilo' => $this->estilo,
                    'color' => $this->color,
                    'talla' => $this->talla,
                    'stock_requerido' => $this->cantidad,
                ]);
                $this->message = 'NO HAY STOCK DISPONIBLE';
            }
        } else {
            $this->click = false;
            $this->message = 'VERIFIQUE QUE ESTEN TODOS LOS CAMPOS LLENOS';
        }
    }
    public function eliminarItem($id)
    {
        Cart::remove($id);
    }
    public function GuardarPedidos()
    {
        if (empty($this->cliente) || !$this->click2) {
            $this->message = 'INGRESE EL NOMBRE DE LA EMPRESARIA';
            return;
        }
        if (Cart::count() > 0) {
            try {
                $flag = false;
                $text = '';
                foreach (Cart::content() as $item) {
                    $pro = Producto::where('id', $item->id)->first();
                    $nuevo_stock = $pro->stock - $item->qty;
                    if ($nuevo_stock < 0) {
                        $flag = true;
                        $text .= $item->name . ' >> ' . $pro->stock . ' en stock, ';
                    }
                }

                if (!$flag) {

                    $separado = Separado::create([
                        'id_usuario' => Auth::user()->id,
                        'id_empresaria' => $this->id_empresaria,
                        'nombre_cliente' => $this->cliente,
                        'cantidad_total' => Cart::count(),
                        'total_venta' => Cart::total(),
                        'total_p_empresaria' => number_format(((float) Cart::total()) * 0.30, 2),
                    ]);
                    foreach (Cart::content() as $item) {
                        Pedidos_pendiente::create([
                            'id_separados' => $separado->id,
                            'id_producto' => $item->id,
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
                } else {
                    $this->message = 'No hay stock disponible de los siguientes productos: ' . substr($text, 0, -2);
                }
            } catch (\Throwable $th) {
                $this->message = 'ERROR AL GUARDAR PEDIDO, CONTACTE CON SISTEMAS';
            }
        } else {
            $this->message = 'NO PUEDE GUARDAR UN PEDIDO SIN PRODUCTOS';
        }
    }
    public function stockProduct($talla)
    {
        $estilo = $this->estilo;
        $producto = Producto::where('estilo', $estilo)->where('color', $this->color)->where('talla', $this->talla)->first();
        $this->stock = $producto->stock;
    }

    public function increaseQuantity($rowId)
    {
        $item = Cart::get($rowId);

        if ($item) {
            Cart::update($rowId, $item->qty + 1);
            $this->emit('cartUpdated');
        }
    }

    public function decreaseQuantity($rowId)
    {
        $item = Cart::get($rowId);

        if ($item && $item->qty > 1) {
            Cart::update($rowId, $item->qty - 1);
            $this->emit('cartUpdated');
        }
    }
}
