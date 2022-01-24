<?php

namespace App\Http\Controllers;

use App\Empresaria;
use App\Models\Venta;
use App\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class ProveedorController
 * @package App\Http\Controllers
 */
class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reporte.index');
    }

    public function empresariaReports()
    {
        $id_usuario = Auth::user()->id;
        //dd($id_usuario);
        $response = '';
        if ($_POST['funcion'] == 'empresaria_venta') {

            $ventas = Venta::where('empresarias.vendedor', $id_usuario)
            ->join('empresarias', 'empresarias.id', '=', 'ventas.id_empresaria')
            ->select('empresarias.cedula')
            ->selectRaw('ROUND(sum(ventas.total_venta),2) as total')
            ->selectRaw('concat_ws(" ", empresarias.nombres, empresarias.apellidos) as nombres')
            ->groupBy('empresarias.cedula')
            ->get();
            if (count($ventas) == 0) {
                $ventas = 'no data';
            }
            $response = json_encode($ventas);
        }
        if ($_POST['funcion'] == 'empresaria_estado') {

            $empresarias = Empresaria::where('vendedor', $id_usuario)
            ->select('cedula', 'tipo_cliente')
            ->selectRaw('concat_ws(" ", nombres, apellidos) as nombres')
            ->get();
            if (count($empresarias) == 0) {
                $empresarias = 'no data';
            }
            $response = json_encode($empresarias);
        }
        return $response;
    }
    
}
