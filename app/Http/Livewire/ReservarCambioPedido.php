<?php

namespace App\Http\Livewire;

use App\Models\ReservarCambiosDetalle;
use App\Models\ReservarCambiosPedido;
use App\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReservarCambioPedido extends Component
{

    public $reserveChangesOrders ;

    public $reserveChangesDetails ;

    public $detalle = false ;

    public $id_pedido = 1 ;

    public $desde;

    public $hasta ;

    public $search;

    public function render()
    {
        $reserveChangeOrder = ReservarCambiosPedido::with('businesswoman', 'user', 'reservedChangeDetail')
        ->where('estado','!=', 0);

        if (Auth::user()->role != 'ADMINISTRADOR') {
            $reserveChangeOrder->where('id_usuario', Auth::user()->id);
        }

        if ($this->search != "") {
            $reserveChangeOrder->where(function ($query) {
                $query->where('f_nombre', 'like', '%' . $this->search . '%')
                    ->orWhereHas('businesswoman', function ($query) {
                        $query->where('nombres', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user', function ($query) {
                        $query->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('businesswoman', function ($query) {
                        $query->where('tipo_cliente', 'like', '%' . $this->search . '%');
                    });
            });

            if (Auth::user()->role != 'ADMINISTRADOR') {
                $reserveChangeOrder->where('id_usuario', Auth::user()->id);
            }
        }

        if ($this->desde != "" && $this->hasta != "") {
            $reserveChangeOrder->where(function ($query) {
                $query->whereDate('created_at', '>=', $this->desde)
                    ->whereDate('created_at', '<=', $this->hasta);
            });
        }

        $this->reserveChangesOrders = $reserveChangeOrder->get();

        return view('livewire.reservar-cambio-pedido');
    }



    public function verDetalle($id)
    {
        $this->detalle = true ;
        $this->id_pedido = $id;

        $this->reserveChangesDetails = ReservarCambiosDetalle::with('product', 'reserveChangesOrder')
                    ->where('id_reservar_cambio_pedido', $id)->get();
    }


    public function eliminarReserva($id)
    {
        try {

            DB::beginTransaction();
            $reserveChangesOrder = ReservarCambiosPedido::findOrFail($id);



            if($reserveChangesOrder && $reserveChangesOrder->estado == 1){
                $reserveChangesOrder->estado = 4 ;
                $reserveChangesOrder->save();


                $reserveChangesDetail = ReservarCambiosDetalle::where('id_reservar_cambio_pedido', $id)->get();

                foreach ($reserveChangesDetail as $key => $detail) {
                    $product = Producto::findOrfail($detail->id_producto);
                    $product->stock += $detail->cantidad ;
                    $product->save();
                }

                // $this->reserveChangesDetails = $this->reserveChangesDetails->filter(function($r) use($id) {
                //         return $r['id'] !== $id ;
                //     })->values();
            }

            DB::commit();
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
            dd("Error");
            //throw $th;
        }


    }



    public function recuperarCambioPedido($id)
    {
        return redirect()->to(route('venta.cambios-reservados', ['id' => $this->id_pedido]));
    }
}
