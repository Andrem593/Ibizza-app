<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservarCambiosPedidosController extends Controller
{
    //

    public function cambios_pedidos_guardados()
    {
        return view('cambio.cambios-reservados');
    }
}
