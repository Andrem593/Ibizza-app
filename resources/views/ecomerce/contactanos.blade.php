<x-plantilla>
    @section('title', 'Contáctenos')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Contáctenos</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Contáctenos</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec Contact Us page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-common-wrapper">
                    <div class="ec-contact-leftside">

                        @if (Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                                @php
                                    Session::forget('success');
                                @endphp
                            </div>
                        @endif

                        <div class="ec-contact-container">
                            <div class="ec-contact-form">
                                <form action="{{ route('web.email-contacto') }}" method="post">
                                    @csrf
                                    <span class="ec-contact-wrap">
                                        <label>Nombres*</label>
                                        
                                        <input type="text" name="firstname" placeholder="Ingresa tus nombres" value="{{ old('firstname') }}" required/>
                                        @if ($errors->has('firstname'))
                                            <span class="text-danger">{{ $errors->first('firstname') }}</span>
                                        @endif
                                    </span>
                                    <span class="ec-contact-wrap">
                                        <label>Apellidos*</label>
                                        <input type="text" name="lastname" placeholder="Ingresa tus apellidos" value="{{ old('lastname') }}" required/>
                                        @if ($errors->has('lastname'))
                                            <span class="text-danger">{{ $errors->first('lastname') }}</span>
                                        @endif
                                    </span>

                                    <span class="ec-contact-wrap">
                                        <label>Email*</label>
                                        <input type="email" name="email" placeholder="Ingresa tu correo electronico" value="{{ old('email') }}" required/>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </span>
                                    <span class="ec-contact-wrap">
                                        <label>Teléfono*</label>
                                        <input type="text" name="phonenumber" placeholder="Ingresa tu numero de teléfono" value="{{ old('phonenumber') }}" required/>
                                        @if ($errors->has('phonenumber'))
                                            <span class="text-danger">{{ $errors->first('phonenumber') }}</span>
                                        @endif
                                    </span>
                                    <span class="ec-contact-wrap">

                                        <label>Indicanos cuales son tu dudas*</label>
                                        <textarea name="comments" placeholder="Por favor ingresa aquí tus dudas, preguntas o comentarios....." required>{{ old('comments') }}</textarea>
                                        @if ($errors->has('comments'))
                                            <span class="text-danger">{{ $errors->first('comments') }}</span>
                                        @endif

                                    </span>
                                    {{-- <span class="ec-contact-wrap ec-recaptcha">
                                        <span class="g-recaptcha"
                                            data-sitekey="6LfKURIUAAAAAO50vlwWZkyK_G2ywqE52NU7YO0S"
                                            data-callback="verifyRecaptchaCallback"
                                            data-expired-callback="expiredRecaptchaCallback"></span>
                                        <input class="form-control d-none" data-recaptcha="true" required
                                            data-error="Please complete the Captcha">
                                        <span class="help-block with-errors"></span>
                                    </span> --}}
                                    <span class="ec-contact-wrap ec-contact-btn">
                                        <button class="btn btn-primary" type="submit">Enviar</button>
                                    </span>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="ec-contact-rightside">
                        <div class="ec_contact_map">

                            <div class="ec_map_canvas">                                                                
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.8965151864104!2d-79.88457228524467!3d-2.192871598401626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x902d6e79731aa081%3A0x63793044cca25108!2sGabriel%20Jose%20de%20Luque%20%26%20Chile%2C%20Guayaquil%20090313!5e0!3m2!1ses!2sec!4v1643986487104!5m2!1ses!2sec" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                        <div class="ec_contact_info">
                            <h1 class="ec_contact_info_head">Contáctenos</h1>
                            <ul class="align-items-center">
                                <li class="ec-contact-item"><i class="ecicon eci-map-marker"

                                        aria-hidden="true"></i><span>Dirección : Calle 10 de Agosto y Pedro Carbo, Centro Guayaquil, Guayas</span></li>
                                <li class="ec-contact-item align-items-center"><i class="ecicon eci-phone"
                                        aria-hidden="true"></i><span>Telefono :</span><a href="tel:0963725427">0963725427</a></li>
                                <li class="ec-contact-item align-items-center"><i class="ecicon eci-envelope"
                                        aria-hidden="true"></i><span>Email :</span><a
                                        href="mailto:servicioalcliente.catalogodpisar@zapecsa.com">servicioalcliente.catalogodpisar@zapecsa.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('js')
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                if ($(this).hasClass('submitted')) {
                    $(this).find(':submit').html('Enviar');
                    $(this).find(':submit').attr("disabled", false);
                    event.preventDefault();
                } else {
                    $(this).find(':submit').attr("disabled", true);
                    $(this).find(':submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando correo');
                    $(this).addClass('submitted');
                }
            });
        });
    </script>
@endpush

</x-plantilla>
