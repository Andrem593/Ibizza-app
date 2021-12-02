<?php

namespace App\Http\Controllers;

use App\Catalogo;
use App\Empresaria;
use App\Mail\RegistroEmpresaria;
use App\Models\Pedido;
use App\Models\Venta;
use App\Premio;
use Illuminate\Support\Facades\DB;
use App\Producto;
use Illuminate\Http\Request;
use Cart;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class webController extends Controller
{
    public function __invoke()
    {
        $productos = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->where('catalogos.estado', '=', 'PUBLICADO')->where('productos.estado','A')
            ->where('productos.stock','>',0)
            ->groupBy('productos.estilo')->limit(8)->get();
        $productos_hombres = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->where('catalogos.estado', '=', 'PUBLICADO')->where('productos.estado','A')
            ->where('productos.stock','>',0)
            ->where('categoria','like','%Hombre%')
            ->groupBy('productos.estilo')->limit(8)->get();
        $productos_mujer = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
        ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
        ->where('catalogos.estado', '=', 'PUBLICADO')->where('productos.estado','A')
        ->where('productos.stock','>',0)
        ->where('categoria','like','%Mujer%')
        ->groupBy('productos.estilo')->limit(8)->get();
        $productos_niños = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->where('catalogos.estado', '=', 'PUBLICADO')->where('productos.estado','A')->where('productos.stock','>',0)
            ->where('categoria','like','%Niñas%')->orWhere('categoria','like','%Niños%')
            ->groupBy('productos.estilo')->limit(8)->get();
        $marcas = DB::table('marcas')->where('imagen', '<>', '')->get();
        $subcategorias = Producto::select(DB::raw('count(nombre_mostrar) as cantidad_productos, subcategoria'))
            ->groupBy('subcategoria')->orderBy('cantidad_productos', 'DESC')->limit(4)->get();
        $catalogos = DB::table('catalogos')->where('estado', '=', 'PUBLICADO')->get();
        $poco_stock = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
        ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
        ->where('productos.stock','>',0)
        ->groupBy('productos.estilo')
        ->orderBy('productos.stock')->limit(2)->get();
        $descuentos = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
        ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
        ->where('productos.stock','>',0)
        ->groupBy('productos.estilo')
        ->orderBy('productos.descuento', 'desc')->limit(2)->get();
        $ultimos = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
        ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
        ->where('productos.stock','>',0)
        ->groupBy('productos.estilo')
        ->orderBy('productos.created_at', 'asc')->limit(4)->get();
        return view('welcome2', compact('marcas', 'productos', 'catalogos','productos_hombres','productos_mujer','productos_niños','subcategorias','poco_stock','descuentos','ultimos'));
    }
    public function addToCart(Request $request)
    {
        if (!empty($request->talla) && !empty($request->color)) {
            $producto = Producto::where('estilo', $request->estilo)->where('talla', $request->talla)->first();
        }
        if (!empty($request->talla)) {
            $producto = Producto::where('color', $request->color)->where('estilo', $request->estilo)->where('talla', $request->talla)->first();
        } else {
            $producto = Producto::where('color', $request->color)->where('estilo', $request->estilo)->first();
        }
        if ($producto->descuento != '') {
            $precio = $producto->precio_empresaria - ($producto->precio_empresaria * ($producto->descuento / 100));
        } else {
            $precio =  $producto->precio_empresaria;
        }
        if (isset($request->cantidad)) {
            $cart = Cart::add($producto->id, $producto->nombre_mostrar, $request->cantidad, number_format($precio,2), ['image' => $producto->imagen_path])->associate('App\Models\Producto');
        }else {
            $cart = Cart::add($producto->id, $producto->nombre_mostrar, 1, number_format($precio,2), ['image' => $producto->imagen_path])->associate('App\Models\Producto');
        }
        return 'add';
    }
    public function deleteToCart(Request $request)
    {
        Cart::remove($request->id);
        $response = [
            'message' => 'deleted',
            'subtotal' => Cart::subtotal(),
            'tax' => Cart::tax(),
            'total' => Cart::total()
        ];
        json_encode($response);
        return $response;
    }
    public function tienda()
    {
        $productos = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->where('catalogos.estado', '=', 'PUBLICADO')
            ->groupBy('productos.estilo')->paginate(16);
        $categorias =DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->selectRaw('count(productos.nombre_mostrar) as cantidad_productos, productos.categoria')
            ->groupBy('categoria')
            ->get();
        $subcategorias =DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->selectRaw('count(nombre_mostrar) as cantidad_productos, productos.subcategoria')
            ->groupBy('subcategoria')
            ->get();
        //$productos->paginate(8);
        return view('ecomerce.tienda', compact('productos','categorias','subcategorias'));
    }
    public function tiendaOrder($category,$orderBy)
    {
        if ($category != 'all') {
            $category = explode('-',$category);
            $productos = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->where('catalogos.estado', '=', 'PUBLICADO')->where($category[0],$category[1])
            ->orderByRaw($orderBy)
            ->groupBy('productos.estilo')->paginate(16);
        }else {
            $productos = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->where('catalogos.estado', '=', 'PUBLICADO')
            ->orderByRaw($orderBy)
            ->groupBy('productos.estilo')->paginate(16);
        }
        $categorias =DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->selectRaw('count(productos.nombre_mostrar) as cantidad_productos, productos.categoria')
            ->groupBy('categoria')
            ->get();
        $subcategorias =DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->selectRaw('count(nombre_mostrar) as cantidad_productos, productos.subcategoria')
            ->groupBy('subcategoria')
            ->get();
        return view('ecomerce.tienda', compact('productos','categorias','subcategorias'));
    }
    public function carrito()
    {
        return view('ecomerce.carrito');
    }
    public function detalle_producto($estilo)
    {
        $productos_color = Producto::where('estilo', $estilo)->groupBy('color')->get();
        $catalogo = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->select('catalogos.*')
            ->where('productos.estilo', '=', $estilo)
            ->groupBy('color')->first();
        $tallas = Producto::where('estilo', $estilo)->where('color', $productos_color[0]->color)->get();
        $poco_stock = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
        ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
        ->where('productos.stock','>',0)
        ->groupBy('productos.estilo')
        ->orderBy('productos.stock')->limit(10)->get();
        return view('ecomerce.producto-detalle', compact('productos_color', 'catalogo', 'tallas','poco_stock'));
    }
    public function tallas_x_color(Request $request)
    {
        $tallas = Producto::where('estilo', $request->estilo)->select('talla')->where('color', $request->color)->get();
        $tallas = json_encode($tallas);
        return $tallas;
    }
    public function stock_x_color(Request $request)
    {
        $stock = Producto::where('estilo', $request->estilo)->where('color', $request->color)->where('talla', $request->talla)->first();
        $stock = json_encode($stock);
        return $stock;
    }

    public function autocompletar(Request $request)
    {

        $data = $request->all();

        $term = $data['term'];

        $productos = Producto::select()
            ->join('catalogo_has_productos', 'catalogo_has_productos.estilo', '=', 'productos.estilo')
            ->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->where('catalogos.estado', 'PUBLICADO')
            ->where('productos.nombre_producto', 'LIKE', '%' . $term . '%')
            ->groupBy('productos.estilo')
            ->get();

        $response = array();

        foreach ($productos as $producto) {
            $response[] = array("value" => $producto->nombre_producto, "estilo" => $producto->estilo, "seccion" => $producto->seccion, "imagen_path" => $producto->imagen_path);
        }

        if (count($response) == 0) {
            $response[] = array("value" => "");
        }

        return response()->json($response);
    }
    public function checkout_view()
    {
        $catalogos = Catalogo::where('estado', 'PUBLICADO')->get();
        $condiciones = [];
        $productoPremio = [];
        $empresaria = new Empresaria();
        $provincia = DB::table('provincias')->where('estado', 'A')->get();
        $ciudad = '';
        $flagPremioEmpresaria = 0;
        $flagPremioPedido = 0;
        $contPremio = 0;
        $contRegla = 0;
        foreach ($catalogos as $catalogo) {
            $condicion = Premio::where('catalogo_id', $catalogo->id)->get();
        }
        if (!empty(Auth::user())) {
            if (Auth::user()->role == 'Empresaria') {
                $empresaria = Empresaria::select('empresarias.*', 'ciudades.provincia_id')->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')->where('empresarias.id_user', Auth::user()->id)->first();
                // if (!empty($condiciones)) {
                //     foreach ($condiciones as $i => $condicion) {
                //         $reglas = json_decode($condicion->condicion);
                //         if ($reglas[0]->nombre_tabla == 'empresarias') {
                //             $premio = DB::table($reglas[0]->nombre_tabla)->whereRaw($reglas[0]->condicion)->get();
                //             foreach ($premio as  $val) {
                //                 if ($val->id_user == Auth::user()->id) {
                //                     $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $condicion->id)->groupBy('productos.estilo')->get();
                //                     foreach ($producto as  $value) {
                //                         array_push($productoPremio, $value);
                //                     }
                //                 }
                //             }
                //         }
                //         if ($reglas[0]->nombre_tabla == 'pedidos') {
                //             $rule = $reglas[0]->condicion;
                //             $total_factura = Cart::total();
                //             $rule  = str_replace('total_factura', $total_factura, $rule);
                //             //pendiente validar por total de factura
                //         }
                //     }
                // }
                if (!empty($condicion)) {
                    foreach ($condicion as $i => $value) {
                        $reglas = json_decode($value->condicion);
        
                        foreach($reglas as $itemRegla){
                            if ($itemRegla->nombre_tabla == 'empresarias') {
                                if(!$flagPremioEmpresaria){
                                    $valores = explode(' ', $itemRegla->condicion);
                                    $estado = '"'.$valores[2].'"';
                                    //$premio = DB::table($itemRegla->nombre_tabla)->whereRaw("'".$valores[0]." ".$valores[1]." ".$estado."'")->get();
                                    $premio = DB::table($itemRegla->nombre_tabla)->whereRaw($itemRegla->condicion)->get();
                                    foreach ($premio as  $val) {
                                        if ($val->id_user == $empresaria->id_user) {
                                            $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $value->id)->groupBy('productos.estilo')->get();
                                            foreach ($producto as  $value) {
                                                $colores = Producto::where('estilo', $value->estilo)->groupBy('color')->get('color');
                                                $colores2 = [];
                                                foreach ($colores as  $color) {
                                                    array_push($colores2, $color->color);
                                                }
                                                $value->colores = $colores2;
                                                $tallas = Producto::where('estilo', $value->estilo)->groupBy('talla')->get('talla');
                                                $tallas2 = [];
                                                foreach ($tallas as $talla) {
                                                    array_push($tallas2, $talla->talla);
                                                }
                                                $value->tallas = $tallas2;
                                                array_push($productoPremio, $value);
                                            }
                                            //$json['premios'] = $productoPremio;
                                            $flagPremioEmpresaria = 1;
                                            $contPremio ++;
                                        }
                                    }
                                }
                            }
                            if ($itemRegla->nombre_tabla == 'pedidos') {
                                $rule = $itemRegla->condicion;
                                $total_factura = Cart::total();
                                $rule  = str_replace('total_factura', $total_factura, $rule);
        
                                $valores = explode(' ', $rule);
                                $dbValor = str_replace("'","",$valores[2]);
                                if($valores[1] == '>'){
                                    if($total_factura > $dbValor){
                                        $flagPremioPedido = 1;
                                    }
                                }elseif($valores[1] == '>='){
                                    if($total_factura >= $dbValor){
                                        $flagPremioPedido = 1;
                                    }
                                }
        
                                if($flagPremioPedido){
                                    $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $value->id)->groupBy('productos.estilo')->get();
                                    foreach ($producto as  $value) {
                                        $colores = Producto::where('estilo', $value->estilo)->groupBy('color')->get('color');
                                        $colores2 = [];
                                        foreach ($colores as  $color) {
                                            array_push($colores2, $color->color);
                                        }
                                        $value->colores = $colores2;
                                        $tallas = Producto::where('estilo', $value->estilo)->groupBy('talla')->get('talla');
                                        $tallas2 = [];
                                        foreach ($tallas as $talla) {
                                            array_push($tallas2, $talla->talla);
                                        }
                                        $value->tallas = $tallas2;
                                        array_push($productoPremio, $value);
                                    }
                                    $contPremio ++;
                                }
                                //pendiente validar por total de factura
                            }
                            $contRegla ++;
        
                        }
                        if($contPremio == $contRegla){
                            $productoPremio;
                        }else {
                            $productoPremio = [];
                        }
                        $contPremio = 0;
                        $contRegla = 0;
                        $flagPremioEmpresaria = 0;
                        $flagPremioPedido = 0;
                    }
                }


                $ciudad = DB::table('ciudades')->where('provincia_id', $empresaria->provincia_id)->where('estado', 'A')->get();
            }
        }        
        return view('ecomerce.checkout', compact('productoPremio', 'empresaria', 'provincia', 'ciudad'));
    }
    public function dataCheckout(Request $request)
    {
        if (isset($request->premios)) {            
            $premios = $request->premios;
            if (count($premios)>0) {
                foreach ($premios as $val) {                 
                    $pro = Producto::where('estilo',$val['estilo'])->where('talla',$val['talla'])->where('color',$val['color'])->first();
                    Cart::add($pro->id, $pro->nombre_mostrar, 1, 0, ['image' => $pro->imagen_path])->associate('App\Models\Producto');
                }
            }
        }
        $productos_pedidos = Cart::content();
        $id_pedidos = '';
        $empresaria = Empresaria::where('cedula', $request->cedula)->first();
        if ($empresaria->tipo_cliente == 'NUEVA') {
            Empresaria::find($empresaria->id)->update(['tipo_cliente' => 'CONTINUA']);
        }
        if (empty($request->observaciones)) {
            $request->observaciones = 'SIN OBSERVACIONES';
        }
        $venta = Venta::create([
            'id_vendedor' => $empresaria->vendedor,
            'id_empresaria' => $empresaria->id,
            'factura_identificacion' => $request->cedula,
            'factura_nombres' => ($request->nombres . ' ' . $request->apellidos),
            'direccion_envio' => $request->direccion,
            'codigo_postal' => $request->codigo_postal,
            'cantidad_total' => count(Cart::content()),
            'total_venta' => $request->total_pagar,
            'estado' => 'PEDIDO',
            'observaciones'=> $request->observaciones
        ]);
        foreach ($productos_pedidos as $producto) {
            $pedido = Pedido::create([
                'id_producto' => $producto->id,
                'id_venta' => $venta->id,
                'cantidad' => $producto->qty,
                'precio' => $producto->price,
                'total' => number_format(($producto->price * $producto->qty), 2),
                'estado' => 'PEDIDO',
                'usuario' => Auth::user()->id,
            ]);
            $pro = Producto::where('id', $producto->id)->first();
            $nuevo_stock = $pro->stock - $producto->qty;
            Producto::where('id', $producto->id)->update(['stock' => $nuevo_stock]);
            $id_pedidos .= $pedido->id . '|';
        }
        Venta::where('id', $venta->id)->update([
            'id_pedidos' => $id_pedidos
        ]);
        Cart::destroy();
        $response = [];
        if (!empty($venta)) {
            $response['id_venta'] = $venta->id;
        }
        return $response;
    }
    public function detalle_pedido($id_venta)
    {
        $pedidos = Pedido::where('id_venta', $id_venta)
            ->join('productos', 'productos.id', '=', 'pedidos.id_producto')
            ->select('pedidos.*', 'productos.clasificacion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto')
            ->get();
        $i = 1;
        $venta = Venta::find($id_venta);
        return view('ecomerce.detalle-pedido', compact('pedidos', 'i', 'venta', 'id_venta'));
    }
    public function autocompletar_empresaria(Request $request)
    {
        $empresarias = Empresaria::where('cedula', 'LIKE', '%' . $request->term . '%')
            ->orWhere('nombres', 'LIKE', '%' . $request->term . '%')->get();
        $response = [];
        foreach ($empresarias as $empresaria) {
            array_push($response, ($empresaria->cedula . ' | ' . $empresaria->nombres));
        }
        return json_encode($response);
    }
    public function data_empresaria(Request $request)
    {
        $empresaria = Empresaria::where('cedula', $request->cedula)->orWhere('nombres', $request->nombres)
            ->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
            ->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
            ->select('empresarias.*', 'ciudades.descripcion as nombre_ciudad', 'provincias.descripcion as nombre_provincia', 'provincias.id as provincia_id')->first();
        $json = [];
        $json['empresaria'] = $empresaria;
        $catalogos = Catalogo::where('estado', 'PUBLICADO')->get();
        $condicion = [];
        $productoPremio = [];
        $flagPremioEmpresaria = 0;
        $flagPremioPedido = 0;
        $contPremio = 0;
        $contRegla = 0;

        $json['ciudad'] = DB::table('ciudades')->where('provincia_id', $empresaria->provincia_id)->where('estado', 'A')->get();

        foreach ($catalogos as $catalogo) {
            $condicion = Premio::where('catalogo_id', $catalogo->id)->get();
            // if (!empty($condicion)) {
            //     foreach ($condicion as  $value) {
            //         array_push($condiciones, $value);
            //     }
            // }
        }
        if (!empty($condicion)) {
            foreach ($condicion as $i => $value) {
                $reglas = json_decode($value->condicion);

                foreach($reglas as $itemRegla){
                    if ($itemRegla->nombre_tabla == 'empresarias') {
                        if(!$flagPremioEmpresaria){
                            $valores = explode(' ', $itemRegla->condicion);
                            $estado = '"'.$valores[2].'"';
                            //$premio = DB::table($itemRegla->nombre_tabla)->whereRaw("'".$valores[0]." ".$valores[1]." ".$estado."'")->get();
                            $premio = DB::table($itemRegla->nombre_tabla)->whereRaw($itemRegla->condicion)->get();
                            foreach ($premio as  $val) {
                                if ($val->id_user == $empresaria->id_user) {
                                    $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $value->id)->groupBy('productos.estilo')->get();
                                    foreach ($producto as  $value) {
                                        $colores = Producto::where('estilo', $value->estilo)->groupBy('color')->get('color');
                                        $colores2 = [];
                                        foreach ($colores as  $color) {
                                            array_push($colores2, $color->color);
                                        }
                                        $value->colores = $colores2;
                                        $tallas = Producto::where('estilo', $value->estilo)->groupBy('talla')->get('talla');
                                        $tallas2 = [];
                                        foreach ($tallas as $talla) {
                                            array_push($tallas2, $talla->talla);
                                        }
                                        $value->tallas = $tallas2;
                                        array_push($productoPremio, $value);
                                    }
                                    //$json['premios'] = $productoPremio;
                                    $flagPremioEmpresaria = 1;
                                    $contPremio ++;
                                }
                            }
                        }
                    }
                    if ($itemRegla->nombre_tabla == 'pedidos') {
                        $rule = $itemRegla->condicion;
                        $total_factura = Cart::total();
                        $rule  = str_replace('total_factura', $total_factura, $rule);

                        $valores = explode(' ', $rule);
                        $dbValor = str_replace("'","",$valores[2]);
                        if($valores[1] == '>'){
                            if($total_factura > $dbValor){
                                $flagPremioPedido = 1;
                            }
                        }elseif($valores[1] == '>='){
                            if($total_factura >= $dbValor){
                                $flagPremioPedido = 1;
                            }
                        }

                        if($flagPremioPedido){
                            $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $value->id)->groupBy('productos.estilo')->get();
                            foreach ($producto as  $value) {
                                $colores = Producto::where('estilo', $value->estilo)->groupBy('color')->get('color');
                                $colores2 = [];
                                foreach ($colores as  $color) {
                                    array_push($colores2, $color->color);
                                }
                                $value->colores = $colores2;
                                $tallas = Producto::where('estilo', $value->estilo)->groupBy('talla')->get('talla');
                                $tallas2 = [];
                                foreach ($tallas as $talla) {
                                    array_push($tallas2, $talla->talla);
                                }
                                $value->tallas = $tallas2;
                                array_push($productoPremio, $value);
                            }
                            $contPremio ++;
                        }
                        //pendiente validar por total de factura
                    }
                    $contRegla ++;

                }
                if($contPremio == $contRegla){
                    $json['premios'] = $productoPremio;
                }else {
                    $productoPremio = [];
                }
                $contPremio = 0;
                $contRegla = 0;
                $flagPremioEmpresaria = 0;
                $flagPremioPedido = 0;
            }
        }
        return json_encode($json);
    }
    public function tracking_pedido($id_venta)
    {
        $venta = Venta::where('ventas.id', $id_venta)->join('users', 'users.id', '=', 'ventas.id_vendedor')->select('ventas.*', 'users.name')->first();
        return view('ecomerce.track-order', compact('venta'));
    }
    public function historial_compras()
    {
        $empresaria = Empresaria::where('id_user', Auth::user()->id)->first();
        $ventas = Venta::where('id_empresaria', $empresaria->id)->get();
        return view('ecomerce.historial-compra', compact('ventas', 'empresaria'));
    }
    public function perfil_empresaria()
    {
        $empresaria = Empresaria::where('id_user', Auth::user()->id)->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
            ->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
            ->join('users', 'empresarias.vendedor', '=', 'users.id')
            ->select('empresarias.*', 'ciudades.descripcion as nombre_ciudad', 'provincias.descripcion as nombre_provincia', 'users.email as correo_vendedor', 'users.name as nombre_vendedor')
            ->first();
        return view('ecomerce.perfil-empresaria', compact('empresaria'));
    }
    public function detalle_compra_empresaria($id_venta)
    {
        $venta = Venta::where('id', $id_venta)->first();
        $empresaria = Empresaria::where('empresarias.id', $venta->id_empresaria)
            ->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
            ->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
            ->join('users', 'empresarias.vendedor', '=', 'users.id')
            ->select('empresarias.*', 'ciudades.descripcion as nombre_ciudad', 'provincias.descripcion as nombre_provincia', 'users.email as correo_vendedor', 'users.name as nombre_vendedor')
            ->first();
        $pedidos = Pedido::where('id_venta', $venta->id)
            ->join('productos', 'productos.id', '=', 'pedidos.id_producto')
            ->select('pedidos.*', 'productos.clasificacion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto')
            ->get();
        $i = 1;
        return view('ecomerce.factura-compra', compact('venta', 'empresaria', 'pedidos', 'i'));
    }
    public function seguimiento_pedidos()
    {
        $empresaria = Empresaria::where('id_user', Auth::user()->id)->first();
        $ventas = Venta::where('id_empresaria', $empresaria->id)->get();
        return view('ecomerce.seguimiento-pedidos', compact('ventas', 'empresaria'));
    }
    public function sobre_nosotros()
    {
        return view('ecomerce.sobre-nosotros');
    }
    public function contacto()
    {
        return view('ecomerce.contactanos'); 
    }
    public function preguntasFrecuentes()
    {
        return view('ecomerce.preguntas-frecuentes');
    }
    public function terminosCondiciones()
    {
        return view('ecomerce.terminos-condiciones');
    }
    public function politicaPrivacidad()
    {
        return view('ecomerce.politica-privacidad');
    }
    public function registroEmpresaria()
    {
        $provincias = DB::table('provincias')->get();
        return view('ecomerce.registro-empresarias',compact('provincias'));
    }
    public function consultarCiudad()
    {
        $ciudades = DB::table('ciudades')
            ->where('provincia_id', '=', $_POST['id_provincia'])
            ->get();
        return json_encode($ciudades);
    }
    public function registrarEmpresariaNueva(Request $request){
        $request->validate([
            'nombres' => 'required|max:255',
            'apellidos' => 'required',
            'cedula' => 'required|unique:empresarias,cedula',
            'email' => 'required|unique:users,email',
            'telefono' => 'required',
            'direccion' => 'required',
        ]);
        $contrseña = Str::random(8); 
        $userData = [
            'name'=>trim(strtoupper($request->nombres)),
            'email'=>trim($request->email),
            'password'=>Hash::make($contrseña),
            'role'=>'Empresaria'
        ];
        $user = User::create($userData);
        $user->roles()->sync(2);// 2 es el id de el rol de empresaria 
        $empresariaData = [
            'cedula'=> trim($request->cedula),
            'nombres'=> trim(strtoupper($request->nombres)),
            'apellidos'=> trim(strtoupper($request->apellidos)),
            'fecha_nacimiento'=> $request->fecha_nacimiento,
            'direccion'=> trim(strtoupper($request->direccion)),
            'tipo_cliente'=> 'PROSPECTO',
            'telefono'=> trim($request->telefono),
            'id_ciudad'=> $request->ciudad,
            'vendedor'=> 0,
            'id_user'=> $user->id
        ];
        Empresaria::create($empresariaData);
        $correo = new RegistroEmpresaria($request->all(),$contrseña);

        Mail::to($request->email)->send($correo);

        return view('ecomerce.registro-exitoso');
    }
}
