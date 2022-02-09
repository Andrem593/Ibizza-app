<x-app-layout>
    @section('title', 'Reporte Ventas')
    <x-slot name="header">
        <h5>Reportes de Ventas</h5>
    </x-slot>

    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Tabla de reporte') }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive p-3">
                <table id="datatable" class="display table table-striped table-sm table-hover fw-bold"
                    style="font-size: 12px">
                    <thead class="bg-ibizza text-center">
                        <tr>
                            <th>ID VENTA</th>
                            <th>CEDULA</th>
                            <th>NOMBRES</th>
                            <th>DIRECCIÓN ENVIO</th>
                            <th>SKU</th>
                            <th>PRODUCTO</th>
                            <th>COLOR</th>
                            <th>TALLA</th>
                            <th>CANTIDAD</th>
                            <th>TOTAL</th>
                            <th>ESTADO</th>
                            <th>FECHA</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @empty(!$ventas)
                        @php
                        $cliente = '';
                        @endphp
                        @foreach ($ventas as $val)
                        <tr>
                            @if ($cliente != $val->id_venta)
                            @php
                            $cliente = $val->id_venta
                            @endphp
                            <td>{{$val->id_venta}}</td>
                            <td>{{$val->factura_identificacion}}</td>
                            <td>{{$val->factura_nombres}}</td>
                            <td>{{$val->direccion_envio}}</td>
                            @else
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                            <td>{{$val->sku}}</td>
                            <td>{{$val->nombre_mostrar}}</td>
                            <td>{{$val->color}}</td>
                            <td>{{$val->talla}}</td>
                            <td>{{$val->cantidad}}</td>
                            <td>${{number_format($val->total,2)}}</td>
                            <td>{{$val->estado}}</td>
                            <td>{{$val->created_at->format('d/m/Y')}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <th colspan="11"><b>NO REGISTRO DE PRODUCTOS VENDIDOS</b></th>
                        </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    @push('css')
    <link rel="stylesheet" href="/css/botonesDataTable.css">
    @endpush


    @Push('scripts')
    <script src="/js/crearDataTable.js"></script>
    <script>
        $(document).ready(function() {        
            reporteVentas();
        });
    </script>
    @endpush
</x-app-layout>