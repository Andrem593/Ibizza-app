<?php

namespace App\Http\Controllers;

use App\Catalogo;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

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
            $profileImage = time().'.'.$request->foto_path->extension();
            $ruta = public_path('storage/images/catalogo/').$profileImage; 
            Image::make($request->file('foto_path'))
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($ruta);
            $input['foto_path'] = "$profileImage";
        }

        if ($request->file('pdf_path')) {
            $profilePDF = str_replace(' ', '_', $request->nombre).'_'.date("Ymd").'.'.$request->pdf_path->extension();
            $request->pdf_path->move(public_path('storage/pdf/catalogo'), $profilePDF);
            $input['pdf_path'] = "$profilePDF";
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
            $profileImage = time().'.'.$request->foto_path->extension();
            $ruta = public_path('storage/images/catalogo/').$profileImage; 
            Image::make($request->file('foto_path'))
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($ruta);
            $input['foto_path'] = "$profileImage";
        }

        if ($request->file('pdf_path')) {
            $profilePDF = str_replace(' ', '_', $request->nombre).'_'.date("Ymd").'.'.$request->pdf_path->extension();
            $ruta = public_path('storage/images/catalogo/').$profilePDF; 
            Image::make($request->file('pdf_path'))
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($ruta);
            $input['pdf_path'] = "$profilePDF";
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
        return $response;
    }

}
