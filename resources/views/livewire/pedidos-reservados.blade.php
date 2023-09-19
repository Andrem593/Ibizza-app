<div>
    <div class="{{ $detalle ? 'd-none' : '' }}">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Lista de Pedidos') }}
                </span>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card-body">

            <div class="row justify-content-start">
                <div class="col mx-2 col-sm-8">
                    <h5>Filtro de Pedidos</h5>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="desde">Desde</label>
                                <input type="date" class="form-control" wire:model="desde">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="hasta">Hasta</label>
                                <input type="date" class="form-control" wire:model="hasta">
                            </div>
                        </div>
                        {{-- <div class="col d-flex align-items-center">
                            <button class="btn btn-ibizza mt-2" onclick="filtro()">
                                <i class="fas fa-search"></i>                                                                                                                                                
                            </button>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="row justify-content-end">
                <div class="col col-sm-3">
                    <div class="form-group form-group-sm">
                        <input type="text" class="form-control" placeholder="Buscar.." wire:model="search">
                    </div>
                </div>
            </div>

            <div class="table-responsive px-3">
                <table id="datatable" class="display table table-striped table-sm table-hover fw-bold"
                    style="font-size: 12px">
                    <thead class="bg-ibizza text-center">
                        <tr>
                            <th># Pedido</th>
                            <th>Empresaria</th>
                            <th>Tipo Empresaria</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Asesor</th>
                            <th>Fecha Emisión</th>
                            <th>Fecha Vencimiento</th>
                            <td>Opc</td>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if (count($separado) > 0)
                            @foreach ($separado as $item)
                                <tr class="my-auto">
                                    <td>{{ sprintf('%06d', $item->id) }}</td>
                                    <td>{{ $item->empresaria->nombres . ' ' . $item->empresaria->apellidos }}</td>
                                    <td>{{ $item->empresaria->tipo_cliente }}</td>
                                    <td>{{ $item->cantidad_total }}</td>
                                    <td>${{ $item->total_venta }}</td>
                                    <td>{{ $item->usuario->name }}</td>
                                    <td>{{ $item->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $item->created_at->addDays(3)->format('Y-m-d') }}</td>
                                    <td>
                                        <button wire:click="verDetalle('{{ $item->id }}')"
                                            class="btn btn-ibizza btn-sm"> <i class=" fas fa-eye"></i> </button>
                                        <button wire:click="eliminarReserva('{{ $item->id }}')"
                                            class="btn btn-danger btn-sm"> <i class=" fas fa-trash"></i> </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="my-auto">
                                <td colspan="9">Sin resultados.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (count($separado) == 0)
        <div class="container">
            <div class="row">
                <div class="px-4 pb-5 my-5 text-center">
                    <img class="d-block mx-auto mb-4" src="{{ url('assets/images/reservados/shopping.png') }}"
                        alt="logo ibizza verde" width="250rem">
                    <h1 class="display-6 fw-bold">Aun no tienes Pedidos Reservados</h1>
                    <div class="col-lg-6 mx-auto">
                        <p class="lead mb-4">Dale click a realizar pedido para poder empezar a separar los productos que
                            deseas comprar antes
                            que se acabe el stock del producto.
                        </p>
                        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                            @if (Auth::user()->role == 'Empresaria')
                                <a type="button" href="{{ route('web.tomar-pedido') }}"
                                    class="btn btn-primary btn-lg px-4 gap-3">Realizar Pedido</a>
                            @else
                                <a type="button" href="{{ route('venta.pedido') }}"
                                    class="btn btn-primary btn-lg px-4 gap-3">Realizar Pedido</a>
                            @endif
                            <a type="button" href="{{ route('web') }}"
                                class="btn btn-outline-secondary btn-lg px-4">Inicio</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('css')
        <link rel="stylesheet" href="/css/botonesDataTable.css">
    @endpush
    <div class="{{ $detalle ? 'p-4' : '' }}">
        <div class="{{ $detalle ? '' : 'd-none' }}">
            <div class="row d-flex justify-content-between">
                <div class="col my-auto fw-bold">
                    DETALLE DEL PEDIDO RESERVADO
                    @empty(!$cliente)
                        <br>
                        Empresaria: <b>{{ $cliente->nombre_cliente }}</b> <br>
                    @endempty
                </div>
                <div class="col text-end">
                    <a href="{{ route('venta.pdf-pedido', $id_pedido) }}" target="_blank" id="btn-pedidoPDF"
                        class="btn bg-ibizza">
                        Descargar PDF
                    </a>
                    <button class="btn btn-primary" wire:click="$set('detalle',false)">Regresar</button>
                </div>
            </div>
            @empty(!$detalles_pedido)
                <div class="row mt-4">
                    <div class="ec-vendor-card-table">
                        <table class="table ec-table" style="font-size: 14px">
                            <thead>
                                <tr>
                                    <th scope="col">SKU</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Talla</th>
                                    <th scope="col">P.V.C</th>
                                    <th scope="col">P.V.E </th>
                                    <th scope="col">Desc.</th>
                                    <th scope="col" width="15px">Cant.</th>
                                    <th scope="col" width="15px">Total</th>
                                    <th scope="col">Dirección</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detalles_pedido as $item)
                                    <tr>
                                        {{-- <td><img src="/storage/images/productos/{{ $item->imagen_path }}" width="50px"
                                                height="50px" style="object-fit: cover">
                                        </td> --}}
                                        <td>{{ $item->sku }}</td>
                                        <td>{{ $item->descripcion }}</td>
                                        <td>{{ $item->color }}</td>
                                        <td>{{ $item->talla }}</td>
                                        <td>${{ $item->precio_empresaria }}</td>
                                        <td>${{ $item->precio }}</td>
                                        <td>{{ $item->descuento * 100 }}%</td>
                                        <td>{{ $item->cantidad }}</td>
                                        <td>${{ $item->total }}</td>
                                        <td>
                                            @php
                                                if ($item->direccion_envio != '') {
                                                    $data = json_decode($item->direccion_envio);
                                                    echo "Nombre: $data->nombre <br> Tel: $data->telefono <br> Dir: $data->direccion <br> Ref: $data->referencia";
                                                }
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4 p-4">
                    <button class="btn btn-primary" wire:click='recuperarPedido({{ $detalles_pedido }})'>RECUPERAR
                        PEDIDO</button>
                </div>
            @endempty
        </div>
    </div>
    @push('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
    @if ($alert)
        <script>
            Swal.fire({
                title: 'Reserva Liberada!',
                icon: 'success',
                confirmButtonColor: '#009788',
            })
        </script>
    @endif
</div>
