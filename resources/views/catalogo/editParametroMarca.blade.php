<x-app-layout>
    @section('title', 'Catálogo')
    <x-slot name="header">
        <h5 class="text-center">Parametros por Marcas</h5>
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
        <form method="POST" action="{{ route('catalogo.parametros-marca.update', $parametro->id) }}" role="form" id="categoriesForm">
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
                    {{-- <div class="col-6">
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
                    </div> --}}
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



                <div class="row mt-4">
                    <div class="card card-success">
                        <div class="card-header">
                            <span>Productos de Premio</span>


                        </div>

                        <div class="card-body">
                            Listado de productos de premios

                            <div class="row mt-2 justify-content-end mt-auto">
                                <div class="col-3">
                                    <button id="addRowBtn" type="button" class="btn btn-primary">Agregar Categorías</button>
                                </div>
                                <div class="col"></div>
                            </div>



                            <table class="table shadow-sm p-3">
                                <thead>
                                    <tr>
                                        <th>CATEGORÍA</th>
                                        <th>% DESCUENTO</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <!-- Las nuevas filas se agregarán aquí -->
                                </tbody>
                            </table>



                        </div>
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
<script>
    function obtenerCategoriasConDescuento() {
        const categoriasConDescuento = [];
        const filas = document.querySelectorAll('#tableBody tr');

        filas.forEach(function(fila) {
            const categoria = fila.querySelector('select').value;
            const descuento = fila.querySelector('input').value;

            const categoriaConDescuento = {};
            categoriaConDescuento[categoria] = parseInt(descuento);
            categoriasConDescuento.push(categoriaConDescuento);
        });

        return categoriasConDescuento;
    }

    function mostrarCategoriasConDescuento(categoriasJson) {
        const categorias = JSON.parse(categoriasJson);
        categorias.forEach(function(item) {
            for (let categoria in item) {
                const descuento = item[categoria];
                console.log(descuento , ' ss');

                console.log(1 , categoria);

                const nuevaCategoria = categoria ;
                // Agregar la categoría y descuento a la tabla
                const newRow = document.createElement('tr');
                const categoriaCell = document.createElement('td');
                const selectHtml = `<x-adminlte-select2 class="form-control" name="marca_nuevo">
                                        @foreach ($categorias as $cat)
                                            <option value="{{ $cat->categoria }}" {{ $cat->categoria ==`+categoria + ` ? 'selected' : '' }}>
                                                {{ $cat->categoria }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>`;

                categoriaCell.innerHTML = selectHtml;
                const descuentoCell = document.createElement('td');
                descuentoCell.innerHTML = `<input type="number" name="marcas" class="form-control" placeholder="Ingrese % descuento" value="${descuento}">`;
                const actionCell = document.createElement('td');
                actionCell.innerHTML = '<button type="button" class="btn btn-danger btn-sm deleteRowBtn">Eliminar</button>';

                newRow.appendChild(categoriaCell);
                newRow.appendChild(descuentoCell);
                newRow.appendChild(actionCell);

                document.getElementById('tableBody').appendChild(newRow);
            }
        });
    }


    // Función para agregar una nueva fila
    document.getElementById('addRowBtn').addEventListener('click', function() {
    // Crear una nueva fila
    const newRow = document.createElement('tr');

    // Función para crear el HTML del select con las opciones
    function generateSelectOptions() {
        let optionsHtml = '';
        @foreach ($categorias as $categoria)
            optionsHtml += `<option value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>`;
        @endforeach
        return optionsHtml;
    }

    // Crear celda para la categoría
    const categoriaCell = document.createElement('td');
    categoriaCell.innerHTML = `
        <x-adminlte-select2 id="sel2Category" class="form-control" name="marca_nuevo">
            ${generateSelectOptions()}
        </x-adminlte-select2>
    `;

    // Crear celda para el descuento
    const descuentoCell = document.createElement('td');
    descuentoCell.innerHTML = '<input type="number" name="marcas" class="form-control" placeholder="Ingrese % descuento">';

    // Crear celda para la acción
    const actionCell = document.createElement('td');
    actionCell.innerHTML = '<button type="button" class="btn btn-danger btn-sm deleteRowBtn">Eliminar</button>';

    // Agregar celdas a la nueva fila
    newRow.appendChild(categoriaCell);
    newRow.appendChild(descuentoCell);
    newRow.appendChild(actionCell);

    // Agregar la nueva fila a la tabla
    document.getElementById('tableBody').appendChild(newRow);
});

    // Delegar el evento de eliminación a las filas dinámicas
    document.getElementById('tableBody').addEventListener('click', function(event) {
        if (event.target && event.target.matches('.deleteRowBtn')) {
            const row = event.target.closest('tr');
            row.parentNode.removeChild(row);
        }
    });

    // Ejemplo de cómo enviar los datos al backend
    document.getElementById('categoriesForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe de forma convencional

        const categoriasConDescuento = obtenerCategoriasConDescuento();
        console.log(categoriasConDescuento); // Solo para depuración, puedes enviar estos datos al backend mediante una petición AJAX o añadirlos al formulario antes de enviarlo

        // Puedes añadir los datos al formulario antes de enviarlo
        const inputCategoriasConDescuento = document.createElement('input');
        inputCategoriasConDescuento.setAttribute('type', 'hidden');
        inputCategoriasConDescuento.setAttribute('name', 'categorias_con_descuento');
        inputCategoriasConDescuento.setAttribute('value', JSON.stringify(categoriasConDescuento));
        document.getElementById('categoriesForm').appendChild(inputCategoriasConDescuento);

        // Envía el formulario
        this.submit();
    });


    document.addEventListener("DOMContentLoaded", function() {
        const categoriasConDescuentoJson = {!! json_encode($parametro->categorias_con_descuento) !!};
        mostrarCategoriasConDescuento(categoriasConDescuentoJson);
    });

</script>
