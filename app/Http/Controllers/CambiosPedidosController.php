<?php

namespace App\Http\Controllers;

use App\Empresaria;
use App\Models\CambioPedido;
use App\Models\ProductoCambio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CambiosPedidosController extends Controller
{

    public function index()
    {
        return view('cambio.index');
    }



    public function cambiosDataTable()
    {
        $response = '' ;
        if ($_POST['funcion'] == 'listar_todo') {

            $changeOrder = CambioPedido::with('businesswomen')->orderBy('id', 'desc')
                ->get()
                ->map(function($change){
                    $change->factura_identificacion = $change->f_cedula ;
                    $change->factura_nombres = $change->f_nombre ;
                    $change->direccion_envio = $change->e_direccion ;
                    $change->empresaria = $change->businesswomen->nombre_completo ;
                    //corregir esta variable
                    $change->observaciones = $change->obervaciones ;

                    //esto ver si se agregan los campos
                    $change->cantidad_total = 0 ;
                    $change->total_venta = 0 ;
                    $change->estado = 0 ;

                    return $change ;
                    // dd($change);

                });

            if (Auth::user()->role == 'ASESOR') {
                $changeOrder = $changeOrder->where("id_vendedor", Auth::user()->id);

            }

            if (count($changeOrder) == 0) {
                $changeOrder = 'no data';
            }

            $response = json_encode($changeOrder);

        }

        return $response ;

    }

    public function datosCambios(Request $request)
    {
        $productChange = ProductoCambio::where('id_cambio', $request->id)->get();
        $changeOrder = CambioPedido::findOrFail($request->id);
        $businesswoman = Empresaria::where('id', $productChange->id_empresaria)
            ->with('usuario')
            ->first();

        $json = [];
        $json['cambioDetalle'] = $productChange;
        $json['cambioEncabezado'] = $changeOrder;
        $json['empresaria'] = $businesswoman;
        $json['rol'] = Auth::user()->role;
        return json_encode($json);

    }
}
