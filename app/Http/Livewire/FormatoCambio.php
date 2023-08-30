<?php

namespace App\Http\Livewire;

use App\Producto;
use App\Empresaria;
use App\Models\Venta;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class FormatoCambio extends Component
{
    public $estilo, $colores, $tallas, $message, $color, $talla, $cantidad, $alert, $stock, $cliente, $similitudes, $click = false, $motivoCambio, $descripcionCambio, $observaciones;
    public $venta, $user, $empresarias, $tipoEmpresaria, $click2 = false, $marca, $id_empresaria, $emp;
    public $idventa, $pedidos, $productosACambiar, $nuevoProducto;
    public $f_nombre, $f_cedula, $f_telefono, $f_correo;
    public $e_nombre, $e_cedula, $e_telefono, $e_provincia, $e_ciudad, $e_direccion, $e_pedido;    


    public function render()
    {
        $this->user = Auth::user();
        if (!empty($this->cliente) && !$this->click2) {
            $this->empresarias = Empresaria::with('pedidos')->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->cliente . '%')
                    ->orWhere('cedula', 'like', '%' . $this->cliente . '%');
            })
                ->where('estado', 'A')
                ->get();
        }

        if (!empty($this->estilo) && !$this->click) {
            $this->similitudes = Producto::distinct()->where('estilo', 'like', '%' . $this->estilo . '%')->select('estilo')->get();
        }

        return view('livewire.formato-cambio');
    }

    public function clickEmpresaria($emp, $tipo)
    {
        $this->cliente = $emp['nombres'] . ' ' . $emp['apellidos'];
        $this->id_empresaria = $emp['id'];
        $this->emp = Empresaria::with('pedidos')->find($this->id_empresaria);
        $this->empresarias = [];
        $this->click2 = true;
        $this->tipoEmpresaria = $tipo;
    }

    public function clearEmpresaria()
    {
        $this->cliente = '';
        $this->empresarias = [];
        $this->id_empresaria = null;
        $this->click2 = false;
        $this->tipoEmpresaria = '';
        $this->emp = null;
    }

    public function buscarVenta()
    {
        try {
            $this->venta = Venta::where('id', $this->idventa)->where('id_empresaria', $this->id_empresaria)
                ->with('pedidos')
                ->first();

            $this->pedidos = $this->venta->pedidos;
        } catch (\Throwable $th) {
            $this->message = 'No se encontró la venta, verifique los datos';
        }
    }
    public function buscarEstilo()
    {

        try {
            $estilo = $this->estilo;
            $colores = Producto::where('estilo', $estilo)->groupBy('color')->get();
            $tallas = Producto::where('estilo', $estilo)
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca')
                ->where('color', $colores[0]->color)
                ->where('productos.estado', 'A')
                ->get();
            $this->colores = $colores;
            $this->tallas = $tallas;
            $this->color = $colores[0]->color;
            $this->marca = $tallas[0]->nombre_marca;
            $this->talla = $tallas[0]->talla;
            $this->stock = $tallas[0]->stock;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->click = false;
            $this->message = 'CODIGO INGRESADO NO ES CORRECTO O PRODUCTO NO DISPONIBLE';
            $this->reset(['colores', 'tallas']);
        }
    }
    public function buscarColor()
    {
        try {
            $estilo = $this->estilo;
            $tallas = Producto::where('estilo', $estilo)
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca')
                ->where('color', $this->color)
                ->where('productos.estado', 'A')->get();
            $this->tallas = $tallas;
            $this->talla = $tallas[0]->talla;
            $this->marca = $tallas[0]->nombre_marca;
            $this->stock = $tallas[0]->stock;
            $this->message = '';
        } catch (\Throwable $th) {
            $this->click = false;
            $this->message = 'CODIGO INGRESADO NO ES CORRECTO O PRODUCTO NO DISPONIBLE';
            $this->reset(['colores', 'tallas']);
        }
    }
    public function stockProduct($talla)
    {
        $estilo = $this->estilo;
        $producto = Producto::where('estilo', $estilo)->where('color', $this->color)->where('talla', $this->talla)->first();
        $this->stock = $producto->stock;
    }
    public function clickSimilitud($similitud)
    {
        $this->estilo = $similitud;
        $this->similitudes = [];
        $this->click = true;
        $this->buscarEstilo();
    }
    public function addCart()
    {
        $this->click = false;
        $this->message = '';
        if ($this->cantidad > 0 && !empty($this->estilo) && !empty($this->color) && !empty($this->talla)) {
            $producto = Producto::where('estilo', $this->estilo)->where('color', $this->color)->where('talla', $this->talla)
                ->where('estado', 'A')
                ->with(['marca', 'catalogo'])
                ->first();
            $this->productosACambiar = json_decode($this->productosACambiar);

            if ($producto->stock >= $this->cantidad) {
                $this->nuevoProducto[] = [
                    'id' => $producto->id,
                    'sku'=> $producto->sku,
                    'descripcion'=> $producto->descripcion,
                    'estilo' => $producto->estilo,
                    'color' => $producto->color,
                    'talla' => $producto->talla,
                    'marca' => $producto->marca->nombre,
                    'cantidad' => $this->cantidad,
                    'precio'=> $producto->precio_empresaria,
                    'descuento'=> $this->productosACambiar->descuento,
                ];
            } else {
                $this->message = 'NO HAY STOCK DISPONIBLE';
            }
            $this->productosACambiar = json_encode($this->productosACambiar);
        } else {
            $this->click = false;
            $this->message = 'VERIFIQUE QUE ESTEN TODOS LOS CAMPOS LLENOS';
        }
    }
}
