<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Venta;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class GuardarPago extends Component
{
    use WithFileUploads;

    public $venta_id;
    public $valor_pagar;
    public $valor_recaudado;
    public $valor_pendiente;
    public $comprobante;

    public $pagos = [];
    protected $listeners = ['setVenta'];

    public function render()
    {
        if(!empty($this->venta_id)){
            $this->pagos = Pago::with('usuario')->where('id_venta', $this->venta_id)->get();
        }

        return view('livewire.guardar-pago');
    }

    public function calcular()
    {

        $validatedData = $this->validate([
            'valor_recaudado' => 'required|numeric',
        ], [
            'valor_recaudado.required' => 'Ingrese un valor numérico',
        ]);

        $this->valor_pendiente = $this->valor_pagar - $this->valor_recaudado;
    }

    public function setVenta($value)
    {
        $this->venta_id = $value;

        $venta = Venta::where('id', $value)->first();
        $pago = Pago::where('id_venta', $value)->latest()->first();

        $total_venta = $venta->total_venta;

        if (!empty($pago)) {
            $total_venta = $pago->valor_pendiente;
        }
        $this->valor_pagar = $total_venta;
        $this->valor_recaudado = $total_venta;
        $this->valor_pendiente = $this->valor_pagar - $this->valor_recaudado;
    }

    public function guardar()
    {
        $validatedData = $this->validate([
            'valor_recaudado' => 'required|numeric',
            'comprobante' => 'required|image',
        ], [
            'valor_recaudado.required' => 'Ingrese un valor numérico',
            'comprobante.required' => 'El comprobante de pago es necesario',
        ]);

        if ($this->valor_recaudado <= $this->valor_pagar) {
            $insert = Pago::create([
                'id_venta' => $this->venta_id,
                'id_usuario' => Auth::user()->id,
                'valor_pagar' => $this->valor_pagar,
                'valor_recaudado' => $this->valor_recaudado,
                'valor_pendiente' => $this->valor_pagar - $this->valor_recaudado,
            ]);

            $valor = Pago::find($insert->id);
            $image = $valor->id.".".date('d.m.Y.h.i.s').".".$this->comprobante->getClientOriginalName();
            $ruta = public_path('storage/images/recibos/') . $image;
            Image::make($this->comprobante)
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta); 
            $valor->comprobante = 'storage/images/recibos/'.$image;
            $valor->save();
        }

        $this->valor_pagar = $this->valor_pendiente;
        $this->valor_recaudado = $this->valor_pendiente;
        $this->valor_pendiente = $this->valor_pagar - $this->valor_recaudado;
        $this->comprobante = "";
    }
}
