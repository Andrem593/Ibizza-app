<?php

namespace App\Http\Controllers;

use App\Catalogo;
use App\Producto;
use Carbon\Carbon;
use App\Models\Marca;
use App\Models\Oferta;
use Illuminate\Http\Request;
use App\Models\ParametroMarca;
use App\Models\ParametroCatalogo;
use Illuminate\Support\Facades\DB;
use App\Models\Catalogo_has_Producto;
use Intervention\Image\Facades\Image;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CatalogoController
 * @package App\Http\Controllers
 */
class CatalogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalogos = Catalogo::paginate();

        return view('catalogo.index', compact('catalogos'))
            ->with('i', (request()->input('page', 1) - 1) * $catalogos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $catalogo = new Catalogo();
        return view('catalogo.create', compact('catalogo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Catalogo::$rules);

        $input = $request->all();

        if ($request->file('foto_path')) {
            $profileImage = time() . '.' . $request->foto_path->extension();
            $ruta = public_path('storage/images/catalogo/') . $profileImage;
            Image::make($request->file('foto_path'))
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta);
            $input['foto_path'] = "$profileImage";
        }

        if ($request->file('pdf_path')) {
            $profilePDF = str_replace(' ', '_', $request->nombre) . '_' . date("Ymd") . '.' . $request->pdf_path->extension();
            $request->pdf_path->move(public_path('storage/pdf/catalogo'), $profilePDF);
            $input['pdf_path'] = "$profilePDF";
        }

        if ($request->estado) {
            $input['estado'] = "PUBLICADO";
        } else {
            $input['estado'] = "SIN PUBLICAR";
        }

        Catalogo::create($input);

        return redirect()->route('catalogos.index')
            ->with('success', 'Catalogo creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $catalogo = Catalogo::find($id);

        return view('catalogo.show', compact('catalogo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $catalogo = Catalogo::find($id);

        return view('catalogo.edit', compact('catalogo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Catalogo $catalogo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalogo $catalogo)
    {
        request()->validate(Catalogo::$rules);

        $input = $request->all();

        if ($request->file('foto_path')) {
            $profileImage = time() . '.' . $request->foto_path->extension();
            $ruta = public_path('storage/images/catalogo/') . $profileImage;
            Image::make($request->file('foto_path'))
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta);
            $input['foto_path'] = "$profileImage";
        }

        if ($request->file('pdf_path')) {
            $profilePDF = str_replace(' ', '_', $request->nombre) . '_' . date("Ymd") . '.' . $request->pdf_path->extension();
            $request->pdf_path->move(public_path('storage/pdf/catalogo'), $profilePDF);
            $input['pdf_path'] = "$profilePDF";
        }

        if ($request->estado) {
            $input['estado'] = "PUBLICADO";
        } else {
            $input['estado'] = "SIN PUBLICAR";
        }

        $catalogo->update($input);

        return redirect()->route('catalogos.index')
            ->with('success', 'Catalogo actualizado correctamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $catalogo = Catalogo::find($id)->update(['estado' => 'ELIMINADO']);


        return redirect()->route('catalogos.index')
            ->with('success', 'Catalogo borrado correctamente');
    }

    public function catalogoDataTable()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $catalogos = Catalogo::all();
            if (count($catalogos) == 0) {
                $catalogos = 'no data';
            }
            $response = json_encode($catalogos);
        }
        if ($_POST['funcion'] == 'listar_catalogo_producto') {

            $catalogo_id = $_POST['id_catalogo'];

            $productos = Producto::addSelect([
                'en_catalogo' => Catalogo_has_Producto::select('estilo')
                    ->whereColumn('estilo', 'productos.estilo')
                    ->where('catalogo_id', $catalogo_id)
                    ->limit(1)
            ])
                ->groupBy('estilo')
                ->get();

            if (count($productos) == 0) {
                $productos = 'no data';
            }

            $response = json_encode($productos);
        }
        return $response;
    }

    public function catalogoProducto()
    {
        $catalogo = Catalogo::whereDate('fecha_fin_catalogo', '>=', Carbon::today())->get();
        return view('catalogo.catalogoProducto', compact('catalogo'));
    }

    public function asignarProducto()
    {
        $jsonData = !empty($_POST['jsonData']) ? json_decode($_POST['jsonData']) : null;

        $catalogo_id = $jsonData->catalogo_id;

        foreach ($jsonData->data as $key => $value) {

            $catalogohasProductos = Catalogo_has_Producto::where('catalogo_id', $catalogo_id)
                ->where('estilo', $value->estilo)->limit(1)->get();

            if (count($catalogohasProductos) > 0) {
                if ($value->asignar == 0) {
                    Catalogo_has_Producto::where('id', $catalogohasProductos->first()->id)->delete();
                }
            } else {
                if ($value->asignar == 1) {
                    Catalogo_has_Producto::insert([
                        'catalogo_id' => $catalogo_id,
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

    public function parametrosMarca()
    {
        return view('catalogo.parametrosMarca');
    }

    public function parametrosMarcaNew()
    {
        $categorias = DB::table('productos')->select('categoria')->distinct()->get();
        return view('catalogo.newParametroMarca', compact('categorias'));
    }

    public function parametrosMarcaEdit($id)
    {
        $parametro = ParametroMarca::find($id);
        $categorias = DB::table('productos')->select('categoria')->distinct()->get();

        $categorias2 = json_decode($parametro->marcas) ;

        $categorias2 = is_object($categorias2) ? $categorias2 : [];

        return view('catalogo.editParametroMarca', compact('parametro', 'categorias','categorias2'));
    }

    public function parametrosMarcaUpdate($id, Request $request)
    {
        $request->validate([
            'categorias' => 'required',
            'tipo_empresaria' => 'required',
            'condicion' => 'required',
            'operador' => 'required',
            'cantidad' => 'required',
        ]);

        try {
            ParametroMarca::find($id)->update([
                'nombre' => $request->nombre,
                'tipo_empresaria' => $request->tipo_empresaria,
                'marcas' => json_encode($request->categorias),
                'condicion' => $request->condicion,
                'operador' => $request->operador,
                'cantidad' => $request->cantidad,
                'descuento' => 0,
                'estado' => 1
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('parametro-marca.edit', $id)->with('error', 'Error al actualizar el parametro:' . $th->getMessage());
        }

        return redirect()->route('catalogo.parametros-marca')->with('success', 'Parametro actualizado correctamente');
    }

    public function parametrosMarcaDelete($id)
    {
        ParametroMarca::find($id)->update([
            'estado' => 0
        ]);

        return redirect()->route('catalogo.parametros-marca')->with('success', 'Parametro eliminado correctamente');
    }

    public function parametrosMarcaListar()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $parametros = ParametroMarca::orderBy('id', 'desc')->get();
            foreach ($parametros as $key => $value) {
                $value->marcas = json_decode($value->marcas);
            }

            foreach ($parametros as $key => $value) {


                $value->marcas = collect($value->marcas)->map(function($mark){
                    if (property_exists($mark, 'categoria')) {
                        return $mark->categoria;
                    }
                    return null;
                })
                ->filter()
                ->values();

            }
            if (count($parametros) == 0) {
                $parametros = 'no data';
            }
            $response = json_encode($parametros);
        }

        return $response;
    }

    public function parametrosMarcaNewStore(Request $request)
    {
        $request->validate([
            'categorias' => 'required',
            'tipo_cliente' => 'required',
            'condicion' => 'required',
            'operador' => 'required',
            'cantidad' => 'required',
        ]);

        try {
            ParametroMarca::create([
                'nombre' => $request->nombre,
                'tipo_empresaria' => $request->tipo_cliente,
                'marcas' => json_encode($request->categorias),
                'condicion' => $request->condicion,
                'operador' => $request->operador,
                'cantidad' => $request->cantidad,
                'descuento' => 0,
                'estado' => 1
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('catalogo.parametros-marca-nuevo')->with('error', 'Error al crear el parametro:' . $th->getMessage());
        }

        return redirect()->route('catalogo.parametros-marca')->with('success', 'Parametro creado correctamente');
    }

    public function parametros()
    {
        return view('catalogo.parametros');
    }

    public function parametros_listar()
    {

        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $parametros = ParametroCatalogo::with('catalogo')->get();

            if (count($parametros) == 0) {
                $parametros = 'no data';
            }
            $response = json_encode($parametros);
        }

        return $response;
    }

    public function reglas()
    {
        $catalogos = Catalogo::all();

        return view('catalogo.reglas', compact('catalogos'));
    }

    public function regla_edit($id)
    {
        $regla = ParametroCatalogo::find($id);
        $catalogos = Catalogo::all();

        return view('catalogo.reglasEdit', compact('regla', 'catalogos'));
    }

    public function reglasCreate(Request $request)
    {
        $request->validate([
            'catalogo' => 'required|exists:catalogos,id',
            'tipo_cliente' => 'required',
            'condicion' => 'required',
            'operador' => 'required',
            'cantidad' => 'required',
            'valor' => 'required|numeric'
        ]);

        try {
            ParametroCatalogo::create([
                'catalogo_id' => $request->catalogo,
                'tipo_empresaria' => $request->tipo_cliente,
                'condicion' => $request->condicion,
                'operador' => $request->operador,
                'cantidad' => $request->cantidad,
                'valor' => $request->valor
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('catalogo.reglas')->with('error', 'Error al crear la regla: ' . $th->getMessage());
        }

        return redirect()->route('catalogo.parametros')->with('success', 'Regla creada correctamente');
    }

    public function reglasUpdate($id, Request $request)
    {
        $request->validate([
            'catalogo' => 'required|exists:catalogos,id',
            'tipo_cliente' => 'required',
            'condicion' => 'required',
            'operador' => 'required',
            'cantidad' => 'required',
            'valor' => 'required|numeric'
        ]);

        try {
            ParametroCatalogo::find($id)->update([
                'catalogo_id' => $request->catalogo,
                'tipo_empresaria' => $request->tipo_cliente,
                'condicion' => $request->condicion,
                'operador' => $request->operador,
                'cantidad' => $request->cantidad,
                'valor' => $request->valor,
                'estado' => 1
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('catalogo.reglas')->with('error', 'Error al actualizar la regla: ' . $th->getMessage());
        }

        return redirect()->route('catalogo.parametros')->with('success', 'Regla actualizada correctamente');
    }

    public function reglasDelete($id)
    {
        ParametroCatalogo::find($id)->update([
            'estado' => 0
        ]);

        return redirect()->route('catalogo.parametros')->with('success', 'Regla eliminada correctamente');
    }

    public function ofertas()
    {
        return view('catalogo.ofertas');
    }

    public function ofertasCreate()
    {
        $catalogos = Catalogo::all();

        return view('catalogo.newOferta', compact('catalogos'));
    }

    public function ofertasEdit($id)
    {
        $oferta = Oferta::find($id);
        $catalogos = Catalogo::all();

        return view('catalogo.editOferta', compact('oferta', 'catalogos'));
    }

    public function ofertasListar()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $ofertas = Oferta::orderBy('estado', 'desc')->get();

            if (count($ofertas) == 0) {
                $ofertas = 'no data';
            }
            $response = json_encode($ofertas);
        }

        return $response;
    }

    public function ofertasDelete($id)
    {
        Oferta::find($id)->update([
            'estado' => 0
        ]);

        return redirect()->route('ofertas.index')->with('success', 'Oferta eliminada correctamente');
    }
}
