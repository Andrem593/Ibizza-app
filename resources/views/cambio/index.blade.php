<x-app-layout>
    @section('title', 'Cambios')
    <x-slot name="header">
        <h5 class="text-center">Registro de Cambios</h5>
    </x-slot>
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('CAMBIOS') }}
                </span>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card-body">

            <div class="row justify-content-start">
                <div class="col mx-3 col-sm-8">
                    <h5>Filtro de Cambios</h5>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="desde">Desde</label>
                                <input type="date" class="form-control" id="txt_fecha_desde">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="hasta">Hasta</label>
                                <input type="date" class="form-control" id="txt_fecha_hasta">
                            </div>
                        </div>
                        {{-- <div class="col d-flex align-items-center">
                        <button class="btn btn-ibizza mt-2" onclick="filtro()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div> --}}
                    </div>
                </div>
            </div>

            <div class="table-responsive p-3">
                <table id="datatable" class="display table table-striped table-sm table-hover fw-bold"
                    style="font-size: 12px">
                    <thead class="bg-ibizza text-center">
                        <tr>
                            <th># PEDIDO</th>
                            <th>IDENTIFICACIÓN</th>
                            <th>NOMBRE</th>
                            <th>DIRECCIÓN</th>
                            <th>EMPRESARIA</th>
                            <th>REFERENCIA</th>
                            <th>CANTIDAD</th>
                            <th>TOTAL CAMBIO</th>
                            <th>ESTADO CAMBIO</th>
                            <th>FECHA</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('css')
        <link rel="stylesheet" href="/css/botonesDataTable.css">
    @endpush
    @push('modals')
        <!-- Modal -->
        <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div id="carga" class="overlay" style="visibility: hidden">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">CAMBIO #<span id="id_venta"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ url('/assets/images/logo/logo_dpisar.svg') }}" alt="Logo DPISAR" width="300px">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold">N° Pedido: <span id="venta"></span></div>
                                <div class="fw-bold">N° Guia de Retorno: <span id="nguia"></span></div>
                                <div class="fw-bold">N° Factura Venta: <span id="nfactura"></span></div>
                                <div class="fw-bold">N° Factura: <span id="nfactura_carga"></span></div>
                                <div class="fw-bold">Se va con Pedido: <span id="e_pedido"></span></div>
                                <div class="fw-bold">Motivo de Cambio: <span id="motivo_cambio"></span></div>
                                <div>Fecha: <span id="fecha"></span></div>
                                <div>Asesor: <span id="vendedor"></span></div>
                            </div>

                            <div class="col-4">
                                <div class="mb-1">
                                    <button class="btn btn-primary btn-sm" data-bs-target="#modalPago"
                                        data-bs-toggle="modal">
                                        Pagos</button>
                                    {{-- <button class="btn btn-secondary btn-sm" data-bs-target="#modalRecibo"
                                        data-bs-toggle="modal">
                                        Recibo</button> --}}
                                    <a href="" id="btn-descarga" class="btn btn-success btn-sm ml-1" target="_blank">
                                        Descargar PDF
                                    </a>
                                </div>

                                <div class="mt-2">
                                    <label for="estado_venta">Estado Cambio</label>
                                    <select id="estado_venta" class="form-control-sm">
                                        @if (Auth::user()->role == 'VALIDADOR' || Auth::user()->role == 'ADMINISTRADOR' || Auth::user()->role == 'ASESOR' )
                                            <option value="PENDIENTE DE PAGO">PENDIENTE DE PAGO</option>
                                            <option value="CAMBIO POR VALIDAR">CAMBIO POR VALIDAR</option>
                                            <option value="CAMBIO APROBADO">CAMBIO APROBADO</option>
                                            <option value="CAMBIO APROBADO SIN VALIDAR">CAMBIO APROBADO SIN VALIDAR</option>
                                            <option value="CAMBIO FACTURADO LOCAL IBIZZA" >CAMBIO FACTURADO LOCAL IBIZZA</option>
                                            <option value="CAMBIO FACTURADO" disabled>CAMBIO FACTURADO</option>
                                            <option value="CAMBIO FACTURADO Y DESPACHADO" disabled>CAMBIO FACTURADO Y DESPACHADO</option>
                                            @if (Auth::user()->role == 'VALIDADOR')
                                                {{--  Si el rol es validador deshabilitar las opciones del validador, para que solo las pueda ver y no seleccionar --}}

                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <span class="fw-bold">Información Empresaria</span>
                                <div>Nombre: <span id="empresaria"></span></div>
                                <div>Identificación: <span id="cedula"></span></div>
                                <div>Teléfono: <span id="telefono"></span></div>
                                <div>Correo: <span id="correo"></span></div>
                            </div>
                            <div class="col-6">
                                <span class="fw-bold">Datos Facturación</span>
                                <div>Identificación: <span id="fcedula"></span></div>
                                <div>Nombre: <span id="fnombre"></span></div>
                                <div>Teléfono: <span id="ftelefono"></span></div>
                                <div>Email: <span id="femail"></span></div>

                            </div>
                            <hr class="divider m-0 mt-2" />
                            <div class="col-12 mt-2">
                                <span class="fw-bold">Dirección de Envio</span>
                                <div>Identificación: <span id="eidentificacion"></span></div>
                                <div>Nombre: <span id="enombre"></span></div>
                                <div>Teléfono: <span id="etelefono"></span></div>
                                <div>Provincia: <span id="eprovincia"></span></div>
                                <div>Ciudad: <span id="eciudad"></span></div>
                                <div>Dirección: <span id="direccion"></span></div>
                                <div>Referencia: <span id="referencia"></span></div>
                            </div>
                        </div>

                        <hr>
                        <div class="text-center">
                            <h6># DE VENTA: <span id="id_venta_pedido"></span></h6>
                        </div>
                            <table id="tabla_pedido" class="table table-bordered p-4">
                                <thead>
                                    <tr class="bg-ibizza">
                                        <th scope="col">SKU</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Talla</th>
                                        <th scope="col">P.V.C</th>
                                        <th scope="col">Desc.</th>
                                        <th scope="col">Cant.</th>
                                        <th scope="col" width="15px">P.V.E</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>

                        <hr>
                        <div class="text-center">
                            <h6>REFERENCIAS DEL PRODUCTO QUE SE LE TIENE QUE ENVIAR A LA EMPRESARIA</h6>
                        </div>

                        <table id="tabla_factura" class="table table-bordered p-4">
                            <thead>
                                <tr class="bg-ibizza">
                                    <th scope="col">SKU</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Talla</th>
                                    <th scope="col">P.V.C</th>
                                    <th scope="col">Desc.</th>
                                    <th scope="col">Cant.</th>
                                    <th scope="col" width="15px">P.V.E</th>
                                    <th scope="col" class="d-none">Dirección</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="border-none" colspan="4">
                                        <span></span>
                                    </td>
                                    <td class="border-color">
                                        $<span id="subtotal"></span>
                                    </td>
                                    <td></td>
                                    <td>
                                        <span id="cant_total"></span>
                                    </td>
                                    <td class="border-color">
                                        $<span id="total_fac"></span>
                                    </td>
                                </tr>
                                <tr></tr>
                                <tr>
                                    <td class="border-none" colspan="6">
                                        <span></span>
                                    </td>
                                    <td><span>Envio</span></td>
                                    <td>$<span id="envio"></span></td>
                                </tr>
                                <tr>
                                    <td class="border-none" colspan="6">
                                        <span></span>
                                    </td>
                                    <td><span>Total</span></td>
                                    <td>$<span id="total"></span></td>
                                </tr>
                                <tr>
                                    <td class="border-none" colspan="6">
                                        <span></span>
                                    </td>
                                    <td><span>Total Pagar</span></td>
                                    <td>$<span id="total_pagar"></span></td>
                                </tr>
                                <tr>
                                    <td class="border-1" colspan="1">Descripción del Cambio</td>
                                    <td class="border-1" colspan="8">
                                        <textarea class="form-control bg-white border-0" readonly id="descripcion" rows="5" contenteditable="false"></textarea>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        @if (Auth::user()->role != 'ASESOR')
                            <button type="button" id="editar_cambio" class="btn bg-ibizza">GUARDAR</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="pedido" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id="cargat" class="overlay" style="visibility: hidden">
                        <i class="fas fa-2x fa-sync fa-spin"></i>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tracking de Cambio #<span id="id_venta_t"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ url('/assets/images/logo/logo_dpisar.svg') }}" alt="Logo DPISAR" width="100px">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold">N° Cambio: <span id="venta_t"></span></div>
                                <div>Fecha: <span id="fecha_t"></span></div>
                                <div>Asesor: <span id="vendedor_t"></span></div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">

                                <!-- The time line -->
                                <div class="timeline">
                                    <div>
                                        <i class="fas fa-hand-holding-usd bg-olive"></i>
                                        <div class="timeline-item">
                                            <h3 id="pendiente" class="timeline-header no-border">Pendiente de Pago</h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-comments-dollar bg-blue"></i>
                                        <div class="timeline-item">
                                            <h3 id="cambio_validar" class="timeline-header no-border">Cambio por Validar
                                            </h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-truck-loading bg-navy"></i>
                                        <div class="timeline-item">
                                            <h3 id="cambio_aprobado" class="timeline-header no-border">Cambio Aprobado</h3>
                                        </div>
                                    </div>

                                    <div>
                                        <i class="fas fa-truck-loading bg-navy"></i>
                                        <div class="timeline-item">
                                            <h3 id="cambio_aprobado_sin_validar" class="timeline-header no-border">Cambio Aprobado Sin Validar</h3>
                                        </div>
                                    </div>

                                    <div>
                                        <i class="fas fa-file-invoice-dollar bg-yellow"></i>
                                        <div class="timeline-item">
                                            <h3 id="cambio_facturado" class="timeline-header no-border">Cambio Facturado</h3>
                                        </div>
                                    </div>

                                    <div>
                                        <i class="fas fa-file-invoice-dollar bg-yellow"></i>
                                        <div class="timeline-item">
                                            <h3 id="cambio_facturado_local" class="timeline-header no-border">Cambio Facturado Local IBIZZA</h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-boxes bg-green"></i>
                                        <div class="timeline-item">
                                            <h3 id="cambio_despachado" class="timeline-header no-border">Cambio Despachado</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.col -->

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="modalRecibo" aria-hidden="true" aria-labelledby="modalReciboLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalReciboLabel">Foto de recibo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form_editar" action="" class="submit" enctype="multipart/form-data">
                            <input type="hidden" name="ant_img" id="imagen_path">
                            @livewire('imagen')
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary" id="guardar_recibo">Guardar Recibo</button>
                        </form>
                        <button class="btn bg-ibizza" data-bs-target="#editar" data-bs-toggle="modal">Regresar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalPago" aria-hidden="true" aria-labelledby="modalPagoLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPagoLabel">Pagos - CAMBIO #<span id="id_venta_p"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @livewire('guardar-pago-cambio')
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" id="guardar_pago">Guardar Pago</button>                         --}}
                        <button class="btn bg-ibizza"  data-bs-target="#editar" data-bs-toggle="modal" data-bs-dismiss="modal" >Regresar</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @Push('scripts')
        <script src="js/crearDataTable9.js?id={{ rand().md5(10) }}"></script>
        <script src="{{ asset('/vendor/datatables-datetime/js/dataTables.dateTime.min.js') }}"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            var minDate, maxDate;

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {

                    if (settings.nTable.id !== 'datatable') {
                        return true;
                    }

                    var min = $('#txt_fecha_desde').val();
                    var max = $('#txt_fecha_hasta').val();

                    var createdAt = data[9]; // Our date column in the table
                    //console.log(min + ' ' + max);

                    if ($('#txt_fecha_desde').val() === "") {
                        min = null;
                    }
                    if ($('#txt_fecha_hasta').val() === "") {
                        max = null;
                    }

                    if (
                        (min === null && max === null) ||
                        (min === null && moment(createdAt).isSameOrBefore(max)) ||
                        (moment(createdAt).isSameOrAfter(min) && max === null) ||
                        (moment(createdAt).isSameOrAfter(min) && moment(createdAt).isSameOrBefore(max))
                    ) {
                        return true;
                    }

                    return false;
                }
            );

            $(document).ready(function() {

                minDate = new DateTime($('#txt_fecha_desde'), {
                    format: 'YYYY-MM-DD'
                });
                maxDate = new DateTime($('#txt_fecha_hasta'), {
                    format: 'YYYY-MM-DD'
                });

                var data = {
                    funcion: 'listar_todo',
                }
                let ruta = '/cambio/datatable'
                crearTablaCambios(data, ruta);

                var table = $("#datatable").DataTable();
                // Refilter the table
                $('#txt_fecha_desde, #txt_fecha_hasta').on('change', function() {
                    table.draw();
                });
            });

            //Al cerrar el modal del pago, volver a actualizar información del pedido en el modal anterior
            $("#modalPago").on("hide.bs.modal", function(e){
                 $('#datatable').DataTable().ajax.reload(null,false) //Recarga el datatable con los datos actualizados
                 $('form').trigger("reset");
                let dato = {
                    id: $('#venta').text(),
                }
                $.post({
                    url: '/cambio/datos-cambio',
                    data: dato,
                    beforeSend: function () {
                        $('#carga').css('visibility', 'visible');
                    },
                    success: function (response) {
                        $('#carga').css('visibility', 'hidden')
                        let data = JSON.parse(response);
                        let empresaria = data['businesswoman'];
                        let venta = data['cambio_encabezado'];
                        let rol = data['role'];
                        let direccionVenta = data['shipping_information'];
                        if(rol == "ASESOR"){
                            $('#estado_venta').prop( "disabled", true );
                        }else{
                            $('#estado_venta').prop( "disabled", false );
                        }
                        Livewire.emitTo('guardar-pago-cambio', 'setCambio', dato.id);
                        $('#estado_venta').val(venta['estado']);
                        $('#venta').text(venta['id'])
                        $('#nfactura').text(venta['n_factura'])
                        $('#nfactura_carga').text(venta['n_factura_carga'])
                        $('#e_pedido').text(venta['e_pedido'])
                        $('#motivo_cambio').text(venta['motivo'])
                        $('#descripcion').text(venta['descripcion'])
                        $('#nguia').text(venta['id_pedido'])
                        $('#btn-descarga').attr( 'href','/cambio/comprobante/' + venta['id']);

                        $('#fcedula').text(venta['f_cedula'])
                        $('#fnombre').text(venta['f_nombre'])
                        $('#ftelefono').text(venta['f_telefono'])
                        $('#femail').text(venta['f_correo'])
                        $('#id_venta_pedido').text(venta['id_venta'])

                        $('#empresaria').text(empresaria['nombres'] + ' ' + empresaria['apellidos'])
                        $('#cedula').text(empresaria['cedula'])
                        $('#telefono').text(empresaria['telefono'])
                        $('#correo').text(empresaria['usuario']['email'])
                        $('#enombre').text(direccionVenta['e_nombre'])

                        $('#etelefono').text(direccionVenta['e_telefono'])
                        $('#eprovincia').text(direccionVenta['e_provincia'])
                        $('#eciudad').text(direccionVenta['e_ciudad'])
                        $('#direccion').text(direccionVenta['e_direccion'])
                        $('#eidentificacion').text(direccionVenta['e_cedula'])

                        $('#referencia').text(direccionVenta['referencia'])

                        $('#imagen_path').val(venta['recibo']);
                        if (venta['recibo'] != null) {
                            $('#imagen_defecto').attr('src',venta['recibo']);
                        }
                        $('#vendedor').text(venta['seller']['name'])
                        let fecha = venta['created_at'];
                        fecha = fecha.split('T');
                        $('#fecha').text(fecha[0]);
                        data = data['cambio_detalle'];
                        $('#tabla_factura tbody').html('');
                        $('#tabla_pedido tbody').html('');
                        let subtotal = 0
                        let total_factura = 0
                        let cantidad_total = 0
                        let envio = venta['envio'];
                        let ganancia = 0
                        $.each(data, function (i, product) {
                        $('#tabla_pedido tbody').append('<tr>' +
                                '<td>' + product['order']['producto']['sku'] + '</td>' +
                                '<td>' + product['order']['producto']['descripcion'] + '</td>' +
                                '<td>' + product['order']['producto']['color'] + '</td>' +
                                '<td>' + product['order']['producto']['talla'] + '</td>' +
                                '<td>' + product['precio_catalogo_producto_venta'] + '</td>' +
                                '<td>' + (product['descuento_venta'] * 100 ) + '%</td>' +
                                '<td>' + product['cantidad_producto_venta'] + '</td>' +
                                '<td>' + product['precio_producto_venta'] + '</td>' +
                                '<td></td>')
                        });

                        $.each(data, function (i, product) {
                            $('#tabla_factura tbody').append('<tr>' +
                                '<td>' + product['product']['sku'] + '</td>' +
                                '<td>' + product['product']['descripcion'] + '</td>' +
                                '<td>' + product['product']['color'] + '</td>' +
                                '<td>' + product['product']['talla'] + '</td>' +
                                '<td>' + product['precio_catalogo'] + '</td>' +
                                '<td>' + (product['descuento'] * 100 ) + '%</td>' +
                                '<td>' + product['cantidad'] + '</td>' +
                                '<td>' + product['precio'] + '</td>' +
                                '<td></td>')

                            subtotal = parseFloat(subtotal) + parseFloat(product['precio_catalogo']);
                            total_factura += parseFloat(product['total'] );
                            cantidad_total = parseInt(product['cantidad'] ) + parseInt(cantidad_total);
                        })
                        total_factura = total_factura.toFixed(2)

                        $('#subtotal').text(subtotal.toFixed(2));
                        $('#cant_total').text(cantidad_total);
                        $('#total_fac').text(parseFloat(venta['total']).toFixed(2)) ;
                        $('#envio').text(parseFloat(envio).toFixed(2) );
                        $('#total').text(parseFloat(venta['total']).toFixed(2)) ;
                        $('#total_pagar').text(parseFloat(venta['total_pagar']).toFixed(2));
                    }
                })
            })

            $('#editar_cambio').click(function() {
                dato = {
                    estado_editar: $('#estado_venta').val(),
                    id: $('#venta').text(),
                }
                $.post({
                    url: '/cambio/editar-cambio',
                    data: dato,
                    beforeSend: function() {
                        $('#carga').css('visibility', 'visible');
                    },
                    success: function(response) {
                        $('#carga').css('visibility', 'hidden')
                        $('#editar .btn-close').click();
                        Toast.fire({
                            icon: 'success',
                            title: 'Estado de pedido Actualizado !!'
                        })
                        $('#datatable').DataTable().ajax.reload(null,false) //Recarga el datatable con los datos actualizados
                    }
                })
            })
            $('#guardar_recibo').click(function(e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });
                var formData = new FormData();
                var files = $('#file')[0].files[0]
                formData.append('idVenta', $('#venta').text());
                formData.append('file', files);
                $.post({
                    url: '/ventas/carga-recibo',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {

                    },
                    success: function(response) {
                        Toast.fire({
                            icon: 'success',
                            title: 'Se Cargo imagen correctamente'
                        })
                    }

                })
            })
        </script>
    @endpush
</x-app-layout>
