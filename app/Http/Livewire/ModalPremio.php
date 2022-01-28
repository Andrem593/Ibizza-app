<?php

namespace App\Http\Livewire;

use App\Models\Premio_has_Producto;
use App\Premio;
use Livewire\Component;

class ModalPremio extends Component
{
    protected $listeners = ['viewPremio'];
    public $premios, $premio;

    public function render()
    {
        return view('livewire.modal-premio');
    }


    public function viewPremio($id_premio)
    {
        $this->dispatchBrowserEvent('contentChanged');
        $this->premios = Premio_has_Producto::where('premio_id', $id_premio)
        ->join('productos', 'productos.estilo', '=', 'premio_has_productos.estilo')
        ->select('productos.*')
        ->groupBy('productos.estilo')
        ->get();

        $this->premio = Premio::where('id', $id_premio)
        ->first();
        
    }
}
