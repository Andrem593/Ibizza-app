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
                        <div class="table-responsive p-3">
                            <table id="datatable" class="display table table-striped table-sm table-hover fw-bold">
                                <thead class="bg-ibizza text-center">
                                    <tr>
                                        <th>FOTO</th>
                                        <th>ESTILO</th>
                                        <th>COLOR</th>
                                        <th>OPCIONES</th>
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
                                <div id="carga2" class="overlay" style="visibility: hidden">
                                    <i class="fas fa-2x fa-sync fa-spin"></i>
                                </div>
                                <div class="modal-header">
                                    <h5 class="modal-title">Eliminar Elemento</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="texto2" class="alert alert-danger w-100 text-center" role="alert"></div>
                                    <form id="form_eliminar" enctype="multipart/form-data">
                                        <input type="hidden" name="estilos" id="estilo2">
                                        <input type="hidden" name="color" id="color2">
                                        <input type="hidden" name="ant_img" id="imagen_path2">
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
                    <div class="modal" id="editar" tabindex="-1" role="dialog">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div id="carga" class="overlay" style="visibility: hidden">
                                    <i class="fas fa-2x fa-sync fa-spin"></i>
                                </div>
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Elemento</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div id="texto" class="alert alert-info w-100 text-center" role="alert"></div>
                                    <form id="form_editar" enctype="multipart/form-data">
                                        <input type="hidden" name="estilos" id="estilo">
                                        <input type="hidden" name="color" id="color">
                                        <input type="hidden" name="ant_img" id="imagen_path">
                                        @livewire('imagen')
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    @csrf
                                    <button type="submit" class="btn btn-ibizza">Guardar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endpush
                @Push('scripts')
                    <script src="/js/crearDataTable.js"></script>
                    <script>
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: false,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })
                        $(document).ready(function() {
                            crearDataTable();
                        });

                        $('#form_editar').submit(e => {
                            e.preventDefault();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                            });
                            var formData = new FormData();
                            var files = $('#file')[0].files[0]
                            formData.append('file', files);
                            formData.append('funcion', 'editar_estilo');
                            formData.append('estilo', $('#estilo').val());
                            formData.append('color', $('#color').val());
                            formData.append('ant_img', $('#imagen_path').val());
                            $.post({
                                url: '/producto/datatable',
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                    $('#carga').css('visibility','visible');
                                },
                                success: function(response) {
                                    $('#carga').css('visibility','hidden');
                                    $('#editar .close').click();
                                    if (response['message'] != 'error') {
                                        crearDataTable();
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Se modificaron ' + response['num'] +
                                                ' registros'
                                        })
                                    } else {
                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Error al editar'
                                        })
                                    }
                                }
                            })
                        })
                        $('#form_eliminar').submit(e => {
                            e.preventDefault();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                            });
                            var formData = new FormData();
                            formData.append('funcion', 'eliminar_estilo');
                            formData.append('estilo', $('#estilo2').val());
                            formData.append('color', $('#color2').val());
                            formData.append('ant_img', $('#imagen_path2').val());
                            $.post({
                                url: '/producto/datatable',
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                    $('#carga2').css('visibility','visible');
                                },
                                success: function(response) {
                                    $('#carga2').css('visibility','hidden');
                                    $('#eliminar .close').click();
                                    if (response['message'] != 'error') {
                                        crearDataTable();
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Se Elimino la imagen de ' + response['num'] +
                                                ' registros'
                                        })
                                    } else {
                                        Toast.fire({
                                            icon: 'error',
                                            title: 'Error al eliminar'
                                        })
                                    }
                                }
                            })
                        })
                        function crearDataTable() {
                            var data = {
                                funcion: 'listar_estilos',
                            }
                            let ruta = '/producto/datatable';
                            crearTablaEstilos(data, ruta);
                        }
                    </script>
                @endpush
            </div>
        </div>
    </x-app-layout>
