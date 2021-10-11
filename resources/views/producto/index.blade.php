<x-app-layout>
    @section('title', 'Productos')
        {{-- @endsection --}}

        <x-slot name="header">
            <h5 class="text-center">Productos</h5>
        </x-slot>

        <div class="recuadro mx-auto">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div style="display: flex; justify-content: space-between; align-items: center;">

                                <span id="card_title">
                                    {{ __('Producto') }}
                                </span>

                                <div class="float-right">
                                    <a href="{{ route('productos.create') }}" class="btn btn-primary btn-sm float-right"
                                        data-placement="left">
                                        {{ __('Nuevo producto') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="thead">
                                        <tr>
                                            <th>No</th>

                                            <th>Categoria Id</th>
                                            <th>Marca Id</th>
                                            <th>Descripcion</th>
                                            <th>Linea</th>
                                            <th>Color</th>
                                            <th>Nombre Color</th>
                                            <th>Precio</th>
                                            <th>Descuento</th>
                                            <th>Sku</th>
                                            <th>Cantidad</th>
                                            <th>Stock Inicial</th>
                                            <th>Coleccion</th>
                                            <th>Fecha Entrega</th>
                                            <th>Status Fabrica</th>
                                            <th>Vigencia</th>
                                            <th>Observacion</th>
                                            <th>Pvp</th>
                                            <th>Imagen</th>
                                            <th>Status Imagen</th>
                                            <th>Precio Mayorista</th>
                                            <th>Modelo</th>
                                            <th>Numero Pedido</th>
                                            <th>Proveedor Id</th>
                                            <th>Clasificacion</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productos as $producto)
                                            <tr>
                                                <td>{{ ++$i }}</td>

                                                <td>{{ $producto->categoria_id }}</td>
                                                <td>{{ $producto->marca_id }}</td>
                                                <td>{{ $producto->descripcion }}</td>
                                                <td>{{ $producto->linea }}</td>
                                                <td>{{ $producto->color }}</td>
                                                <td>{{ $producto->nombre_color }}</td>
                                                <td>{{ $producto->precio }}</td>
                                                <td>{{ $producto->descuento }}</td>
                                                <td>{{ $producto->sku }}</td>
                                                <td>{{ $producto->cantidad }}</td>
                                                <td>{{ $producto->stock_inicial }}</td>
                                                <td>{{ $producto->coleccion }}</td>
                                                <td>{{ $producto->fecha_entrega }}</td>
                                                <td>{{ $producto->status_fabrica }}</td>
                                                <td>{{ $producto->vigencia }}</td>
                                                <td>{{ $producto->observacion }}</td>
                                                <td>{{ $producto->pvp }}</td>
                                                <td>{{ $producto->imagen }}</td>
                                                <td>{{ $producto->status_imagen }}</td>
                                                <td>{{ $producto->precio_mayorista }}</td>
                                                <td>{{ $producto->modelo }}</td>
                                                <td>{{ $producto->numero_pedido }}</td>
                                                <td>{{ $producto->proveedor_id }}</td>
                                                <td>{{ $producto->clasificacion }}</td>

                                                <td>
                                                    <form action="{{ route('productos.destroy', $producto->id) }}"
                                                        method="POST">
                                                        <a class="btn btn-sm btn-primary "
                                                            href="{{ route('productos.show', $producto->id) }}"><i
                                                                class="fa fa-fw fa-eye"></i> Ver</a>
                                                        <a class="btn btn-sm btn-success"
                                                            href="{{ route('productos.edit', $producto->id) }}"><i
                                                                class="fa fa-fw fa-edit"></i> Editar</a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fa fa-fw fa-trash"></i> Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {!! $productos->links() !!}
                </div>
            </div>
        </div>
    </x-app-layout>
