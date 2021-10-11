<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Jetstream;

class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:usuario.create');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        return redirect()->back()->with('message',$message);
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
        //
    }
}
