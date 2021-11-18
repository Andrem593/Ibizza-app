<?php

namespace App\Http\Controllers;

use App\Catalogo;
use App\Empresaria;
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
            ->where('nombre_producto', 'LIKE', '%' . $term . '%')
            ->groupBy('estilo')
            ->get();

        $response = array();

        foreach ($productos as $producto) {
            $response[] = array("value" => $producto->nombre_producto, "estilo" => $producto->estilo, "seccion" => $producto->seccion, "imagen_path" => $producto->imagen_path);
        }

        if(count($response)==0){
            $response[] = array("value" => "");
        }

        return response()->json($response);
    }
    public function checkout_view(){
        $catalogos = Catalogo::where('estado','PUBLICADO')->get();
        $condiciones = [];
        $productoPremio = [];  
        $empresaria = new Empresaria();   
        foreach ($catalogos as $catalogo) {
            $condicion = Premio::where('catalogo_id',$catalogo->id)->first();
            if (!empty($condicion) ) {        
                array_push($condiciones,$condicion);
                $reglas = json_decode($condiciones[0]->condicion);
            }
        }
        
        if (!empty(Auth::user())) {   
            if (Auth::user()->role == 'Empresaria') { 
                $empresaria = Empresaria::where('id_user',Auth::user()->id)->first();
                if (!empty($condicion)) {                
                    $premio = DB::table($reglas[0]->nombre_tabla)->whereRaw($reglas[0]->condicion)->get();
                    foreach ($premio as  $val) {
                        if ($val->id_user == Auth::user()->id) {
                            $productoPremio = DB::table('premio_has_productos')->join('productos','productos.estilo','=','premio_has_productos.estilo')->where('premio_id',$condiciones[0]->id)->groupBy('productos.estilo')->get();
                        }
                    }
                }
            }
        }
        return view('ecomerce.checkout',compact('productoPremio','empresaria'));        
    }
}
