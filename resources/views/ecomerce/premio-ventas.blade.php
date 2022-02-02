<x-plantilla>
    @section('title', 'Plan de Premios')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Plan de Premios</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Inicio</a></li>
                                <li class="ec-breadcrumb-item active">Plan de Premios</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec About Us page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Plan de Premios</h2>
                        <h2 class="ec-title">Plan de Premios</h2>
                        <p class="sub-title mb-3">Gana Premios y aumenta tus ganancias</p>
                    </div>
                </div>
                <div class="ec-common-wrapper">
                    <div class="row margin-minus-t-15 justify-content-center">
                        @if (count($premios) > 0)
                            @foreach ($premios as $key => $item)
                                @php
                                    $fecha = Carbon\Carbon::parse($item->fecha_fin_catalogo . ' 23:59:59');
                                @endphp
                                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                    <div class="ec-card-grid-space">
                                        <a class="ec-card prueba" title="Ver premios" id="{{$item->id}}"
                                        data-bs-toggle="modal" data-bs-target="#modal_premio"
                                            style="background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url(../storage/images/catalogo/{{ $item->foto_path }}); background-position: center;">
                                            <div class="ec-num">{{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}
                                            </div>
                                            <h1>{{ $item->descripcion }}</h1>
                                            <p><strong>Catalogo:</strong> {{ $item->nombre }}</p>
                                            <div class="ec-date">Finaliza en
                                                {{ $fecha->diffForHumans(null, true) }}</div>
                                            <div class="ec-tags">
                                                <div class="ec-tag">Ver premios</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8">Sin datos que mostrar</td>
                            </tr>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--  services Section Start -->
    <section class="section ec-services-section section-space-p">
        <h2 class="d-none">Services</h2>
        <div class="container">
            <div class="row">
                <div class="ec_ser_content ec_ser_content_1 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <img loading='lazy' src="assets/images/icons/service_1.svg" class="svg_img" alt="" />
                        </div>
                        <div class="ec-service-desc">
                            <h2>Envio Gratuito</h2>
                            <p>Envio Gratuito en todas las Ordenes superiores a $100</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_2 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <img loading='lazy' src="assets/images/icons/service_2.svg" class="svg_img" alt="" />
                        </div>
                        <div class="ec-service-desc">
                            <h2>Soporte 24X7</h2>
                            <p>Contáctanos 24 Horas del dia, 7 Días de la semana</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_3 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <img loading='lazy' src="assets/images/icons/service_3.svg" class="svg_img" alt="" />
                        </div>
                        <div class="ec-service-desc">
                            <h2>Devoluciones de 30 Días</h2>
                            <p>Simplemente devuelvelo dentro de los 30 dias para un cambio</p>
                        </div>
                    </div>
                </div>
                <div class="ec_ser_content ec_ser_content_4 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                    <div class="ec_ser_inner">
                        <div class="ec-service-image">
                            <img loading='lazy' src="assets/images/icons/service_4.svg" class="svg_img" alt="" />
                        </div>
                        <div class="ec-service-desc">
                            <h2>Pagos seguros</h2>
                            <p>Contáctanos 24 Horas del dia, 7 Días de la semana</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--services Section End -->

    <!-- Ec Instagram Start -->
    <section class="section ec-instagram-section module section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Instagram Feed</h2>
                        <h2 class="ec-title">Instagram Feed</h2>
                        <p class="sub-title">Comparte tus compras con nosotros</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="ec-insta-wrapper">
            <div class="ec-insta-outer">
                <div class="container" data-animation="fadeIn">
                    <div class="insta-auto">
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img loading='lazy'
                                        src="assets/images/instragram-image/1.png" alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img loading='lazy'
                                        src="assets/images/instragram-image/2.png" alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img loading='lazy'
                                        src="assets/images/instragram-image/3.png" alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img loading='lazy'
                                        src="assets/images/instragram-image/4.png" alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img loading='lazy'
                                        src="assets/images/instragram-image/5.png" alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img loading='lazy'
                                        src="assets/images/instragram-image/6.png" alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                        <!-- instagram item -->
                        <div class="ec-insta-item">
                            <div class="ec-insta-inner">
                                <a href="#" target="_blank"><img loading='lazy'
                                        src="assets/images/instragram-image/7.png" alt="insta"></a>
                            </div>
                        </div>
                        <!-- instagram item -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Ec Instagram End -->

    <livewire:modal-premio />
    @push('js')
    <script>
        $('.prueba').on('click', function(){
            let id = $(this).attr("id");
            console.log(id);
            Livewire.emit('viewPremio',id);
        });
    </script>
    @endpush
</x-plantilla>
