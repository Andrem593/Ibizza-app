<x-app-layout>
    @section('title', 'Reporte')
    <x-slot name="header">
        <h5 class="text-center">Reportes</h5>
    </x-slot>

    <div class="card">

        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Reporte') }}
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
                <table id="datatable" class="display table table-striped table-sm table-hover fw-bold" >
                    <thead class="bg-ibizza text-center">
                        <tr>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th></th>                            
                        </tr>
                    </thead>
                    <tbody class="text-center">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
