<x-plantilla>
    @section('title', 'Liquidación de Pedido')
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Liquidación de Pedido</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Liquidación</li>
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
                            <input type="hidden" id="data_search"
                                value="{{ $empresaria->cedula . ' | ' . $empresaria->nombres . ' ' . $empresaria->apellidos }}">
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
                                            <div class="ec-new-desc">Si deseas ser parte de nuestras empresarias solo
                                                dale
                                                click al boton continuar para poder comunicarte
                                                con uno de nuestro asesores y puedas hacer tu primera compra.
                                            </div>
                                            <div class="ec-new-btn"><a href="{{ route('web.registro-empresaria') }}"
                                                    class="btn btn-primary">Registrarme</a>
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
                            <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                                <div class="ec-checkout-block ec-check-bill">
                                    <h3 class="ec-checkout-title">Datos de Facturación</h3>
                                    <div class="ec-bl-block-content">
                                        <div class="ec-check-subtitle">Opciones de pago</div>
                                        <span class="ec-bill-option">
                                            <span>
                                                <input type="radio" id="bill1" name="radio-direccion"
                                                    value="envio" checked>
                                                <label for="bill1">Utilizar información de empresaria</label>
                                            </span>
                                            <span>
                                                <input type="radio" id="bill2" name="radio-direccion"
                                                    value="domicilio">
                                                <label for="bill2">Ingresar nuevos datos </label>
                                            </span>
                                        </span>
                                        <div class="ec-check-bill-form">
                                            <form id="form_datos" action="#" method="post">
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Tipo Identificación</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select class="ec-bill-select" name="tipo_id" id="tipo_id">
                                                            <option value="cedula"
                                                                {{ $empresaria->tipo_id == 'cedula' ? 'selected' : '' }}>
                                                                Cédula</option>
                                                            <option value="pasaporte"
                                                                {{ $empresaria->tipo_id == 'pasaporte' ? 'selected' : '' }}>
                                                                Pasaporte</option>
                                                            <option value="ruc"
                                                                {{ $empresaria->tipo_id == 'ruc' ? 'selected' : '' }}>
                                                                Ruc
                                                            </option>
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Número de identificacion</label>
                                                    <input type="text" id="cedula" name="cedula"
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
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Teléfono</label>
                                                    <input type="text" id="telefono" name="telefono"
                                                        value="{{ $empresaria->telefono }}"
                                                        placeholder="Ingrese teléfono" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Email</label>
                                                    <input type="text" id="email" name="email"
                                                        value="{{ $empresaria->email }}" placeholder="Ingrese email"
                                                        required />
                                                </span>
                                                <input type="hidden" id="direccion_domicilio"
                                                    value="{{ $empresaria->direccion }}">
                                                <input type="hidden" id="referencia_domicilio"
                                                    value="{{ $empresaria->referencia }}">
                                            </form>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                                <div class="ec-checkout-block ec-check-bill">
                                    <h3 class="ec-checkout-title">Dirección de Envio</h3>
                                    <div class="ec-bl-block-content">
                                        <span class="ec-bill-option">
                                            <span>
                                                <input type="radio" id="env1" name="radio-envio"
                                                    value="varios">
                                                <label for="env1">He ingresado varias direcciones</label>
                                            </span>
                                            <span>
                                                <input type="radio" id="env2" name="radio-envio"
                                                    value="nueva">
                                                <label for="env2">Ingresar nueva dirección</label>
                                            </span>
                                            <span>
                                                <input type="radio" id="env3" name="radio-envio"
                                                    value="midireccion" checked>
                                                <label for="env3">Utilizar la dirección existente</label>
                                            </span>
                                            <span>
                                                <input type="radio" id="env4" name="radio-envio"
                                                    value="localibizza">
                                                <label for="env4">Enviar al local de Ibizza</label>
                                            </span>
                                        </span>
                                        <div class="ec-check-bill-form">
                                            <form id="form_datos_envio" action="#" method="post">
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Nombre</label>
                                                    <input type="text" id="nombre_envio" name="nombre_envio"
                                                        value="{{ $empresaria->nombres . ' ' . $empresaria->apellidos }}"
                                                        placeholder="Ingrese nombre" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Teléfono</label>
                                                    <input type="text" id="telefono_envio" name="telefono_envio"
                                                        value="{{ $empresaria->telefono }}"
                                                        placeholder="Ingrese número de teléfono" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Provincia</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="provincia" id="provincia"
                                                            class="ec-bill-select">
                                                            <option value="">Seleccione provincia</option>
                                                            @foreach ($provincia as $item)
                                                                @if ($empresaria->provincia_id == $item->id)
                                                                    <option value="{{ $item->id }}" selected>
                                                                        {{ $item->descripcion }}</option>
                                                                @else
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->descripcion }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half mx-auto">
                                                    <label>Ciudad</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="ciudad" id="ciudad" class="ec-bill-select">
                                                            <option value="">Seleccione ciudad</option>
                                                            @empty(!$ciudad)
                                                                @foreach ($ciudad as $item)
                                                                    @if ($empresaria->id_ciudad == $item->id)
                                                                        <option value="{{ $item->id }}" selected>
                                                                            {{ $item->descripcion }}</option>
                                                                    @else
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->descripcion }}</option>
                                                                    @endif
                                                                @endforeach
                                                            @endempty
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Dirección</label>
                                                    <input type="text" id="direccion" name="direccion"
                                                        value="{{ $empresaria->direccion }}"
                                                        placeholder="Ingrese la dirección de entrega del pedido"
                                                        required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Referencia</label>
                                                    <input type="text" id="referencia" name="referencia"
                                                        value="{{ $empresaria->referencia }}"
                                                        placeholder="Ingrese la referencia de envío" required />
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
                                        <span class="text-left">Ganacias</span>
                                        <span class="text-right"
                                            id="ganancia">${{ number_format(Cart::content()->map(function ($item) {return $item->options->pCatalogo * $item->qty;})->sum(),2) - Cart::subtotal() }}</span>
                                    </div>
                                    <div>
                                        <span class="text-left">Envio</span>
                                        <span class="text-right" id="envio">${{ $envio }}</span>
                                    </div>
                                    <div class="ec-checkout-summary-total">
                                        <span class="text-left">Total a Pagar</span>
                                        <span class="text-right"
                                            id="total_pagar">${{ Cart::total() + $envio }}</span>
                                    </div>
                                </div>
                                <div class="ec-checkout-pro">
                                    <h3 class="ec-sidebar-title">Premios por pedido</h3>
                                    @if (!empty($productoPremio))
                                        <input type="hidden" id="premio" value="tiene premio">
                                        @foreach ($productoPremio as $producto)
                                            @livewire('card-premio', ['id_producto' => $producto->id, 'imagen' => $producto->imagen_path, 'clasificacion' => $producto->clasificacion, 'pvp' => $producto->valor_venta, 'color' => $producto->color, 'estilo' => $producto->estilo, 'nombre' => $producto->descripcion])
                                        @endforeach
                                    @else
                                        <input type="hidden" id="premio" value="no tiene premio">
                                        <div id="premios_despues">
                                            <p>Tu pedido no incluye premio</p>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <div class="ec-checkout-pro">
                                        @if (!empty($empresaria))
                                            @if (count($empresaria->pedidos) == 0)
                                                <hr />
                                                <div class="text-center w-100">
                                                    <label class="form-check-label fw-bold">
                                                        Enviar catálogo
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar Summary Block -->
                        </div>

                        <div class="ec-sidebar-wrap ec-checkout-pay-wrap">
                            <!-- Sidebar Payment Block -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Metodo de pago</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <div class="ec-checkout-pay">
                                        <div class="ec-pay-desc">Por favor seleccione su metodo de pago preferido.
                                        </div>
                                        <form action="#">
                                            <span class="ec-pay-option">
                                                <span>
                                                    <input type="radio" id="pay1" name="radio-group" checked>
                                                    <label for="pay1">transferencia Bancaria</label>
                                                </span>
                                            </span>
                                            <span class="ec-pay-commemt">
                                                <span class="ec-pay-opt-head">Agrega comentarios a tu pedido</span>
                                                <textarea name="your-commemt" id="observaciones_pedido" placeholder="Comentarios"></textarea>
                                            </span>
                                            <span class="ec-pay-agree"><input type="checkbox" value=""
                                                    checked><a href="#">He leído y acepto los <span>Terminos y
                                                        condiciones</span></a><span class="checked"></span></span>
                                        </form>
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
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
        <script>
            $('.ec-side-toggle').css('display', 'none')
            $('.ec-opt-size').each(function() {
                $(document).on('click', 'li', function() {
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
            $('body').addClass('checkout_page');
            $('#tomar_pedido').click(function() {
                let productosPremio = [];
                let total = $('#total_pagar').text().split('$');
                let ganancia = $('#ganancia').text().split('$');


                let direccion = $('#direccion_domicilio').val();
                let referencia = $('#referencia_domicilio').val();

                let datos = {
                    cedula: $('#cedula').val(),
                    nombres: $('#nombres').val(),
                    apellidos: $('#apellidos').val(),
                    direccion: direccion,
                    referencia: referencia,
                    provincia: $('#provincia').val(),
                    ciudad: $('#ciudad').val(),
                    total_pagar: total[1],
                    total_productos: $('#total_productos').text(),
                    premio: $('#premio').val(),
                    observaciones: $('#observaciones_pedido').val(),
                    ganancia: ganancia[1],
                    opcion: opcion,
                    envio: $('#envio').text(),
                    nombre_envio: $('#nombre_envio').val(),
                    telefono_envio: $('#telefono_envio').val(),
                    direccion_envio: $('#direccion').val(),
                    referencia_envio: $('#referencia').val(),

                }
                let continuar = 0;
                if ($('#premio').val() == "tiene premio") {
                    let premios = $('.datos-premios')
                    $.each(premios, function(i, v) {
                        let data = {
                            nombre: $(this).find('.ec-pro-title a').text(),
                            precio: 0,
                            color: $(this).find('.ec-pro-color .p-1').val(),
                            talla: $(this).find('.ec-pro-size ul .active').text(),
                            estilo: $(this).find('.estiloPro').val(),
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

                if ($('#cedula').val() != '' && $('#nombres').val() != '' && $('#apellidos').val() != '' &&
                    $('#direccion').val() != '' && $('#referencia').val() != '' && $('#ciudad').val() != '' ||
                    $('#cedula').val() != '' && $('#nombres').val() != '' && $('#apellidos').val() != '' && $(
                        'input[name="radio-envio"]:checked').val() == 'varios'
                ) {
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
                    beforeSend: function() {
                        $('#tomar_pedido').attr("disabled", true);
                        $('#tomar_pedido').html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando pedido...'
                        );
                    },
                    success: function(response) {
                        if (response != '') {
                            let id_ventas = response.id_venta
                            let url = 'detalle-pedido-ibizza/' + id_ventas

                            $(location).attr('href', url);
                        }
                        $('#tomar_pedido').attr("disabled", false);
                        $('#tomar_pedido').html('Realizar Pedido');
                    }
                })
            }
            $('#bill1').click(function() {
                $('#direccion').prop('disabled', false);
                $('#provincia').prop('disabled', false);
                $('#ciudad').prop('disabled', false);
                datos = $('#data_search').val();
                datos = datos.split(' | ');
                data = {
                    cedula: datos[0],
                    nombres: datos[1]
                }
                search_data(data);
            });

            $('#bill2').click(function() {
                $('#cedula').val('')
                $('#nombres').val('')
                $('#apellidos').val('')
                $('#telefono').val('')
                $('#email').val('')
            });

            $('#env1').click(function() {
                $('#nombre_envio').val('')
                $('#telefono_envio').val('')
                $('#direccion').val('')
                $('#referencia').val('')
            });

            $('#env2').click(function() {
                $('#nombre_envio').val('')
                $('#telefono_envio').val('')
                $('#direccion').val('')
                $('#referencia').val('')
            });

            $('#env3').click(function() {
                datos = $('#data_search').val();
                datos = datos.split(' | ');
                data = {
                    cedula: datos[0],
                    nombres: datos[1]
                }
                search_data(data);
            });

            $('#env4').click(function() {
                $('#nombre_envio').val('Local Ibizza')
                $('#direccion').val('Chile y Luque')
                $('#referencia').val('Frente a Deprati')
            });



            function search_data(data) {
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
                            $('#tipo_id').val(response['empresaria']['tipo_id'])
                            $('#nombres').val(response['empresaria']['nombres'])
                            $('#nombre_envio').val(response['empresaria']['nombres'] + ' ' + response[
                                'empresaria']['apellidos'])
                            $('#apellidos').val(response['empresaria']['apellidos'])
                            $('#telefono').val(response['empresaria']['telefono'])
                            $('#telefono_envio').val(response['empresaria']['telefono'])
                            $('#email').val(response['empresaria']['email'])
                            $('#direccion').val(response['empresaria']['direccion'])
                            $('#referencia').val(response['empresaria']['referencia'])
                            // $('#direccion_domicilio').val(response['empresaria']['direccion'])
                            // $('#referencia_domicilio').val(response['empresaria']['referencia'])
                            $('#provincia').val(response['empresaria']['provincia_id']);
                            if (response['ciudad'] != null) {
                                $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                                $.each(response['ciudad'], function(i, val) {
                                    if (response['empresaria']['id_ciudad'] == val['id']) {
                                        $('#ciudad').append('<option value="' + val['id'] +
                                            '" selected>' + val['descripcion'] + '</option>');
                                    } else {
                                        $('#ciudad').append('<option value="' + val['id'] + '">' +
                                            val['descripcion'] + '</option>');
                                    }
                                });
                            }
                            if (response['premios'] != null) {
                                $('#premios_despues').html('');
                                $.each(response['premios'], function(i, v) {
                                    agregar_cards_premios(v);
                                })
                            } else {
                                $('#premios_despues').html('');
                                $('#premio').val('no tiene premio');
                            }
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'no encontramos registro de la empresaria'
                            })
                        }
                    }
                })
            }
            $(document).on('change', '#provincia', function() {
                $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                $.post({
                    url: "{{ route('empresaria.ciudad') }}",
                    data: {
                        'id_provincia': $('#provincia').val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response != null) {
                            $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                            $.each(response, function(i, val) {
                                $('#ciudad').append('<option value="' + val['id'] + '">' + val[
                                    'descripcion'] + '</option>')
                            });
                        }
                    }
                });
            });

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
                if (val['imagen_path'] == null) {
                    val['imagen_path'] = "https://www.blackwallst.directory/images/NoImageAvailable.png";
                } else {
                    val['imagen_path'] = 'storage/images/productos/' + val['imagen_path'];
                }
                $('#premios_despues').append('<div class="col-sm-12 mb-6">' +
                    '<div class="ec-product-inner">' +
                    '<div class="ec-pro-image-outer">' +
                    '<div class="ec-pro-image">' +
                    '<a href="#" class="image">' +
                    '<img class="main-image" src="' + val['imagen_path'] +
                    '" alt="Product" />' +
                    '<img class="hover-image" src="' + val['imagen_path'] +
                    '" alt="Product" />' +
                    ' </a>' +
                    '</div>' +
                    '</div>' +
                    '<div class="ec-pro-content datos-premios">' +
                    '<h5 class="ec-pro-title"><a href="#">' + val['nombre_mostrar'] + '</a>' +
                    '</h5>' +
                    '<input type="hidden" class="estiloPro" value="' + val['estilo'] + '">' +
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
