<?php

namespace App\Http\Livewire;

use App\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModalQuickView extends Component
{
    public $productos_color;
    protected $listeners = ['quickView'];

    public function render()
    {
        return view('livewire.modal-quick-view');
    }

    public function quickView($estilo)
    {
        $productos_color = Producto::where('estilo', $estilo)->groupBy('color')->get();
        $catalogo = DB::table('catalogo_has_productos')->join('catalogos', 'catalogos.id', '=', 'catalogo_has_productos.catalogo_id')
            ->join('productos', 'productos.estilo', '=', 'catalogo_has_productos.estilo')
            ->select('catalogos.*')
            ->where('productos.estilo', '=', $estilo)
            ->groupBy('color')->first();
        $tallas = Producto::where('estilo', $estilo)->where('color', $productos_color[0]->color)->get();

        $this->productos_color = 2;
        
    }
}
