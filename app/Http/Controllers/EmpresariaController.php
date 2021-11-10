<?php

namespace App\Http\Controllers;

use App\Empresaria;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
/**
 * Class EmpresariaController
 * @package App\Http\Controllers
 */
class EmpresariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('can:empresarias.index');
    }
    public function index()
    {
        $empresarias = Empresaria::paginate();

        return view('empresaria.index', compact('empresarias'))
            ->with('i', (request()->input('page', 1) - 1) * $empresarias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresaria = new Empresaria();
        $provincias = DB::table('provincias')->get();
        return view('empresaria.create', compact('empresaria', 'provincias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Empresaria::$rules);
        $userData = [
            'name'=>trim(strtoupper($request->nombres)),
            'email'=>trim($request->email),
            'password'=>Hash::make($request->password),
            'role'=>'Empresaria'
        ];
        $user = User::create($userData);
        $user->roles()->sync(2);// 2 es el id de el rol de empresaria 
        $empresariaData = [
            'cedula'=> trim($request->cedula),
            'nombres'=> trim(strtoupper($request->nombres)),
            'apellidos'=> trim(strtoupper($request->apellidos)),
            'fecha_nacimiento'=> $request->fecha_nacimiento,
            'direccion'=> trim(strtoupper($request->direccion)),
            'tipo_cliente'=> trim(strtoupper($request->tipo_cliente)),
            'telefono'=> trim($request->telefono),
            'id_ciudad'=> $request->id_ciudad,
            'vendedor'=> Auth::user()->id
        ];
        Empresaria::create($empresariaData);
        
        return redirect()->route('empresarias.index')
            ->with('success', 'Empresaria Creada Correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresaria = Empresaria::find($id);
        $provincias = DB::table('provincias')->get();
        return view('empresaria.show', compact('empresaria','provincias'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresaria = Empresaria::find($id);
        $provincias = DB::table('provincias')->get();
        return view('empresaria.edit', compact('empresaria','provincias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Empresaria $empresaria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empresaria $empresaria)
    {
        request()->validate(Empresaria::$rules);
        $empresariaData = [
            'cedula'=> trim($request->cedula),
            'nombres'=> trim(strtoupper($request->nombres)),
            'apellidos'=> trim(strtoupper($request->apellidos)),
            'fecha_nacimiento'=> $request->fecha_nacimiento,
            'direccion'=> trim(strtoupper($request->direccion)),
            'tipo_cliente'=> trim(strtoupper($request->tipo_cliente)),
            'telefono'=> trim($request->telefono),
            'id_ciudad'=> $request->id_ciudad,
            'vendedor'=> Auth::user()->id,
        ];

        $empresaria->update($empresariaData);
        

        return redirect()->route('empresarias.index')
            ->with('success', 'Empresaria updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $empresaria = Empresaria::find($id);
        User::find($empresaria->id_usuario)->delete();
        Empresaria::find($id)->delete();
        return redirect()->route('empresarias.index')
            ->with('success', 'Empresaria Eliminada correctamente');
    }
    public function consultarCiudad()
    {
        $ciudades = DB::table('ciudades')
            ->where('provincia_id', '=', $_POST['id_provincia'])
            ->get();
        return json_encode($ciudades);
    }
    public function empresariaDatatable(){
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {
            $empresarias = DB::table('empresarias')
            ->join('ciudades','empresarias.id_ciudad','=', 'ciudades.id')
            ->join('users','users.id', '=', 'empresarias.vendedor')
            ->select('empresarias.*','ciudades.descripcion as nombre_ciudad','users.name as nombre_vendedor')
            ->get();
            if (count($empresarias) == 0) {
                $empresarias = 'no data';
            }
            $response = json_encode($empresarias);
        }
        return $response;
    }
}
