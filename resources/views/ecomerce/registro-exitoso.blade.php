<x-plantilla>
    @section('title', 'Registro')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Registro de Empresaria</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{route('web')}}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Registro</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->
    <!-- Start Register -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="px-4 py-5 my-5 text-center">
                    <img class="d-block mx-auto mb-4" src="{{url('assets/images/favicon/logo_dpisar.svg')}}" alt="logo ibizza verde" width="120rem" height="80rem">
                    <h1 class="display-5 fw-bold">Gracias por Registrate</h1>
                    <div class="col-lg-6 mx-auto">
                      <p class="lead mb-4">Tu ultimo paso para formar parte de las empresarias de <b>D'PISAR venta por catálogo</b> es verificar en tu correo tu contraseña temporal para poder ingresar y realizar los pedidos que desees.</p>
                      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a type="button" href="{{route('login')}}"  class="btn btn-primary btn-lg px-4 gap-3">Iniciar Sesión</a>
                        <a type="button" href="{{route('web')}}" class="btn btn-outline-secondary btn-lg px-4">Inicio</a>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </section>
    <!-- End Register -->
</x-plantilla>