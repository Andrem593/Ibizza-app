<?php

namespace App\Http\Controllers;

use App\Catalogo;
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

        $premio = Premio::create($request->all());

        $premio_id = $premio->id;

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
        $catalogo = Catalogo::all();

        $productos = Producto::addSelect([
            'en_premio' => Premio_has_Producto::select('estilo')
                ->whereColumn('estilo', 'productos.estilo')
                ->where('premio_id', $premio->id)
                ->limit(1)
        ])
            ->groupBy('estilo')
            ->get();

        if (count($productos) == 0) {
            $productos = 'no data';
        }

        //$response = json_encode($productos);

        return view('premio.edit', compact('premio', 'catalogo', 'productos'));
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
        $premio->update($request->all());

        $premio_id = $premio->id;

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
        $premio = Premio::find($id)->delete();

        Premio_has_Producto::where('premio_id', $id)->delete();

        return redirect()->route('premios.index')
            ->with('success', 'Premio deleted successfully');
    }

    public function premioDataTable()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $premios = Premio::join('catalogos', 'premios.catalogo_id', '=', 'catalogos.id')
                ->select('premios.id', 'premios.descripcion', 'catalogos.nombre')
                ->get();
            if (count($premios) == 0) {
                $premios = 'no data';
            }
            $response = json_encode($premios);
        }
        if ($_POST['funcion'] == 'listar_premio_producto') {

            $productos = Producto::groupBy('estilo')
                ->get();

            if (count($productos) == 0) {
                $productos = 'no data';
            }

            $response = json_encode($productos);
        }
        return $response;
    }
}
