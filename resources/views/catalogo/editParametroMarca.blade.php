<x-app-layout>
    @section('title', 'Catálogo')
    <x-slot name="header">
        <h5 class="text-center">Parametros por Marca</h5>
    </x-slot>

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    @section('plugins.Select2', true)

    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Editar') }}
                </span>

                <div class="float-right">
                    <a href="{{ route('catalogo.parametros-marca') }}" class="btn btn-ibizza btn-sm float-right"
                        data-placement="left">
                        {{ __('Regresar') }}
                    </a>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('catalogo.parametros-marca.update', $parametro->id) }}" role="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre"
                            class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                            value="{{ $parametro->nombre }}">
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            {{ Form::label('tipo_empresaria') }}
                            <select name="tipo_empresaria"
                                class="form-select {{ $errors->has('tipo_empresaria') ? 'is-invalid' : '' }}">
                                <option value="TODOS">TODOS</option>
                                <option value="PROSPECTO" {{$parametro->tipo_empresaria == 'PROSPECTO' ? 'selected' : '' }}>
                                    PROSPECTO
                                </option>
                                <option value="NUEVA" {{ $parametro->tipo_empresaria == 'NUEVA' ? 'selected' : '' }}>
                                    NUEVA
                                </option>
                                <option value="CONTINUA" {{ $parametro->tipo_empresaria == 'CONTINUA' ? 'selected' : '' }}>
                                    CONTINUA
                                </option>
                                <option value="INACTIVA-1" {{ $parametro->tipo_empresaria == 'INACTIVA-1' ? 'selected' : '' }}>
                                    INACTIVA-1
                                </option>
                                <option value="INACTIVA-2" {{ $parametro->tipo_empresaria == 'INACTIVA-2' ? 'selected' : '' }}>
                                    INACTIVA-2
                                </option>
                                <option value="INACTIVA-3" {{ $parametro->tipo_empresaria == 'INACTIVA-3' ? 'selected' : '' }}>
                                    INACTIVA-3
                                </option>
                                <option value="POSIBLE BAJA"
                                    {{ $parametro->tipo_empresaria == 'POSIBLE BAJA' ? 'selected' : '' }}>
                                    POSIBLE BAJA
                                </option>
                                <option value="REACTIVA" {{ $parametro->tipo_empresaria == 'REACTIVA' ? 'selected' : '' }}>
                                    REACTIVA
                                </option>
                                <option value="BAJA" {{ $parametro->tipo_empresaria == 'BAJA' ? 'selected' : '' }}>
                                    BAJA
                                </option>
                                <option value="RE-INGRESO" {{ $parametro->tipo_empresaria == 'RE-INGRESO' ? 'selected' : '' }}>
                                    RE-INGRESO
                                </option>
                            </select>
                            @error('tipo_empresaria')
                                <p class="mt-1 p-1 text-danger" role="alert">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Categorias</label>                     
                        <x-adminlte-select2 id="sel2Category" class="form-control" name="marca[]" multiple>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->categoria }}" 
                                    {{in_array($categoria->categoria, json_decode($parametro->marcas))? 'selected' : ''}}>
                                    {{ $categoria->categoria }}
                                </option>
                            @endforeach
                        </x-adminlte-select2>

                        @error('marca')
                            <p class="mt-1 p-1 text-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-3">
                        {{ Form::label('Condición') }}
                        <select name="condicion"
                            class="form-select  {{ $errors->has('condicion') ? 'is-invalid' : '' }}">
                            <option value="">Seleccione una opción</option>
                            <option value="factura" {{$parametro->condicion == 'factura' ? 'selected': ''}} >Total a pagar</option>
                            <option value="cantidad" {{$parametro->condicion == 'cantidad' ? 'selected': ''}}>Cantidad de productos</option>
                        </select>
                        @error('condicion')
                            <p class="mt-1 p-1 text-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-3">
                        {{ Form::label('Operador') }}
                        <select name="operador" class="form-select {{ $errors->has('operador') ? 'is-invalid' : '' }}">
                            <option value="">Seleccione una opción</option>
                            <option value="=" {{$parametro->operador == '=' ? 'selected': ''}} > = </option>
                            <option value="<" {{$parametro->operador == '<' ? 'selected': ''}} > < </option>
                            <option value=">" {{$parametro->operador == '>' ? 'selected': ''}} > > </option>
                            <option value=">=" {{$parametro->operador == '>=' ? 'selected': ''}} > >= </option>
                            <option value="<=" {{$parametro->operador == '<=' ? 'selected': ''}} > <= </option>
                        </select>
                        @error('operador')
                            <p class="mt-1 p-1 text-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col-3">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad"
                            class="form-control {{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                            value="{{ $parametro->cantidad }}">
                        
                    </div>
                    <div class="col-3">
                        <label>% Descuento</label>
                        <input type="number" name="descuento"
                            class="form-control {{ $errors->has('descuento') ? 'is-invalid' : '' }}"
                            value="{{ $parametro->descuento}}">
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-ibizza" data-placement="left">
                        {{ __('Editar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
