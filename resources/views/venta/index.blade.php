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
                <div class="table-responsive p-3">
                    <table id="datatable" class="display table table-striped table-sm table-hover fw-bold"
                        style="font-size: 12px">
                        <thead class="bg-ibizza text-center">
                            <tr>
                                <th>ID</th>
                                <th>CEDULA</th>
                                <th>NOMBRES</th>
                                <th>DIRECCIÓN ENVIO</th>
                                <th>CODIGO POSTAL</th>
                                <th>OBSERVACION</th>
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
                <div class="modal-dialog modal-lg">
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
                                <img src="../assets/images/logo/logo_ibizza.svg" alt="Logo Ibizza" width="100px">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="my-2">
                                        <span class="text-sm text-grey-m2 align-middle">Nombre :</span>
                                        <span id="factura_nombre"></span>
                                    </div>
                                    <div class="text-grey-m2">
                                        <div class="my-2">
                                            <span id="provincia"></span>,<span id="ciudad"></span>
                                        </div>
                                        <div class="my-2">
                                            <span id="direccion"></span>
                                        </div>
                                        <div class="my-2"><b class="text-600">Teléfono :</b>
                                            <span id="telefono"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->

                                <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                                    <hr class="d-sm-none" />
                                    <div class="text-grey-m2">

                                        <div class="my-2"><span class="text-600 text-90">ID :<span id="venta"></span> </span>
                                        </div>
                                        <div class="my-2"><span class="text-600 text-90">Vendedor :</span><span
                                                id="vendedor"></span></div>

                                        <div class="my-2"><span class="text-600 text-90">Fecha :</span><span id="fecha"></span>
                                        </div>

                                        <div class="my-2">Estado Venta:
                                            <select id="estado_venta" class="form-select">
                                                <option value="PEDIDO">PEDIDO</option>
                                                <option value="FACTURADO">FACTURADO</option>
                                                <option value="DESPACHADO">DESPACHADO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <table id="tabla_factura" class="table table-hover table-striped p-4">
                                <thead>
                                    <tr class="bg-ibizza">
                                        <th scope="col">#</th>
                                        <th scope="col">Productos</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Talla</th>
                                        <th scope="col" width="15px">Cantidad</th>
                                        <th scope="col" width="15px">Total</th>
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
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="border-none" colspan="3">
                                            <span></span>
                                        </td>
                                        <td class="border-color" colspan="2">
                                            <span><strong>Sub Total</strong></span>
                                        </td>
                                        <td class="border-color">
                                            $<span id="subtotal"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-none" colspan="3">
                                            <span></span>
                                        </td>
                                        <td class="border-color" colspan="2">
                                            <span><strong>IVA (12%)</strong></span>
                                        </td>
                                        <td class="border-color">
                                            $<span id="iva"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border-none m-m15" colspan="3"><span class="note-text-color"></span></td>
                                        <td class="border-color m-m15" colspan="2">
                                            <span><strong>Total</strong></span>
                                        </td>
                                        <td class="border-color m-m15">
                                            $<span id="total_fac"></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                            <button type="button" id="editar_venta" class="btn btn-ibizza">EDITAR</button>
                        </div>
                    </div>
                </div>
            </div>
        @endpush
        @Push('scripts')
            <script src="/js/crearDataTable.js"></script>
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
                })
                $(document).ready(function() {
                    var data = {
                        funcion: 'listar_todo',
                    }
                    let ruta = '/ventas/datatable'
                    crearTablaVentas(data, ruta);
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

            </script>
        @endpush
    </x-app-layout>
