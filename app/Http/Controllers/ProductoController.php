<?php

namespace App\Http\Controllers;

use App\Models\LogStockFaltante;
use App\Producto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Cart;
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

                $producto = Producto::where('sku', $row[0])->first();

                if ($producto) {
                    $producto->stock = $row[11] + $producto->stock;
                    $producto->save();
                }else{
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
                        'color'  => $row[9],
                        'talla'  => $row[10],
                        'cantidad_inicial'  => $row[11],
                        'stock'  => $row[11],
                        'valor_venta'  => $row[12],
                        'nombre_mostrar'  => $row[13],
                        'categoria'  => $row[14],
                        'subcategoria'  => $row[15],
                        'precio_empresaria'  => $row[16],
                        'descuento'  => $row[17]
                    );
    
                    Producto::create($insert_data);
                }

            }
        }

        return redirect()->route('productos.index')
            ->with('success', 'Productos cargados correctamente');
    }
    public function productoDataTable(Request $request)
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
            
            if ($response > 0 ) {
                $response = [
                    'num' => $response,
                    'message'=> 'actualizado'
                ];
            }else{
                $response = [
                    'message'=> 'error'
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
            if ($response > 0 ) {
                $response = [
                    'num' => $response,
                    'message'=> 'actualizado'
                ];
            }else{
                $response = [
                    'message'=> 'error'
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
            $stock = LogStockFaltante::all();
            if (count($stock) == 0) {
                $stock = 'no data';
            }
            $response = json_encode($stock);
        }

        return $response;
    }
}
