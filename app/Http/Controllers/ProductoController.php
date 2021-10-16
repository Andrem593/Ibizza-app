<?php

namespace App\Http\Controllers;

use App\Producto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Marcas;

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
        $productos = Producto::paginate();

        return view('producto.index', compact('productos'))
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
            $request->imagen_path->move(public_path('storage/images/productos'), $image);
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
        $producto = Producto::find($id)->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto Eliminado Correctamente');
    }

    public function productoUpload()
    {
        return view('producto.upload');
    }

    public function saveExcel(Request $request)
    {
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
            if ($key >= 1) {

                $marca_id = DB::table('marcas')->where('nombre', 'like', '%' . $row[3] . '%')->value('id');

                if (empty($marca_id)) {
                    $marca_id = DB::table('marcas')->insertGetId(
                        array('nombre' => $row[3], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
                    );
                }

                $proveedor_id = DB::table('proveedores')->where('nombre', 'like', '%' . $row[7] . '%')->value('id');

                if (empty($proveedor_id)) {
                    $proveedor_id = DB::table('proveedores')->insertGetId(
                        array('nombre' => $row[7], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
                    );
                }

                $insert_data = array(
                    'sku'  => $row[0],
                    'nombre_producto'  => $row[1],
                    'descripcion'  => $row[2],
                    'marca_id'  => $marca_id,
                    'grupo' => $row[4],
                    'seccion'  => $row[5],
                    'clasificacion'  => $row[6],
                    'proveedor_id'  => $proveedor_id,
                    'estilo'  => $row[8],
                    'talla'  => $row[9],
                    'cantidad_inicial'  => $row[10],
                    'stock'  => $row[11],
                    'valor_venta'  => $row[12],
                    'ultima_venta'  => $row[13]
                );

                Producto::create($insert_data);
            }
        }

        return redirect()->route('productos.index')
            ->with('success', 'Productos cargados correctamente');
    }
    public function productoDataTable()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {
            $productos = DB::table('productos')
                ->join('proveedores', 'proveedores.id', '=', 'productos.proveedor_id')
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca', 'proveedores.nombre AS nombre_proveedor')
                ->get();
            if (count($productos) == 0) {
                $productos = 'no data';
            }
            $response = json_encode($productos);
        }
        return $response;
    }
}
