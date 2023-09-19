<x-app-layout>
    @section('title', 'Dashboard')
    <x-slot name="header" class="m-0">
        <div class="card p-2">
            <div class="row d-flex justify-content-start py-2">
                <div class="col-lg-6 col-md-6">
                    <h2 class="font-weight-bold mb-0">Hola, {{ Auth::user()->name }} 👋</h2>
                    <p class="lead text-muted">Revisa la última información</p>
                </div>
            </div>
        </div>
    </x-slot>
    {{-- seccion de cards de informacion principal --}}
    <div class="row">
        {{-- <div class="col">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-book-reader"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Ventas Catalogo</span>
                    <span class="info-box-number">
                        {{$ventaCatalogo}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div> ---}}
        <!-- /.col -->
        <div class="col">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shoe-prints"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Productos</span>
                    <span class="info-box-number">{{$productos}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Ventas</span>
                    <span class="info-box-number">{{$ventas}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Empresarias</span>
                    <span class="info-box-number">{{$empresarias}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    {{-- seccion de graficos con metas --}}
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">VENTAS
                            <b>{{Str::upper(\Carbon\Carbon::now()->formatLocalized('%B'))}}</b>
                        </h3>

                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="text-bold text-lg"><i class="fas fa-shopping-bag"></i>
                                {{$ventasMes->count()}}</span>
                            <span>Ventas en el mes actual</span>
                        </p>
                        <p class="ml-auto my-auto d-flex flex-column text-right">
                            <span class="text-success">
                                <i class="fas fa-arrow-up"></i> 12.5%
                            </span>
                            <span class="text-muted">Since last week</span>
                        </p>
                    </div>

                    <div class="position-relative mb-4">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="visitors-chart" height="200" width="769"
                            style="display: block; width: 769px; height: 200px;"
                            class="chartjs-render-monitor"></canvas>
                    </div>
                    <div class="d-flex flex-row justify-content-end">
                        <span class="mr-2">
                            <i class="fas fa-square text-primary"></i> Esta Semana
                        </span>
                        <span>
                            <i class="fas fa-square text-gray"></i> Semana Pasada
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">ULTIMAS VENTAS</h3>                    
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Empresaria</th>
                                <th>Cantidad</th>
                                <th>Venta</th>
                                <th>Mas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @empty(!$ventasCliente)
                                @foreach ($ventasCliente as $val )                                    
                                <tr>
                                    <td>
                                        @php
                                            $imagen_defecto = 'https://ui-avatars.com/api/?name='.$val->nombres." ".$val->apellidos.'&color=7F9CF5&background=EBF4FF'
                                        @endphp
                                        <img src="{{$val->profile_photo_path != '' ? 'storage/'.$val->profile_photo_path : $imagen_defecto}}"                                             
                                            class="img-circle img-size-32 mr-2" style="max-height: 30px">
                                            {{$val->nombres." ".$val->apellidos}}
                                    </td>
                                    <td># {{$val->cantidad_total}} </td>
                                    <td>
                                        ${{$val->total_venta}} USD
                                    </td>
                                    <td>
                                        <a href="{{route('ventas.index')}}" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endempty
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @push('js')
    <script>
        /* global Chart:false */
    
                $(function() {
                    'use strict'
    
                    var ticksStyle = {
                        fontColor: '#495057',
                        fontStyle: 'bold'
                    }
    
                    var mode = 'index'
                    var intersect = true
    
                    var $salesChart = $('#sales-chart')
                    // eslint-disable-next-line no-unused-vars
                    var salesChart = new Chart($salesChart, {
                        type: 'bar',
                        data: {
                            labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
                            datasets: [{
                                    backgroundColor: '#007bff',
                                    borderColor: '#007bff',
                                    data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
                                },
                                {
                                    backgroundColor: '#ced4da',
                                    borderColor: '#ced4da',
                                    data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
                                }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: mode,
                                intersect: intersect
                            },
                            hover: {
                                mode: mode,
                                intersect: intersect
                            },
                            legend: {
                                display: false
                            },
                            scales: {
                                yAxes: [{
                                    // display: false,
                                    gridLines: {
                                        display: true,
                                        lineWidth: '4px',
                                        color: 'rgba(0, 0, 0, .2)',
                                        zeroLineColor: 'transparent'
                                    },
                                    ticks: $.extend({
                                        beginAtZero: true,
    
                                        // Include a dollar sign in the ticks
                                        callback: function(value) {
                                            if (value >= 1000) {
                                                value /= 1000
                                                value += 'k'
                                            }
    
                                            return '$' + value
                                        }
                                    }, ticksStyle)
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: ticksStyle
                                }]
                            }
                        }
                    })
    
                    var $visitorsChart = $('#visitors-chart')
                    // eslint-disable-next-line no-unused-vars
                    var visitorsChart = new Chart($visitorsChart, {
                        data: {
                            labels: ['lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
                            datasets: [{
                                    type: 'line',
                                    data: [100, 120, 170, 167, 180, 177, 160],
                                    backgroundColor: 'transparent',
                                    borderColor: '#007bff',
                                    pointBorderColor: '#007bff',
                                    pointBackgroundColor: '#007bff',
                                    fill: false
                                    // pointHoverBackgroundColor: '#007bff',
                                    // pointHoverBorderColor    : '#007bff'
                                },
                                {
                                    type: 'line',
                                    data: [60, 80, 70, 67, 80, 77, 100],
                                    backgroundColor: 'tansparent',
                                    borderColor: '#ced4da',
                                    pointBorderColor: '#ced4da',
                                    pointBackgroundColor: '#ced4da',
                                    fill: false
                                    // pointHoverBackgroundColor: '#ced4da',
                                    // pointHoverBorderColor    : '#ced4da'
                                }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                mode: mode,
                                intersect: intersect
                            },
                            hover: {
                                mode: mode,
                                intersect: intersect
                            },
                            legend: {
                                display: false
                            },
                            scales: {
                                yAxes: [{
                                    // display: false,
                                    gridLines: {
                                        display: true,
                                        lineWidth: '4px',
                                        color: 'rgba(0, 0, 0, .2)',
                                        zeroLineColor: 'transparent'
                                    },
                                    ticks: $.extend({
                                        beginAtZero: true,
                                        suggestedMax: 200
                                    }, ticksStyle)
                                }],
                                xAxes: [{
                                    display: true,
                                    gridLines: {
                                        display: false
                                    },
                                    ticks: ticksStyle
                                }]
                            }
                        }
                    })
                })
    
    </script>
    @endpush
</x-app-layout>