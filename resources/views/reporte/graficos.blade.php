<x-app-layout>
    @section('title', 'Reporte')
    <x-slot name="header">
        <h5 class="text-center">Reportes</h5>
    </x-slot>

    <div class="card card-dark">
        <div class="card-header p-0 pt-1">
            <h3 class="text-center">Ventas mes {{$anio_anterior}} vs {{$anio_actual}}</h3>
        </div>
        <div class="card-body">

        </div>
    </div>
</x-app-layout>
