<?php

namespace App\Http\Livewire;

use App\Models\CambioPedido;
use App\Models\PagosCambio;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class GuardarPagoCambio extends Component
{
    use WithFileUploads;

    public $pago_id;
    public $venta_id;
    public $valor_pagar;
    public $valor_recaudado;
    public $valor_pendiente;
    public $comprobante;
    public $tipo_pago;
    public $valor_recaudado_total;
    public $resetearFileInput;
    public $esPagoLocalIbizza = false;
    public $previewUrl ;

    public $pagos = [];
    protected $listeners = ['setCambio', 'updatePreviewUrl'];

    //Cambiar el estado de la Bandera
    public $bandera = false;

    public function render()
    {        
        if (!empty($this->venta_id)) {
            $this->pagos = PagosCambio::with('user')->where('id_cambio', $this->venta_id)->latest()->get();
            $this->calcularValorRecaudadoTodal();
        }

        return view('livewire.guardar-pago-cambio');
    }


    public function resetForm()
    {
        $this->resetearFileInput++;
    }

    public function updatePreviewUrl($url)
    {
        $this->previewUrl = $url;
    }


    public function calcularValorRecaudadoTodal()
    {
        $valorRecaudadoTotal = collect($this->pagos)->map(function ($pago) {
                                    return $pago->valor_recaudado;
                                })->sum();

        $this->valor_recaudado_total = number_format((float)($valorRecaudadoTotal), 2, ".", "");

        $this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado_total), 2,".", "");
    }

    public function cancelar()
    {
        $pago = PagosCambio::where('id_cambio', $this->venta_id)->latest()->first();
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
        $this->tipo_pago = "";
        $this->valor_recaudado_total = "";
        $this->dispatchBrowserEvent('cancelar');
    }


    public function calcular()
    {
        $validatedData = $this->validate([
            'valor_recaudado' => 'required|numeric'
        ], [
            'valor_recaudado.required' => 'Ingrese un valor numérico',
        ]);

        if ($this->valor_recaudado > $this->valor_pagar || $this->valor_recaudado > $this->valor_pendiente) {
        } else {
            if($this->valor_recaudado == 0):
                $this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", "");
            endif;

            if($this->valor_pendiente > 0):
                $this->valor_pendiente = number_format((float)($this->valor_pendiente - $this->valor_recaudado), 2, ".", "");
            endif;
        }
    }


    public function setCambio($value)
    {
        $this->venta_id = $value;

        $changeOrder = CambioPedido::where('id', $value)->first();
        $paymentsChange = PagosCambio::where('id_cambio', $value)->latest()->first();

        $totalPay = $changeOrder->total_pagar;

        if (!empty($pago)) {
            if ($paymentsChange->valor_pendiente == 0 || $changeOrder->estado == 'CAMBIO FACTURADO' || $changeOrder->estado == 'CAMBIO FACTURADO Y DESPACHADO' || $changeOrder->estado == 'CAMBIO APROBADO') {
                $this->bandera = false; //Bandera en false significa que se ocultan los campos para subir pagos
            } else {
                $this->bandera = true;
                $this->dispatchBrowserEvent('cancelar');
            }
        }else{
            $this->bandera = true;
            $this->dispatchBrowserEvent('cancelar');
        }
        $this->valor_pagar = $totalPay;
        $this->valor_recaudado = 0;
    }

    public function validarTipoPago(){

        $this->esPagoLocalIbizza = $this->tipo_pago == 'LI' || $this->tipo_pago == 'CP' || $this->tipo_pago == 'RI' ? true : false;
    }


    public function guardar()
    {
        $this->previewUrl = '';
        $validatedData = $this->validate([
            
            'valor_recaudado' => $this->tipo_pago == 'LI' || $this->tipo_pago == 'RI' ? 'required|numeric' : 'required|numeric|gt:0',
            'tipo_pago' => Rule::in(['TR','TC','SF','LI','RI','CP','CL']),
        ], [
            'valor_recaudado.required' => 'Ingrese un valor numérico',
            'valor_recaudado.gt' => 'Debe ser mayor a 0',
            'tipo_pago.in' => 'Seleccione un tipo de pago',
        ]);

        //Si el pago es diferente de local Ibizza, validar comprobante
        if ($this->tipo_pago <> 'LI' && $this->tipo_pago <> 'CP' && $this->tipo_pago <> 'CL' && $this->tipo_pago <> 'RI'):
            $this->validate([
            'comprobante' => 'required|image',
        ],
        [
            'comprobante.required' => 'El comprobante de pago es necesario',
        ]);
        endif;

        if ($this->valor_recaudado_total <> $this->valor_pagar || $this->tipo_pago == 'RI'):
                $insert = PagosCambio::create([
                    'id_cambio' => $this->venta_id,
                    'id_usuario' => Auth::user()->id,
                    'valor_pagar' => number_format((float)$this->valor_pagar, 2, ".", ""),
                    'valor_recaudado' => number_format((float)$this->valor_recaudado, 2, ".", ""),
                    'valor_pendiente' => number_format((float)($this->valor_pendiente - $this->valor_recaudado), 2, ".", ""),
                    'tipo_pago' => $this->tipo_pago
                ]);
                $valor = PagosCambio::find($insert->id);
                //Solo permitir subir comprobante si es el arreglo de archivos no esta vacio y el pago es difrente de local ibizza
                if ($this->tipo_pago <> 'LI' && $this->tipo_pago <> 'CP' && $this->tipo_pago <> 'CL' && $this->tipo_pago <> 'RI')  :

                    $image = $valor->id . "." . date('d.m.Y.h.i.s') . "." . $this->comprobante->getClientOriginalName();
                    $ruta = public_path('storage/images/recibos/') . $image;
                    Image::make($this->comprobante)
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($ruta);
                    $valor->comprobante = 'storage/images/recibos/' . $image;
                endif;
                $valor->save();
                CambioPedido::find($this->venta_id)->update(['estado' => 'CAMBIO POR VALIDAR']);

        endif;

        $this->valor_recaudado = 0;
        $this->valor_recaudado_total = 0;
        $this->tipo_pago = "";
        $this->esPagoLocalIbizza = false;
        $this->comprobante = "";
        session()->flash('message', 'Se ha generado el pago correctamente.');


        $this->setCambio($this->venta_id);
        $this->resetForm();
    }


}
