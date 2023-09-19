<x-app-layout>
    @section('title', 'Empresarias')
    <x-slot name="header">
        <h5 class="text-center">Empresarias</h5>
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
                                <a href="{{ route('empresarias.create') }}" class="btn btn-ibizza btn-sm float-right"
                                    data-placement="left">
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
                        <div class="row">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="desde">Desde</label>
                                        <input type="date" id="desde" class="form-control">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="hasta">Hasta</label>
                                        <input type="date" id="hasta" class="form-control">
                                    </div>
                                </div>
                                <div class="col d-flex align-items-center">
                                    <button class="btn btn-ibizza mt-2" onclick="filtro()">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="ml-2 btn btn-danger mt-2" onclick="borrar()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-3">
                            <table id="datatable" class="display table table-striped table-sm table-hover fw-bold">
                                <thead class="bg-ibizza text-center">
                                    <tr>
                                        <th>IDENTIFICACIÓN</th>
                                        <th>NOMBRE</th>
                                        <th>FECHA NACIMIENTO</th>
                                        <th>TELEFONO</th>
                                        <th>CIUDAD</th>
                                        <th>TIPO EMPRESARIA</th>
                                        <th>ASESOR</th>
                                        <th>FECHA REGISTRO</th>
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
                @push('modals')
                    <div class="modal" id="eliminar" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Eliminar Empresaria</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="form_eliminar" action="" method="POST">
                                        <div class="form-group">
                                            <label for="">Seguro de eliminar a la Empresaria: </label>
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
                    <script src="/js/crearDataTable.js?id={{ rand().md5(10) }}"></script>
                    <script>
                        $(document).ready(function() {
                            var data = {
                                funcion: 'listar_todo',
                            }
                            let ruta = '/empresaria/datatable'
                            crearTablaEmpresarias(data, ruta);
                        });

                        function filtro() {                                                
                            var desde = $('#desde').val();
                            var hasta = $('#hasta').val();
                            var data = {
                                funcion: 'filtro',
                                desde: desde,
                                hasta: hasta,
                            }                            
                            let ruta = '/empresaria/datatable'
                            crearTablaEmpresarias(data, ruta);
                        }
                        function borrar(){
                            $('#desde').val('');
                            $('#hasta').val('');
                            var data = {
                                funcion: 'listar_todo',
                            }
                            let ruta = '/empresaria/datatable'
                            crearTablaEmpresarias(data, ruta);
                        }
                    </script>
                @endpush
            </div>
        </div>
    </div>
</x-app-layout>
