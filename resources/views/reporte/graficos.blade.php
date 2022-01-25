<x-app-layout>
    @section('title', 'Reporte')
    <x-slot name="header">
        <h5 class="text-center">Reportes</h5>
    </x-slot>

    <div class="card card-dark">
        <div class="card-header p-0 pt-1">
            <h3 class="text-center">Ventas mes {{ $anio_anterior }} vs {{ $anio_actual }}</h3>
        </div>
        <div class="card-body">
            <canvas id="myChart" width="200" height="200"></canvas>
        </div>
    </div>
    @push('js')
        <script>
            var dataAnterior = JSON.parse('<?= $anterior ?>');
            var dataActual = JSON.parse('<?= $actual ?>');
            console.log(dataAnterior);
            console.log(dataActual);
            var ctx = $('#myChart');

            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre',
                        'Octubre', 'Noviembre', 'Diciembre'
                    ],
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
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    },
                    responsive: true,
                }
            });
        </script>
    @endpush
</x-app-layout>
