<x-app-layout>
    @section('title', 'Ventas')
    <x-slot name="header">
        <h5 class="text-center">Ventas</h5>
    </x-slot>
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Ventas') }}
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
                    <h5>Filtro de Ventas</h5>
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
                            <th>ID</th>
                            <th>CÉDULA</th>
                            <th>NOMBRES</th>
                            <th>DIRECCIÓN</th>
                            <th>EMPRESARIA</th>
                            <th>OBSERVACIÓN</th>
                            <th>CANTIDAD</th>
                            <th>TOTAL VENTA</th>
                            <th>ESTADO VENTA</th>
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
                        <h5 class="modal-title" id="exampleModalLabel">VENTA #<span id="id_venta"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ url('/assets/images/logo/Logo_ibizza.svg') }}" alt="Logo Ibizza" width="100px">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold">N° Pedido: <span id="venta"></span></div>
                                <div class="fw-bold">N° Factura: <span id="nfactura"></span></div>
                                <div class="fw-bold">N° Guia: <span id="nguia"></span></div>
                                <div>Fecha: <span id="fecha"></span></div>
                                <div>Asesor: <span id="vendedor"></span></div>
                            </div>

                            <div class="col-4">
                                <div class="mb-1">
                                    <button class="btn btn-secondary btn-sm" data-bs-target="#modalPago"
                                        data-bs-toggle="modal">
                                        Pagos</button>
                                    {{-- <button class="btn btn-secondary btn-sm" data-bs-target="#modalRecibo"
                                        data-bs-toggle="modal">
                                        Recibo</button> --}}
                                    <a href="" id="btn-descarga" class="btn btn-success btn-sm ml-1">
                                        Descargar
                                    </a>
                                </div>

                                <div>Estado Venta:
                                    <select id="estado_venta" class="form-control-sm">
                                        <option value="PENDIENTE DE PAGO">PENDIENTE DE PAGO</option>
                                        <option value="PEDIDO POR VALIDAR">PEDIDO POR VALIDAR</option>
                                        <option value="PEDIDO APROBADO">PEDIDO APROBADO</option>
                                        <option value="PEDIDO FACTURADO">PEDIDO FACTURADO</option>
                                        <option value="PEDIDO DESPACHADO">PEDIDO DESPACHADO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <span class="fw-bold">Información Empresaria</span>
                                <div>Nombre: <span id="empresaria"></span></div>
                                <div>Cédula: <span id="cedula"></span></div>
                                <div>Teléfono: <span id="telefono"></span></div>
                                <div>Correo: <span id="correo"></span></div>
                            </div>
                            <div class="col">
                                <span class="fw-bold">Datos Facturación</span>
                                <div>Identificación: <span id="fcedula"></span></div>
                                <div>Nombre: <span id="fnombre"></span></div>
                                <div>Teléfono: <span id="ftelefono"></span></div>
                                <div>Email: <span id="femail"></span></div>

                            </div>
                            <div class="col">
                                <span class="fw-bold">Dirección de Envio</span>
                                <div>Nombre: <span id="enombre"></span></div>
                                <div>teléfono: <span id="etelefono"></span></div>
                                <div>Provincia: <span id="eprovincia"></span></div>
                                <div>Ciudad: <span id="eciudad"></span></div>
                                <div>Dirección: <span id="direccion"></span></div>
                                <div>Referencia: <span id="referencia"></span></div>
                            </div>
                        </div>
                        <hr>

                        <table id="tabla_factura" class="table table-hover table-striped p-4">
                            <thead>
                                <tr class="bg-ibizza">
                                    <th scope="col">Foto</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Color</th>
                                    <th scope="col">Talla</th>
                                    <th scope="col">Precio Catalogo</th>
                                    <th scope="col">Descuento</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col" width="15px">Precio Empresaria</th>
                                    <th scope="col">Dirección</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
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
                                    <td><span>Total a pagar</span></td>
                                    <td>$<span id="tot_pagar"></span></td>
                                </tr>
                                <tr>
                                    <td class="border-none" colspan="6">
                                        <span></span>
                                    </td>
                                    <td><span>Ganancia</span></td>
                                    <td>$<span id="ganancia"></span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                        @if (Auth::user()->role != 'ASESOR')                            
                            <button type="button" id="editar_venta" class="btn btn-ibizza">EDITAR</button>
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
                        <h5 class="modal-title" id="exampleModalLabel">Tracking de Pedido #<span id="id_venta_t"></span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ url('/assets/images/logo/Logo_ibizza.svg') }}" alt="Logo Ibizza" width="100px">
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold">N° Pedido: <span id="venta_t"></span></div>
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
                                            <h3 id="verificar_pago" class="timeline-header no-border">Pedido por Validar
                                            </h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-truck-loading bg-navy"></i>
                                        <div class="timeline-item">
                                            <h3 id="tomar_pedido" class="timeline-header no-border">Pedido Aprobado</h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-file-invoice-dollar bg-yellow"></i>
                                        <div class="timeline-item">
                                            <h3 id="facturado" class="timeline-header no-border">Pedido Facturado</h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-boxes bg-green"></i>
                                        <div class="timeline-item">
                                            <h3 id="despachado" class="timeline-header no-border">Pedido Despachado</h3>
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
                        <button class="btn btn-ibizza" data-bs-target="#editar" data-bs-toggle="modal">Regresar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalPago" aria-hidden="true" aria-labelledby="modalPagoLabel" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPagoLabel">Pagos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @livewire('guardar-pago')
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" id="guardar_pago">Guardar Pago</button>                         --}}
                        <button class="btn btn-ibizza" onclick="window.location.reload();" >Regresar</button>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @Push('scripts')
        <script src="/js/crearDataTable6.js"></script>
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
                let ruta = '/ventas/datatable'
                crearTablaVentas(data, ruta);

                var table = $("#datatable").DataTable();
                // Refilter the table
                $('#txt_fecha_desde, #txt_fecha_hasta').on('change', function() {
                    table.draw();
                });
            });
            $('#editar_venta').click(function() {
                dato = {
                    estado_editar: $('#estado_venta').val(),
                    id_venta: $('#venta').text(),
                }
                $.post({
                    url: '/ventas/editar-venta',
                    data: dato,
                    beforeSend: function() {
                        $('#carga').css('visibility', 'visible');
                    },
                    success: function(response) {
                        $('#carga').css('visibility', 'hidden')
                        $('#editar .btn-close').click();
                        Toast.fire({
                            icon: 'success',
                            title: 'Estado de Actualizado !!'
                        })
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
