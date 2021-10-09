<?php

namespace App\Http\Controllers\Admi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class homeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:usuario.create');
    }
    
    public function index(){
        return view('admin.index');
    }
    public function productoUpload(){
        return view('producto.upload');
    }
    public function userCreate(){
        $roles = Role::all();
        return view('usuario.crear',compact('roles'));
    }
}
