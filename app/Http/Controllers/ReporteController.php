<?php

namespace App\Http\Controllers;

use App\Catalogo;
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
        $id_usuario = Auth::user()->id;
        $empresarias = Empresaria::select('tipo_cliente')
            ->selectRaw('count(*) as count')
            ->groupBy('tipo_cliente');

        if ($id_usuario != 1) {
            $empresarias->where('vendedor', $id_usuario);
        }

        $empresarias = $empresarias->get();

        return view('reporte.index', compact('empresarias'));
    }

    public function empresariaReports()
    {
        $id_usuario = Auth::user()->id;
        $response = '';
        if ($_POST['funcion'] == 'empresaria_venta') {

            $ventas = Venta::join('empresarias', 'empresarias.id', '=', 'ventas.id_empresaria')
                ->select('empresarias.cedula')
                ->selectRaw('ROUND(sum(ventas.total_venta),2) as total')
                ->selectRaw('concat_ws(" ", empresarias.nombres, empresarias.apellidos) as nombres')
                ->groupBy('empresarias.cedula');

            if ($id_usuario != 1) {
                $ventas->where('empresarias.vendedor', $id_usuario);
            }
            $ventas = $ventas->get();
            if (count($ventas) == 0) {
                $ventas = 'no data';
            }
            $response = json_encode($ventas);
        }
        if ($_POST['funcion'] == 'empresaria_estado') {

            $empresarias = Empresaria::select('cedula', 'tipo_cliente')
                ->selectRaw('concat_ws(" ", nombres, apellidos) as nombres');
            if ($id_usuario != 1) {
                $empresarias->where('vendedor', $id_usuario);
            }
            $empresarias = $empresarias->get();
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
        $meses = [
            'January',
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
            'December'
        ];

        $catalogos = Catalogo::join('ventas', 'ventas.id_catalogo', '=', 'catalogos.id')
            ->join('pedidos', 'pedidos.id_venta', '=', 'ventas.id')          
            ->select('catalogos.nombre')
            ->selectRaw('count(distinct ventas.id_empresaria) as n_empresarias')
            ->selectRaw('ROUND(sum(pedidos.total),2) as total')
            ->selectRaw('sum(pedidos.cantidad) as suma_pedidos')
            ->selectRaw('YEAR(catalogos.fecha_publicacion) as year')
            ->selectRaw('ROUND(DATEDIFF(catalogos.fecha_fin_catalogo, catalogos.fecha_publicacion)/7, 0) AS n_semanas')            
            ->where('pedidos.estado', 'PEDIDO')
            ->groupBy('catalogos.nombre')
            ->get();

        $dataCatalogo = [];
        foreach ($catalogos as $key => $value) {
            $dataCatalogo['label'][] = $value->nombre;
            $dataCatalogo['data'][] = $value->total;
        }
        $jsonCatalogo = json_encode($dataCatalogo);

        $ventas_actual = Venta::whereRaw('YEAR(created_at) = ?', $anio_actual)
            ->selectRaw('count(*) as ventas')
            ->selectRaw('ROUND(sum(total_venta),2) as total')
            ->selectRaw('MONTHNAME(created_at) as nombre_mes')
            ->selectRaw('MONTH(created_at) as mes')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $ventas_anterior = Venta::whereRaw('YEAR(created_at) = ?', $anio_anterior)
            ->selectRaw('count(*) as ventas')
            ->selectRaw('ROUND(sum(total_venta),2) as total')
            ->selectRaw('MONTHNAME(created_at) as nombre_mes')
            ->selectRaw('MONTH(created_at) as mes')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $data_actual = [];
        $data_anterior = [];

        foreach ($meses as $row) {
            $valor = 0;
            foreach ($ventas_actual as $item) {
                if ($row == $item->nombre_mes) {
                    $valor = (float) $item->total;
                }
            }
            $data_actual['label'][] = $row;
            $data_actual['data'][] = $valor;
        }

        foreach ($meses as $row) {
            $valor = 0;
            foreach ($ventas_anterior as $item) {
                if ($row == $item->nombre_mes) {
                    $valor = (float) $item->total;
                }
            }
            $data_anterior['label'][] = $row;
            $data_anterior['data'][] = $valor;
        }

        $anterior = json_encode($data_anterior);
        $actual = json_encode($data_actual);

        return view('reporte.graficos', compact('anio_actual', 'anio_anterior', 'anterior', 'actual', 'catalogos', 'jsonCatalogo'));
    }
}
