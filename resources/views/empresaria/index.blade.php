<x-app-layout>
    @section('title', 'Empresarias')
    <x-slot name="header">
        <h5 class="text-center">Marcas</h5>
    </x-slot>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Empresaria') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('empresarias.create') }}" class="btn btn-ibizza btn-sm float-right"  data-placement="left">
                                    <i class="fas fa-address-card me-1"></i>{{ __('Crear Empresaria') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <table id="datatable" class="display table table-striped table-sm table-hover fw-bold">
                                <thead class="bg-ibizza text-center">
                                    <tr>
                                        <th>CEDULA</th>
                                        <th>NOMBRES</th>
                                        <th>FECHA NACIMIENTO</th>
                                        <th>TELEFONO</th>
                                        <th>CIUDAD</th>
                                        <th>CLIENTE</th>
                                        <th>VENDEDOR</th>
                                        <th>ESTADO</th>
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
                    let ruta = '/empresaria/datatable'
                    crearTablaEmpresarias(data, ruta);
                });

            </script>
        @endpush
            </div>
        </div>
    </div>
</x-app-layout>