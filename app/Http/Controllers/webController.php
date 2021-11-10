<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Producto;
use Illuminate\Http\Request;
use Cart;

class webController extends Controller
{
    public function __invoke()
    {
        $productos = DB::table('catalogo_has_productos')->join('catalogos','catalogos.id','=','catalogo_has_productos.catalogo_id')
        ->join('productos','productos.estilo','=','catalogo_has_productos.estilo')
        ->where('catalogos.estado','=','PUBLICADO')
        ->groupBy('productos.grupo','productos.seccion','productos.clasificacion')->get();
        $marcas = DB::table('marcas')->where('imagen','<>','')->get();
        $catalogos = DB::table('catalogos')->where('estado','=','PUBLICADO')->get();
        return view('welcome2',compact('marcas','productos','catalogos'));
    }
    public function addToCart(Request $request){
        if (!empty($request->talla)) {
            $producto = Producto::where('color',$request->color)->where('clasificacion',$request->clasificacion)->where('talla',$request->talla)->first();
        }else{
            $producto = Producto::where('color',$request->color)->where('clasificacion',$request->clasificacion)->first();
        }
        $cart = Cart::add($producto->id,$producto->nombre_producto,1,$producto->valor_venta,['image'=> $producto->imagen_path ])->associate('App\Models\Producto');
        return 'add';
    }
    public function deleteToCart(Request $request){
        Cart::remove($request->id);
        $response = [
            'message'=>'deleted',
            'subtotal'=>Cart::subtotal(),
            'tax'=>Cart::tax(),
            'total'=>Cart::total()
        ];
        json_encode($response);
        return $response;
    }
}
