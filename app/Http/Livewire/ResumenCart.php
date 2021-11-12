<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ResumenCart extends Component
{
    protected $listeners = ['resumen' => 'render'];
    
    public function render()
    {
        return view('livewire.resumen-cart');
    }
}
