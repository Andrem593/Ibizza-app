<x-app-layout>
    @section('title', 'Reporte')
    <x-slot name="header">
        <h5 class="text-center">Reportes</h5>
    </x-slot>

    <div class="row">
        <div class="col">
            <div class="card card-dark card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs justify-content-center" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                                href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                aria-selected="true">Empresarias con ventas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false">Estado de Empresarias</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                            aria-labelledby="custom-tabs-one-home-tab">
                            <div class="table-responsive p-3">
                                <table id="datatable_venta" class="display table table-striped table-sm table-hover fw-bold">
                                    <thead class="bg-ibizza text-center">
                                        <tr>
                                            <th>Identificación</th>
                                            <th>Cliente</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                            aria-labelledby="custom-tabs-one-profile-tab">
                            <table id="datatable_estado" class="display table table-striped table-sm table-hover fw-bold">
                                <thead class="bg-ibizza text-center">
                                    <tr>
                                        <th>Identificación</th>
                                        <th>Cliente</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
        
                                </tbody>
                            </table>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-dark">
                <div class="card-header">
                    <h5 class="text-center">Resumen Estado Empresarias</h5>
                </div>
                <div class="card-body">
                    <table class="display table table-striped table-sm table-hover fw-bold text-center">
                        <thead class="bg-ibizza">
                            <tr>
                                <th>Estado Empresaria</th>
                                <th>Total General</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $acum = 0;
                            @endphp
                            @if (count($empresarias) > 0)
                            @foreach ($empresarias as $item)
                                <tr>
                                    <td>{{ $item->tipo_cliente }}</td>
                                    <td>{{ $item->count }}</td>
                                </tr>
                                @php
                                    $acum = $acum + $item->count;
                                @endphp
                            @endforeach
                            @else
                            <tr>
                                <td colspan="2">Sin datos que mostrar</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td>Total General</td>
                                <td>{{ $acum }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
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
                var data = {
                    funcion: 'empresaria_venta',
                }
                var data2 = {
                    funcion: 'empresaria_estado',
                }
                let ruta = '/reporte/empresariaReports'
                reporteEmpresariaVentas(data, ruta);

                reporteEmpresariaEstado(data2, ruta);

            });
        </script>
    @endpush
</x-app-layout>
