<x-plantilla>
    @section('title', 'Preguntas Frecuentes')
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Preguntas Frecuentes</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{route('web')}}">Inicio</a></li>
                                <li class="ec-breadcrumb-item active">Preguntas Frecuentes</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec FAQ page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="section-title">
                        <h2 class="ec-bg-title">Preguntas Más Frecuentes</h2>
                        <h2 class="ec-title">Preguntas Más Frecuentes</h2>
                        <p class="sub-title mb-3">Gestión de servicio al cliente</p>
                    </div>
                </div>
                <div class="ec-faq-wrapper">
                    <div class="ec-faq-container">
                        <h2 class="ec-faq-heading">¿Cuales son los servicios de Ibizza?</h2>
                        <div id="ec-faq">
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Como puedo ser Empresaria Ibizza?</h4>
                                <div class="ec-faq-content">
                                    <p>Dar click en el <a class="text-success" href="{{route('web.registro-empresaria')}}">Resgistrate</a>, dejas tus datos personales e inmediata hace parte de nuestra red de empresarias uno de nuestros asesores le contactara ampliara la información.</p>
                                </div>
                            </div>
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Tiene algún costo la Inscripción?</h4>
                                <div class="ec-faq-content">
                                    <p>No, es totalmente gratis, puede hacerlo siguiendo este <a class="text-success" href="{{route('web.registro-empresaria')}}">Link</a>.</p>
                                </div>
                            </div>
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Donde puedo conseguir el Catálogo Físico o digital?</h4>
                                <div class="ec-faq-content">
                                    <p>El catálogo digital lo puede descargar directamente aquí en este <a class="text-success" href="{{ url('/') }}#section_catalogo">Link</a> o solicitarlo con uno de nuestros asesores a través del wathsapp 0963725427
                                        <br>
                                        El catálogo impreso lo puedes adquirir en nuestros local Ibizza ubicado en Chile 315 con Luque totalmente gratis, o a través de su primer pedido, el cual realizo una vez visto el catálogo digital.</p>
                                </div>
                            </div>
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Puedo hacer pedidos en el local Ibizza del Centro de Guayaquil?</h4>
                                <div class="ec-faq-content">
                                    <p>En el local Ibizza, que se encuentra ubicado en Chile 315 con Luque, diagonal al Dprati, podrá realizar su pedido, sin embargo, no se podrá realizar la entrega inmediata del pedido. Este se podrá entregar a las 24 horas.<br>
                                        Al igual con los cambios, podrá gestionar los cambios, pero este se podrá realizar la entrega después de 72 Horas.</p>
                                </div>
                            </div>
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Tiene algún costo el envió?</h4>
                                <div class="ec-faq-content">
                                    <p>Si el valor facturado es superior a $70 dólares el costo del envío es gratis. Si es menor a este valor deberá depositar o cancelar $3, esto aplica a nivel nacional.<br>
                                        Para los envíos a Galápagos si el valor facturado es de $100 el envío es gratis, en caso contrario deberá cancelar un valor de $5. 
                                        </p>
                                </div>
                            </div>
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Cuánto tardan en la entrega del pedido?</h4>
                                <div class="ec-faq-content">
                                    <p>Nuestro operador actual de Logistica es Servientrega, el tiempo de entrega puede estar entre 24 horas a 72 Horas, una vez facturado el pedido, dependiendo de la ubicación a donde se dirige el pedido.</p>
                                </div>
                            </div>
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Qué Plan de Premios ofrecen?</h4>
                                <div class="ec-faq-content">
                                    <p>Cada campaña cuenta con su programa de premios, es por ello importante que siempre consultes a tu asesor comercial. 
                                        Actualmente tenemos el Plan de premios por Pedido Facturado, el cual consta de 3 niveles, por cada campaña el Plan de premios puede variar. <br>Así que por favor contactar al asesor para mantener la información actualizada y que no se pierda ningún premio que ayudan a aumentar tus ganancias.</p>
                                </div>
                            </div>
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Que vigencia tiene el Catálogo?</h4>
                                <div class="ec-faq-content">
                                    <p>El catálogo tiene una vigencia de 5 semanas. Constantemente nos estamos renovando.</p>
                                </div>
                            </div>
                            <div class="col-sm-12 ec-faq-block">
                                <h4 class="ec-faq-title">¿Ofrecen garantías del producto?</h4>
                                <div class="ec-faq-content">
                                    <p>Claro que sí, todos nuestros productos se encuentran respaldados por la marca Dpisar, mercadería de Marcas originales, como Ipanema, Azaleria, Tommy, Democrata, entre otras, que cuentan con el respaldo de nuestros proveedores.<br>
                                        Contamos con garantía de un mes. En el momento de presentar daños en el calzado contactar a su asesor el le ayudara con la gestión del cambio.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-plantilla>