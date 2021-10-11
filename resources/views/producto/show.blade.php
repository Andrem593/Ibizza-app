<x-app-layout>
    @section('title', 'Productos')
        {{-- @endsection --}}

        <x-slot name="header">
            <h5 class="text-center">Productos</h5>
        </x-slot>

        <div class="recuadro mx-auto">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <span class="card-title">Show Producto</span>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('productos.index') }}"> Back</a>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="form-group">
                                <strong>Categoria Id:</strong>
                                {{ $producto->categoria_id }}
                            </div>
                            <div class="form-group">
                                <strong>Marca Id:</strong>
                                {{ $producto->marca_id }}
                            </div>
                            <div class="form-group">
                                <strong>Descripcion:</strong>
                                {{ $producto->descripcion }}
                            </div>
                            <div class="form-group">
                                <strong>Linea:</strong>
                                {{ $producto->linea }}
                            </div>
                            <div class="form-group">
                                <strong>Color:</strong>
                                {{ $producto->color }}
                            </div>
                            <div class="form-group">
                                <strong>Nombre Color:</strong>
                                {{ $producto->nombre_color }}
                            </div>
                            <div class="form-group">
                                <strong>Precio:</strong>
                                {{ $producto->precio }}
                            </div>
                            <div class="form-group">
                                <strong>Descuento:</strong>
                                {{ $producto->descuento }}
                            </div>
                            <div class="form-group">
                                <strong>Sku:</strong>
                                {{ $producto->sku }}
                            </div>
                            <div class="form-group">
                                <strong>Cantidad:</strong>
                                {{ $producto->cantidad }}
                            </div>
                            <div class="form-group">
                                <strong>Stock Inicial:</strong>
                                {{ $producto->stock_inicial }}
                            </div>
                            <div class="form-group">
                                <strong>Coleccion:</strong>
                                {{ $producto->coleccion }}
                            </div>
                            <div class="form-group">
                                <strong>Fecha Entrega:</strong>
                                {{ $producto->fecha_entrega }}
                            </div>
                            <div class="form-group">
                                <strong>Status Fabrica:</strong>
                                {{ $producto->status_fabrica }}
                            </div>
                            <div class="form-group">
                                <strong>Vigencia:</strong>
                                {{ $producto->vigencia }}
                            </div>
                            <div class="form-group">
                                <strong>Observacion:</strong>
                                {{ $producto->observacion }}
                            </div>
                            <div class="form-group">
                                <strong>Pvp:</strong>
                                {{ $producto->pvp }}
                            </div>
                            <div class="form-group">
                                <strong>Imagen:</strong>
                                {{ $producto->imagen }}
                            </div>
                            <div class="form-group">
                                <strong>Status Imagen:</strong>
                                {{ $producto->status_imagen }}
                            </div>
                            <div class="form-group">
                                <strong>Precio Mayorista:</strong>
                                {{ $producto->precio_mayorista }}
                            </div>
                            <div class="form-group">
                                <strong>Modelo:</strong>
                                {{ $producto->modelo }}
                            </div>
                            <div class="form-group">
                                <strong>Numero Pedido:</strong>
                                {{ $producto->numero_pedido }}
                            </div>
                            <div class="form-group">
                                <strong>Proveedor Id:</strong>
                                {{ $producto->proveedor_id }}
                            </div>
                            <div class="form-group">
                                <strong>Clasificacion:</strong>
                                {{ $producto->clasificacion }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
