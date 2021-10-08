<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('categoria_id') }}
            {{ Form::text('categoria_id', $producto->categoria_id, ['class' => 'form-control' . ($errors->has('categoria_id') ? ' is-invalid' : ''), 'placeholder' => 'Categoria Id']) }}
            {!! $errors->first('categoria_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('marca_id') }}
            {{ Form::text('marca_id', $producto->marca_id, ['class' => 'form-control' . ($errors->has('marca_id') ? ' is-invalid' : ''), 'placeholder' => 'Marca Id']) }}
            {!! $errors->first('marca_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('descripcion') }}
            {{ Form::text('descripcion', $producto->descripcion, ['class' => 'form-control' . ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripcion']) }}
            {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('linea') }}
            {{ Form::text('linea', $producto->linea, ['class' => 'form-control' . ($errors->has('linea') ? ' is-invalid' : ''), 'placeholder' => 'Linea']) }}
            {!! $errors->first('linea', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('color') }}
            {{ Form::text('color', $producto->color, ['class' => 'form-control' . ($errors->has('color') ? ' is-invalid' : ''), 'placeholder' => 'Color']) }}
            {!! $errors->first('color', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('nombre_color') }}
            {{ Form::text('nombre_color', $producto->nombre_color, ['class' => 'form-control' . ($errors->has('nombre_color') ? ' is-invalid' : ''), 'placeholder' => 'Nombre Color']) }}
            {!! $errors->first('nombre_color', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('precio') }}
            {{ Form::text('precio', $producto->precio, ['class' => 'form-control' . ($errors->has('precio') ? ' is-invalid' : ''), 'placeholder' => 'Precio']) }}
            {!! $errors->first('precio', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('descuento') }}
            {{ Form::text('descuento', $producto->descuento, ['class' => 'form-control' . ($errors->has('descuento') ? ' is-invalid' : ''), 'placeholder' => 'Descuento']) }}
            {!! $errors->first('descuento', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('sku') }}
            {{ Form::text('sku', $producto->sku, ['class' => 'form-control' . ($errors->has('sku') ? ' is-invalid' : ''), 'placeholder' => 'Sku']) }}
            {!! $errors->first('sku', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('cantidad') }}
            {{ Form::text('cantidad', $producto->cantidad, ['class' => 'form-control' . ($errors->has('cantidad') ? ' is-invalid' : ''), 'placeholder' => 'Cantidad']) }}
            {!! $errors->first('cantidad', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('stock_inicial') }}
            {{ Form::text('stock_inicial', $producto->stock_inicial, ['class' => 'form-control' . ($errors->has('stock_inicial') ? ' is-invalid' : ''), 'placeholder' => 'Stock Inicial']) }}
            {!! $errors->first('stock_inicial', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('coleccion') }}
            {{ Form::text('coleccion', $producto->coleccion, ['class' => 'form-control' . ($errors->has('coleccion') ? ' is-invalid' : ''), 'placeholder' => 'Coleccion']) }}
            {!! $errors->first('coleccion', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_entrega') }}
            {{ Form::text('fecha_entrega', $producto->fecha_entrega, ['class' => 'form-control' . ($errors->has('fecha_entrega') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Entrega']) }}
            {!! $errors->first('fecha_entrega', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status_fabrica') }}
            {{ Form::text('status_fabrica', $producto->status_fabrica, ['class' => 'form-control' . ($errors->has('status_fabrica') ? ' is-invalid' : ''), 'placeholder' => 'Status Fabrica']) }}
            {!! $errors->first('status_fabrica', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('vigencia') }}
            {{ Form::text('vigencia', $producto->vigencia, ['class' => 'form-control' . ($errors->has('vigencia') ? ' is-invalid' : ''), 'placeholder' => 'Vigencia']) }}
            {!! $errors->first('vigencia', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('observacion') }}
            {{ Form::text('observacion', $producto->observacion, ['class' => 'form-control' . ($errors->has('observacion') ? ' is-invalid' : ''), 'placeholder' => 'Observacion']) }}
            {!! $errors->first('observacion', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('pvp') }}
            {{ Form::text('pvp', $producto->pvp, ['class' => 'form-control' . ($errors->has('pvp') ? ' is-invalid' : ''), 'placeholder' => 'Pvp']) }}
            {!! $errors->first('pvp', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('imagen') }}
            {{ Form::text('imagen', $producto->imagen, ['class' => 'form-control' . ($errors->has('imagen') ? ' is-invalid' : ''), 'placeholder' => 'Imagen']) }}
            {!! $errors->first('imagen', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('status_imagen') }}
            {{ Form::text('status_imagen', $producto->status_imagen, ['class' => 'form-control' . ($errors->has('status_imagen') ? ' is-invalid' : ''), 'placeholder' => 'Status Imagen']) }}
            {!! $errors->first('status_imagen', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('precio_mayorista') }}
            {{ Form::text('precio_mayorista', $producto->precio_mayorista, ['class' => 'form-control' . ($errors->has('precio_mayorista') ? ' is-invalid' : ''), 'placeholder' => 'Precio Mayorista']) }}
            {!! $errors->first('precio_mayorista', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('modelo') }}
            {{ Form::text('modelo', $producto->modelo, ['class' => 'form-control' . ($errors->has('modelo') ? ' is-invalid' : ''), 'placeholder' => 'Modelo']) }}
            {!! $errors->first('modelo', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('numero_pedido') }}
            {{ Form::text('numero_pedido', $producto->numero_pedido, ['class' => 'form-control' . ($errors->has('numero_pedido') ? ' is-invalid' : ''), 'placeholder' => 'Numero Pedido']) }}
            {!! $errors->first('numero_pedido', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('proveedor_id') }}
            {{ Form::text('proveedor_id', $producto->proveedor_id, ['class' => 'form-control' . ($errors->has('proveedor_id') ? ' is-invalid' : ''), 'placeholder' => 'Proveedor Id']) }}
            {!! $errors->first('proveedor_id', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('clasificacion') }}
            {{ Form::text('clasificacion', $producto->clasificacion, ['class' => 'form-control' . ($errors->has('clasificacion') ? ' is-invalid' : ''), 'placeholder' => 'Clasificacion']) }}
            {!! $errors->first('clasificacion', '<div class="invalid-feedback">:message</p>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
</div>