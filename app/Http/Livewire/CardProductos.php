<?php

namespace App\Http\Livewire;

use App\Producto;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Cart;

class CardProductos extends Component
{
    public $id_producto ,$imagen,$clasificacion,$valor_venta,$color,$estilo,$nombre_producto,$precio_empresaria,$descuento,$nuevo;

    public function render()
    {
        $productos_all = Producto::where('estilo',$this->estilo)->groupBy('color')->get();
        $productos_tallas = DB::table('productos')->get();
        return view('livewire.card-productos',compact('productos_all','productos_tallas'));
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
