<div class="box box-info padding-1">
    <div class="box-body">

        <div class="row">
            <div class="col-4 text-center">
                @livewire('image',['ruta_imagen'=>"$marca->imagen", 'path' => '/storage/images/marca/', 'name' =>
                'imagen'])
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('nombre') }}
                    {{ Form::text('nombre', $marca->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('estado') }}
                    <select name="estado" class="form-select">
                            <option value="A" {{ 'A' == $marca->estado ? 'selected' : '' }}>Activo</option>                                                            
                            <option value="I" {{ 'I' == $marca->estado ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    
                    {!! $errors->first('estado', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-ibizza w-100">Guardar</button>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                if ($(this).hasClass('submitted')) {
                    $(this).find(':submit').html('Guardar');
                    $(this).find(':submit').attr("disabled", false);
                    event.preventDefault();
                } else {
                    $(this).find(':submit').attr("disabled", true);
                    $(this).find(':submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
                    $(this).addClass('submitted');
                }
            });
        });
    </script>
@endpush
