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
            @section('plugins.Select2', true)
            {{ Form::label('condición') }}
            <div id="nueva_condicion">
                <div class="row">
                    <div class="col">
                        <select id="nombre_tabla" class="selectpicker show-tick" data-live-search="true" data-width="100%">
                            <option value="0">Seleccionar tabla</option>
                            <option value="marcas" data-tokens="">Marca</option>
                            <option value="empresarias" data-tokens="">Empresaria</option>
                            <option value="pedidos" data-tokens="">Venta</option>
                        </select>
                    </div>
                </div>
                <div id="nueva_regla" class="d-none">
                    <div class="row py-2">
                        <div class="col col-sm-4">
                            <select name="table_name" class="no-editable" data-width="100%">
                                <option value="">Seleccionar campo</option>
                                <option value="marcas">Descripción</option>
                                <option value="empresarias">Empresaria</option>
                                <option value="pedidos">Venta</option>
                            </select>
                        </div>
                        <div class="col col-sm-2">
                            <select name="operador" class="no-editable" data-width="100%">
                                <option value="">Operador</option>
                                <option value="marcas">igual</option>
                                <option value="empresarias">mayor que</option>
                                <option value="pedidos">menor que</option>
                                <option value="empresarias">mayor igual que</option>
                                <option value="pedidos">menor igual que</option>
                                <option value="pedidos">contiene</option>
                                <option value="pedidos">no contiene</option>
                            </select>
                        </div>
                        <div class="col col-sm-4">
                            <select name="valor" class="editable" data-width="100%">
                                <option value="">Ingrese un valor</option>
                                <option value="marcas">Nueva</option>
                                <option value="empresarias">Compras consecutivas</option>
                                <option value="pedidos">Venta</option>
                            </select>
                        </div>
                        <div class="col col-sm-1">
                            <select name="condicion" class="no-editable" data-width="100%">
                                <option value="and">Y</option>
                                <option value="or">O</option>
                            </select>
                        </div>
                        <div class="col col-sm-1">
                            <button id="btn_regla" class="btn btn-ibizza"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>            
            </div>
            <button id="btn_condicion" class="btn btn-ibizza btn-block btn-sm d-none"><i class="fas fa-plus"></i></button>
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
        $(document).ready(function() {

            function inicializar_select(){
                $(".editable").select2({
                tags: true
                });
                $(".no-editable").select2({
                });
            }

            $('#nombre_tabla').on('change', function(e){
                
                let valor = $('#nombre_tabla').val();
                console.log(valor);
                if(valor != '0'){
                    $('#nueva_regla').removeClass('d-none');
                    $('#btn_condicion').removeClass('d-none');
                }else{
                    $('#nueva_regla').addClass('d-none');
                    $('#btn_condicion').addClass('d-none');
                }
            });

            inicializar_select();

            $('#btn_regla').on('click', function(e){
                e.preventDefault();
                $('#nueva_regla').append('<div class="regla row py-2"> <div class="col col-sm-4"> <select name="table_name" class="no-editable" data-width="100%"> <option value="">Seleccionar campo</option> <option value="marcas">Descripción</option> <option value="empresarias">Empresaria</option> <option value="pedidos">Venta</option> </select> </div> <div class="col col-sm-2"> <select name="operador" class="no-editable" data-width="100%"> <option value="">Operador</option> <option value="marcas">igual</option> <option value="empresarias">mayor que</option> <option value="pedidos">menor que</option> <option value="empresarias">mayor igual que</option> <option value="pedidos">menor igual que</option> <option value="pedidos">contiene</option> <option value="pedidos">no contiene</option> </select> </div> <div class="col col-sm-4"> <select name="valor" class="editable" data-width="100%"> <option value="">Ingrese un valor</option> <option value="marcas">Nueva</option> <option value="empresarias">Compras consecutivas</option> <option value="pedidos">Venta</option> </select> </div> <div class="col col-sm-1"> <select name="condicion" class="no-editable" data-width="100%"> <option value="and">Y</option> <option value="or">O</option> </select> </div> <div class="col col-sm-1"> <button class="btn btn-danger removeRegla"><i class="fas fa-minus"></i></button> </div> </div>');
                inicializar_select();
            });

            $('#btn_condicion').on('click', function(e){
                e.preventDefault();
                $('#nueva_condicion').append('<div class="row"> <div class="col"> <select id="nombre_tabla" class="selectpicker show-tick" data-live-search="true" data-width="100%"> <option value="0">Seleccionar tabla</option> <option value="marcas" data-tokens="">Marca</option> <option value="empresarias" data-tokens="">Empresaria</option> <option value="pedidos" data-tokens="">Venta</option> </select> </div> </div> <div id="nueva_regla" class="d-none"> <div class="row py-2"> <div class="col col-sm-4"> <select name="table_name" class="no-editable" data-width="100%"> <option value="">Seleccionar campo</option> <option value="marcas">Descripción</option> <option value="empresarias">Empresaria</option> <option value="pedidos">Venta</option> </select> </div> <div class="col col-sm-2"> <select name="operador" class="no-editable" data-width="100%"> <option value="">Operador</option> <option value="marcas">igual</option> <option value="empresarias">mayor que</option> <option value="pedidos">menor que</option> <option value="empresarias">mayor igual que</option> <option value="pedidos">menor igual que</option> <option value="pedidos">contiene</option> <option value="pedidos">no contiene</option> </select> </div> <div class="col col-sm-4"> <select name="valor" class="editable" data-width="100%"> <option value="">Ingrese un valor</option> <option value="marcas">Nueva</option> <option value="empresarias">Compras consecutivas</option> <option value="pedidos">Venta</option> </select> </div> <div class="col col-sm-1"> <select name="condicion" class="no-editable" data-width="100%"> <option value="and">Y</option> <option value="or">O</option> </select> </div> <div class="col col-sm-1"> <button id="btn_regla" class="btn btn-ibizza"><i class="fas fa-plus"></i></button> </div> </div> </div>');
                inicializar_select();
            });

            $(document).on('click','button.removeRegla',function(){
                $(this).closest('div.regla').remove();
            });
        });
    </script>

@endpush
