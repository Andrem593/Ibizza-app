<x-plantilla>
    @section('title', 'Detalle de Compra')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Detalle Compra</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="ec-breadcrumb-item active">Detalle Compra</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- User invoice section -->
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
                    <div class="ec-vendor-dashboard-card">
                        <div class="ec-vendor-card-header">
                            <h5>Detalle Compra</h5>
                            <div class="ec-header-btn">
                                <a class="btn btn-lg btn-secondary" href="#">Imprimir</a>
                                <a class="btn btn-lg btn-primary" href="#">Descargar</a>
                            </div>
                        </div>
                        <div class="ec-vendor-card-body padding-b-0">
                            <div class="page-content">
                                <div class="page-header text-blue-d2">
                                    <img src="../assets/images/logo/logo_ibizza.svg" alt="Logo Ibizza">
                                </div>

                                <div class="container px-0">
                                    <div class="row mt-4">
                                        <div class="col-lg-12">
                                            <hr class="row brc-default-l1 mx-n1 mb-4" />

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="my-2">
                                                        <span class="text-sm text-grey-m2 align-middle">Nombre : </span>
                                                        <span
                                                            class="text-600 text-110 text-blue align-middle">{{ $venta->factura_nombres }}</span>
                                                    </div>
                                                    <div class="text-grey-m2">
                                                        <div class="my-2">
                                                            {{ $venta->direccion_envio }}
                                                        </div>
                                                        <div class="my-2">
                                                            {{ $empresaria->nombre_provincia . ', ' . $empresaria->nombre_ciudad }}
                                                        </div>
                                                        <div class="my-2"><b class="text-600">Teléfono :
                                                            </b>{{ $empresaria->telefono }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.col -->

                                                <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                                    <hr class="d-sm-none" />
                                                    <div class="text-grey-m2">

                                                        <div class="my-2"><span class="text-600 text-90">ID : </span>
                                                            {{ $venta->id }}</div>

                                                        <div class="my-2"><span class="text-600 text-90">Vendedor :
                                                            </span>{{ $empresaria->nombre_vendedor }}</div>
                                                        <div class="my-2"><span class="text-600 text-90">Fecha :
                                                            </span>{{ date_format($venta->created_at, 'D,m-y') }}
                                                        </div>

                                                        <div class="my-2"><span class="text-600 text-90">Número de
                                                                Factura :
                                                            </span>6548</div>
                                                    </div>
                                                </div>
                                                <!-- /.col -->
                                            </div>

                                            <div class="mt-4">

                                                <div class="text-95 text-secondary-d3">
                                                    <div class="ec-vendor-card-table">
                                                        <table class="table ec-table">
                                                            <thead>
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
                                                                        <td>${{ $pedido->cantidad *  $pedido->precio}}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>Sub Total</strong></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span>${{number_format(($venta->total_venta / 1.12),2)}}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none" colspan="4">
                                                                        <span></span>
                                                                    </td>
                                                                    <td class="border-color" colspan="1">
                                                                        <span><strong>IVA (12%)</strong></span>
                                                                    </td>
                                                                    <td class="border-color">
                                                                        <span>${{number_format(($venta->total_venta * 0.12),2)}}</span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="border-none m-m15" colspan="4"><span
                                                                            class="note-text-color">Informacion extra sobre ibizza
                                                                            o datos de pago...</span></td>
                                                                    <td class="border-color m-m15" colspan="1">
                                                                        <span><strong>Total</strong></span>
                                                                    </td>
                                                                    <td class="border-color m-m15">
                                                                        <span>${{$venta->total_venta}}</span>
                                                                    </td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
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
            </div>
        </div>
    </section>
    <!-- End User invoice section -->
    @push('js')
        <script>
            $('body').addClass('shop_page')

        </script>
    @endpush
</x-plantilla>
