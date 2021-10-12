<?php

namespace App\Http\Controllers;

use App\Producto;
use App\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->with('success', 'Producto created successfully.');
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

        return view('producto.edit', compact('producto'));
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

        $producto->update($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto updated successfully');
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
            ->with('success', 'Producto deleted successfully');
    }

    public function productoUpload()
    {
        return view('producto.upload');
    }

    public function saveExcel(Request $request)
    {


        // include 'vendor/autoload.php';

        if ($_FILES["excel"]["name"] != '') {
            $allowed_extension = array('xls', 'csv', 'xlsx');
            $file_array = explode(".", $_FILES["excel"]["name"]);
            $file_extension = end($file_array);

            if (in_array($file_extension, $allowed_extension)) {
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES["excel"]["tmp_name"], $file_name);
                $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

                $spreadsheet = $reader->load($file_name);

                unlink($file_name);

                $data = $spreadsheet->getActiveSheet()->toArray();

                foreach ($data as $key => $row) {
                    if ($key >= 1) {

                        // $proveedor = DB::table('proveedores')
                        // ->select('id')
                        // ->where('nombre', 'like', '%'. $row[7] .'%')                        
                        // ->first();

                        $proveedor = DB::table('proveedores')->where('nombre', 'like', '%' . $row[7] . '%')->value('id');

                        if (empty($proveedor)) {
                            $proveedor_id = DB::table('proveedores')->insertGetId(
                                array('nombre' => $row[7], 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'))
                            );
                        } else {
                            $proveedor_id = $proveedor;
                        }

                        $insert_data = array(
                            'sku'  => $row[1],
                            'nombre_producto'  => $row[2],
                            'descripcion'  => $row[3],
                            'marca'  => $row[4],
                            'seccion'  => $row[5],
                            'clasificacion'  => $row[6],
                            'proveedor'  => $proveedor_id,
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
                $message = '<div class="alert alert-success">Data Imported Successfully</div>';
            } else {
                $message = '<div class="alert alert-danger">Only .xls .csv or .xlsx file allowed</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Please Select File</div>';
        }

        echo $message;
    }
}
