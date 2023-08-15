<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-4 text-center">
                @livewire('imagen',['ruta_imagen'=>"$producto->imagen_path"])
            </div>
            <div class="col">
                <div class="row form-group">
                    <div class="col">
                        {{ Form::label('sku') }}
                        {{ Form::text('sku', $producto->sku, ['class' => 'form-control' . ($errors->has('sku') ? ' is-invalid' : ''), 'placeholder' => 'ingrese el sku del producto', 'readonly' => true]) }}
                        {!! $errors->first('sku', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="col">
                        {{ Form::label('marca') }}
                        <select name="marca_id" class="form-select">
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('descripcion') }}
                    {{ Form::text('descripcion', $producto->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
                    {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</p>') !!}
                </div>
                <div class="row form-group">
                    <div class="col">
                        {{ Form::label('clasificacion') }}
                        {{ Form::text('clasificacion', $producto->clasificacion, ['class' => 'form-control' . ($errors->has('clasificacion') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese clasificacion del producto']) }}
                        {!! $errors->first('clasificacion', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                {{ Form::label('categoria') }}
                {{ Form::text('categoria', $producto->categoria, ['class' => 'form-control' . ($errors->has('categoria') ? ' is-invalid' : ''), 'placeholder' => 'categoria']) }}
                {!! $errors->first('categoria', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="col">
                {{ Form::label('subcategoria') }}
                {{ Form::text('subcategoria', $producto->subcategoria, ['class' => 'form-control' . ($errors->has('subcategoria') ? ' is-invalid' : ''), 'placeholder' => 'subcategoria']) }}
                {!! $errors->first('subcategoria', '<div class="invalid-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                {{ Form::label('estilo') }}
                {{ Form::text('estilo', $producto->estilo, ['class' => 'form-control' . ($errors->has('estilo') ? ' is-invalid' : ''), 'placeholder' => 'estilo']) }}
                {!! $errors->first('estilo', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="col">
                {{ Form::label('color') }}
                {{ Form::text('color', $producto->color, ['class' => 'form-control' . ($errors->has('color') ? ' is-invalid' : ''), 'placeholder' => 'color']) }}
                {!! $errors->first('color', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="col">
                {{ Form::label('observaciones') }}
                {{ Form::text('observaciones', $producto->observaciones, ['class' => 'form-control' . ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'observaciones']) }}
                {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</p>') !!}
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                {{ Form::label('stock') }}
            {{ Form::text('stock', $producto->stock, ['class' => 'form-control' . ($errors->has('stock') ? ' is-invalid' : ''), 'placeholder' => 'stock']) }}
            {!! $errors->first('stock', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="col">
                {{ Form::label('talla') }}
            {{ Form::text('talla', $producto->talla, ['class' => 'form-control' . ($errors->has('talla') ? ' is-invalid' : ''), 'placeholder' => 'talla']) }}
            {!! $errors->first('talla', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="col">
                {{ Form::label('precio_catálogo') }}
            {{ Form::text('precio_empresaria', $producto->precio_empresaria, ['class' => 'form-control' . ($errors->has('precio_empresaria') ? ' is-invalid' : ''), 'placeholder' => 'precio empresaria']) }}
            {!! $errors->first('precio_empresaria', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="col">
                {{ Form::label('estado') }}
            {{ Form::text('estado', $producto->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</p>') !!}
            </div>
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-ibizza w-100">Guardar</button>
    </div>
</div>
