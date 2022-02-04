<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Empresaria;

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
        $venta = Venta::where('id', $request->id_venta)->first();
        $empresaria = Empresaria::where('empresarias.id', $venta->id_empresaria)
            ->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
            ->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
            ->join('users', 'empresarias.vendedor', '=', 'users.id')
            ->select('empresarias.*', 'ciudades.descripcion as nombre_ciudad', 'provincias.descripcion as nombre_provincia', 'users.email as correo_vendedor', 'users.name as nombre_vendedor')
            ->first();
        $json = [];
        $json['pedidos'] = $pedidos;
        $json['venta'] = $venta;
        $json['empresaria'] = $empresaria;
        return json_encode($json);
    }
    public function editarVenta(Request $request){
        Venta::where('id',$request->id_venta)->update(['estado'=>$request->estado_editar]);
        return 'editado';
    }

    public function ventasUpload(){
        return view('venta.upload');
    }

    public function saveExcel(Request $request)
    {
        $request->validate([
            'excel' => 'required|max:10000|mimes:xlsx,xls'
        ]);

        $file_array = explode(".", $_FILES["excel"]["name"]);
        $file_extension = end($file_array);

        $file_name = time() . '.' . $file_extension;
        move_uploaded_file($_FILES["excel"]["tmp_name"], $file_name);
        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

        $spreadsheet = $reader->load($file_name);

        unlink($file_name);

        $data = $spreadsheet->getActiveSheet()->toArray();

        $cont = 0;

        foreach ($data as $key => $row) {
            if ($key >= 1) {

                $update_data = [
                    'n_factura'  => $row[1],
                    'n_guia'  => $row[2],
                    'estado'  => $row[3]
                ];

                $update = Venta::where('id', $row[0])->update($update_data);

                if($update > 0 ){
                    $cont++;
                }

            }
        }

        return redirect()->route('venta.upload')
            ->with('success', 'Se actualizaron '.$cont.' registros');
    }
    public function tomar_pedido()
    {
        return view('venta.pedido');
    }
    public function pedidos_guardados()
    {
        return view('venta.pedidos-guardados');
    }
}
