<?php

namespace App\Http\Controllers;

use App\Reporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ProveedorController
 * @package App\Http\Controllers
 */
class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reporte.index');
    }

    
}
