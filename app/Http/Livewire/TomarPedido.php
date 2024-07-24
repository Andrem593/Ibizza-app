<?php

namespace App\Http\Livewire;

use Cart;
use App\Catalogo;
use App\Producto;
use App\Empresaria;
use App\Models\Marca;
use App\Models\Venta;
use App\Models\Ciudad;
use App\Models\CondicionPremio;
use App\Models\Oferta;
use Livewire\Component;
use App\Models\Separado;
use App\Models\Provincia;
use App\Models\ParametroMarca;
use App\Models\LogStockFaltante;
use App\Models\ParametroCatalogo;
use App\Models\Pedidos_pendiente;
use App\Models\Premio_has_Producto;
use App\Models\PremioAcumuladoEmpresaria;
use App\Premio;
use Illuminate\Support\Facades\Auth;
use PremioHasProductos;

class TomarPedido extends Component
{
    public $estilo, $colores, $tallas, $message, $color, $talla, $cantidad, $alert, $stock, $cliente, $similitudes, $descripcion_producto, $click = false;

    public $venta, $user, $empresarias, $tipoEmpresaria, $click2 = false, $marca, $id_empresaria, $emp;

    public $provincias, $ciudades, $sku;

    public $nombre, $telefono, $provincia, $ciudad, $direccion, $referencia;

    public $localDpisar = false;

    public $envio = 0;

    public $premiosEmpresaria = [] ;

    public $productosPremios = [];

    public $countProductosPremios = 0 ;

    public $imagen = 'https://catalogoibizza.com/img/imagen-no-disponible.jpg';

    protected $listeners = ['change' => 'buscarColor', 'guardarDatos', 'aceptarAccion', 'cerrarVenta', 'showModal' => 'openModal'];

    public $flagPrize = false;

    public $showModal = false;

    public $direccionData = [
        'rowId' => null,
        'identificacion' => '',
        'nombre' => '',
        'telefono' => '',
        'direccion' => '',
        'referencia' => ''
    ];


    public function openModal($id)
    {
        $this->direccionData = [
            'rowId' => $id,
            'identificacion' => '',
            'nombre' => '',
            'telefono' => '',
            'direccion' => '',
            'referencia' => ''
        ];
        $this->showModal = true;
        $this->emit('showModalJs');
    }


    public function render()
    {
        $venta = Venta::orderBy('id', 'desc')->first();
        $venta = $venta == null ?0 : $venta->id;
        $this->venta = sprintf('%06d', $venta + 1);
        $this->user = Auth::user();
        if ($this->localDpisar) {
            $this->direccionData = [
                'rowId' => $this->direccionData['rowId'],
                'identificacion' => null,
                'nombre' => 'LOCAL DPISAR',
                'telefono' => '0963725427',
                'direccion' => 'Calle 10 de agosto y Pedro Carbo',
                'referencia' => 'Calle 10 de agosto y Pedro Carbo'
            ];
        }
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
                ->limit(100)
                ->get();
        }

        $this->provincias = Provincia::get();

        if (!empty($this->estilo) && !$this->click) {
            $this->similitudes = Producto::distinct()->where('estilo', 'like', '%' . $this->estilo . '%')
                ->where('estado', 'A')
                ->where('stock', '>', 0)
                ->select('estilo')
                ->limit(50)
                ->get();
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
            $this->descripcion_producto = $tallas[0]->descripcion; //Se agrega propiedad para capturar la descripción del producto
            $this->color = $colores[0]->color;
            $this->marca = $tallas[0]->nombre_marca;
            $this->talla = $tallas[0]->talla;
            $this->stock = $tallas[0]->stock;
            $this->imagen = empty($colores[0]->imagen_path) ?$this->imagen : '../storage/images/productos/' . $colores[0]->imagen_path;
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
                ->where('productos.stock', '>', 0)
                ->where('productos.estado', 'A')
                ->distinct('talla')->get();
            $this->tallas = $tallas;
            $this->talla = $tallas[0]->talla;
            $this->descripcion_producto = $tallas[0]->descripcion; //Se agrega propiedad para capturar la descripción del producto
            $this->marca = $tallas[0]->nombre_marca;
            $this->stock = $tallas[0]->stock;
            $this->imagen = empty($tallas[0]->imagen_path) ?$this->imagen : '../storage/images/productos/' . $tallas[0]->imagen_path;
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
                ->where('stock', '>', 0)
                ->with(['marca', 'catalogo'])
                ->first();

            $parametros = ParametroCatalogo::where('catalogo_id', $producto->catalogo->catalogo_id)
                ->where('estado', 1)
                ->orderBy('condicion')
                ->get();

            if ($producto->stock >= $this->cantidad) {
                $precio = $producto->precio_empresaria;
                $descuento = 0;

                // $data = $this->validacionReglas($producto, $descuento, $precio, $parametros, $this->cantidad + Cart::count(), $this->envio, 'suma', 1, $this->cantidad);

                // $descuento = $data['descuento'];
                // $precio = $data['precio'];
                try {
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
                $this->verificarOfertas(0);
                $this->OfertaClasificacion();
                $this->brandDiscount();
                $this->checkShippingCost();
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



    public function VerificarOfertaXProducto2($productosOferta, $oferta)
    {

        $cartItems = Cart::content();
        // dd($cartItems);

        foreach ($cartItems as $keyItem => $item) {
            $item1Cart = Cart::get($item->rowId);
            if ($item1Cart ) {

                $producto = Producto::with(['marca', 'catalogo'])->findOrFail($item->id);

                $price = $producto->precio_empresaria;

                $options = $item1Cart->options->toArray();
                $options['pCatalogo'] = $price;
                unset($options['promo']);
                unset($options['premio']);
                unset($options['oferta']);
                unset($options['tipo']);

                Cart::update($item1Cart->rowId, [
                    'qty' => $item1Cart->qty,
                    'price' => round($price, 2),
                    'options' => $options
                ]);
            }
        }

        $carItems = Cart::content();
        $productosAgrupados = [];
        foreach ($carItems as $key => $item) {
            $producto = Producto::where('id', $item->id)->first();
            if (!$item->options->promo) {
                if (!isset($productosAgrupados[$producto->estilo])) {
                    $productosAgrupados[$producto->estilo] = [
                        'precio' => 0,
                        'cantidad' => 0,
                        'estilo' => $producto->estilo,
                        'color' => $producto->color,
                        'productos' => [],
                    ];
                }
                $productosAgrupados[$producto->estilo]['precio'] += $producto->precio_empresaria * $item->qty;
                $productosAgrupados[$producto->estilo]['cantidad'] += $item->qty;
                $productosAgrupados[$producto->estilo]['productos'][] = $item;
            }
        }


        if($oferta->tipo_premio == 2) {

            $groupOfertas =  collect($productosOferta)->groupBy('cantidad') ;

            $nGroup = [] ;

            $cartItems = Cart::content();

            foreach ($groupOfertas as $cantidad => $detailOferta) {
                $nGroup[$cantidad] = [
                    'productos_oferta' => $detailOferta ,
                    'cantidad_oferta' => $cantidad ,
                    'productos' => [],
                    'cantidad' => 0
                ];

                foreach ($cartItems as $key => $item) {
                    $producto = Producto::with(['marca', 'catalogo'])->findOrFail($item->id);
                    $result =  $detailOferta->where('estilo', $producto->estilo )->where('color', $producto->color)->first() ;

                    if($result){
                        $nGroup[$cantidad]['cantidad'] += $item->qty ;
                        $nGroup[$cantidad]['productos'][] = $item ;
                    }
                }
            }


            foreach ($nGroup as $key => $group) {

                if($group['cantidad'] >= $group['cantidad_oferta']){
                    $cantidadDePremios = intdiv($group['cantidad'], $group['cantidad_oferta']);
                    $premios = json_decode($oferta->premios);

                    foreach ($premios as $keyPremio => $premio) {

                        $productoPremio = Producto::where('estilo', $premio->estilo)->where('color', $premio->color)
                        ->where('estado', 'A')
                        ->where('stock', '>', 0)
                        ->first();

                        if($productoPremio){
                            $verifycart = $cartItems->where('id', $premio->id)->first() ;
                            if($verifycart){
                                $ncant = ($premio->cantidad * $cantidadDePremios) ;
                                $nstock = $ncant - $verifycart->qty ;
                                if($ncant > $verifycart->qty){
                                    $options = $verifycart->options->toArray();
                                    Cart::update($verifycart->rowId, [
                                        'qty' => $ncant,
                                        'price' => $verifycart->price,
                                        'options' => $options
                                    ])->associate('App\Models\Producto');

                                    $productoPremio->update(['stock' => $productoPremio->stock - $nstock ]);

                                }
                                //verifico para Actualizar

                            }else{
                                //Procedo a Crear
                                Cart::add(
                                    $productoPremio->id,
                                    $productoPremio->descripcion,
                                    $premio->cantidad * $cantidadDePremios,
                                    0,
                                    [
                                        'sku' => $productoPremio->sku, 'color'  => $productoPremio->color, 'talla' => $productoPremio->talla, 'marca' => $productoPremio->marca->nombre,
                                        'descuento' => 0, 'pCatalogo' => $productoPremio->precio_empresaria, 'promo' => true, 'premio' => true
                                    ]
                                )->associate('App\Models\Producto');

                                $productoPremio->update(['stock' => $productoPremio->stock - $premio->cantidad]);
                            }

                        }else{
                            $this->message = 'NO HAY STOCK DISPONIBLE PARA EL PREMIO';
                            break;

                        }
                    }
                }
                // dd($group);
            }

            // dd(collect($productosOferta)->groupBy('cantidad'));

            // $cartItems = Cart::content();

            // $tCant = 0 ;
            // foreach ($cartItems as $key2 => $item) {

            //     $producto = Producto::with(['marca', 'catalogo'])->findOrFail($item->id);

            //     $ofert = collect($productosOferta)->where('estilo', $producto->estilo )->where('color', $producto->color)->first();

            //     if($ofert){
            //         $tCant += $item->qty;
            //     }

            // }




            // foreach ($productosOferta as $key => $productoOferta) {
            //     foreach ($productosAgrupados as $key2 => $item) {
            //         if ($item['estilo'] == $productoOferta->estilo ){
            //             if ($item['cantidad'] >= $productoOferta->cantidad) {
            //                 $premios = json_decode($oferta->premios);
            //                 $cantidadDePremios =  intdiv($item['cantidad'], $productoOferta->cantidad);


            //                 foreach ($premios as $key => $premio) {
            //                     $producto = Producto::where('estilo', $premio->estilo)->where('color', $premio->color)
            //                         ->where('estado', 'A')
            //                         ->where('stock', '>', 0)
            //                         ->first();



            //                     if ($producto) {

            //                         $ncant = $premio->cantidad * $cantidadDePremios ;
            //                         $result = $carItems->where('id', $producto->id )->first() ;

            //                         if ($result){

            //                             $item1Cart = Cart::get($result->rowId);

            //                             if($item1Cart){
            //                                 $nstock = $ncant - $item1Cart->qty ;
            //                                 if($ncant > $item1Cart->qty ){


            //                                     $options = $item1Cart->options->toArray();
            //                                     Cart::update($item1Cart->rowId, [
            //                                         'qty' => $ncant,
            //                                         'price' => $item1Cart->price,
            //                                         'options' => $options
            //                                     ])->associate('App\Models\Producto');

            //                                     $producto->update(['stock' => $producto->stock - $nstock ]);

            //                                 }

            //                             }

            //                         }else{

            //                             // dump($cantidadDePremios, $premio->cantidad , $cantidadDePremios);
            //                             Cart::add(
            //                                 $producto->id,
            //                                 $producto->descripcion,
            //                                 $premio->cantidad * $cantidadDePremios,
            //                                 0,
            //                                 [
            //                                     'sku' => $producto->sku, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
            //                                     'descuento' => 0, 'pCatalogo' => $producto->precio_empresaria, 'promo' => true, 'premio' => true
            //                                 ]
            //                             )->associate('App\Models\Producto');

            //                             $producto->update(['stock' => $producto->stock - $premio->cantidad]);

            //                         }
            //                     } else {
            //                         $this->message = 'NO HAY STOCK DISPONIBLE PARA EL PREMIO';
            //                         break;
            //                     }
            //                 }

            //                 foreach ($item['productos'] as $key => $pro) {
            //                     Cart::update($pro->rowId, ['options' => [
            //                         'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
            //                         'descuento' => $pro->options->descuento, 'pCatalogo' => $pro->options->pCatalogo, 'promo' => true
            //                     ]]);
            //                 }
            //             }
            //         }
            //     }

            // }

        }

        if ($oferta->tipo_premio == 1) {

            foreach ($productosOferta as $key => $productoOferta) {
                foreach ($productosAgrupados as $key2 => $item) {
                    if ($item['estilo'] == $productoOferta->estilo && $item['color'] == $productoOferta->color) {
                        if ($item['cantidad'] >= $productoOferta->cantidad) {
                            $this->aplicarOferta2($productoOferta, $oferta, $item);
                        }
                        //Aqui debe de ser la condicion
                    }
                }
            }
        }
    }


    public function aplicarOferta2($productoOferta, $oferta, $item)
    {
        $premios = json_decode($oferta->premios);
        $cantidadDePremios =  intdiv($item['cantidad'], $productoOferta->cantidad);

        foreach ($premios as $key => $premio) {
            $producto = Producto::where('estilo', $premio->estilo)->where('color', $premio->color)
                ->where('estado', 'A')
                ->where('stock', '>', 0)
                ->first();
            if ($producto) {
                Cart::add(
                    $producto->id,
                    $producto->descripcion,
                    $premio->cantidad * $cantidadDePremios,
                    0,
                    [
                        'sku' => $producto->sku, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
                        'descuento' => 0, 'pCatalogo' => $producto->precio_empresaria, 'promo' => true, 'premio' => true
                    ]
                )->associate('App\Models\Producto');

                $producto->update(['stock' => $producto->stock - $premio->cantidad]);
            } else {
                $this->message = 'NO HAY STOCK DISPONIBLE PARA EL PREMIO';
                break;
            }
        }

        foreach ($item['productos'] as $key => $pro) {
            Cart::update($pro->rowId, ['options' => [
                'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
                'descuento' => $pro->options->descuento, 'pCatalogo' => $pro->options->pCatalogo, 'promo' => true
            ]]);
        }

    }




    public function OfertaClasificacion()
    {
        $catalogo = Catalogo::where('estado', 'PUBLICADO')->first();
        $ofertas = Oferta::where('catalogo_id', $catalogo->id)
            ->where('estado', 1)
            ->get();

        foreach ($ofertas as $key => $oferta) {
            if($oferta->tipo_oferta == 1){

                $productosOferta = json_decode($oferta->productos);
                // $this->VerificarOfertaXProducto($productosOferta, $oferta);
                $this->VerificarOfertaXProducto2($productosOferta, $oferta) ;

            } elseif ($oferta->tipo_oferta == 2) {

                //Oferta 2
                $this->verificarOffertaMarca2($oferta) ;

            } elseif($oferta->tipo_oferta == 3){
                //oferta 3
                $carItems = Cart::content();
                $productosAgrupados = [];
                $clasificacion = $oferta->clasificacion;
                foreach ($carItems as $key => $item) {
                    $producto = Producto::where('id', $item->id)->first();
                    if ($producto->clasificacion_global == $clasificacion) {
                        if (!isset($productosAgrupados[$producto->clasificacion_global])) {
                            $productosAgrupados[$producto->clasificacion_global] = [
                                'precio' => 0,
                                'cantidad' => 0,
                                'productos' => [],
                            ];
                        }
                        $productosAgrupados[$producto->clasificacion_global]['precio'] += $producto->precio_empresaria * $item->qty;
                        $productosAgrupados[$producto->clasificacion_global]['cantidad'] += $item->qty;
                        $productosAgrupados[$producto->clasificacion_global]['productos'][] = $item;
                    }
                }

                foreach ($productosAgrupados as $key => $item3) {
                    if ($item3['cantidad'] >= $oferta->cantidad && $item3['precio'] >= $oferta->desde) {
                        $this->aplicarOfertaXClasificacion($oferta, $item3);
                    }
                }

            }
        }
    }


    public function brandDiscount()
    {
        $cartItems = Cart::content();

        $catalogue = Catalogo::where('estado', 'PUBLICADO')->first();
        //Ver el cattalogo Activo
        $offers = Oferta::where([
                ['catalogo_id' , $catalogue->id],
                ['estado', 1]
            ])->get();

        $productosOffert = [] ;

        foreach ($offers as $key => $value) {
            $detail = collect(json_decode($value->productos));
            foreach ($detail as $key2 => $det) {
                $productosOffert[] = $det ;
            }
        }

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

        // dd($cartItems);

        foreach ($cartItems as $key => $item) {

            $product = Producto::findOrFail($item->id);

            $offert = collect($productosOffert)
                ->where('estilo', $product->estilo)
                ->where('color', $product->color)
                ->first();



            if($offert){
                $total_valor = ( $item->qty * $item->options->pCatalogo) ;
                $price = $item->options->pCatalogo;
            }else{
                $total_valor = ( $item->qty * $product->precio_empresaria ) ;
                $price = $product->precio_empresaria;
            }
            foreach ($groupsParameters as $keyParameter => $parameter) {
                $flag = collect($parameter['marcas'])->where('categoria', $product->categoria)->first();
                if($flag != null){
                    $groupsParameters[$keyParameter]['productos'][] = [
                        'id' => $product->id,
                        'categoria' =>$product->categoria,
                        'cantidad' => $item->qty ,
                        'valor' => $price,
                        'descuento' => $flag['descuento']
                    ];
                    $groupsParameters[$keyParameter]['total_valor'] += $total_valor;
                    $groupsParameters[$keyParameter]['total_cantidad'] += $item->qty ;
                }
            }
        }

        $groupsParameters = collect($groupsParameters)->filter(function ($item) {
            return $item['tipo_empresaria'] === $this->tipoEmpresaria || $item['tipo_empresaria'] === 'TODOS';
        })->values()->toArray();


        foreach ($cartItems as $keyItem => $item) {

            foreach ($groupsParameters as $key => $parameter) {

                $product = collect($parameter['productos'])->where('id', $item->id)->first();

                $productDB = Producto::findOrFail($item->id);

                $offert = collect($productosOffert)
                    ->where('estilo', $productDB->estilo)
                    ->where('color', $productDB->color)
                    ->first();



                if($offert){
                    $price = $item->options->pCatalogo;
                }else{
                    $price = $productDB->precio_empresaria ;
                }

                $discount = 0 ;

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
                    $price = (float)$price - ($price * $discount);
                    $item1Cart = Cart::get($item->rowId);

                    if ($item1Cart ) {
                        $options = $item1Cart->options->toArray();
                        $options['descuento'] = $discount;
                        Cart::update($item1Cart->rowId, [
                            'qty' => $item1Cart->qty,
                            'price' => round($price, 2),
                            'options' => $options
                        ]);
                    }

                }
            }
        }

        //$this->emit('cartUpdated');

    }

    public function checkShippingCost()
    {
        $cartItems = Cart::content();
        $groupedProducts = [] ;
        foreach ($cartItems as $key => $item) {
            $address = 'NINGUNA' ;
            if( $item->options->has('dataEnvio') && $item->options->dataEnvio != ''){
                $shippingInformation = json_decode($item->options->dataEnvio);
                $address = trim(strtolower($shippingInformation->direccion));
            }
            if (!isset($groupedProducts[$address])) {
                $groupedProducts[$address] = [
                    'precio' => 0,
                    'cantidad' => 0,
                    'productos' => [],
                ];
            }
            $groupedProducts[$address]['precio'] += $item->price * $item->qty;
            $groupedProducts[$address]['cantidad'] += $item->qty;
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

                        $totalPrice = $product->price * $product->qty ;
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
            if ($nameGroup != 'calle 10 de agosto y pedro carbo') {
                foreach ($parameter as $parameterId => $parameterDetail) {
                    if($parameterDetail['tipo_empresaria'] == 'TODOS' && $parameterDetail['condicion'] == 'envio_costo' ){
                        $parameterDetail['total_precio']  = number_format($parameterDetail['total_precio'], 2, '.', ',');
                        $eval = $parameterDetail['total_precio'] . $parameterDetail['eval'] ;
                        $value = eval("return $eval;") ? $parameterDetail['valor_condicion'] : 0 ;
                        $shippingCost += $value ;
                    }
                }
            }
        }
        $this->envio = $shippingCost  ;
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
        // $datos = $this->validacionReglas($producto, $descuento, $precio, $parametros, Cart::count() - $item->qty, $this->envio, 'resta', $item->qty);
        // $descuento = $datos['descuento'];
        Cart::remove($id);
        $this->OfertaClasificacion();
        $this->brandDiscount();
        $this->checkShippingCost();
        // if ($descuento == 0) {
        //     $carItems = Cart::content();
        //     foreach ($carItems as $key => $item) {
        //         $precioNuevo = (float)$item->options->pCatalogo;
        //         Cart::update($item->rowId, ['price' => round($precioNuevo, 2), 'options' => [
        //             'sku' => $item->options->sku, 'color'  => $item->options->color, 'talla' => $item->options->talla, 'marca' => $item->options->marca,
        //             'descuento' => $descuento, 'pCatalogo' => $item->options->pCatalogo, 'dataEnvio' => $item->options->dataEnvio != '' ?$item->options->dataEnvio : ''
        //         ]]);
        //     }
        // }
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
                            'precio' => round($item->price, 2),
                            'descuento' => $item->options->descuento,
                            'precio_empresaria' => $item->options->pCatalogo,
                            'total' => round(($item->price * $item->qty), 2),
                            'estado' => 'SEPARADO',
                            'usuario' => Auth::user()->id,
                            'direccion_envio' => $item->options->dataEnvio != '' ?$item->options->dataEnvio : '',
                            'promo' => $item->options->promo,
                            'tipo' => $item->options->tipo,
                            'premio' => $item->options->premio,
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
            ->where('stock', '>', 0)
            ->first();
        $this->stock = $producto->stock;
        $this->descripcion_producto = $producto->descripcion; //Se agrega propiedad para capturar la descripción del producto
    }

    public function increaseQuantity($rowId)
    {
        $item1 = Cart::get($rowId);
        $producto = Producto::where('id', $item1->id)->with(['marca', 'catalogo'])->first();
        if ($producto->stock - 1 >= 0) {
            $producto->update(['stock' => $producto->stock - 1]);
            $parametros = ParametroCatalogo::where('catalogo_id', $producto->catalogo->catalogo_id)
                ->where('estado', 1)
                ->orderBy('condicion')
                ->get();

            if ($item1) {
                $descuento = 0;
                $precio = $producto->precio_empresaria;
                // $data = $this->validacionReglas($producto, $descuento, $precio, $parametros, $item1->qty + 1, $this->envio, 'suma', 1);
                // $descuento = $data['descuento'];
                // $precio = $data['precio'];
                Cart::update($rowId, [
                    'qty' => $item1->qty + 1, 'price' => round($precio, 2),
                    'options' => $item1->options
                ]);
                // $carItems = Cart::content();
                // foreach ($carItems as $key => $item) {
                //     if ($item->options->promo) {
                //         Cart::update($item->rowId, ['price' => round($precio, 2), 'options' => [
                //             'sku' => $item->options->sku, 'color'  => $item->options->color, 'talla' => $item->options->talla, 'marca' => $item->options->marca,
                //             'descuento' => $descuento, 'pCatalogo' => $item->options->pCatalogo, 'dataEnvio' => $item->options->dataEnvio != '' ?$item->options->dataEnvio : '', 'premio' => $item->options->premio
                //         ]]);
                //     }
                //     if ($item->options->premio && $item->options->tipo == 'MARCATODAS' || $item->options->premio && $item->options->tipo == NULL) {
                //         $producto = Producto::where('id', $item->id)->first();
                //         $producto->update(['stock' => $producto->stock - $item->qty]);
                //         Cart::remove($item->rowId);
                //     }
                // }
                //$this->emit('cartUpdated');
            }

        } else {
            $this->message = 'NO HAY STOCK DISPONIBLE PARA ' . $producto->descripcion;
        }
        $this->verificarOfertas(0);
        $this->OfertaClasificacion();
        $this->brandDiscount();
        $this->checkShippingCost();
    }

    public function decreaseQuantity($rowId)
    {
        $item1 = Cart::get($rowId);
        if ($item1 && $item1->qty > 1) {
            $producto = Producto::where('id', $item1->id)->with(['marca', 'catalogo'])->first();
            $producto->update(['stock' => $producto->stock + 1]);
            $parametros = ParametroCatalogo::where('catalogo_id', $producto->catalogo->catalogo_id)
                ->where('estado', 1)
                ->orderBy('condicion')
                ->get();
            $descuento = 0;
            $precio = $producto->precio_empresaria;
            // $data = $this->validacionReglas($producto, $descuento, $precio, $parametros, $item1->qty - 1, $this->envio, 'resta', 1, 1, $item1->options->descuento, $item1->qty);
            // $precio = $data['precio'];
            // $descuento = $data['descuento'];

            Cart::update($rowId, ['qty' => $item1->qty - 1, 'price' => round($precio, 2), 'options' => [
                'sku' => $item1->options->sku, 'color'  => $item1->options->color, 'talla' => $item1->options->talla, 'marca' => $item1->options->marca,
                'descuento' => $descuento, 'pCatalogo' => $item1->options->pCatalogo, 'dataEnvio' => $item1->options->dataEnvio != '' ?$item1->options->dataEnvio : ''
            ]]);
            // $carItems = Cart::content();
            // foreach ($carItems as $key => $item) {
            //     if ($item->options->premio) {
            //         $producto = Producto::where('id', $item->id)->update(['stock' => $producto->stock + $item->qty]);
            //         Cart::remove($item->rowId);
            //     }
            // }


        }
        $this->verificarOfertas(0);
        $this->OfertaClasificacion();
        $this->brandDiscount();
        //$this->emit('cartUpdated');
        $this->checkShippingCost();
    }

    public function validacionReglas($prod, $descuento, $precio, $parametros, $cantidad, $envio, $tipo = null, $cantidadResta = 1, $cantidadSuma = 1, $descuentoDecrease = 0, $itemCantidad = 0)
    {

        //NO Borrar
        $parametrosMarca = ParametroMarca::where('estado', 1)->get();
        if (!empty($parametrosMarca)) {
            foreach ($parametrosMarca as $key => $regla) {
                if ($regla->tipo_empresaria == $this->tipoEmpresaria) {
                    if (in_array($prod->categoria, json_decode($regla->marcas))) {
                        if ($regla->condicion == 'cantidad') {
                            $desc = $cantidad . $regla->operador . $regla->cantidad;
                            $desc = eval("return $desc;") ?$regla->descuento : 0;
                            $desc = $desc / 100;
                            if ($desc != 0) $descuento = $desc;
                        }
                        if ($regla->condicion == 'valor') {
                            $desc = $cantidad . $regla->operador . $regla->cantidad;
                            $desc = eval("return $desc;") ?$regla->descuento : 0;
                            $desc = $desc / 100;
                            if ($desc != 0) $descuento = $desc;
                        }
                    }
                } elseif ($regla->tipo_empresaria == 'TODOS') {
                    if (in_array($prod->categoria, json_decode($regla->marcas))) {
                        if ($regla->condicion == 'cantidad') {
                            $desc = $cantidad . $regla->operador . $regla->cantidad;
                            $desc = eval("return $desc;") ?$regla->descuento : 0;
                            $desc = $desc / 100;
                            if ($desc != 0) $descuento = $desc;
                        }
                        if ($regla->condicion == 'valor') {
                            $desc = $cantidad . $regla->operador . $regla->cantidad;
                            $desc = eval("return $desc;") ?$regla->descuento : 0;
                            $desc = $desc / 100;
                            if ($desc != 0) $descuento = $desc;
                        }
                    }
                }
            }
        }
        if ($descuento > 0) {
            $precio = (float)$precio - ($precio * $descuento);
        }
        return ['descuento' => $descuento, 'precio' => $precio];
    }


    public function cerrarVenta()
    {
        if (empty($this->cliente) || !$this->click2) {
            $this->message = 'INGRESE EL NOMBRE DE LA EMPRESARIA';
            return;
        }

        $this->flagPrize  = false ;

        foreach ($this->premiosEmpresaria as $key => $value) {
            PremioAcumuladoEmpresaria::create($value);
        }

        return redirect()->to(route('web.checkout', ['id' => $this->id_empresaria, 'envio' => $this->envio]));
    }

    public function guardarDatos()
    {
        $rowId = $this->direccionData['rowId'];
        $item = Cart::get($rowId);

        Cart::update($item->rowId, ['options' => [
            'sku' => $item->options->sku, 'color'  => $item->options->color, 'talla' => $item->options->talla, 'marca' => $item->options->marca,
            'descuento' => $item->options->descuento, 'pCatalogo' => $item->options->pCatalogo, 'dataEnvio' => json_encode($this->direccionData)
        ]]);
        //$this->emit('cartUpdated');
        $this->checkShippingCost();
        $this->localDpisar = false;
        $this->emit('closeModal');
    }

    public function reglaDireccionEnvio($data, $item)
    {
        $this->envio = 0;
        $producto = Producto::where('id', $item->id)->with(['marca', 'catalogo'])->first();
        $parametros =  $parametros = ParametroCatalogo::where('catalogo_id', $producto->catalogo->catalogo_id)
            ->where('estado', 1)
            ->where('condicion', 'envio_costo')
            ->orWhere('condicion', 'envio_cantidad')
            ->orderBy('condicion')
            ->get();

        $carItems = Cart::content();
        $productosAgrupados = [];
        //agrupacion por dirección
        foreach ($carItems as $key => $item2) {
            if ($item2->options->dataEnvio != '') {
                $data2 = json_decode($item2->options->dataEnvio);
                $dir = trim(strtolower($data2->direccion));

                if (!isset($productosAgrupados[$dir])) {
                    $productosAgrupados[$dir] = [
                        'precio' => 0,
                        'cantidad' => 0,
                        'productos' => [],
                    ];
                }

                $productosAgrupados[$dir]['precio'] += $item2->price * $item2->qty;
                $productosAgrupados[$dir]['cantidad'] += $item2->qty;
                $productosAgrupados[$dir]['productos'][] = $item2;
            }
        }
        //calculo de envio
        foreach ($productosAgrupados as $key => $item3) {
            if (!empty($parametros)) {
                foreach ($parametros as $key => $regla) {
                    if ($regla->tipo_empresaria == 'TODOS') {
                        if ($regla->condicion == 'envio_costo') {
                            $env = $item3['precio'] . $regla->operador . $regla->cantidad;
                            $env = eval("return $env;") ?$regla->valor : 0;
                            $this->envio += $env;
                        }
                        if ($regla->condicion == 'envio_cantidad') {
                            $env = $item3['cantidad'] . $regla->operador . $regla->cantidad;
                            $env = eval("return $env;") ?$regla->valor : 0;
                            $this->envio += $env;
                        }
                    }
                    if ($regla->tipo_empresaria == $this->tipoEmpresaria) {
                        if ($regla->condicion == 'envio_costo') {
                            $env = $item3['precio'] . $regla->operador . $regla->cantidad;
                            $env = eval("return $env;") ?$regla->valor : 0;
                            $this->envio += $env;
                        }
                        if ($regla->condicion == 'envio_cantidad') {
                            $env = $item3['cantidad'] . $regla->operador . $regla->cantidad;
                            $env = eval("return $env;") ?$regla->valor : 0;
                            $this->envio += $env;
                        }
                    }
                }
            }
        }
    }

    public function verificarOfertas($descuento)
    {
        $catalogo = Catalogo::where('estado', 'PUBLICADO')->first();
        $ofertas = Oferta::where('catalogo_id', $catalogo->id)
            ->where('estado', 1)
            ->get();
        $aplicaOferta = false;

        foreach ($ofertas as $oferta) {
            //Verificar si la oferta aplica por productos y a la cantidad de productos en el carrito
            if ($oferta->tipo_oferta == 1) {
                $productosOferta = json_decode($oferta->productos);
                // $this->VerificarOfertaXProducto($productosOferta, $oferta);
            } else if ($oferta->tipo_oferta == 2) {
                //Verificar si la oferta aplica por marca y a la cantidad comprada es la requerida
                // $this->verificarOfertaXMarca($oferta);
            } else if ($oferta->tipo_oferta == 3) {
                //Verificar si la oferta aplica por clasificación global y a la cantidad comprada es la requerida
                //$this->verificarOfertaXClasificacion($oferta);
            }
        }
    }


    public function verificarOffertaMarca2($oferta)
    {
        $carItems = Cart::content();
        $productosAgrupados = [];
        if ($oferta->marca_id != null) $marca = Marca::where('id', $oferta->marca_id)->first()->nombre;
        else $marca = 'TODAS';

        foreach ($carItems as $key => $item) {
            if ($marca != 'TODAS') {
                if ($item->options->marca == $marca /*&& !$item->options->oferta*/) {
                    if (!isset($productosAgrupados[$item->options->marca])) {
                        $productosAgrupados[$item->options->marca] = [
                            'precio' => 0,
                            'cantidad' => 0,
                            'productos' => [],
                        ];
                    }
                    $productosAgrupados[$item->options->marca]['precio'] += $item->options->pCatalogo * $item->qty;
                    $productosAgrupados[$item->options->marca]['cantidad'] += $item->qty;
                    $productosAgrupados[$item->options->marca]['productos'][] = $item;
                }
            } else {
                if (!isset($productosAgrupados['TODAS'])) {
                    $productosAgrupados['TODAS'] = [
                        'precio' => 0,
                        'cantidad' => 0,
                        'productos' => [],
                    ];
                }
                $productosAgrupados['TODAS']['precio'] += $item->options->pCatalogo * $item->qty;
                $productosAgrupados['TODAS']['cantidad'] += $item->qty;
                $productosAgrupados['TODAS']['productos'][] = $item;
                if ($item->options->oferta) {
                    if ($item->options->oferta && $item->options->tipo == 'MARCATODAS') {
                        $productosAgrupados = [];
                        break;
                    }
                }
            }
        }

        foreach ($productosAgrupados as $key => $item3) {

            if ($item3['cantidad'] >= $oferta->cantidad && $item3['precio'] >= $oferta->desde) {
                $this->aplicarOfertaXMarca($oferta, $item3, $key);
                foreach ($item3['productos'] as $key => $pro) {
                    Cart::update($pro->rowId, ['options' => [
                        'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
                        'descuento' => $pro->options->descuento, 'pCatalogo' => $pro->options->pCatalogo, 'oferta' => true, 'tipo' => 'MARCA'
                    ]]);
                }
            }
        }



    }


    public function VerificarOfertaXProducto($productosOferta, $oferta)
    {

        $cartItems = Cart::content();
        // dd($cartItems);

        foreach ($cartItems as $keyItem => $item) {
            $item1Cart = Cart::get($item->rowId);
            if ($item1Cart ) {

                $producto = Producto::with(['marca', 'catalogo'])->findOrFail($item->id);

                $price = $producto->precio_empresaria;

                $options = $item1Cart->options->toArray();
                $options['pCatalogo'] = $price;
                unset($options['promo']);
                unset($options['premio']);
                unset($options['oferta']);
                unset($options['tipo']);

                Cart::update($item1Cart->rowId, [
                    'qty' => $item1Cart->qty,
                    'price' => round($price, 2),
                    'options' => $options
                ]);
            }
        }



        $carItems = Cart::content();
        $productosAgrupados = [];
        foreach ($carItems as $key => $item) {
            $producto = Producto::where('id', $item->id)->first();
            if (!$item->options->promo) {
                if (!isset($productosAgrupados[$producto->estilo])) {
                    $productosAgrupados[$producto->estilo] = [
                        'precio' => 0,
                        'cantidad' => 0,
                        'estilo' => $producto->estilo,
                        'color' => $producto->color,
                        'productos' => [],
                    ];
                }
                $productosAgrupados[$producto->estilo]['precio'] += $item->options->pCatalogo * $item->qty;
                $productosAgrupados[$producto->estilo]['cantidad'] += $item->qty;
                $productosAgrupados[$producto->estilo]['productos'][] = $item;
            }
        }
        // dd($productosOferta, $productosAgrupados);
        foreach ($productosOferta as $key => $productoOferta) {
            foreach ($productosAgrupados as $key2 => $item) {
                // if ($producto->estilo == $productoOferta->estilo && $producto->color == $productoOferta->color) {

                if ($item['estilo'] == $productoOferta->estilo && $item['color'] == $productoOferta->color) {
                    if ($item['cantidad'] >= $productoOferta->cantidad) {
                        $this->aplicarOferta($productoOferta, $oferta, $item);
                    }
                    //Aqui debe de ser la condicion
                }
            }
        }
    }

    public function aplicarOferta($productoOferta, $oferta, $item)
    {
        //aplicar oferta de precio especial
        //Ya no lo utilizo asi que le voy a poner en cero
        if ($oferta->tipo_premio == 1) {
            $precioEspecial = $oferta->valor;
            $cantidadOferta = $productoOferta->cantidad;
            $cantidadProducto = $item['cantidad'];

            $grupos = (int) ($cantidadProducto / $cantidadOferta);
            $residuo = $cantidadProducto % $cantidadOferta;
            $precioTotalGrupos = $precioEspecial * $grupos;
            if ($residuo === 0) {
                $precioTotal = ($precioTotalGrupos / $cantidadProducto);
                foreach ($item['productos'] as $key => $pro) {
                    if ($pro->options->descuento > 0) {
                        $precioFinal = $precioTotal - ($precioTotal * $pro->options->descuento);
                    } else {
                        $precioFinal = $precioTotal;
                    }
                    Cart::update($pro->rowId, ['price' => $precioFinal, 'options' => [
                        'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
                        'descuento' => $pro->options->descuento, 'pCatalogo' => $precioTotal, 'promo' => true
                    ]]);
                }
            } else {
                $precioTotal = ($precioTotalGrupos / ($cantidadProducto - 1));
                foreach ($item['productos'] as $key => $pro) {
                    if ($pro->options->descuento > 0) {
                        $precioFinal = $precioTotal - ($precioTotal * $pro->options->descuento);
                    } else {
                        $precioFinal = $precioTotal;
                    }
                    $residuo2 = $pro->qty % $cantidadOferta;

                    if ($residuo2 === 0 && $pro->qty < $cantidadOferta) {
                        Cart::update($pro->rowId, ['price' => $precioFinal, 'options' => [
                            'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
                            'descuento' => $pro->options->descuento, 'pCatalogo' => $precioTotal, 'promo' => true
                        ]]);
                    } else if ($residuo2 != 0 && $pro->qty > $cantidadOferta) {
                        Cart::update($pro->rowId, [
                            'price' => $precioFinal, 'qty' => $pro->qty - 1,
                            'options' => [
                                'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
                                'descuento' => $pro->options->descuento, 'pCatalogo' => $precioTotal, 'promo' => true
                            ]
                        ]);
                        $producto = Producto::where('id', $pro->id)->first();
                        if ($pro->options->descuento > 0) {
                            $precioFinal = $producto->precio_empresaria  - ($producto->precio_empresaria * $pro->options->descuento);
                        } else {
                            $precioFinal = $producto->precio_empresaria;
                        }
                        Cart::add(
                            $pro->id,
                            $producto->descripcion,
                            1,
                            $precioFinal,
                            [
                                'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
                                'descuento' => $pro->options->descuento, 'pCatalogo' => $producto->precio_empresaria, 'promo' => false
                            ]
                        )->associate('App\Models\Producto');
                    }
                }
            }
        }
        //aplicar oferta de premio producto
        if ($oferta->tipo_premio == 2) {
            $premios = json_decode($oferta->premios);
            $cantidadDePremios =  intdiv($item['cantidad'], $productoOferta->cantidad);

            foreach ($premios as $key => $premio) {
                $producto = Producto::where('estilo', $premio->estilo)->where('color', $premio->color)
                    ->where('estado', 'A')
                    ->where('stock', '>', 0)
                    ->first();
                if ($producto) {
                    Cart::add(
                        $producto->id,
                        $producto->descripcion,
                        $premio->cantidad * $cantidadDePremios,
                        0,
                        [
                            'sku' => $producto->sku, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
                            'descuento' => 0, 'pCatalogo' => $producto->precio_empresaria, 'promo' => true, 'premio' => true
                        ]
                    )->associate('App\Models\Producto');

                    $producto->update(['stock' => $producto->stock - $premio->cantidad]);
                } else {
                    $this->message = 'NO HAY STOCK DISPONIBLE PARA EL PREMIO';
                    break;
                }
            }

            foreach ($item['productos'] as $key => $pro) {
                Cart::update($pro->rowId, ['options' => [
                    'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
                    'descuento' => $pro->options->descuento, 'pCatalogo' => $pro->options->pCatalogo, 'promo' => true
                ]]);
            }
        }
    }

    public function verificarOfertaXMarca($oferta)
    {
        $carItems = Cart::content();
        $productosAgrupados = [];
        if ($oferta->marca_id != null) $marca = Marca::where('id', $oferta->marca_id)->first()->nombre;
        else $marca = 'TODAS';
        foreach ($carItems as $key => $item) {
            if ($marca != 'TODAS') {
                if ($item->options->marca == $marca && !$item->options->oferta) {
                    if (!isset($productosAgrupados[$item->options->marca])) {
                        $productosAgrupados[$item->options->marca] = [
                            'precio' => 0,
                            'cantidad' => 0,
                            'productos' => [],
                        ];
                    }
                    $productosAgrupados[$item->options->marca]['precio'] += $item->options->pCatalogo * $item->qty;
                    $productosAgrupados[$item->options->marca]['cantidad'] += $item->qty;
                    $productosAgrupados[$item->options->marca]['productos'][] = $item;
                }
            } else {
                if (!isset($productosAgrupados['TODAS'])) {
                    $productosAgrupados['TODAS'] = [
                        'precio' => 0,
                        'cantidad' => 0,
                        'productos' => [],
                    ];
                }
                $productosAgrupados['TODAS']['precio'] += $item->options->pCatalogo * $item->qty;
                $productosAgrupados['TODAS']['cantidad'] += $item->qty;
                $productosAgrupados['TODAS']['productos'][] = $item;
                if ($item->options->oferta) {
                    if ($item->options->oferta && $item->options->tipo == 'MARCATODAS') {
                        $productosAgrupados = [];
                        break;
                    }
                }
            }
        }
        foreach ($productosAgrupados as $key => $item3) {
            dd($productosAgrupados);
            if ($item3['cantidad'] >= $oferta->cantidad && $item3['precio'] >= $oferta->desde) {
                $this->aplicarOfertaXMarca($oferta, $item3, $key);
                foreach ($item3['productos'] as $key => $pro) {
                    Cart::update($pro->rowId, ['options' => [
                        'sku' => $pro->options->sku, 'color'  => $pro->options->color, 'talla' => $pro->options->talla, 'marca' => $pro->options->marca,
                        'descuento' => $pro->options->descuento, 'pCatalogo' => $pro->options->pCatalogo, 'oferta' => true, 'tipo' => 'MARCA'
                    ]]);
                }
            }
        }
    }

    public function aplicarOfertaXMarca($oferta, $item3, $marca)
    {
        //Creeria que se debe crear un nuevo campo para identificar;
        //aplicar oferta de premio
        $carItems = Cart::content();

        if ($oferta->tipo_premio == 2) {
            $premios = json_decode($oferta->premios);
            foreach ($premios as $key => $premio) {
                $producto = Producto::where('estilo', $premio->estilo)->where('color', $premio->color)
                    ->where('estado', 'A')
                    ->where('stock', '>', 0)
                    ->first();

                $result = $carItems->where('id', $producto->id )->first() ;

                // dd($result,  $result->options->oferta
                // , $result->options->tipo , $marca
                // , $result->options->premio, $carItems);
                ///Verificar por el tipo de Premio

                if ($marca == 'TODAS'){
                    if (!$result && $producto) {
                        // dd($result ,$result->options->oferta
                        // , $result->options->tipo,  'MARCA');
                        Cart::add(
                            $producto->id,
                            $producto->descripcion,
                            $premio->cantidad,
                            0,
                            [
                                'sku' => $producto->sku, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
                                'descuento' => 0, 'pCatalogo' => $producto->precio_empresaria, 'oferta' => true, 'tipo' => $marca, 'premio' => true
                            ]
                        )->associate('App\Models\Producto');

                        $producto->update(['stock' => $producto->stock - $premio->cantidad]);
                    } else {
                        $this->message = 'NO HAY STOCK DISPONIBLE PARA EL PREMIO';
                        break;
                    }
                }else{
                    if($producto){
                        $cantidadDePremios = intdiv($item3['cantidad'], $oferta->cantidad);

                        if($result){
                            $ncant = ($premio->cantidad * $cantidadDePremios) ;
                            $nstock = $ncant - $result->qty ;
                            if($ncant > $result->qty){
                                $options = $result->options->toArray();

                                Cart::update($result->rowId, [
                                    'qty' => $ncant,
                                    'price' => $result->price,
                                    'options' => $options
                                ])->associate('App\Models\Producto');

                                $producto->update(['stock' => $producto->stock - $nstock ]);
                            }

                        }else{
                              // , $result->options->tipo,  'MARCA');
                            Cart::add(
                                $producto->id,
                                $producto->descripcion,
                                $premio->cantidad * $cantidadDePremios,
                                0,
                                [
                                    'sku' => $producto->sku, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
                                    'descuento' => 0, 'pCatalogo' => $producto->precio_empresaria, 'oferta' => true, 'tipo' => $marca, 'premio' => true
                                ]
                            )->associate('App\Models\Producto');

                            $producto->update(['stock' => $producto->stock - ($premio->cantidad * $cantidadDePremios)]);

                        }

                    }else {
                        $this->message = 'NO HAY STOCK DISPONIBLE PARA EL PREMIO';
                        break;
                    }
                }
            }
        }
    }

    public function verificarOfertaXClasificacion($oferta)
    {
        $carItems = Cart::content();
        $productosAgrupados = [];
        $clasificacion = $oferta->clasificacion;
        foreach ($carItems as $key => $item) {
            $producto = Producto::where('id', $item->id)->first();
            if ($producto->clasificacion_global == $clasificacion) {
                if (!isset($productosAgrupados[$producto->clasificacion_global])) {
                    $productosAgrupados[$producto->clasificacion_global] = [
                        'precio' => 0,
                        'cantidad' => 0,
                        'productos' => [],
                    ];
                }
                $productosAgrupados[$producto->clasificacion_global]['precio'] += $item->options->pCatalogo * $item->qty;
                $productosAgrupados[$producto->clasificacion_global]['cantidad'] += $item->qty;
                $productosAgrupados[$producto->clasificacion_global]['productos'][] = $item;
            }
        }
        foreach ($productosAgrupados as $key => $item3) {
            if ($item3['cantidad'] >= $oferta->cantidad && $item3['precio'] >= $oferta->desde) {
                $this->aplicarOfertaXClasificacion($oferta, $item3);
            }
        }
    }

    public function aplicarOfertaXClasificacion($oferta, $item)
    {
        $carItems = Cart::content();
        foreach ($carItems as $key => $item2) {
            if ($item2->options->premio) {
                $producto = Producto::where('id', $item2->id)->first();
                $producto->update(['stock' => $producto->stock + $item2->qty]);
                Cart::remove($item2->rowId);
            }
        }
        //aplicar oferta de premio
        if ($oferta->tipo_premio == 2) {
            $premios = json_decode($oferta->premios);
            $cantidadDePremios =  intdiv($item['precio'], $oferta->desde);
            // dd($cantidadDePremios ,  intdiv($item['precio'], $oferta->desde), $item['precio'], $oferta->desde);
            foreach ($premios as $key => $premio) {
                $producto = Producto::where('estilo', $premio->estilo)->where('color', $premio->color)
                    ->where('estado', 'A')
                    ->where('stock', '>', 0)
                    ->first();
                if ($producto) {
                    Cart::add(
                        $producto->id,
                        $producto->descripcion,
                        $premio->cantidad * $cantidadDePremios,
                        0,
                        [
                            'sku' => $producto->sku, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
                            'descuento' => 0, 'pCatalogo' => $producto->precio_empresaria, 'oferta' => true, 'tipo' => 'CLASIFICACION', 'premio' => true
                        ]
                    )->associate('App\Models\Producto');

                    $producto->update(['stock' => $producto->stock - ($premio->cantidad * $cantidadDePremios)]);
                } else {
                    $this->message = 'NO HAY STOCK DISPONIBLE PARA EL PREMIO';
                    break;
                }
            }
        }
    }


    public function eliminarProducto($id)
    {
        $this->productosPremios = $this->productosPremios->filter(function($producto) use ($id) {
            return $producto->id != $id;
        });
    }



    public function agrgarPromocion()
    {

        foreach ($this->productosPremios as $key => $value) {
            $producto = Producto::where('id', $value->id)
                ->with(['marca', 'catalogo'])
                ->first();

            try {
                $precio = $producto->precio_empresaria;
                $descuento = 0;
                Cart::add(
                    $producto->id,
                    $producto->descripcion,
                    1,
                    $precio,
                    [
                        'sku' => $producto->sku, 'color'  => $producto->color, 'talla' => $producto->talla, 'marca' => $producto->marca->nombre,
                        'descuento' => $descuento, 'pCatalogo' => $producto->precio_empresaria
                    ]
                )->associate('App\Models\Producto');
                //separar stock
                $producto->update(['stock' => $producto->stock - 1]);
                $this->reset(['colores', 'tallas', 'imagen', 'color', 'talla', 'cantidad']);

            } catch (\Throwable $th) {
                dd($th->getMessage());
            }
        }

    }


    public function checkAwards()
    {
        $this->premiosEmpresaria = [];
        $this->flagPrize  = false ;
        $prizeProductsWithoutAccumulation = collect([]);
        $prizeProductsWithAccumulation = collect([]);

        if($this->tipoEmpresaria != ''){
            $this->countProductosPremios += 1 ;
            //NO acumula
            $total = Cart::content()->map(function ($item) {return round($item->price * $item->qty, 2);})->sum();

            $conditionPrize = $this->getAwardCondition( 0, $total, 'TODOS') ;

            if($conditionPrize){
                $prizeProductsWithoutAccumulation = $this->getThePrizeProducts($conditionPrize);
            }

            if($prizeProductsWithoutAccumulation->count() == 0){
                $conditionPrize = $this->getAwardCondition( 0, $total, $this->tipoEmpresaria) ;
                if($conditionPrize) $prizeProductsWithoutAccumulation = $this->getThePrizeProducts($conditionPrize);
            }


            //Acumula
            //Parametrizar
            // if($total > 60){
            $prizeProductsWithAccumulation = $this->getAccumulationPrizeProducts($total);

            // }

            if(count($prizeProductsWithoutAccumulation) > 0){
                $this->productosPremios = $prizeProductsWithoutAccumulation->merge($prizeProductsWithAccumulation);
            }else{
                $this->productosPremios = $prizeProductsWithAccumulation->merge($prizeProductsWithoutAccumulation);
            }
            // $this->productosPremios = collect($this->productosPremios)->map(function($element){

            //     return (object)[
            //         'sku'=> $element->sku,
            //         'descripcion'=> $element->descripcion,
            //         'marca'=> $element->marca->nombre,
            //         'color'=> $element->color,
            //         'talla'=> $element->talla,
            //         'stock'=> $element->stock,
            //         'id'=> $element->id
            //     ];

            // }) ;
            $this->flagPrize = $this->productosPremios->count() > 0 ? true : false ;
        }

    }



    public function getAccumulationPrizeProducts($valorTotalCarrito)
    {
        $products = collect([]);

        $currentCatalog = Catalogo::where('estado', 'PUBLICADO')->first();

        $catalogOld = Catalogo::where('id', '!=',$currentCatalog->id)
            ->orderBy('fecha_publicacion', 'desc')
            ->first();

        if($catalogOld){
            $total = Venta::where([
                ['id_empresaria', $this->id_empresaria],
                ['id_catalogo', $catalogOld->id]
            ])->sum('total_venta');


            $envio = Venta::where([
                ['id_empresaria', $this->id_empresaria],
                ['id_catalogo', $catalogOld->id]
            ])->sum('envio');

            $total -= $envio ;

            $conditionPrize = $this->getAwardCondition( 1, $total, 'TODOS') ;


            if($conditionPrize){
                if($valorTotalCarrito >= $conditionPrize->prize->monto_minimo_acumulado){
                    $prizeAccumulatedBusinesswoman = PremioAcumuladoEmpresaria::where([
                            ['empresaria_id' , $this->id_empresaria],
                            ['estado' , 1],
                            ['catalogo_id' , $catalogOld->id],
                            ['condicion_premio_id', $conditionPrize->id]
                        ])->first();

                    if(!$prizeAccumulatedBusinesswoman){
                        $products = $this->getThePrizeProducts($conditionPrize);
                        if($products->count() > 0 ){
                            //me falta el de ventaId
                            $this->premiosEmpresaria[]=[
                                'empresaria_id' => $this->id_empresaria,
                                'catalogo_id' => $catalogOld->id,
                                'condicion_premio_id'=> $conditionPrize->id,
                                'venta_id'=>null
                            ];

                        }
                    }

                }
            }
            if(count($products) == 0 ){
                $conditionPrize = $this->getAwardCondition( 1, $total, $this->tipoEmpresaria) ;

                if($conditionPrize){
                    // dd($total, $conditionPrize, $conditionPrize->prize->monto_minimo_acumulado , $valorTotalCarrito, $conditionPrize->prize->monto_minimo_acumulado >= $valorTotalCarrito);
                    if($valorTotalCarrito >= $conditionPrize->prize->monto_minimo_acumulado){
                        //Preguntar por la condicion
                        $prizeAccumulatedBusinesswoman = PremioAcumuladoEmpresaria::where([
                                ['empresaria_id' , $this->id_empresaria],
                                ['estado' , 1],
                                ['catalogo_id' , $catalogOld->id],
                                ['condicion_premio_id', $conditionPrize->id]
                            ])->first();
                        if(!$prizeAccumulatedBusinesswoman){
                            $products = $this->getThePrizeProducts($conditionPrize);
                            if($products->count() > 0){
                                //me falta el de ventaId
                                $this->premiosEmpresaria[]=[
                                    'empresaria_id' => $this->id_empresaria,
                                    'catalogo_id' => $catalogOld->id,
                                    'condicion_premio_id'=> $conditionPrize->id,
                                    'venta_id'=>null
                                ];

                            }
                        }

                    }
                }
            }


        }

        return $products ;
    }


    public function getThePrizeProducts($conditionPrize)
    {
        $PrizeHasProduct = Premio_has_Producto::where('premio_id',$conditionPrize->premio_id )->pluck('estilo');
        $products = Producto::with('marca')
            ->where([
                ['catalogo_id', $conditionPrize->prize->catalogo_id],
                ['categoria', 'PREMIOS'],
                ['estado', 'A'],
                ['stock', '>', 0]
            ])
            ->whereIn('estilo', $PrizeHasProduct )
            ->get();

        return $products ;
    }


    public function getAwardCondition($accumulates, $total, $tipoEmpresaria)
    {
        $prizeCondition = CondicionPremio::with('prize')
                    ->whereHas('prize', function($q){
                        $q->whereHas('catalogue', function($query){
                            $query->where('estado', 'PUBLICADO');
                        });
                    })
                    ->where([
                        ['tipo_empresaria', $tipoEmpresaria],
                        ['rango_desde', '<=', $total],
                        ['rango_hasta', '>=', $total],
                        ['acumular', $accumulates]
                    ])
                    ->first();

        return $prizeCondition ;
    }


    public function verificarYProcesar()
    {
        if($this->flagPrize){
            $this->cerrarVenta();
        }
        // Lógica para verificar la bandera (puedes ajustarla a tu lógica de negocio)
        $this->checkAwards();
        if ($this->flagPrize) {
            // Emitir evento para mostrar SweetAlert
            $this->dispatchBrowserEvent('mostrar-alerta');
        } else {
            // Cerrar la venta directamente
            $this->cerrarVenta();
        }
    }


    public function aceptarAccion()
    {
        $this->emit('mostrar-modal-premios');
    }

}
