<?php

namespace App\Http\Controllers;

use App\Empresaria;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
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
        // $this->middleware('can:empresarias.index');
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
            'vendedor'=> Auth::user()->id,
            'id_user'=> $user->id
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
        $empresaria = Empresaria::where('empresarias.id', $id)
        ->join('ciudades', 'ciudades.id', '=', 'empresarias.id_ciudad')
        ->select('empresarias.*','ciudades.provincia_id')
        ->first();
        $usuario = User::find($empresaria->id_user);
        $provincias = DB::table('provincias')->get();
        $ciudades = DB::table('ciudades')->where('provincia_id', $empresaria->provincia_id)->where('estado', 'A')->get();
        return view('empresaria.edit', compact('empresaria','provincias','usuario','ciudades'));
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
        request()->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'tipo_cliente' => 'required',
            'id_ciudad' => 'required',
        ]);
        $empresariaData = [
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
    public function update_perfil(Request $request)
    {
        $empresaria = Empresaria::find($request->id_empresaria);
        $empresaria->update([
            'nombres'=>$request->nombres,
            'apellidos'=>$request->apellidos,
            'direccion'=>$request->direccion,
            'telefono'=>$request->telefono,
            'referencia'=>$request->referencia,
            'direccion_envio'=>$request->direccion_envio,
            'referencia_envio'=>$request->referencia_envio,
        ]);
        $user = User::find($empresaria->id_user);
        $image = $user->profile_photo_path;
        if ($request->file('foto_perfil')) {
            $image = time() . '.' . $request->foto_perfil->extension();
            // $request->imagen_path->move(public_path('storage/images/productos'), $image);
            $ruta = public_path('storage/profile-photos/') . $image;
            Image::make($request->file('foto_perfil'))
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta);
            $image = "profile-photos/".$image;
        }
        $user->update([
            'name'=>$request->nombres,
            'email'=>$request->email,
            'profile_photo_path'=>$image,
        ]);
        return redirect()->route('web.perfil-empresaria')
            ->with('success', 'Datos Actualizado Correctamente');
    }
}
