<x-app-layout>
    @section('title', 'Proveedor')
    <x-slot name="header">
        <h5 class="text-center">Proveedores</h5>
    </x-slot>

    <div class="card">

        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Proveedor') }}
                </span>

                <div class="float-right">
                    <a href="{{ route('proveedores.create') }}" class="btn btn-ibizza btn-sm float-right"
                        data-placement="left">
                        {{ __('Nuevo Proveedor') }}
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
                                <label for="">Seguro de Eliminar Proveedor: </label>
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
                var data = {
                    funcion: 'listar_todo',
                }
                let ruta = '/proveedor/datatable'
                crearTablaProveedor(data, ruta);
            });
        </script>
    @endpush
</x-app-layout>
