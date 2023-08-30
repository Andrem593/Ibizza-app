<?php

namespace App\Http\Controllers;

use App\Catalogo;
use App\Models\Catalogo_has_Producto;
use App\Models\LogStockFaltante;
use App\Producto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Cart;
use CatalogoHasPremios;
use CatalogoHasProductos;

/**
 * Class ProductoController
 * @package App\Http\Controllers
 */
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = Producto::with('catalogo')->paginate();
        $catalogos = Catalogo::all();

        return view('producto.index', compact('productos', 'catalogos'))
            ->with('i', (request()->input('page', 1) - 1) * $productos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $producto = new Producto();
        return view('producto.create', compact('producto'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Producto::$rules);

        $producto = Producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto Creado Correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $producto = Producto::find($id);

        return view('producto.show', compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::find($id);
        $marcas = DB::table('marcas')->get();
        $proveedores = DB::table('proveedores')->get();
        return view('producto.edit', compact('producto', 'marcas', 'proveedores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Producto $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        request()->validate(Producto::$rules);
        $requestData = $request->all();

        if ($request->file('imagen_path')) {
            $image = time() . '.' . $request->imagen_path->extension();
            // $request->imagen_path->move(public_path('storage/images/productos'), $image);
            $ruta = public_path('storage/images/productos/') . $image;
            Image::make($request->file('imagen_path'))
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta);
            $requestData['imagen_path'] = $image;
        }
        $producto->update($requestData);

        return redirect()->route('productos.index')
            ->with('success', 'Producto Actualizado Correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $producto = Producto::find($id)->update(['estado' => 'I']);

        return redirect()->route('productos.index')
            ->with('success', 'Producto Eliminado Correctamente');
    }

    public function productoUpload()
    {
        return view('producto.upload');
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
            foreach ($data as $key => $row) {
                if ($key >= 1 || $row[0] != ''  and $row[1]) {
                    $marca_id = DB::table('marcas')->where('nombre', 'like', '%' . $row[2] . '%')->value('id');

                    if (empty($marca_id)) {
                        $marca_id = DB::table('marcas')->insertGetId(
                            array('nombre' => $row[2], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
                        );
                    }

                    $catalogo = DB::table('catalogos')->where('id', $row[11])->value('id');

                    if (empty($catalogo)) { } else {
                        Catalogo_has_Producto::updateOrInsert([
                            'catalogo_id' => $catalogo,
                            'estilo' => $row[6],
                        ]);
                    }

                    $insert_data = array(
                        'sku'  => $row[0],
                        'descripcion'  => $row[1],
                        'marca_id'  => $marca_id,
                        'clasificacion' => $row[3],
                        'categoria'  => $row[4],
                        'subcategoria'  => $row[5],
                        'estilo'  => $row[6],
                        'color'  => $row[7],
                        'talla'  => $row[8],
                        'cantidad_inicial'  => $row[9],
                        'stock'  => $row[10],
                        'nombre_mostrar'  => $row[1],
                        'precio_empresaria'  => $row[12],
                        'estado'  => $row[13],
                        'observaciones'  => $row[14],
                        'catalogo_id'=> $row[11],
                    );

                    Producto::create($insert_data);
                }
            }

            return redirect()->route('productos.index')
                ->with('success', 'Productos cargados correctamente');
        } catch (\Throwable $th) {
            return redirect()->route('producto.upload')
                ->with('error', 'EL archivo no cumple con el formato requerido, por favor verifique el archivo e intente nuevamente.');
        }
    }
    public function productoDataTable(Request $request)
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {
            $productos = DB::table('productos')
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->join('catalogos', 'catalogos.id', '=', 'productos.catalogo_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca', 'catalogos.nombre AS nombre_catalogo')
                ->get();
            if (count($productos) == 0) {
                $productos = 'no data';
            }
            $response = json_encode($productos);
        }

        if ($_POST['funcion'] == 'filtro') {
            $catalogo = $_POST['catalogo'];
            $productos = DB::table('productos')
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->join('catalogos', 'catalogos.id', '=', 'productos.catalogo_id')
                ->where('catalogos.id', $catalogo)
                ->select('productos.*', 'marcas.nombre AS nombre_marca', 'catalogos.nombre AS nombre_catalogo')
                ->get();
            if (count($productos) == 0) {
                $productos = 'no data';
            }
            $response = json_encode($productos);
        }

        if ($_POST['funcion'] == 'listar_estilos') {
            $productos = DB::table('productos')
                ->distinct()
                ->select('imagen_path', 'estilo', 'color')
                ->get();
            if (count($productos) == 0) {
                $productos = 'no data';
            }
            $response = json_encode($productos);
        }
        if ($_POST['funcion'] == 'editar_estilo') {

            if (!empty($_FILES["file"])) {

                $image = time() . '.' . $_FILES["file"]['name'];
                $ruta = public_path('storage/images/productos/') . $image;
                Image::make($_FILES["file"]["tmp_name"])
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($ruta);
            }
            $ant_img = empty($_POST['ant_img']) ? null : $_POST['ant_img'];
            $response = Producto::where('color', $_POST['color'])
                ->where('estilo', $_POST['estilo'])
                ->where('imagen_path', $ant_img)
                ->update([
                    'imagen_path' => $image
                ]);

            if ($response > 0) {
                $response = [
                    'num' => $response,
                    'message' => 'actualizado'
                ];
            } else {
                $response = [
                    'message' => 'error'
                ];
            }
            json_encode($response);
        }
        if ($_POST['funcion'] == 'eliminar_estilo') {
            $response = Producto::where('color', $_POST['color'])
                ->where('estilo', $_POST['estilo'])
                ->where('imagen_path', $_POST['ant_img'])
                ->update([
                    'imagen_path' => null
                ]);
            if ($response > 0) {
                $response = [
                    'num' => $response,
                    'message' => 'actualizado'
                ];
            } else {
                $response = [
                    'message' => 'error'
                ];
            }
            json_encode($response);
        }

        return $response;
    }
    public function productoEstilos()
    {
        return view('producto.estilos');
    }

    public function stockFaltante()
    {
        return view('producto.stock-faltante');
    }

    public function productoDataTableStock(Request $request)
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_STOCK') {
            $stock = LogStockFaltante::join('productos', function ($join) {
                $join->on('productos.estilo', '=', 'log_stock_faltantes.estilo')
                    ->on('productos.color', '=', 'log_stock_faltantes.color')
                    ->on('productos.talla', '=', 'log_stock_faltantes.talla');
            })
                ->join('catalogos', 'catalogos.id', '=', 'productos.catalogo_id')
                ->select('log_stock_faltantes.*', 'catalogos.nombre')
                ->selectRaw('DATE_FORMAT(log_stock_faltantes.created_at, "%Y-%m-%d %H:%i:%s") as fecha')
                ->get();
            if (count($stock) == 0) {
                $stock = 'no data';
            }
            $response = json_encode($stock);
        }

        return $response;
    }
}
