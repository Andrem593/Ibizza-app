<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Imagen extends Component
{
    use WithFileUploads;
    
    public $ruta_imagen,$image;


    public function render()
    { 
        return view('livewire.imagen');
    }
}
