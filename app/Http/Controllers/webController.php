<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Producto;
use Illuminate\Http\Request;

class webController extends Controller
{
    public function __invoke()
    {
        $productos = DB::table('productos')->groupBy('grupo','seccion','clasificacion')->get();
        $marcas = DB::table('marcas')->where('imagen','<>','')->get();
        return view('welcome2',compact('marcas','productos'));
    }
}
