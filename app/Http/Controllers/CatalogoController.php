<?php

namespace App\Http\Controllers;

use App\Catalogo;
use App\Models\Catalogo_has_Producto;
use App\Producto;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->with('success', 'Catalogo created successfully.');
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
            ->with('success', 'Catalogo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $catalogo = Catalogo::find($id)->delete();

        Catalogo_has_Producto::where('catalogo_id', $id)->delete();

        return redirect()->route('catalogos.index')
            ->with('success', 'Catalogo deleted successfully');
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
}
