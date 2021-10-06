<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $marca->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        {{-- <div class="form-group">
            {{ Form::label('imagen') }}
            {{ Form::file('imagen', $marca->imagen, ['class' => 'form-control' . ($errors->has('imagen') ? ' is-invalid' : ''), 'placeholder' => 'Imagen']) }}
            {!! $errors->first('imagen', '<div class="invalid-feedback">:message</p>') !!}
        </div> --}}
        @section('plugins.BsCustomFileInput', true)
        
        <x-adminlte-input-file name="imagen" class="{{ $errors->has('imagen') ? 'is-invalid' : '' }}" igroup-size="sm" label="Imágen" legend="Seleccionar" placeholder="Escoger una imágen...">
            
            <x-slot name="prependSlot">
                <div class="input-group-text bg-lightblue">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
            {!! $errors->first('imagen', '<div class="invalid-feedback">:message</p>') !!}
        </x-adminlte-input-file>
        

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>