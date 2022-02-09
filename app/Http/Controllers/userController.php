<?php

namespace App\Http\Controllers;

use App\Empresaria;
use App\Models\User;
use App\Models\Venta;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use Ventas;

class userController extends Controller
{
    public function __construct()
    {
        
    }

    public function index()
    {
        return view('usuario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('usuario.crear',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'=>['required','string','max:50'],
            'password' => ['required', 'string', 'min:8']
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->role == 1) {
            $user->role = 'Administrador';
        }else{
            $user->role = 'Empresaria';
        }
        $user->password = Hash::make($request->password);
        if($user->save()){
            $message = 'nuevo usuario creado';
        }else{
            $message = 'error en base';
        }
        $user->roles()->sync($request->role);
        return redirect()->route('usuario.index')
            ->with('success', 'Se creó el usuario correctamente');
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        $usuario = User::find($id)->delete();

        return redirect()->route('usuario.index')
            ->with('success', 'Se eliminó el usuario');
    }

    public function usuarioDataTable()
    {
        $response = '';
        if ($_POST['funcion'] == 'listar_todo') {

            $usuarios = User::where('role', 'not like', "%empresaria%")->get();
            if (count($usuarios) == 0) {
                $usuarios = 'no data';
            }
            $response = json_encode($usuarios);
        }
        return $response;
    }
    public function dashboard(){
        $empresarias = Empresaria::all()->count();
        $ventas = Venta::all()->count();
        $ventaCatalogo = Venta::join('catalogos','ventas.id_catalogo','=','catalogos.id')
        ->where('catalogos.estado','PUBLICADO')->get()->count();
        $productos = Producto::all()->count();
        $ventasMes = Venta::whereMonth('created_at','=',date('m'))->get();
        $ventasCliente = Venta::join('empresarias','ventas.id_empresaria','=','empresarias.id')
        ->join('users','users.id','=','empresarias.id_user')->limit(10)
        ->get();
        return view('dashboard',compact('empresarias','ventas','ventaCatalogo','productos','ventasMes','ventasCliente'));
    }
}
