<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CardPremio extends Component
{
    public  $id_producto,$imagen,$clasificacion,$color,$estilo, $pvp;

    public function render()
    {
        $productos_all = DB::table('productos')->groupBy('color')->get();
        $productos_tallas = DB::table('productos')->get();
        return view('livewire.card-premio',compact('productos_all','productos_tallas'));

    }
}
