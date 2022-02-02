<x-plantilla>
    @section('title', 'Perfil Empresaria')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Perfil de Usuario</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Inicio</a></li>
                                <li class="ec-breadcrumb-item active">Perfil</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->
    <!-- User profile section -->
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
                    <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                        <div class="ec-vendor-card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    @if ($message = Session::get('success'))
                                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                        </symbol>
                                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                        </symbol>
                                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                        </symbol>
                                    </svg>
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                                            aria-label="Success:">
                                            <use xlink:href="#check-circle-fill" />
                                        </svg>
                                        <div>
                                            {{ $message }}
                                        </div>
                                    </div>
                                    @endif
                                    <div class="ec-vendor-block-profile">
                                        <div class="ec-vendor-block-img space-bottom-30">
                                            <div class="ec-vendor-block-bg">
                                                <a href="#" class="btn btn-lg btn-primary" data-link-action="editmodal"
                                                    title="Edit Detail" data-bs-toggle="modal"
                                                    data-bs-target="#edit_modal">Editar Perfil</a>
                                            </div>
                                            <div class="ec-vendor-block-detail">
                                                <img class="v-img" src="{{ Auth::user()->profile_photo_url }}"
                                                    alt="vendor image">
                                                <h5 class="name">
                                                    {{ $empresaria->nombres . ' ' . $empresaria->apellidos }}
                                                </h5>
                                                <p>( Empresaria )</p>
                                            </div>
                                            <p>Hola
                                                <span>{{ $empresaria->nombres . ' ' . $empresaria->apellidos }}!</span>
                                            </p>
                                            <p>Desde tu cuenta, podras ver y realizar un seguimiento a todos los pedidos
                                                fácilmente. Puedes administrar
                                                y cambiar la información de tu cuenta, como la dirección, email,
                                                telefonos y podras ver todo el
                                                historial de tus pedidos.</p>
                                            <div class="spinner-border text-primary" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                        <h5>Información de la cuenta</h5>

                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div
                                                    class="ec-vendor-detail-block ec-vendor-block-email space-bottom-30">
                                                    <h6>Correo Electronico <a href="javasript:void(0)"
                                                            data-link-action="editmodal" title="Edit Detail"
                                                            data-bs-toggle="modal" data-bs-target="#edit_modal"><img
                                                                src="assets/images/icons/edit.svg"
                                                                class="svg_img pro_svg" alt="edit" /></a></h6>
                                                    <ul>
                                                        <li><strong>e-mail : </strong>{{ Auth::user()->email }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div
                                                    class="ec-vendor-detail-block ec-vendor-block-contact space-bottom-30">
                                                    <h6>Teléfono Contacto<a href="javasript:void(0)"
                                                            data-link-action="editmodal" title="Edit Detail"
                                                            data-bs-toggle="modal" data-bs-target="#edit_modal"><img
                                                                src="assets/images/icons/edit.svg"
                                                                class="svg_img pro_svg" alt="edit" /></a></h6>
                                                    <ul>
                                                        <li><strong>Celular : </strong>{{ $empresaria->telefono }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="ec-vendor-detail-block ec-vendor-block-address mar-b-30">
                                                    <h6>Direccion<a href="javasript:void(0)"
                                                            data-link-action="editmodal" title="Edit Detail"
                                                            data-bs-toggle="modal" data-bs-target="#edit_modal"><img
                                                                src="assets/images/icons/edit.svg"
                                                                class="svg_img pro_svg" alt="edit" /></a></h6>
                                                    <ul>
                                                        <li><strong>Provincia :
                                                            </strong>{{ $empresaria->nombre_provincia }}</li>
                                                        <li><strong>Ciudad : </strong>{{ $empresaria->nombre_ciudad }}
                                                        </li>
                                                        <li><strong>Dirección : </strong>{{ $empresaria->direccion }}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                    <h6>Vendedor Asignado<a href="javasript:void(0)"
                                                            data-link-action="editmodal" title="Edit Detail"
                                                            data-bs-toggle="modal" data-bs-target="#edit_modal"><img
                                                                src="assets/images/icons/edit.svg"
                                                                class="svg_img pro_svg" alt="edit" /></a></h6>
                                                    <ul>
                                                        <li><strong>Nombre Vendedor :
                                                            </strong>{{ $empresaria->nombre_vendedor }}</li>
                                                        <li><strong>Contacto :
                                                            </strong>{{ $empresaria->correo_vendedor }}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mt-3">
                                                <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                    <h6>Dirección de Envio<a href="javasript:void(0)"
                                                            data-link-action="editmodal" title="Edit Detail"
                                                            data-bs-toggle="modal" data-bs-target="#edit_modal"><img
                                                                src="assets/images/icons/edit.svg"
                                                                class="svg_img pro_svg" alt="edit" /></a></h6>
                                                </div>
                                                <ul>
                                                    <li><strong>Dirección :
                                                        </strong>{{ $empresaria->direccion_envio }}</li>
                                                    <li><strong>referencia :
                                                        </strong>{{ $empresaria->referencia_envio }}</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mt-3">
                                                <div class="ec-vendor-detail-block ec-vendor-block-address">
                                                    <h6>Actualizar Contraseña<a href="javasript:void(0)"
                                                        data-bs-toggle="modal" data-bs-target="#modalPassword"><img
                                                                src="assets/images/icons/edit.svg"
                                                                class="svg_img pro_svg" alt="edit" /></a></h6>
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
    <!-- End User profile section -->
    <!-- Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="ec-vendor-block-img space-bottom-30">
                            <div class="ec-vendor-block-bg cover-upload">
                                <div class="thumb-upload">
                                    <div class="thumb-preview ec-preview">
                                        <div class="image-thumb-preview">
                                            <img class="image-thumb-preview ec-image-preview v-img"
                                                src="img/carrousel/banner_ibizza.jpg" alt="edit" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ec-vendor-block-detail">
                                <div class="thumb-upload">
                                    <form class="" action="{{ route('web.update-information-empresaria') }}"
                                        method="POST" enctype="multipart/form-data">
                                        <div class="thumb-edit">
                                            <input type='file' name="foto_perfil" id="thumbUpload02"
                                                class="ec-image-upload" accept=".png, .jpg, .jpeg" />
                                            <label><img src="assets/images/icons/edit.svg" class="svg_img header_svg"
                                                    alt="edit" /></label>
                                        </div>
                                        <div class="thumb-preview ec-preview">
                                            <div class="image-thumb-preview">
                                                <img class="image-thumb-preview ec-image-preview v-img"
                                                    src="{{ Auth::user()->profile_photo_url }}" alt="edit" />
                                            </div>
                                        </div>
                                </div>
                            </div>
                            <div class="ec-vendor-upload-detail row g-3">
                                @csrf
                                <input type="hidden" name="id_empresaria" value="{{ $empresaria->id }}">
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Nombres</label>
                                    <input type="text" name="nombres" class="form-control"
                                        value="{{ $empresaria->nombres }}">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control"
                                        value="{{ $empresaria->apellidos }}">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Direccion</label>
                                    <input type="text" name="direccion" class="form-control"
                                        value="{{ $empresaria->direccion }}">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Referencia de Domicilio</label>
                                    <input type="text" name="referencia" class="form-control"
                                        value="{{ $empresaria->referencia }}">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Dirección de Envio</label>
                                    <input type="text" name="direccion_envio" class="form-control"
                                        value="{{ $empresaria->direccion_envio }}">
                                </div>
                                <div class="col-md-6 space-t-15">
                                    <label class="form-label">Referencia de Envio</label>
                                    <input type="text" name="referencia_envio" class="form-control"
                                        value="{{ $empresaria->referencia_envio }}">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Telefono</label>
                                    <input type="text" name="telefono" id="telefono" class="form-control"
                                        value="{{ $empresaria->telefono }}">
                                </div>
                                <div class="col-md-12 space-t-15">
                                    <label class="form-label">Correo</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{ Auth::user()->email }}">
                                </div>
                
                                <div class="col-md-12 space-t-15">
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                    <a href="#" class="btn btn-lg btn-secondary qty_close" data-bs-dismiss="modal"
                                        aria-label="Close">Cerrar</a>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
    {{-- Modal de actualizacion de contraseña --}}
    <div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPass" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-body mx-auto">
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                        @livewire('profile.update-password-form')
                    @endif                 
                </div>
            </div>
        </div>
    </div>
    @push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"
        integrity="sha512-6Jym48dWwVjfmvB0Hu3/4jn4TODd6uvkxdi9GNbBHwZ4nGcRxJUCaTkL3pVY6XUQABqFo3T58EMXFQztbjvAFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#telefono').inputmask("999-999-9999", {
                "placeholder": ""
            });
            $('body').addClass('shop_page')

    </script>
    @endpush
</x-plantilla>