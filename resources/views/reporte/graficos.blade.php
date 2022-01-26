<x-app-layout>
    @section('title', 'Reporte')
    <x-slot name="header">
        <h5 class="text-center">Reportes</h5>
    </x-slot>

    <div class="card card-dark card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs justify-content-center" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill"
                        href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                        aria-selected="true">Ventas mes {{ $anio_anterior }} vs {{ $anio_actual }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill"
                        href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                        aria-selected="false">Ventas por Catálogo</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel"
                    aria-labelledby="custom-tabs-one-home-tab">
                    <div class="row">
                        <div class="col-sm-3">
                            <table class="display table table-striped table-sm table-hover fw-bold text-center">
                                <thead class="bg-ibizza">
                                    <tr>
                                        <th>Mes</th>
                                        <th>{{ $anio_anterior }}</th>
                                        <th>{{ $anio_actual }}</th>
                                    </tr>
                                </thead>
                                <tbody id="resumen">
                                </tbody>
                                <tfoot id="pie">
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-sm-9">
                            <div class="chart-container">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel"
                    aria-labelledby="custom-tabs-one-profile-tab">
                    <div class="row">
                        <div class="col-sm-8">
                            <table class="display table table-striped table-sm table-hover fw-bold text-center">
                                <thead class="bg-ibizza">
                                    <tr>
                                        <th>Año</th>
                                        <th>Catálogo</th>
                                        <th>Suma de total</th>
                                        <th>Suma # Clientes</th>
                                        <th>Suma # Pedidos</th>
                                        <th>Ticket Promedio</th>
                                        <th># Semanas</th>
                                        <th>Venta promedio x semana</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($catalogos) > 0)
                                        @foreach ($catalogos as $item)
                                            <tr>
                                                <td>{{ $item->year }}</td>
                                                <td>{{ $item->nombre }}</td>
                                                <td>{{ $item->total }}</td>
                                                <td>{{ $item->n_empresarias }}</td>
                                                <td>{{ $item->suma_pedidos }}</td>
                                                <td>{{ $item->total / $item->suma_pedidos }}</td>
                                                <td>{{ $item->n_semanas }}</td>
                                                <td>{{ round($item->total / $item->n_semanas, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8">Sin datos que mostrar</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-sm-4">
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    @push('css')
        <style>
            .chart-container {
                position: relative;
                margin: auto;
                height: 50vh;
                width: 100%;
            }

        </style>
    @endpush
    @push('js')
        <script>
            var dataAnterior = JSON.parse('<?= $anterior ?>');
            var dataActual = JSON.parse('<?= $actual ?>');
            var ctx = $('#myChart');

            let meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
                'Noviembre', 'Diciembre'
            ];

            let table_html = "";
            let acumAnterior = 0;
            let acumActual = 0;
            dataAnterior.data.forEach((value, index) => {
                table_html += "<tr>";
                table_html += "<td>" + meses[index] + "</td>";
                table_html += "<td>" + value + "</td>";
                table_html += "<td>" + dataActual.data[index] + "</td>";
                table_html += "</tr>";
                acumAnterior = acumAnterior + value;
                acumActual = acumActual + dataActual.data[index];
            });

            $('#resumen').html(table_html);

            $('#pie').html('<tr><td>Total General</td><td>' + acumAnterior + '</td><td>' + acumActual + '</td></tr>');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [{
                            label: '<?= $anio_anterior ?>',
                            data: dataAnterior.data,
                            backgroundColor: 'rgba(68, 114, 196, 0.5)',
                            borderColor: 'rgba(68, 114, 196, 1)',
                            borderWidth: 1
                        },
                        {
                            label: '<?= $anio_actual ?>',
                            data: dataActual.data,
                            backgroundColor: 'rgba(165, 165, 165, 0.5)',
                            borderColor: 'rgba(165, 165, 165, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            stacked: true,
                            grid: {
                                display: false,
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    responsive: true,
                }
            });
        </script>
    @endpush
</x-app-layout>
