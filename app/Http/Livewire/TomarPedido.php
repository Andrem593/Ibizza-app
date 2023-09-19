<?php

namespace App\Http\Livewire;

use Cart;
use App\Producto;
use App\Empresaria;
use App\Models\Venta;
use App\Models\Ciudad;
use Livewire\Component;
use App\Models\Separado;
use App\Models\Provincia;
use App\Models\LogStockFaltante;
use App\Models\ParametroCatalogo;
use App\Models\Pedidos_pendiente;
use Illuminate\Support\Facades\Auth;

class TomarPedido extends Component
{
    public $estilo, $colores, $tallas, $message, $color, $talla, $cantidad, $alert, $stock, $cliente, $similitudes, $descripcion_producto, $click = false;

    public $venta, $user, $empresarias, $tipoEmpresaria, $click2 = false, $marca, $id_empresaria, $emp;

    public $provincias, $ciudades;

    public $nombre, $telefono, $provincia, $ciudad, $direccion, $referencia;

    public $envio = 0;

    public $imagen = 'https://catalogoibizza.com/img/imagen-no-disponible.jpg';

    protected $listeners = ['change' => 'buscarColor', 'guardarDatos'];


    public function render()
    {
        $venta = Venta::orderBy('id', 'desc')->first();
        $venta = $venta == null ? 0 : $venta->id;
        $this->venta = sprintf('%06d', $venta + 1);
        $this->user = Auth::user();
        if ($this->id_empresaria != null && !$this->click2) {
            $emp = Empresaria::with('pedidos')->find($this->id_empresaria);
            $this->cliente = $emp->nombres . ' ' . $emp->apellidos;
            $this->tipoEmpresaria = $emp->tipo_cliente;
            $this->click2 = true;
        }
        if (!empty($this->cliente) && !$this->click2) {
            $this->empresarias = Empresaria::with('pedidos')
                ->where(function ($query) {
                    $query->where('cedula', 'like', '%' . $this->cliente . '%')
                        ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ['%' . $this->cliente . '%']);
                })
                ->where('estado', 'A')
                ->get();
        }

        $this->provincias = Provincia::get();

        if (!empty($this->estilo) && !$this->click) {
            $this->similitudes = Producto::distinct()->where('estilo', 'like', '%' . $this->estilo . '%')
                ->where('estado', 'A')
                ->select('estilo')->get();
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
            $colores = Producto::where('estilo', $estilo)->groupBy('color')
                ->where('estado', 'A')
                ->get();
            $tallas = Producto::where('estilo', $estilo)
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca')
                ->where('color', $colores[0]->color)
                ->where('productos.estado', 'A')
                ->get();
            $this->colores = $colores;
            $this->tallas = $tallas;
            $this->descripcion_producto = $tallas[0]->descripcion; //Se agrega propiedad para capturar la descripción del producto
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
                ->where('color', $this->color)
                ->where('productos.estado', 'A')->get();
            $this->tallas = $tallas;
            $this->talla = $tallas[0]->talla;
            $this->descripcion_producto = $tallas[0]->descripcion;//Se agrega propiedad para capturar la descripción del producto
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
                ->where('estado', 'A')
                ->with(['marca', 'catalogo'])
                ->first();

            $parametros = ParametroCatalogo::where('catalogo_id', $producto->catalogo->catalogo_id)
                ->where('estado', 1)
                ->get();

            if ($producto->stock >= $this->cantidad) {
                $precio = $producto->precio_empresaria;
                $descuento = 0;

                $data = $this->validacionReglas($descuento, $precio, $parametros, $this->cantidad + Cart::count(), $this->envio, 'suma', 1, $this->cantidad);

                $descuento = $data['descuento'];
                $precio = $data['precio'];                            
                try {
                    if ($descuento > 0) {
                        $carItems = Cart::content();
                        foreach ($carItems as $key => $item) {
                            $precioNuevo = (float) $item->options->pCatalogo - ($item->options->pCatalogo * $descuento);                            
                            Cart::update($item->rowId, ['price' => $precioNuevo, 'options' => [
                                'sku' => $item->options->sku, 'color'  => $item->options->color, 'talla' => $item->options->talla, 'marca' => $item->options->marca,
                                'descuento' => $descuento, 'pCatalogo' => $item->options->pCatalogo, 'dataEnvio' => $item->options->dataEnvio != '' ? $item->options->dataEnvio : ''
                            ]]);
                        }
                    }
                    Cart::add(
                        $producto->id,
                        $producto->descripcion,
                        $this->cantidad,
                        $precio,
                        [
                            'sku' => $producto->sku, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
                            'descuento' => $descuento, 'pCatalogo' => $producto->precio_empresaria
                        ]
                    )->associate('App\Models\Producto');
                    //separar stock 
                    $producto->update(['stock' => $producto->stock - $this->cantidad]);
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
        $item = Cart::get($id);
        $producto = Producto::where('id', $item->id)->with(['marca', 'catalogo'])->first();
        $producto->update(['stock' => $producto->stock + $item->qty]);
        $parametros = ParametroCatalogo::where('catalogo_id', $producto->catalogo->catalogo_id)
            ->where('estado', 1)
            ->get();

        $descuento = 0;
        $this->envio = 0; //Al eliminar item, siempre el costo de envio será 0. Se volverá a calcular según párametro del catalogo
        $precio = $producto->precio_empresaria;
        $datos = $this->validacionReglas($descuento, $precio, $parametros, Cart::count() - $item->qty, $this->envio, 'resta', $item->qty);
        $descuento = $datos['descuento'];
        Cart::remove($id);
        if ($descuento == 0) {
            $carItems = Cart::content();
            foreach ($carItems as $key => $item) {
                $precioNuevo = (float) $item->options->pCatalogo;
                Cart::update($item->rowId, ['price' => round($precioNuevo,2), 'options' => [
                    'sku' => $item->options->sku, 'color'  => $item->options->color, 'talla' => $item->options->talla, 'marca' => $item->options->marca,
                    'descuento' => $descuento, 'pCatalogo' => $item->options->pCatalogo, 'dataEnvio' => $item->options->dataEnvio != '' ? $item->options->dataEnvio : ''
                ]]);
            }
        }
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
                    $nuevo_stock = $pro->stock;
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
                        'total_venta' => round(Cart::content()->map(function ($item) {
                            return $item->options->pCatalogo * $item->qty;
                        })->sum(), 2),
                        'total_p_empresaria' => Cart::subtotal(),
                        'envio' => $this->envio,
                    ]);
                    foreach (Cart::content() as $item) {
                        Pedidos_pendiente::create([
                            'id_separados' => $separado->id,
                            'id_producto' => $item->id,
                            'cantidad' => $item->qty,
                            'precio' => round($item->price,2),
                            'descuento' => $item->options->descuento,
                            'precio_empresaria' => $item->options->pCatalogo,
                            'total' => round(($item->price * $item->qty), 2),
                            'estado' => 'SEPARADO',
                            'usuario' => Auth::user()->id,
                            'direccion_envio' => $item->options->dataEnvio != '' ? $item->options->dataEnvio : ''
                        ]);
                        $pro = Producto::where('id', $item->id)->first();
                        // $nuevo_stock = $pro->stock - $item->qty;
                        // Producto::where('id', $item->id)->update(['stock' => $nuevo_stock]);
                    }
                    Cart::destroy();
                    $this->alert = true;
                } else {
                    $this->message = 'No hay stock disponible de los siguientes productos: ' . substr($text, 0, -2);
                }
            } catch (\Throwable $th) {
                dd($th->getMessage());
                $this->message = 'ERROR AL GUARDAR PEDIDO, CONTACTE CON SISTEMAS';
            }
        } else {
            $this->message = 'NO PUEDE GUARDAR UN PEDIDO SIN PRODUCTOS';
        }
    }
    public function stockProduct($talla)
    {
        $estilo = $this->estilo;
        $producto = Producto::where('estilo', $estilo)->where('color', $this->color)->where('talla', $this->talla)
            ->where('estado', 'A')
            ->first();
        $this->stock = $producto->stock;
        $this->descripcion_producto = $producto->descripcion; //Se agrega propiedad para capturar la descripción del producto
    }

    public function increaseQuantity($rowId)
    {
        $item1 = Cart::get($rowId);
        $producto = Producto::where('id', $item1->id)->with(['marca', 'catalogo'])->first();
        if($producto->stock - 1 >= 0){
            $producto->update(['stock' => $producto->stock - 1]);
            $parametros = ParametroCatalogo::where('catalogo_id', $producto->catalogo->catalogo_id)
                ->where('estado', 1)
                ->get();
    
            if ($item1) {
                $descuento = 0;
                $precio = $producto->precio_empresaria;
                $data = $this->validacionReglas($descuento, $precio, $parametros, Cart::count() + 1, $this->envio, 'suma', 1);
                $descuento = $data['descuento'];
                $precio = $data['precio'];
    
                Cart::update($rowId, ['qty' => $item1->qty + 1]);
                if ($descuento > 0) {
                    $carItems = Cart::content();
                    foreach ($carItems as $key => $item) {
                        $precioNuevo = (float) $item->options->pCatalogo - ($item->options->pCatalogo * $descuento);
                        Cart::update($item->rowId, ['price' => round($precioNuevo,2), 'options' => [
                            'sku' => $item->options->sku, 'color'  => $item->options->color, 'talla' => $item->options->talla, 'marca' => $item->options->marca,
                            'descuento' => $descuento, 'pCatalogo' => $item->options->pCatalogo, 'dataEnvio' => $item->options->dataEnvio != '' ? $item->options->dataEnvio : ''
                        ]]);
                    }
                }
                $this->emit('cartUpdated');
            }
        }else{
            $this->message = 'NO HAY STOCK DISPONIBLE PARA '. $producto->descripcion;
        }
    }

    public function decreaseQuantity($rowId)
    {
        $item1 = Cart::get($rowId);
        $producto = Producto::where('id', $item1->id)->with(['marca', 'catalogo'])->first();
        $producto->update(['stock' => $producto->stock + 1]);
        $parametros = ParametroCatalogo::where('catalogo_id', $producto->catalogo->catalogo_id)
            ->where('estado', 1)
            ->get();

        if ($item1 && $item1->qty > 1) {
            $descuento = 0;
            $precio = $producto->precio_empresaria;
            $data = $this->validacionReglas($descuento, $precio, $parametros, Cart::count() - 1, $this->envio, 'resta', 1, 1, $item1->options->descuento, $item1->qty);
            $precio = $data['precio'];
            $descuento = $data['descuento'];

            Cart::update($rowId, ['qty' => $item1->qty - 1]);
            if ($descuento == 0) {
                $carItems = Cart::content();
                foreach ($carItems as $key => $item) {
                    $precioNuevo = (float) $item->options->pCatalogo;
                    Cart::update($item->rowId, ['price' => round($precioNuevo,2), 'options' => [
                        'sku' => $item->options->sku, 'color'  => $item->options->color, 'talla' => $item->options->talla, 'marca' => $item->options->marca,
                        'descuento' => $descuento, 'pCatalogo' => $item->options->pCatalogo, 'dataEnvio' => $item->options->dataEnvio != '' ? $item->options->dataEnvio : ''
                    ]]);
                }
            }
            $this->emit('cartUpdated');
        }
    }

    public function validacionReglas($descuento, $precio, $parametros, $cantidad, $envio, $tipo = null, $cantidadResta = 1, $cantidadSuma = 1, $descuentoDecrease = 0, $itemCantidad = 0)
    {
        try {
            if (!empty($parametros)) {
                foreach ($parametros as $key => $regla) {
                    if ($regla->tipo_empresaria == 'TODOS') {
                        if ($regla->condicion == 'cantidad') {
                            $desc = $cantidad . $regla->operador . $regla->cantidad;
                            $desc = eval("return $desc;") ? $regla->valor : 0;
                            if ($desc > $descuento) $descuento = $desc;
                        }
                        if ($regla->condicion == 'valor') {
                            $desc = $cantidad . $regla->operador . $regla->cantidad;
                            $desc = eval("return $desc;") ? $regla->valor : 0;
                            if ($desc > $descuento) $descuento = $desc;
                        }
                        if ($regla->condicion == 'envio_cantidad') {
                            $env = Cart::count() + $cantidad . $regla->operador . $regla->cantidad;
                            $env = eval("return $env;") ? $regla->valor : 0;
                            $this->envio = $env;
                        }
                        if ($regla->condicion == 'envio_costo') {
                            $desc = $precio * ($descuento / 100);
                            if ($descuentoDecrease > 0 && $itemCantidad > 0) {
                                $desc = $precio * $descuentoDecrease;
                                $cant = $itemCantidad;
                            }
                            if ($tipo == 'resta') {
                                if ($descuentoDecrease > 0 && $itemCantidad > 0) {
                                    $carro = floatval(str_replace(',', '', Cart::subtotal())) - ($cant * ($precio - $desc));
                                    $subtotal = $carro + ((($cant - 1) * ($precio - $desc)));
                                } else {
                                    $subtotal = floatval(str_replace(',', '', Cart::subtotal())) - ($cantidadResta * ($precio - $desc));
                                }
                            } else {
                                $subtotal = 0;
                                $subtotal = Cart::content()->map(function ($item) use ($desc) {
                                    return ($item->options->pCatalogo - $desc) * $item->qty;
                                })->sum();
                                $subtotal = $subtotal + ($cantidadSuma * ($precio - $desc));
                            };
                            
                            //Solo aplicar condición del catalogo cuando subtotal sea mayor que 0
                            if($subtotal > 0):
                                $env = $subtotal  .$regla->operador . $regla->cantidad;
                                $env = eval("return $env;") ? $regla->valor : 0;
                                $this->envio = $env;
                            endif;
                            
                        }
                    } elseif ($regla->tipo_empresaria == $this->tipoEmpresaria) {
                        if ($regla->condicion == 'cantidad') {
                            $desc = $cantidad . $regla->operador . $regla->cantidad;
                            $desc = eval("return $desc;") ? $regla->valor : 0;
                            if ($desc > $descuento) $descuento = $desc;
                        }
                        if ($regla->condicion == 'valor') {
                            $desc = $cantidad . $regla->operador . $regla->cantidad;
                            $desc = eval("return $desc;") ? $regla->valor : 0;
                            if ($desc > $descuento) $descuento = $desc;
                        }
                        if ($regla->condicion == 'envio_cantidad') {
                            $env = Cart::count() + $cantidad . $regla->operador . $regla->cantidad;
                            $env = eval("return $env;") ? $regla->valor : 0;
                            $this->envio = $env;
                        }
                    }
                }
                $descuento = (float) $descuento / 100;
                $precio = (float) $precio - ($precio * $descuento);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }


        return ['descuento' => $descuento, 'precio' => $precio];
    }

    public function cerrarVenta()
    {
        if (empty($this->cliente) || !$this->click2) {
            $this->message = 'INGRESE EL NOMBRE DE LA EMPRESARIA';
            return;
        }

        return redirect()->to(route('web.checkout', ['id' => $this->id_empresaria, 'envio' => $this->envio]));
    }

    public function guardarDatos($data)
    {
        $rowId = $data['rowId'];
        $item = Cart::get($rowId);
        Cart::update($item->rowId, ['options' => [
            'sku' => $item->options->sku, 'color'  => $item->options->color, 'talla' => $item->options->talla, 'marca' => $item->options->marca,
            'descuento' => $item->options->descuento, 'pCatalogo' => $item->options->pCatalogo, 'dataEnvio' => json_encode($data)
        ]]);
    }
}
