<?php

namespace App\Http\Livewire;

use App\Marca;
use App\Catalogo;
use App\Producto;
use Livewire\Component;
use Svg\Tag\RadialGradient;
use App\Models\Oferta as OfertaModel;
use Illuminate\Support\Facades\Redirect;


class Oferta extends Component
{
    public $estilo, $estilo2, $click = false, $similitudes = [], $similitudes2 = [], $message = '';
    public $productos = [], $productos2 = [];
    public $tipoOferta = 1, $tipoPremio = 1;
    public $oferta, $catalogo, $marca, $desde, $valor;
    public $editOferta, $edit = false;
    public $cantidadPrem, $cantidadPro;
    public $clasificacion, $clasificaciones;

    public function render()
    {
        $catalogos = Catalogo::all();

        $this->marcas = Marca::where('estado', 'A')->get();

        $this->clasificaciones = Producto::distinct()->where('estado', 'A')
        ->where('clasificacion_global', '!=', null)
        ->select('clasificacion_global')->get();        

        if (!empty($this->estilo)) {
            $this->similitudes = Producto::distinct()->where('estilo', 'like', '%' . $this->estilo . '%')
                ->where('estado', 'A')
                ->where('stock', '>', 0)
                ->select('estilo', 'color')
                ->limit(50)
                ->get();
        }
        if (!empty($this->estilo2)) {
            $this->similitudes2 = Producto::distinct()->where('estilo', 'like', '%' . $this->estilo2 . '%')
                ->where('estado', 'A')
                ->where('stock', '>', 0)
                ->select('estilo', 'color')
                ->limit(50)
                ->get();
        }

        if ($this->editOferta && !$this->edit) {
            $this->oferta = $this->editOferta->oferta;
            $this->catalogo = $this->editOferta->catalogo_id;
            $this->marca = $this->editOferta->marca_id;
            $this->tipoOferta = $this->editOferta->tipo_oferta;
            $this->productos = json_decode($this->editOferta->productos);
            $this->desde = $this->editOferta->desde;
            $this->valor = $this->editOferta->valor;
            $this->tipoPremio = $this->editOferta->tipo_premio;
            $this->productos2 = json_decode($this->editOferta->premios);
            $this->clasificacion = $this->editOferta->clasificacion;
            $this->edit = true;

            if($this->editOferta->tipo_oferta == 2 || $this->editOferta->tipo_oferta == 3){
                $this->cantidadPro = $this->editOferta->cantidad;
            }
        }
        return view('livewire.oferta', compact('catalogos'));
    }

    public function clickSimilitud($similitud, $color)
    {
        $this->similitudes = [];
        $this->estilo = '';

        $pro = Producto::where('estilo', $similitud)
            ->where('color', $color)
            ->where('estado', 'A')
            ->where('stock', '>', 0)
            ->first();
        if ($pro) {
            $this->productos[] = [
                'id' => $pro->id,
                'estilo' => $pro->estilo,
                'color' => $pro->color,
                'cantidad' => $this->cantidadPro,
            ];
        }
        $this->cantidadPro = '';
    }

    public function clickSimilitud2($similitud, $color)
    {
        $this->similitudes2 = [];
        $this->estilo2 = '';

        $pro = Producto::where('estilo', $similitud)
            ->where('color', $color)
            ->where('estado', 'A')
            ->where('stock', '>', 0)
            ->first();
        if ($pro) {
            $this->productos2[] = [
                'id' => $pro->id,
                'estilo' => $pro->estilo,
                'color' => $pro->color,
                'cantidad' => $this->cantidadPrem,
            ];
        }
        $this->cantidadPrem = '';
    }

    public function guardar()
    {
        try {
            if ($this->editOferta) {
                OfertaModel::find($this->editOferta->id)->update([
                    'oferta' => $this->oferta,
                    'catalogo_id' => $this->catalogo,
                    'marca_id' => $this->marca,
                    'tipo_oferta' => $this->tipoOferta,
                    'productos' => json_encode($this->productos),
                    'desde' => $this->desde,
                    'valor' => $this->valor,
                    'tipo_premio' => $this->tipoPremio,
                    'premios' => json_encode($this->productos2),
                    'clasificacion' => $this->clasificacion
                ]);

                if($this->editOferta->tipo_oferta == 2 || $this->editOferta->tipo_oferta == 3){
                    OfertaModel::where('id',$this->editOferta->id)->update([
                        'cantidad' => $this->cantidadPro
                    ]);
                }
                $this->message = 'Oferta actualizada correctamente';
                $this->reset([
                    'estilo', 'estilo2', 'click', 'similitudes', 'similitudes2', 'message',
                    'productos', 'productos2', 'tipoOferta', 'tipoPremio', 'oferta', 'catalogo', 'marca', 'desde', 'valor'
                ]);
                Redirect::to('catalogo/ofertas');
            } else {
                if ( $this->marca == 0 ){
                    $this->marca = null;
                }                
                $oferta = OfertaModel::create([
                    'oferta' => $this->oferta,
                    'catalogo_id' => $this->catalogo,
                    'marca_id' => $this->marca,
                    'tipo_oferta' => $this->tipoOferta,
                    'productos' => json_encode($this->productos),
                    'desde' => $this->desde,
                    'valor' => $this->valor,
                    'tipo_premio' => $this->tipoPremio,
                    'premios' => json_encode($this->productos2),
                    'clasificacion' => $this->clasificacion,
                ]);

                if($oferta->tipo_oferta == 2 || $oferta->tipo_oferta == 3){
                    OfertaModel::where('id',$oferta->id)->update([
                        'cantidad' => $this->cantidadPro
                    ]);
                }

                $this->message = 'Oferta guardada correctamente';

                $this->reset([
                    'estilo', 'estilo2', 'click', 'similitudes', 'similitudes2', 'message',
                    'productos', 'productos2', 'tipoOferta', 'tipoPremio', 'oferta', 'catalogo', 'marca', 'desde', 'valor'
                ]);
            }

            Redirect::to('catalogo/ofertas');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
