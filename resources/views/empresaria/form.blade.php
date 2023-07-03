<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('cedula') }}
                    {{ Form::text('cedula', $empresaria->cedula, ['class' => 'form-control' . ($errors->has('cedula') ? ' is-invalid' : ''), 'placeholder' => 'Cedula']) }}
                    {!! $errors->first('cedula', '<div class="invalid-feedback">:message</p> </div>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('nombres') }}
                    {{ Form::text('nombres', $empresaria->nombres, ['class' => 'form-control' . ($errors->has('nombres') ? ' is-invalid' : ''), 'placeholder' => 'Nombres']) }}
                    {!! $errors->first('nombres', '<div class="invalid-feedback">:message</p> </div>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('apellidos') }}
                    {{ Form::text('apellidos', $empresaria->apellidos, ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Apellidos']) }}
                    {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</p> </div>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('fecha_nacimiento') }}
                    {{ Form::date('fecha_nacimiento', $empresaria->fecha_nacimiento, ['class' => 'form-control' . ($errors->has('fecha_nacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Nacimiento']) }}
                    {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback">:message</p> </div>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('teléfono') }}

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" id="telefono" name="telefono" class="form-control" value="{!! $empresaria->telefono !!}">
                        {!! $errors->first('telefono', '<div class="invalid-feedback">:message</p> </div>') !!}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('tipo_empresaria') }}
                    <select name="tipo_cliente" class="form-select">
                        <option value="PROSPECTO" {{ 'PROSPECTO' == $empresaria->tipo_cliente ? 'selected' : '' }}>PROSPECTO</option>
                        <option value="NUEVA" {{ 'NUEVA' == $empresaria->tipo_cliente ? 'selected' : '' }}>NUEVA</option>
                        <option value="CONTINUA" {{ 'CONTINUA' == $empresaria->tipo_cliente ? 'selected' : '' }}>CONTINUA</option>
                        <option value="INACTIVA-1" {{ 'INACTIVA-1' == $empresaria->tipo_cliente ? 'selected' : '' }}>INACTIVA-1</option>
                        <option value="INACTIVA-2" {{ 'INACTIVA-2' == $empresaria->tipo_cliente ? 'selected' : '' }}>INACTIVA-2</option>
                        <option value="INACTIVA-3" {{ 'INACTIVA-3' == $empresaria->tipo_cliente ? 'selected' : '' }}>INACTIVA-3</option>
                        <option value="POSIBLE BAJA" {{ 'POSIBLE BAJA' == $empresaria->tipo_cliente ? 'selected' : '' }}>POSIBLE BAJA</option>
                        <option value="REACTIVA" {{ 'REACTIVA' == $empresaria->tipo_cliente ? 'selected' : '' }}>REACTIVA</option>
                        <option value="BAJA" {{ 'BAJA' == $empresaria->tipo_cliente ? 'selected' : '' }}>BAJA</option>
                        <option value="RE-INGRESO" {{ 'RE-INGRESO' == $empresaria->tipo_cliente ? 'selected' : '' }}>RE-INGRESO</option>
                    </select>
                    {!! $errors->first('tipo_cliente', '<div class="invalid-feedback">:message</p> </div>') !!}
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
                            @if ($provincia->id == $empresaria->provincia_id)
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
                            @if ($ciudad->id == $empresaria->id_ciudad)
                            <option value="{{ $ciudad->id }}" selected>{{ $ciudad->descripcion }}</option>                                
                            @else
                            <option value="{{ $ciudad->id }}">{{ $ciudad->descripcion }}</option>                                
                            @endif
                            @endforeach
                        @endisset
                    </select>
                    {!! $errors->first('id_ciudad', '<div class="invalid-feedback">:message</p> </div>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                {{ Form::label('direccion') }}
                {{ Form::text('direccion', $empresaria->direccion, ['class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''), 'placeholder' => 'Direccion']) }}
                {!! $errors->first('direccion', '<div class="invalid-feedback">:message</p> </div>') !!}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('email') }}
                    {{-- {{ Form::email('email', $usuario->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email de empresaria' ,'id'=>'email']) }} --}}
                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : ''}}" name="email" placeholder="Email de empresaria" value="{{ isset($usuario) ? $usuario->email : '' }}">
                    {!! $errors->first('email', '<div class="invalid-feedback">:message</p> </div>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Contraseña') }}
                    <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : ''}}" name="password" placeholder="Crea una contraseña para tu empresaria">
                    {!! $errors->first('password', '<div class="invalid-feedback">:message</p> </div>') !!}
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
            $('#telefono').inputmask("999-999-9999", {"placeholder": ""});
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

            $(document).on('change', '#provincia', function(){
                $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                $.post({
                    url: "{{ route('empresaria.ciudad') }}",
                    data: {
                        'id_provincia' : $('#provincia').val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        response = JSON.parse(response);

                        if (response != null) {
                            $('#ciudad').html('<option value="" selected>Seleccione ciudad</option>');
                            $.each(response, function(i, val){
                                $('#ciudad').append('<option value="'+ val['id'] +'">' + val['descripcion'] +'</option>')
                            });
                        }
                    }
                });
            });

        </script>
    @endpush
</div>
