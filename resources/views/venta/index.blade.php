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
                                        <td class="border-none m-m15" colspan="3"><span
                                                class="note-text-color"></span></td>
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
                            <button type="button" class="btn btn-ibizza">EDITAR</button>
                        </div>
                    </div>
                </div>
            </div>
        @endpush
        @Push('scripts')
            <script src="/js/crearDataTable.js"></script>
            <script>
                $(document).ready(function() {
                    var data = {
                        funcion: 'listar_todo',
                    }
                    let ruta = '/ventas/datatable'
                    crearTablaVentas(data, ruta);
                });

            </script>
        @endpush
    </x-app-layout>
