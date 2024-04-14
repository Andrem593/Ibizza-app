<x-app-layout>
    @section('title', 'Productos')
    {{-- @endsection --}}

    <x-slot name="header">
        <h5 class="text-center">Productos</h5>
    </x-slot>


    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">

                        <span id="card_title">
                            {{ __('Producto') }}
                        </span>

                        <div class="float-right">
                            <a href="{{ route('producto.estilos') }}" class="btn btn-ibizza btn-sm ms-2 float-right"
                                data-placement="left">
                                {{ __('Estilos y Color') }}
                            </a>
                            <a href="{{ route('producto.upload') }}" class="btn btn-ibizza btn-sm float-right"
                                data-placement="left">
                                {{ __('Carga Productos') }}
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

                    <div class="row">
                        <h5>Filtro de Productos</h5>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="catalogo">Catalogo</label>
                                    <select class="form-select" id="catalogo">
                                        <option>Selecione el catalogo</option>
                                        @foreach ($catalogos as $catalogo)
                                            <option value="{{ $catalogo->id }}">{{ $catalogo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="desde">Desde</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="hasta">Hasta</label>
                                    <input type="date" class="form-control">                                    
                                </div>
                            </div>
                            <div class="col d-flex align-items-center">
                                <button class="btn btn-ibizza mt-2" onclick="filtro()">
                                    <i class="fas fa-search"></i>                                                                                                                                                
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="datatable" class="display table table-striped table-sm table-hover fw-bold"
                            style="font-size: 10px">
                            <thead class="bg-ibizza">
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>FOTO</th>
                                    <th>SKU</th>
                                    <th>DESCRIPCION</th>
                                    <th>MARCA</th>
                                    <th>CLASIFICACION</th>
                                    <th>CATEGORIA</th>
                                    <th>GÉNERO</th>
                                    <th>ESTILO</th>
                                    <th>COLOR</th>
                                    <th>TALLA</th>
                                    <th>CANTIDAD</th>
                                    <th>STOCK</th>
                                    <th>CATÁLOGO</th>
                                    <th>PRECIO CATALOGO</th>
                                    <th>ESTADO</th>
                                    <th>OBSERVACIONES</th>
                                    <th>CLASIFICACION_GLOBAL</th>
                                    <th>TIPO_PRODUCTO</th>
                                    <th>COSTO_RP3</th>
                                </tr>
                            </thead>
                            <tbody>

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
                <script src="/js/crearDataTable2.js?id={{ rand().md5(10) }}"></script>
                <script>
                    $(document).ready(function() {
                        var data = {
                            funcion: 'listar_todo',
                        }
                        let ruta = '/producto/datatable'
                        crearTabla(data, ruta);
                    });

                    function filtro() {
                        var catalogo = $('#catalogo').val();
                        var desde = $('#desde').val();
                        var hasta = $('#hasta').val();
                        var data = {
                            funcion: 'filtro',
                            catalogo: catalogo,
                            desde: desde,
                            hasta: hasta,
                        }
                        let ruta = '/producto/datatable'
                        crearTabla(data, ruta);
                    }
                </script>
            @endpush
        </div>
    </div>
</x-app-layout>
{{-- insertar codigo js --}}
