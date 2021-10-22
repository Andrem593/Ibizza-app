<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Producto;
use Illuminate\Http\Request;

class webController extends Controller
{
    public function __invoke()
    {
        $marcas = DB::table('marcas')->where('imagen','<>','')->get();
        $productos_all = DB::table('productos')->groupBy('color')->get();
        $productos_tallas = DB::table('productos')->get();
        $productos = DB::table('productos')->groupBy('grupo','seccion','clasificacion')->get();
        return view('welcome2',compact('productos','marcas','productos_all','productos_tallas'));
    }
}
