<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

    <title>IBIZZA - Sitio Oficial</title>
    <meta name="keywords" content="ecomerce,zapatos,ibizza,zapatos mujer,zapatos hombre,dpisar" />
    <meta name="description"
        content="Se parte de nuestras empresarias y genera ingresos extras vendiendo el fabuloso catalogo de Ibizza">
    <meta name="author" content="AM DESINGS">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- site Favicon -->
    <link rel="icon" href="assets/images/favicon/Logo_ibizza_verde.svg" sizes="32x32" />
    <link rel="apple-touch-icon" href="assets/images/favicon/Logo_ibizza.png" />
    <meta name="msapplication-TileImage" content="assets/images/favicon/Logo_ibizza.png" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="assets/css/vendor/ecicons.min.css" />

    <!-- css All Plugins Files -->
    <link rel="stylesheet" href="assets/css/plugins/animate.css" />
    <link rel="stylesheet" href="assets/css/plugins/swiper-bundle.min.css" />
    <link rel="stylesheet" href="assets/css/plugins/jquery-ui.min.css" />
    <link rel="stylesheet" href="assets/css/plugins/countdownTimer.css" />
    <link rel="stylesheet" href="assets/css/plugins/slick.min.css" />
    <link rel="stylesheet" href="assets/css/plugins/bootstrap.css" />

    <!-- Main Style -->
    <link rel="stylesheet" href="assets/css/demo1.css" />
    <link rel="stylesheet" href="assets/css/skin-04.css">
    <link rel="stylesheet" href="assets/css/responsive.css" />

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="assets/css/backgrounds/bg-4.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css" />

    @livewireStyles
</head>

<body>
    <div id="ec-overlay"><span class="loader_img"></span></div>

    <!-- Header  -->
    <header class="ec-header">
        <!--Ec Header Top -->
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Header Top social -->
                    <div class="col text-left header-top-left d-none d-lg-block">
    
                    </div>
                    <!-- Header Top social End -->
                    <!-- Header Top Message -->
                    <div class="col text-center header-top-center">
                        <div class="header-top-message text-upper">
                            @if (!empty($catalogos))
                                <span class="fw-bold fs-6">
                                    VIGENTE:
                                    @foreach ($catalogos as $catalogo)
                                        {{ $catalogo->nombre }}
                                    @endforeach
                                </span>
                            @endif
                        </div>
                    </div>
                    <!-- Header Top Message End -->
                    <!-- Header Top Language Currency -->
                    <div class="col header-top-right d-none d-lg-block">
                        <div class="header-top-lan-curr d-flex justify-content-end">
                            @auth
                            <a href="{{ route('web.perfil-empresaria') }}" class="text-muted me-2">SOY EMPRESARIA</a>
                            @else
                            <a href="{{ route('login') }}" class="text-muted me-2">SOY EMPRESARIA</a>
                            @endauth
                            <a href="{{ route('web.registro-empresaria') }}" class="text-muted">QUIERO SER
                                EMPRESARIA</a>
                        </div>
                    </div>
                    <!-- Header Top Language Currency -->
                    <!-- Header Top responsive Action -->
                    <div class="col d-lg-none ">
                        <div class="ec-header-bottons">
                            <!-- Header User -->
                            <div class="ec-header-user dropdown">
                                <button class="dropdown-toggle" data-bs-toggle="dropdown"><img loading='lazy'
                                        src="assets/images/icons/user.svg" class="svg_img header_svg" alt="" /></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @if (Route::has('login'))

                                        @auth
                                            @can('dashboard')
                                                <li> <a href="{{ url('/dashboard') }}" class="dropdown-item">Dashboard</a>
                                                </li>
                                            @else
                                                <li> <a href="{{ route('web.perfil-empresaria') }}"
                                                        class="dropdown-item">Perfil</a>
                                                </li>
                                            @endcan
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">cerrar sesión</button>
                                            </form>
                                            <li><a class="dropdown-item" href="{{ route('web.checkout') }}">Liquidar Pedido</a>
                                            </li>
                                        @else
                                            <li><a href="{{ route('login') }}" class="dropdown-item">Login</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('web.registro-empresaria') }}">Registrar</a></li>
                                            <li><a class="dropdown-item" href="{{ route('web.checkout') }}">Liquidar Pedido</a>
                                            </li>
                                        @endif
                                        @endif
                                    </ul>
                                </div>
                                <!-- Header User End -->
                                <!-- Header Cart -->
                                <a href="#" class="ec-header-btn ec-header-wishlist">
                                    <div class="header-icon"><img loading='lazy' src="assets/images/icons/wishlist.svg"
                                            class="svg_img header_svg" alt="" /></div>
                                    <span class="ec-header-count">0</span>
                                </a>
                                <!-- Header Cart End -->
                                <!-- Header Cart -->
                                <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                    <div class="header-icon"><img loading='lazy' src="assets/images/icons/cart.svg"
                                            class="svg_img header_svg" alt="" /></div>
                                    <span class="ec-header-count cart-count-lable">{{ Cart::count() }}</span>
                                </a>
                                <!-- Header Cart End -->
                                <!-- Header menu -->
                                <a href="#ec-mobile-menu" class="ec-header-btn ec-side-toggle d-lg-none">
                                    <img loading='lazy' src="assets/images/icons/menu.svg" class="svg_img header_svg"
                                        alt="icon" />
                                </a>
                                <!-- Header menu End -->
                            </div>
                        </div>
                        <!-- Header Top responsive Action -->
                    </div>
                </div>
            </div>
            <!-- Ec Header Top  End -->
            <!-- Ec Header Bottom  -->
            <div class="ec-header-bottom d-none d-lg-block">
                <div class="container position-relative">
                    <div class="row">
                        <div class="ec-flex">
                            <!-- Ec Header Logo -->
                            <div class="align-self-center">
                                <div class="header-logo">

                                    <a href="{{ url('/') }}"><img loading='lazy' class="p-1"
                                            src="{{ url('assets/images/logo/logo_ibizza.svg') }}" alt="Logo Ibizza" />
                                        <img loading='lazy' class="dark-logo" src="assets/images/logo/dark-logo.png"
                                            alt="Site Logo" style="display: none;" /></a>

                                </div>
                            </div>
                            <!-- Ec Header Logo End -->

                            <!-- Ec Header Search -->
                            {{-- <div class="align-self-center">
                            <div class="header-search">
                                <form class="ec-btn-group-form" action="#">
                                    <input id="txt_search" class="form-control"
                                        placeholder="Ingresa el nombre de un Producto..." type="text">
                                    <button class="submit" type="submit"><img loading='lazy'
                                            src="assets/images/icons/search.svg" class="svg_img header_svg"
                                            alt="" /></button>
                                </form>
                            </div>
                        </div> --}}
                            <!-- EC Main Menu -->
                            <div id="ec-main-menu-desk" class="d-none d-lg-block mx-auto sticky-nav align-self-center">
                                <div class="">
                                    <div class="row mx-auto">
                                        <div class="align-self-center ms-4">
                                            <div class="ec-main-menu">
                                                <ul>
                                                    <li><a href="{{ url('/') }}">Inicio</a></li>
                                                    <li class="dropdown"><a href='javascript:void(0)'>Quiénes somos</a>
                                                        <ul class="sub-menu">                                                            
                                                            <li><a href="{{ route('web.sobre-nosotros') }}">Sobre Nosotros</a></li>
                                                            <li><a href="{{ route('web.contactanos') }}">Contactanos</a></li>
                                                            <li><a href="{{ route('web.politica-privacidad') }}">Politicas de Privacidad</a></li>
                                                        </ul>
                                                    </li>                                                    
                                                    <li><a href="#porQueSerEmpresaria">¿Por qué ser Empresaria?</a></li>                                                    
                                                    <li><a href="#section_catalogo">Catálogo</a></li>
                                                    {{-- <li class="dropdown"><span class="main-label-note-new"
                                                            data-toggle="tooltip" title="NEW"></span><a
                                                            href="{{ route('web.tienda') }}">Tienda</a>
                                                    </li> --}}
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ec Main Menu End -->
                            <!-- Ec Header Search End -->

                            <!-- Ec Header Button -->
                            <div class="align-self-center">
                                <div class="ec-header-bottons">

                                    <!-- Header User -->
                                    <div class="ec-header-user dropdown">
                                        <button class="dropdown-toggle" data-bs-toggle="dropdown"><img loading='lazy'
                                                src="assets/images/icons/user.svg" class="svg_img header_svg"
                                                alt="" /></button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            @if (Route::has('login'))

                                                @auth
                                                    @can('dashboard')
                                                        <li> <a href="{{ url('/dashboard') }}"
                                                                class="dropdown-item">Dashboard</a></li>
                                                    @else
                                                        <li> <a href="{{ route('web.perfil-empresaria') }}"
                                                                class="dropdown-item">Perfil</a></li>
                                                    @endcan
                                                    <form action="{{ route('logout') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">cerrar sesión</button>
                                                    </form>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('web.checkout') }}">Liquidar Pedido</a>
                                                    </li>
                                                @else
                                                    <li><a href="{{ route('login') }}" class="dropdown-item">Login</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('web.registro-empresaria') }}">Registro</a></li>
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('web.checkout') }}">Liquidar Pedido</a>
                                                    </li>
                                                @endif
                                                @endif
                                            </ul>
                                        </div>
                                        <!-- Header User End -->
                                        <!-- Header wishlist -->
                                        <a href="#" class="ec-header-btn ec-header-wishlist">
                                            <div class="header-icon"><img loading='lazy'
                                                    src="assets/images/icons/wishlist.svg" class="svg_img header_svg" alt="" />
                                            </div>
                                            <span class="ec-header-count">0</span>
                                        </a>
                                        <!-- Header wishlist End -->
                                        <!-- Header Cart -->
                                        <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                            <div class="header-icon"><img loading='lazy' src="assets/images/icons/cart.svg"
                                                    class="svg_img header_svg" alt="" /></div>
                                            <span class="ec-header-count cart-count-lable">{{ Cart::count() }}</span>
                                        </a>
                                        <!-- Header Cart End -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ec Header Button End -->
                <!-- Header responsive Bottom  -->
                <div class="ec-header-bottom d-lg-none">
                    <div class="container position-relative">
                        <div class="row ">

                            <!-- Ec Header Logo -->
                            <div class="col">
                                <div class="header-logo">
                                    <a href="index.html"><img loading='lazy'
                                            src="{{ url('assets/images/logo/logo_ibizza.svg') }}" alt="Logo Ibizza" /><img
                                            loading='lazy' class="dark-logo" src="assets/images/logo/dark-logo.png"
                                            alt="Site Logo" style="display: none;" /></a>
                                </div>
                            </div>
                            <!-- Ec Header Logo End -->
                            <!-- Ec Header Search -->
                            {{-- <div class="col">
                        <div class="header-search">
                            <form class="ec-btn-group-form" action="#">
                                <input id="txt_search_mobile" class="form-control"
                                    placeholder="Ingresa el nombre de un Producto..." type="text">
                                <button class="submit" type="submit"><img loading='lazy'
                                        src="assets/images/icons/search.svg" class="svg_img header_svg"
                                        alt="icon" /></button>
                            </form>
                        </div>
                    </div> --}}
                            <!-- Ec Header Search End -->


                        </div>
                    </div>
                </div>
                <!-- Header responsive Bottom  End -->

                <!-- ekka Mobile Menu -->
                <div id="ec-mobile-menu" class="ec-side-cart ec-mobile-menu">
                    <div class="ec-menu-title">
                        <span class="menu_title">Menu Ibizza</span>
                        <button class="ec-close">×</button>
                    </div>
                    <div class="ec-menu-inner">
                        <div class="ec-menu-content">
                            <ul>
                                <li><a href="{{url('/')}}">Inicio</a></li>
                                <li><a href="javascript:void(0)">Quiénes Somos</a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{ route('web.sobre-nosotros') }}">Sobre Nosotros</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('web.contactanos') }}">Contactanos</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('web.politica-privacidad') }}">Politicas de Privacidad</a>
                                        </li>                                        
                                        <li><a class="p-0" href="#">
                                            <img loading='lazy' class="img-responsive" src="assets/images/menu-banner/1.jpg"></a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#porQueSerEmpresaria">¿Por qué ser Empresaria?</a></li>
                                <li><a href="#section_catalogo">Catálogo</a></li>                                
                            </ul>
                        </div>
                        <div class="header-res-lan-curr">
                            <div class="header-top-lan-curr">
                                <!-- Language -->
                                {{-- <div class="header-top-lan dropdown">
                            <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Idioma <i
                                    class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu">
                                <li class="active"><a class="dropdown-item" href="#">Español</a></li>
                            </ul>
                        </div> --}}
                                <!-- Language End -->
                                <!-- Currency -->
                                {{-- <div class="header-top-curr dropdown">
                            <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Moneda <i
                                    class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                            <ul class="dropdown-menu">
                                <li class="active"><a class="dropdown-item" href="#">USD $</a></li>
                            </ul>
                        </div> --}}
                                <!-- Currency End -->
                            </div>
                            <!-- Social -->
                            <div class="header-res-social">
                                <div class="header-top-social">
                                    <ul class="mb-0">
                                        <li class="list-inline-item"><a class="hdr-facebook" target="_blank" href="https://www.facebook.com/catalogo.ibizza/"><i
                                                    class="ecicon eci-facebook"></i></a></li>
                                        {{-- <li class="list-inline-item"><a class="hdr-twitter" href="#"><i
                                            class="ecicon eci-twitter"></i></a></li> --}}
                                        <li class="list-inline-item"><a class="hdr-instagram" target="_blank" href="https://www.instagram.com/catalogo.ibizza/"><i
                                                    class="ecicon eci-instagram"></i></a></li>
                                        {{-- <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i
                                            class="ecicon eci-linkedin"></i></a></li> --}}
                                    </ul>
                                </div>
                            </div>
                            <!-- Social End -->
                        </div>
                    </div>
                </div>
                <!-- ekka mobile Menu End -->
            </header>
            <!-- Header End  -->

            <!-- ibizza Cart -->
            <div class="ec-side-cart-overlay"></div>
            @livewire('ibizza-side-cart')
            <!-- ibizza Cart End -->

            <!-- Main Slider -->
            <div class="mx-auto">
                <div class="sticky-header-next-sec ec-main-slider section section-space-pb">
                    <div class="ec-slider swiper-container main-slider-nav main-slider-dot">
                        <!-- Main slider -->
                        <div class="swiper-wrapper">
                            <div class="ec-slide-item swiper-slide d-flex ec-slide-1">
                                <div class="container align-self-center">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                                            <div class="ec-slide-content slider-animation">
                                                <h1 class="ec-slide-title">Se una de nuestras Empresarias</h1>
                                                <h2 class="ec-slide-stitle">En Ibizza</h2>
                                                <p>Obten ingresos seguros vendiendo por catálogo y forma parte de nosotras</p>
                                                <a href="{{ route('web.tienda') }}" class="btn btn-lg btn-secondary">Ordenar
                                                    Ahora</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ec-slide-item swiper-slide d-flex ec-slide-2">
                                <div class="container align-self-center">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                                            <div class="ec-slide-content slider-animation">
                                                <h1 class="ec-slide-title">Conoce nuestro catálogo</h1>
                                                <h2 class="ec-slide-stitle">100% online</h2>
                                                <p>Puedes hacer tus pedidos en el momento que quieras y llegaran a la comodidad
                                                    de
                                                    tu hogar</p>
                                                <a href="{{ route('web.tienda') }}" class="btn btn-lg btn-secondary">Ordenar
                                                    Ahora</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination swiper-pagination-white"></div>
                        <div class="swiper-buttons">
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Main Slider End -->

            <!-- Product tab Area -->
            {{-- <section class="section ec-product-tab section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Nuestra Colección</h2>
                        <h2 class="ec-title">Nuestra Colección</h2>
                        <p class="sub-title">Explora nuestro catalogo con los mejores productos</p>
                    </div>
                </div>

                <!-- Tab -->
                <div class="col-md-12 text-center">
                    <ul class="ec-pro-tab-nav nav justify-content-center">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                href="#tab-pro-for-all">Todos</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-pro-for-men">Para
                                Hombres</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-pro-for-women">Para
                                Mujeres</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-pro-for-child">Para
                                Niños</a></li>
                    </ul>
                </div>
                <!-- Tab End -->
            </div>
            <div class="row">
                <div class="col">
                    <div class="tab-content">
                        <!-- 1st Product tab -->
                        <div class="tab-pane fade show active" id="tab-pro-for-all">
                            <div class="row">
                                <!-- Product Content -->
                                @foreach ($productos as $producto)

                                @livewire('card-productos' , ['id_producto'=>$producto->id,'imagen' =>
                                $producto->imagen_path,'clasificacion' => $producto->clasificacion ,'valor_venta'
                                => $producto->valor_venta,'color' => $producto->color, 'estilo' =>
                                $producto->estilo,'nombre_producto'=>$producto->nombre_mostrar,'precio_empresaria'=>$producto->precio_empresaria,'descuento'=>$producto->descuento])
                                @endforeach
                                <div class="col-sm-12 shop-all-btn"><a href="{{ route('web.tienda') }}">Ver todos
                                        los Productos<a></div>
                            </div>
                        </div>
                        <!-- ec 1st Product tab end -->
                        <!-- ec 2nd Product tab -->
                        <div class="tab-pane fade" id="tab-pro-for-men">
                            <div class="row">
                                <!-- Product Content -->
                                @empty(!$productos_hombres)
                                @foreach ($productos_hombres as $producto)

                                @livewire('card-productos' , ['id_producto'=>$producto->id,'imagen' =>
                                $producto->imagen_path,'clasificacion' => $producto->clasificacion ,'valor_venta'
                                => $producto->valor_venta,'color' => $producto->color, 'estilo' =>
                                $producto->estilo,'nombre_producto'=>$producto->nombre_mostrar,'precio_empresaria'=>$producto->precio_empresaria,'descuento'=>$producto->descuento])
                                @endforeach
                                @endempty
                                <div class="col-sm-12 shop-all-btn"><a href="{{ route('web.tienda') }}">ver todos
                                        los
                                        productos</a></div>
                            </div>
                        </div>
                        <!-- ec 2nd Product tab end -->
                        <!-- ec 3rd Product tab -->
                        <div class="tab-pane fade" id="tab-pro-for-women">
                            <div class="row">
                                <!-- Product Content -->
                                @empty(!$productos_mujer)
                                @foreach ($productos_mujer as $producto)

                                @livewire('card-productos' , ['id_producto'=>$producto->id,'imagen' =>
                                $producto->imagen_path,'clasificacion' => $producto->clasificacion ,'valor_venta'
                                => $producto->valor_venta,'color' => $producto->color, 'estilo' =>
                                $producto->estilo,'nombre_producto'=>$producto->nombre_mostrar,'precio_empresaria'=>$producto->precio_empresaria,'descuento'=>$producto->descuento])
                                @endforeach
                                @endempty
                                <div class="col-sm-12 shop-all-btn"><a href="{{ route('web.tienda') }}">ver todos
                                        los
                                        productos</a></div>
                            </div>
                        </div>
                        <!-- ec 3rd Product tab end -->
                        <!-- ec 4th Product tab -->
                        <div class="tab-pane fade" id="tab-pro-for-child">
                            <div class="row">
                                <!-- Product Content -->
                                @empty(!$productos_niños)
                                @foreach ($productos_niños as $producto)

                                @livewire('card-productos' , ['id_producto'=>$producto->id,'imagen' =>
                                $producto->imagen_path,'clasificacion' => $producto->clasificacion ,'valor_venta'
                                => $producto->valor_venta,'color' => $producto->color, 'estilo' =>
                                $producto->estilo,'nombre_producto'=>$producto->nombre_mostrar,'precio_empresaria'=>$producto->precio_empresaria,'descuento'=>$producto->descuento])
                                @endforeach

                                @endempty

                                <div class="col-sm-12 shop-all-btn"><a href="{{ route('web.tienda') }}">ver todos
                                        los
                                        productos</a></div>
                            </div>
                        </div>
                        <!-- ec 4th Product tab end -->
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
            <!-- ec Product tab Area End -->
            <section id="porQueSerEmpresaria" class="ec-banner section section-space-p">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-title p-4 ">¿Por qué ser una empresaria en Ibizza?</h2>
                        <p class="col-md-6 col-sm-12 mx-auto fs-5 my-2 p-2">Podras obtener ganancias seguras con nuestra venta
                            por catálogo y
                            disfrutaras trabajando para nosotros desde la comodidad de tu hogar.</p>
                    </div>
                </div>
                <div class="container">
                    <div class="row mt-3 mx-auto">
                        <div class="col my-3 d-flex justify-content-around">
                            <div class="card shadow rounded mx-auto" style="width: 15rem;">
                                <img src="{{ url('assets/images/card-empresaria/1.jpg') }}" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">Facil de Registrarse</h5>
                                    <p class="card-text">Afiliación sin costo y en pocos minutos.</p>
                                    <a href="{{ route('web.registro-empresaria') }}" class="btn nav-link">Registrarme
                                        aquí</a>
                                </div>
                            </div>
                        </div>
                        <div class="col my-3">
                            <div class="card shadow rounded mx-auto" style="width: 15rem;">
                                <img src="{{ url('assets/images/card-empresaria/2.jpg') }}" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">Genera Ingresos</h5>
                                    <p class="card-text">Ganancias de hasta el 30% de tus ventas.</p>
                                    <a href="#" class="btn nav-link">Lista de Precios</a>
                                </div>
                            </div>
                        </div>
                        <div class="col my-3">
                            <div class="card shadow rounded mx-auto" style="width: 15rem;">
                                <img src="{{ url('assets/images/card-empresaria/1.jpg') }}" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">Premios en ventas</h5>
                                    <p class="card-text">Gana premios y aumentan tus ganancias.</p>
                                    <a href="#" class="btn nav-link">Plan de Premios</a>
                                </div>
                            </div>
                        </div>
                        <div class="col my-3">
                            <div class="card shadow rounded mx-auto" style="width: 15rem;">
                                <img src="{{ url('assets/images/card-empresaria/2.jpg') }}" class="card-img-top">
                                <div class="card-body text-center">
                                    <h5 class="card-title fw-bold">Facil de Vender</h5>
                                    <p class="card-text">Puedes obtener tu catálogo fisico o digital para vender.</p>
                                    <a href="#" class="btn nav-link">Ver Catálogo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- ec Banner Section || SECCION DE CATALOGO AM -->
            <section id="section_catalogo" class="ec-banner section section-space-p">
                <h2 class="d-none">Banner</h2>
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Conoce Nuestros Catálogos</h2>
                        <h2 class="ec-title">Conoce Nuestros Catálogos</h2>
                        <p class="sub-title">Explora nuestro catálogo con los mejores productos</p>
                    </div>

                </div>
                <div class="container">
                    <!-- ec Banners -->
                    <div class="">
                        <!--ec Banner -->
                        <div class="d-flex justify-content-center">
                            <div class="row">
                                @if ($catalogos->count() > 0)
                                    @foreach ($catalogos as $key => $catalogo)
                                        <div class="banner-block col-sm-12 col-md-6 margin-b-30"
                                            data-animation="{{ ($key + 1) % 2 == 0 ? 'slideInLeft' : 'slideInRight' }}">
                                            <div class="bnr-overlay">
                                                <img loading='lazy' src="storage/images/catalogo/{{ $catalogo->foto_path }}"
                                                    alt="" style="width: 40rem" />
                                                <div class="banner-text">
                                                    <span
                                                        class="nombre-catalogo ec-banner-stitle">{{ $catalogo->nombre }}</span>
                                                    <span class="ec-banner-title"
                                                        style="width: 60%">{{ $catalogo->descripcion }}</span>
                                                    <input type="hidden" class='pdf_path' value="{{ $catalogo->pdf_path }}">
                                                </div>
                                                <div class="banner-content">
                                                    <span class="ec-banner-btn"><a class="btn-modal"
                                                            data-bs-toggle="modal" data-bs-target="#modalCustom">Ver
                                                            Catálogo</a></span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                {{-- modal de descargar pdf --}}
                                <div class="modal fade" id="modalCustom" tabindex="-1" aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="titulo_catalogo"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <object id="catalogo" class="PDFdoc" width="100%" height="500px"
                                                    type="application/pdf"></object>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                                <a id="btn-descargar" type="button" target="_blank"
                                                    class="btn btn-primary">Descargar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ec Banner End -->
                        </div>
                        <!-- ec Banners End -->
                    </div>
                </div>
            </section>
            <!-- ec Banner Section End -->


            {{-- @if (count($subcategorias) > 3)
    <!--  Category Section -->
    <section class="section ec-category-section section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Conoce nuestra Colección</h2>
                        <h2 class="ec-title">Escoge por Categorias</h2>
                        <p class="sub-title">Busca articulos por categorias</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <!--Category Nav -->
                <div class="col-lg-3">
                    <ul class="ec-cat-tab-nav nav">
                        @php
                        $i = 1;
                        $sub = [];
                        @endphp
                        @foreach ($subcategorias as $subcategoria)

                        <li class="cat-item"><a class="cat-link" data-bs-toggle="tab" href="{{ '#tab-cat-' . $i++ }}">
                                <div class="cat-icons"><img loading='lazy' class="cat-icon"
                                        src="assets/images/icons/cat_4.png" alt="cat-icon"><img loading='lazy'
                                        class="cat-icon-hover" src="assets/images/icons/cat_4_1.png" alt="cat-icon">
                                </div>
                                <div class="cat-desc">
                                    <span>{{ $subcategoria->subcategoria }}</span><span>{{
                                        $subcategoria->cantidad_productos }}
                                        Productos</span>
                                </div>
                                @php
                                array_push($sub, $subcategoria->subcategoria);
                                @endphp
                            </a></li>
                        @endforeach
                    </ul>

                </div>
                <!-- Category Nav End -->
                <!--Category Tab -->
                <div class="col-lg-9">
                    <div class="tab-content">
                        <!-- 1st Category tab end -->
                        <div class="tab-pane fade show active" id="tab-cat-1">
                            <div class="row">
                                <img loading='lazy' src="assets/images/cat-banner/1.jpg" alt="" />
                            </div>
                            <span class="panel-overlay">
                                <a href="{{ route('web.tiendaOrderBy', ['subcategoria-' . $sub[0], 'productos.id']) }}"
                                    class="btn btn-primary">Ver Todos</a>
                            </span>
                        </div>
                        <!-- 1st Category tab end -->
                        <div class="tab-pane fade" id="tab-cat-2">
                            <div class="row">
                                <img loading='lazy' src="assets/images/cat-banner/2.jpg" alt="" />
                            </div>
                            <span class="panel-overlay">
                                <a href="{{ route('web.tiendaOrderBy', ['subcategoria-' . $sub[1], 'productos.id']) }}"
                                    class="btn btn-primary">Ver Todos</a>
                            </span>
                        </div>
                        <!-- 2nd Category tab end -->
                        <!-- 3rd Category tab -->
                        <div class="tab-pane fade" id="tab-cat-3">
                            <div class="row">
                                <img loading='lazy' src="assets/images/cat-banner/3.jpg" alt="" />
                            </div>
                            <span class="panel-overlay">
                                <a href="{{ route('web.tiendaOrderBy', ['subcategoria-' . $sub[2], 'productos.id']) }}"
                                    class="btn btn-primary">Ver Todos</a>
                            </span>
                        </div>
                        <!-- 3rd Category tab end -->
                        <!-- 4th Category tab -->
                        <div class="tab-pane fade" id="tab-cat-4">
                            <div class="row">
                                <img loading='lazy' src="assets/images/cat-banner/4.jpg" alt="" />
                            </div>
                            <span class="panel-overlay">
                                <a href="{{ route('web.tiendaOrderBy', ['subcategoria-' . $sub[3], 'productos.id']) }}"
                                    class="btn btn-primary">Ver Todos</a>
                            </span>
                        </div>
                        <!-- 4th Category tab end -->
                    </div>
                    <!-- Category Tab End -->
                </div>
            </div>
        </div>
    </section>
    <!-- Category Section End -->
    @endif --}}

            <!--  Feature & Special Section -->

            {{-- @if (count($poco_stock) > 1 && count($descuentos) > 1)
    <section class="section ec-fre-spe-section section-space-p">
        <div class="container">
            <div class="row">
                <!--  Feature Section -->
                <div class="ec-fre-section col-lg-6 col-md-6 col-sm-6 margin-b-30" data-animation="slideInRight">
                    <div class="col-md-12 text-left">
                        <div class="section-title">
                            <h2 class="ec-bg-title">Pocas Unidades</h2>
                            <h2 class="ec-title">Pocas Unidades</h2>
                        </div>
                    </div>

                    <div class="ec-fre-products">
                        @php
                        $i = 1;
                        @endphp
                        @foreach ($poco_stock as $value)
                        <div class="ec-fs-product">
                            <div class="ec-fs-pro-inner">
                                <div class="ec-fs-pro-image-outer col-lg-6 col-md-6 col-sm-6">
                                    <div class="ec-fs-pro-image">
                                        <a href="{{ route('web.detalle-producto', $value->estilo) }}" class="image"><img
                                                loading='lazy' class="main-image"
                                                src="storage/images/productos/{{ $value->imagen_path }}"
                                                style="object-fit: cover" /></a>
                                        <a href="#" class="quickview" data-link-action="quickview" title="Quick view"
                                            data-bs-toggle="modal" data-bs-target="#ec_quickview_modal"><img
                                                loading='lazy' src="assets/images/icons/quickview.svg"
                                                class="svg_img pro_svg" alt="" /></a>
                                    </div>
                                </div>
                                <div class="ec-fs-pro-content col-lg-6 col-md-6 col-sm-6">
                                    <h5 class="ec-fs-pro-title"><a
                                            href="{{ route('web.detalle-producto', $value->estilo) }}">{{
                                            $value->nombre_mostrar }}</a>
                                    </h5>
                                    <div class="ec-fs-pro-rating">
                                        <span class="ec-fs-rating-icon">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </span>
                                    </div>
                                    <div class="ec-fs-price">
                                        @empty(!$value->descuento)
                                        <span class="old-price">${{ $value->precio_empresaria }}</span>
                                        <span class="new-price">${{ number_format($value->precio_empresaria -
                                            $value->precio_empresaria * ($value->descuento / 100), 2) }}</span>
                                        @else
                                        <span class="new-price">${{ number_format($value->precio_empresaria, 2)
                                            }}</span>
                                        @endempty
                                    </div>

                                    <div class="countdowntimer"><span id="{{ 'ec-fs-count-' . $i++ }}"></span>
                                    </div>
                                    <div class="ec-fs-pro-desc">{{ $value->descripcion }}
                                    </div>
                                    <div class="ec-fs-pro-book">Total en stock:
                                        <span>{{ $value->stock }}</span>
                                    </div>
                                    <div class="ec-fs-pro-btn">
                                        <a href="#" class="btn btn-lg btn-secondary">Recordarme</a>
                                        <a href="{{ route('web.detalle-producto', $value->estilo) }}"
                                            class="btn btn-lg btn-primary">Comprar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!--  Feature Section End -->
                <!--  Special Section -->
                <div class="ec-spe-section col-lg-6 col-md-6 col-sm-6" data-animation="slideInLeft">
                    <div class="col-md-12 text-left">
                        <div class="section-title">
                            <h2 class="ec-bg-title">Ofertas Tiempo Limitado</h2>
                            <h2 class="ec-title">Ofertas Tiempo Limitado</h2>
                        </div>
                    </div>

                    <div class="ec-spe-products">
                        @foreach ($descuentos as $value)
                        <div class="ec-fs-product">
                            <div class="ec-fs-pro-inner">
                                <div class="ec-fs-pro-image-outer col-lg-6 col-md-6 col-sm-6">
                                    <div class="ec-fs-pro-image">
                                        <a href="{{ route('web.detalle-producto', $value->estilo) }}" class="image"><img
                                                loading='lazy' class="main-image"
                                                src="storage/images/productos/{{ $value->imagen_path }}"
                                                style="object-fit: cover" /></a>
                                        <a href="#" class="quickview" data-link-action="quickview" title="Quick view"
                                            data-bs-toggle="modal" data-bs-target="#ec_quickview_modal"><img
                                                loading='lazy' src="assets/images/icons/quickview.svg"
                                                class="svg_img pro_svg" alt="" /></a>
                                    </div>
                                </div>
                                <div class="ec-fs-pro-content col-lg-6 col-md-6 col-sm-6">
                                    <h5 class="ec-fs-pro-title"><a
                                            href="{{ route('web.detalle-producto', $value->estilo) }}">{{
                                            $value->nombre_mostrar }}</a>
                                    </h5>
                                    <span class="ec-fs-rating-text"><span class="badge rounded-pill bg-danger">Descuento
                                            del
                                            {{ $value->descuento }}%</span></span>
                                    <div class="ec-fs-price">
                                        @empty(!$value->descuento)
                                        <span class="old-price">${{ $value->precio_empresaria }}</span>
                                        <span class="new-price">${{ number_format($value->precio_empresaria -
                                            $value->precio_empresaria * ($value->descuento / 100), 2) }}</span>
                                        @else
                                        <span class="new-price">${{ number_format($value->precio_empresaria, 2)
                                            }}</span>
                                        @endempty
                                    </div>

                                    <div class="countdowntimer"><span id="{{ 'ec-fs-count-' . $i++ }}"></span>
                                    </div>
                                    <div class="ec-fs-pro-desc">{{ $value->descripcion }}
                                    </div>
                                    <div class="ec-fs-pro-book">Total en stock:
                                        <span>{{ $value->stock }}</span>
                                    </div>
                                    <div class="ec-fs-pro-btn">
                                        <a href="#" class="btn btn-lg btn-secondary">Recordarme</a>
                                        <a href="{{ route('web.detalle-producto', $value->estilo) }}"
                                            class="btn btn-lg btn-primary">Comprar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!--  Special Section End -->
            </div>
        </div>
    </section>
    @endif --}}
            <!-- Feature & Special Section End -->
            {{-- seccion de pasos para registrarte --}}
            <section class="section ec-test-section section-space-ptb-100 section-space-m">
                <div class="container">
                    <div class="col-md-12 text-center">
                        <div class="section-title">
                            <h2 class="ec-title">Registrate en Ibizza</h2>
                            <p class="w-50 mx-auto my-2">¡En tu primer pedido ya recibes premios!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-sm-12 mx-auto">
                    <nav>
                        <div class="nav nav-tabs justify-content-center border-success" id="nav-tab" role="tablist">
                            <button class="nav-link active w-25" id="nav-home-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                aria-selected="true">PASO 1</button>
                            <button class="nav-link w-25" id="nav-profile-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                                aria-selected="false">PASO 2</button>
                            <button class="nav-link w-25" id="nav-contact-tab" data-bs-toggle="tab"
                                data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                                aria-selected="false">PASO 3</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active bg-light" id="nav-home" role="tabpanel"
                            aria-labelledby="nav-home-tab">
                            <div class="card w-100 p-4">
                                <div class="row g-0">
                                    <div class="col-md-7">
                                        <img src="{{ url('assets/images/card-empresaria/1.jpg') }}" class="img-fluid rounded" alt="...">
                                    </div>
                                    <div class="col-md-5 my-auto">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold text-center p-4">Solo Registrate</h5>
                                            <p class="card-text">Debes darle click al boton de registrarte o quiero ser empresaria para llenar unos
                                                pocos datos y empezar a formar parte del equipo de Ibizza.</p>
                                            <a href="{{ route('web.registro-empresaria') }}" class="btn nav-link">Registrarme
                                                aquí</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade bg-light" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card w-100 p-4">
                                <div class="row g-0">                                    
                                    <div class="col-md-5 my-auto">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold text-center p-4">Ingresa a tu perfil</h5>
                                            <p class="card-text">Debes acceder con tu usuario en Soy Empresaria y podras solicitar tu catálogo fisico o descargar el catálogo virtual, podras saber tus ganancias, tus ultimos pedidos, tus premios y mucho más.</p>
                                            @auth
                                            <a href="{{ route('web.perfil-empresaria') }}" class="btn nav-link">Soy Empresaria</a>
                                            @else                                            
                                            <a href="{{ route('login') }}" class="btn nav-link">Soy Empresaria</a>
                                            @endauth
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <img src="{{ url('assets/images/card-empresaria/2.jpg') }}" class="img-fluid rounded" alt="...">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade bg-light" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="card w-100 p-4">
                                <div class="row g-0">
                                    <div class="col-md-7">
                                        <img src="{{ url('assets/images/card-empresaria/3.jpg') }}" class="img-fluid rounded" alt="...">
                                    </div>
                                    <div class="col-md-5 my-auto">
                                        <div class="card-body">
                                            <h5 class="card-title fw-bold text-center p-4">Comparte… y ¡GANA!</h5>
                                            <p class="card-text">Comentale a tus amigos y familiares que formas parte de Ibizza, realiza tu primer pedido y empieza a ganar muchos premios.</p>
                                            <a href="#" class="btn nav-link">Plan de Premios Actual</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--  services Section -->
            <section class="section ec-services-section section-space-p">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-title">En Ibizza Estamos para ayudarte</h2>
                        <p class="w-50 mx-auto my-2">Estaremos siempre presente para ayudarte en cualquier duda o
                            inconveniente</p>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="ec_ser_content ec_ser_content_1 col-sm-12 col-md-6 col-lg-3" data-animation="zoomIn">
                            <div class="ec_ser_inner">
                                <div class="ec-service-image">
                                    <img loading='lazy' src="assets/images/icons/service_1.svg" class="svg_img"
                                        alt="" />
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
                                    <img loading='lazy' src="assets/images/icons/service_2.svg" class="svg_img"
                                        alt="" />
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
                                    <img loading='lazy' src="assets/images/icons/service_3.svg" class="svg_img"
                                        alt="" />
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
                                    <img loading='lazy' src="assets/images/icons/service_4.svg" class="svg_img"
                                        alt="" />
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

            <!--  offer Section -->
            {{-- <section class="section ec-offer-section section-space-p section-space-m">
        <h2 class="d-none">Ofertas</h2>
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center ec-offer-content">
                    <h2 class="ec-offer-title">Gafas de Sol</h2>
                    <h3 class="ec-offer-stitle" data-animation="slideInDown">Super Ofertas</h3>
                    <span class="ec-offer-img" data-animation="zoomIn"><img loading='lazy'
                            src="assets/images/offer-image/1.png" alt="offer image" /></span>
                    <span class="ec-offer-desc">Descripción de Gafas de sol</span>
                    <span class="ec-offer-price">$40.00</span>
                    <a class="btn btn-primary" href="shop-left-sidebar-col-3.html" data-animation="zoomIn">Comprar</a>
                </div>
            </div>
        </div>
    </section> --}}
            <!-- offer Section End -->

            <!-- New Product -->
            {{-- <section class="section ec-new-product section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Nuevos Productos</h2>
                        <h2 class="ec-title">Nuevos Productos</h2>
                        <p class="sub-title">Explora la colección de los mejores productos</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- New Product Content -->
                @foreach ($ultimos as $ultimo)
                @livewire('card-productos' , ['id_producto'=>$ultimo->id,'imagen' =>
                $ultimo->imagen_path,'clasificacion' => $ultimo->clasificacion ,'valor_venta'
                => $ultimo->valor_venta,'color' => $ultimo->color, 'estilo' =>
                $ultimo->estilo,'nombre_producto'=>$ultimo->nombre_mostrar,'precio_empresaria'=>$ultimo->precio_empresaria,'descuento'=>$ultimo->descuento,'nuevo'=>'nuevo'])
                @endforeach
                <div class="col-sm-12 shop-all-btn"><a href="{{ route('web.tienda') }}">ver todos los
                        productos</a>
                </div>
            </div>
        </div>
    </section> --}}
            <!-- New Product end -->

            <!-- ec testmonial -->
            <section class="section ec-test-section section-space-ptb-100 section-space-m">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="section-title mb-0">
                                <h2 class="ec-bg-title">Testimonios</h2>
                                <h2 class="ec-title">Testimonios</h2>
                                <p class="sub-title mb-3">¿Qué dice el cliente sobre nosotros?</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="ec-test-outer">
                            <ul id="ec-testimonial-slider">
                                <li class="ec-test-item">
                                    <img loading='lazy' src="assets/images/testimonial/top-quotes.svg"
                                        class="svg_img test_svg top" alt="" />
                                    <div class="ec-test-inner">
                                        <div class="ec-test-img"><img loading='lazy' alt="testimonial" title="testimonial"
                                                src="assets/images/testimonial/1.jpg" /></div>
                                        <div class="ec-test-content">
                                            <div class="ec-test-desc">Lorem Ipsum is simply dummy text of the printing and
                                                typesetting industry. Lorem Ipsum has been the industry's standard dummy text
                                                ever since the 1500s, when an unknown printer took a galley of type and
                                                scrambled it to make a type specimen</div>
                                            <div class="ec-test-name">Karla Campos</div>
                                            <div class="ec-test-designation">Empresaria</strong>
                                            </div>
                                            <div class="ec-test-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <img loading='lazy' src="assets/images/testimonial/bottom-quotes.svg"
                                        class="svg_img test_svg bottom" alt="" />
                                </li>
                                <li class="ec-test-item ">
                                    <img loading='lazy' src="assets/images/testimonial/top-quotes.svg"
                                        class="svg_img test_svg top" alt="" />
                                    <div class="ec-test-inner">
                                        <div class="ec-test-img"><img loading='lazy' alt="testimonial" title="testimonial"
                                                src="assets/images/testimonial/2.jpg" /></div>
                                        <div class="ec-test-content">
                                            <div class="ec-test-desc">Lorem Ipsum is simply dummy text of the printing and
                                                typesetting industry. Lorem Ipsum has been the industry's standard dummy text
                                                ever since the 1500s, when an unknown printer took a galley of type and
                                                scrambled it to make a type specimen</div>
                                            <div class="ec-test-name">Johanna Garcia</div>
                                            <div class="ec-test-designation">Emprendedora</div>
                                            <div class="ec-test-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <img loading='lazy' src="assets/images/testimonial/bottom-quotes.svg"
                                        class="svg_img test_svg bottom" alt="" />
                                </li>
                                <li class="ec-test-item">
                                    <img loading='lazy' src="assets/images/testimonial/top-quotes.svg"
                                        class="svg_img test_svg top" alt="" />
                                    <div class="ec-test-inner">
                                        <div class="ec-test-img"><img loading='lazy' alt="testimonial" title="testimonial"
                                                src="assets/images/testimonial/3.png" /></div>
                                        <div class="ec-test-content">
                                            <div class="ec-test-desc">Lorem Ipsum is simply dummy text of the printing and
                                                typesetting industry. Lorem Ipsum has been the industry's standard dummy text
                                                ever since the 1500s, when an unknown printer took a galley of type and
                                                scrambled it to make a type specimen</div>
                                            <div class="ec-test-name">Juan Perez</div>
                                            <div class="ec-test-designation">Administrador de tienda</div>
                                            <div class="ec-test-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <img loading='lazy' src="assets/images/testimonial/bottom-quotes.svg"
                                        class="svg_img test_svg bottom" alt="" />
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!-- ec testmonial end -->

            <!-- Ec Brand Section -->
            <section class="section ec-brand-area section-space-p">
                <h2 class="d-none">Brand</h2>
                <div class="container">
                    <div class="row">
                        <div class="ec-brand-outer">
                            <ul id="ec-brand-slider">
                                @foreach ($marcas as $marca)
                                    <li class="ec-brand-item" data-animation="zoomIn">
                                        <div class="ec-brand-img"><a href="/tienda/marca/{{ $marca->nombre }}"><img
                                                    loading='lazy' alt="brand" title="brand"
                                                    src="storage/images/marca/{{ $marca->imagen }}" /></a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Ec Brand Section End -->

            <!-- Ec Instagram -->
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

            <!-- Footer -->
            <footer class="ec-footer section-space-mt">
                <div class="footer-container">
                    <div class="footer-offer">
                        <div class="container">
                            <div class="row">
                                <div class="text-center footer-off-msg">
                                    <span>!Gana Premios! por todas tus compras</span><a href="#" target="_blank">ver
                                        Detalle</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-top section-space-footer-p">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-12 col-lg-3 ec-footer-contact">
                                    <div class="ec-footer-widget">
                                        <div class="ec-footer-logo"><a href="#"><img loading='lazy'
                                                    src="{{ url('assets/images/logo/logo_ibizza.svg') }}" alt=""><img
                                                    loading='lazy' class="dark-footer-logo"
                                                    src="assets/images/logo/dark-logo.png" alt="Site Logo"
                                                    style="display: none;" /></a></div>
                                        <h4 class="ec-footer-heading">Contactanos</h4>
                                        <div class="ec-footer-links">
                                            <ul class="align-items-center">
                                                <li class="ec-footer-link">Guayas - Guayaqui || Cdla. La Garzota</li>
                                                <li class="ec-footer-link"><span>Contactanos:</span><a
                                                        href="tel:+440123456789">+593 98 765 4321</a></li>
                                                <li class="ec-footer-link"><span>Email:</span><a
                                                        href="mailto:example@ec-email.com">+example@ec-email.com</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-2 ec-footer-info">
                                    <div class="ec-footer-widget">
                                        <h4 class="ec-footer-heading">Información</h4>
                                        <div class="ec-footer-links">
                                            <ul class="align-items-center">
                                                <li class="ec-footer-link"><a href="{{ route('web.sobre-nosotros') }}">Sobre
                                                        Nosotros</a></li>
                                                <li class="ec-footer-link"><a
                                                        href="{{ route('web.preguntas-frecuentes') }}">Preguntas</a></li>
                                                <li class="ec-footer-link"><a href="track-order.html">Información de Envios</a>
                                                </li>
                                                <li class="ec-footer-link"><a
                                                        href="{{ route('web.contactanos') }}">Contáctenos</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-2 ec-footer-account">
                                    <div class="ec-footer-widget">
                                        <h4 class="ec-footer-heading">Soy Empresaria</h4>
                                        <div class="ec-footer-links">
                                            <ul class="align-items-center">
                                                <li class="ec-footer-link"><a href="user-profile.html">My Account</a></li>
                                                <li class="ec-footer-link"><a href="track-order.html">Order History</a></li>
                                                <li class="ec-footer-link"><a href="offer.html">Specials</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-2 ec-footer-service">
                                    <div class="ec-footer-widget">
                                        <h4 class="ec-footer-heading">Servicios</h4>
                                        <div class="ec-footer-links">
                                            <ul class="align-items-center">
                                                <li class="ec-footer-link"><a href="track-order.html">Discount Returns</a>
                                                </li>
                                                <li class="ec-footer-link"><a
                                                        href="{{ route('web.politica-privacidad') }}">Política de
                                                        Privacidad</a>
                                                </li>
                                                <li class="ec-footer-link"><a
                                                        href="{{ route('web.terminos-condiciones') }}">Servicios</a>
                                                </li>
                                                <li class="ec-footer-link"><a
                                                        href="{{ route('web.terminos-condiciones') }}">Términos y
                                                        Condiciones</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-3 ec-footer-news">
                                    <div class="ec-footer-widget">
                                        <h4 class="ec-footer-heading">Newsletter</h4>
                                        <div class="ec-footer-links">
                                            <ul class="align-items-center">
                                                <li class="ec-footer-link">Get instant updates about our new products and
                                                    special promos!</li>
                                            </ul>
                                            <div class="ec-subscribe-form">
                                                <form id="ec-newsletter-form" name="ec-newsletter-form" method="post"
                                                    action="#">
                                                    <div id="ec_news_signup" class="ec-form">
                                                        <input class="ec-email" type="email" required=""
                                                            placeholder="Enter your email here..." name="ec-email" value="" />
                                                        <button id="ec-news-btn" class="button btn-primary" type="submit"
                                                            name="subscribe" value=""><i class="ecicon eci-paper-plane-o"
                                                                aria-hidden="true"></i></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-bottom">
                        <div class="container">
                            <div class="row align-items-center">
                                <!-- Footer social -->
                                <div class="col text-left footer-bottom-left">
                                    <div class="footer-bottom-social">
                                        <span class="social-text text-upper">Follow us on:</span>
                                        <ul class="mb-0">
                                            <li class="list-inline-item"><a class="hdr-facebook" href="#"><i
                                                        class="ecicon eci-facebook"></i></a></li>
                                            {{-- <li class="list-inline-item"><a class="hdr-twitter" href="#"><i
                                                class="ecicon eci-twitter"></i></a></li> --}}
                                            <li class="list-inline-item"><a class="hdr-instagram" href="#"><i
                                                        class="ecicon eci-instagram"></i></a></li>
                                            {{-- <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i
                                                class="ecicon eci-linkedin"></i></a></li> --}}
                                        </ul>
                                    </div>
                                </div>
                                <!-- Footer social End -->
                                <!-- Footer Copyright -->
                                <div class="col text-center footer-copy">
                                    <div class="footer-bottom-copy ">
                                        <div class="ec-copy">Copyright © 2021-2022 <a class="site-name text-upper"
                                                href="#">Ibizza<span>.</span></a>. Todos los derechos reservados</div>
                                    </div>
                                </div>
                                <!-- Footer Copyright End -->
                                <!-- Footer payment -->
                                <div class="col footer-bottom-right">
                                    <div class="footer-bottom-payment d-flex justify-content-end">
                                        <div class="payment-link">
                                            <img loading='lazy' src="assets/images/icons/payment.png" alt="">
                                        </div>

                                    </div>
                                </div>
                                <!-- Footer payment -->
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- Footer Area End -->

            <livewire:modal-quick-view />

            <!-- Newsletter Modal -->

            <!-- Newsletter Modal end -->

            <!-- Footer navigation panel for responsive display -->
            <div class="ec-nav-toolbar">
                <div class="container">
                    <div class="ec-nav-panel">
                        <div class="ec-nav-panel-icons">
                            <a href="#ec-mobile-menu" class="navbar-toggler-btn ec-header-btn ec-side-toggle"><img
                                    loading='lazy' src="assets/images/icons/menu.svg" class="svg_img header_svg"
                                    alt="icon" /></a>
                        </div>
                        <div class="ec-nav-panel-icons">
                            <a href="#ec-side-cart" class="toggle-cart ec-header-btn ec-side-toggle"><img loading='lazy'
                                    src="assets/images/icons/cart.svg" class="svg_img header_svg" alt="icon" /><span
                                    class="ec-cart-noti ec-header-count cart-count-lable">{{ Cart::count() }}</span></a>
                        </div>
                        <div class="ec-nav-panel-icons">
                            <a href="{{ url('/') }}" class="ec-header-btn"><img loading='lazy'
                                    src="assets/images/icons/home.svg" class="svg_img header_svg" alt="icon" /></a>
                        </div>
                        <div class="ec-nav-panel-icons">
                            <a href="#" class="ec-header-btn"><img loading='lazy' src="assets/images/icons/wishlist.svg"
                                    class="svg_img header_svg" alt="icon" /><span class="ec-cart-noti">0</span></a>
                        </div>
                        <div class="ec-nav-panel-icons">
                            @if (Route::has('login'))

                                @auth
                                    @can('dashboard')
                                        <a href="{{ url('/dashboard') }}" class="ec-header-btn"><img loading='lazy'
                                                src="assets/images/icons/user.svg" class="svg_img header_svg" alt="icon" /></a>
                                    @else
                                        <a href="{{ route('web.perfil-empresaria') }}" class="ec-header-btn"><img loading='lazy'
                                                src="assets/images/icons/user.svg" class="svg_img header_svg" alt="icon" /></a>
                                    @endcan
                                @else

                                    <a href="{{ route('login') }}" class="ec-header-btn"><img loading='lazy'
                                            src="assets/images/icons/user.svg" class="svg_img header_svg" alt="icon" /></a>
                                @endif
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Footer navigation panel for responsive display end -->

                <!-- Recent Purchase Popup  -->

                <!-- Recent Purchase Popup end -->

                <!-- Cart Floating Button -->
                <div class="ec-cart-float">
                    <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                        <div class="header-icon"><img loading='lazy' src="assets/images/icons/cart.svg"
                                class="svg_img header_svg" alt="cart" />
                        </div>
                        <span class="ec-cart-count cart-count-lable">{{ Cart::count() }}</span>
                    </a>
                </div>
                <!-- Cart Floating Button end -->

                <!-- Whatsapp -->
                <div class="ec-style ec-right-bottom">
                    <!-- Floating Panel Container -->
                    <div class="ec-panel">
                        <!-- Panel Header -->
                        <div class="ec-header">
                            <strong>Necesitas Ayuda?</strong>
                            <p>Chatea con nosotros en Whatsapp</p>
                        </div>
                        <!-- Panel Content -->
                        <div class="ec-body">
                            <ul>
                                <!-- Single Contact List -->
                                <li>
                                    <a class="ec-list" data-number="593967402331"
                                        data-message="¡Hola! Necesito ayuda en un pedido ">
                                        <div class="d-flex bd-highlight">
                                            <!-- Profile Picture -->
                                            <div class="ec-img-cont">
                                                <img loading='lazy' src="assets/images/favicon/logo_ibizza_verde.svg"
                                                    class="ec-user-img" alt="Profile image">
                                                <span class="ec-status-icon ec-online"></span>
                                            </div>
                                            <!-- Display Name & Last Seen -->
                                            <div class="ec-user-info">
                                                <span>Ibizza</span>
                                                <p>Ibizza está en linea</p>
                                            </div>
                                            <!-- Chat iCon -->
                                            <div class="ec-chat-icon">
                                                <i class="fa fa-whatsapp"></i>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!--/ End Single Contact List -->
                                <!-- Single Contact List -->
                                <li>
                                    <a class="ec-list" data-number="593967402331"
                                        data-message="¡Hola! Necesito ayuda en un pedido ">
                                        <div class="d-flex bd-highlight">
                                            <!-- Profile Picture -->
                                            <div class="ec-img-cont">
                                                <img loading='lazy' src="assets/images/favicon/logo_ibizza_verde.svg"
                                                    class="ec-user-img" alt="Profile image">
                                                <span class="ec-status-icon ec-offline"></span>
                                            </div>
                                            <!-- Display Name & Last Seen -->
                                            <div class="ec-user-info">
                                                <span>D'pisar</span>
                                                <p>activo hace 7 min</p>
                                            </div>
                                            <!-- Chat iCon -->
                                            <div class="ec-chat-icon">
                                                <i class="fa fa-whatsapp"></i>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <!--/ End Single Contact List -->
                            </ul>
                        </div>
                    </div>
                    <!--/ End Floating Panel Container -->
                    <!-- Right Floating Button-->
                    <div class="ec-right-bottom">
                        <div class="ec-box">
                            <div class="ec-button rotateBackward">
                                <img loading='lazy' class="whatsapp" src="assets/images/common/whatsapp.png"
                                    alt="whatsapp icon">
                            </div>
                        </div>
                    </div>
                    <!--/ End Right Floating Button-->
                </div>
                <!-- Whatsapp end -->

                <!-- Feature tools -->

                <!-- Feature tools end -->

                <!-- Vendor JS -->
                <script src="assets/js/vendor/jquery-3.5.1.min.js"></script>
                <script src="assets/js/vendor/popper.min.js"></script>
                <script src="assets/js/vendor/bootstrap.min.js"></script>
                <script src="assets/js/vendor/jquery-migrate-3.3.0.min.js"></script>
                <script src="assets/js/vendor/modernizr-3.11.2.min.js"></script>

                <!--Plugins JS-->
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="assets/js/plugins/swiper-bundle.min.js"></script>
                <script src="assets/js/plugins/countdownTimer.min.js"></script>
                <script src="assets/js/plugins/scrollup.js"></script>
                <script src="assets/js/plugins/jquery.zoom.min.js"></script>
                <script src="assets/js/plugins/slick.min.js"></script>
                <script src="assets/js/plugins/infiniteslidev2.js"></script>
                <script src="assets/js/vendor/jquery.magnific-popup.min.js"></script>
                <script src="assets/js/plugins/jquery.sticky-sidebar.js"></script>

                <!-- Main Js -->
                <script src="assets/js/vendor/index.js"></script>
                <script src="assets/js/main.js"></script>

                <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

                @stack('js')
                @livewireScripts
            </body>

            </html>
