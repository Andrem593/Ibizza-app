<x-plantilla>
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
                                <li class="ec-breadcrumb-item"><a href="{{route('web')}}">Home</a></li>
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
        <!-- Ec Track Order section -->
        <section class="ec-page-content section-space-p">
            <div class="container">
                <!-- Track Order Content Start -->
                <div class="ec-trackorder-content col-md-12">
                    <div class="ec-trackorder-inner">
                        <div class="ec-trackorder-top">
                            <h2 class="ec-order-id">Pedido #{{$venta->id}}</h2>
                            <div class="ec-order-detail">
                                <div>Llegada Prevista 10-12-2021</div>
                                <div>Vendedor de contacto <span> {{$venta->name}}</span></div>
                            </div>
                        </div>
                        <div class="ec-trackorder-bottom">
                            <div class="ec-progress-track">
                                <ul id="ec-progressbar">
                                    <li class="step0 {{$venta->estado == 'PEDIDO' ? 'active' : ''}}"><span class="ec-track-icon"> <img
                                                src="../assets/images/icons/track_1.png" alt="track_order"></span><span
                                            class="ec-progressbar-track"></span><span class="ec-track-title">Orden en 
                                            <br>proceso</span></li>
                                    <li class="step0 {{$venta->estado == 'PEDIDO' ? 'active' : ''}}"><span class="ec-track-icon"> <img
                                                src="../assets/images/icons/track_2.png" alt="track_order"></span><span
                                            class="ec-progressbar-track"></span><span class="ec-track-title">Preparación de
                                                <br>Pedidos</span></li>
                                    <li class="step0"><span class="ec-track-icon"> <img
                                                src="../assets/images/icons/track_3.png" alt="track_order"></span><span
                                            class="ec-progressbar-track"></span><span class="ec-track-title">Orden 
                                                <br>Enviada</span></li>
                                    <li class="step0"><span class="ec-track-icon"> <img
                                                src="../assets/images/icons/track_4.png" alt="track_order"></span><span
                                            class="ec-progressbar-track"></span><span class="ec-track-title">Orden <br>en camino</span></li>
                                    <li class="step0"><span class="ec-track-icon"> <img
                                                src="../assets/images/icons/track_5.png" alt="track_order"></span><span
                                            class="ec-progressbar-track"></span><span class="ec-track-title">Orden 
                                                <br>entregada</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Track Order Content end -->
            </div>
        </section>
        <!-- End Track Order section -->
        @push('js')
            <script>
                $('body').addClass('track_order_page')
            </script>
        @endpush
</x-plantilla>
