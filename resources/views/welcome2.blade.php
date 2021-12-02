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
     <link rel="apple-touch-icon" href="assets/images/favicon/Logo_ibizza.svg" />
     <meta name="msapplication-TileImage" content="assets/images/favicon/Logo_ibizza.svg" />

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
                             @if (!empty($catalogos))
                                 <span>
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
                                         src="assets/images/icons/user.svg" class="svg_img header_svg"
                                         alt="" /></button>
                                 <ul class="dropdown-menu dropdown-menu-right">
                                     @if (Route::has('login'))

                                         @auth
                                             @can('dashboard')
                                                 <li> <a href="{{ url('/dashboard') }}" class="dropdown-item">Dashboard</a>
                                                 </li>
                                             @else
                                                 <li> <a href="{{ route('web.perfil-empresaria') }}"
                                                         class="dropdown-item">Perfil</a></li>
                                             @endcan
                                             <form action="{{ route('logout') }}" method="POST">
                                                 @csrf
                                                 <button type="submit" class="dropdown-item">cerrar sesión</button>
                                             </form>
                                             <li><a class="dropdown-item" href="{{ route('web.checkout') }}">Checkout</a>
                                             </li>
                                         @else
                                             <li><a href="{{ route('login') }}" class="dropdown-item">Login</a></li>
                                             <li><a class="dropdown-item" href="register.html">Registrar</a></li>
                                             <li><a class="dropdown-item" href="{{ route('web.checkout') }}">Checkout</a>
                                             </li>
                                         @endif
                                         @endif
                                     </ul>
                                 </div>
                                 <!-- Header User End -->
                                 <!-- Header Cart Start -->
                                 <a href="#" class="ec-header-btn ec-header-wishlist">
                                     <div class="header-icon"><img loading='lazy' src="assets/images/icons/wishlist.svg"
                                             class="svg_img header_svg" alt="" /></div>
                                     <span class="ec-header-count">0</span>
                                 </a>
                                 <!-- Header Cart End -->
                                 <!-- Header Cart Start -->
                                 <a href="#ec-side-cart" class="ec-header-btn ec-side-toggle">
                                     <div class="header-icon"><img loading='lazy' src="assets/images/icons/cart.svg"
                                             class="svg_img header_svg" alt="" /></div>
                                     <span class="ec-header-count cart-count-lable">{{ Cart::count() }}</span>
                                 </a>
                                 <!-- Header Cart End -->
                                 <!-- Header menu Start -->
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
             <!-- Ec Header Bottom  Start -->
             <div class="ec-header-bottom d-none d-lg-block">
                 <div class="container position-relative">
                     <div class="row">
                         <div class="ec-flex">
                             <!-- Ec Header Logo Start -->
                             <div class="align-self-center">
                                 <div class="header-logo">
                                     <a href="{{ url('/') }}"><img loading='lazy' class="p-1"
                                             src="assets/images/logo/logo_ibizza.svg" alt="Logo Ibizza" />
                                         <img loading='lazy' class="dark-logo" src="assets/images/logo/dark-logo.png"
                                             alt="Site Logo" style="display: none;" /></a>
                                 </div>
                             </div>
                             <!-- Ec Header Logo End -->

                             <!-- Ec Header Search Start -->
                             <div class="align-self-center">
                                 <div class="header-search">
                                     <form class="ec-btn-group-form" action="#">
                                         <input class="form-control txt_search"
                                             placeholder="Ingresa el nombre de un Producto..." type="text">
                                         <button class="submit" type="submit"><img loading='lazy'
                                                 src="assets/images/icons/search.svg" class="svg_img header_svg"
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
                                                             href="{{ route('web.checkout') }}">Checkout</a></li>
                                                 @else
                                                     <li><a href="{{ route('login') }}" class="dropdown-item">Login</a></li>
                                                     <li><a class="dropdown-item" href="register.html">Registro</a></li>
                                                     <li><a class="dropdown-item"
                                                             href="{{ route('web.checkout') }}">Checkout</a></li>
                                                 @endif
                                                 @endif
                                             </ul>
                                         </div>
                                         <!-- Header User End -->
                                         <!-- Header wishlist Start -->
                                         <a href="#" class="ec-header-btn ec-header-wishlist">
                                             <div class="header-icon"><img loading='lazy'
                                                     src="assets/images/icons/wishlist.svg" class="svg_img header_svg" alt="" />
                                             </div>
                                             <span class="ec-header-count">0</span>
                                         </a>
                                         <!-- Header wishlist End -->
                                         <!-- Header Cart Start -->
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
                 <!-- Header responsive Bottom  Start -->
                 <div class="ec-header-bottom d-lg-none">
                     <div class="container position-relative">
                         <div class="row ">

                             <!-- Ec Header Logo Start -->
                             <div class="col">
                                 <div class="header-logo">
                                     <a href="index.html"><img loading='lazy' src="assets/images/logo/logo_ibizza.svg"
                                             alt="Logo Ibizza" /><img loading='lazy' class="dark-logo"
                                             src="assets/images/logo/dark-logo.png" alt="Site Logo"
                                             style="display: none;" /></a>
                                 </div>
                             </div>
                             <!-- Ec Header Logo End -->
                             <!-- Ec Header Search Start -->
                             <div class="col">
                                 <div class="header-search">
                                     <form class="ec-btn-group-form" action="#">
                                         <input class="form-control txt_search"
                                             placeholder="Ingresa el nombre de un Producto..." type="text">
                                         <button class="submit" type="submit"><img loading='lazy'
                                                 src="assets/images/icons/search.svg" class="svg_img header_svg"
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
                                             <ul class="mega-menu d-block">
                                                 <li class="d-flex">
                                                     @empty(!$productos_mujer)
                                                         <ul class="d-block">
                                                             <li class="menu_title"><a href="javascript:void(0)">Mujeres</a>
                                                             </li>
                                                             @for ($i = 0; $i < 5; $i++)
                                                                 @empty($productos_mujer[$i]->estilo)
                                                                 @break
                                                             @endempty
                                                             <li><a
                                                                     href="{{ route('web.detalle-producto', $productos_mujer[$i]->estilo) }}">{{ $productos_mujer[$i]->nombre_mostrar . ' ' . $productos_mujer[$i]->estilo }}</a>
                                                             </li>
                                                             @endfor
                                                         </ul>
                                                     @endempty
                                                     @empty(!$productos_hombres)
                                                         <ul class="d-block">
                                                             <li class="menu_title"><a href="javascript:void(0)">Hombres</a>
                                                             </li>
                                                             @for ($i = 0; $i < 5; $i++)
                                                                 @empty($productos_hombres[$i]->estilo)
                                                                 @break
                                                             @endempty
                                                             <li><a
                                                                     href="{{ route('web.detalle-producto', $productos_hombres[$i]->estilo) }}">{{ $productos_hombres[$i]->nombre_mostrar . ' ' . $productos_hombres[$i]->estilo }}</a>
                                                             </li>
                                                             @endfor
                                                         </ul>
                                                     @endempty
                                                     @empty(!$productos_niños)
                                                         <ul class="d-block">
                                                             <li class="menu_title"><a href="javascript:void(0)">Niños</a></li>
                                                             @for ($i = 0; $i < 5; $i++)
                                                                 @empty($productos_niños[$i]->estilo)
                                                                 @break
                                                             @endempty
                                                             @if ($productos_niños[$i]->categoria == 'Niños')
                                                                 <li><a
                                                                         href="{{ route('web.detalle-producto', $productos_niños[$i]->estilo) }}">{{ $productos_niños[$i]->nombre_mostrar . ' ' . $productos_niños[$i]->estilo }}</a>
                                                                 </li>
                                                             @endif
                                                             @endfor
                                                         </ul>
                                                     @endempty
                                                     @empty(!$productos_niños)
                                                         <ul class="d-block">
                                                             <li class="menu_title"><a href="javascript:void(0)">Niñas</a>
                                                             </li>
                                                             @for ($i = 0; $i < 5; $i++)
                                                                 @empty($productos_niños[$i]->estilo)
                                                                 @break
                                                             @endempty
                                                             @if ($productos_niños[$i]->categoria == 'Niñas')
                                                                 <li><a
                                                                         href="{{ route('web.detalle-producto', $productos_niños[$i]->estilo) }}">{{ $productos_niños[$i]->nombre_mostrar . ' ' . $productos_niños[$i]->estilo }}</a>
                                                                 </li>
                                                             @endif
                                                             @endfor
                                                         </ul>
                                                     @endempty
                                                 </li>
                                                 <li>
                                                     <ul class="ec-main-banner w-100">
                                                         <li><a class="p-0"
                                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Mujer', 'productos.id']) }}"><img
                                                                     loading='lazy' class="img-responsive"
                                                                     src="assets/images/menu-banner/1.jpg" alt=""></a></li>
                                                         <li><a class="p-0"
                                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Hombre', 'productos.id']) }}"><img
                                                                     loading='lazy' class="img-responsive"
                                                                     src="assets/images/menu-banner/2.jpg" alt=""></a></li>
                                                         <li><a class="p-0"
                                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Niños', 'productos.id']) }}"><img
                                                                     loading='lazy' class="img-responsive"
                                                                     src="assets/images/menu-banner/3.jpg" alt=""></a></li>
                                                         <li><a class="p-0"
                                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Niñas', 'productos.id']) }}l"><img
                                                                     loading='lazy' class="img-responsive"
                                                                     src="assets/images/menu-banner/4.jpg" alt=""></a></li>
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
                                                 <li class="dropdown position-static"><a href="javascript:void(0)">Product
                                                         video
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
                                                 <li><a href="{{ route('web.sobre-nosotros') }}">Sobre Nosotros</a></li>
                                                 <li><a href="{{ route('web.contactanos') }}">Contáctenos</a></li>
                                                 <li><a href="cart.html">Cart</a></li>
                                                 <li><a href="{{ route('web.checkout') }}">Checkout</a></li>
                                                 <li><a href="compare.html">Compare</a></li>
                                                 <li><a href="{{ route('web.preguntas-frecuentes') }}">Preguntas</a></li>
                                                 <li><a href="login.html">Login</a></li>
                                                 <li><a href="register.html">Register</a></li>
                                                 <li><a href="track-order.html">Track Order</a></li>
                                                 <li><a href="{{ route('web.terminos-condiciones') }}">Términos y
                                                         Condiciones</a></li>
                                                 <li><a href="{{ route('web.politica-privacidad') }}">Política de
                                                         Privacidad</a></li>
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
                                 <li><a href="index.html">Home</a></li>
                                 <li><a href="javascript:void(0)">Categorias</a>
                                     <ul class="sub-menu">
                                         <li>
                                             <a
                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Mujer', 'productos.id']) }}">Mujeres</a>
                                         </li>
                                         <li>
                                             <a
                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Hombre', 'productos.id']) }}">Hombres</a>
                                         </li>
                                         <li>
                                             <a
                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Niños', 'productos.id']) }}">Niños</a>
                                         </li>
                                         <li>
                                             <a
                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Niñas', 'productos.id']) }}">Niñas</a>
                                         </li>
                                         <li><a class="p-0"
                                                 href="{{ route('web.tiendaOrderBy', ['categoria-Mujer', 'productos.id']) }}"><img
                                                     loading='lazy' class="img-responsive"
                                                     src="assets/images/menu-banner/1.jpg" alt=""></a>
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
                                         <li><a href="{{ route('web.sobre-nosotros') }}">Sobre Nosotros</a></li>
                                         <li><a href="{{ route('web.contactanos') }}">Contáctenos</a></li>
                                         <li><a href="cart.html">Cart</a></li>
                                         <li><a href="{{ route('web.checkout') }}">Checkout</a></li>
                                         <li><a href="compare.html">Compare</a></li>
                                         <li><a href="{{ route('web.preguntas-frecuentes') }}">Preguntas</a></li>
                                         <li><a href="login.html">Login</a></li>
                                         <li><a href="register.html">Register</a></li>
                                         <li><a href="track-order.html">Track Order</a></li>
                                         <li><a href="{{ route('web.terminos-condiciones') }}">Términos y Condiciones</a>
                                         </li>
                                         <li><a href="{{ route('web.politica-privacidad') }}">Política de Privacidad</a></li>
                                     </ul>
                                 </li>
                                 <li class="dropdown"><a href="{{ route('web.tienda') }}">Tienda</a>
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
             <!-- Header End  -->

             <!-- ibizza Cart Start -->
             <div class="ec-side-cart-overlay"></div>
             @livewire('ibizza-side-cart')
             <!-- ibizza Cart End -->

             <!-- Main Slider Start -->
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
                                             <h1 class="ec-slide-title">Conoce nuestro catalogo</h1>
                                             <h2 class="ec-slide-stitle">100% online</h2>
                                             <p>Puedes hacer tus pedidos en el momento que quieras y llegaran a la comodidad de
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
             <!-- Main Slider End -->

             <!-- Product tab Area Start -->
             <section class="section ec-product-tab section-space-p">
                 <div class="container">
                     <div class="row">
                         <div class="col-md-12 text-center">
                             <div class="section-title">
                                 <h2 class="ec-bg-title">Nuestra Colección</h2>
                                 <h2 class="ec-title">Nuestra Colección</h2>
                                 <p class="sub-title">Explora nuestro catalogo con los mejores productos</p>
                             </div>
                         </div>

                         <!-- Tab Start -->
                         <div class="col-md-12 text-center">
                             <ul class="ec-pro-tab-nav nav justify-content-center">
                                 <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                         href="#tab-pro-for-all">Todos</a></li>
                                 <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                         href="#tab-pro-for-men">Para
                                         Hombres</a></li>
                                 <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                         href="#tab-pro-for-women">Para
                                         Mujeres</a></li>
                                 <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                         href="#tab-pro-for-child">Para
                                         Niños</a></li>
                             </ul>
                         </div>
                         <!-- Tab End -->
                     </div>
                     <div class="row">
                         <div class="col">
                             <div class="tab-content">
                                 <!-- 1st Product tab start -->
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
                                 <!-- ec 2nd Product tab start -->
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
                                 <!-- ec 3rd Product tab start -->
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
                                 <!-- ec 4th Product tab start -->
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
             </section>
             <!-- ec Product tab Area End -->

             <!-- ec Banner Section Start || SECCION DE CATALOGO AM -->
             <section class="ec-banner section section-space-p">
                 <h2 class="d-none">Banner</h2>
                 <div class="container">
                     <!-- ec Banners Start -->
                     <div class="">
                         <!--ec Banner Start -->
                         <div class="d-flex justify-content-center">
                             <div class="row">
                                 @if ($catalogos->count() > 0)
                                     @foreach ($catalogos as $key => $catalogo)
                                         <div class="banner-block col margin-b-30"
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
                                                             Catalogo</a></span>
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
             @if (count($subcategorias) > 3)
             <!--  Category Section Start -->
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
                            <!--Category Nav Start -->
                            <div class="col-lg-3">
                                <ul class="ec-cat-tab-nav nav">
                                    @php
                                        $i = 1;
                                        $sub = [];
                                    @endphp
                                    @foreach ($subcategorias as $subcategoria)

                                        <li class="cat-item"><a class="cat-link" data-bs-toggle="tab"
                                                href="{{ '#tab-cat-' . $i++ }}">
                                                <div class="cat-icons"><img loading='lazy' class="cat-icon"
                                                        src="assets/images/icons/cat_4.png" alt="cat-icon"><img loading='lazy'
                                                        class="cat-icon-hover" src="assets/images/icons/cat_4_1.png"
                                                        alt="cat-icon">
                                                </div>
                                                <div class="cat-desc">
                                                    <span>{{ $subcategoria->subcategoria }}</span><span>{{ $subcategoria->cantidad_productos }}
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
                            <!--Category Tab Start -->
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
                                    <!-- 3rd Category tab start -->
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
                                    <!-- 4th Category tab start -->
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
             @endif

             <!--  Feature & Special Section Start -->

             @if (count($poco_stock) > 1 && count($descuentos) > 1)                 
                <section class="section ec-fre-spe-section section-space-p">
                    <div class="container">
                        <div class="row">
                            <!--  Feature Section Start -->
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
                                                        <a href="{{ route('web.detalle-producto', $value->estilo) }}"
                                                            class="image"><img loading='lazy' class="main-image"
                                                                src="storage/images/productos/{{ $value->imagen_path }}"
                                                                style="object-fit: cover" /></a>
                                                        <a href="#" class="quickview" data-link-action="quickview"
                                                            title="Quick view" data-bs-toggle="modal"
                                                            data-bs-target="#ec_quickview_modal"><img loading='lazy'
                                                                src="assets/images/icons/quickview.svg" class="svg_img pro_svg"
                                                                alt="" /></a>
                                                    </div>
                                                </div>
                                                <div class="ec-fs-pro-content col-lg-6 col-md-6 col-sm-6">
                                                    <h5 class="ec-fs-pro-title"><a
                                                            href="{{ route('web.detalle-producto', $value->estilo) }}">{{ $value->nombre_mostrar }}</a>
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
                                                            <span
                                                                class="new-price">${{ number_format($value->precio_empresaria - $value->precio_empresaria * ($value->descuento / 100), 2) }}</span>
                                                        @else
                                                            <span
                                                                class="new-price">${{ number_format($value->precio_empresaria, 2) }}</span>
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
                            <!--  Special Section Start -->
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
                                                        <a href="{{ route('web.detalle-producto', $value->estilo) }}"
                                                            class="image"><img loading='lazy' class="main-image"
                                                                src="storage/images/productos/{{ $value->imagen_path }}"
                                                                style="object-fit: cover" /></a>
                                                        <a href="#" class="quickview" data-link-action="quickview"
                                                            title="Quick view" data-bs-toggle="modal"
                                                            data-bs-target="#ec_quickview_modal"><img loading='lazy'
                                                                src="assets/images/icons/quickview.svg" class="svg_img pro_svg"
                                                                alt="" /></a>
                                                    </div>
                                                </div>
                                                <div class="ec-fs-pro-content col-lg-6 col-md-6 col-sm-6">
                                                    <h5 class="ec-fs-pro-title"><a
                                                            href="{{ route('web.detalle-producto', $value->estilo) }}">{{ $value->nombre_mostrar }}</a>
                                                    </h5>
                                                    <span class="ec-fs-rating-text"><span
                                                            class="badge rounded-pill bg-danger">Descuento del
                                                            {{ $value->descuento }}%</span></span>
                                                    <div class="ec-fs-price">
                                                        @empty(!$value->descuento)
                                                            <span class="old-price">${{ $value->precio_empresaria }}</span>
                                                            <span
                                                                class="new-price">${{ number_format($value->precio_empresaria - $value->precio_empresaria * ($value->descuento / 100), 2) }}</span>
                                                        @else
                                                            <span
                                                                class="new-price">${{ number_format($value->precio_empresaria, 2) }}</span>
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
             @endif
             <!-- Feature & Special Section End -->

             <!--  services Section Start -->
             <section class="section ec-services-section section-space-p">
                 <h2 class="d-none">Services</h2>
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

             <!--  offer Section Start -->
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
                             <a class="btn btn-primary" href="shop-left-sidebar-col-3.html"
                                 data-animation="zoomIn">Comprar</a>
                         </div>
                     </div>
                 </div>
             </section> --}}
             <!-- offer Section End -->

             <!-- New Product Start -->
             <section class="section ec-new-product section-space-p">
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
             </section>
             <!-- New Product end -->

             <!-- ec testmonial Start -->
             <section class="section ec-test-section section-space-ptb-100 section-space-m">
                 <div class="container">
                     <div class="row">
                         <div class="col-md-12 text-center">
                             <div class="section-title mb-0">
                                 <h2 class="ec-bg-title">Testimonios</h2>
                                 <h2 class="ec-title">Testimonios</h2>
                                 <p class="sub-title mb-3">¡Qué dice el cliente sobre nosotros?</p>
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

             <!-- Ec Brand Section Start -->
             <section class="section ec-brand-area section-space-p">
                 <h2 class="d-none">Brand</h2>
                 <div class="container">
                     <div class="row">
                         <div class="ec-brand-outer">
                             <ul id="ec-brand-slider">
                                 @foreach ($marcas as $marca)
                                     <li class="ec-brand-item" data-animation="zoomIn">
                                         <div class="ec-brand-img"><a href="#"><img loading='lazy' alt="brand" title="brand"
                                                     src="storage/images/marca/{{ $marca->imagen }}" /></a></div>
                                     </li>
                                 @endforeach
                             </ul>
                         </div>
                     </div>
                 </div>
             </section>
             <!-- Ec Brand Section End -->

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
                                                     src="assets/images/logo/logo_ibizza.svg" alt=""><img loading='lazy'
                                                     class="dark-footer-logo" src="assets/images/logo/dark-logo.png"
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
                                         <h4 class="ec-footer-heading">Información</h4>
                                         <div class="ec-footer-links">
                                             <ul class="align-items-center">
                                                 <li class="ec-footer-link"><a
                                                         href="{{ route('web.sobre-nosotros') }}">Sobre
                                                         Nosotros</a></li>
                                                 <li class="ec-footer-link"><a
                                                         href="{{ route('web.preguntas-frecuentes') }}">Preguntas</a></li>
                                                 <li class="ec-footer-link"><a href="track-order.html">Delivery
                                                         Information</a>
                                                 </li>
                                                 <li class="ec-footer-link"><a
                                                         href="{{ route('web.contactanos') }}">Contáctenos</a></li>
                                             </ul>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-sm-12 col-lg-2 ec-footer-account">
                                     <div class="ec-footer-widget">
                                         <h4 class="ec-footer-heading">Account</h4>
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
             <!-- Modal -->
             {{-- <div class="modal fade" id="ec_quickview_modal" tabindex="-1" role="dialog">
                 <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content">
                         <button type="button" class="btn-close qty_close" data-bs-dismiss="modal"
                             aria-label="Close"></button>
                         <div class="modal-body">
                             <div class="row">
                                 <div class="col-md-5 col-sm-12 col-xs-12">
                                     <!-- Swiper -->
                                     <div class="qty-product-cover">
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_1.jpg" alt="">
                                         </div>
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_2.jpg" alt="">
                                         </div>
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_3.jpg" alt="">
                                         </div>
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_4.jpg" alt="">
                                         </div>
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_5.jpg" alt="">
                                         </div>
                                     </div>
                                     <div class="qty-nav-thumb">
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_1.jpg" alt="">
                                         </div>
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_2.jpg" alt="">
                                         </div>
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_3.jpg" alt="">
                                         </div>
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_4.jpg" alt="">
                                         </div>
                                         <div class="qty-slide">
                                             <img loading='lazy' class="img-responsive"
                                                 src="assets/images/product-image/3_5.jpg" alt="">
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
                                                         <li><a href="#" class="ec-opt-sz" data-tooltip="Medium">M</a>
                                                         </li>
                                                         <li><a href="#" class="ec-opt-sz" data-tooltip="Large">X</a>
                                                         </li>
                                                         <li><a href="#" class="ec-opt-sz"
                                                                 data-tooltip="Extra Large">XL</a>
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
                                                         src="assets/images/icons/cart.svg" class="svg_img pro_svg" alt="" />
                                                     Add To Cart</button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div> --}}
             <!-- Modal end -->

             <!-- Newsletter Modal Start -->

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
                                 <!-- Start Single Contact List -->
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
                     <!-- Start Right Floating Button-->
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

                 <script type="text/javascript">
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


                     window.addEventListener('contentChanged', event => {

                         $('.qty-product-cover').slick('init');
                         $('.qty-nav-thumb').slick('init');
                         var QtyPlusMinus = $(".qty-plus-minus");
                         QtyPlusMinus.prepend('<div class="dec ec_qtybtn">-</div>');
                         QtyPlusMinus.append('<div class="inc ec_qtybtn">+</div>');

                     });

                     $('#ec_quickview_modal').on('hidden.bs.modal', function(e) {
                         $('#qv_modal').hide();
                         $('#qv_spinner').removeClass('d-none');
                     });
                     // CUENTA REGRESIVA DE TIMER
                     @isset($catalogo)
                         $("#ec-fs-count-1").countdowntimer({
                         startDate: "{{ str_replace('-', '/', date('Y-m-d')) . ' ' . date('h:i:s') }}",
                         dateAndTime: "{{ str_replace('-', '/', $catalogos[0]->fecha_fin_catalogo) . ' 00:00:00' }}",
                         labelsFormat: true,
                         displayFormat: "DHMS"
                         });
                     
                         $("#ec-fs-count-2").countdowntimer({
                         startDate: "{{ str_replace('-', '/', date('Y-m-d')) . ' ' . date('h:i:s') }}",
                         dateAndTime: "{{ str_replace('-', '/', $catalogos[0]->fecha_fin_catalogo) . ' 00:00:00' }}",
                         labelsFormat: true,
                         displayFormat: "DHMS"
                         });
                     
                         $("#ec-fs-count-3").countdowntimer({
                         startDate: "{{ str_replace('-', '/', date('Y-m-d')) . ' ' . date('h:i:s') }}",
                         dateAndTime: "{{ str_replace('-', '/', $catalogos[0]->fecha_fin_catalogo) . ' 00:00:00' }}",
                         labelsFormat: true,
                         displayFormat: "DHMS"
                         });
                     
                         $("#ec-fs-count-4").countdowntimer({
                         startDate: "{{ str_replace('-', '/', date('Y-m-d')) . ' ' . date('h:i:s') }}",
                         dateAndTime: "{{ str_replace('-', '/', $catalogos[0]->fecha_fin_catalogo) . ' 00:00:00' }}",
                         labelsFormat: true,
                         displayFormat: "DHMS"
                         });
                     @endisset
                 </script>

                 @stack('js')
                 @livewireScripts
             </body>

             </html>
