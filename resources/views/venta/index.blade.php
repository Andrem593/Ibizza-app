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
                    <table id="datatable" class="display table table-striped table-sm table-hover fw-bold" style="font-size: 12px">
                        <thead class="bg-ibizza text-center">
                            <tr>
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
