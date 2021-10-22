<div class="box box-info padding-1">
    <div class="box-body">

        <div class="row">
            <div class="col-sm-4 text-center">
                @livewire('image',['ruta_imagen'=>"$catalogo->foto_path", 'path' => '/storage/images/catalogo/'])
            </div>
            <div class="col">
                <div class="form-group">
                    {{ Form::label('nombre') }}
                    {{ Form::text('nombre', $catalogo->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                    {!! $errors->first('nombre', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="form-group">
                    {{ Form::label('descripción') }}
                    {{ Form::textarea('descripcion', $catalogo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripción', 'rows' => 3, 'style' => 'resize: none']) }}
                    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="row form-group">
                    <div class="col">
                        @php
                            $config = ['format' => 'L'];
                        @endphp
                        <x-adminlte-input-date name="fecha_publicacion" :config="$config"
                            placeholder="Fecha Publicación" label="Fecha Publicación">
                            <x-slot name="appendSlot"
                                class="form-control{{ $errors->has('fecha_publicacion') ? ' is-invalid' : '' }}">
                                <div class="input-group-text btn-ibizza">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-date>
                        {!! $errors->first('fecha_publicacion', '<div class="invalid-feedback">:message</p>') !!}
                        {{-- {{ Form::label('fecha_publicación') }}
                        {{ Form::text('fecha_publicacion', $catalogo->fecha_publicacion, ['class' => 'form-control' . ($errors->has('fecha_publicacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Publicación']) }}
                        {!! $errors->first('fecha_publicacion', '<div class="invalid-feedback">:message</p>') !!} --}}
                    </div>

                    <div class="col">
                        {{ Form::label('fecha_fin_catálogo') }}
                        {{ Form::text('fecha_fin_catalogo', $catalogo->fecha_fin_catalogo, ['class' => 'form-control' . ($errors->has('fecha_fin_catalogo') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Fin Catálogo']) }}
                        {!! $errors->first('fecha_fin_catalogo', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="col">
                        {{ Form::label('estado') }}
                        {{ Form::text('estado', $catalogo->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
                        {!! $errors->first('estado', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                </div>
                @section('plugins.BsCustomFileInput', true)

                    <x-adminlte-input-file name="pdf_path" class="" igroup-size="sm" label="Carga archivo (.pdf)"
                        legend="Seleccionar" placeholder="Escoger un archivo .pdf" accept="application/pdf">

                        <x-slot name="prependSlot">
                            <div class="input-group-text btn-ibizza">
                                <i class="fas fa-upload"></i>
                            </div>
                        </x-slot>

                    </x-adminlte-input-file>
                    {{-- <div class="form-group">
                    {{ Form::label('Subir PDF') }}
                    {{ Form::text('pdf_path', $catalogo->pdf_path, ['class' => 'form-control' . ($errors->has('pdf_path') ? ' is-invalid' : ''), 'placeholder' => 'Pdf Path']) }}
                    {!! $errors->first('pdf_path', '<div class="invalid-feedback">:message</p>') !!}
                </div> --}}
                </div>
            </div>

        </div>
        <div class="box-footer mt20">
            <button type="submit" class="btn btn-ibizza w-100">Guardar</button>
        </div>
    </div>
