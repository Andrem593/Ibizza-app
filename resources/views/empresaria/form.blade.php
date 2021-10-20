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
                        <input type="text" id="telefono" name="telefono" class="form-control">
                        {!! $errors->first('telefono', '<div class="invalid-feedback">:message</p> </div>') !!}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('tipo_cliente') }}
                    <select name="tipo_cliente" class="form-select">
                        <option value="NUEVA">NUEVA</option>
                        <option value="CONTINUA">CONTINUA</option>
                        <option value="INACTIVA-1">INACTIVA-1</option>
                        <option value="INACTIVA-2">INACTIVA-2</option>
                        <option value="INACTIVA-3">INACTIVA-3</option>
                        <option value="REACTIVA">REACTIVA</option>
                        <option value="BAJA">BAJA</option>
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
                        <option value="0">SELECCIONE</option>
                        @foreach ($provincias as $provincia)
                            <option value="{{ $provincia->id }}">{{ $provincia->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Ciudad') }}
                    <select id="ciudad" name="id_ciudad" class="form-select" disabled>
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
                    {{ Form::email('email', $empresaria->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email de empresaria' ,'id'=>'email']) }}
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
            $('#provincia').change(e => {
                if ($('#provincia').val() != 0) {
                    $('#ciudad').attr('disabled', false)
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    });
                    $.post({
                        url: '/empresaria/ciudad',
                        data: {id_provincia : $('#provincia').val()},
                        success: function(response) {
                            response = JSON.parse(response);
                            $('#ciudad').html('<option value="0">SELECCIONE</option>')
                            for (let i = 0; i < response.length; i++) {
                                $('#ciudad').append('<option value="'+response[i]['id']+'">'+response[i]['descripcion']+'</option>');
                            }
                        }
                    })
                } else {
                    $('#ciudad').attr('disabled', true)
                }
            })

        </script>
    @endpush
</div>
