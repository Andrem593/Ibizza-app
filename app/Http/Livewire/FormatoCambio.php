<?php

namespace App\Http\Livewire;

use App\Producto;
use App\Empresaria;
use App\Models\CambioPedido;
use App\Models\Ciudad;
use App\Models\ParametroCatalogo;
use App\Models\ParametroMarca;
use App\Models\ProductoCambio;
use App\Models\Provincia;
use App\Models\ReservarCambiosDetalle;
use App\Models\ReservarCambiosPedido;
use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FormatoCambio extends Component
{
    public $estilo, $colores, $tallas, $message, $color, $talla, $cantidad, $alert, $stock, $cliente, $similitudes, $click = false, $motivoCambio, $descripcionCambio, $e_referencia;
    public $venta, $user, $empresarias, $tipoEmpresaria, $click2 = false, $marca, $id_empresaria, $emp;
    public $idventa, $pedidos, $productosACambiar, $nuevoProducto = [];
    public $f_nombre, $f_cedula, $f_telefono, $f_correo, $f_tipo_id;
    public $e_nombre, $e_cedula, $e_telefono, $e_provincia, $e_ciudad, $e_direccion, $e_pedido, $e_c_envio, $ciudad_id, $provincia_id, $e_tipo_id;
    public $envio = 0 ;
    public $n_factura ;
    public $id_pedido = "" ;
    public $selectedItems = [];

    public $descripcion_producto = "";

    public $provincias = [];

    public $provincia ;

    public $ciudades = [] ;

    public $cantidadVenta ;

    public $mensajeError;

    public $mensajeCambio;


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

    protected $listeners = ['openModal', 'closeModal', 'reservarCambio','saveData'];

    public $changes = [];

    public $isOpen = false;

    public $idCambio = null ;

    public $idVerificate = null ;



    public function updatedProvinciaId($id)
    {
        $this->ciudades =  Ciudad::where('provincia_id', $id)->get();
    }

    public function updatedIdPedido($value)
    {


        $this->checkShippingCostChange();

    }

    public function updatedEPedido($value)
    {
        $limitDate = Carbon::now()->subDays(6);
        $this->id_pedido ='' ;
        $this->mensajeError = null ;
        if($value != ''){
            $sale = Venta::where('id', $value)
            ->whereDate('created_at', '>=', $limitDate)
            ->first();

            // Si no se encuentra el pedido, mostrar un mensaje de error
            if (!$sale) {
                $this->mensajeError = "El pedido con ID {$value} no existe o su fecha de creación no está dentro de los últimos 6 días.";
            } else {
                $this->mensajeError = null; // Limpiar el mensaje si el pedido existe
                if($this->descripcionCambio === 'AVERIA'){
                    $this->id_pedido = 'NO';

                }
            }

        }else{
            if($this->descripcionCambio === 'AVERIA'){
                $this->id_pedido = 'Si';

            }

        }


        $this->checkShippingCostChange();

    }


    public function updatedDescripcionCambio($value)
    {
        // Verificar si el motivo de cambio es "AVERIA"
        $this->id_pedido = '';
        if ($value === 'AVERIA' && $this->mensajeError == null && $this->e_pedido != '') {
            $this->id_pedido = 'NO';
            $this->mensajeCambio = "El producto está siendo cambiado por AVERIA.";
        } else {
            if($value === 'AVERIA' && ($this->e_pedido == '' || $this->e_pedido == null)){
                $this->id_pedido = 'SI';
            }
            $this->mensajeCambio = null; // Limpiar el mensaje si el motivo cambia
        }
        $this->checkShippingCostChange();
    }

    public function updatedENombre($value)
    {

        $this->checkShippingCostChange();

    }

    public function mount()
    {
        $changeOrder = CambioPedido::orderBy('id', 'desc')->first();
        $this->idCambio = $changeOrder ? $changeOrder->id + 1 : 1 ;

        $this->idCambio = '0000'.$this->idCambio ;

        $this->provincias = Provincia::get();
        $id = Session::get('id', null);

        $this->idVerificate = $id ;
        Session::forget('id');
        if($id){
            $reserveChangesOrder = ReservarCambiosPedido::findOrFail($id);
            if($reserveChangesOrder){
                $this->f_nombre = $reserveChangesOrder->f_cedula ;
                $this->f_cedula = $reserveChangesOrder->f_cedula ;
                $this->f_telefono = $reserveChangesOrder->f_telefono ;
                $this->f_correo = $reserveChangesOrder->f_correo ;
                $this->n_factura = $reserveChangesOrder->n_factura ;
                $this->f_tipo_id = $reserveChangesOrder->f_tipo_id ;

                //Preguntarla Fceha
                // $this->fecha = ;
                $this->id_empresaria =  $reserveChangesOrder->id_empresaria ;
                $this->id_pedido =  $reserveChangesOrder->id_pedido ;
                $this->descripcionCambio = $reserveChangesOrder->motivo ;
                $this->motivoCambio = $reserveChangesOrder->descripcion ;

                $this->provincia_id = $reserveChangesOrder->provincia_id ;
                $this->ciudades =  Ciudad::where('provincia_id', $this->provincia_id)->get();
                $this->ciudad_id = $reserveChangesOrder->ciudad_id ;


                $this->e_nombre = $reserveChangesOrder->e_nombre ;
                $this->e_cedula = $reserveChangesOrder->e_cedula ;
                $this->e_telefono = $reserveChangesOrder->e_telefono ;
                $this->e_provincia = $reserveChangesOrder->e_provincia ;
                $this->e_ciudad = $reserveChangesOrder->e_ciudad ;
                $this->e_direccion = $reserveChangesOrder->e_direccion ;
                $this->e_referencia = $reserveChangesOrder->e_referencia ;
                $this->e_pedido = $reserveChangesOrder->e_pedido ;
                $this->e_tipo_id = $reserveChangesOrder->e_tipo_id ;

                $this->e_c_envio = $reserveChangesOrder->envio ;
                $this->idventa = $reserveChangesOrder->id_venta ;

                $empresaria = Empresaria::findOrFail($this->id_empresaria);


                $this->cliente = $empresaria->nombre_completo;
                $this->tipoEmpresaria = $empresaria->tipo_cliente;

                $this->id_pedido = $reserveChangesOrder->id_pedido ;

                // $this->emp = Empresaria::with('pedidos', 'usuario', 'ciudad')->find($this->id_empresaria);

                $this->buscarVenta() ;

                $this->getReservedChangeDetail($id);

                $this->brandDiscount();

                $this->checkShippingCostChange();

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
                'total'=> $detail->precio_catalogo * $detail->cantidad,
                'descuento' => $detail->descuento,
                'id_pedido' => $detail->id_pedido ,
                'total_p_empresaria' => $detail->total - ($detail->total * $detail->descuento),

                'id_producto_original' => $detail->order->producto->id,
                'precio_producto_venta' => $detail->precio_producto_venta,
                'precio_catalogo_producto_venta' => $detail->precio_catalogo_producto_venta,
                'descuento_venta' => $detail->descuento_venta ,
                'cantidad_producto_venta' => $detail->cantidad_producto_venta,
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
            if ($this->user->role == 'ADMINISTRADOR' || $this->user->role == 'Administrador') {                
                $this->empresarias = Empresaria::with('pedidos')->where(function ($query) {
                    $query->where('cedula', 'like', '%' . $this->cliente . '%')
                    ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ['%' . $this->cliente . '%']);
                })
                    ->where('estado', 'A')
                    ->limit(20)
                    ->get();
            }else{
                $this->empresarias = Empresaria::with('pedidos')->where(function ($query) {
                    $query->where('cedula', 'like', '%' . $this->cliente . '%')
                    ->orWhereRaw("CONCAT(nombres, ' ', apellidos) LIKE ?", ['%' . $this->cliente . '%']);
                })
                    ->where('estado', 'A')
                    ->where('vendedor', $this->user->id)
                    ->limit(20)
                    ->get();
            }
        }

        if (!empty($this->estilo) && !$this->click) {
            $this->similitudes = Producto::distinct()->where('estilo', 'like', '%' . $this->estilo . '%')
            ->where('categoria', '<>', 'PREMIOS')
            ->where('estado', 'A')
            ->select('estilo')->get();
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
            $this->f_tipo_id = $this->emp->tipo_id ;
        }

    }

    public function getShippingDataBusinesswoman()
    {
        if($this->id_empresaria !=''){
            $this->emp = Empresaria::with('pedidos', 'usuario', 'ciudad')->find($this->id_empresaria);
            $this->e_nombre = $this->emp->nombres . ' ' . $this->emp->apellidos;
            $this->e_cedula = $this->emp->cedula;
            $this->e_telefono = $this->emp->telefono;
            $this->e_tipo_id = $this->emp->tipo_id ;
            if ($this->emp->ciudad) {
                $this->provincia_id = $this->emp->ciudad->provincia->id ;
                $this->ciudades =  Ciudad::where('provincia_id', $this->provincia_id)->get();
                $this->ciudad_id = $this->emp->ciudad->id ;
                $this->e_provincia = $this->emp->ciudad->provincia->descripcion;
                $this->e_ciudad = $this->emp->ciudad->descripcion;
            }
            $this->e_direccion = $this->emp->direccion;
            $this->e_referencia = $this->emp->referencia;
        }
        $this->checkShippingCostChange();

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
        $this->f_tipo_id = $this->emp->tipo_id ;

        $this->e_nombre = $this->emp->nombres . ' ' . $this->emp->apellidos;
        $this->e_cedula = $this->emp->cedula;
        $this->e_telefono = $this->emp->telefono;
        $this->e_tipo_id = $this->emp->tipo_id ;


        if ($this->emp->ciudad) {
            $this->provincia_id = $this->emp->ciudad->provincia->id ;
            $this->ciudades =  Ciudad::where('provincia_id', $this->provincia_id)->get();
            $this->ciudad_id = $this->emp->ciudad->id ;

            $this->e_provincia = $this->emp->ciudad->provincia->descripcion;
            $this->e_ciudad = $this->emp->ciudad->descripcion;
        }
        $this->e_direccion = $this->emp->direccion;
        $this->e_referencia = $this->emp->referencia;
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
        $this->e_referencia = '';
        $this->e_pedido = '';
        $this->e_c_envio = '';

        $this->checkShippingCostChange();
    }

    public function nuevosDatosLoc()
    {
        $this->e_nombre = 'Local Ibizza';
        $this->e_provincia = 'Guayas';
        $this->e_ciudad = 'Guayaquil';
        $this->e_direccion = 'Calle chile y Luque';
        $this->e_referencia = 'Frente a De Prati';
        $city = Ciudad::where('descripcion', 'GUAYAQUIL')->first() ;

        $this->provincia_id = $city->provincia_id ;
        $this->ciudades =  Ciudad::where('provincia_id', $this->provincia_id)->get();
        $this->ciudad_id = $city->id ;

        $this->envio = 0 ;
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
            $venta = Venta::where('id', $this->idventa)->where('id_empresaria', $this->id_empresaria)
                ->with('pedidos')
                ->first();


            $this->venta = $venta ;

            $this->pedidos = $this->venta->pedidos;

            $this->n_factura = null ;
            if($venta){
                $this->n_factura = $venta->n_factura;

            }

        } catch (\Throwable $th) {
            $this->n_factura = null ;
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
                ->where('categoria', '<>', 'PREMIOS')
                ->get();
            $tallas = Producto::where('estilo', $estilo)
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca')
                ->where('color', $colores[0]->color)
                ->where('productos.estado', 'A')
                ->where('productos.stock', '>', 0)
                ->where('categoria', '<>', 'PREMIOS')
                ->distinct('talla')
                ->get();
            $this->colores = $colores;
            $this->tallas = $tallas;
            $this->descripcion_producto = $tallas[0]->descripcion;
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
                ->where('categoria', '<>', 'PREMIOS')
                ->where('productos.estado', 'A')->get();
            $this->tallas = $tallas;
            $this->talla = $tallas[0]->talla;
            $this->descripcion_producto = $tallas[0]->descripcion; //Se agrega propiedad para capturar la descripción del producto
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
        $producto = Producto::where('estilo', $estilo)->where('color', $this->color)->where('talla', $this->talla)
            ->where('estado', 'A')
            ->where('stock', '>', 0)
            ->where('categoria', '<>', 'PREMIOS')
            ->first();
        $this->stock = $producto->stock;
        $this->descripcion_producto = $producto->descripcion; //Se agrega propiedad para capturar la descripción del producto

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
                ->where('categoria', '<>', 'PREMIOS')
                ->with(['marca', 'catalogo'])
                ->first();


            if ($producto && ($producto->stock >= $this->cantidad)) {
                try {

                    DB::beginTransaction();

                    $productSale = $this->pedidos->where('id_producto', $this->selectedItem)->first();

                    $productSalesInformation = Producto::findOrFail($productSale['id_producto']);

                    $discountPriceSale = $productSalesInformation->precio_empresaria - ($productSalesInformation->precio_empresaria * $productSale['descuento'] );

                    $diff = ($producto->precio_empresaria * $this->cantidad ) - ($productSale['precio'] * $this->cantidad );

                    $diff = $diff < 0 ? 0 : $diff ;

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
                        'total_p_empresaria' => 0,

                        'id_producto_original' => $productSale['id_producto'],
                        'precio_producto_venta' =>$discountPriceSale,
                        'precio_catalogo_producto_venta' => $productSalesInformation->precio_empresaria * $this->cantidad,
                        'descuento_venta' =>$productSale['descuento'],
                        'cantidad_producto_venta' => $this->cantidadVenta,
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


                    $productStock = Producto::findOrFail($producto->id);
                    if($productStock){
                        $productStock->stock -= $this->cantidad;
                        if($productStock->stock < 0) throw new \Exception('No existe stock.');
                        $productStock->save();
                    }
                    DB::commit();

                    $this->reset('selectedItem', 'selectedItemData','estilo', 'color');

                } catch (\Throwable $th) {
                    DB::rollBack();
                    $this->message = $th;

                }

            } else {
                $this->message = 'NO HAY STOCK DISPONIBLE';
            }
            $this->productosACambiar = json_encode($this->productosACambiar);
        } else {
            $this->click = false;
            $this->message = 'VERIFIQUE QUE ESTEN TODOS LOS CAMPOS LLENOS';
        }
        $this->brandDiscount();
        $this->checkShippingCostChange();
    }

    public function selectItem($itemId)
    {
        $item = $this->pedidos->where('id_producto', $itemId)->first();
        $this->selectedItem = $itemId;
        $this->cantidadVenta = 1;
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
        try {

            DB::beginTransaction();
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

            $this->brandDiscount();
            $this->checkShippingCostChange();

            $product = Producto::findOrFail($deletedItem['id']);
            if($product){
                $product->stock += $deletedItem['cantidad'];
                $product->save();
            }

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            dd("Error");
            $this->message = 'Ha ocurrido un error al eleiminar';
        }

    }


    public function saveData()
    {
        $this->message = '';

        if(!$this->idventa){
            $this->message = 'Debe seleccionar una Venta';
            return ;
        }

        if($this->mensajeError != null){
            $this->message = 'El Pedido no existe';
            return ;
        }

        try {
            DB::beginTransaction();

            $empresaria = Empresaria::where('id', $this->id_empresaria)->first();

            $data =[
                'n_factura'=> $this->n_factura ,
                'id_usuario'=> Auth::user()->id,
                'id_vendedor' => $empresaria->vendedor,
                'fecha' => date('Y-m-d'),
                'fecha_vencimiento' => $this->addBusinessDays(date('Y-m-d'), 3),
                'id_empresaria' => $this->id_empresaria,
                'motivo' => $this->descripcionCambio,
                'descripcion' => $this->motivoCambio,
                'f_nombre' => $this->f_nombre,
                'f_cedula' => $this->f_cedula,
                'f_telefono' => $this->f_telefono,
                'f_correo' => $this->f_correo,

                'f_tipo_id' => $this->f_tipo_id,

                'e_nombre' => $this->e_nombre,
                'e_cedula' => $this->e_cedula,
                'e_telefono' => $this->e_telefono,
                'e_provincia' => $this->e_provincia,
                'e_ciudad' => $this->e_ciudad,
                'e_direccion' => $this->e_direccion,
                'e_pedido' => $this->e_pedido,

                'e_tipo_id' => $this->e_tipo_id ,
                'provincia_id' => $this->provincia_id ,
                'ciudad_id' => $this->ciudad_id ,


                'referencia' => $this->e_referencia,
                //ver el envio
                'envio' => $this->envio,
                'total' =>number_format(collect($this->nuevoProducto)->sum('diferencia'),2),
                'total_pagar'=> number_format(collect($this->nuevoProducto)->sum('diferencia') + $this->envio ,2),
                'id_venta' => $this->idventa == 0 ? null : $this->idventa,

                //El id Pedido es si tiene un pedido pendiente
                'id_pedido' => $this->id_pedido == 0 ? null : $this->id_pedido,
                'estado' =>'PENDIENTE DE PAGO'
            ];

            $changeOrder = CambioPedido::create($data);

            foreach ($this->nuevoProducto as $key => $value) {
                $productsChanges =  [
                    'id_cambio'=>$changeOrder->id,
                    'id_producto'=> $value['id'],
                    'cantidad' => $value['cantidad'],
                    'diferencia' => $value['diferencia'],
                    'fecha'=>date('Y-m-d'),
                    'hora'=>date('H:i:s' ),
                    'id_pedido'=> $value['id_pedido'],
                    'precio'=> $value['precio'],
                    'precio_catalogo' => $value['precio_catalogo'],
                    'total'=> number_format ($value['precio'] * $value['cantidad'] ,2),
                    'descuento' => $value['descuento'],
                    'precio_producto_venta'=> $value['precio_producto_venta'],
                    'descuento_venta'=> $value['descuento_venta'],
                    'precio_catalogo_producto_venta'=> $value['precio_catalogo_producto_venta'],
                    'cantidad_producto_venta'=> $value['cantidad_producto_venta'],
                    //Poner la otra Variable
                ];
                ProductoCambio::create($productsChanges);
            }
            if($this->idVerificate){
                $reserveChangesOrder = ReservarCambiosPedido::findOrFail($this->idVerificate);
                $reserveChangesOrder->estado = 2 ;
                $reserveChangesOrder->save();
            }

            DB::commit();

            return redirect()->route('cambios.index');
            // return redirect()->route('cambio.cambios-reservados');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->message = 'Ha oacurrido un Error';
        }

    }



    public function reservarCambio()
    {

        $this->message='' ;

        if(!$this->idventa){
            $this->message = 'Debe seleccionar una Venta';
            return ;
        }

        if($this->mensajeError != null){
            $this->message = 'El Pedido no existe';
            return ;
        }


        try {
            DB::beginTransaction();

            $empresaria = Empresaria::where('id', $this->id_empresaria)->first();

            $data =[
                'n_factura'=> $this->n_factura ,
                'id_usuario'=> Auth::user()->id,
                'id_vendedor' => $empresaria->vendedor,
                'fecha' => date('Y-m-d'),
                'fecha_vencimiento' => $this->addBusinessDays(date('Y-m-d'), 3),
                'id_empresaria' => $this->id_empresaria,
                'motivo' => $this->descripcionCambio,
                'descripcion' => $this->motivoCambio,
                'f_nombre' => $this->f_nombre,
                'f_cedula' => $this->f_cedula,
                'f_telefono' => $this->f_telefono,
                'f_correo' => $this->f_correo,

                'f_tipo_id' => $this->f_tipo_id,

                'e_nombre' => $this->e_nombre,
                'e_cedula' => $this->e_cedula,
                'e_telefono' => $this->e_telefono,
                'e_provincia' => $this->e_provincia,
                'e_ciudad' => $this->e_ciudad,
                'e_direccion' => $this->e_direccion,
                'e_pedido' => $this->e_pedido,

                'e_tipo_id' => $this->e_tipo_id ,
                'provincia_id' => $this->provincia_id ,
                'ciudad_id' => $this->ciudad_id ,


                'e_referencia' => $this->e_referencia,
                //ver el envio
                'envio' => $this->envio,
                'total' =>number_format(collect($this->nuevoProducto)->sum('diferencia'),2),
                'total_pagar'=> number_format(collect($this->nuevoProducto)->sum('diferencia') + $this->envio ,2),
                'id_venta' => $this->idventa == 0 ? null : $this->idventa,

                //El id Pedido es si tiene un pedido pendiente
                'id_pedido' => $this->id_pedido == 0 ? null : $this->id_pedido


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
                    'total'=> number_format ($value['precio'] * $value['cantidad'] ,2),
                    'descuento' => $value['descuento'],

                    'precio_producto_venta'=> $value['precio_producto_venta'],
                    'precio_catalogo_producto_venta'=> $value['precio_catalogo_producto_venta'],
                    'descuento_venta'=> $value['descuento_venta'],
                    'cantidad_producto_venta'=> $value['cantidad_producto_venta'],
                ];

                ReservarCambiosDetalle::create($productosCambios);
            }

            if($this->idVerificate){
                ReservarCambiosDetalle::where('id_reservar_cambio_pedido', $this->idVerificate)->delete() ;
                ReservarCambiosPedido::findOrFail($this->idVerificate)->delete();
            }
            DB::commit();
            return redirect()->route('cambio.cambios-reservados');
        } catch (\Exception $th) {
            DB::rollBack();
            dd("Error ", $th);
        }
    }



    function addBusinessDays($date, $days)
    {
        $date = Carbon::parse($date);
        while ($days > 0) {
            $date->addDay();
            // Si el día no es sábado (6) ni domingo (0), decrementamos los días hábiles restantes
            if (!$date->isWeekend()) {
                $days--;
            }
        }
        return $date->format('Y-m-d');
    }


    public function checkShippingCostChange()
    {
        if(trim($this->e_pedido) != '' || trim($this->id_pedido) != '' || trim($this->e_nombre) == 'Local Ibizza'){
            $this->envio = 0 ;
        }else{
            $this->envio = 3 ;
        }
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

                    $precioDiff = $precioDiff < 0 ? 0 : $precioDiff ;

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
