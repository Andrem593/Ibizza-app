<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Producto;

class CardProductoTienda extends Component
{
    public $id_producto ,$imagen,$clasificacion,$valor_venta,$color,$descripcion,$estilo,$nombre_producto,$precio_empresaria,$descuento;
    public function render()
    {
        $productos_all = Producto::where('estilo',$this->estilo)->groupBy('color')->get();
        $productos_tallas = DB::table('productos')->get();
        return view('livewire.card-producto-tienda',compact('productos_all','productos_tallas'));
    }
}
