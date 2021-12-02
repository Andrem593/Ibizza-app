<x-plantilla>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Historial de Usuario</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{route('web')}}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Historial</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- User history section -->
    <section class="ec-page-content ec-vendor-uploads ec-user-account section-space-p">
        <div class="container">
            <div class="row">
                <!-- Sidebar Area Start -->
                <div class="ec-shop-leftside ec-vendor-sidebar col-lg-3 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Category Block -->
                        <x-lista-rutas-usuarios/>
                    </div>
                </div>
                <div class="ec-shop-rightside col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card">
                        <div class="ec-vendor-card-header">
                            <h5>Historial de Compras</h5>
                            <div class="ec-header-btn">
                                <a class="btn btn-lg btn-primary" href="{{route('web.tienda')}}">Visitar Tienda</a>
                            </div>
                        </div>
                        <div class="ec-vendor-card-body">
                            <div class="ec-vendor-card-table">
                                <table class="table ec-table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Identificación</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Ganancia</th>
                                            <th scope="col">Estado</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ventas as $venta)                                            
                                        <tr>
                                            <th scope="row"><span>{{$venta->id}}</span></th>
                                            <td><span>{{$venta->factura_identificacion}}</span></td>
                                            <td><span>{{$venta->cantidad_total}}</span></td>
                                            <td><span>$ {{$venta->total_venta}}</span></td>
                                            <td><span>$ {{$venta->total_p_empresaria}}</span></td>
                                            <td><span>{{$venta->estado}}</span></td>
                                            <td><span>{{ date_format($venta->created_at,"d/m/Y")}}</span></td>
                                            <td><span class="tbl-btn"><a class="btn btn-lg btn-primary"
                                                        href="{{route('web.detalle-compra-empresaria',$venta->id)}}">Ver</a></span></td>
                                        </tr>                                        
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End User history section -->
    @push('js')
    <script>
        $('body').addClass('shop_page')
    </script>
    @endpush
</x-plantilla>
