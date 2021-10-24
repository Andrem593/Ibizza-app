<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Cart;

class IbizzaSideCart extends Component
{
    protected $listeners = ['render' => 'render'];
    
    public function render()
    {
        return view('livewire.ibizza-side-cart');
    }
}
