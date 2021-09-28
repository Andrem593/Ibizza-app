<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    {{-- CDN fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
        integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>IBIZZA | Sitio Oficial </title>
</head>

<body>
    <div class="container p-2">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="/img/logo_ibizza.png" alt="" width="120" height="35">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Ofertas</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Categorias
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">categoria 1</a></li>
                                <li><a class="dropdown-item" href="#">categoria 1</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">categoria 1</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled">Regalos</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscas un producto.."
                                aria-label="Recipient's username" aria-describedby="search">
                            <span class="input-group-text" id="search"><i class="fas fa-search"></i></span>
                        </div>
                    </form>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle position-relative mx-1" type="button"
                            id="elementos_car" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-shopping-cart"></i>
                            <span
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                2
                            </span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="elementos_car">
                            <li><a class="dropdown-item" href="#">Producto 1</a></li>
                            <li><a class="dropdown-item" href="#">Producto 2</a></li>
                        </ul>
                    </div>
                    @if (Route::has('login'))
                        <div class="">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-dark mx-1">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-dark mx-1"><i class="fas fa-user"></i></a>
                        @endif
                    </div>
                    @endif
                </div>
        </div>
        </nav>
        </div>
        <div>
            <div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel" height="50vh">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="8000">
                        <img src="/img/carrousel/banner_ibizza.png" class="img-fluid" alt="..."
                            style="width: 100%; height: 50vh;">
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                        <img src="/img/carrousel/banner_ibizza2.png" class="img-fluid" alt="..."
                            style="width: 100%; height: 50vh;">
                    </div>
                    <div class="carousel-item">
                        <img src="/img/carrousel/banner_ibizza2.png" class="img-fluid" alt="..."
                            style="width: 100%; height: 50vh;">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="container">
                <h2 class="text-center p-4">PROMOCIONES DE LA SEMANA</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4 my-2">
                    <div class="col">
                        <div class="card h-100">
                            <img src="/img/carrousel/carrousel-1.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                    to additional content. This content is a little bit longer.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <img src="/img/carrousel/carrousel-2.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a short card.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <img src="/img/carrousel/carrousel-3.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                    to additional content.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100">
                            <img src="/img/carrousel/carrousel-1.jpg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                    to additional content. This content is a little bit longer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <footer class="py-5">
                    <div class="row">
                        <div class="col-2">
                            <h5>Section</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                            </ul>
                        </div>

                        <div class="col-2">
                            <h5>Section</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                            </ul>
                        </div>

                        <div class="col-2">
                            <h5>Section</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Home</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Features</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">Pricing</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">FAQs</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-muted">About</a></li>
                            </ul>
                        </div>

                        <div class="col-4 offset-1">
                            <form>
                                <img src="/img/logo_ibizza.png" alt="" width="240" height="75" class="mb-2">
                                <h5>Subscribe to our newsletter</h5>
                                <p>Monthly digest of whats new and exciting from us.</p>
                                <div class="d-flex w-100 gap-2">
                                    <label for="newsletter1" class="visually-hidden">Email address</label>
                                    <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                                    <button class="btn btn-primary" type="button">Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between py-4 my-4 border-top">
                        <p class="w-50">© 2021 Ibizza, All rights reserved.</p>
                        <ul class="list-unstyled d-flex justify-content-end w-50 me-4">
                            <li class="ms-3"><a class="link-dark" href="#"><i class="fab fa-twitter fs-3"></i></a></li>
                            <li class="ms-3"><a class="link-dark" href="#"><i class="fab fa-instagram fs-3"></i></a></li>
                            <li class="ms-3"><a class="link-dark" href="#"><i class="fab fa-facebook fs-3"></i></li>
                        </ul>
                    </div>
                </footer>
            </div>
        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
        </script>
    </body>

    </html>

    {{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito';
            background: #f7fafc;
        }
    </style>
</head>
<body>
    <div class="container-fluid fixed-top p-4">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                @if (Route::has('login'))
                    <div class="">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-muted">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-muted">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ms-4 text-muted">Registrate</a>
                            @endif
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container-fluid my-5 pt-5 px-5">
        <div class="row justify-content-center px-4">
            <div class="col-md-12 col-lg-9">
                <svg viewBox="0 0 651 192" fill="none" xmlns="http://www.w3.org/2000/svg" class="my-4" style="width: 271px">
                    <g clip-path="url(#clip0)" fill="#EF3B2D">
                        <path d="M248.032 44.676h-16.466v100.23h47.394v-14.748h-30.928V44.676zM337.091 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 6.609 5.799 10.811 7.66 4.199 1.861 8.828 2.792 13.89 2.792 3.913 0 7.804-.955 11.669-2.863 3.866-1.908 6.849-4.533 8.949-7.875v9.021h15.607V78.182h-15.607v9.02zm-1.431 32.503c-.955 2.578-2.291 4.821-4.009 6.73-1.719 1.91-3.795 3.437-6.229 4.582-2.435 1.146-5.133 1.718-8.091 1.718-2.96 0-5.633-.572-8.019-1.718-2.387-1.146-4.438-2.672-6.156-4.582-1.719-1.909-3.032-4.152-3.938-6.73-.909-2.577-1.36-5.298-1.36-8.161 0-2.864.451-5.585 1.36-8.162.905-2.577 2.219-4.819 3.938-6.729 1.718-1.908 3.77-3.437 6.156-4.582 2.386-1.146 5.059-1.718 8.019-1.718 2.958 0 5.656.572 8.091 1.718 2.434 1.146 4.51 2.674 6.229 4.582 1.718 1.91 3.054 4.152 4.009 6.729.953 2.577 1.432 5.298 1.432 8.162-.001 2.863-.479 5.584-1.432 8.161zM463.954 87.202c-2.101-3.341-5.083-5.965-8.949-7.875-3.865-1.909-7.756-2.864-11.669-2.864-5.062 0-9.69.931-13.89 2.792-4.201 1.861-7.804 4.417-10.811 7.661-3.007 3.246-5.347 6.993-7.016 11.239-1.672 4.249-2.506 8.713-2.506 13.389 0 4.774.834 9.26 2.506 13.459 1.669 4.202 4.009 7.925 7.016 11.169 3.007 3.246 6.609 5.799 10.811 7.66 4.199 1.861 8.828 2.792 13.89 2.792 3.913 0 7.804-.955 11.669-2.863 3.866-1.908 6.849-4.533 8.949-7.875v9.021h15.607V78.182h-15.607v9.02zm-1.432 32.503c-.955 2.578-2.291 4.821-4.009 6.73-1.719 1.91-3.795 3.437-6.229 4.582-2.435 1.146-5.133 1.718-8.091 1.718-2.96 0-5.633-.572-8.019-1.718-2.387-1.146-4.438-2.672-6.156-4.582-1.719-1.909-3.032-4.152-3.938-6.73-.909-2.577-1.36-5.298-1.36-8.161 0-2.864.451-5.585 1.36-8.162.905-2.577 2.219-4.819 3.938-6.729 1.718-1.908 3.77-3.437 6.156-4.582 2.386-1.146 5.059-1.718 8.019-1.718 2.958 0 5.656.572 8.091 1.718 2.434 1.146 4.51 2.674 6.229 4.582 1.718 1.91 3.054 4.152 4.009 6.729.953 2.577 1.432 5.298 1.432 8.162 0 2.863-.479 5.584-1.432 8.161zM650.772 44.676h-15.606v100.23h15.606V44.676zM365.013 144.906h15.607V93.538h26.776V78.182h-42.383v66.724zM542.133 78.182l-19.616 51.096-19.616-51.096h-15.808l25.617 66.724h19.614l25.617-66.724h-15.808zM591.98 76.466c-19.112 0-34.239 15.706-34.239 35.079 0 21.416 14.641 35.079 36.239 35.079 12.088 0 19.806-4.622 29.234-14.688l-10.544-8.158c-.006.008-7.958 10.449-19.832 10.449-13.802 0-19.612-11.127-19.612-16.884h51.777c2.72-22.043-11.772-40.877-33.023-40.877zm-18.713 29.28c.12-1.284 1.917-16.884 18.589-16.884 16.671 0 18.697 15.598 18.813 16.884h-37.402zM184.068 43.892c-.024-.088-.073-.165-.104-.25-.058-.157-.108-.316-.191-.46-.056-.097-.137-.176-.203-.265-.087-.117-.161-.242-.265-.345-.085-.086-.194-.148-.29-.223-.109-.085-.206-.182-.327-.252l-.002-.001-.002-.002-35.648-20.524a2.971 2.971 0 00-2.964 0l-35.647 20.522-.002.002-.002.001c-.121.07-.219.167-.327.252-.096.075-.205.138-.29.223-.103.103-.178.228-.265.345-.066.089-.147.169-.203.265-.083.144-.133.304-.191.46-.031.085-.08.162-.104.25-.067.249-.103.51-.103.776v38.979l-29.706 17.103V24.493a3 3 0 00-.103-.776c-.024-.088-.073-.165-.104-.25-.058-.157-.108-.316-.191-.46-.056-.097-.137-.176-.203-.265-.087-.117-.161-.242-.265-.345-.085-.086-.194-.148-.29-.223-.109-.085-.206-.182-.327-.252l-.002-.001-.002-.002L40.098 1.396a2.971 2.971 0 00-2.964 0L1.487 21.919l-.002.002-.002.001c-.121.07-.219.167-.327.252-.096.075-.205.138-.29.223-.103.103-.178.228-.265.345-.066.089-.147.169-.203.265-.083.144-.133.304-.191.46-.031.085-.08.162-.104.25-.067.249-.103.51-.103.776v122.09c0 1.063.568 2.044 1.489 2.575l71.293 41.045c.156.089.324.143.49.202.078.028.15.074.23.095a2.98 2.98 0 001.524 0c.069-.018.132-.059.2-.083.176-.061.354-.119.519-.214l71.293-41.045a2.971 2.971 0 001.489-2.575v-38.979l34.158-19.666a2.971 2.971 0 001.489-2.575V44.666a3.075 3.075 0 00-.106-.774zM74.255 143.167l-29.648-16.779 31.136-17.926.001-.001 34.164-19.669 29.674 17.084-21.772 12.428-43.555 24.863zm68.329-76.259v33.841l-12.475-7.182-17.231-9.92V49.806l12.475 7.182 17.231 9.92zm2.97-39.335l29.693 17.095-29.693 17.095-29.693-17.095 29.693-17.095zM54.06 114.089l-12.475 7.182V46.733l17.231-9.92 12.475-7.182v74.537l-17.231 9.921zM38.614 7.398l29.693 17.095-29.693 17.095L8.921 24.493 38.614 7.398zM5.938 29.632l12.475 7.182 17.231 9.92v79.676l.001.005-.001.006c0 .114.032.221.045.333.017.146.021.294.059.434l.002.007c.032.117.094.222.14.334.051.124.088.255.156.371a.036.036 0 00.004.009c.061.105.149.191.222.288.081.105.149.22.244.314l.008.01c.084.083.19.142.284.215.106.083.202.178.32.247l.013.005.011.008 34.139 19.321v34.175L5.939 144.867V29.632h-.001zm136.646 115.235l-65.352 37.625V148.31l48.399-27.628 16.953-9.677v33.862zm35.646-61.22l-29.706 17.102V66.908l17.231-9.92 12.475-7.182v33.841z"/>
                    </g>
                </svg>

                <div class="card shadow-sm">
                    <div class="row">
                        <div class="col-md-6 pr-0">
                            <div class="card-body border-right border-bottom p-3 h-100">
                                <div class="d-flex flex-row bd-highlight pt-2">
                                    <div>
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="text-muted" width="32"><path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    <div class="pl-3">
                                        <div class="mb-2">
                                            <a href="https://laravel.com/docs" class="h5 font-weight-bolder text-dark">Documentation</a>
                                        </div>
                                        <p class="text-muted small">
                                            Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience with Laravel, we recommend reading all of the documentation from beginning to end.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pl-0">
                            <div class="card-body border-bottom p-3 h-100">
                                <div class="d-flex flex-row bd-highlight pt-2">
                                    <div>
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="text-muted" width="32"><path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div class="pl-3">
                                        <div class="mb-2">
                                            <a href="https://laracasts.com" class="h5 font-weight-bolder text-dark">Laracasts</a>
                                        </div>
                                        <p class="text-muted small">
                                            Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pr-0">
                            <div class="card-body border-right p-3 h-100">
                                <div class="d-flex flex-row bd-highlight pt-2">
                                    <div>
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="text-muted" width="32"><path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                    </div>
                                    <div class="pl-3 text-sm">
                                        <div class="mb-2">
                                            <a href="https://laravel-news.com/" class="h5 font-weight-bolder text-dark">Laravel News</a>
                                        </div>
                                        <p class="text-muted small">
                                            Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 pl-0">
                            <div class="card-body p-3 h-100">
                                <div class="d-flex flex-row bd-highlight pt-2">
                                    <div>
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="text-muted" width="32"><path d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div class="pl-3">
                                        <div class="mb-2">
                                            <span class="h5 font-weight-bolder text-dark">Vibrant Ecosystem</span>
                                        </div>
                                        <p class="text-muted small">
                                            Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com" class="text-muted">Forge</a>, <a href="https://vapor.laravel.com" class="text-muted">Vapor</a>, <a href="https://nova.laravel.com" class="text-muted">Nova</a>, and <a href="https://envoyer.io" class="text-muted">Envoyer</a> help you take your projects to the next level. Pair them with powerful open source libraries like <a href="https://laravel.com/docs/billing" class="text-muted">Cashier</a>, <a href="https://laravel.com/docs/dusk" class="text-muted">Dusk</a>, <a href="https://laravel.com/docs/broadcasting" class="text-muted">Echo</a>, <a href="https://laravel.com/docs/horizon" class="text-muted">Horizon</a>, <a href="https://laravel.com/docs/sanctum" class="text-muted">Sanctum</a>, <a href="https://laravel.com/docs/telescope" class="text-muted">Telescope</a>, and more.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <div class="text-sm text-muted">
                        <div class="flex align-content-center">
                            <svg fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="text-muted" style="width: 18px">
                                <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>

                            <a href="https://laravel.bigcartel.com" class="text-muted">
                                Shop
                            </a>

                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="ml-4 text-muted" style="width: 18px">
                                <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>

                            <a href="https://github.com/sponsors/taylorotwell" class="text-muted">
                                Sponsor
                            </a>
                        </div>
                    </div>

                    <div class="text-sm text-muted">
                        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> --}}
