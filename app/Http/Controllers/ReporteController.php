<?php

namespace App\Http\Controllers;

use App\Empresaria;
use App\Models\Venta;
use App\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

    public function graficos()
    {
        $anio_actual = Carbon::now()->format('Y');
        $anio_anterior = Carbon::now()->subYear()->format('Y');
        $meses = ['January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'];

        $ventas_actual = Venta::whereRaw('YEAR(created_at) = ?', $anio_actual)        
        ->selectRaw('count(*) as ventas')
        ->selectRaw('MONTHNAME(created_at) as nombre_mes')
        ->selectRaw('MONTH(created_at) as mes')
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

        $ventas_anterior = Venta::whereRaw('YEAR(created_at) = ?', $anio_anterior)        
        ->selectRaw('count(*) as ventas')
        ->selectRaw('MONTHNAME(created_at) as nombre_mes')
        ->selectRaw('MONTH(created_at) as mes')
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

        $data_actual = [];
        $data_anterior = [];

        foreach($meses as $row) {
            $valor = 0;
            foreach($ventas_actual as $item) {
                if($row == $item->nombre_mes){
                    $valor = (int) $item->ventas;
                }
            }
            $data_actual['label'][] = $row;
            $data_actual['data'][] = $valor;
        }

        foreach($meses as $row) {
            $valor = 0;
            foreach($ventas_anterior as $item) {
                if($row == $item->nombre_mes){
                    $valor = (int) $item->ventas;
                }
            }
            $data_anterior['label'][] = $row;
            $data_anterior['data'][] = $valor;
        }

        return view('reporte.graficos', compact('anio_actual','anio_anterior','data_anterior','data_actual'));
    }
    
}
