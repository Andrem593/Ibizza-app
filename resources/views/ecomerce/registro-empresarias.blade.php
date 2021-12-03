<x-plantilla>
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
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Registro de Empresaria</h2>
                        <h2 class="ec-title">Registro de Empresaria</h2>
                        <p class="sub-title mb-3">Estas a pocos paso de convertirte en una empresaria de ibizza</p>
                    </div>
                </div>
                <div class="ec-register-wrapper">
                    <div class="ec-register-container">
                        <div class="ec-register-form">
                            <form action="{{route('web.registrar-empresaria-nueva')}}" method="POST"> 
                                @csrf                               
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Nombres*</label>
                                    <input type="text" name="nombres" placeholder="Ingrese sus nombres" value="{{old('nombres')}}" required />
                                    {!! $errors->first('nombres', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Apellidos*</label>
                                    <input type="text" name="apellidos" placeholder="Ingrese sus apellidos" value="{{old('apellidos')}}" required />
                                    {!! $errors->first('apellidos', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Cedula*</label>
                                    <input type="number" name="cedula" placeholder="Ingrese su número de identificación" value="{{old('cedula')}}" />
                                    {!! $errors->first('cedula', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Fecha Nacimiento*</label>
                                    <input type="date" name="fecha_nacimiento" placeholder="Ingrese su fecha de nacimiento" value="{{old('fecha_nacimiento')}}" />
                                    {!! $errors->first('fecha_nacimiento', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Correo*</label>
                                    <input type="email" name="email" placeholder="ingrese su correo..." required value="{{old('email')}}" />
                                    {!! $errors->first('email', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Teléfono*</label>
                                    <input type="number" name="telefono" value="{{old('telefono')}}" placeholder="Ingrese su numero de contacto"
                                        required />
                                    {!! $errors->first('telefono', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                <span class="ec-register-wrap">
                                    <label>Dirección domicilio</label>
                                    <input type="text" name="direccion" value="{{old('direccion')}}" placeholder="Ingrese su direccción" />
                                    {!! $errors->first('direccion', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                <span class="ec-register-wrap">
                                    <label>Referencia domicilio</label>
                                    <input type="text" name="referencia" value="{{old('referencia')}}" placeholder="Ingrese una referencia de su domicilio" />
                                    {!! $errors->first('referencia', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Provincia *</label>
                                    <span class="ec-rg-select-inner">
                                        <select name="provincia" id="provincia" class="ec-register-select">
                                            <option selected disabled>Provincia</option>
                                            @foreach ($provincias as $provincia )
                                                <option value="{{$provincia->id}}">{{$provincia->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                    {!! $errors->first('provincia', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>
                                
                                <span class="ec-register-wrap ec-register-half">
                                    <label>Ciudad *</label>
                                    <span class="ec-rg-select-inner">
                                        <select name="ciudad" id="ciudad"
                                            class="ec-register-select">
                                            <option selected disabled>Ciudad</option>
                                        </select>
                                    </span>
                                    {!! $errors->first('ciudad', '<p class="text-danger mb-1 mt-0">:message</p>') !!}
                                </span>                                
                                <span class="ec-register-wrap ec-register-btn">
                                    <button class="btn btn-primary" type="submit">Registro</button>
                                </span>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Register -->
    @push('js')
        <script>
            $('body').addClass('register_page');
            $(document).on('change', '#provincia', function(){
                $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                $.post({
                    url: "{{ route('web.consutar-ciudad') }}",
                    data: {
                        'id_provincia' : $('#provincia').val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response != null) {
                            $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                            $.each(response, function(i, val){
                                $('#ciudad').append('<option value="'+ val['id'] +'">' + val['descripcion'] +'</option>')
                            });
                        }
                    }
                });
            });

            $(document).ready(function() {
                $('form').submit(function(event) {
                    if ($(this).hasClass('submitted')) {
                        $(this).find(':submit').html('Registro');
                        $(this).find(':submit').attr("disabled", false);
                        event.preventDefault();
                    } else {
                        $(this).find(':submit').attr("disabled", true);
                        $(this).find(':submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Registrando...');
                        $(this).addClass('submitted');
                    }
                });
            });
        </script>
    @endpush
</x-plantilla>