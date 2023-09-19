<x-app-layout>
    @section('title', 'Pedidos')
    <x-slot name="header">
        <h5 class="">Pedidos Reservados</h5>
    </x-slot>
    <div class="card w-100 mx-auto shadow-sm">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Lista de Pedidos') }}
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
                            <th># Pedido</th>
                            <th>Empresaria</th>
                            <th>Tipo Empresaria</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                            <th>Asesor</th>
                            <th>Fecha Emisión</th>
                            <th>Fecha Vencimiento</th>
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
        <script src="/js/crearDataTable?id={{ rand().md5(10) }}.js"></script>
        <script>
            $(document).ready(function() {
                var data = {
                    funcion: 'listar_todo',
                }
                let ruta = '/venta/datatable/reservas'
                crearTablaReservas(data, ruta);
            });
        </script>
    @endpush

</x-app-layout>
