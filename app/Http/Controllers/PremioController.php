<?php

namespace App\Http\Controllers;

use App\Catalogo;
use App\Http\Livewire\Condicion;
use App\Models\CondicionPremio;
use App\Models\Premio_has_Producto;
use App\Premio;
use App\Producto;
use Illuminate\Http\Request;

/**
 * Class PremioController
 * @package App\Http\Controllers
 */
class PremioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $premios = Premio::paginate();

        return view('premio.index', compact('premios'))
            ->with('i', (request()->input('page', 1) - 1) * $premios->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $premio = new Premio();
        $catalogo = Catalogo::all();
        return view('premio.create', compact('premio', 'catalogo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Premio::$rules);

        $premio = Premio::create([
            'catalogo_id' => $request->catalogo_id,
            'descripcion' => $request->descripcion,
            'monto_minimo_acumulado' => $request->monto_minimo_acumulado
        ]);

        $premio_id = $premio->id;

        if (!empty($request->condicion)) {

            $condicion = json_decode($request->condicion);

            foreach ($condicion as $key => $value) {

                CondicionPremio::insert([
                    'premio_id' => $premio_id,
                    'tipo_empresaria' => $value->tipo_empresaria,
                    'nivel' => $value->nivel,
                    'rango_desde' => $value->rango_desde,
                    'rango_hasta' => $value->rango_hasta,
                    'acumular' => $value->acumular,
                ]);
            }
        }

        if (!empty($request->premio)) {

            $premio = json_decode($request->premio);

            foreach ($premio as $key => $value) {

                if ($value->asignar == 1) {
                    Premio_has_Producto::insert([
                        'premio_id' => $premio_id,
                        'estilo' => $value->estilo,
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
                }
            }
        }

        $json_data = array(
            'mensaje' => 'ok',
            'estado' => true
        );

        return json_encode($json_data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $premio = Premio::find($id);

        return view('premio.show', compact('premio'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $premio = Premio::find($id);
        $condicion = CondicionPremio::where('premio_id', $id)
            ->get()
            ->map(function($condition){
                $condition->nombre_tabla = $condition->tipo_empresaria;
                $condition->descripcion = '$'.$condition->rango_desde.' - '.$condition->rango_hasta;
                $condition->acumular_valor = $condition->acumular == 1 ? 'SI' : 'NO';
                return $condition ;
            });

        $premio->condicion = json_encode($condicion);
        $catalogo = Catalogo::all();

        $productos = Producto::join('catalogo_has_productos', 'catalogo_has_productos.estilo', '=', 'productos.estilo')->addSelect([
            'en_premio' => Premio_has_Producto::select('estilo')
                ->whereColumn('estilo', 'productos.estilo')
                ->where('premio_id', $premio->id)
                ->limit(1)
        ])
        ->where('categoria', 'PREMIOS')
        ->where('estado', 'A')
        ->where('catalogo_has_productos.catalogo_id', $premio->catalogo_id)
            ->groupBy('catalogo_has_productos.estilo')
            ->get();

        if (count($productos) == 0) {
            $productos = 'no data';
        }

        //$response = json_encode($productos);

        return view('premio.edit', compact('premio', 'condicion', 'catalogo', 'productos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Premio $premio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Premio $premio)
    {
        request()->validate(Premio::$rules);
        $premio->update([
            'catalogo_id' => $request->catalogo_id,
            'descripcion' => $request->descripcion,
            'monto_minimo_acumulado'=> $request->monto_minimo_acumulado
        ]);

        $premio_id = $premio->id;

        if (!empty($request->condicion)) {

            $condicion = json_decode($request->condicion);

            $idsEliminar = collect($condicion)->pluck('id')->filter(function ($value) {
                return !is_null($value);
            }) ;

            CondicionPremio::where([
                ['premio_id', $premio->id],
            ])->whereNotIn('id', $idsEliminar)->delete();

            foreach ($condicion as $key => $value) {

                if(!isset($value->id)){
                    CondicionPremio::insert([
                        'premio_id' => $premio_id,
                        'tipo_empresaria' => $value->tipo_empresaria,
                        'nivel' => $value->nivel,
                        'rango_desde' => $value->rango_desde,
                        'rango_hasta' => $value->rango_hasta,
                        'acumular' => $value->acumular,
                    ]);
                }
            }
        }

        if (!empty($request->premio)) {

            $premio = json_decode($request->premio);

            foreach ($premio as $key => $value) {

                $premiohasProductos = Premio_has_Producto::where('premio_id', $premio_id)
                    ->where('estilo', $value->estilo)->limit(1)->get();

                if (count($premiohasProductos) > 0) {
                    if ($value->asignar == 0) {
                        Premio_has_Producto::where('id', $premiohasProductos->first()->id)->delete();
                    }
                } else {
                    if ($value->asignar == 1) {
                        Premio_has_Producto::insert([
                            'premio_id' => $premio_id,
                            'estilo' => $value->estilo,
                            'created_at' =>  \Carbon\Carbon::now(),
                            'updated_at' => \Carbon\Carbon::now()
                        ]);
                    }
                }
            }
        }

        $json_data = array(
            'mensaje' => 'ok',
            'estado' => true
        );

        return json_encode($json_data);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        // $premio = Premio::find($id)->delete();

        Premio_has_Producto::where('premio_id', $id)->delete();

        return redirect()->route('premios.index')
            ->with('success', 'Premio eliminado correctamente');
    }

    public function deleteCondicion(Request $request)
    {
        // $premio = Premio::find($id)->delete();

        CondicionPremio::where('id', $request->id)->delete();

        $json_data = array(
            'mensaje' => 'ok',
            'estado' => true
        );

        return json_encode($json_data);
    }

    public function premioDataTable(Request $request)
    {
        $response = '';
        if ($request->funcion == 'listar_todo') {

            $premios = Premio::join('catalogos', 'premios.catalogo_id', '=', 'catalogos.id')
                ->select('premios.id', 'premios.descripcion', 'catalogos.nombre')
                ->get();
            if (count($premios) == 0) {
                $premios = 'no data';
            }
            $response = json_encode($premios);
        }
        if ($request->funcion == 'listar_premio_producto') {

            $productos = Producto::join('catalogo_has_productos', 'catalogo_has_productos.estilo', '=', 'productos.estilo')->where('catalogo_has_productos.catalogo_id', $request->id_catalogo)->groupBy('catalogo_has_productos.estilo')->select('productos.*')
                ->get();

            if (count($productos) == 0) {
                $productos = 'no data';
            }

            $response = json_encode($productos);
        }
        return $response;
    }
}
