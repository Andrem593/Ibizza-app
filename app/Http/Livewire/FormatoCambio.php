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
    public $e_nombre, $e_cedula, $e_telefono, $e_provincia, $e_ciudad, $e_direccion, $e_pedido, $e_c_envio;
    public $selectedItems = [];

    public $selectedItem = null;
    public $selectedItemData = [
        'sku' => '',
        'descripcion' => '',
        'color' => '',
        'talla' => '',
        'cantidad' => '',
        'descuento' => '',
        'pvp' => '',
        'p_empresaria' => ''
    ];

    public $changes = [];


    public function render()
    {
        $this->user = Auth::user();
        if (!empty($this->cliente) && !$this->click2) {
            $this->empresarias = Empresaria::with('pedidos')->where(function ($query) {
                $query->where('nombres', 'like', '%' . $this->cliente . '%')
                    ->orWhere('cedula', 'like', '%' . $this->cliente . '%');
            })
                ->where('estado', 'A')
                ->limit(20)
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
        $this->emp = Empresaria::with('pedidos', 'usuario', 'ciudad')->find($this->id_empresaria);
        $this->f_cedula = $this->emp->cedula;
        $this->f_nombre = $this->emp->nombres . ' ' . $this->emp->apellidos;
        $this->f_telefono = $this->emp->telefono;
        $this->f_correo = $this->emp->usuario->email;
        $this->e_nombre = $this->emp->nombres . ' ' . $this->emp->apellidos;
        $this->e_cedula = $this->emp->cedula;
        $this->e_telefono = $this->emp->telefono;
        if ($this->emp->ciudad) {
            $this->e_provincia = $this->emp->ciudad->provincia->descripcion;
            $this->e_ciudad = $this->emp->ciudad->descripcion;
        }
        $this->e_direccion = $this->emp->direccion;
        $this->empresarias = [];
        $this->click2 = true;
        $this->tipoEmpresaria = $tipo;
    }

    public function nuevosDatosFac()
    {
        $this->f_cedula = '';
        $this->f_nombre = '';
        $this->f_telefono = '';
        $this->f_correo = '';
    }

    public function nuevosDatosEnv()
    {
        $this->e_nombre = '';
        $this->e_cedula = '';
        $this->e_telefono = '';
        $this->e_provincia = '';
        $this->e_ciudad = '';
        $this->e_direccion = '';
        $this->e_pedido = '';
        $this->e_c_envio = '';
    }

    public function nuevosDatosLoc()
    {
        $this->e_nombre = 'Local Ibizza';
        $this->e_provincia = 'Guayas';
        $this->e_ciudad = 'Guayaquil';
        $this->e_direccion = 'Calle chile y Luque';
        $this->observaciones = 'Frente a De Prati';
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
            $colores = Producto::where('estilo', $estilo)->groupBy('color')
                ->where('estado', 'A')
                ->where('stock', '>', 0)
                ->get();
            $tallas = Producto::where('estilo', $estilo)
                ->join('marcas', 'marcas.id', '=', 'productos.marca_id')
                ->select('productos.*', 'marcas.nombre AS nombre_marca')
                ->where('color', $colores[0]->color)
                ->where('productos.estado', 'A')
                ->where('productos.stock', '>', 0)
                ->distinct('talla')
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

            if ($producto->stock >= $this->cantidad) {

                $originalItem = $this->pedidos->where('id_producto', $this->selectedItem)->first();

                $this->nuevoProducto[] = [
                    'id' => $producto->id,
                    'sku' => $producto->sku,
                    'descripcion' => $producto->descripcion,
                    'estilo' => $producto->estilo,
                    'color' => $producto->color,
                    'talla' => $producto->talla,
                    'marca' => $producto->marca->nombre,
                    'cantidad' => $this->cantidad,
                    'precio' => $producto->precio_empresaria,
                    'id_producto_original' => $originalItem['id_producto']
                ];


                $originalData = [
                    'id' => $originalItem['id_producto'],
                    'sku' => $originalItem['producto']['sku'],
                    'descripcion' => $originalItem['producto']['descripcion'],
                    'color' => $originalItem['producto']['color'],
                    'talla' => $originalItem['producto']['talla'],
                    'cantidad' => $originalItem['cantidad'],
                    'descuento' => $originalItem['descuento'],
                    'pvp' => number_format($originalItem['cantidad'] * $originalItem['precio'], 2),
                    'p_empresaria' => number_format($originalItem['cantidad'] * ($originalItem['precio'] - $originalItem['precio'] * $originalItem['descuento']), 2)
                ];
                $this->changes[] = [
                    'original' => $originalData,
                    'changed' => [
                        'id' => $producto->id,
                        'sku' => $producto->sku,
                        'descripcion' => $producto->descripcion,
                        'estilo' => $producto->estilo,
                        'color' => $producto->color,
                        'talla' => $producto->talla,
                        'marca' => $producto->marca->nombre,
                        'cantidad' => $this->cantidad,
                        'precio' => $producto->precio_empresaria,
                    ]
                ];

                $this->reset('selectedItem', 'selectedItemData','estilo', 'color');

            } else {
                $this->message = 'NO HAY STOCK DISPONIBLE';
            }
            $this->productosACambiar = json_encode($this->productosACambiar);
        } else {
            $this->click = false;
            $this->message = 'VERIFIQUE QUE ESTEN TODOS LOS CAMPOS LLENOS';
        }
    }

    public function selectItem($itemId)
    {
        $item = $this->pedidos->where('id_producto', $itemId)->first();
        $this->selectedItem = $itemId;
        $this->selectedItemData = [
            'sku' => $item['producto']['sku'],
            'descripcion' => $item['producto']['descripcion'],
            'color' => $item['producto']['color'],
            'talla' => $item['producto']['talla'],
            'cantidad' => $item['cantidad'],
            'descuento' => $item['descuento'],
            'pvp' => number_format($item['cantidad'] * $item['precio'], 2),
            'p_empresaria' => number_format($item['cantidad'] * ($item['precio'] - $item['precio'] * $item['descuento']), 2)
        ];
    }


    public function isDisabled($itemId)
    {
        foreach ($this->changes as $change) {
            if ($change['original']['id'] == $itemId) {
                return true;
            }
        }
        return false;
    }


    public function deleteProduct($index)
    {
        $deletedItem = $this->nuevoProducto[$index];

        unset($this->nuevoProducto[$index]);
        $this->nuevoProducto = array_values($this->nuevoProducto); // Reindex array

        foreach ($this->changes as $key => $change) {
            if ($change['original']['id'] == $deletedItem['id_producto_original']) {
                // dd($change['original']['id'], $key, $this->changes[$key] , $this->changes );
                unset($this->changes[$key]);
                break;
            }
        }
        $this->changes = array_values($this->changes); // Reindex array
        // dd($deletedItem);

    }
}
