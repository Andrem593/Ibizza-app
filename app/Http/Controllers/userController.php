<?php

namespace App\Http\Controllers;

use Ventas;
use App\Producto;
use App\Empresaria;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\Request;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        if($request->tipoId =='cedula') $request->validate(['identificacion' => ['required', 'numeric', 'digits_between:10,10' ,'unique:users']]);
        if($request->tipoId =='ruc') $request->validate(['identificacion' => ['required', 'numeric','digits_between:10,13' ,'unique:users']]);
        if($request->tipoId =='pasaporte') $request->validate(['identificacion' => ['required', 'string', 'max:20', 'min:6','unique:users']]);    
        $request->validate([// 'unique:users
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'=>['required','string','max:50'],
            'password' => ['required', 'string', 'min:8']
        ]);

        $user = new User();
        $user->tipo_id = $request->tipoId;
        $user->identificacion = $request->identificacion;
        $user->name = $request->name;
        $user->email = $request->email;
        $rol_usuario =DB::table('roles')->find($request->role);
        $user->role = $rol_usuario->name;         
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
        $usuario = User::find($id);
        $roles = Role::all();
        return view('usuario.edit',compact('usuario','roles'));
    }

    public function update(Request $request, $id)
    {
        if($request->tipoId =='cedula') $request->validate(['identificacion' => ['required', 'numeric', 'digits_between:10,10']]);
        if($request->tipoId =='ruc') $request->validate(['identificacion' => ['required', 'numeric','digits_between:10,13']]);
        if($request->tipoId =='pasaporte') $request->validate(['identificacion' => ['required', 'string', 'max:20', 'min:6']]);    


        $usuario = User::find($id);
        $usuario->identificacion = $request->identificacion;
        $usuario->tipo_id = $request->tipoId;
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $rol_usuario =DB::table('roles')->find($request->role);
        $usuario->role = $rol_usuario->name;         
        if($usuario->save()){
            $message = 'nuevo usuario creado';
        }else{
            $message = 'error en base';
        }
        $usuario->roles()->sync($request->role);
        return redirect()->route('usuario.index')
            ->with('success', 'Se actualizó el usuario correctamente');
    }
    public function destroy($id)
    {
        User::find($id)->delete();

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
        if(Auth::user()->role == 'Asesor' || Auth::user()->role == 'ASESOR'){
            return redirect()->route('venta.pedido');
        }
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
