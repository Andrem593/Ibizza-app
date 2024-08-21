<?php

namespace App\Http\Controllers;

use PDF;
use DateTime;
use App\Empresaria;
use App\Models\Pago;
use App\Models\Venta;
use App\Models\Pedido;
use App\Models\Separado;
use App\Models\CambioPedido;
use Illuminate\Http\Request;
use App\Models\DireccionVenta;
use App\Models\Pedidos_pendiente;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class VentaController extends Controller
{
    public function index(){
        return view('venta.index');
    }
    public function ventasDataTable(Request $request)
    {
        $response = '';
        if ($request->post('funcion') == 'listar_todo') {

            // $rol = Auth::user()->hasRole('Administrador');
            $ventas = Venta::join('empresarias', 
            'empresarias.id', '=', 
            'ventas.id_empresaria')->orderBy('ventas.id','desc');

        
            if (Auth::user()->role == 'ASESOR') {
                $ventas = $ventas->where("ventas.id_vendedor", Auth::user()->id); 
            }

            $ventas = $ventas->select('ventas.*')->selectRaw('concat_ws(" ", empresarias.nombres, empresarias.apellidos) as empresaria')->get();
            if (count($ventas) == 0) {
                $ventas = 'no data';
            }
            $response = json_encode($ventas);
        }

        //leidy 03/05/2024: Función para buscar por nuevos criterios: estado de facturación, estado de validación y fechas
        if ($request->post('funcion') == 'criterios'){
            $estado_validacion = $request->post('estado_validacion');
            $estado_facturacion = $request->post('estado_facturacion');
            $fecha_desde = $request->post('fecha_desde');
            $fecha_hasta = $request->post('fecha_hasta');

            $ventas = Venta::join('empresarias', 
            'empresarias.id', '=', 
            'ventas.id_empresaria')->orderBy('ventas.id','desc');

            //Si el asesor inicia sesión, solo se muestran sus ventas
            if (Auth::user()->role == 'ASESOR') {
                $ventas = $ventas->where("ventas.id_vendedor", Auth::user()->id); 
            }

            //Evaluamos que el estado de facturación y validación no tengan valor nulo
            //y los agregamos al filtro del where
            if ($estado_validacion != null && $estado_facturacion != null){
                $ventas = $ventas
                ->where("ventas.estado_facturacion", $estado_facturacion)
                ->where("ventas.estado_validacion", $estado_validacion);
            }
           
            //Hacemos lo mismo con las fechas y que no tengan valor nulo
            if (($fecha_desde != null && $fecha_desde != "" ) && ($fecha_hasta != null && $fecha_hasta != "")){
                $ventas = $ventas->whereBetween('ventas.created_at', [$fecha_desde, $fecha_hasta]);
            }
            

            $ventas = $ventas->select('ventas.*')->selectRaw('concat_ws(" ", empresarias.nombres, empresarias.apellidos) as empresaria')->get();
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
        ->select('pedidos.*', 'productos.sku','productos.descripcion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto')
        ->get();
        $venta = Venta::where('id', $request->id_venta)
        ->with('vendedor')
        ->first();
        $direccionVenta = DireccionVenta::where('id_venta', $request->id_venta)
        ->with('ciudad')
        ->first();
        $empresaria = Empresaria::where('id', $venta->id_empresaria)
        ->with('usuario')
        ->first();
        $json = [];
        $json['pedidos'] = $pedidos;
        $json['venta'] = $venta;
        $json['empresaria'] = $empresaria;
        $json['rol'] = Auth::user()->role;
        $json['direccionVenta'] = $direccionVenta;
        return json_encode($json);
    }
    public function datosPedido(Request $request)
    {
        $pedidos = Pedido::where('id_venta',$request->id_venta)
        ->join('productos', 'productos.id', '=', 'pedidos.id_producto')
        ->select('pedidos.*', 'productos.clasificacion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto')
        ->get();
        $venta = Venta::where('id', $request->id_venta)
        ->with('vendedor')
        ->first();
        $empresaria = Empresaria::where('id', $venta->id_empresaria)
        ->with('usuario')
        ->first();
        $json = [];
        $json['pedidos'] = $pedidos;
        $json['venta'] = $venta;
        $json['empresaria'] = $empresaria;
        return json_encode($json);
    }

    //leidy 03/05/2024: Guardamos los estados de validación y facturación
    public function editarVenta(Request $request){

        //leidy 03/05/2024: si el rol es validador O ADMIN, guardamos el id del usuario validador
        if (Auth::user()->role == 'VALIDADOR' || Auth::user()->role == 'ADMINISTRADOR') {
            Venta::where('id',$request->id_venta)->update([
                'estado_validacion'     => $request->estado_validacion_editar,
                'usuario_validacion'    => Auth::user()->id,
                'fecha_validacion'      =>  new Datetime()
            ]);
        }

         //leidy 03/05/2024: si el rol es facturador O ADMIN, guardamos el id del usuario facturador
        if (Auth::user()->role == 'LOGISTICO' || Auth::user()->role == 'ADMINISTRADOR') {
            Venta::where('id',$request->id_venta)->update([
                'estado_facturacion'    =>$request->estado_facturacion_editar,
                'usuario_facturacion'   => Auth::user()->id,
                'fecha_facturacion'     => new Datetime()
            ]);
        }

        return 'editado';
    }

    public function ventasUpload(){
        return view('venta.upload');
    }

    public function cambioUpload(){
        return view('venta.uploadCambios');
    }

    public function saveExcel(Request $request)
    {
        try {
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
    
                    //leidy 03/05/2024:Se guarda la fecha de facturacion y el usuario de facturacion en la carga masiva
                    $update_data = [
                        'n_factura'  => $row[1],
                        'n_guia'  => $row[2],
                        'n_transferencia'  => $row[3],
                        // 'id_vendedor'  => $row[3],  
                        //'estado_validacion'  => $row[4],
                        'estado_facturacion'  => $row[4],
                        'fecha_facturacion' => new Datetime(),
                        'usuario_facturacion' => Auth::user()->id
                    ];
    
                    $update = Venta::where('id', $row[0])->update($update_data);
    
                    if($update > 0 ){
                        $cont++;
                    }
    
                }
            }
    
            return redirect()->route('venta.upload')
                ->with('success', 'Se actualizaron '.$cont.' registros');
        } catch (\Throwable $th) {
            return redirect()->route('venta.upload')
                ->with('error', 'Existe un error en el archivo excel');
        }
        
    }
    public function tomar_pedido($empresaria = null, $envio = 0)
    {                
        if ($empresaria != null) {
            $empresaria = Empresaria::find($empresaria);
        }
        return view('venta.pedido', compact('empresaria','envio'));
    }
    public function pedidos_guardados()
    {
        return view('venta.pedidos-guardados');
    }
    public function pedidos_reservados()
    {
        return view('venta.pedidos-reservados');
    }

    public function datatable_reservas()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $reservas = Separado::with('usuario', 'empresaria')->get();
            if (count($reservas) == 0) {
                $reservas = 'no data';
            }
            $response = json_encode($reservas);
        }
        return $response;
    }
    public function cargaRecibo()
    {
        if (!empty($_FILES["file"])) {
            $venta = Venta::find($_POST['idVenta']);            
            $image = $venta->factura_identificacion.".".date('d.m.Y.h.i.s').".".$_FILES["file"]['name'];
            $ruta = public_path('storage/images/recibos/') . $image;
            Image::make($_FILES["file"]["tmp_name"])
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta); 
            $venta->recibo = 'storage/images/recibos/'.$image;
            $venta->save();                
        }
    }

    public function generarComprobante($id)
    {
        //Se extraen los datos del pedido
        $pedidos = Pedido::where('id_venta',$id)
        ->join('productos', 'productos.id', '=', 'pedidos.id_producto')
        ->select('pedidos.*', 'productos.sku as sku' ,'productos.descripcion as nombre_producto', 'productos.talla as talla_producto', 'productos.color as color_producto', 'productos.imagen_path as imagen_path')
        ->get();
        
        //Se extraen los datos de la venta
        $venta = Venta::where('id', $id)
        ->with('vendedor')
        ->first();
        
        //Se extraen los datos de la dirección de venta
        $direccionVenta = DireccionVenta::where('id_venta', $id)
        ->with('ciudad')
        ->first();
        
        //Se extraen los datos de la empresaria
        $empresaria = Empresaria::where('id', $venta->id_empresaria)
        ->with('usuario', 'pedidos')
        ->first();
        
        //Se extraen los datos de los pagos de esa venta
        $pagos = Pago::with('usuario')->where('id_venta', $id)->latest()->get();
        $valorRecaudadoTotal = collect($pagos)->map(function($pago){
            return $pago->valor_recaudado;
        })->sum();
        
        //Se carga la vista PDF
        $pdf = PDF::loadView('venta.comprobante', compact('pedidos', 'venta', 'empresaria', 'direccionVenta', 'pagos','valorRecaudadoTotal'));
        $pdf->getDomPDF();
        return $pdf->stream('comprobante.pdf');
    }

    public function generarPedidoGuardado($id)
    {
        //$reservas = Separado::with('usuario', 'empresaria')->where('id', $id)->first();
        $pedidos_pendientes = Pedidos_pendiente::where('id_separados', $id)->with('producto')->get();
        
        //Realizamos la relación entre provincias y ciudades
        $reservas = Separado::where('separados.id', $id)
        ->join('users', 'users.id', '=', 'separados.id_usuario')
        ->join('empresarias', 'empresarias.id', '=', 'separados.id_empresaria')
        ->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
        ->join('provincias', 'provincias.id', '=', 'ciudades.provincia_id')
        ->select('separados.*', 'ciudades.descripcion as ciudad','provincias.descripcion as provincia' )->first();
        
        
        $pdf = PDF::loadView('venta.comprobante-pedido-guardado', compact('reservas', 'pedidos_pendientes'));
        return $pdf->stream();
    }

    public function saveExcelCambio(Request $request)
    {
        try {
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
                        'n_factura_carga'  => $row[1],
                        'id_pedido'  => $row[2],
                        // 'id_vendedor'  => $row[3],
                        'estado'  => $row[4]
                    ];

                    $update = CambioPedido::where('id', $row[0])->update($update_data);

                    if($update > 0 ){
                        $cont++;
                    }

                }
            }

            return redirect()->route('cambio.upload')
                ->with('success', 'Se actualizaron '.$cont.' registros');
        } catch (\Throwable $th) {
            return redirect()->route('cambio.upload')
                ->with('error', 'Existe un error en el archivo excel');
        }

    }

    public function view_cambios()
    {
        return view('venta.cambios');
    }

    public function view_cambios_reservado($id)
    {
        Session::put('id', $id);
        return view('venta.cambios');
    }
}
