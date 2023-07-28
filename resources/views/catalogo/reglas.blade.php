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
                    {{ __('Nueva Regla') }}
                </span>

                <div class="float-right">
                    <a href="{{ route('catalogo.parametros') }}" class="btn btn-ibizza btn-sm float-right"
                        data-placement="left">
                        {{ __('Regresar') }}
                    </a>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('catalogo.reglas.create') }}" role="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <label class="form-label">Catalogos:</label>
                        <select name="catalogo" class="form-select {{ $errors->has('catalogo') ? 'is-invalid' : '' }}">
                            <option value="0">Seleccione</option>
                            @foreach ($catalogos as $catalogo)
                                <option value="{{ $catalogo->id }}">{{ $catalogo->nombre }}</option>
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
                                <option value="PROSPECTO" {{ old('tipo_cliente') == 'PROSPECTO' ? 'selected' : '' }}>
                                    PROSPECTO
                                </option>
                                <option value="NUEVA" {{ old('tipo_cliente') == 'NUEVA' ? 'selected' : '' }}>
                                    NUEVA
                                </option>
                                <option value="CONTINUA" {{ old('tipo_cliente') == 'CONTINUA' ? 'selected' : '' }}>
                                    CONTINUA
                                </option>
                                <option value="INACTIVA-1" {{ old('tipo_cliente') == 'INACTIVA-1' ? 'selected' : '' }}>
                                    INACTIVA-1
                                </option>
                                <option value="INACTIVA-2" {{ old('tipo_cliente') == 'INACTIVA-2' ? 'selected' : '' }}>
                                    INACTIVA-2
                                </option>
                                <option value="INACTIVA-3" {{ old('tipo_cliente') == 'INACTIVA-3' ? 'selected' : '' }}>
                                    INACTIVA-3
                                </option>
                                <option value="POSIBLE BAJA"
                                    {{ old('tipo_cliente') == 'POSIBLE BAJA' ? 'selected' : '' }}>
                                    POSIBLE BAJA
                                </option>
                                <option value="REACTIVA" {{ old('tipo_cliente') == 'REACTIVA' ? 'selected' : '' }}>
                                    REACTIVA
                                </option>
                                <option value="BAJA" {{ old('tipo_cliente') == 'BAJA' ? 'selected' : '' }}>
                                    BAJA
                                </option>
                                <option value="RE-INGRESO" {{ old('tipo_cliente') == 'RE-INGRESO' ? 'selected' : '' }}>
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
                            <option value="="> = </option>
                            <option value="<">
                                < </option>
                            <option value=">"> > </option>
                            <option value=">="> >= </option>
                            <option value="<=">
                                <= </option>
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
                        {{ __('Guardar') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
