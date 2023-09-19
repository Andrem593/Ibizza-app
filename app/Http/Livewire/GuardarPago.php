<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Venta;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class GuardarPago extends Component
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

    public $pagos = [];
    protected $listeners = ['setVenta'];

    public $bandera = false;

    public function render()
    {
        if (!empty($this->venta_id)) {
            $this->pagos = Pago::with('usuario')->where('id_venta', $this->venta_id)->latest()->get();
            $this->calcularValorRecaudadoTodal();
        }
        return view('livewire.guardar-pago');
    }
    
    public function resetForm(){
        $this->resetearFileInput++;
    }
    
    public function calcularValorRecaudadoTodal(){
        $valorRecaudadoTotal = collect($this->pagos)->map(function ($pago) {
                                    return $pago->valor_recaudado;
                                })->sum();
                                
        $this->valor_recaudado_total = number_format((float)($valorRecaudadoTotal), 2, ".", "");
        $this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado_total), 2,".", "");
    }

    public function editar($id)
    {
        $pago = Pago::where('id', $id)->first();
        $this->pago_id = $pago->id;
        $this->valor_pagar = $pago->valor_pagar;
        $this->valor_recaudado = $pago->valor_recaudado;
        $this->valor_pendiente = $pago->valor_pendiente;
        
        $this->tipo_pago = $pago->tipo_pago; //Establece el tipo de pago
        $this->calcularValorRecaudadoTodal(); //Calcula todos los valores_recaudados del detalle
        
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
            //$this->valor_recaudado = 0;
        } else {
            if($this->valor_recaudado == 0):
                $this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", "");
            endif;
            
            if($this->valor_pendiente > 0):
                $this->valor_pendiente = number_format((float)($this->valor_pendiente - $this->valor_recaudado), 2, ".", "");
                //$this->valor_pendiente = $this->valor_pagar - $this->valor_recaudado;
                //$this->valor_recaudado_total = $this->valor_recaudado_total + $this->valor_recaudado;
            endif;
        }
    }

    public function setVenta($value)
    {
        $this->venta_id = $value;

        $venta = Venta::where('id', $value)->first();
        $pago = Pago::where('id_venta', $value)->latest()->first();

        $total_venta = $venta->total_venta;
        
        if (!empty($pago)) {
            //$total_venta = $pago->valor_pendiente;
            $total_veta = $venta->total_venta;
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
        $this->valor_recaudado = 0;
        
        //$this->valor_recaudado = $total_venta;
        //$this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado_total), 2,".", "");

    }
    
    public function validarTipoPago(){
        
        $this->esPagoLocalIbizza = $this->tipo_pago == 'LI' || $this->tipo_pago == 'CP' ? true : false;
    }

    public function guardar()
    {
        $validatedData = $this->validate([
            'valor_recaudado' => 'required|numeric|gt:0',
            'tipo_pago' => Rule::in(['TR','TC','SF','LI','CP']),
        ], [
            'valor_recaudado.required' => 'Ingrese un valor numérico',
            'valor_recaudado.gt' => 'Debe ser mayor a 0',
            'tipo_pago.in' => 'Seleccione un tipo de pago',
        ]);
        
        //Si el pago es diferente de local Ibizza, validar comprobante
        if ($this->tipo_pago <> 'LI' && $this->tipo_pago <> 'CP'):
            $this->validate([
            'comprobante' => 'required|image',
        ], 
        [
            'comprobante.required' => 'El comprobante de pago es necesario',
        ]);
        endif;
        

        if ($this->valor_recaudado_total <> $this->valor_pagar):
            // if ($this->valor_recaudado <= $this->valor_pagar) {
                $insert = Pago::create([
                    'id_venta' => $this->venta_id,
                    'id_usuario' => Auth::user()->id,
                    'valor_pagar' => number_format((float)$this->valor_pagar, 2, ".", ""),
                    'valor_recaudado' => number_format((float)$this->valor_recaudado, 2, ".", ""),
                    //'valor_pendiente' => number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", ""),
                    //'valor_pendiente' =>  number_format((float)($this->valor_pendiente), 2, ".", ""),
                    'valor_pendiente' => number_format((float)($this->valor_pendiente - $this->valor_recaudado), 2, ".", ""),
                    'tipo_pago' => $this->tipo_pago
                ]);
    
                $valor = Pago::find($insert->id);
                //Solo permitir subir comprobante si es el arreglo de archivos no esta vacio y el pago es difrente de local ibizza
                if ($this->tipo_pago <> 'LI' && $this->tipo_pago <> 'CP') :
                    $image = $valor->id . "." . date('d.m.Y.h.i.s') . "." . $this->comprobante->getClientOriginalName();
                    $ruta = public_path('storage/images/recibos/') . $image;
                    Image::make($this->comprobante)
                        ->resize(1200, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($ruta);
                    $valor->comprobante = 'storage/images/recibos/' . $image;
                endif;
                $valor->save();
                Venta::find($this->venta_id)->update(['estado' => 'PEDIDO POR VALIDAR']);
            // }
       endif;
       
        //$this->valor_pagar = number_format((float)$this->valor_pendiente, 2, ".", "");
        //$this->valor_recaudado = number_format((float)$this->valor_pendiente, 2, ".", "");
        //$this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", "");
        //$this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado_total), 2, ".", "");
        
        $this->valor_recaudado = 0;
        $this->valor_recaudado_total = 0;
        $this->tipo_pago = "";
        $this->esPagoLocalIbizza = false;
        $this->comprobante = "";
        session()->flash('message', 'Se ha generado el pago correctamente.');
        
        
        $this->setVenta($this->venta_id);
        $this->resetForm();
    }

    public function actualizar()
    {
        $validatedData = $this->validate([
            'valor_recaudado' => 'required|numeric',
           //'comprobante' => 'required|image',
        ], 
        [
            'valor_recaudado.required' => 'Ingrese un valor numérico',
            //'comprobante.required' => 'El comprobante de pago es necesario',
        ]);
        
         

        // if ($this->valor_recaudado <= $this->valor_pagar) {
            $valor = Pago::find($this->pago_id);
            $valor->valor_pagar = number_format((float)$this->valor_pagar, 2, ".", "");
            $valor->valor_recaudado = number_format((float)$this->valor_recaudado, 2, ".", "");
            $valor->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", "");
            $valor->tipo_pago = $this->tipo_pago;
            $valor->id_usuario = Auth::user()->id;
            
            if (!empty($_FILES["file"])) :
                $image = $valor->id . "." . date('d.m.Y.h.i.s') . "." . $this->comprobante->getClientOriginalName();
                $ruta = public_path('storage/images/recibos/') . $image;
                Image::make($this->comprobante)
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save($ruta);
                    $valor->comprobante = 'storage/images/recibos/' . $image;
            endif;
            $valor->save();
        // }
        if ($this->valor_pendiente == 0) {
            $this->bandera = false;
        } else {
            $this->bandera = true;
            $this->dispatchBrowserEvent('cancelar');
        }

        //$this->valor_pagar = number_format((float)$this->valor_pendiente, 2, ".", "");
        //$this->valor_recaudado = number_format((float)$this->valor_pendiente, 2, ".", "");
        //$this->valor_pendiente = number_format((float)($this->valor_pagar - $this->valor_recaudado), 2, ".", "");
        //$this->tipo_pago = $this->tipo_pago;
        $this->comprobante = "";
    }
}
