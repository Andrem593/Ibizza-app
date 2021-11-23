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
            ->where('catalogos.estado', '=', 'PUBLICADO')
            ->groupBy('productos.estilo')->get();
        $marcas = DB::table('marcas')->where('imagen', '<>', '')->get();
        $catalogos = DB::table('catalogos')->where('estado', '=', 'PUBLICADO')->get();
        return view('welcome2', compact('marcas', 'productos', 'catalogos'));
    }
    public function addToCart(Request $request)
    {
        if (!empty($request->talla)) {
            $producto = Producto::where('color', $request->color)->where('clasificacion', $request->clasificacion)->where('talla', $request->talla)->first();
        } else {
            $producto = Producto::where('color', $request->color)->where('clasificacion', $request->clasificacion)->first();
        }
        $cart = Cart::add($producto->id, $producto->nombre_producto, 1, $producto->valor_venta, ['image' => $producto->imagen_path])->associate('App\Models\Producto');
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
            ->groupBy('productos.estilo')->get();
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
            $id_pedidos .= $pedido->id . '|';
        }
        Venta::where('id', $venta->id)->update([
            'id_pedidos' => $id_pedidos
        ]);
        // Cart::destroy();                
        $response = [];
        if (!empty($venta)) {
            $response['id_venta'] = $venta->id;
        }
        return $response;
    }
    public function detalle_pedido($id_venta)
    {
        $pedidos = Pedido::where('id_venta', $id_venta)->join('productos', 'productos.id', '=', 'pedidos.id_producto')->select('pedidos.*', 'productos.clasificacion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto')->get();
        $i = 1;
        $venta = Venta::find($id_venta);
        return view('ecomerce.detalle-pedido', compact('pedidos', 'i', 'venta'));
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
            $json['premios'] = $productoPremio;
        }
        return json_encode($json);
    }
}
