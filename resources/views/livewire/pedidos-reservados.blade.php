<div>
    @if (count($separado) > 0)
    <div class="row margin-minus-t-15 {{$detalle ? 'd-none' : ''}}">
        @foreach ($separado as $item)
        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
            <div class="ec-box-card">
                <div class="ec-wrapper wrp-img-3">
                    <div class="ec-date">
                        <span class="ec-day">{{$item->created_at->format('d')}}</span>
                        <span class="ec-month">{{$item->created_at->formatLocalized('%b')}}</span>
                        <span class="ec-year">{{$item->created_at->format('Y')}}</span>
                    </div>
                    <div class="ec-body">
                        <div class="ec-content">
                            <span class="ec-author">Pedido Reservado {{$item->created_at->diffForHumans()}}</span>
                            <h2 class="ec-title"><a wire:click="verDetalle({{$item->id}})">Ver Detalles del Pedido</a>
                            </h2>
                            <p class="ec-text h-100">
                                Cantidad Reservada: <b>{{$item->cantidad_total}}</b> <br>
                                Total de Pedido: <b>${{$item->total_venta}}</b><br>
                                Ganancia Estimada: <b>${{$item->total_p_empresaria}}</b><br>
                                <button class="btn btn-danger" wire:click="eliminarReserva({{$item->id}})">Eliminar
                                    Reserva</button>
                            </p>
                            <label class="ec-menu-button"><span></span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="{{$detalle ? '' : 'd-none' }}">
        <div class="row d-flex justify-content-between">
            <div class="col my-auto fw-bold">
                DETALLE DEL PEDIDO RESERVADO
            </div>
            <div class="col text-end">
                <button class="btn btn-primary" wire:click="$set('detalle',false)">Regresar</button>
            </div>
        </div>
        @empty(!$detalles_pedido)
        <div class="row mt-4">
            <div class="ec-vendor-card-table">
                <table class="table ec-table" style="font-size: 14px">
                    <thead>
                        <tr>
                            <th scope="col">Foto</th>
                            <th scope="col">Productos</th>
                            <th scope="col">Color</th>
                            <th scope="col">Talla</th>
                            <th scope="col">Precio</th>
                            <th scope="col" width="15px">Cantidad</th>
                            <th scope="col" width="15px">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles_pedido as $item)
                        <tr>
                            <td><img src="/storage/images/productos/{{ $item->imagen_path }}" width="50px" height="50px"
                                    style="object-fit: cover"></td>
                            <td>{{$item->nombre_mostrar }}</td>
                            <td>{{$item->color}}</td>
                            <td>{{$item->talla}}</td>
                            <td>${{$item->precio}}</td>
                            <td>{{$item->cantidad}}</td>
                            <td>${{$item->total}}</td>                        
                        </tr>
                        @endforeach
                    </tbody>                
                </table>
            </div>
        </div>
        <div class="row mt-4 p-4">
            <button class="btn btn-primary" wire:click='recuperarPedido({{$detalles_pedido}})'>RECUPERAR PEDIDO</button>
        </div>
        @endempty
    </div>
    @else
    <div class="container">
        <div class="row">
            <div class="px-4 py-5 my-5 text-center">
                <img class="d-block mx-auto mb-4" src="{{url('assets/images/reservados/shopping.png')}}"
                    alt="logo ibizza verde" width="250rem">
                <h1 class="display-6 fw-bold">Aun no tienes Pedidos Reservados</h1>
                <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4">Dale click a realizar pedido para poder empezar a separar los productos que
                        deseas comprar antes
                        que se acabe el stock del producto.
                    </p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a type="button" href="{{route('web.tomar-pedido')}}"
                            class="btn btn-primary btn-lg px-4 gap-3">Realizar Pedido</a>
                        <a type="button" href="{{route('web')}}"
                            class="btn btn-outline-secondary btn-lg px-4">Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @push('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
    @if ($alert)
    <script>
        Swal.fire({
                    title:'Reserva Liberada!',                
                    icon:'success',    
                    confirmButtonColor: '#009788',            
                })
            })
    </script>
    @endif
</div>