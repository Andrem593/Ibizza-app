<x-plantilla>
    @section('title', 'Detalle del Pedido')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Detalle del Pedido</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Detalle</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->
    
    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <x-lista-rutas-usuarios />
                    </div>
                </div>
                <div class="ec-shop-rightside col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                        <div class="ec-vendor-card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="ec-vendor-block-profile">
                                        <div class="section-title mx-auto text-center">
                                            <h2 class="ec-bg-title">GRACIAS !!</h2>
                                            <h2 class="ec-title">GRACIAS !!</h2>
                                            <p class="sub-title mb-3">Tu pedido ha sido recibido</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mx-auto shadow" style="width: 80%">
                                <div class="card-header">
                                    información sobre tu pedido
                                </div>
                                <div class="card-body m-2">
                                    <h5 class="card-title mb-2 fs-2 fw-bold text-secondary">Formas de Pago</h5>                                    
                                    <span class="fw-bold">(Cta.Corriente)</span>
                                    <h6 class="text-secondary">A nombre de <span class="fw-bold">Zapec S.A</span></h6>
                                    <h6 class="text-secondary">RUC: <span class="fw-bold">0992703342001</span></h6>
                                    <div class="row my-4 mx-0">
                                        <div class="list-group">
                                            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/c/cc/Banco-Pichincha.png"
                                                    alt="icono-banco-ibizza" width="32" height="32"
                                                    class="rounded-circle flex-shrink-0">
                                                <div class="d-flex gap-2 w-100 justify-content-between">
                                                    <div>
                                                        <h6 class="mb-0">Banco Pichincha</h6>
                                                        <p class="mb-0 opacity-75">Número de cuenta: <span class="fw-bold">2100118345</span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                                <img src="data:image/png;base64,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"
                                                    alt="icono-banco-ibizza" width="32" height="32"
                                                    class="rounded-circle flex-shrink-0">
                                                <div class="d-flex gap-2 w-100 justify-content-between">
                                                    <div>
                                                        <h6 class="mb-0">Banco Guayaquil</h6>
                                                        <p class="mb-0 opacity-75">Número de cuenta: <span class="fw-bold">17319540<span></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                                <img src="data:image/png;base64,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"
                                                    alt="icono-banco-ibizza" width="32" height="32"
                                                    class="rounded-circle flex-shrink-0">
                                                <div class="d-flex gap-2 w-100 justify-content-between">
                                                    <div>
                                                        <h6 class="mb-0">Banco Pacifico</h6>
                                                        <p class="mb-0 opacity-75">Número de cuenta: <span class="fw-bold">7341288<span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-2">
                                        <h5 class="card-title mb-2 fs-2 fw-bold text-secondary">Detalles de Pedido</h5>
                                        <div class="ec-sb-block-content">
                                            <div class="table-responsive">
                                                <table class="table table-hover">
                                                    <thead class="bg-ibizza">
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Productos</th>
                                                            <th scope="col">Color</th>
                                                            <th scope="col">Talla</th>
                                                            <th scope="col" width="15px">Cantidad</th>
                                                            <th scope="col" width="15px">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($pedidos as $pedido)
                                                            <tr>
                                                                <th scope="row">{{ $i++ }}</th>
                                                                <td>{{ $pedido->nombre_producto }}</td>
                                                                <td>{{ $pedido->color_producto }}</td>
                                                                <td>{{ $pedido->talla_producto }}</td>
                                                                <td>{{ $pedido->cantidad }}</td>
                                                                <td>${{ $pedido->precio }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="ec-cart-summary-bottom">
                                                <div class="ec-cart-summary">
                                                    <div>
                                                        <span class="text-left">Total de Productos</span>
                                                        <span class="text-right">{{ $venta->cantidad_total }}</span>
                                                    </div>
                                                    <div class="ec-cart-summary-total">
                                                        <span class="text-left">Envio</span>
                                                        <span class="text-right">${{ $venta->envio }}</span>
                                                    </div>
                                                    <div class="ec-cart-summary-total">
                                                        <span class="text-left">Total Pagar</span>
                                                        <span class="text-right">${{ number_format($venta->total_venta, 2) }}</span>
                                                    </div>
                                                </div>
                
                                            </div>
                                            <div class="mx-auto text-center">
                                                @if ( Auth::user()->role != 'Empresaria' || Auth::user()->role != 'EMPRESARIA')
                                                    <a href="{{route('ventas.index')}}" class="btn btn-ibizza w-100 mx-auto my-2">VER SEGUIMIENTO</a>
                                                @else                                                    
                                                    <a href="{{route('web.tracking-pedido',$id_venta)}}" class="btn btn-ibizza w-100 mx-auto my-2">VER SEGUIMIENTO</a>
                                                @endif
                                            </div>
                                        </div>
                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-plantilla>
