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
                <option value="POR MODELO">POR MODELO</option>
                <option value="POR MODELO COSTO ADICIONAL">POR MODELO COSTO ADICIONAL</option>
            </select>
        </div>
        <div class="col">
            <label class="form-label">Descripción del cambio:</label>
            <input type="te xt" class="form-control p-1" wire:model="motivoCambio">
        </div>
    </div>
    <div class="row mb-2">
        <div class="d-flex">
            <label class="my-auto">Datos Faturación</label>
            <button class="btn btn-primary rounded btn-sm ml-2" type="button" wire:click="nuevosDatosFac">
                <i class="fas fa-plus"></i> Nuevos datos
            </button>
        </div>
        <div class="col">
            <label class="form-label"># Factura:</label>
            <input type="text" class="form-control p-1">
        </div>
        <div class="col">
            <label class="form-label">Nombre:</label>
            <input type="text" class="form-control p-1" wire:model="f_nombre">
        </div>
        <div class="col">
            <label class="form-label">Cédula:</label>
            <input type="text" class="form-control p-1" wire:model="f_cedula">
        </div>
        <div class="col">
            <label class="form-label">Teléfono:</label>
            <input type="text" class="form-control p-1" wire:model="f_telefono">
        </div>
        <div class="col">
            <label class="form-label">Correo:</label>
            <input type="text" class="form-control p-1" wire:model="f_correo">
        </div>
    </div>
    <div class="row mb-2">
        <div class="d-flex">
            <label>Datos Envio</label>
            <button class="btn btn-primary rounded btn-sm ml-2" type="button" wire:click="nuevosDatosEnv">
                <i class="fas fa-plus"></i> Nuevos datos
            </button>
            <button class="btn btn-success rounded btn-sm ml-2" type="button" wire:click="nuevosDatosLoc">
                <i class="fas fa-plus"></i> Envio Local
            </button>
        </div>
        <div class="col">
            <label class="form-label">Nombre:</label>
            <input type="text" class="form-control p-1" wire:model="e_nombre">
        </div>
        <div class="col">
            <label class="form-label">Cédula:</label>
            <input type="text" class="form-control p-1" wire:model="e_cedula">
        </div>
        <div class="col">
            <label class="form-label">Teléfono:</label>
            <input type="text" class="form-control p-1" wire:model="e_telefono">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <label class="form-label">Provincia:</label>
            <input type="text" class="form-control p-1" wire:model="e_provincia">
        </div>
        <div class="col">
            <label class="form-label">Ciudad:</label>
            <input type="text" class="form-control p-1" wire:model="e_ciudad">
        </div>
        <div class="col">
            <label class="form-label">Dirección:</label>
            <input type="text" class="form-control p-1" wire:model="e_direccion">
        </div>
    </div>
    <div class="row mb-2">
        <div class="col">
            <label class="form-label">Observaciones:</label>
            <textarea class="form-control" wire:model="observaciones" rows="3">
                {{ $observaciones }}
            </textarea>
        </div>
        <div class="col">
            <label class="form-label">Se va con pedido:</label>
            <input type="text" class="form-control p-1" wire:model="e_pedido">
        </div>
        <div class="col">
            <label class="form-label">N° Guía de Retorno:</label>
            <input type="number" class="form-control p-1" wire:model="id_pedido">
        </div>
    </div>
    <div class="text-center">
        <h6>PRODUCTO VENDIDO</h6>
    </div>
    <div class="row mb-2">
        <div class="col-6">
            <label class="form-label"># de Venta:</label>
            <div class="input-group">
                <input type="text" class="form-control p-1" placeholder="Ingrese el id de la venta"
                    wire:model="idventa">
                <button class="btn btn-primary rounded" type="button" id="search" wire:click='buscarVenta'
                    style="z-index: 10"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
    <div class="row">
        @if (!empty($venta) && !empty($pedidos))
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>CHECK</th>
                        <th>SKU</th>
                        <th>DESCRIPCION</th>
                        <th>COLOR</th>
                        <th>TALLA</th>
                        <th>CANTIDAD</th>
                        <th>DESCUENTO</th>
                        <th>P.V.P</th>
                        <th>P.V.E</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $item)
                        <tr>
                            {{-- <td><input type="checkbox" wire:model="selectedItems.{{ $item['id_producto'] }}" ></td> --}}
                            <td><input type="checkbox" wire:click="selectItem({{ $item['id_producto'] }})" @if ($selectedItem === $item['id_producto']) checked @endif
                                @if ($this->isDisabled($item['id_producto'])) disabled @endif
                                ></td>
                            <td>{{ $item['producto']['sku'] }}</td>
                            <td>{{ $item['producto']['descripcion'] }}</td>
                            <td>{{ $item['producto']['color'] }}</td>
                            <td>{{ $item['producto']['talla'] }}</td>
                            <td>{{ $item['cantidad'] }}</td>
                            <td>{{ $item['descuento'] * 100 }} %</td>
                            <td>{{ number_format($item['cantidad'] * $item['precio'], 2) }}</td>
                            <td>{{ number_format($item['cantidad'] * ($item['precio'] - $item['precio'] * $item['descuento']), 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>


    <div class="modal fade @if($isOpen) show @endif" id="livewireModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: @if($isOpen) block @else none @endif;">
        <div class="modal-dialog modal-lg"  role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambios Registrados</h5>
                    <button type="button" class="close" wire:click="$emit('closeModal')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if (count($changes) > 0)

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Productos Venta</th>
                                            <th>Productos a Cambiar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($changes as $change)
                                            <tr>
                                                <td>
                                                    <div><strong>SKU:</strong> {{ $change['original']['sku'] }}</div>
                                                    <div><strong>Descripcion:</strong> {{ $change['original']['descripcion'] }}</div>
                                                    <div><strong>Color:</strong> {{ $change['original']['color'] }}</div>
                                                    <div><strong>Talla:</strong> {{ $change['original']['talla'] }}</div>
                                                    <div><strong>Cantidad:</strong> {{ $change['original']['cantidad'] }}</div>
                                                    <div><strong>Descuento:</strong> {{ $change['original']['descuento'] }}</div>
                                                    <div><strong>PVP:</strong> {{ $change['original']['pvp'] }}</div>
                                                    <div><strong>P. Empresaria:</strong> {{ $change['original']['p_empresaria'] }}</div>
                                                </td>
                                                <td>
                                                    <div><strong>SKU:</strong> {{ $change['changed']['sku'] }}</div>
                                                    <div><strong>Descripcion:</strong> {{ $change['changed']['descripcion'] }}</div>
                                                    <div><strong>Color:</strong> {{ $change['changed']['color'] }}</div>
                                                    <div><strong>Talla:</strong> {{ $change['changed']['talla'] }}</div>
                                                    <div><strong>Cantidad:</strong> {{ $change['changed']['cantidad'] }}</div>
                                                    {{-- <div><strong>Descuento:</strong> {{ $change['changed']['descuento'] }}</div> --}}
                                                    {{-- <div><strong>PVP:</strong> {{ $change['changed']['pvp'] }}</div> --}}
                                                    {{-- <div><strong>P. Empresaria:</strong> {{ $change['changed']['p_empresaria'] }}</div> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @endif
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$emit('closeModal')">Cerrar</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="text-center">
            <h6>REFERENCIAS DEL PRODUCTO QUE SE LE TIENE QUE ENVIAR A LA EMPRESARIA</h6>
        </div>
        @if (count($changes) > 0)
            <div class="text-right">
                <button type="button" class="btn btn-primary" wire:click="$emit('openModal')">
                    Ver Productos Cambiados
                </button>
            </div>

        @endif

        @if ($selectedItemData['sku'] != '')
            <div class="row" >
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h6><strong>PRODUCTO DE VENTA</strong></h6>
                            <hr>
                        </div>

                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div><strong>SKU:</strong> {{ $selectedItemData['sku'] }}</div>
                            <div><strong>Descripcion:</strong> {{ $selectedItemData['descripcion'] }}</div>
                            <div><strong>Color:</strong> {{ $selectedItemData['color'] }}</div>
                            <div><strong>Talla:</strong> {{ $selectedItemData['talla'] }}</div>
                            <div><strong>Cantidad:</strong> {{ $selectedItemData['cantidad'] }}</div>
                            <div><strong>Descuento:</strong> {{ $selectedItemData['descuento'] }}</div>
                            <div><strong>PVP:</strong> {{ $selectedItemData['pvp'] }}</div>
                            <div><strong>P. Empresaria:</strong> {{ $selectedItemData['p_empresaria'] }}</div>
                        </div>

                    </div>

                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h6><strong>PRODUCTO A CAMBIAR</strong></h6>
                            <hr>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col mb-3 position-relative">
                            <label class="form-label">Código Artículo:</label>
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
                    <div class="my-3 text-right">
                        <button class="btn btn-primary" wire:click="addCart">AGREGAR</button>
                    </div>
                </div>

            </div>

        @endif

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
                            <th>P.V.P</th>
                            <th>DESCUENTO</th>
                            <th>CANTIDAD</th>
                            <th>P.V.E</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nuevoProducto as $index => $item)
                            <tr>
                                <td>{{ $item['sku'] }}</td>
                                <td>{{ $item['descripcion'] }}</td>
                                <td>{{ $item['color'] }}</td>
                                <td>{{ $item['talla'] }}</td>
                                <td>{{ number_format($item['cantidad'] * $item['precio_catalogo'], 2) }}</td>
                                <td>{{ $item['descuento'] * 100 }} % </td>
                                <td>{{ $item['cantidad'] }}</td>
                                <td>{{ number_format($item['cantidad'] * ($item['precio']), 2) }}
                                </td>
                                <td>
                                    <button class="btn btn-danger" wire:click="deleteProduct({{ $index }})">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td>{{ collect($nuevoProducto)->sum('total')}}</td>
                            <td></td>
                            <td>{{collect($nuevoProducto)->sum('cantidad')}}</td>
                            <td>{{collect($nuevoProducto)->sum('total_p_empresaria')}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td></td>
                            <td></td>
                            <td><strong>Envío</strong></td>
                            <td>{{$envio}}</td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total</strong></td>
                            <td>{{collect($nuevoProducto)->sum('diferencia')}}</td>
                        </tr>

                        <tr>
                            <td colspan="4"></td>
                            <td></td>
                            <td></td>
                            <td><strong>Total a Pagar</strong></td>
                            <td>{{collect($nuevoProducto)->sum('diferencia') + $envio }}</td>
                        </tr>


                    </tfoot>
                </table>
            </div>
        @endif

        <div class="my-3">
            <button class="btn bg-ibizza w-25 m-3" wire:click="reservarCambio">RESERVAR CAMBIO</button>
            <button wire:click="saveData" class="btn btn-success w-25 m-3">GUARDAR CAMBIO</button>
        </div>
    </div>

    @if($isOpen)
        <script>
            document.addEventListener('livewire:load', function () {
                var myModal = new bootstrap.Modal(document.getElementById('livewireModal'));
                myModal.show();
            });
        </script>
        @else
            <script>
                document.addEventListener('livewire:load', function () {
                    var myModal = bootstrap.Modal.getInstance(document.getElementById('livewireModal'));
                    if (myModal) {
                        myModal.hide();
                    }
                });
            </script>
    @endif
</div>
