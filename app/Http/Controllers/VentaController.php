<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Venta;

class VentaController extends Controller
{
    public function index(){
        return view('venta.index');
    }
    public function ventasDataTable()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $ventas = Venta::all();
            if (count($ventas) == 0) {
                $ventas = 'no data';
            }
            $response = json_encode($ventas);
        }
        return $response;
    }
    public function datosVentas(Request $request)
    {
        $pedidos = Pedido::where('id_venta',$request->id_venta)
        ->join('productos', 'productos.id', '=', 'pedidos.id_producto')
        ->select('pedidos.*', 'productos.clasificacion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto')
        ->get();

        return json_encode($pedidos);
    }
}
