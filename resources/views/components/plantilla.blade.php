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
    <link rel="icon" href="{{url('assets/images/favicon/Logo_ibizza_verde.svg')}}" sizes="32x32" />
    <link rel="apple-touch-icon" href="{{url('assets/images/favicon/Logo_ibizza.svg')}}" />
    <meta name="msapplication-TileImage" content="{{url('assets/images/favicon/Logo_ibizza.svg')}}" />

    <!-- css Icon Font -->
    <link rel="stylesheet" href="{{url('assets/css/vendor/ecicons.min.css')}}" />

    <!-- css All Plugins Files -->
    <link rel="stylesheet" href="{{url('assets/css/plugins/animate.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/plugins/swiper-bundle.min.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/plugins/jquery-ui.min.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/plugins/countdownTimer.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/plugins/slick.min.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/plugins/bootstrap.css')}}" />

    <!-- Main Style -->
    <link rel="stylesheet" href="{{url('assets/css/demo1.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/skin-04.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/responsive.css')}}" />

    <!-- Background css -->
    <link rel="stylesheet" id="bg-switcher-css" href="{{url('assets/css/backgrounds/bg-4.css')}}">
    @stack('css')
    <style>
        ul {
            padding-left: 0 !important
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

    </style>
    @livewireStyles
    @method('css')
</head>

<body>
    <div id="ec-overlay"><span class="loader_img"></span></div>

    <!-- Header start  -->
    <header class="ec-header">
        <!--Ec Header Top Start -->
        <div class="header-top">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Header Top social Start -->
                    <div class="col text-left header-top-left d-none d-lg-block">
                        <div class="header-top-social">
                            <span class="social-text text-upper">Siguenos en :</span>
                            <ul class="mb-0">
                                <li class="list-inline-item"><a class="hdr-facebook" href="#"><i
                                            class="ecicon eci-facebook"></i></a></li>
                                <li class="list-inline-item"><a class="hdr-twitter" href="#"><i
                                            class="ecicon eci-twitter"></i></a></li>
                                <li class="list-inline-item"><a class="hdr-instagram" href="#"><i
                                            class="ecicon eci-instagram"></i></a></li>
                                <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i
                                            class="ecicon eci-linkedin"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Header Top social End -->
                    <!-- Header Top Message Start -->
                    <div class="col text-center header-top-center">
                        <div class="header-top-message text-upper">
                            
                        </div>
                    </div>
                    <!-- Header Top Message End -->
                    <!-- Header Top Language Currency -->
                    <div class="col header-top-right d-none d-lg-block">
                        <div class="header-top-lan-curr d-flex justify-content-end">
                            <!-- Currency Start -->
                            <div class="header-top-curr dropdown">
                                <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Moneda<i
                                        class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                                <ul class="dropdown-menu">
                                    <li class="active"><a class="dropdown-item" href="#">USD $</a></li>
                                </ul>
                            </div>
                            <!-- Currency End -->
                            <!-- Language Start -->
                            <div class="header-top-lan dropdown">
                                <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Idioma <i
                                        class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                                <ul class="dropdown-menu">
                                    <li class="active"><a class="dropdown-item" href="#">Español</a></li>
                                </ul>
                            </div>
                            <!-- Language End -->

                        </div>
                    </div>
                    <!-- Header Top Language Currency -->
                    <!-- Header Top responsive Action -->
                    <div class="col d-lg-none ">
                        <div class="ec-header-bottons">
                            <!-- Header User Start -->
                            <div class="ec-header-user dropdown">
                                <button class="dropdown-toggle" data-bs-toggle="dropdown"><img loading='lazy'
                                        src="{{url('assets/images/icons/user.svg')}}" class="svg_img header_svg" alt="" /></button>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    @if (Route::has('login'))

                                        @auth
                                            @can('dashboard')
                                            <li> <a href="{{ url('/dashboard') }}" class="dropdown-item">Dashboard</a></li> 
                                            @else
                                            <li> <a href="{{route('web.perfil-empresaria') }}" class="dropdown-item">Perfil</a></li>                                              
                                            @endcan
                                            <form action="{{ route('logout')}}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">cerrar sesión</button>
                                            </form>
                                            <li><a class="dropdown-item" href="{{ route('web.checkout')}}">Checkout</a></li>
                                        @else
                                            <li><a href="{{ route('login') }}" class="dropdown-item">Login</a></li>
                                            <li><a class="dropdown-item" href="{{route('web.registro-empresaria')}}">Registrar</a></li>
                                            <li><a class="dropdown-item" href="{{ route('web.checkout')}}">Checkout</a></li>
                                        @endif
                                        @endif
                                    </ul>
                                </div>
                                <!-- Header User End -->
                                <!-- Header Cart Start -->
                                <a href="#" class="ec-header-btn ec-header-wishlist">
                                    <div class="header-icon"><img loading='lazy' src="{{url('assets/images/icons/wishlist.svg')}}"
                                            class="svg_img header_svg" alt="" /></div>
                                    <span class="ec-header-count">0</span>
                                </a>
                                <!-- Header Cart End -->
                                <!-- Header Cart Start -->
                                <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                    <div class="header-icon"><img loading='lazy' src="{{url('assets/images/icons/cart.svg')}}"
                                            class="svg_img header_svg" alt="" /></div>
                                    <span class="ec-header-count cart-count-lable">{{ Cart::count() }}</span>
                                </a>
                                <!-- Header Cart End -->
                                <!-- Header menu Start -->
                                <a href="#ec-mobile-menu" class="ec-header-btn ec-side-toggle d-lg-none">
                                    <img loading='lazy' src="{{url('assets/images/icons/menu.svg')}}" class="svg_img header_svg"
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
            <!-- Ec Header Bottom  Start -->
            <div class="ec-header-bottom d-none d-lg-block">
                <div class="container position-relative">
                    <div class="row">
                        <div class="ec-flex">
                            <!-- Ec Header Logo Start -->
                            <div class="align-self-center">
                                <div class="header-logo">
                                    <a href="{{ url('/') }}"><img loading='lazy' class="p-1"
                                            src="{{url('assets/images/logo/logo_ibizza.svg')}}" alt="Logo Ibizza" />
                                        <img loading='lazy' class="dark-logo" src="{{url('assets/images/logo/dark-logo.png')}}"
                                            alt="Site Logo" style="display: none;" /></a>
                                </div>
                            </div>
                            <!-- Ec Header Logo End -->

                            <!-- Ec Header Search Start -->
                            <div class="align-self-center">
                                <div class="header-search">
                                    <form class="ec-btn-group-form" action="#">
                                        <input class="form-control txt_search" placeholder="Ingresa el nombre de un Producto..."
                                            type="text">
                                        <button class="submit" type="submit"><img loading='lazy'
                                                src="{{url('assets/images/icons/search.svg')}}" class="svg_img header_svg"
                                                alt="" /></button>
                                    </form>
                                </div>
                            </div>
                            <!-- Ec Header Search End -->

                            <!-- Ec Header Button Start -->
                            <div class="align-self-center">
                                <div class="ec-header-bottons">

                                    <!-- Header User Start -->
                                    <div class="ec-header-user dropdown">
                                        <button class="dropdown-toggle" data-bs-toggle="dropdown"><img loading='lazy'
                                                src="{{url('assets/images/icons/user.svg')}}" class="svg_img header_svg"
                                                alt="" /></button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            @if (Route::has('login'))

                                                @auth
                                                    @can('dashboard')
                                                    <li> <a href="{{ url('/dashboard') }}" class="dropdown-item">Dashboard</a></li> 
                                                    @else
                                                    <li> <a href="{{route('web.perfil-empresaria') }}" class="dropdown-item">Perfil</a></li>                                              
                                                    @endcan
                                                    <form action="{{ route('logout')}}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">cerrar sesión</button>
                                                    </form>
                                                    <li><a class="dropdown-item" href="{{ route('web.checkout')}}">Checkout</a></li>
                                                @else
                                                    <li><a href="{{ route('login') }}" class="dropdown-item">Login</a></li>
                                                    <li><a class="dropdown-item" href="{{route('web.registro-empresaria')}}">Registro</a></li>
                                                    <li><a class="dropdown-item" href="{{route('web.checkout')}}">Checkout</a></li>
                                                @endif
                                                @endif
                                            </ul>
                                        </div>
                                        <!-- Header User End -->
                                        <!-- Header wishlist Start -->
                                        <a href="#" class="ec-header-btn ec-header-wishlist">
                                            <div class="header-icon"><img loading='lazy' src="{{url('assets/images/icons/wishlist.svg')}}"
                                                    class="svg_img header_svg" alt="" /></div>
                                            <span class="ec-header-count">0</span>
                                        </a>
                                        <!-- Header wishlist End -->
                                        <!-- Header Cart Start -->
                                        <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                            <div class="header-icon"><img loading='lazy' src="{{url('assets/images/icons/cart.svg')}}"
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
                <!-- Header responsive Bottom  Start -->
                <div class="ec-header-bottom d-lg-none">
                    <div class="container position-relative">
                        <div class="row ">

                            <!-- Ec Header Logo Start -->
                            <div class="col">
                                <div class="header-logo">
                                    <a href="{{route('web')}}"><img loading='lazy' src="{{url('assets/images/logo/logo_ibizza.svg')}}"
                                            alt="Logo Ibizza" /><img loading='lazy' class="dark-logo"
                                            src="{{url('assets/images/logo/dark-logo.png')}}" alt="Site Logo" style="display: none;" /></a>
                                </div>
                            </div>
                            <!-- Ec Header Logo End -->
                            <!-- Ec Header Search Start -->
                            <div class="col">
                                <div class="header-search">
                                    <form class="ec-btn-group-form" action="#">
                                        <input class="form-control" placeholder="Ingresa el nombre de un Producto..."
                                            type="text">
                                        <button class="submit" type="submit"><img loading='lazy'
                                                src="{{url('assets/images/icons/search.svg')}}" class="svg_img header_svg"
                                                alt="icon" /></button>
                                    </form>
                                </div>
                            </div>
                            <!-- Ec Header Search End -->
                        </div>
                    </div>
                </div>
                <!-- Header responsive Bottom  End -->
                <!-- EC Main Menu Start -->
                <div id="ec-main-menu-desk" class="d-none d-lg-block sticky-nav">
                    <div class="container position-relative">
                        <div class="row">
                            <div class="col-md-12 align-self-center">
                                <div class="ec-main-menu">
                                    <ul>
                                        <li><a href="{{ url('/') }}">Home</a></li>
                                        <li class="dropdown position-static"><a href="javascript:void(0)">Categorias</a>
                                            <ul class="mega-menu d-block p-4">
                                                <li class="d-flex">
                                                    <ul class="d-block">
                                                        <li class="menu_title"><a href="{{route('web.tiendaOrderBy',['categoria-Mujer','productos.id'])}}">Mujeres</a></li>                                                        
                                                    </ul>
                                                    <ul class="d-block">
                                                        <li class="menu_title"><a href="{{route('web.tiendaOrderBy',['categoria-Hombre','productos.id'])}}">Hombres</a></li>                                                        
                                                        </li>
                                                    </ul>
                                                    <ul class="d-block">
                                                        <li class="menu_title"><a href="{{route('web.tiendaOrderBy',['categoria-Niños','productos.id'])}}">Niños</a></li>
                                                    </ul>
                                                    <ul class="d-block">
                                                        <li class="menu_title"><a href="{{route('web.tiendaOrderBy',['categoria-Niñas','productos.id'])}}">Niñas</a></li>                                                        
                                                    </ul>
                                                </li>
                                                <li>
                                                    <ul class="ec-main-banner w-100">
                                                        <li><a class="p-0" href="{{route('web.tiendaOrderBy',['categoria-Mujer','productos.id'])}}"><img
                                                                    loading='lazy' class="img-responsive"
                                                                    src="{{url('assets/images/menu-banner/1.jpg')}}" alt=""></a></li>
                                                        <li><a class="p-0" href="{{route('web.tiendaOrderBy',['categoria-Hombre','productos.id'])}}"><img
                                                                    loading='lazy' class="img-responsive"
                                                                    src="{{url('assets/images/menu-banner/2.jpg')}}" alt=""></a></li>
                                                        <li><a class="p-0" href="{{route('web.tiendaOrderBy',['categoria-Niños','productos.id'])}}"><img
                                                                    loading='lazy' class="img-responsive"
                                                                    src="{{url('assets/images/menu-banner/3.jpg')}}" alt=""></a></li>
                                                        <li><a class="p-0" href="{{route('web.tiendaOrderBy',['categoria-Niñas','productos.id'])}}"><img
                                                                    loading='lazy' class="img-responsive"
                                                                    src="{{url('assets/images/menu-banner/4.jpg')}}" alt=""></a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="dropdown"><a href="javascript:void(0)">Productos</a>
                                            <ul class="sub-menu">
                                                <li class="dropdown position-static"><a href="javascript:void(0)">Product page
                                                        <i class="ecicon eci-angle-right"></i></a>
                                                    <ul class="sub-menu sub-menu-child">
                                                        <li><a href="product-left-sidebar.html">Product left sidebar</a></li>
                                                        <li><a href="product-right-sidebar.html">Product right sidebar</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown position-static"><a href="javascript:void(0)">Product 360
                                                        <i class="ecicon eci-angle-right"></i></a>
                                                    <ul class="sub-menu sub-menu-child">
                                                        <li><a href="product-360-left-sidebar.html">360 left sidebar</a></li>
                                                        <li><a href="product-360-right-sidebar.html">360 right sidebar</a></li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown position-static"><a href="javascript:void(0)">Product video
                                                        <i class="ecicon eci-angle-right"></i></a>
                                                    <ul class="sub-menu sub-menu-child">
                                                        <li><a href="product-video-left-sidebar.html">Video left sidebar</a>
                                                        </li>
                                                        <li><a href="product-video-right-sidebar.html">Video right sidebar</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="dropdown position-static"><a href="javascript:void(0)">Product
                                                        gallery
                                                        <i class="ecicon eci-angle-right"></i></a>
                                                    <ul class="sub-menu sub-menu-child">
                                                        <li><a href="product-gallery-left-sidebar.html">Gallery left
                                                                sidebar</a>
                                                        </li>
                                                        <li><a href="product-gallery-right-sidebar.html">Gallery right
                                                                sidebar</a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="product-full-width.html">Product full width</a></li>
                                                <li><a href="product-360-full-width.html">360 full width</a></li>
                                                <li><a href="product-video-full-width.html">Video full width</a></li>
                                                <li><a href="product-gallery-full-width.html">Gallery full width</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown"><a href="javascript:void(0)">Paginas</a>
                                            <ul class="sub-menu">
                                                <li><a href="{{route('web.sobre-nosotros')}}">Sobre Nosotros</a></li>
                                                <li><a href="{{route('web.contactanos')}}">Contáctenos</a></li>
                                                <li><a href="cart.html">Cart</a></li>
                                                <li><a href="{{ route('web.checkout')}}">Checkout</a></li>
                                                <li><a href="compare.html">Compare</a></li>
                                                <li><a href="{{route('web.preguntas-frecuentes')}}">Preguntas</a></li>
                                                <li><a href="{{route('login')}}">Login</a></li>
                                                <li><a href="{{route('web.registro-empresaria')}}">Register</a></li>
                                                <li><a href="track-order.html">Track Order</a></li>
                                                <li><a href="{{route('web.terminos-condiciones')}}">Términos y Condiciones</a></li>
                                                <li><a href="{{route('web.politica-privacidad')}}">Política de Privacidad</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown"><span class="main-label-note-new" data-toggle="tooltip"
                                                title="NEW"></span><a href="{{ route('web.tienda') }}">Tienda</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ec Main Menu End -->
                <!-- ekka Mobile Menu Start -->
                <div id="ec-mobile-menu" class="ec-side-cart ec-mobile-menu">
                    <div class="ec-menu-title">
                        <span class="menu_title">Menu Ibizza</span>
                        <button class="ec-close">×</button>
                    </div>
                    <div class="ec-menu-inner">
                        <div class="ec-menu-content">
                            <ul>
                                <li><a href="{{route('web')}}">Home</a></li>
                                <li><a href="javascript:void(0)">Categorias</a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{route('web.tiendaOrderBy',['categoria-Mujer','productos.id'])}}">Mujeres</a>
                                        </li>
                                        <li>
                                            <a href="{{route('web.tiendaOrderBy',['categoria-Hombre','productos.id'])}}">Hombres</a>
                                        </li>
                                        <li>
                                            <a href="{{route('web.tiendaOrderBy',['categoria-Niños','productos.id'])}}">Niños</a>
                                        </li>
                                        <li>
                                            <a href="{{route('web.tiendaOrderBy',['categoria-Niñas','productos.id'])}}">Niñas</a>
                                        </li>
                                        <li><a class="p-0" href="{{route('web.tiendaOrderBy',['categoria-Mujer','productos.id'])}}"><img loading='lazy'
                                                    class="img-responsive" src="assets/images/menu-banner/1.jpg" alt=""></a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Productos</a>
                                    <ul class="sub-menu">
                                        <li><a href="javascript:void(0)">Product page</a>
                                            <ul class="sub-menu">
                                                <li><a href="product-left-sidebar.html">Product left sidebar</a></li>
                                                <li><a href="product-right-sidebar.html">Product right sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:void(0)">Product 360</a>
                                            <ul class="sub-menu">
                                                <li><a href="product-360-left-sidebar.html">360 left sidebar</a></li>
                                                <li><a href="product-360-right-sidebar.html">360 right sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:void(0)">Product vodeo</a>
                                            <ul class="sub-menu">
                                                <li><a href="product-video-left-sidebar.html">vodeo left sidebar</a></li>
                                                <li><a href="product-video-right-sidebar.html">vodeo right sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="javascript:void(0)">Product gallery</a>
                                            <ul class="sub-menu">
                                                <li><a href="product-gallery-left-sidebar.html">Gallery left sidebar</a></li>
                                                <li><a href="product-gallery-right-sidebar.html">Gallery right sidebar</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="product-full-width.html">Product full width</a></li>
                                        <li><a href="product-360-full-width.html">360 full width</a></li>
                                        <li><a href="product-video-full-width.html">Video full width</a></li>
                                        <li><a href="product-gallery-full-width.html">Gallery full width</a></li>
                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)">Paginas</a>
                                    <ul class="sub-menu">
                                        <li><a href="{{route('web.sobre-nosotros')}}">Sobre Nosotros</a></li>
                                        <li><a href="{{route('web.contactanos')}}">Contáctenos</a></li>
                                        <li><a href="cart.html">Cart</a></li>
                                        <li><a href="{{ route('web.checkout')}}">Checkout</a></li>
                                        <li><a href="compare.html">Compare</a></li>
                                        <li><a href="{{route('web.preguntas-frecuentes')}}">Preguntas</a></li>
                                        <li><a href="{{route('login')}}">Login</a></li>
                                        <li><a href="{{route('web.registro-empresaria')}}">Registro</a></li>
                                        <li><a href="track-order.html">Track Order</a></li>
                                        <li><a href="{{route('web.terminos-condiciones')}}">Términos y Condiciones</a></li>
                                        <li><a href="{{route('web.politica-privacidad')}}">Política de Privacidad</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="{{route('web.tienda')}}">Tienda</a>
                                </li>
                            </ul>
                        </div>
                        <div class="header-res-lan-curr">
                            <div class="header-top-lan-curr">
                                <!-- Language Start -->
                                <div class="header-top-lan dropdown">
                                    <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Idioma <i
                                            class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                                    <ul class="dropdown-menu">
                                        <li class="active"><a class="dropdown-item" href="#">Español</a></li>
                                    </ul>
                                </div>
                                <!-- Language End -->
                                <!-- Currency Start -->
                                <div class="header-top-curr dropdown">
                                    <button class="dropdown-toggle text-upper" data-bs-toggle="dropdown">Moneda <i
                                            class="ecicon eci-caret-down" aria-hidden="true"></i></button>
                                    <ul class="dropdown-menu">
                                        <li class="active"><a class="dropdown-item" href="#">USD $</a></li>
                                    </ul>
                                </div>
                                <!-- Currency End -->
                            </div>
                            <!-- Social Start -->
                            <div class="header-res-social">
                                <div class="header-top-social">
                                    <ul class="mb-0">
                                        <li class="list-inline-item"><a class="hdr-facebook" href="#"><i
                                                    class="ecicon eci-facebook"></i></a></li>
                                        <li class="list-inline-item"><a class="hdr-twitter" href="#"><i
                                                    class="ecicon eci-twitter"></i></a></li>
                                        <li class="list-inline-item"><a class="hdr-instagram" href="#"><i
                                                    class="ecicon eci-instagram"></i></a></li>
                                        <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i
                                                    class="ecicon eci-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Social End -->
                        </div>
                    </div>
                </div>
                <!-- ekka mobile Menu End -->
            </header>
            <!-- ibizza Cart Start -->
            <div class="ec-side-cart-overlay"></div>
            @livewire('ibizza-side-cart')
            <!-- ibizza Cart End -->
            {{-- main content start --}}
            <div>
                {{ $slot }}
            </div>
            {{-- main contente end --}}
            <!-- Footer Start -->
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
                                                    src="{{url('assets/images/logo/logo_ibizza.svg')}}" alt=""><img loading='lazy'
                                                    class="dark-footer-logo" src="{{url('assets/images/logo/dark-logo.png')}}"
                                                    alt="Site Logo" style="display: none;" /></a></div>
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
                                        <h4 class="ec-footer-heading">Information</h4>
                                        <div class="ec-footer-links">
                                            <ul class="align-items-center">
                                                <li class="ec-footer-link"><a href="{{route('web.sobre-nosotros')}}">Sobre Nosotros</a></li>
                                                <li class="ec-footer-link"><a href="{{route('web.preguntas-frecuentes')}}">Preguntas</a></li>
                                                <li class="ec-footer-link"><a href="track-order.html">Delivery Information</a>
                                                </li>
                                                <li class="ec-footer-link"><a href="{{route('web.contactanos')}}">Contáctenos</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-2 ec-footer-account">
                                    <div class="ec-footer-widget">
                                        <h4 class="ec-footer-heading">Cuenta</h4>
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
                                        <h4 class="ec-footer-heading">Services</h4>
                                        <div class="ec-footer-links">
                                            <ul class="align-items-center">
                                                <li class="ec-footer-link"><a href="track-order.html">Discount Returns</a></li>
                                                <li class="ec-footer-link"><a href="{{route('web.politica-privacidad')}}">Política de Privacidad</a>
                                                </li>
                                                <li class="ec-footer-link"><a href="{{route('web.terminos-condiciones')}}">Servicios</a>
                                                </li>
                                                <li class="ec-footer-link"><a href="{{route('web.terminos-condiciones')}}">Términos y Condiciones</a>
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
                                <!-- Footer social Start -->
                                <div class="col text-left footer-bottom-left">
                                    <div class="footer-bottom-social">
                                        <span class="social-text text-upper">Follow us on:</span>
                                        <ul class="mb-0">
                                            <li class="list-inline-item"><a class="hdr-facebook" href="#"><i
                                                        class="ecicon eci-facebook"></i></a></li>
                                            <li class="list-inline-item"><a class="hdr-twitter" href="#"><i
                                                        class="ecicon eci-twitter"></i></a></li>
                                            <li class="list-inline-item"><a class="hdr-instagram" href="#"><i
                                                        class="ecicon eci-instagram"></i></a></li>
                                            <li class="list-inline-item"><a class="hdr-linkedin" href="#"><i
                                                        class="ecicon eci-linkedin"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Footer social End -->
                                <!-- Footer Copyright Start -->
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
                                            <img loading='lazy' src="{{url('assets/images/icons/payment.png')}}" alt="">
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

            <!-- Modal -->
            <div class="modal fade" id="ec_quickview_modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <button type="button" class="btn-close qty_close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5 col-sm-12 col-xs-12">
                                    <!-- Swiper -->
                                    <div class="qty-product-cover">
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_1.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_2.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_3.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_4.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_5.jpg')}}"
                                                alt="">
                                        </div>
                                    </div>
                                    <div class="qty-nav-thumb">
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_1.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_2.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_3.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_4.jpg')}}"
                                                alt="">
                                        </div>
                                        <div class="qty-slide">
                                            <img loading='lazy' class="img-responsive" src="{{url('assets/images/product-image/3_5.jpg')}}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-12 col-xs-12">
                                    <div class="quickview-pro-content">
                                        <h5 class="ec-quick-title"><a href="product-left-sidebar.html">Handbag leather purse
                                                for women</a>
                                        </h5>
                                        <div class="ec-quickview-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>

                                        <div class="ec-quickview-desc">Lorem Ipsum is simply dummy text of the printing and
                                            typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                                            since the 1500s,</div>
                                        <div class="ec-quickview-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </div>

                                        <div class="ec-pro-variation">
                                            <div class="ec-pro-variation-inner ec-pro-variation-color">
                                                <span>Color</span>
                                                <div class="ec-pro-color">
                                                    <ul class="ec-opt-swatch">
                                                        <li><span style="background-color:#ebbf60;"></span></li>
                                                        <li><span style="background-color:#75e3ff;"></span></li>
                                                        <li><span style="background-color:#11f7d8;"></span></li>
                                                        <li><span style="background-color:#acff7c;"></span></li>
                                                        <li><span style="background-color:#e996fa;"></span></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="ec-pro-variation-inner ec-pro-variation-size ec-pro-size">
                                                <span>Size</span>
                                                <div class="ec-pro-variation-content">
                                                    <ul class="ec-opt-size">
                                                        <li class="active"><a href="#" class="ec-opt-sz"
                                                                data-tooltip="Small">S</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-tooltip="Medium">M</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-tooltip="Large">X</a></li>
                                                        <li><a href="#" class="ec-opt-sz" data-tooltip="Extra Large">XL</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-quickview-qty">
                                            <div class="qty-plus-minus">
                                                <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                                            </div>
                                            <div class="ec-quickview-cart ">
                                                <button class="btn btn-primary"><img loading='lazy'
                                                        src="{{url('assets/images/icons/cart.svg')}}" class="svg_img pro_svg" alt="" /> Add
                                                    To Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal end -->

            <!-- Newsletter Modal Start -->

            <!-- Newsletter Modal end -->

            <!-- Footer navigation panel for responsive display -->
            <div class="ec-nav-toolbar">
                <div class="container">
                    <div class="ec-nav-panel">
                        <div class="ec-nav-panel-icons">
                            <a href="#ec-mobile-menu" class="navbar-toggler-btn ec-header-btn ec-side-toggle"><img
                                    loading='lazy' src="{{url('assets/images/icons/menu.svg')}}" class="svg_img header_svg"
                                    alt="icon" /></a>
                        </div>
                        <div class="ec-nav-panel-icons">
                            <a href="#ec-side-cart" class="toggle-cart ec-header-btn ec-side-toggle"><img loading='lazy'
                                    src="{{url('assets/images/icons/cart.svg')}}" class="svg_img header_svg" alt="icon" /><span
                                    class="ec-cart-noti ec-header-count cart-count-lable">{{ Cart::count() }}</span></a>
                        </div>
                        <div class="ec-nav-panel-icons">
                            <a href="{{ url('/') }}" class="ec-header-btn"><img loading='lazy'
                                    src="{{url('assets/images/icons/home.svg')}}" class="svg_img header_svg" alt="icon" /></a>
                        </div>
                        <div class="ec-nav-panel-icons">
                            <a href="#" class="ec-header-btn"><img loading='lazy'
                                    src="{{url('assets/images/icons/wishlist.svg')}}" class="svg_img header_svg" alt="icon" /><span
                                    class="ec-cart-noti">0</span></a>
                        </div>
                        <div class="ec-nav-panel-icons">
                            @if (Route::has('login'))

                                @auth
                                    @can('dashboard')
                                        <a href="{{ url('/dashboard') }}" class="ec-header-btn"><img loading='lazy'
                                            src="{{url('assets/images/icons/user.svg')}}" class="svg_img header_svg" alt="icon" /></a>                                               
                                    @else
                                        <a href="{{ route('web.perfil-empresaria') }}" class="ec-header-btn"><img loading='lazy'
                                            src="{{url('assets/images/icons/user.svg')}}" class="svg_img header_svg" alt="icon" /></a>
                                    @endcan
                                @else

                                    <a href="{{ route('login') }}" class="ec-header-btn"><img loading='lazy'
                                            src="{{url('assets/images/icons/user.svg')}}" class="svg_img header_svg" alt="icon" /></a>
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
                        <div class="header-icon"><img loading='lazy' src="{{url('assets/images/icons/cart.svg')}}" class="svg_img header_svg"
                                alt="cart" />
                        </div>
                        <span class="ec-cart-count cart-count-lable">{{ Cart::count() }}</span>
                    </a>
                </div>
                <!-- Cart Floating Button end -->

                <!-- Whatsapp -->
                <div class="ec-style ec-right-bottom">
                    <!-- Start Floating Panel Container -->
                    <div class="ec-panel">
                        <!-- Panel Header -->
                        <div class="ec-header">
                            <strong>Necesitas Ayuda?</strong>
                            <p>Chatea con nosotros en Whatsapp</p>
                        </div>
                        <!-- Panel Content -->
                        <div class="ec-body">
                            <ul>
                                <!-- Start Single Contact List -->
                                <li>
                                    <a class="ec-list" data-number="593967402331"
                                        data-message="¡Hola! Necesito ayuda en un pedido ">
                                        <div class="d-flex bd-highlight">
                                            <!-- Profile Picture -->
                                            <div class="ec-img-cont">
                                                <img loading='lazy' src="{{url('assets/images/favicon/logo_ibizza_verde.svg')}}"
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
                                <!-- Start Single Contact List -->
                                <li>
                                    <a class="ec-list" data-number="593967402331"
                                        data-message="¡Hola! Necesito ayuda en un pedido ">
                                        <div class="d-flex bd-highlight">
                                            <!-- Profile Picture -->
                                            <div class="ec-img-cont">
                                                <img loading='lazy' src="{{url('assets/images/favicon/logo_ibizza_verde.svg')}}"
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
                    <!-- Start Right Floating Button-->
                    <div class="ec-right-bottom">
                        <div class="ec-box">
                            <div class="ec-button rotateBackward">
                                <img loading='lazy' class="whatsapp" src="{{url('assets/images/common/whatsapp.png')}}" alt="whatsapp icon">
                            </div>
                        </div>
                    </div>
                    <!--/ End Right Floating Button-->
                </div>
                <!-- Whatsapp end -->

                <!-- Feature tools -->

                <!-- Feature tools end -->

                <!-- Vendor JS -->
                <script src="{{url('assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
                <script src="{{url('assets/js/vendor/popper.min.js')}}"></script>
                <script src="{{url('assets/js/vendor/bootstrap.min.js')}}"></script>
                <script src="{{url('assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
                <script src="{{url('assets/js/vendor/modernizr-3.11.2.min.js')}}"></script>

                <!--Plugins JS-->
                <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script src="{{url('assets/js/plugins/swiper-bundle.min.js')}}"></script>
                <script src="{{url('assets/js/plugins/countdownTimer.min.js')}}"></script>
                <script src="{{url('assets/js/plugins/scrollup.js')}}"></script>
                <script src="{{url('assets/js/plugins/jquery.zoom.min.js')}}"></script>
                <script src="{{url('assets/js/plugins/slick.min.js')}}"></script>
                <script src="{{url('assets/js/plugins/infiniteslidev2.js')}}"></script>
                <script src="{{url('assets/js/vendor/jquery.magnific-popup.min.js')}}"></script>
                <script src="{{url('assets/js/plugins/jquery.sticky-sidebar.js')}}"></script>

                <!-- Main Js -->
                <script src="{{url('assets/js/vendor/index.js')}}"></script>
                <script src="{{url('assets/js/main.js')}}"></script>
                <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
                <script>
                    var path = "{{ route('web.autocompletar') }}";
                    $('.txt_search').autocomplete({
                        source: function(request, response) {
                            $.getJSON(path, {
                                    term: request.term
                                },
                                response
                            );
                        },
                        focus: function(event, ui) {
                            $(".txt_search").val(ui.item.value);
                            return false;
                        },
                        minLength: 1,
                        select: function(event, ui) {
                            let url = "{{ route('web.detalle-producto', ':id') }}";
                            url = url.replace(':id', ui.item.estilo);
                            document.location.href = url;
                            //get_datos_afiliado(ui.item.data);
                            //console.log('You selected: ' + ui.item.value + ', ' + ui.item.data);
                        }
                    }).autocomplete("instance")._renderItem = function(ul, item) {
                        if (item.value) {
                            let image = 'https://www.blackwallst.directory/images/NoImageAvailable.png';
                            if (item.imagen_path != '' && item.imagen_path != null) {
                                image = '/storage/images/productos/' + item.imagen_path
                            }
                            return $("<li>").append("<div><img src='" + image +
                                    "' class='rounded p-2' width='50' height='50' /><span>" + item.value + "</span></div>")
                                .appendTo(ul);
                        } else {
                            return $("<li class='ui-state-disabled'>").append("<div>Produco no encontrado</div>").appendTo(ul);
                        }

                    };
                </script>
                @stack('js')
                @livewireScripts
            </body>

            </html>
