<?php

namespace App\Http\Controllers;

use App\Models\ReservarCambiosPedido;
use Illuminate\Http\Request;

use PDF;

class ReservarCambiosPedidosController extends Controller
{
    public function cambios_pedidos_guardados()
    {
        return view('cambio.cambios-reservados');
    }



    public function generatePdfChangeReserved($id)
    {
        $reserveChangeOrder = ReservarCambiosPedido::with('reservedChangeDetail.product',
            'province', 'city',
            'businesswoman')
            ->findOrFail($id);
        $pdf = PDF::loadView('cambio.comprobante-cambio-guardado', compact('reserveChangeOrder'));
        return $pdf->stream();
    }




}
