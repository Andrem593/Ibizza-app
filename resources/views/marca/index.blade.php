<x-app-layout>
    @section('title', 'Marcas')
        <x-slot name="header">
            MARCAS
            <a href="{{ route('marcas.create') }}" class="btn btn-secondary btn-sm float-right" data-placement="left">
                {{ __('Nueva Marca') }}
            </a>
        </x-slot>
        <div class="card">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="display table table-striped table-sm table-hover fw-bold" style="font-size: 10px">
                        <thead class="bg-ibizza">
                            <tr>
                                <th></th>
                                <th>Nombre</th>
                                <th>Imagen</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
<<<<<<< HEAD
                            {{-- @foreach ($marcas as $marca)
                                <tr>
                                    <td class="my-auto">{{ ++$i }}</td>

                                    <td class="my-auto">{{ $marca->nombre }}</td>
                                    <td class="my-auto"><img src="/storage/images/marca/{{ $marca->imagen }}"
                                            width="100px" class="rounded img-fluid"
                                            style="max-height: 80px; width: auto">
                                    </td>
                                    <td class="my-auto">{{ $marca->estado }}</td>

                                    <td class="my-auto">
                                        <form action="{{ route('marcas.destroy', $marca->id) }}" method="POST">

                                            <div class="btn-group">
                                                <a class="btn btn-secondary"
                                                    href="{{ route('marcas.show', $marca->id) }}">
                                                    <i class="fa fa-fw fa-eye"></i> Ver
                                                </a>
                                                <a class="btn btn-primary" href="{{ route('marcas.edit', $marca->id) }}">
                                                    <i class="fa fa-fw fa-edit"></i> Editar
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    href="{{ route('marcas.show', $marca->id) }}">
                                                    <i class="fa fa-fw fa-trash"></i> Eliminar
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach --}}
=======
                            
>>>>>>> 36d593e931f7e4a0f2d8863aa27526c7831e1f0e
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
                    var data = {
                        funcion: 'listar_todo',
                    }
                    let ruta = '/marca/datatable'
                    crearTablaMarca(data, ruta);
                });

            </script>
        @endpush
    </x-app-layout>
