<x-app-layout>
    @section('title', 'Reporte')
    <x-slot name="header">
        <h5 class="text-center">Reportes</h5>
    </x-slot>

    <div class="card card-dark">
        <div class="card-header p-0 pt-1">
            <h3 class="text-center">Ventas mes {{ $anio_anterior }} vs {{ $anio_actual }}</h3>
        </div>
        <div class="card-body p-2">
            <div class="chart-container">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>    
    <div class="card card-dark">
        <div class="card-body">
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

            let meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

            let table_html = "";
            let acumAnterior = 0;
            let acumActual = 0;
            dataAnterior.data.forEach((value, index) => {
                table_html += "<tr>";
                table_html += "<td>"+ meses[index] +"</td>";
                table_html += "<td>"+ value +"</td>";
                table_html += "<td>"+ dataActual.data[index] +"</td>";
                table_html += "<tr>";
                acumAnterior = acumAnterior + value;
                acumActual = acumActual + dataActual.data[index];
            });

            $('#resumen').html(table_html);

            $('#pie').html('<tr><td>Total General</td><td>'+ acumAnterior +'</td><td>'+ acumActual +'</td></tr>');

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
