<x-plantilla>
    @section('title', 'Seguimiento de Pedido')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Seguimiento de Pedido</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Inicio</a></li>
                                <li class="ec-breadcrumb-item active">Tracking</li>
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
                            <div class="ec-trackorder-content col-md-12">
                                <div class="ec-trackorder-inner shadow" style="background-color: #fff !important">
                                    <div class="ec-trackorder-top">
                                        <h2 class="ec-order-id">Pedido #{{ $venta->id }}</h2>
                                        <div class="ec-order-detail">
                                            <div>Llegada Prevista 10-12-2021</div>
                                            <div>Vendedor de contacto <span> {{ $venta->name }}</span></div>
                                        </div>
                                    </div>
                                    <div class="ec-trackorder-bottom">
                                        <div class="ec-progress-track mx-auto w-100">
                                            <ul id="ec-progressbar">
                                                <li
                                                    class="step0 {{ $venta->estado == 'PENDIENTE DE PAGO' || $venta->estado == 'PEDIDO POR VALIDAR' || $venta->estado == 'PEDIDO APROBADO' || $venta->estado == 'PEDIDO FACTURADO' || $venta->estado == 'PEDIDO DESPACHADO' ? 'active' : '' }}">
                                                    <span class="ec-track-icon"> <img
                                                            src="../assets/images/icons/pendiente.png"
                                                            alt="track_order" height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Verificación <br>de Pedido</span>
                                                </li>
                                                <li
                                                    class="step0 {{ $venta->estado == 'PEDIDO POR VALIDAR' || $venta->estado == 'PEDIDO APROBADO' || $venta->estado == 'PEDIDO FACTURADO' || $venta->estado == 'PEDIDO DESPACHADO' ? 'active' : '' }}">
                                                    <span class="ec-track-icon"> <img
                                                            src="../assets/images/icons/verificar_pago.png"
                                                            alt="track_order" height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Verificación <br>de Pedido</span>
                                                </li>
                                                <li
                                                    class="step0 {{ $venta->estado == 'PEDIDO APROBADO' || $venta->estado == 'PEDIDO FACTURADO' || $venta->estado == 'PEDIDO DESPACHADO' ? 'active' : '' }}">
                                                    <span class="ec-track-icon"> <img
                                                            src="../assets/images/icons/tomar-pedido.png"
                                                            alt="track_order" height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Pedido en
                                                        <br>proceso</span>
                                                </li>
                                                <li
                                                    class="step0 {{ $venta->estado == 'PEDIDO FACTURADO' || $venta->estado == 'PEDIDO DESPACHADO' ? 'active' : '' }}">
                                                    <span class="ec-track-icon"> <img
                                                            src="../assets/images/icons/facturado.png" alt="track_order"
                                                            height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Pedido
                                                        <br>Facturada</span>
                                                </li>
                                                <li class="step0 {{ $venta->estado == 'PEDIDO DESPACHADO' ? 'active' : '' }}">
                                                    <span class="ec-track-icon"> <img
                                                            src="{{ $venta->estado == 'PEDIDO DESPACHADO' ? '../assets/images/icons/despachado.gif' : '../assets/images/icons/despachado.png' }}"
                                                            alt="track_order" height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Pedido <br>Despachada</span>
                                                </li>
                                            </ul>
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
    <!-- End Track Order section -->
    @push('js')
        <script>
            $('body').addClass('track_order_page')
        </script>
    @endpush
</x-plantilla>
