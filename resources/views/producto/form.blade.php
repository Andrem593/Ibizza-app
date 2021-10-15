<div class="box box-info padding-1">
    <div class="box-body">
        <div class="row">
            <div class="col-4 text-center">
                <img src="https://www.blackwallst.directory/images/NoImageAvailable.png" class="mx-auto rounded" alt="imagen-producto" style="width:15rem">
            </div>
            <div class="col">
                <div class="row form-group">
                    <div class="col">
                        {{ Form::label('sku') }}
                        {{ Form::text('sku', $producto->sku, ['class' => 'form-control' . ($errors->has('sku') ? ' is-invalid' : ''), 'placeholder' => 'ingrese el sku del producto']) }}
                        {!! $errors->first('sku', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="col">
                        {{ Form::label('nombre_producto') }}
                        {{ Form::text('nombre_producto', $producto->nombre_producto, ['class' => 'form-control' . ($errors->has('nombre_producto') ? ' is-invalid' : ''), 'placeholder' => 'Marca Id']) }}
                        {!! $errors->first('nombre_producto', '<div class="invalid-feedback">:message</p>') !!}
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
                        {{ Form::label('grupo') }}
                        {{ Form::text('grupo', $producto->grupo, ['class' => 'form-control' . ($errors->has('grupo') ? ' is-invalid' : ''), 'placeholder' => 'Registre el grupo']) }}
                        {!! $errors->first('grupo', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
                    <div class="col">
                        {{ Form::label('seccion') }}
                        {{ Form::text('seccion', $producto->seccion, ['class' => 'form-control' . ($errors->has('seccion') ? ' is-invalid' : ''), 'placeholder' => 'seccion']) }}
                        {!! $errors->first('seccion', '<div class="invalid-feedback">:message</p>') !!}
                    </div>
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
                {{ Form::label('Proveedor') }}
                <select name="proveedor_id" class="form-select">
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row form-group">
            <div class="col">
                {{ Form::label('talla') }}
            {{ Form::text('talla', $producto->talla, ['class' => 'form-control' . ($errors->has('talla') ? ' is-invalid' : ''), 'placeholder' => 'talla']) }}
            {!! $errors->first('talla', '<div class="invalid-feedback">:message</p>') !!}
            </div>
            <div class="col">
                {{ Form::label('precio') }}
            {{ Form::text('valor_venta', $producto->valor_venta, ['class' => 'form-control' . ($errors->has('precio') ? ' is-invalid' : ''), 'placeholder' => 'precio']) }}
            {!! $errors->first('valor_venta', '<div class="invalid-feedback">:message</p>') !!}
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
