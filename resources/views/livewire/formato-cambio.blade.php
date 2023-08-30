<div>
    @empty(!$message)
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @endempty
    <div class="row mb-2">
        <div class="col">
            <label class="form-label"># Cambio:</label>
            <input type="text" class="form-control p-1" value="00001" disabled>
        </div>
        <div class="col">
            <label class="form-label">Asesor:</label>
            <input type="text" class="form-control p-1" value="{{ $user->name }}" disabled>
        </div>
        <div class="col">
            <label class="form-label">Fecha Emisión:</label>
            <input type="text" class="form-control p-1" value="{{ date('d-m-Y') }}" disabled>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col mb-2 position-relative">
            <label class="form-label">Nombre de Empresaria:</label>
            <div class="input-group">
                <input type="text" class="form-control p-1" wire:model.debounce.500ms='cliente'
                    placeholder="Ingrese el nombre de la empresaria para su pedido" {{ $click2 ? 'disabled' : '' }}>
                <button class="btn btn-danger rounded" type="button" wire:click='clearEmpresaria'
                    style="z-index: 10"><i class="fas fa-trash"></i></button>
            </div>
            @if (!empty($empresarias))
                <div class="position-absolute bg-white shadow mt-2" style="width: 100%; z-index: 100">
                    <ul class="list-group">
                        @foreach ($empresarias as $empresaria)
                            <li class="list-group-item bg-white"
                                wire:click='clickEmpresaria({{ $empresaria }}, "{{ $empresaria->tipo_cliente }}")'>
                                {{ $empresaria->cedula . ' | ' . $empresaria->nombres . ' ' . $empresaria->apellidos }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col">
            <label class="form-label">Tipo Empresaria:</label>
            <input type="text" class="form-control p-1" value="{{ $this->tipoEmpresaria }}" disabled>
        </div>
        <div class="col">
            <label class="form-label">Motivo de cambio:</label>
            <select class="form-select" wire:model="descripcionCambio">
                <option value="COLOR">COLOR</option>
                <option value="TALLA">TALLA</option>
                <option value="COLOR Y TALLA">COLOR Y TALLA</option>
                <option value="AVERIA">AVERIA</option>
            </select>
        </div>
        <div class="col">
            <label class="form-label">Descripción del cambio:</label>
            <input type="te xt" class="form-control p-1" value="{{ $this->motivoCambio }}">
        </div>
    </div>
    <div class="row mb-2">
        <label>Datos Faturación</label>
        <div class="col">
            <label class="form-label"># Factura:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Nombre:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Cédula:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Teléfono:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Correo:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
    </div>
    <div class="row mb-2">
        <label>Datos Envio</label>
        <div class="col">
            <label class="form-label">Nombre:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Cédula:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Teléfono:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <label class="form-label">Provincia:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Ciudad:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Dirección:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <label class="form-label">Observaciones:</label>
            <textarea class="form-control" wire:model="observaciones" rows="3"></textarea>
        </div>
        <div class="col">
            <label class="form-label">Se va con pedido:</label>
            <input type="text" class="form-control p-1" value="">
        </div>
        <div class="col">
            <label class="form-label">Costo Envio:</label>
            <input type="number" class="form-control p-1" value="">
        </div>
    </div>
    <hr />
    <div class="row mb-2">
        <div class="text-center">
            <h6>PRODUCTO VENDIDO</h6>
        </div>
        <div class="col">
            <label class="form-label"># de Venta:</label>
            <div class="input-group">
                <input type="text" class="form-control p-1" placeholder="Ingrese el id de la venta"
                    wire:model.debounce.500ms="idventa">
                <button class="btn btn-primary rounded" type="button" id="search" wire:click='buscarVenta'
                    style="z-index: 10"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <div class="col">
            <label class="form-label">Seleccione el producto:</label>
            <select class="form-select" wire:model="productosACambiar">
                @if (empty($pedidos))
                    <option value="0">Seleccione un producto</option>
                @else
                    @foreach ($pedidos as $producto)
                        <option value="{{ $producto }}">{{ $producto->producto->descripcion }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    <div class="row">
        @if (!empty($venta) && !empty($pedidos))
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>DESCRIPCION</th>
                        <th>COLOR</th>
                        <th>TALLA</th>
                        <th>CANTIDAD</th>
                        <th>DESCUENTO</th>
                        <th>PVP</th>
                        <th>P.EMPRESARIA</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $item)
                        <tr>
                            <td>{{ $item['producto']['sku'] }}</td>
                            <td>{{ $item['producto']['descripcion'] }}</td>
                            <td>{{ $item['producto']['color'] }}</td>
                            <td>{{ $item['producto']['talla'] }}</td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>{{ $item['descuento'] }}</td>
                            <td>{{ number_format($item['cantidad'] * $item['precio'], 2) }}</td>
                            <td>{{ number_format($item['cantidad'] * ($item['precio'] - $item['precio'] * $item['descuento']), 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <hr />
    <div class="row">
        <div class="text-center">
            <h6>REFERENCIAS DEL PRODUCTO QUE SE LE TIENE QUE ENVIAR A LA EMPRESARIA</h6>
        </div>
        <div class="row">
            <div class="col mb-3 position-relative">
                <label class="form-label">Codigo Artículo:</label>
                <div class="input-group">
                    <input type="text" class="form-control p-1" placeholder="Ingrese el código"
                        wire:model.debounce.500ms="estilo" wire:keydown.enter='buscarEstilo'>
                    <button class="btn btn-primary rounded" type="button" id="search" wire:click='buscarEstilo'
                        style="z-index: 10"><i class="fas fa-search"></i></button>
                </div>
                @if (!empty($similitudes))
                    <div class="position-absolute bg-white shadow mt-2" style="width: 100%; z-index: 100">
                        <ul class="list-group">
                            @foreach ($similitudes as $similitud)
                                <li class="list-group-item bg-white"
                                    wire:click='clickSimilitud("{{ $similitud->estilo }}")'>
                                    {{ $similitud->estilo }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col mb-3">
                <label class="form-label">Seleccionar Color:</label>
                <select class="form-select p-2" id="optColor" wire:model='color' wire:change='buscarColor'>
                    @empty(!$colores)
                        @foreach ($colores as $color)
                            <option value="{{ $color->color }}">{{ $color->color }}</option>
                        @endforeach
                    @else
                        <option value="">SELECCIONE</option>
                    @endempty
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <label class="form-label">Ingrese Unidades:</label>
                <input type="number" class="form-control p-1" wire:model='cantidad'
                    placeholder="unidades deseadas">
            </div>
            <div class="col mb-3">
                <label class="form-label">Seleccionar Talla:</label>
                <select class="form-select p-2" wire:model="talla" wire:change='stockProduct({{ $talla }})'>
                    @empty(!$tallas)
                        @foreach ($tallas as $talla)
                            <option value="{{ $talla->talla }}">{{ $talla->talla }}</option>
                        @endforeach
                    @else
                        <option value="">SELECCIONE</option>
                    @endempty
                </select>
            </div>
        </div>
        <div class="row">
            <div class="">
                @empty(!$tallas)
                    <div class="row">
                        <div class="col-6">
                            <span>{{ $tallas[0]->nombre_mostrar }}</span>
                            <br>
                            <span class="{{ $stock == 0 ? 'badge badge-pill bg-danger' : '' }}">Marca:
                                {{ $marca }} | STOCK:
                                <b>{{ $stock == 0 ? 'AGOTADO' : $stock }}</b></span>
                        </div>
                        <div class="col-6">
                            @empty(!$tallas[0]->descuento)
                                <span class="badge badge-pill bg-ibizza" style="font-size: 0.9rem;">Descuento:
                                    {{ $tallas[0]->descuento }}%</span>
                                <span class="badge badge-pill badge-dark" style="font-size: 0.9rem;">P.Final:
                                    ${{ number_format(
                                        $tallas[0]->precio_empresaria - $tallas[0]->precio_empresaria * ($tallas[0]->descuento / 100),
                                        2,
                                    ) }}</span>
                            @else
                                <span class="badge badge-pill badge-dark" style="font-size: 0.9rem;">P.Final:
                                    ${{ number_format($tallas[0]->precio_empresaria, 2) }}</span>
                            @endempty
                        </div>
                    </div>
                @endempty
            </div>
        </div>
        <div class="my-3">
            <button class="btn btn-primary" wire:click="addCart">AGREGAR</button>
        </div>
        <hr />
        @if (!empty($nuevoProducto))
            <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>SKU</th>
                            <th>DESCRIPCION</th>
                            <th>COLOR</th>
                            <th>TALLA</th>
                            <th>CANTIDAD</th>
                            <th>DESCUENTO</th>
                            <th>PVP</th>
                            <th>P.EMPRESARIA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nuevoProducto as $item)
                            <tr>
                                <td>{{ $item['sku'] }}</td>
                                <td>{{ $item['descripcion'] }}</td>
                                <td>{{ $item['color'] }}</td>
                                <td>{{ $item['talla'] }}</td>
                                <td>{{ $item['cantidad'] }}</td>
                                <td>{{ $item['descuento'] }}</td>
                                <td>{{ number_format($item['cantidad'] * $item['precio'], 2) }}</td>
                                <td>{{ number_format($item['cantidad'] * ($item['precio'] - $item['precio'] * $item['descuento']), 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="my-3">
            <button class="btn btn-primary">GUARDAR CAMBIO</button>
        </div>
    </div>
</div>
