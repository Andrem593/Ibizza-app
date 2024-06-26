<?php

namespace App\Http\Livewire;

use App\Models\ReservarCambiosDetalle;
use App\Models\ReservarCambiosPedido;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReservarCambioPedido extends Component
{

    public $reserveChangesOrders ;

    public $reserveChangesDetails ;

    public $detalle = false ;

    public $id_pedido ;



    public function render()
    {
        $reserveChangeOrder = ReservarCambiosPedido::with('businesswoman', 'user');

        if (Auth::user()->role != 'ADMINISTRADOR') {
            $reserveChangeOrder->where('id_usuario', Auth::user()->id);
        }

        $this->reserveChangesOrders = $reserveChangeOrder->get() ;

        return view('livewire.reservar-cambio-pedido');
    }



    public function verDetalle($id)
    {
        $this->detalle = true ;
        $this->id_pedido = $id;

        $this->reserveChangesDetails = ReservarCambiosDetalle::with('product')
                    ->where('id_reservar_cambio_pedido', $id)->get();
    }


    public function eliminarReserva($id)
    {
        //Diminuir el stock
        //Cosa que no hace
        $reserveChangesOrder = ReservarCambiosPedido::findOrFail($id);
        if($reserveChangesOrder){
            $reserveChangesOrder->estado = 0 ;
            $reserveChangesOrder->save();


            $this->reserveChangesDetails = $this->reserveChangesDetails->filter(function($r) use($id) {
                return $r['id'] !== $id ;
            })->values();
        }

    }



    public function recuperarCambioPedido($id)
    {
        return redirect()->to(route('venta.cambios-reservados', ['id' => $this->id_pedido]));
    }
}
