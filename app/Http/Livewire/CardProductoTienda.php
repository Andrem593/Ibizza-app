<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CardProductoTienda extends Component
{
    public $id_producto ,$imagen,$clasificacion,$valor_venta,$color,$descripcion;
    public function render()
    {
        $productos_all = DB::table('productos')->groupBy('color')->get();
        $productos_tallas = DB::table('productos')->get();
        return view('livewire.card-producto-tienda',compact('productos_all','productos_tallas'));
    }
}
