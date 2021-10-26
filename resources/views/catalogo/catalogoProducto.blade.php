<x-app-layout>
    @section('title', 'Catálogo')
        <x-slot name="header">
            <h5 class="text-center">Asignar productos</h5>
        </x-slot>
        <div class="card">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">

                    <span id="card_title">
                        {{ __('Catálogo') }}
                    </span>

                    <div class="float-right">
                        <a href="{{ route('catalogos.create') }}" class="btn btn-ibizza btn-sm float-right"
                            data-placement="left">
                            {{ __('Nuevo Catálogo') }}
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
            @section('plugins.BootstrapSelect', true)
                <div class="form-group">
                    <select id="mySelect" class="selectpicker show-tick" data-live-search="true" data-width="100%">
                        <option value="">Seleccionar un catálogo</option>
                        @foreach ($catalogo as $item)
                            <option value="{{ $item->id }}" data-tokens="{{ $item->nombre }}">{{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="table-responsive p-3">
                    <table id="datatable" class="table table-striped table-hover">
                        <thead class="bg-ibizza text-center">
                            <tr>
                                <th></th>
                                <th>Producto</th>
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
        @push('modals')
            <div class="modal" id="eliminar" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Eliminar Elemento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="form_eliminar" action="" method="POST">
                                <div class="form-group">
                                    <label for="">Seguro de Eliminar Producto: </label>
                                    <label id="elemento_eliminar"></label>
                                    <input type="hidden" id="id_eliminar">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endpush
        @Push('scripts')
            <script src="/js/crearDataTable.js"></script>
            <script>
                $(document).ready(function() {
                    // var data = {
                    //     funcion: 'listar_todo',
                    // }
                    // let ruta = '/catalogo/datatable'
                    // crearTablaCatalogo(data, ruta);

                    $('#mySelect').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                        console.log($('#mySelect').val());

                        let id_catalogo = $('#mySelect').val();
                        let ruta = '/catalogo/datatable';

                        var data = {
                            funcion: 'listar_catalogo_producto',
                            id_catalogo
                        }
                        
                        crearTablaCatalogoProducto(data, ruta);
                    });

                });

            </script>
        @endpush

    </x-app-layout>
