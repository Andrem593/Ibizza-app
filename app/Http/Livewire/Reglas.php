<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Reglas extends Component
{
    public $columnas = [];
    public function render()
    {
        return view('livewire.reglas');
    }
}
