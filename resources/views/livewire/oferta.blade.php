<div>

    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">

                <span id="card_title">
                    {{ __('Nuevo') }}
                </span>

                <div class="float-right">
                    <a href="{{ route('ofertas.index') }}" class="btn btn-ibizza btn-sm float-right" data-placement="left">
                        {{ __('Regresar') }}
                    </a>
                </div>
            </div>
        </div>

        @if ($message)
            <div class="alert alert-info">
                <p>{{ $message }}</p>
            </div>
        @endif

        <form action="" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="oferta">Oferta</label>
                            <input type="text" name="oferta" id="oferta" class="form-control"
                                wire:model="oferta">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="catalogo_id">Catálogo</label>
                            <select name="catalogo_id" id="catalogo_id" class="form-control" wire:model="catalogo">
                                <option value="">Seleccione un catálogo</option>
                                @foreach ($catalogos as $catalogo)
                                    <option value="{{ $catalogo->id }}">{{ $catalogo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="tipo_oferta">Tipo de Oferta</label>
                            <select name="tipo_oferta" id="tipo_oferta" class="form-control" wire:model="tipoOferta">
                                <option value="">Seleccione un tipo de oferta</option>
                                <option value="1">Cantidad Productos</option>
                                <option value="2">Marca</option>
                                <option value="3">Clasificación</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="cantidadPro" class="form-control" wire:model="cantidadPro"
                                min="0">
                        </div>
                    </div>
                    @if ($tipoOferta == 1)
                        <div class="col-3">
                            <div class="form-group">
                                <label for="marca">Productos</label>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" placeholder=""
                                        wire:model.debounce.50ms="estilo">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Agregar</button>
                                    </div>
                                </div>
                                @if (!empty($similitudes))
                                    <div class="position-absolute bg-white shadow" style="width: 100%; z-index: 100">
                                        <ul class="list-group">
                                            @foreach ($similitudes as $similitud)
                                                <li class="list-group-item bg-white"
                                                    wire:click='clickSimilitud("{{ $similitud->estilo }}", "{{ $similitud->color }}")'>
                                                    {{ $similitud->estilo . ' - ' . $similitud->color }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    @if ($tipoOferta == 2)
                        <div class="col-3">
                            <div class="form-group">
                                <label for="marca">Marca</label>
                                <select name="marca" id="marca" class="form-control" wire:model="marca">
                                    <option value="">TODAS</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="desde">Desde</label>
                                <input type="number" name="desde" id="desde" class="form-control"
                                    wire:model="desde">
                            </div>
                        </div>
                    @endif
                    @if ($tipoOferta == 3)
                        <div class="col-3">
                            <div class="form-group">
                                <label for="clasificacion">clasificación</label>
                                <select name="clasificacion" id="clasificacion" class="form-control" wire:model="clasificacion">
                                    <option value="">Seleccione una clasificación</option>
                                    @foreach ($clasificaciones as $cla)
                                        <option value="{{ $cla->clasificacion_global }}">{{ $cla->clasificacion_global}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="desde">Desde</label>
                                <input type="number" name="desde" id="desde" class="form-control"
                                    wire:model="desde">
                            </div>
                        </div>
                    @endif
                    <div class="col-3">
                        <div class="form-group">
                            <label for="tipo_premio">Tipo Premio</label>
                            <select name="tipo_premio" id="tipo_premio" class="form-control" wire:model="tipoPremio">
                                <option value="">Seleccione un tipo de premio</option>
                                <option value="1">Precio Especial</option>
                                <option value="2">Producto</option>
                            </select>
                        </div>
                    </div>
                    @if ($tipoPremio == 1)
                        <div class="col-3">
                            <div class="form-group">
                                <label for="valor">Valor</label>
                                <input type="number" name="valor" id="valor" class="form-control"
                                    wire:model="valor">
                            </div>
                        </div>
                    @endif
                    @if ($tipoPremio == 2)
                        <div class="col-2">
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input type="number" name="cantidadPrem" class="form-control"
                                    wire:model="cantidadPrem" min="0">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="premio">Premio</label>
                                <div class="input-group mb-1">
                                    <input type="text" class="form-control" placeholder=""
                                        wire:model.debounce.50ms="estilo2">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-secondary" type="button">Agregar</button>
                                    </div>
                                </div>
                                @if (!empty($similitudes2))
                                    <div class="position-absolute bg-white shadow" style="width: 100%; z-index: 100">
                                        <ul class="list-group">
                                            @foreach ($similitudes2 as $similitud)
                                                <li class="list-group-item bg-white"
                                                    wire:click='clickSimilitud2("{{ $similitud->estilo }}", "{{ $similitud->color }}")'>
                                                    {{ $similitud->estilo . ' - ' . $similitud->color }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card-footer">
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-ibizza" wire:click="guardar">Guardar</button>
                    </div>
                </div>
            </div>
        </form>


    </div>

    <div class="row my-2 w-100">
        <div class="col">
            <div class="card card-primary">
                <div class="card-header">
                    <span>Productos de Oferta</span>
                </div>
                <div class="card-body">
                    Listado de productos de oferta
                    @if ($productos)
                        <table class="table shadow-sm p-3">
                            <thead>
                                <tr>
                                    <th>Estilo</th>
                                    <th>Color</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ isset($producto->estilo) ? $producto->estilo : $producto['estilo'] }}
                                        </td>
                                        <td>{{ isset($producto->color) ? $producto->color : $producto['color'] }}</td>
                                        <td>
                                            {{ isset($producto->cantidad) ? $producto->cantidad : $producto['cantidad'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card card-success">
                <div class="card-header">
                    <span>Productos de Premio</span>
                </div>

                <div class="card-body">
                    Listado de productos de premios


                    @if ($productos2)
                        <table class="table shadow-sm p-3">
                            <thead>
                                <tr>
                                    <th>Estilo</th>
                                    <th>Color</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos2 as $producto)
                                    <tr>
                                        <td>{{ isset($producto->estilo) ? $producto->estilo : $producto['estilo'] }}
                                        </td>
                                        <td>{{ isset($producto->color) ? $producto->color : $producto['color'] }}</td>
                                        <td>
                                            {{ isset($producto->cantidad) ? $producto->cantidad : $producto['cantidad'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
