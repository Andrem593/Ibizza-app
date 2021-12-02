<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Cart;

class ListaProductosCart extends Component
{
    public function render()
    {
        return view('livewire.lista-productos-cart');
    }
    public function incremento($rowId, $cantidad)
    {
        $cantidad++;
        Cart::update($rowId, $cantidad);
        $this->emit('resumen');
    }
    public function decremento($rowId, $cantidad)
    {
        if ($cantidad > 1) {            
            $cantidad--;
            Cart::update($rowId, $cantidad);
            $this->emit('resumen');
        }
    }
    public function eliminarItem($rowId)
    {
        Cart::remove($rowId);
        $this->emit('resumen');
    }
}
