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

    public $pago_id;
    public $venta_id;
    public $valor_pagar;
    public $valor_recaudado;
    public $valor_pendiente;
    public $comprobante;

    public $pagos = [];
    protected $listeners = ['setVenta'];

    public $bandera = false;

    public function render()
    {
        if (!empty($this->venta_id)) {
            $this->pagos = Pago::with('usuario')->where('id_venta', $this->venta_id)->get();
        }

        return view('livewire.guardar-pago');
    }

    public function editar($id)
    {
        $pago = Pago::where('id', $id)->first();
        $this->pago_id = $pago->id;
        $this->valor_pagar = $pago->valor_pagar;
        $this->valor_recaudado = $pago->valor_recaudado;
        $this->valor_pendiente = $pago->valor_pendiente;
        $this->bandera = true;
        $this->dispatchBrowserEvent('actualizar');
    }
    public function cancelar()
    {
        $pago = Pago::where('id_venta', $this->venta_id)->latest()->first();
        if ($pago->valor_pendiente == 0) {
            $this->bandera = false;
        } else {
            $this->bandera = true;
            $this->dispatchBrowserEvent('cancelar');
        }
        $this->pago_id = "";
        $this->valor_pagar = "";
        $this->valor_recaudado = "";
        $this->valor_pendiente = "";
        $this->comprobante = "";
        $this->dispatchBrowserEvent('cancelar');
    }

    public function calcular()
    {

        $validatedData = $this->validate([
            'valor_recaudado' => 'required|numeric',
        ], [
            'valor_recaudado.required' => 'Ingrese un valor numérico',
        ]);

        if ($this->valor_recaudado > $this->valor_pagar) {
            $this->valor_recaudado = 0;
        } else {
            $this->valor_pendiente = $this->valor_pagar - $this->valor_recaudado;
        }
    }

    public function setVenta($value)
    {
        $this->venta_id = $value;

        $venta = Venta::where('id', $value)->first();
        $pago = Pago::where('id_venta', $value)->latest()->first();

        $total_venta = $venta->total_venta;

        if (!empty($pago)) {
            $total_venta = $pago->valor_pendiente;
            if ($pago->valor_pendiente == 0) {
                $this->bandera = false;
            } else {
                $this->bandera = true;
                $this->dispatchBrowserEvent('cancelar');
            }
        } else {
            $this->bandera = true;
            $this->dispatchBrowserEvent('cancelar');
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

        // if ($this->valor_recaudado <= $this->valor_pagar) {
            $insert = Pago::create([
                'id_venta' => $this->venta_id,
                'id_usuario' => Auth::user()->id,
                'valor_pagar' => number_format((float)$this->valor_pagar, 2, ".", ""),
                'valor_recaudado' => number_format((float)$this->valor_recaudado, 2, ".", ""),
                'valor_pendiente' => number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", ""),
            ]);

            $valor = Pago::find($insert->id);
            $image = $valor->id . "." . date('d.m.Y.h.i.s') . "." . $this->comprobante->getClientOriginalName();
            $ruta = public_path('storage/images/recibos/') . $image;
            Image::make($this->comprobante)
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta);
            $valor->comprobante = 'storage/images/recibos/' . $image;
            $valor->save();
            Venta::find($this->venta_id)->update(['estado' => 'PEDIDO POR VALIDAR']);
        // }

        $this->valor_pagar = number_format((float)$this->valor_pendiente, 2, ".", "");
        $this->valor_recaudado = number_format((float)$this->valor_pendiente, 2, ".", "");
        $this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", "");
        $this->comprobante = "";
    }

    public function actualizar()
    {
        $validatedData = $this->validate([
            'valor_recaudado' => 'required|numeric',
            'comprobante' => 'required|image',
        ], [
            'valor_recaudado.required' => 'Ingrese un valor numérico',
            'comprobante.required' => 'El comprobante de pago es necesario',
        ]);

        // if ($this->valor_recaudado <= $this->valor_pagar) {
            $valor = Pago::find($this->pago_id);
            $image = $valor->id . "." . date('d.m.Y.h.i.s') . "." . $this->comprobante->getClientOriginalName();
            $ruta = public_path('storage/images/recibos/') . $image;
            Image::make($this->comprobante)
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($ruta);
            $valor->valor_pagar = number_format((float)$this->valor_pagar, 2, ".", "");
            $valor->valor_recaudado = number_format((float)$this->valor_recaudado, 2, ".", "");
            $valor->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", "");
            $valor->id_usuario = Auth::user()->id;
            $valor->comprobante = 'storage/images/recibos/' . $image;
            $valor->save();
        // }
        if ($this->valor_pendiente == 0) {
            $this->bandera = false;
        } else {
            $this->bandera = true;
            $this->dispatchBrowserEvent('cancelar');
        }

        $this->valor_pagar = number_format((float)$this->valor_pendiente, 2, ".", "");
        $this->valor_recaudado = number_format((float)$this->valor_pendiente, 2, ".", "");
        $this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", "");
        $this->comprobante = "";
    }
}
