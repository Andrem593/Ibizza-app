<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-4">
                <div class="form-group ">
                    {{ Form::label('descripción') }}
                    {{ Form::text('descripcion', $premio->descripcion, ['id' => 'txt_descripcion', 'class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
                    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('Catálogo') }}
                    @section('plugins.BootstrapSelect', true)
                    <select id="cmb_catalogo" name="catalogo_id" class="selectpicker show-tick" data-live-search="true"
                        data-width="100%" disabled>
                        <option value="">Seleccionar un catálogo</option>
                        @foreach ($catalogo as $item)
                            @if ($item->id == $premio->catalogo_id)
                                <option value="{{ $item->id }}" data-tokens="{{ $item->nombre }}" selected>
                                    {{ $item->nombre }}
                                </option>
                            @else
                                <option value="{{ $item->id }}" data-tokens="{{ $item->nombre }}">
                                    {{ $item->nombre }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {{ Form::label('Monto Mínimo Premio Acumulado') }}
                    {{ Form::text('monto_minimo_acumulado', $premio->monto_minimo_acumulado, ['id'=>'monto_minimo_acumulado','class' => 'form-control' . ($errors->has('monto_minimo_acumulado') ? ' is-invalid' : ''), 'placeholder' => 'Monto mínimo']) }}
                </div>


            </div>

            {{-- <input id="conArray" type="hidden" value="{{ !empty($condicion) ? $condicion : '' }}"> --}}
            <input id="conArray" type="hidden" value="{{ !empty($premio->condicion) ? $premio->condicion : '' }}">

            <div class="col">
                <div class="form-group">

                    {{ Form::label('condición') }}

                    <livewire:condicion />

                </div>
                <div class="table-responsive p-3">
                    <table id="example" class="display table table-striped table-sm table-hover fw-bold">
                        <thead class="bg-ibizza text-center">
                            <th>Descripción</th>
                            <th>Condición</th>
                            <th>Acumula</th>
                            <th></th>
                        </thead>
                        <tbody class="text-center">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="table-responsive p-1">
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

                    @foreach ($productos as $value)
                        <tr>
                            <td>
                                <div class="form-check">
                                    @empty($value->en_premio)
                                        <input class="form-check-input chk_seleccionar" type="checkbox">
                                    @else
                                        <input class="form-check-input chk_seleccionar" type="checkbox" checked>
                                    @endempty
                                </div>
                            </td>
                            <td>
                                <center>
                                    @empty($value->imagen_path)
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRObusbGxpV0B3_s_l06FZPdwSGrQU31j3ETA&s"
                                            class="rounded" width="80" height="60" />
                                    @else
                                        <img src="/storage/images/productos/{{ $value->imagen_path }}"
                                            class="rounded" width="80" height="60" />
                                    @endempty
                                </center>
                            </td>
                            <td>
                                {{ $value->nombre_producto }}
                            </td>
                            <td>
                                {{ $value->estilo }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{-- <div class="form-group">
            {{ Form::label('condición') }}
            {{ Form::text('condicion', $premio->condicion, ['class' => 'form-control' . ($errors->has('condicion') ? ' is-invalid' : ''), 'placeholder' => 'Condicion']) }}
            {!! $errors->first('condicion', '<div class="invalid-feedback">:message</p>') !!}
        </div> --}}
    </div>
    {{-- <div class="box-footer mt20">
        <button type="submit" class="btn btn-ibizza w-100">GUARDAR</button>
    </div> --}}
</div>
@push('css')
    <link rel="stylesheet" href="/css/botonesDataTable.css">
@endpush
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

                //destroy: true,
                "processing": true,
                "lengthMenu": [
                    [-1, 10, 25, 50],
                    ["Todo", 10, 25, 50]
                ],
                "columns": [{
                        "data": "id"
                    },
                    {
                        "data": "imagen_path"
                    },
                    {
                        "data": "nombre_producto"
                    },
                    {
                        "data": "estilo"
                    },
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
                    $(document).on('click', '.btn_guardar', myBtnGuardar);
                },
                dom: "Bfrtilp",
                buttons: {
                    buttons: [{
                        text: "GUARDAR",
                        action: function(e, dt, node, config) {
                            //trigger the bootstrap modal
                        }
                    }],
                    dom: {
                        button: {
                            tag: "button",
                            className: "btn btn-ibizza btn_guardar"
                        },
                        buttonLiner: {
                            tag: null
                        }
                    }
                }
            });

            // if (dataTable.length == 0) {
            //     dataTable.clear();
            //     dataTable.draw();
            // }

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

            function myBtnGuardar(e) {
                e.preventDefault();

                let descripcion = $('#txt_descripcion').val();
                let catalogo_id = $('#cmb_catalogo').val();
                let monto_minimo_acumulado = $('#monto_minimo_acumulado').val();
                let condicion = '';
                let premio = '';

                if (arrayFinal.length !== 0) {
                    condicion = JSON.stringify(arrayFinal)
                }

                let data = [];

                dataTable.rows().every(function() {
                    data.push({
                        estilo: this.data().estilo,
                        asignar: $(dataTable.cell(this.index(), 0).node()).find('input').is(
                            ':checked') ? 1 : 0
                    });
                });


                if (data.length !== 0) {
                    premio = JSON.stringify(data)
                }

                console.log(data);
                if (descripcion != '') {
                    $.ajax({
                        type: 'PATCH',
                        url: '{{ route('premios.update', $premio->id) }}',
                        data: {
                            descripcion,
                            catalogo_id,
                            monto_minimo_acumulado,
                            condicion,
                            premio
                        },
                        success: function(msg) {
                            dataJson = JSON.parse(msg);
                            //console.log(dataJson.mensaje);
                            if (dataJson.estado) {
                                if (dataJson.mensaje == 'ok') {
                                    Swal.fire({
                                        text: "Se actualizó el premio correctamente.",
                                        icon: 'success',
                                        allowOutsideClick: false,
                                        didDestroy: () => {
                                            window.location.href =
                                                "{{ route('premios.index') }}";
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
                } else {
                    Swal.fire({
                        text: 'Descripción es obligatoria',
                        icon: 'warning',
                        didDestroy: () => {
                            $('#txt_descripcion').focus();
                        }
                    });
                }

            }

            let dataTableCondiciones = $('#example').DataTable({
                "data": [],
                "columns": [{
                        'data': 'nombre_tabla'
                    },
                    {
                        'data': 'descripcion'
                    },
                    {
                        'data': 'acumular_valor'
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
                        $('.operador').html(
                            '<option value="=">igual</option>'
                        );
                        $('.valor').html(
                            '<option value="" selected>Seleccione un estado</option><option value="NUEVA">Nueva</option><option value="CONTINUA">Continua</option><option value="INACTIVA-1">Inactiva 1</option><option value="INACTIVA-2">Inactiva 2</option><option value="INACTIVA-3">Inactiva 3</option><option value="REACTIVA">Reactiva</option><option value="BAJA">Baja</option>'
                        );
                    } else if (valor == 'pedidos') {
                        $('.campo').html(
                            '<option value="" selected>Seleccionar campo</option><option value="total_factura">Total factura</option>'
                        );
                        $('.operador').html(
                            '<option value="" selected>Operador</option><option value=">=">mayor igual que</option><option value=">">mayor que</option>'
                        );
                        $('.valor').html(
                            '<option value="" selected>Ingrese un valor</option>'
                        );
                    }

                    // $('#nueva_regla').removeClass('d-none');
                    // $('#btn_condicion').removeClass('d-none');
                } else {
                    // $('#nueva_regla').addClass('d-none');
                    // $('#btn_condicion').addClass('d-none');
                }
            });



            $('#btn_condicion').on('click', function(e) {
                e.preventDefault();
                // Livewire.emit('recargar');
                // return ;



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
                        value: "'" + element.value + "'"
                    };
                });

                // console.log(operadorArray);
                // let condicionArray = $.map($(".condicion"), function(element) {
                //     return {
                //         name: element.options[element.selectedIndex].text,
                //         value: element.value
                //     };
                // });

                let flag = 0;
                $.each(campoArray, function(key, value) {
                    if (value.value == '' || operadorArray[key].value == '' || valorArray[key]
                        .value == '') {
                        flag = 1;
                    }
                });

                let tipo_empresaria = $('#tipo_empresaria').val();
                let chk_acumular = $('#chk_acumular').prop('checked');
                let nivel = $('#nivel').val();
                let rango_desde = $('#rango_desde').val();
                let rango_hasta = $('#rango_hasta').val();


                let nombre_tabla = $('#nombre_tabla').val();

                console.log("NOmbre tabak: ", nombre_tabla);

                if(nombre_tabla != ""){
                    if (!flag) {

                        let condiciones = '';
                        let nombres = '';
                        // $.each(campoArray, function(key, value) {
                        //     console.log(key);
                        //     condiciones += value.value + ' ' + operadorArray[key].value + ' ' +
                        //         valorArray[key].value;// + ' ' + condicionArray[key].value;
                        //     nombres += value.name + ' ' + operadorArray[key].name + ' ' +
                        //         valorArray[key].name;// + ' ' + condicionArray[key].name;
                        // });
                        // let condPart = condiciones.split(' ');
                        // condPart.pop();
                        // let condClean = condPart.toString().replace(/,/g, ' ');

                        // let namePart = nombres.split(' ');
                        // namePart.pop();
                        // let nameClean = namePart.toString().replace(/,/g, ' ');

                        let tabla = $('#nombre_tabla').val();

                        console.log("Llega", tabla, condiciones, nombres);

                        let descripcion2 = '$'+rango_desde+' - $'+rango_hasta;

                        arrayFinal.push({
                            'nombre_tabla': tipo_empresaria,
                            'descripcion':descripcion2 ,
                            'rango_desde':rango_desde,
                            'rango_hasta':rango_hasta,
                            'nivel':nivel,
                            'acumular':chk_acumular,
                            'acumular_valor':chk_acumular == 1 ? 'SI' : 'NO',
                            'tipo_empresaria':tipo_empresaria
                        });
                        console.log(arrayFinal);

                        dataTableCondiciones.clear().draw();
                        dataTableCondiciones.rows.add(arrayFinal).draw();

                        // Livewire.emit('recargar');

                        Livewire.hook('message.processed', (message, component) => {
                            inicializar_select();
                        });
                    } else {
                        Swal.fire({
                            text: 'Hay condiciones incompletas, por favor revisar',
                            icon: 'warning',
                            didDestroy: () => {
                            }
                        });
                    }
                }else{
                    Swal.fire({
                        text: 'Seleccionar la tabla',
                        icon: 'warning',
                        didDestroy: () => {
                        }
                    });
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

            let conArray = $('#conArray').val();
            console.log("conArray", conArray);
            if (conArray != '') {
                dataTableCondiciones.clear().draw();
                dataTableCondiciones.rows.add(JSON.parse(conArray)).draw();
                arrayFinal = JSON.parse(conArray);
                console.log(JSON.parse(conArray));
            }

        });
    </script>

@endpush
