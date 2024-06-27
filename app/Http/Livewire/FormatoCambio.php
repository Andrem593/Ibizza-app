<?php

namespace App\Http\Livewire;

use App\Producto;
use App\Empresaria;
use App\Models\CambioPedido;
use App\Models\ParametroCatalogo;
use App\Models\ParametroMarca;
use App\Models\ProductoCambio;
use App\Models\ReservarCambiosDetalle;
use App\Models\ReservarCambiosPedido;
use App\Models\Venta;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FormatoCambio extends Component
{
    public $estilo, $colores, $tallas, $message, $color, $talla, $cantidad, $alert, $stock, $cliente, $similitudes, $click = false, $motivoCambio, $descripcionCambio, $observaciones;
    public $venta, $user, $empresarias, $tipoEmpresaria, $click2 = false, $marca, $id_empresaria, $emp;
    public $idventa, $pedidos, $productosACambiar, $nuevoProducto = [];
    public $f_nombre, $f_cedula, $f_telefono, $f_correo;
    public $e_nombre, $e_cedula, $e_telefono, $e_provincia, $e_ciudad, $e_direccion, $e_pedido, $e_c_envio;
    public $envio = 0 ;
    public $id_pedido = "" ;
    public $selectedItems = [];

    public $selectedItem = null;
    public $selectedItemData = [
        'sku' => '',
        'descripcion' => '',
        'color' => '',
        'talla' => '',
        'cantidad' => '',
        'descuento' => '',
        'pvp' => '',
        'p_empresaria' => '',
        'cantidad_cambiar' =>''
    ];

    protected $listeners = ['openModal', 'closeModal'];

    public $changes = [];

    public $isOpen = false;

    public $idCambio = null ;



    public function updatedIdPedido($value)
    {
        if ($value > 0) {
            $this->envio = 0 ;
        }else{
            $this->checkShippingCost();
        }
    }

    public function mount()
    {
        $id = Session::get('id', null);
        Session::forget('id');
        if($id){

            $this->idCambio = $id ;
            $reserveChangesOrder = ReservarCambiosPedido::findOrFail($id);
            if($reserveChangesOrder){
                $this->f_nombre = $reserveChangesOrder->f_cedula ;
                $this->f_cedula = $reserveChangesOrder->f_cedula ;
                $this->f_telefono = $reserveChangesOrder->f_telefono ;
                $this->f_correo = $reserveChangesOrder->f_correo ;

                //Preguntarla Fceha
                // $this->fecha = ;
                $this->id_empresaria =  $reserveChangesOrder->id_empresaria ;
                $this->descripcionCambio = $reserveChangesOrder->motivo ;
                $this->motivoCambio = $reserveChangesOrder->descripcion ;

                $this->e_nombre = $reserveChangesOrder->e_nombre ;
                $this->e_cedula = $reserveChangesOrder->e_cedula ;
                $this->e_telefono = $reserveChangesOrder->e_telefono ;
                $this->e_provincia = $reserveChangesOrder->e_provincia ;
                $this->e_ciudad = $reserveChangesOrder->e_ciudad ;
                $this->e_direccion = $reserveChangesOrder->e_direccion ;
                $this->observaciones = $reserveChangesOrder->observaciones ;
                $this->e_pedido = $reserveChangesOrder->e_pedido ;

                $this->e_c_envio = $reserveChangesOrder->envio ;
                $this->idventa = $reserveChangesOrder->id_venta ;

                $empresaria = Empresaria::findOrFail($this->id_empresaria);
                $this->cliente = $empresaria->nombre_completo;
                $this->tipoEmpresaria = $empresaria->tipo_cliente;

                $this->id_pedido = $reserveChangesOrder->id_pedido ;

                // $this->emp = Empresaria::with('pedidos', 'usuario', 'ciudad')->find($this->id_empresaria);

                $this->buscarVenta() ;

                $this->getReservedChangeDetail($id);

                $this->checkShippingCost();

                $this->brandDiscount();


            }
        }
    }

    public function getReservedChangeDetail($id)
    {
        $reservarCambiosDetalle = ReservarCambiosDetalle::with('product')->where('id_reservar_cambio_pedido', $id)->get();

        foreach ($reservarCambiosDetalle as $key => $detail) {

            $product = Producto::findOrfail($detail->id_producto);

            $productSale = $this->pedidos->where('id_producto', $detail->order->producto->id)->first();


            $diff = ($detail->precio * $detail->cantidad ) - ($productSale['precio'] * $detail->cantidad ) ;

            $diff = number_format($diff, 2);
            $this->nuevoProducto[] = [
                'id' => $product->id,
                'sku' => $product->sku,
                'descripcion' => $product->descripcion,
                'estilo' => $product->estilo,
                'color' => $product->color,
                'talla' => $product->talla,
                'marca' => $product->marca->nombre,
                'cantidad' => $detail->cantidad,
                'precio' => $detail->precio,
                'precio_catalogo' => $detail->precio_catalogo,
                'total'=> $detail->total,
                'descuento' => $detail->descuento,
                'id_pedido' => $detail->id_pedido ,
                'total_p_empresaria' => $detail->total - ($detail->total * $detail->descuento),

                'id_producto_original' => $detail->order->producto->id,
                'precio_producto_venta' => $productSale['precio'],
                'cantidad_producto_venta' => $productSale['cantidad'],
                'diferencia' => $diff
            ];


            $originalData = [
                'id' => $productSale['id_producto'],
                'sku' => $productSale['producto']['sku'],
                'descripcion' => $productSale['producto']['descripcion'],
                'color' => $productSale['producto']['color'],
                'talla' => $productSale['producto']['talla'],
                'cantidad' => $productSale['cantidad'],
                'pvp' => number_format($productSale['precio_catalogo'], 2),
                'descuento' => $productSale['descuento'] * 100 . '%',
                'p_empresaria' => number_format(($productSale['precio']), 2)
            ];
            $this->changes[] = [
                'original' => $originalData,
                'changed' => [
                    'id' => $product->id,
                    'sku' => $product->sku,
                    'descripcion' => $product->descripcion,
                    'estilo' => $product->estilo,
                    'color' => $product->color,
                    'talla' => $product->talla,
                    'marca' => $product->marca->nombre,
                    'cantidad' => $detail->cantidad,
                    'precio' => $product->precio_empresaria,
                ]
            ];
        }

        // dd($reservarCambiosDetalle);
    }


    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }


    public function render()
    {
        $this->user = Auth::user();
        if (!empty($this->cliente) && !$this->click2) {
            $this->empresarias = Empresaria::with('pedidos')->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->cliente . '%')
                    ->orWhere('cedula', 'like', '%' . $this->cliente . '%');
            })
                ->where('estado', 'A')
                ->limit(20)
                ->get();
        }

        if (!empty($this->estilo) && !$this->click) {
            $this->similitudes = Producto::distinct()->where('estilo', 'like', '%' . $this->estilo . '%')->select('estilo')->get();
        }

        return view('livewire.formato-cambio');
    }


    public function getBusinessInformation()
    {
        if($this->id_empresaria !=''){
            $this->emp = Empresaria::with('pedidos', 'usuario', 'ciudad')->find($this->id_empresaria);
            $this->f_cedula = $this->emp->cedula;
            $this->f_nombre = $this->emp->nombres . ' ' . $this->emp->apellidos;
            $this->f_telefono = $this->emp->telefono;
            $this->f_correo = $this->emp->usuario->email;
        }

    }

    public function getShippingDataBusinesswoman()
    {
        if($this->id_empresaria !=''){
            $this->emp = Empresaria::with('pedidos', 'usuario', 'ciudad')->find($this->id_empresaria);
            $this->e_nombre = $this->emp->nombres . ' ' . $this->emp->apellidos;
            $this->e_cedula = $this->emp->cedula;
            $this->e_telefono = $this->emp->telefono;
            if ($this->emp->ciudad) {
                $this->e_provincia = $this->emp->ciudad->provincia->descripcion;
                $this->e_ciudad = $this->emp->ciudad->descripcion;
            }
            $this->e_direccion = $this->emp->direccion;
        }

    }

    public function clickEmpresaria($emp, $tipo)
    {
        $this->cliente = $emp['nombres'] . ' ' . $emp['apellidos'];
        $this->id_empresaria = $emp['id'];
        $this->emp = Empresaria::with('pedidos', 'usuario', 'ciudad')->find($this->id_empresaria);
        $this->f_cedula = $this->emp->cedula;
        $this->f_nombre = $this->emp->nombres . ' ' . $this->emp->apellidos;
        $this->f_telefono = $this->emp->telefono;
        $this->f_correo = $this->emp->usuario->email;

        $this->e_nombre = $this->emp->nombres . ' ' . $this->emp->apellidos;
        $this->e_cedula = $this->emp->cedula;
        $this->e_telefono = $this->emp->telefono;
        if ($this->emp->ciudad) {
            $this->e_provincia = $this->emp->ciudad->provincia->descripcion;
            $this->e_ciudad = $this->emp->ciudad->descripcion;
        }
        $this->e_direccion = $this->emp->direccion;
        $this->empresarias = [];
        $this->click2 = true;
        $this->tipoEmpresaria = $tipo;
    }

    public function nuevosDatosFac()
    {
        $this->f_cedula = '';
        $this->f_nombre = '';
        $this->f_telefono = '';
        $this->f_correo = '';
    }

    public function nuevosDatosEnv()
    {
        $this->e_nombre = '';
        $this->e_cedula = '';
        $this->e_telefono = '';
        $this->e_provincia = '';
        $this->e_ciudad = '';
        $this->e_direccion = '';
        $this->e_pedido = '';
        $this->e_c_envio = '';

        $this->checkShippingCost();
    }

    public function nuevosDatosLoc()
    {
        $this->e_nombre = 'Local Ibizza';
        $this->e_provincia = 'Guayas';
        $this->e_ciudad = 'Guayaquil';
        $this->e_direccion = 'Calle chile y Luque';
        $this->observaciones = 'Frente a De Prati';

        // $this->envio = 0 ;
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

    public function buscarVenta()
    {
        try {
            $this->venta = Venta::where('id', $this->idventa)->where('id_empresaria', $this->id_empresaria)
                ->with('pedidos')
                ->first();
            $this->pedidos = $this->venta->pedidos;
        } catch (\Throwable $th) {
            $this->message = 'No se encontró la venta, verifique los datos';
        }
    }
    public function buscarEstilo()
    {
        try {
            $estilo = $this->estilo;
            $colores = Producto::where('estilo', $estilo)->groupBy('color')
                ->where('estado', 'A')
                ->where('stock', '>', 0)
                ->get();
            $tallas = Producto::where('estilo', $estilo)
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca')
                ->where('color', $colores[0]->color)
                ->where('productos.estado', 'A')
                ->where('productos.stock', '>', 0)
                ->distinct('talla')
                ->get();
            $this->colores = $colores;
            $this->tallas = $tallas;
            $this->color = $colores[0]->color;
            $this->marca = $tallas[0]->nombre_marca;
            $this->talla = $tallas[0]->talla;
            $this->stock = $tallas[0]->stock;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->click = false;
            $this->message = 'CODIGO INGRESADO NO ES CORRECTO O PRODUCTO NO DISPONIBLE';
            $this->reset(['colores', 'tallas']);
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
            $this->marca = $tallas[0]->nombre_marca;
            $this->stock = $tallas[0]->stock;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->click = false;
            $this->message = 'CODIGO INGRESADO NO ES CORRECTO O PRODUCTO NO DISPONIBLE';
            $this->reset(['colores', 'tallas']);
        }
    }
    public function stockProduct($talla)
    {
        $estilo = $this->estilo;
        $producto = Producto::where('estilo', $estilo)->where('color', $this->color)->where('talla', $this->talla)->first();
        $this->stock = $producto->stock;
    }
    public function clickSimilitud($similitud)
    {
        $this->estilo = $similitud;
        $this->similitudes = [];
        $this->click = true;
        $this->buscarEstilo();
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

            if ($producto->stock >= $this->cantidad) {

                $productSale = $this->pedidos->where('id_producto', $this->selectedItem)->first();

                $diff = ($producto->precio_empresaria * $this->cantidad ) - ($productSale['precio'] * $this->cantidad );

                $diff = number_format($diff, 2);
                $this->nuevoProducto[] = [
                    'id' => $producto->id,
                    'sku' => $producto->sku,
                    'descripcion' => $producto->descripcion,
                    'estilo' => $producto->estilo,
                    'color' => $producto->color,
                    'talla' => $producto->talla,
                    'marca' => $producto->marca->nombre,
                    'cantidad' => $this->cantidad,
                    'precio' => $producto->precio_empresaria,
                    'precio_catalogo' => $producto->precio_empresaria,
                    'total'=> $this->cantidad * $producto->precio_empresaria,
                    'descuento' => 0,
                    'id_pedido' => $productSale->id ,
                    'total_p_empresaria' => ($this->cantidad * $producto->precio_empresaria) - (($this->cantidad * $producto->precio_empresaria) * 0 ) ,

                    'id_producto_original' => $productSale['id_producto'],
                    'precio_producto_venta' => $productSale['precio'],
                    'cantidad_producto_venta' => $productSale['cantidad'],
                    'diferencia' => $diff
                ];

                $originalData = [
                    'id' => $productSale['id_producto'],
                    'sku' => $productSale['producto']['sku'],
                    'descripcion' => $productSale['producto']['descripcion'],
                    'color' => $productSale['producto']['color'],
                    'talla' => $productSale['producto']['talla'],
                    'cantidad' => $productSale['cantidad'],
                    'pvp' => number_format($productSale['precio_catalogo'], 2) ,
                    'descuento' => $productSale['descuento'] * 100 . '%',
                    'p_empresaria' => number_format(($productSale['precio']), 2)
                ];
                $this->changes[] = [
                    'original' => $originalData,
                    'changed' => [
                        'id' => $producto->id,
                        'sku' => $producto->sku,
                        'descripcion' => $producto->descripcion,
                        'estilo' => $producto->estilo,
                        'color' => $producto->color,
                        'talla' => $producto->talla,
                        'marca' => $producto->marca->nombre,
                        'cantidad' => $this->cantidad,
                        'precio' => $producto->precio_empresaria,
                    ]
                ];

                $this->reset('selectedItem', 'selectedItemData','estilo', 'color');

            } else {
                $this->message = 'NO HAY STOCK DISPONIBLE';
            }
            $this->productosACambiar = json_encode($this->productosACambiar);
        } else {
            $this->click = false;
            $this->message = 'VERIFIQUE QUE ESTEN TODOS LOS CAMPOS LLENOS';
        }
        $this->checkShippingCost();
        $this->brandDiscount();
    }

    public function selectItem($itemId)
    {
        $item = $this->pedidos->where('id_producto', $itemId)->first();
        $this->selectedItem = $itemId;
        $this->selectedItemData = [
            'sku' => $item['producto']['sku'],
            'descripcion' => $item['producto']['descripcion'],
            'color' => $item['producto']['color'],
            'talla' => $item['producto']['talla'],
            'cantidad' => $item['cantidad'],
            'pvp' => number_format($item['precio_catalogo'], 2),
            'descuento' => $item['descuento'] * 100 .'%',
            'p_empresaria' => number_format($item['precio'] , 2),
            'cantidad_cambiar'=> $item['cantidad']
        ];
    }


    public function isDisabled($itemId)
    {
        foreach ($this->changes as $change) {
            if ($change['original']['id'] == $itemId) {
                return true;
            }
        }
        return false;
    }


    public function deleteProduct($index)
    {
        $deletedItem = $this->nuevoProducto[$index];

        unset($this->nuevoProducto[$index]);
        $this->nuevoProducto = array_values($this->nuevoProducto); // Reindex array

        foreach ($this->changes as $key => $change) {
            if ($change['original']['id'] == $deletedItem['id_producto_original']) {
                // dd($change['original']['id'], $key, $this->changes[$key] , $this->changes );
                unset($this->changes[$key]);
                break;
            }
        }
        $this->changes = array_values($this->changes); // Reindex array

        $this->checkShippingCost();
        $this->brandDiscount();

    }


    public function saveData()
    {

        return  ;

        //DESCONTAR DEL STOCK CUANDO GURADE, pero si tiene el Id no descontar

        if(!$this->idventa){
            dd("Debe seleccionar un a venta");
        }


        $empresaria = Empresaria::where('id', $this->id_empresaria)->first();

        $data =[
            'id_vendedor' => $empresaria->vendedor,
            'fecha' => date('Y-m-d'),
            'id_empresaria' => $this->id_empresaria,
            'motivo' => $this->descripcionCambio,
            'descripcion' => $this->motivoCambio,
            'f_nombre' => $this->f_nombre,
            'f_cedula' => $this->f_cedula,
            'f_telefono' => $this->f_telefono,
            'f_correo' => $this->f_correo,
            'e_nombre' => $this->e_nombre,
            'e_cedula' => $this->e_cedula,
            'e_telefono' => $this->e_telefono,
            'e_provincia' => $this->e_provincia,
            'e_ciudad' => $this->e_ciudad,
            'e_direccion' => $this->e_direccion,
            'obervaciones' => $this->observaciones,
            'e_pedido' => $this->e_pedido,
            //ver el envio
            'envio' => $this->e_c_envio,
            'id_venta' => $this->idventa,

            //Id Pedido es si tiene un pedido pendiente
            'id_pedido' => null,
        ];
        $cambioPedido = CambioPedido::create($data);

        foreach ($this->nuevoProducto as $key => $value) {
            $productosCambios =  [
                'id_cambio'=>$cambioPedido->id,
                'id_producto'=> $value['id'],
                'cantidad' => $value['cantidad'],
                //ver que va en diferencia
                'diferencia' => 0,
                'fecha'=>date('Y-m-d'),
                'hora'=>date('H:i:s' ),


                'id_pedido'=> $value['id_pedido'],
                'precio'=> $value['precio'],
                'precio_catalogo' => $value['precio_catalogo'],
                'total'=> $value['total'],
                'descuento' => $value['descuento']
            ];


            ProductoCambio::create($productosCambios);
        }
    }



    public function reservarCambio()
    {

        //DESCONTAR DEL STOCK CUANDO GURADE

        if(!$this->idventa){
            dd("Debe seleccionar una venta");
        }

        try {
            DB::beginTransaction();

            $empresaria = Empresaria::where('id', $this->id_empresaria)->first();

            $data =[
                'id_usuario'=> Auth::user()->id,
                'id_vendedor' => $empresaria->vendedor,
                'fecha' => date('Y-m-d'),
                'id_empresaria' => $this->id_empresaria,
                'motivo' => $this->descripcionCambio,
                'descripcion' => $this->motivoCambio,
                'f_nombre' => $this->f_nombre,
                'f_cedula' => $this->f_cedula,
                'f_telefono' => $this->f_telefono,
                'f_correo' => $this->f_correo,
                'e_nombre' => $this->e_nombre,
                'e_cedula' => $this->e_cedula,
                'e_telefono' => $this->e_telefono,
                'e_provincia' => $this->e_provincia,
                'e_ciudad' => $this->e_ciudad,
                'e_direccion' => $this->e_direccion,
                'obervaciones' => $this->observaciones,
                'e_pedido' => $this->e_pedido,
                //ver el envio
                'envio' => $this->envio,
                'id_venta' => $this->idventa,

                //El id Pedido es si tiene un pedido pendiente
                'id_pedido' => $this->id_pedido,
            ];
            $cambioPedido = ReservarCambiosPedido::create($data);

            foreach ($this->nuevoProducto as $key => $value) {
                $productosCambios =  [
                    'id_reservar_cambio_pedido'=>$cambioPedido->id,
                    'id_producto'=> $value['id'],
                    'cantidad' => $value['cantidad'],
                    //ver que va en diferencia
                    'diferencia' => $value['diferencia'],
                    'fecha'=>date('Y-m-d'),
                    'hora'=>date('H:i:s' ),


                    'id_pedido'=> $value['id_pedido'],
                    'precio'=> $value['precio'],
                    'precio_catalogo' => $value['precio_catalogo'],
                    'total'=> $value['total'],
                    'descuento' => $value['descuento']
                ];

                ReservarCambiosDetalle::create($productosCambios);

                $product = Producto::findOrFail($value['id']);
                if($product){
                    $product->stock -= $value['cantidad'] ;
                    // dd($value['cantidad'],$value['id'] , $product->stock );
                    if($product->stock < 0) throw new \Exception('No existe stock.');

                    $product->save();
                }
            }

            DB::commit();
            return redirect()->route('cambio.cambios-reservados');
        } catch (\Exception $th) {
            DB::rollBack();
            dd("Error ", $th);
            //throw $th;
        }



    }



    public function checkShippingCost()
    {

        $productChanges = $this->nuevoProducto ;

        $groupedProducts = [] ;

        foreach ($productChanges as $key => $item) {
            $item = (object) $item ;
            $address = 'NINGUNA' ;

            if (!isset($groupedProducts[$address])) {
                $groupedProducts[$address] = [
                    'precio' => 0,
                    'cantidad' => 0,
                    'productos' => [],
                ];
            }

            $groupedProducts[$address]['precio'] += $item->precio * $item->cantidad;
            $groupedProducts[$address]['cantidad'] += $item->cantidad;
            $groupedProducts[$address]['productos'][] = $item;

        }

        //calculo de envio

        $groupingByCondition = [] ;

        foreach ($groupedProducts as $nameGroup => $group) {
            $groupingByCondition[$nameGroup] = [];
            foreach ($group['productos'] as $key => $product) {

                $productModel = Producto::where('id', $product->id)->with(['marca', 'catalogo'])->first();
                $parameterCatalog = ParametroCatalogo::where('catalogo_id', $productModel->catalogo_id)
                    ->where('estado', 1)
                    ->where('condicion', 'envio_costo')
                    ->orWhere('condicion', 'envio_cantidad')
                    ->orderBy('condicion')
                    ->get();

                foreach ($parameterCatalog as $key => $parameter) {
                    $totalPrice = $product->precio * $product->cantidad ;
                    $condition = $parameter->operador . $parameter->cantidad ;

                    if (!isset($groupingByCondition[$nameGroup][$parameter->id])) {
                        $groupingByCondition[$nameGroup][$parameter->id] = [
                            'total_precio' => 0,
                            'tipo_empresaria' => $parameter->tipo_empresaria,
                            'condicion' => $parameter->condicion,
                            'eval' => $condition,
                            'valor_condicion' => $parameter->valor ,
                            'products' => [],
                        ];
                    }
                    $groupingByCondition[$nameGroup][$parameter->id]['total_precio'] += $totalPrice ;

                }
                $groupingByCondition[$nameGroup][$parameter->id]['products'][] = $product ;
            }
        }

        $shippingCost = 0 ;

        foreach ($groupingByCondition as $nameGroup => $parameter) {
            foreach ($parameter as $parameterId => $parameterDetail) {
                if($parameterDetail['tipo_empresaria'] == 'TODOS' && $parameterDetail['condicion'] == 'envio_costo' ){
                    $parameterDetail['total_precio']  = number_format($parameterDetail['total_precio'], 2, '.', ',');
                    $eval = $parameterDetail['total_precio'] . $parameterDetail['eval'] ;
                    $value = eval("return $eval;") ? $parameterDetail['valor_condicion'] : 0 ;
                    $shippingCost += $value ;
                }
            }
        }

        $this->envio = $this->id_pedido > 0 ? 0 : $shippingCost  ;
        //Si se envia al local Ibizza el envio es cero
        // if($this->e_nombre == 'Local Ibizza'){
        //     $this->envio = 0 ;
        // }

    }



    public function brandDiscount()
    {

        $productChanges = $this->nuevoProducto ;


        $parametersBrand = ParametroMarca::where([
            ['estado', 1],
            ])->get();

        $groupsParameters = [] ;

        foreach ($parametersBrand as $key => $parameter) {
            $groupsParameters[] = [
                'id' => $parameter->id ,
                'nombre' => $parameter->nombre,
                'tipo_empresaria' => $parameter->tipo_empresaria,
                'condicion' => $parameter->condicion,
                'operador' => $parameter->operador,
                'cantidad' => $parameter->cantidad,
                'descuento' => $parameter->descuento ,
                'operador' => $parameter->operador ,
                'total_valor' => 0,
                'total_cantidad' => 0,
                'marcas' => json_decode($parameter->marcas, true),
                'productos' => []
            ];
        }


        foreach ($productChanges as $key => $item) {
            $item = (object) $item ;
            $product = Producto::findOrFail($item->id);
            foreach ($groupsParameters as $keyParameter => $parameter) {
                $flag = collect($parameter['marcas'])->where('categoria', $product->categoria)->first();
                if($flag != null){
                    $groupsParameters[$keyParameter]['productos'][] = [
                        'id' => $product->id,
                        'categoria' =>$product->categoria,
                        'cantidad' => $item->cantidad ,
                        'valor' => $product->precio_empresaria,
                        'descuento' => $flag['descuento']
                    ];
                    $groupsParameters[$keyParameter]['total_valor'] += ( $item->cantidad * $product->precio_empresaria );
                    $groupsParameters[$keyParameter]['total_cantidad'] += $item->cantidad ;
                }
            }
        }


        $groupsParameters = collect($groupsParameters)->filter(function ($item) {
            return $item['tipo_empresaria'] === $this->tipoEmpresaria || $item['tipo_empresaria'] === 'TODOS';
        })->values()->toArray();

        foreach ($productChanges as $keyItem => $item) {
            $item = (object) $item ;

            foreach ($groupsParameters as $key => $parameter) {

                $product = collect($parameter['productos'])->where('id', $item->id)->first();

                $productDB = Producto::findOrFail($item->id);

                //Poner en cero
                $discount = 0 ;
                $price = $productDB->precio_empresaria ;

                if($product){

                    if ($parameter['tipo_empresaria'] == $this->tipoEmpresaria) {

                        if ($parameter['condicion'] == 'cantidad') {
                            $condition = $parameter['total_cantidad'] . $parameter['operador'] . $parameter['cantidad'];

                            $discount = eval("return $condition;") ? $product['descuento'] : 0;
                            $discount = $discount / 100;

                        }

                        if ($parameter['condicion'] == 'factura') {
                            $condition = $parameter['total_valor'] . $parameter['operador'] . $parameter['cantidad'];
                            $discount = eval("return $condition;") ?$product['descuento'] : 0;
                            $discount = $discount / 100;
                        }

                    }elseif($parameter['tipo_empresaria'] == 'TODOS'){
                        if ($parameter['condicion'] == 'cantidad') {
                            $condition = $parameter['total_cantidad'] . $parameter['operador'] . $parameter['cantidad'];

                            $discount = eval("return $condition;") ?$product['descuento'] : 0;
                            $discount = $discount / 100;
                        }

                        if ($parameter['condicion'] == 'factura') {
                            $condition = $parameter['total_valor'] . $parameter['operador'] . $parameter['cantidad'];
                            $discount = eval("return $condition;") ?$product['descuento'] : 0;
                            $discount = $discount / 100;
                        }
                    }

                    //Aqui debe ir

                    //MOver
                    $price = (float)$productDB->precio_empresaria - ($productDB->precio_empresaria * $discount);
                    $precioCambioTotal = round($price, 2) * $productChanges[$keyItem]['cantidad'];
                    $precioVentaTotal =  (round($productChanges[$keyItem]['precio_producto_venta'], 2) * $productChanges[$keyItem]['cantidad']);
                    $precioDiff =  $precioCambioTotal -  $precioVentaTotal ;
                    
                    $productChanges[$keyItem]['descuento'] = $discount;
                    $productChanges[$keyItem]['precio'] = round($price, 2);
                    $productChanges[$keyItem]['diferencia'] = $precioDiff ;
                    $productChanges[$keyItem]['total_p_empresaria'] = round($price, 2) * $productChanges[$keyItem]['cantidad'];
       

                }

            }
        }

        $this->nuevoProducto = $productChanges ;

    }

}
