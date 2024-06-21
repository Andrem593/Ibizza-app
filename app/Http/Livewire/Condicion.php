<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Condicion extends Component
{

    protected $listeners = ['recargar' => 'render'];

    public function render()
    {
        return view('livewire.condicion');
    }

     public function reloadComponent()
    {
        Log::info('reloadComponent method called'); // Para depuración
        // Si tienes lógica adicional para recargar el componente, inclúyela aquí
    }
}
