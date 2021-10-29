<?php

namespace App\Http\Controllers;

use App\Premio;
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
        return view('premio.create', compact('premio'));
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

        return redirect()->route('premios.index')
            ->with('success', 'Premio created successfully.');
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

        return view('premio.edit', compact('premio'));
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

        return redirect()->route('premios.index')
            ->with('success', 'Premio updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $premio = Premio::find($id)->delete();

        return redirect()->route('premios.index')
            ->with('success', 'Premio deleted successfully');
    }

    public function premioDataTable()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $premios = Premio::all();
            if (count($premios) == 0) {
                $premios = 'no data';
            }
            $response = json_encode($premios);
        }
        return $response;
    }
}
