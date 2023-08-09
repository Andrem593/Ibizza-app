<x-app-layout>
    @section('title', 'Ventas')
    <x-slot name="header">
        <h5 class="text-center">Ventas</h5>
    </x-slot>

    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-shop-rightside col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                        <div class="ec-vendor-card-body" >
                            <div class="ec-trackorder-content col-md-12">
                                <div class="ec-trackorder-inner shadow" style="background-color: #fff !important">
                                    <div class="ec-trackorder-top">
                                        <h2 class="ec-order-id">Pedido #{{$venta->id}}</h2>
                                        <div class="ec-order-detail">
                                            <div>Llegada Prevista 10-12-2021</div>
                                            <div>Vendedor de contacto <span> {{$venta->name}}</span></div>
                                        </div>
                                    </div>
                                    <div class="ec-trackorder-bottom">
                                        <div class="ec-progress-track mx-auto w-100">
                                            <ul id="ec-progressbar">
                                                <li
                                                    class="step0 {{$venta->estado == 'PEDIDO' || $venta->estado == 'VERIFICACION'|| $venta->estado == 'FACTURADO'|| $venta->estado == 'DESPACHADO' ? 'active' : ''}}">
                                                    <span class="ec-track-icon"> <img
                                                            src="../assets/images/icons/tomar-pedido.png"
                                                            alt="track_order" height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Pedido en
                                                        <br>proceso</span></li>
                                                <li
                                                    class="step0 {{$venta->estado == 'VERIFICACION' || $venta->estado == 'FACTURADO' || $venta->estado == 'DESPACHADO'  ? 'active' : ''}}">
                                                    <span class="ec-track-icon"> <img
                                                            src="../assets/images/icons/verificar_pago.png"
                                                            alt="track_order" height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Verificación <br>de Pedido</span></li>
                                                <li
                                                    class="step0 {{$venta->estado == 'FACTURADO' || $venta->estado == 'DESPACHADO'  ? 'active' : ''}}">
                                                    <span class="ec-track-icon"> <img
                                                            src="../assets/images/icons/facturado.png"
                                                            alt="track_order" height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Pedido
                                                        <br>Facturada</span></li>
                                                <li class="step0 {{$venta->estado == 'DESPACHADO' ? 'active' : ''}}">
                                                    <span class="ec-track-icon"> <img
                                                            src="{{$venta->estado == 'DESPACHADO' ? '../assets/images/icons/despachado.gif' : '../assets/images/icons/despachado.png'}}"
                                                            alt="track_order" height="80px"></span><span
                                                        class="ec-progressbar-track"></span><span
                                                        class="ec-track-title">Pedido <br>Despachada</span></li>                                                
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
</x-app-layout>