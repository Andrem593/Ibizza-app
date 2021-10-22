<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('nombre') }}
            {{ Form::text('nombre', $catalogo->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
            {!! $errors->first('nombre', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('descripcion') }}
            {{ Form::text('descripcion', $catalogo->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('foto_path') }}
            {{ Form::text('foto_path', $catalogo->foto_path, ['class' => 'form-control' . ($errors->has('foto_path') ? ' is-invalid' : ''), 'placeholder' => 'Foto Path']) }}
            {!! $errors->first('foto_path', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('pdf_path') }}
            {{ Form::text('pdf_path', $catalogo->pdf_path, ['class' => 'form-control' . ($errors->has('pdf_path') ? ' is-invalid' : ''), 'placeholder' => 'Pdf Path']) }}
            {!! $errors->first('pdf_path', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_publicacion') }}
            {{ Form::text('fecha_publicacion', $catalogo->fecha_publicacion, ['class' => 'form-control' . ($errors->has('fecha_publicacion') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Publicacion']) }}
            {!! $errors->first('fecha_publicacion', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_fin_catalogo') }}
            {{ Form::text('fecha_fin_catalogo', $catalogo->fecha_fin_catalogo, ['class' => 'form-control' . ($errors->has('fecha_fin_catalogo') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Fin Catalogo']) }}
            {!! $errors->first('fecha_fin_catalogo', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $catalogo->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('premio_id') }}
            {{ Form::text('premio_id', $catalogo->premio_id, ['class' => 'form-control' . ($errors->has('premio_id') ? ' is-invalid' : ''), 'placeholder' => 'Premio Id']) }}
            {!! $errors->first('premio_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>