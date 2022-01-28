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
                                    <h5 class="card-title mb-2 fs-2 fw-bold text-secondary">Detalles bancarios</h5>
                                    <div class="row my-4 mx-0">
                                        <div class="list-group">
                                            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                                <img src="data:image/png;base64,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"
                                                    alt="icono-banco-ibizza" width="32" height="32"
                                                    class="rounded-circle flex-shrink-0">
                                                <div class="d-flex gap-2 w-100 justify-content-between">
                                                    <div>
                                                        <h6 class="mb-0">Banco Pichincha</h6>
                                                        <p class="mb-0 opacity-75">Tipo de cuenta: Corriente</p>
                                                        <p class="mb-0 opacity-75">Número de cuenta: 002345435676</p>
                                                        <p class="mb-0 opacity-75">Nombre Propietario: Zapec S.A</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                                <img src="data:image/png;base64,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"
                                                    alt="icono-banco-ibizza" width="32" height="32"
                                                    class="rounded-circle flex-shrink-0">
                                                <div class="d-flex gap-2 w-100 justify-content-between">
                                                    <div>
                                                        <h6 class="mb-0">Banco Pichincha</h6>
                                                        <p class="mb-0 opacity-75">Tipo de cuenta: Corriente</p>
                                                        <p class="mb-0 opacity-75">Número de cuenta: 002345435676</p>
                                                        <p class="mb-0 opacity-75">Nombre Propietario: Zapec S.A</p>
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
                                                                <td>${{ $pedido->total }}</td>
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
                                                    <div>
                                                        <span class="text-left">Sub-Total</span>
                                                        <span
                                                            class="text-right">${{ number_format($venta->total_venta / 1.12, 2) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-left">IVA (12%)</span>
                                                        <span
                                                            class="text-right">${{ number_format($venta->total_venta * 0.12, 2) }}</span>
                                                    </div>
                                                    <div class="ec-cart-summary-total">
                                                        <span class="text-left">Ganancia Estimada</span>
                                                        <span
                                                            class="text-right">${{ number_format($venta->total_venta * 0.3, 2) }}</span>
                                                    </div>
                                                    <div class="ec-cart-summary-total">
                                                        <span class="text-left">Total Pagar</span>
                                                        <span class="text-right">${{ number_format($venta->total_venta, 2) }}</span>
                                                    </div>
                                                </div>
                
                                            </div>
                                            <div class="mx-auto text-center">
                                                <a href="{{route('web.tracking-pedido',$id_venta)}}" class="btn btn-ibizza w-100 mx-auto my-2">VER SEGUIMIENTO</a>
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
