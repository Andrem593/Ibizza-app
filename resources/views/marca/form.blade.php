<div class="box box-info padding-1">
    <div class="box-body">

        <div class="row">
            <div class="col-4 text-center">
                @livewire('image',['ruta_imagen'=>"$marca->imagen", 'path' => '/storage/images/marca/', 'name' => 'imagen'])
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('nombre') }}
                    {{ Form::text('nombre', $marca->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('estado') }}
                    {{ Form::text('estado', $marca->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
                    {!! $errors->first('estado', '<div class="invalid-feedback">:message</p>') !!}
                </div>
            </div>
        </div>
        
        {{-- @section('plugins.BsCustomFileInput', true)
        
        <x-adminlte-input-file name="imagen" class="{{ $errors->has('imagen') ? 'is-invalid' : '' }}" igroup-size="sm" label="Imágen" legend="Seleccionar" placeholder="Escoger una imágen...">
            
            <x-slot name="prependSlot">
                <div class="input-group-text btn-ibizza">
                    <i class="fas fa-upload"></i>
                </div>
            </x-slot>
            {!! $errors->first('imagen', '<div class="invalid-feedback">:message</p>') !!}
        </x-adminlte-input-file>
        @if (isset($marca->imagen))
        <img src="/storage/images/marca/{{ $marca->imagen }}" width="300px">
        @endif --}}

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-ibizza w-100">Guardar</button>
    </div>
</div>