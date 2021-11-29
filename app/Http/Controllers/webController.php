<?php

namespace App\Http\Controllers;

use App\Catalogo;
use App\Empresaria;
use App\Models\Pedido;
use App\Models\Venta;
use App\Premio;
use Illuminate\Support\Facades\DB;
use App\Producto;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;

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
            ->where('categoria','Hombre')
            ->groupBy('productos.estilo')->limit(8)->get();            
        $productos_mujer = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
        ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
        ->where('catalogos.estado', '=', 'PUBLICADO')->where('productos.estado','A')
        ->where('productos.stock','>',0)
        ->where('categoria','Mujer')
        ->groupBy('productos.estilo')->limit(8)->get();
        $productos_niños = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->where('catalogos.estado', '=', 'PUBLICADO')->where('productos.estado','A')->where('productos.stock','>',0)
            ->where('categoria','Niñas')->orWhere('categoria','Niños')
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
        $cart = Cart::add($producto->id, $producto->nombre_mostrar, 1, number_format($precio, 2), ['image' => $producto->imagen_path])->associate('App\Models\Producto');
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
            ->groupBy('productos.estilo')->paginate(8);

        if(!empty(request('orderby'))){
            switch (request('orderby')) {
                case 'nombre':
                    //$productos->orderBy(request('orderby'), request('orderway'));
                    break;
                case 'Popular':
                    
                    break;
                case 'Ohirgi':
                    
                    break;
                default:
                    // $doctors->orderby('id', 'asc');
                    break;
            }
        }
        //$productos->paginate(8);
        return view('ecomerce.tienda', compact('productos'));
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
        return view('ecomerce.producto-detalle', compact('productos_color', 'catalogo', 'tallas'));
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
        foreach ($catalogos as $catalogo) {
            $condicion = Premio::where('catalogo_id', $catalogo->id)->get();
            if (!empty($condicion)) {
                foreach ($condicion as  $value) {
                    array_push($condiciones, $value);
                }
            }
        }
        if (!empty(Auth::user())) {
            if (Auth::user()->role == 'Empresaria') {
                $empresaria = Empresaria::where('id_user', Auth::user()->id)->first();
                if (!empty($condiciones)) {
                    foreach ($condiciones as $i => $condicion) {
                        $reglas = json_decode($condicion->condicion);
                        if ($reglas[0]->nombre_tabla == 'empresarias') {
                            $premio = DB::table($reglas[0]->nombre_tabla)->whereRaw($reglas[0]->condicion)->get();
                            foreach ($premio as  $val) {
                                if ($val->id_user == Auth::user()->id) {
                                    $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $condicion->id)->groupBy('productos.estilo')->get();
                                    foreach ($producto as  $value) {
                                        array_push($productoPremio, $value);
                                    }
                                }
                            }
                        }
                        if ($reglas[0]->nombre_tabla == 'pedidos') {
                            $rule = $reglas[0]->condicion;
                            $total_factura = Cart::total();
                            $rule  = str_replace('total_factura', $total_factura, $rule);
                            //pendiente validar por total de factura
                        }
                    }
                }
            }
        }
        return view('ecomerce.checkout', compact('productoPremio', 'empresaria'));
    }
    public function dataCheckout(Request $request)
    {
        $productos_pedidos = Cart::content();
        $id_pedidos = '';
        $empresaria = Empresaria::where('cedula', $request->cedula)->first();
        if ($empresaria->tipo_cliente == 'NUEVA') {
            Empresaria::find($empresaria->id)->update(['tipo_cliente' => 'CONTINUA']);
        }
        $venta = Venta::create([
            'id_vendedor' => $empresaria->vendedor,
            'id_empresaria' => $empresaria->id,
            'factura_identificacion' => $request->cedula,
            'factura_nombres' => ($request->nombres . ' ' . $request->apellidos),
            'direccion_envio' => $request->direccion,
            'codigo_postal' => $request->codigo_postal,
            'cantidad_total' => $request->total_productos,
            'total_venta' => $request->total_pagar,
            'estado' => 'PEDIDO'
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
            ->select('empresarias.*', 'ciudades.descripcion as nombre_ciudad', 'provincias.descripcion as nombre_provincia')->first();
        $json = [];
        $json['empresaria'] = $empresaria;
        $catalogos = Catalogo::where('estado', 'PUBLICADO')->get();
        $condiciones = [];
        $productoPremio = [];
        foreach ($catalogos as $catalogo) {
            $condicion = Premio::where('catalogo_id', $catalogo->id)->get();
            if (!empty($condicion)) {
                foreach ($condicion as  $value) {
                    array_push($condiciones, $value);
                }
            }
        }
        if (!empty($condiciones)) {
            foreach ($condiciones as $i => $condicion) {
                $reglas = json_decode($condicion->condicion);
                if ($reglas[0]->nombre_tabla == 'empresarias') {
                    $premio = DB::table($reglas[0]->nombre_tabla)->whereRaw($reglas[0]->condicion)->get();
                    foreach ($premio as  $val) {
                        if ($val->id_user == $empresaria->id_user) {
                            $producto = DB::table('premio_has_productos')->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')->where('premio_id', $condicion->id)->groupBy('productos.estilo')->get();
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
                            $json['premios'] = $productoPremio;
                        }
                    }
                }
                if ($reglas[0]->nombre_tabla == 'pedidos') {
                    $rule = $reglas[0]->condicion;
                    $total_factura = Cart::total();
                    $rule  = str_replace('total_factura', $total_factura, $rule);
                    //pendiente validar por total de factura
                }
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
}
