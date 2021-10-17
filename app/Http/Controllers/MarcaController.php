<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

/**
 * Class MarcaController
 * @package App\Http\Controllers
 */
class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $marcas = Marca::paginate();

        return view('marca.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marca = new Marca();
        return view('marca.create', compact('marca'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Marca::$rules);

        $input = $request->all();

        if ($image = $request->file('imagen')) {
            //$destinationPath = 'image/';
            //$profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $profileImage = time().'.'.$request->imagen->extension();
            //$image->move($destinationPath, $profileImage);
            // $request->imagen->storeAs('images', $profileImage);
            $request->imagen->move(public_path('storage/images/marca'), $profileImage);
            $input['imagen'] = "$profileImage";
        }

        Marca::create($input);

        return redirect()->route('marcas.index')
            ->with('success', 'Se creó la marca.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = Marca::find($id);

        return view('marca.show', compact('marca'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $marca = Marca::find($id);

        return view('marca.edit', compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Marca $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        request()->validate(Marca::$rules);

        $input = $request->all();

        if ($request->file('imagen')) {

            $profileImage = time().'.'.$request->imagen->extension();

            $ruta = public_path('storage/images/marca/').$profileImage; 
            Image::make($request->file('imagen'))
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($ruta);
            $input['imagen'] = $profileImage;
        }
          
        $marca->update($input);

        return redirect()->route('marcas.index')
            ->with('success', 'Se actualizó la marca correctamente');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $marca = Marca::find($id)->delete();

        return redirect()->route('marcas.index')
            ->with('success', 'Se eliminó la marca');
    }

    public function marcaDataTable()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {
            $marcas = DB::table('marcas')
            ->get();
            if (count($marcas) == 0) {
                $marcas = 'no data';
            }
            $response = json_encode($marcas);
        }
        return $response;
    }
}
