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
                            <th>Seleccionar<br>
                                <div class="form-check"><input id="all" class="form-check-input" type="checkbox">
                                </div>
                            </th>
                            <th>Foto</th>
                            <th>Producto</th>
                            <th>Estilo</th>
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });
                
                let dataTable = $('#datatable').DataTable({

                    destroy: true,
                    "processing": true,
                    // "ajax": {
                    //     "url": ruta,
                    //     "method": "POST",
                    //     "data": data,
                    //     "dataSrc": function(json) {
                    //         if (json == 'no data') {
                    //             return [];
                    //         } else {
                    //             return json;
                    //         }
                    //     },
                    // },
                    "data": [],
                    "columns": [{
                            "data": "id",
                            "render": function(data, type, row) {
                                let estado =
                                    '<div class="form-check"><input class="form-check-input chk_seleccionar" type="checkbox"></div>';
                                if (row['en_catalogo'] != null) {
                                    estado =
                                        '<div class="form-check"><input class="form-check-input chk_seleccionar" type="checkbox" checked></div>'
                                }
                                return estado;
                            }
                        },
                        {
                            "data": "imagen_path",
                            "render": function(data, type, row) {
                                let image =
                                    'https://www.blackwallst.directory/images/NoImageAvailable.png';
                                if (data != '' && data != null) {
                                    image = '/storage/images/productos/' + data
                                }
                                return '<center><img  src="' + image +
                                    '"class="rounded" width="80" height="60" /> </center>';
                            }
                        },
                        {
                            "data": "nombre_producto"
                        },
                        {
                            "data": "estilo"
                        },
                    ],
                    "lengthMenu": [
                        [-1, 10, 25, 50 ],
                        ["Todo", 10, 25, 50]
                    ],
                    "columnDefs": [{
                            "targets": [0, 1],
                            "orderable": false,
                            "searchable": false
                        },
                        //{ "width": "1%", "targets": 0 }
                    ],
                    "order": [
                        [2, 'asc']
                    ],
                    "language": espanol,
                    //para usar los botones
                    responsive: false,
                    autoWidth: false,
                    initComplete: function(row, data, start, end, display) {
                        $(document).on('click', '.btn_asignar', myBtnAsignar);
                    },
                    dom: "Bfrtilp",
                    buttons: {
                        buttons: [{
                            text: "Actualizar Catálogo",
                            action: function(e, dt, node, config) {
                                //trigger the bootstrap modal
                            }
                        }],
                        dom: {
                            button: {
                                tag: "button",
                                className: "btn btn-ibizza btn_asignar"
                            },
                            buttonLiner: {
                                tag: null
                            }
                        }
                    }
                });
                if (dataTable.length == 0) {
                    dataTable.clear();
                    dataTable.draw();
                }

                $('#all').on('click', function() {
                    if (this.checked) {
                        $('.chk_seleccionar').each(function() {
                            this.checked = true;
                        });
                    } else {
                        $('.chk_seleccionar').each(function() {
                            this.checked = false;
                        });
                    }
                });

                function myBtnAsignar() {
                    console.log("hola");
                    let data = [];

                    dataTable.rows().every(function() {
                        //if (this.data().terminado == 0) {
                        data.push({
                            estilo: this.data().estilo,
                            asignar: $(dataTable.cell(this.index(), 0).node()).find('input').is(
                                ':checked') ? 1 : 0
                        });


                        //}
                    });


                    if (data.length !== 0) {
                        let catalogo_id = $('#mySelect').val();

                        let jsonData = {
                            catalogo_id,
                            data
                        }

                        console.log(jsonData);

                        $.ajax({
                            type: 'POST',
                            url: '/catalogo/asignarProducto',
                            data: {
                                jsonData: JSON.stringify(jsonData)
                            },
                            success: function(msg) {
                                dataJson = JSON.parse(msg);
                                //console.log(dataJson.mensaje);
                                if (dataJson.estado) {
                                    if (dataJson.mensaje == 'ok') {
                                        Swal.fire({
                                            text: "Se actualizó el catalogo.",
                                            icon: 'success',
                                            allowOutsideClick: false,
                                            didDestroy: () => {
                                                // limpiar();
                                                // //dataTable.draw();
                                                //dataTable.ajax.reload();
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            text: dataJson.mensaje,
                                            icon: 'warning',
                                            didDestroy: () => {}
                                        });
                                    }
                                } else {
                                    Swal.fire({
                                        text: dataJson.mensaje,
                                        icon: 'error',
                                        didDestroy: () => {}
                                    });
                                    //console.log(dataJson.mensaje);
                                }
                            }
                        });
                    }
                }

                $('#mySelect').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                    

                    let id_catalogo = $('#mySelect').val();
                    let ruta = '/catalogo/datatable';

                    var data = {
                        funcion: 'listar_catalogo_producto',
                        id_catalogo
                    }                    

                    if (id_catalogo != '') {
                        $.ajax({
                            url: "/catalogo/datatable",
                            type: "POST",
                            data: data,
                        }).done(function (result) {
                            
                            result = JSON.parse(result);
                            console.log(result);
                            dataTable.clear().draw();
                            dataTable.rows.add(result).draw();
                        })
                    } else {
                        dataTable.clear().draw();
                    }
                });


            });
        </script>
    @endpush

</x-app-layout>
