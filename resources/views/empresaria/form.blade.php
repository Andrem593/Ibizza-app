<div>
    <div class="box-body">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="name">Tipo de identificación</label>
                    <select class="form-select" name="tipo_id" id="tipo_id">
                        <option value="cedula" {{ $empresaria->tipo_id == 'cedula' ? 'selected' : '' }}>Cédula</option>
                        <option value="pasaporte" {{ $empresaria->tipo_id == 'pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                        <option value="ruc" {{ $empresaria->tipo_id == 'ruc' ? 'selected' : '' }}>Ruc</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Identificación') }}
                    {{ Form::text('cedula', old('cedula', $empresaria->cedula), ['class' => 'form-control' . ($errors->has('cedula') ? ' is-invalid' : ''), 'placeholder' => 'Identificación']) }}
                    {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('nombres') }}
                    {{ Form::text('nombres', old('nombres', $empresaria->nombres), ['class' => 'form-control' . ($errors->has('nombres') ? ' is-invalid' : ''), 'placeholder' => 'Nombres']) }}
                    {!! $errors->first('nombres', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('apellidos') }}
                    {{ Form::text('apellidos', old('apellidos', $empresaria->apellidos), ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Apellidos']) }}
                    {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('fecha_nacimiento') }}
                    {{ Form::date('fecha_nacimiento', old('fecha_nacimiento', $empresaria->fecha_nacimiento), ['class' => 'form-control' . ($errors->has('fecha_nacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Nacimiento']) }}
                    {!! $errors->first(
                        'fecha_nacimiento',
                        '<div class="invalid-feedback">La empresaria debe ser mayor a 18 años</div>',
                    ) !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('teléfono') }}

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        {{ Form::text('telefono', old('telefono', $empresaria->telefono), ['class' => 'form-control' . ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Teléfono', 'id' => 'telefono']) }}
                        {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('tipo_empresaria') }}
                    <select name="tipo_cliente" class="form-select" {{Auth::user()->role == 'Administrador' || Auth::user()->role == 'ADMINISTRADOR' ? '' : 'Disabled'}} >
                        <option value="PROSPECTO"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'PROSPECTO' ? 'selected' : '' }}>
                            PROSPECTO
                        </option>
                        <option value="NUEVA"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'NUEVA' ? 'selected' : '' }}>
                            NUEVA
                        </option>
                        <option value="CONTINUA"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'CONTINUA' ? 'selected' : '' }}>
                            CONTINUA
                        </option>
                        <option value="INACTIVA-1"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'INACTIVA-1' ? 'selected' : '' }}>
                            INACTIVA-1
                        </option>
                        <option value="INACTIVA-2"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'INACTIVA-2' ? 'selected' : '' }}>
                            INACTIVA-2
                        </option>
                        <option value="INACTIVA-3"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'INACTIVA-3' ? 'selected' : '' }}>
                            INACTIVA-3
                        </option>
                        <option value="POSIBLE BAJA"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'POSIBLE BAJA' ? 'selected' : '' }}>
                            POSIBLE BAJA
                        </option>
                        <option value="REACTIVA"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'REACTIVA' ? 'selected' : '' }}>
                            REACTIVA
                        </option>
                        <option value="BAJA"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'BAJA' ? 'selected' : '' }}>
                            BAJA
                        </option>
                        <option value="RE-INGRESO"
                            {{ old('tipo_cliente', $empresaria->tipo_cliente) == 'RE-INGRESO' ? 'selected' : '' }}>
                            RE-INGRESO
                        </option>
                    </select>
                    {!! $errors->first('tipo_cliente', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Provincia') }}
                    <select id="provincia" class="form-select">
                        <option value="">Seleccione Provincia</option>
                        @foreach ($provincias as $provincia)
                            @if (old('provincia', $empresaria->provincia_id) == $provincia->id)
                                <option value="{{ $provincia->id }}" selected>{{ $provincia->descripcion }}</option>
                            @else
                                <option value="{{ $provincia->id }}">{{ $provincia->descripcion }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Ciudad') }}
                    <select id="ciudad" name="id_ciudad" class="form-select">
                        <option value="" selected>Seleccione ciudad</option>
                        @isset($ciudades)
                            @foreach ($ciudades as $ciudad)
                                @if (old('id_ciudad', $empresaria->id_ciudad) == $ciudad->id)
                                    <option value="{{ $ciudad->id }}" selected>{{ $ciudad->descripcion }}</option>
                                @else
                                    <option value="{{ $ciudad->id }}">{{ $ciudad->descripcion }}</option>
                                @endif
                            @endforeach
                        @endisset
                    </select>
                    {!! $errors->first('id_ciudad', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            @if (Auth::user()->role == 'ADMINISTRADOR' && !empty($vendedores) || Auth::user()->role == 'Administrador' && !empty($vendedores))
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Asignación de Asesor') }}
                    <select name="vendedor" class="form-select">
                        <option value="0">Seleccione Asesor</option>
                        @foreach ($vendedores as $vendedor)
                            @if (old('vendedor', $empresaria->vendedor) == $vendedor->id)
                                <option value="{{ $vendedor->id }}" selected>{{ $vendedor->name }}</option>
                            @else
                                <option value="{{ $vendedor->id }}">{{ $vendedor->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        @endif
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('direccion') }}
                    {{ Form::text('direccion', old('direccion', $empresaria->direccion), ['class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''), 'placeholder' => 'Direccion']) }}
                    {!! $errors->first('direccion', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('referencia') }}
                    {{ Form::text('referencia', old('referencia', $empresaria->referencia), ['class' => 'form-control' . ($errors->has('referencia') ? ' is-invalid' : ''), 'placeholder' => 'Referencia']) }}
                    {!! $errors->first('referencia', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('email') }}
                    <input id="email" type="email"
                        class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                        placeholder="Email de empresaria"
                        value="{{ old('email', isset($usuario) ? $usuario->email : '') }}">
                    {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Contraseña') }}
                    <input id="password" type="password"
                        class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                        placeholder="Crea una contraseña para tu empresaria">
                    {!! $errors->first('password', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    {{ Form::label('Observación') }}
                    {{ Form::textarea('observacion', old('observacion', $empresaria->observacion), [
                        'rows' => 2,
                        'cols' => 6,
                        'class' => 'form-control' . ($errors->has('observacion') ? ' is-invalid' : ''), 
                        'placeholder' => 'Observación'
                    ]) }}
                    {!! $errors->first('observacion', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>        
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-ibizza w-100">GUARDAR</button>
    </div>
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"
            integrity="sha512-6Jym48dWwVjfmvB0Hu3/4jn4TODd6uvkxdi9GNbBHwZ4nGcRxJUCaTkL3pVY6XUQABqFo3T58EMXFQztbjvAFQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $('#telefono').inputmask("999-999-9999", {
                "placeholder": ""
            });
            // $('#provincia').change(e => {
            //     if ($('#provincia').val() != 0) {
            //         $('#ciudad').attr('disabled', false)
            //         $.ajaxSetup({
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //         });
            //         $.post({
            //             url: '/empresaria/ciudad',
            //             data: {id_provincia : $('#provincia').val()},
            //             success: function(response) {
            //                 response = JSON.parse(response);
            //                 $('#ciudad').html('<option value="0">SELECCIONE</option>')
            //                 for (let i = 0; i < response.length; i++) {
            //                     $('#ciudad').append('<option value="'+response[i]['id']+'">'+response[i]['descripcion']+'</option>');
            //                 }
            //             }
            //         })
            //     } else {
            //         $('#ciudad').attr('disabled', true)
            //     }
            // });

            $(document).on('change', '#provincia', function() {
                $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                $.post({
                    url: "{{ route('empresaria.ciudad') }}",
                    data: {
                        'id_provincia': $('#provincia').val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response != null) {
                            $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                            $.each(response, function(i, val) {
                                $('#ciudad').append('<option value="' + val['id'] + '">' + val[
                                    'descripcion'] + '</option>')
                            });
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
