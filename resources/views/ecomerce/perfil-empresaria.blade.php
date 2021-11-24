<x-plantilla>
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
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Home</a></li>
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
                        <x-lista-rutas-usuarios/>
                    </div>
                </div>
                <div class="ec-shop-rightside col-lg-9 col-md-12">
                    <div class="ec-vendor-dashboard-card ec-vendor-setting-card">
                        <div class="ec-vendor-card-body">
                            <div class="row">
                                <div class="col-md-12">
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
                                                <h5 class="name">{{ $empresaria->nombres . ' ' . $empresaria->apellidos }}
                                                </h5>
                                                <p>( Empresaria )</p>
                                            </div>
                                            <p>Hola <span>{{ $empresaria->nombres . ' ' . $empresaria->apellidos }}!</span>
                                            </p>
                                            <p>Desde tu cuenta, podras ver y realizar un seguimiento a todos los pedidos
                                                fácilmente. Puedes administrar
                                                y cambiar la información de tu cuenta, como la dirección, email,
                                                telefonos y podras ver todo el
                                                historial de tus pedidos.</p>
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
                                                        <li><strong>Celular : </strong>{{ $empresaria->telefono }}</li>
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
                                                        <li><strong>Provincia : </strong>{{ $empresaria->nombre_provincia }}</li>
                                                        <li><strong>Ciudad : </strong>{{ $empresaria->nombre_ciudad }}</li>
                                                        <li><strong>Dirección : </strong>{{ $empresaria->direccion }}</li>
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
                                                        <li><strong>Nombre Vendedor : </strong>{{$empresaria->nombre_vendedor}}</li>
                                                        <li><strong>Contacto : </strong>{{$empresaria->correo_vendedor}}</li>
                                                    </ul>
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
                                    <div class="thumb-edit">
                                        <input type='file' id="thumbUpload02" class="ec-image-upload"
                                            accept=".png, .jpg, .jpeg" />
                                        <label><img src="assets/images/icons/edit.svg" class="svg_img header_svg"
                                                alt="edit" /></label>
                                    </div>
                                    <div class="thumb-preview ec-preview">
                                        <div class="image-thumb-preview">
                                            <img class="image-thumb-preview ec-image-preview v-img"
                                                src="{{Auth::user()->profile_photo_url}}" alt="edit" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ec-vendor-upload-detail">
                                <form class="row g-3">
                                    <div class="col-md-6 space-t-15">
                                        <label class="form-label">Nombres</label>
                                        <input type="text" class="form-control" value="{{$empresaria->nombres}}">
                                    </div>
                                    <div class="col-md-6 space-t-15">
                                        <label class="form-label">Apellidos</label>
                                        <input type="text" class="form-control" value="{{$empresaria->apellidos}}">
                                    </div>
                                    <div class="col-md-12 space-t-15">
                                        <label class="form-label">Direccion</label>
                                        <input type="text" class="form-control" value="{{$empresaria->direccion}}">
                                    </div>
                                    <div class="col-md-12 space-t-15">
                                        <label class="form-label">Telefono</label>
                                        <input type="text" class="form-control" value="{{$empresaria->telefono}}">
                                    </div>
                                    <div class="col-md-12 space-t-15">
                                        <label class="form-label">Correo</label>
                                        <input type="text" class="form-control" value="{{Auth::user()->email}}">
                                    </div>                                    
                                    <div class="col-md-12 space-t-15">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="#" class="btn btn-lg btn-secondary qty_close" data-bs-dismiss="modal"
                                            aria-label="Close">Close</a>
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
    @push('js')
        <script>
            $('body').addClass('shop_page')
        </script>
    @endpush
</x-plantilla>
