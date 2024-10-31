<x-app-layout>
    @section('title', 'Catálogo')
    <x-slot name="header">
        <h5 class="text-center">Parámetros por categoria</h5>
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
                    {{ __('Nuevo') }}
                </span>

                <div class="float-right">
                    <a href="{{ route('catalogo.parametros-marca') }}" class="btn btn-ibizza btn-sm float-right"
                        data-placement="left">
                        {{ __('Regresar') }}
                    </a>
                </div>
            </div>
        </div>
        <form method="POST" action="{{ route('catalogo.parametros-marca-nuevo.store') }}" role="form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre"
                            class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}"
                            value="{{ old('nombre') }}">
                    </div>
                    <div class="col-3">
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

                </div>
                <div class="row">
                    <div class="col-3">
                        {{ Form::label('Condición') }}
                        <select name="condicion"
                            class="form-select  {{ $errors->has('condicion') ? 'is-invalid' : '' }}">
                            <option value="">Seleccione una opción</option>
                            <option value="factura">Total a pagar</option>
                            <option value="cantidad">Cantidad de productos</option>
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
                    <div class="col-3">
                        <label>Cantidad</label>
                        <input type="number" name="cantidad"
                            class="form-control {{ $errors->has('cantidad') ? 'is-invalid' : '' }}"
                            value="{{ old('cantidad') }}">

                    </div>
                </div>
                <div class="row mt-4">
                    <div class="card">
                        <div class="card-header align-items-center">
                            <div class="row">
                                <div class="col-md-8">
                                    <span>DESCUENTO DE CATEGORÍAS</span>

                                </div>

                                <div class="col-md-4 card-header-custom  d-flex justify-content-end">

                                    <button type="button" class="btn btn-primary" onclick="addRow()">Agregar Fila</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            Listado de Descuentos
                            <div class="row">
                                <table id="categoryTable" class="table shadow-sm p-3">
                                    <tr>
                                        <th>Categoría</th>
                                        <th>% Descuento</th>
                                        <th>Acción</th>
                                    </tr>

                                </table>

                            </div>
                        </div>
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
<script>
    function addRow() {
        let table = document.getElementById("categoryTable");
        let rowCount = table.rows.length;
        let row = table.insertRow();
        let cell1 = row.insertCell(0);
        let cell2 = row.insertCell(1);
        let cell3 = row.insertCell(2);

        cell1.innerHTML = `<select class="form-select" name="categorias[${rowCount}][categoria]">
                               @foreach($categorias as $categoria)
                                   <option value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>
                               @endforeach
                           </select>`;
        cell2.innerHTML = '<input type="number" name="categorias[' + rowCount + '][descuento]"  class="form-control">';
        cell3.innerHTML = '<button type="button" onclick="deleteRow(this)" class="btn btn-danger btn-sm">Eliminar</button>';
    }

    function deleteRow(button) {
        let row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>

