<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    {{ Form::label('descripción') }}
                    {{ Form::text('descripcion', $premio->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
                    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Catálogo') }}
                    @section('plugins.BootstrapSelect', true)
                    <select name="catalogo_id" class="selectpicker show-tick" data-live-search="true" data-width="100%">
                        <option value="">Seleccionar un catálogo</option>
                        @foreach ($catalogo as $item)
                            <option value="{{ $item->id }}" data-tokens="{{ $item->nombre }}">
                                {{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
            <div class="col">
                <div class="form-group">

                    {{ Form::label('condición') }}

                    <livewire:condicion />

                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-4">
                <div class="table-responsive p-3">
                    <table id="datatable" class="table table-striped table-hover">
                        <thead class="bg-ibizza text-center">
                            <tr>
                                <th>Seleccionar<br>
                                    <div class="form-check"><input id="all" class="form-check-input"
                                            type="checkbox">
                                    </div>
                                </th>
                                <th>Foto</th>
                                <th>Producto</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col">
                <div class="table-responsive p-3">
                    <table id="example" class="display table table-striped table-sm table-hover fw-bold">
                        <thead class="bg-ibizza text-center">
                            <th>Descripción</th>
                            <th>Condición</th>
                            <th></th>
                        </thead>
                        <tbody class="text-center">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="form-group">
            {{ Form::label('condición') }}
            {{ Form::text('condicion', $premio->condicion, ['class' => 'form-control' . ($errors->has('condicion') ? ' is-invalid' : ''), 'placeholder' => 'Condicion']) }}
            {!! $errors->first('condicion', '<div class="invalid-feedback">:message</p>') !!}
        </div> --}}
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-ibizza w-100">GUARDAR</button>
    </div>
</div>
@push('js')
    <script>
        let espanol = {
            "sProcessing": '<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div>',
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad"
            }
        }
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            });

            let arrayFinal = [];

            function inicializar_select() {
                $(".editable").select2({
                    tags: true
                });
                $(".no-editable").select2({
                    minimumResultsForSearch: Infinity
                });
            }

            inicializar_select();

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
                ],
                "lengthMenu": [
                    [-1, 10, 25, 50],
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
                    //$(document).on('click', '.btn_asignar', myBtnAsignar);
                },
                dom: "Bfrtilp",
                buttons: {
                    buttons: [{
                        text: "Seleccionar Premios",
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

            let dataTableCondiciones = $('#example').DataTable({
                "data": [],
                "columns": [{
                        'data': 'nombre_tabla'
                    },
                    {
                        'data': 'descripcion'
                    },
                    {
                        'data': 'descripcion',
                        "render": function(data, type, row) {
                            return '<button class="btn btn-danger remove"><i class="fas fa-trash-alt"></i></button>';
                        }
                    },
                ],
                "paging": false,
                "ordering": false,
                "info": false,
                "responsive": false,
                "autoWidth": false,
                "searching": false,
                "language": espanol
            });

            

            $('#nombre_tabla').on('change', function(e) {

                let valor = $('#nombre_tabla').val();
                console.log(valor);
                if (valor != '0') {

                    if (valor == 'empresarias') {
                        $('.campo').html(
                            '<option value="" selected>Seleccionar campo</option><option value="tipo_cliente">Tipo Cliente</option>'
                            );
                    } else if (valor == 'pedidos') {
                        $('.campo').html(
                            '<option value="" selected>Seleccionar campo</option><option value="total_factura">Total factura</option>'
                            );
                    }

                    $('#nueva_regla').removeClass('d-none');
                    $('#btn_condicion').removeClass('d-none');
                } else {
                    $('#nueva_regla').addClass('d-none');
                    $('#btn_condicion').addClass('d-none');
                }
            });

            

            $('#btn_condicion').on('click', function(e) {
                e.preventDefault();

                let campoArray = $.map($(".campo"), function(element) {
                    return {
                        name: element.options[element.selectedIndex].text,
                        value: element.value
                    };
                });
                let operadorArray = $.map($(".operador"), function(element) {
                    return {
                        name: element.options[element.selectedIndex].text,
                        value: element.value
                    };
                });
                let valorArray = $.map($(".valor"), function(element) {
                    return {
                        name: element.options[element.selectedIndex].text,
                        value: element.value
                    };
                });
                console.log(operadorArray);
                let condicionArray = $.map($(".condicion"), function(element) {
                    return {
                        name: element.options[element.selectedIndex].text,
                        value: element.value
                    };
                });

                let flag = 0;
                $.each(campoArray, function(key, value) {
                    if (value.value == '' || operadorArray[key].value == '' || valorArray[key]
                        .value == '') {
                        flag = 1;
                    }
                });

                if (!flag) {

                    let condiciones = '';
                    let nombres = '';
                    $.each(campoArray, function(key, value) {
                        console.log(key);
                        condiciones += ' ' + value.value + ' ' + operadorArray[key].value + ' ' +
                            valorArray[key].value + ' ' + condicionArray[key].value;
                        nombres += ' ' + value.name + ' ' + operadorArray[key].name + ' ' +
                            valorArray[key].name + ' ' + condicionArray[key].name;
                    });
                    let condPart = condiciones.split(' ');
                    condPart.pop();
                    let condClean = condPart.toString().replace(/,/g, ' ');

                    let namePart = nombres.split(' ');
                    namePart.pop();
                    let nameClean = namePart.toString().replace(/,/g, ' ');

                    let tabla = $('#nombre_tabla').val();

                    arrayFinal.push({
                        'nombre_tabla': tabla,
                        'condicion': $.trim(condClean),
                        'descripcion': $.trim(nameClean)
                    });
                    console.log(arrayFinal);

                    // let result = JSON.parse(arrayFinal);
                    // console.log(result);
                    dataTableCondiciones.clear().draw();
                    dataTableCondiciones.rows.add(arrayFinal).draw();

                    Livewire.emit('recargar');

                    Livewire.hook('message.processed', (message, component) => {
                        inicializar_select();
                    })


                } else {
                    alert('Hay condiciones incompletas, por favor revisar');
                }
            });

            $(document).on('click', '#btn_regla', function(e) {
                e.preventDefault();
                $("#nueva_regla").find('select').select2('destroy');
                let liItem = $('.clone-div:first').clone();
                liItem.find('.remover_regla').html(
                    '<button class="btn btn-danger removeRegla"><i class="fas fa-minus"></i></button>');
                //Append the clone to the list item. But this only works once!
                $('#nueva_regla').append(liItem);

                inicializar_select();
            });

            $('#example').on('click', '.remove', function(e) {
                e.preventDefault();
                console.log(dataTableCondiciones.row($(this).parents()).index());
                arrayFinal.splice(dataTableCondiciones.row($(this).parents()).index(), 1);
                //console.log($(this).index());
                dataTableCondiciones.row($(this).parents())
                    .remove()
                    .draw();
                console.log(arrayFinal);

            });

            $(document).on('click', 'button.removeRegla', function(e) {
                e.preventDefault();
                $(this).closest('div.clone-div').remove();
            });



        });
    </script>

@endpush
