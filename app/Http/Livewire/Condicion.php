<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Condicion extends Component
{

    protected $listeners = ['recargar' => 'render'];

    public function render()
    {
        return view('livewire.condicion');
    }
}
