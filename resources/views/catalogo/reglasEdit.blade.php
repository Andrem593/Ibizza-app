<x-app-layout>
    @section('title', 'Catálogo')
    <x-slot name="header">
        <h5 class="text-center">Reglas de Catálogo</h5>
    </x-slot>

    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Editar Regla') }}
                </span>

                <div class="float-right">
                    <a href="{{ route('catalogo.parametros') }}" class="btn btn-ibizza btn-sm float-right"
                        data-placement="left">
                        {{ __('Regresar') }}
                    </a>
                </div>
            </div>
        </div>
        <form method="POST" action="{{route('catalogo.reglas.edit', $regla->id)}}" role="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Catalogos:</label>
                        <select name="catalogo" class="form-select {{ $errors->has('catalogo') ? 'is-invalid' : '' }}">
                            <option value="0">Seleccione</option>
                            @foreach ($catalogos as $catalogo)
                                <option value="{{ $catalogo->id }}" {{ $regla->catalogo_id == $catalogo->id  ? 'selected' : '' }}  >{{ $catalogo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('catalogo')
                            <p class="mt-1 p-1 text-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col">
                        <div class="form-group">
                            {{ Form::label('tipo_empresaria') }}
                            <select name="tipo_cliente"
                                class="form-select {{ $errors->has('tipo_cliente') ? 'is-invalid' : '' }}">
                                <option value="TODOS">TODOS</option>
                                <option value="PROSPECTO" {{ $regla->tipo_empresaria == 'PROSPECTO' ? 'selected' : '' }}>
                                    PROSPECTO
                                </option>
                                <option value="NUEVA" {{ $regla->tipo_empresaria == 'NUEVA' ? 'selected' : '' }}>
                                    NUEVA
                                </option>
                                <option value="CONTINUA" {{ $regla->tipo_empresaria == 'CONTINUA' ? 'selected' : '' }}>
                                    CONTINUA
                                </option>
                                <option value="INACTIVA-1" {{ $regla->tipo_empresaria == 'INACTIVA-1' ? 'selected' : '' }}>
                                    INACTIVA-1
                                </option>
                                <option value="INACTIVA-2" {{ $regla->tipo_empresaria == 'INACTIVA-2' ? 'selected' : '' }}>
                                    INACTIVA-2
                                </option>
                                <option value="INACTIVA-3" {{ $regla->tipo_empresaria == 'INACTIVA-3' ? 'selected' : '' }}>
                                    INACTIVA-3
                                </option>
                                <option value="POSIBLE BAJA"
                                    {{ $regla->tipo_empresaria == 'POSIBLE BAJA' ? 'selected' : '' }}>
                                    POSIBLE BAJA
                                </option>
                                <option value="REACTIVA" {{ $regla->tipo_empresaria == 'REACTIVA' ? 'selected' : '' }}>
                                    REACTIVA
                                </option>
                                <option value="BAJA" {{ $regla->tipo_empresaria == 'BAJA' ? 'selected' : '' }}>
                                    BAJA
                                </option>
                                <option value="RE-INGRESO" {{ $regla->tipo_empresaria == 'RE-INGRESO' ? 'selected' : '' }}>
                                    RE-INGRESO
                                </option>
                            </select>
                            @error('tipo_cliente')
                                <p class="mt-1 p-1 text-danger" role="alert">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        {{ Form::label('Condición') }}
                        <select name="condicion"
                            class="form-select  {{ $errors->has('condicion') ? 'is-invalid' : '' }}">
                            <option value="">Seleccione una opción</option>
                            <option value="factura">Total a pagar</option>
                            <option value="cantidad">Cantidad de productos</option>
                            <option value="envio_costo">Costo de envio por valor</option>
                            <option value="envio_cantidad">Costo de envio por cantidad</option>
                        </select>
                        @error('condicion')
                            <p class="mt-1 p-1 text-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        {{ Form::label('Operador') }}
                        <select name="operador" class="form-select {{ $errors->has('operador') ? 'is-invalid' : '' }}">
                            <option value="">Seleccione una opción</option>
                            <option value="=" {{ $regla->operador == '=' ? 'selected' : '' }} > = </option>
                            <option value="<" {{ $regla->operador == '<' ? 'selected' : '' }} > < </option>
                            <option value=">" {{ $regla->operador == '>' ? 'selected' : '' }} > > </option>
                            <option value=">="{{ $regla->operador == '>=' ? 'selected' : '' }} > >= </option>
                            <option value="<="{{ $regla->operador == '<=' ? 'selected' : '' }} > <= </option>
                        </select>
                        @error('operador')
                            <p class="mt-1 p-1 text-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col">
                        {{ Form::label('Cantidad') }}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">#</span>
                            </div>
                            <input type="number"
                                class="form-control {{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                                value="{{ $regla->cantidad }}"
                                name="cantidad">
                        </div>
                        @error('cantidad')
                            <p class="mt-1 p-1 text-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="col">
                        {{ Form::label('Valor') }}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">%</span>
                            </div>
                            <input type="number" class="form-control  {{ $errors->has('valor') ? 'is-invalid' : '' }}"
                                value="{{ $regla->valor }}"
                                name="valor">
                        </div>
                        @error('valor')
                            <p class="mt-1 p-1 text-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-ibizza" data-placement="left">
                        {{ __('Actualizar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
