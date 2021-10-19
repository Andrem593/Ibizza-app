<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('cedula') }}
                    {{ Form::text('cedula', $empresaria->cedula, ['class' => 'form-control' . ($errors->has('cedula') ? ' is-invalid' : ''), 'placeholder' => 'Cedula']) }}
                    {!! $errors->first('cedula', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('nombres') }}
                    {{ Form::text('nombres', $empresaria->nombres, ['class' => 'form-control' . ($errors->has('nombres') ? ' is-invalid' : ''), 'placeholder' => 'Nombres']) }}
                    {!! $errors->first('nombres', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('apellidos') }}
                    {{ Form::text('apellidos', $empresaria->apellidos, ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Apellidos']) }}
                    {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('fecha_nacimiento') }}
                    {{ Form::date('fecha_nacimiento', $empresaria->fecha_nacimiento, ['class' => 'form-control' . ($errors->has('fecha_nacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Nacimiento']) }}
                    {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('telefono') }}

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="text" class="form-control"
                        data-inputmask='"mask": "999-999-9999"' data-mask="" inputmode="text">
                        {!! $errors->first('telefono', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('tipo_cliente') }}
                    {{ Form::text('tipo_cliente', $empresaria->tipo_cliente, ['class' => 'form-control' . ($errors->has('tipo_cliente') ? ' is-invalid' : ''), 'placeholder' => 'Tipo Cliente']) }}
                    {!! $errors->first('tipo_cliente', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                {{ Form::label('direccion') }}
                {{ Form::text('direccion', $empresaria->direccion, ['class' => 'form-control' . ($errors->has('direccion') ? ' is-invalid' : ''), 'placeholder' => 'Direccion']) }}
                {!! $errors->first('direccion', '<div class="invalid-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('id_ciudad') }}
                    {{ Form::text('id_ciudad', $empresaria->id_ciudad, ['class' => 'form-control' . ($errors->has('id_ciudad') ? ' is-invalid' : ''), 'placeholder' => 'Id Ciudad']) }}
                    {!! $errors->first('id_ciudad', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('vendedor') }}
                    {{ Form::text('vendedor', $empresaria->vendedor, ['class' => 'form-control' . ($errors->has('vendedor') ? ' is-invalid' : ''), 'placeholder' => 'Vendedor']) }}
                    {!! $errors->first('vendedor', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    {{ Form::label('email') }}
                    {{ Form::text('email', $empresaria->id_ciudad, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email de empresaria']) }}
                    {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('Contraseña') }}
                    {{ Form::text('password', $empresaria->vendedor, ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : ''), 'placeholder' => 'Crea una contraseña para tu empresaria']) }}
                    {!! $errors->first('password', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    @push('js')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"
            integrity="sha512-6Jym48dWwVjfmvB0Hu3/4jn4TODd6uvkxdi9GNbBHwZ4nGcRxJUCaTkL3pVY6XUQABqFo3T58EMXFQztbjvAFQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $('[data-mask]').inputmask();

        </script>
    @endpush
</div>
