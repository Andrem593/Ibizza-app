<div class="box box-info padding-1">
    <div class="box-body">
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
                    <option value="{{ $item->id }}" data-tokens="{{ $item->nombre }}">{{ $item->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">

            {{ Form::label('condición') }}

            <livewire:condicion />

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
            let arrayFinal = [];

            let clone = "";
            console.log(clone);

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
                            return '<button class="remove">DEL</button>';
                        }
                    },
                ],
                "paging": false,
                "ordering": false,
                "info": false,
                "responsive": false,
                "autoWidth": false,
                "language": espanol
            });

            function inicializar_select() {
                $(".editable").select2({
                    tags: true
                });
                $(".no-editable").select2({
                    minimumResultsForSearch: Infinity
                });
            }

            $('#nombre_tabla').on('change', function(e) {

                let valor = $('#nombre_tabla').val();
                console.log(valor);
                if (valor != '0') {
                    $('#nueva_regla').removeClass('d-none');
                    $('#btn_condicion').removeClass('d-none');                    
                    if(clone == ""){
                        $('.editable, .no-editable').select2('destroy');
                        clone = $( ".clone-div" ).clone(true);
                        clone.find('.remover_regla').html('<button class="btn btn-danger removeRegla"><i class="fas fa-minus"></i></button>');
                        
                        inicializar_select();
                    }
                    
                } else {
                    clone = "";
                    $('#nueva_regla').addClass('d-none');
                    $('#btn_condicion').addClass('d-none');
                }
                console.log(clone);
            });

            inicializar_select();

            $('#btn_condicion').on('click', function(e) {
                e.preventDefault();

                let nombreTablaArray = $.map($(".nombreTabla"), function(element) {
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
                $.each(nombreTablaArray, function(key, value) {
                    if (value.value == '' || operadorArray[key].value == '' || valorArray[key]
                        .value == '') {
                        flag = 1;
                    }
                });

                if (!flag) {

                    let condiciones = '';
                    let nombres = '';
                    $.each(nombreTablaArray, function(key, value) {
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
                        clone = "";
                        inicializar_select();
                    })                    

                    //$('#nueva_condicion').removeClass('d-none');
                    //$('#nueva_regla').addClass('d-none');
                    //$('#btn_condicion').addClass('d-none');

                    // $('#nueva_condicion').empty();

                    // let someText = $.parseHTML(clone[0].innerHTML);
                    // console.log(someText);
                    // $('#nueva_condicion').append(someText);

                    // $('#nueva_condicion').html('<div class="row"> <div class="col"> <select id="nombre_tabla" class="selectpicker show-tick" data-live-search="true" data-width="100%"> <option value="0">Seleccionar tabla</option> <option value="marcas" data-tokens="">Marca</option> <option value="empresarias" data-tokens="">Empresaria</option> <option value="pedidos" data-tokens="">Venta</option> </select> </div> </div> <div id="nueva_regla" class="d-none"> <div class="row py-2 clone-div"> <div class="col col-sm-4"> <select name="nombreTabla" class="nombreTabla no-editable" data-width="100%"> <option value="">Seleccionar campo</option> <option value="marcas">Descripción</option> <option value="empresarias">Empresaria</option> <option value="pedidos">Venta</option> </select> </div> <div class="col col-sm-2"> <select name="operador" class="operador no-editable" data-width="100%"> <option value="">Operador</option> <option value="=">igual</option> <option value=">">mayor que</option> <option value="<">menor que</option> <option value=">=">mayor igual que</option> <option value="<=">menor igual que</option> <option value="contiene">contiene</option> <option value="no contiene">no contiene</option> </select> </div> <div class="col col-sm-4"> <select name="valor" class="valor editable" data-width="100%"> <option value="">Ingrese un valor</option> <option value="marcas">Nueva</option> <option value="empresarias">Compras consecutivas</option> <option value="pedidos">Venta</option> </select> </div> <div class="col col-sm-1"> <select name="condicion" class="condicion no-editable" data-width="100%"> <option value="and">Y</option> <option value="or">O</option> </select> </div> <div class="col col-sm-1"> <button id="btn_regla" class="btn btn-ibizza"><i class="fas fa-plus"></i></button> </div> </div> </div>');

                } else {
                    alert('Hay condiciones incompletas, por favor revisar');
                }
            });

            $(document).on('click', '#btn_regla', function(e) {
                e.preventDefault();
                //$('.editable, .no-editable').select2('destroy');
                //clone.appendTo( "#nueva_regla" );
                $('#nueva_regla').append(clone);

                // $('#nueva_regla').append(
                //     '<div class="regla row py-2"> <div class="col col-sm-4"> <select name="nombreTabla" class="nombreTabla no-editable" data-width="100%"> <option value="">Seleccionar campo</option> <option value="marcas">Descripción</option> <option value="empresarias">Empresaria</option> <option value="pedidos">Venta</option> </select> </div> <div class="col col-sm-2"> <select name="operador" class="operador no-editable" data-width="100%"> <option value="">Operador</option> <option value="=">igual</option> <option value=">">mayor que</option> <option value="<">menor que</option> <option value=">=">mayor igual que</option> <option value="<=">menor igual que</option> <option value="contiene">contiene</option> <option value="no contiene">no contiene</option> </select> </div> <div class="col col-sm-4"> <select name="valor" class="valor editable" data-width="100%"> <option value="">Ingrese un valor</option> <option value="marcas">Nueva</option> <option value="empresarias">Compras consecutivas</option> <option value="pedidos">Venta</option> </select> </div> <div class="col col-sm-1"> <select name="condicion" class="condicion no-editable" data-width="100%"> <option value="and">Y</option> <option value="or">O</option> </select> </div> <div class="col col-sm-1"> <button class="btn btn-danger removeRegla"><i class="fas fa-minus"></i></button> </div> </div>'
                // );
                
                //inicializar_select();
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
