<x-plantilla>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Checkout</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Checkout</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-checkout-leftside col-lg-8 col-md-12 ">
                    <!-- checkout content Start -->
                    <div class="ec-checkout-content">
                        <div class="ec-checkout-inner">
                            @empty(Auth::user())
                                <div class="ec-checkout-wrap margin-bottom-30">
                                    <div class="ec-checkout-block ec-check-new">
                                        <h3 class="ec-checkout-title">Nuevo Cliente</h3>
                                        <div class="ec-check-block-content">
                                            <div class="ec-check-subtitle">Opciones Checkout</div>
                                            <form action="#">
                                                <span class="ec-new-option">
                                                    <span>
                                                        <input type="radio" id="account1" name="radio-group" checked>
                                                        <label for="account1">Registrarme como Empresaria</label>
                                                    </span>
                                                </span>
                                            </form>
                                            <div class="ec-new-desc">Si deseas ser parte de nuestras empresarias solo dale
                                                click al boton continuar para poder comunicarte
                                                con uno de nuestro asesores y puedas hacer tu primera compra.
                                            </div>
                                            <div class="ec-new-btn"><a href="#" class="btn btn-primary ec-list"
                                                    data-number="593967402331"
                                                    data-message="¡Hola! Quiero registrarme como empresaria">Continuar</a>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="ec-checkout-block ec-check-login">
                                        <h3 class="ec-checkout-title">Soy Cliente</h3>
                                        <div class="ec-check-login-form">
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <span class="ec-check-login-wrap">
                                                    <x-jet-label value="{{ __('Email') }}" />

                                                    <x-jet-input class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                                        type="email" name="email" :value="old('email')"
                                                        placeholder='Ingresa tu correo' required />
                                                    <x-jet-input-error for="email"></x-jet-input-error>
                                                </span>
                                                <span class="ec-check-login-wrap">
                                                    <x-jet-label value="{{ __('Password') }}" />

                                                    <x-jet-input
                                                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                                        type="password" name="password" placeholder='ingrese su contraseña'
                                                        required autocomplete="current-password" />
                                                    <x-jet-input-error for="password"></x-jet-input-error>
                                                </span>

                                                <span class="ec-check-login-wrap ec-check-login-btn">
                                                    <button class="btn btn-primary" type="submit">Login</button>
                                                    @if (Route::has('password.request'))
                                                        <a class="text-muted me-3" href="{{ route('password.request') }}">
                                                            {{ __('Olvidate tu contraseña?') }}
                                                        </a>
                                                    @endif
                                                </span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endempty
                            @if (!empty(Auth::user()))
                                @if (Auth::user()->role != 'Empresaria')
                                    <div class="ec-checkout-wrap margin-bottom-30">
                                        <div class="ec-checkout-block ec-check-new">
                                            <h3 class="ec-checkout-title">Asignación de Empresarias para vendedores</h3>
                                            <div class="ec-check-block-content">
                                                <div class="ec-check-subtitle">Escoge la empresaria</div>
                                                <div class="row mx-0">
                                                    <select id="tipo_busqueda" class="form-select my-auto">
                                                        <option value="cedula">CEDULA</option>
                                                        <option value="nombre">NOMBRES</option>
                                                    </select>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="search"
                                                            placeholder="Ingrese datos de empresaria">
                                                    </div>
                                                </div>
                                                <div class="ec-new-btn"><a id="asignarEmpresaria"
                                                        class="btn btn-primary">Continuar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                                <div class="ec-checkout-block ec-check-bill">
                                    <h3 class="ec-checkout-title">Detalles de Facturación</h3>
                                    <div class="ec-bl-block-content">
                                        <div class="ec-check-subtitle">Opciones de pago</div>
                                        <span class="ec-bill-option">
                                            <span>
                                                <input type="radio" id="bill1" name="radio-group" checked>
                                                <label for="bill1">Usar dirección existente</label>
                                            </span>
                                            <span>
                                                <input type="radio" id="bill2" name="radio-group">
                                                <label for="bill2">quiero usar una nueva direccion</label>
                                            </span>
                                        </span>
                                        <div class="ec-check-bill-form">
                                            <form id="form_datos" action="#" method="post">
                                                <span class="ec-bill-wrap">
                                                    <label>Número de identificacion</label>
                                                    <input type="number" id="cedula" name="cedula"
                                                        value="{{ $empresaria->cedula }}"
                                                        placeholder="Ingrese su número de cedula" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Nombres</label>
                                                    <input type="text" id="nombres" name="nombres"
                                                        value="{{ $empresaria->nombres }}"
                                                        placeholder="Ingrese sus nombres" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Apellidos</label>
                                                    <input type="text" id="apellidos" name="apellidos"
                                                        value="{{ $empresaria->apellidos }}"
                                                        placeholder="Ingrese sus apellidos" required />
                                                </span>
                                                <span class="ec-bill-wrap">
                                                    <label>Dirección</label>
                                                    <input type="text" id="direccion" name="direccion"
                                                        value="{{ $empresaria->direccion }}"
                                                        placeholder="ingrese la direccion de entrega del pedido"
                                                        required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Pais</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="pais" id="ec-select-country"
                                                            class="ec-bill-select" disabled>
                                                            <option selected disabled>ECUADOR</option>
                                                        </select>
                                                    </span>
                                                </span>
                                                @php
                                                    $ubicacion = DB::table('ciudades')
                                                        ->join('provincias', 'ciudades.provincia_id', '=', 'provincias.id')
                                                        ->select('ciudades.id', 'ciudades.descripcion as ciudad', 'provincias.descripcion as provincia', 'provincias.id as id_provincia')
                                                        ->where('ciudades.id', $empresaria->id_ciudad)
                                                        ->get();
                                                @endphp
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Provincia</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="provincia" id="provincia" class="ec-bill-select">
                                                            <option>
                                                                {{ !empty($ubicacion[0]) ? $ubicacion[0]->provincia : '' }}
                                                            </option>
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Ciudad</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="ciudad" id="ciudad" class="ec-bill-select">
                                                            <option>
                                                                {{ !empty($ubicacion[0]) ? $ubicacion[0]->ciudad : '' }}
                                                            </option>
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Codigo Postal</label>
                                                    <input type="text" name="postalcode" id="codigo_postal"
                                                        placeholder="ingrese el codigo postal" required />
                                                </span>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <span class="ec-check-order-btn">
                                <a class="btn btn-primary w-100" id="tomar_pedido">Realizar Pedido</a>
                            </span>
                        </div>
                    </div>
                    <!--cart content End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="ec-checkout-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Resumen</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-summary">
                                    <div>
                                        <span class="text-left">Total de Productos</span>
                                        <span class="text-right" id="total_productos">{{ Cart::count() }}</span>
                                    </div>
                                    <div>
                                        <span class="text-left">Ganacia estimada</span>
                                        <span class="text-right">${{ number_format(Cart::total() * 0.4, 2) }}</span>
                                    </div>
                                    <div class="ec-checkout-summary-total">
                                        <span class="text-left">Total a Pagar</span>
                                        <span class="text-right" id="total_pagar">${{ Cart::total() }}</span>
                                    </div>
                                </div>
                                <div class="ec-checkout-pro">
                                    <h3 class="ec-sidebar-title">Premios por pedido</h3>
                                    @if (!empty($productoPremio))
                                        <input type="hidden" id="premio" value="tiene premio">
                                        @foreach ($productoPremio as $producto)
                                            @livewire('card-premio',['id_producto'=>$producto->id,'imagen'=>$producto->imagen_path,'clasificacion'=>$producto->clasificacion,
                                            'pvp'=>$producto->valor_venta,'color'=>$producto->color,'estilo'=>$producto->estilo])
                                        @endforeach
                                    @else
                                        <input type="hidden" id="premio" value="no tiene premio">
                                        <div id="premios_despues">
                                            <p>Tu pedido no incluye premio</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                    {{-- <div class="ec-sidebar-wrap ec-checkout-del-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Delivery Method</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-del">
                                    <div class="ec-del-desc">Please select the preferred shipping method to use on this
                                        order.</div>
                                    <form action="#">
                                        <span class="ec-del-option">
                                            <span>
                                                <span class="ec-del-opt-head">Free Shipping</span>
                                                <input type="radio" id="del1" name="radio-group" checked>
                                                <label for="del1">Rate - $0 .00</label>
                                            </span>
                                            <span>
                                                <span class="ec-del-opt-head">Flat Rate</span>
                                                <input type="radio" id="del2" name="radio-group">
                                                <label for="del2">Rate - $5.00</label>
                                            </span>
                                        </span>
                                        <span class="ec-del-commemt">
                                            <span class="ec-del-opt-head">Add Comments About Your Order</span>
                                            <textarea name="your-commemt" placeholder="Comments"></textarea>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div> --}}
                    <div class="ec-sidebar-wrap ec-checkout-pay-wrap">
                        <!-- Sidebar Payment Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Metodo de pago</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-pay">
                                    <div class="ec-pay-desc">Por favor seleccione su metodo de pago preferido.</div>
                                    <form action="#">
                                        <span class="ec-pay-option">
                                            <span>
                                                <input type="radio" id="pay1" name="radio-group" checked>
                                                <label for="pay1">Contra entrega</label>
                                            </span>
                                        </span>
                                        <span class="ec-pay-commemt">
                                            <span class="ec-pay-opt-head">Agrega comentarios a tu pedido</span>
                                            <textarea name="your-commemt" placeholder="Comentarios"></textarea>
                                        </span>
                                        <span class="ec-pay-agree"><input type="checkbox" value="" checked><a
                                                href="#">He leído y acepto los <span>Terminos y
                                                    condiciones</span></a><span class="checked"></span></span>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Payment Block -->
                    </div>
                    <div class="ec-sidebar-wrap ec-check-pay-img-wrap">
                        <!-- Sidebar Payment Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Metodos de Pago</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-check-pay-img-inner">
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment1.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment2.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment3.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment4.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment5.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment6.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment7.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Payment Block -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
        <script>
            $('.ec-opt-size').each(function() {
                $(document).on('mouseenter', 'li', function() {
                    // alert("1");
                    onSizeChange($(this));
                });

                $(document).on('click', 'li', function() {
                    // alert("2");
                    onSizeChange($(this));
                });

                function onSizeChange(thisObj) {
                    // alert("3");
                    var $this = thisObj;
                    var $old_data = $this.find('a').attr('data-old');
                    var $new_data = $this.find('a').attr('data-new');
                    var $old_price = $this.closest('.ec-pro-content').find('.old-price');
                    var $new_price = $this.closest('.ec-pro-content').find('.new-price');

                    $old_price.text($old_data);
                    $new_price.text($new_data);

                    $this.addClass('active').siblings().removeClass('active');
                }
            });
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })
            $('body').addClass('checkout_page');
            $('#tomar_pedido').click(function() {
                let productosPremio = [];
                let total = $('#total_pagar').text().split('$')
                let datos = {
                    cedula: $('#cedula').val(),
                    nombres: $('#nombres').val(),
                    apellidos: $('#apellidos').val(),
                    direccion: $('#direccion').val(),
                    provincia: $('#provincia').val(),
                    ciudad: $('#ciudad').val(),
                    codigo_postal: $('#codigo_postal').val(),
                    total_pagar: total[1],
                    total_productos: $('#total_productos').text(),
                    premio: $('#premio').val()
                }
                let continuar = 0;
                if ($('#premio').val() == "tiene premio") {
                    let premios = $('.datos-premios')
                    $.each(premios, function(i, v) {
                        let data = {
                            nombre: $(this).find('.ec-pro-title a').text(),
                            precio: 0,
                            color: $(this).find('.ec-pro-color .p-1').val(),
                            talla: $(this).find('.ec-pro-size ul .active').text()
                        }
                        if ($(this).find('.ec-pro-size ul .active').text() == '') {
                            continuar++;
                        } else {
                            productosPremio.push(data);
                        }
                    })
                }
                datos['premios'] = productosPremio;
                let total_pedido = $('#total_pagar').text().split('$');

                if ($('#codigo_postal').val() != '' && $('#cedula').val() != '' && $('#nombres').val() != '' && $(
                        '#apellidos').val() != '' && $('#direccion').val() != '' && $('#ciudad').val() != '') {
                    if (total_pedido[1] > 0) {
                        if (continuar > 0) {
                            Swal.fire(
                                'Debe escoger la talla y \n el color del premio!',
                                '',
                                'info'
                            )
                        } else {
                            data_checkout(datos)
                        }
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: 'no puedes continuar si tu total es 0'
                        })
                    }
                } else {
                    Toast.fire({
                        icon: 'info',
                        title: 'Verifique que todos los campos de la facturacion esten completos '
                    })
                }
            })

            function data_checkout(datos) {
                $.post({
                    url: "{{ route('web.checkout-productos') }}",
                    data: datos,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {},
                    success: function(response) {
                        if (response != '') {
                            let id_ventas = response.id_venta
                            let url = 'detalle-pedido-ibizza/' + id_ventas

                            $(location).attr('href', url);
                        }
                    }
                })
            }
            $('#search').autocomplete({
                source: function(request, response) {
                    $.getJSON("{{ route('web.autocompletar-empresaria') }}", {
                            term: request.term
                        },
                        response
                    );
                },
            })
            $('#asignarEmpresaria').click(function() {
                datos = $('#search').val();
                datos = datos.split(' | ');
                data = {
                    cedula: datos[0],
                    nombres: datos[1]
                }
                $.post({
                    url: "{{ route('web.data-empresaria') }}",
                    data: data,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response != null) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Datos de empresaria agregados'
                            })
                            $('#cedula').val(response['empresaria']['cedula'])
                            $('#nombres').val(response['empresaria']['nombres'])
                            $('#apellidos').val(response['empresaria']['apellidos'])
                            $('#direccion').val(response['empresaria']['direccion'])
                            $('#provincia').html('');
                            $('#provincia').append('<option>' + response['empresaria'][
                                    'nombre_provincia'
                                ] +
                                '</option>')
                            $('#ciudad').html('');
                            $('#ciudad').append('<option>' + response['empresaria']['nombre_ciudad'] +
                                '</option>')

                            if (response['premios'] != null) {
                                $('#premios_despues').html('');
                                $.each(response['premios'], function(i, v) {
                                    agregar_cards_premios(v);
                                })
                            }
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'no encontramos registro de la empresaria'
                            })
                        }
                    }
                })
            })

            function agregar_cards_premios(val) {
                let ruta = './detalle-producto/' + val['estilo']
                let option_colores = ''
                let option_tallas = ''
                $.each(val['colores'], function(i, v) {
                    option_colores += '<option value="' + v + '">' + v + '</option>'
                })
                $.each(val['tallas'], function(i, v) {
                    option_tallas += '<li><a href="#" class="ec-opt-sz">' + v + '</a></li>'
                })
                $('#premio').val('tiene premio');
                $('#premios_despues').append('<div class="col-sm-12 mb-6">' +
                    '<div class="ec-product-inner">' +
                    '<div class="ec-pro-image-outer">' +
                    '<div class="ec-pro-image">' +
                    '<a href="' + ruta + '" class="image">' +
                    '<img class="main-image" src="storage/images/productos/' + val['imagen_path'] +
                    '" alt="Product" />' +
                    '<img class="hover-image" src="storage/images/productos/' + val['imagen_path'] +
                    '" alt="Product" />' +
                    ' </a>' +
                    '</div>' +
                    '</div>' +
                    '<div class="ec-pro-content datos-premios">' +
                    '<h5 class="ec-pro-title"><a href="' + ruta + '">' + val['clasificacion'] + '</a>' +
                    '</h5>' +
                    '<span class="ec-price">' +
                    '<span class="old-price">$' + val['valor_venta'] + '</span>' +
                    '<span class="new-price">$Gratis</span>' +
                    '</span>' +
                    '<div class="ec-pro-option">' +
                    '<div class="ec-pro-color">' +
                    ' <span class="ec-pro-opt-label">Color</span>' +
                    ' <select class="p-1">' +
                    option_colores +
                    '</select>' +
                    '</div>' +
                    '<div class="ec-pro-size">' +
                    '<span class="ec-pro-opt-label">Size</span>' +
                    '<ul class="ec-opt-size">' +
                    option_tallas +
                    '</ul>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>')
            }

        </script>
    @endpush
</x-plantilla>
