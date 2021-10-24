<?php

namespace App\Http\Livewire;

use App\Producto;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Cart;

class CardProductos extends Component
{
    public $id_producto ,$imagen,$clasificacion,$valor_venta,$color;

    public function render()
    {
        $productos_all = DB::table('productos')->groupBy('color')->get();
        $productos_tallas = DB::table('productos')->get();
        return view('livewire.card-productos',compact('productos_all','productos_tallas'));
    }
}
