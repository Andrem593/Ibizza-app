<?php

namespace App\Http\Controllers;

use App\Empresaria;
use App\Models\CambioPedido;
use App\Models\PagosCambio;
use App\Models\ProductoCambio;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use PDF ;

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

            $changeOrder = CambioPedido::with('businesswomen', 'requestedChanges')->orderBy('id', 'desc')
                ->get()
                ->map(function($change){
                    $change->factura_identificacion = $change->f_cedula ;
                    $change->factura_nombres = $change->f_nombre ;
                    $change->direccion_envio = $change->e_direccion ;
                    $change->empresaria = $change->businesswomen->nombre_completo ;
                    //corregir esta variable
                    $change->referencia = $change->referencia ;

                    //esto ver si se agregan los campos
                    $change->cantidad_total = $change->requestedChanges->sum('cantidad') ;

                    return $change ;

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

    public function editarCambio(Request $request)
    {
        CambioPedido::where('id',$request->id)->update(['estado'=>$request->estado_editar]);
        return 'editado';
    }

    public function datosCambios(Request $request)
    {
        $productChange = ProductoCambio::with('product', 'changeOrder')->where('id_cambio', $request->id)->get();
        $changeOrder = CambioPedido::with('seller', 'requestedChanges')->findOrFail($request->id);
        $businesswoman = Empresaria::where('id', $changeOrder->id_empresaria)
            ->with('usuario')
            ->first();

        $json = [];
        $json['cambio_detalle'] = $productChange;
        $json['shipping_information'] = $changeOrder;
        $json['cambio_encabezado'] = $changeOrder;
        $json['businesswoman'] = $businesswoman;
        $json['role'] = Auth::user()->role;
        return json_encode($json);

    }

    public function generarComprobante($id)
    {

        $changeOrder = CambioPedido::with('seller', 'user', 'requestedChanges.product', 'province', 'city', 'businesswomen')
            ->findOrfail($id);

        $paymentsChange = PagosCambio::with('user')->where('id_cambio', $id)->latest()->get();

        $pdf = PDF::loadView('cambio.comprobante', compact('changeOrder','paymentsChange'));
        $pdf->getDomPDF();
        return $pdf->stream('comprobante.pdf');
    }


    public function deleteChangeOrder(Request $request)
    {
        try {
            DB::beginTransaction();
                $changeOrder = CambioPedido::findOrFail($request->id);

                if($changeOrder->estado == 'ANULADO'){
                    return response()->json(['message' => 'No puede volver anular un cambio'], 500);
                }

                $productChange = ProductoCambio::where('id_cambio', $changeOrder->id )->get();

                foreach ($productChange as $key => $detail) {
                    $product = Producto::findOrFail($detail->id_producto);
                    $product->stock += $detail->cantidad ;
                    $product->save();
                }

                $changeOrder->estado = 'ANULADO';
                $changeOrder->save();

            DB::commit();

            return response()->json(['message' => 'Eliminado con éxito'], 200);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['message' => 'Ha ocurrido un error'], 500);
        }
    }
}
