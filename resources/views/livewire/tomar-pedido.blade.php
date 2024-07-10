<div>
    @empty(!$message)
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
    @endempty
    <div class="row mb-2">
        <div class="col">
            <label class="form-label"># Pedido:</label>
            <input type="text" class="form-control p-1" value="{{ $venta }}" disabled>
        </div>
        <div class="col">
            <label class="form-label">Asesor:</label>
            <input type="text" class="form-control p-1" value="{{ $user->name }}" disabled>
        </div>
        <div class="col">
            <label class="form-label">Fecha Emisión:</label>
            <input type="text" class="form-control p-1" value="{{ date('d-m-Y') }}" disabled>
        </div>
        <div class="col">
            <label class="form-label">Fecha Vencimiento:</label>
            <input type="text" class="form-control p-1" value="{{ date('d-m-Y', strtotime('+3 days')) }}" disabled>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card rounded">
                <img src="{{ $imagen }}" alt="" height="100%" class="" style="object-fit: cover">
            </div>
        </div>
        <div class="col">
            @if (Auth::user()->role != 'Empresaria')
                <div class="row ">
                    <div class="col mb-2 position-relative">
                        <label class="form-label">Nombre de Empresaria:</label>
                        <div class="input-group">
                            <input type="text" class="form-control p-1" wire:model.debounce.50ms='cliente'
                                placeholder="Ingrese el nombre de la empresaria para su pedido"
                                {{ $click2 ? 'disabled' : '' }}>
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
                </div>
            @endif
            <div class="row">
                <div class="col mb-3 position-relative">
                    <label class="form-label">Codigo Artículo:</label>
                    <div class="input-group">
                        <input type="text" class="form-control p-1" placeholder="Ingrese el código"
                            wire:model.debounce.50ms="estilo" wire:keydown.enter='buscarEstilo'>
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
                                {{-- <span>{{ $tallas[0]->nombre_mostrar }}</span> --}}
                                <span>{{ $descripcion_producto }}</span>
                                <br>
                                <span class="{{ $stock == 0 ? 'badge badge-pill bg-danger' : '' }}"> Marca:
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
                                    <span class="badge badge-pill badge-dark" style="font-size: 0.9rem;">P.V.C:
                                        ${{ number_format($tallas[0]->precio_empresaria, 2) }}</span>
                                @endempty
                            </div>
                        </div>
                    @endempty
                </div>
                <div class="my-3">
                    <button class="btn btn-primary" wire:click="addCart">AGREGAR</button>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <div class="ec-vendor-card-table">
            <table class="table ec-table" style="font-size: 14px">
                <thead>
                    <tr>
                        {{--<th scope="col">Foto</th>--}}
                        <th>SKU</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Marca</th>
                        <th scope="col">Color</th>
                        <th scope="col">Talla</th>
                        <th scope="col">P.V.C</th>
                        <th scope="col">Desc</th>
                        <th scope="col" width="15px">Cant</th>
                        <th scope="col">P.V.E</th>
                        <th scope="col" class="d-none">Dirección</th>
                        <th scope="col" width="10px">Opc</th>
                    </tr>
                </thead>
                <tbody>
                    @if (Cart::count() > 0)
                        @foreach (Cart::content() as $item)
                            <tr>
                                {{-- CAMBIO DE IMAGEN POR SKU --}}
                                {{-- <td>
                                    <img src="{{ '../storage/images/productos/' . $item->options->image }}"
                                        width="50px" height="50px" style="object-fit: cover">
                                </td> --}}
                                <td>
                                    {{ $item->options->sku }}
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->options->marca }}</td>
                                <td>{{ $item->options->color }}</td>
                                <td>{{ $item->options->talla }}</td>
                                <td>${{ $item->options->pCatalogo * $item->qty }}</td>
                                <td>{{ $item->options->descuento * 100 }}%</td>
                                <td>
                                    <span class="mx-2">{{ $item->qty }}</span>
                                </td>
                                <td>${{ number_format($item->qty * $item->price, 2) }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-sm btn-outline-default mr-1" 
                                        wire:click="openModal('{{ $item->rowId }}')">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </button>
                                        
                                        <button class="btn btn-sm btn-outline-primary mr-1"
                                            wire:click="increaseQuantity('{{ $item->rowId }}')">+</button>
                                        <button class="btn btn-sm btn-outline-danger mr-1"
                                            wire:click="decreaseQuantity('{{ $item->rowId }}')">-</button>
                                        <a wire:click="eliminarItem('{{ $item->rowId }}')">
                                            <i
                                                class="{{ Auth::user()->role != 'Empresaria' ? 'fas fa-trash' : 'ecicon eci-trash-o ' }}">
                                            </i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @if ($item->options->dataEnvio != '')
                            <tr>
                                <td></td>
                                <td colspan="10">
                                    @php
                                        $data = json_decode($item->options->dataEnvio);
                                        if ($item->options->dataEnvio != '') {
                                            $data = json_decode($item->options->dataEnvio);
                                            //echo "Identificación: $data->identificacion <br> Nombre: $data->nombre <br> Tel: $data->telefono <br> Dir: $data->direccion <br> Ref: $data->referencia";
                                        }
                                    @endphp
                                    <table class="table table-borderless table-sm">
                                        <tr>
                                            <td style="width: 10%;">Identificación: </td>
                                            <td>{{ $data->identificacion }} </td>
                                        </tr>
                                        <tr>
                                            <td>Nombre: </td>
                                            <td>{{ $data->nombre }} </td>
                                        </tr>
                                        <tr>
                                            <td>Teléfono: </td>
                                            <td>{{ $data->telefono }}</td>
                                        </tr>
                                        <tr>
                                            <td> Dirección: </td>
                                            <td>{{ $data->direccion }}</td>
                                       </tr>
                                        <tr>
                                            <td> Referencia: </td>
                                            <td>{{ $data->referencia }}</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="emp-cart-msg text-center"> SIN PRODUCTOS PEDIDOS</td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="border-none" colspan="5">
                            <span></span>
                        </td>
                        <td colspan="2" class="fw-bold">
                            ${{ number_format(Cart::content()->map(function ($item) {return $item->options->pCatalogo * $item->qty;})->sum(),2) }}
                        </td>
                        <td class="fw-bold"> {{ Cart::count() }}</td>
                        <td class="fw-bold" colspan="2">
                            ${{ number_format(Cart::content()->map(function ($item) {return round($item->price * $item->qty, 2);})->sum(),2) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="border-none" colspan="7">
                            <span></span>
                        </td>
                        <td class="" colspan="1">
                            <span><strong>Envio</strong></span>
                        </td>
                        <td colspan="2">
                            <span class="fw-bold">${{ $envio }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-none" colspan="7">
                        <td class="" colspan="1">
                            <span><strong>Total</strong></span>
                        </td>
                        <td colspan="3">
                            <span
                                class="fw-bold">${{number_format(number_format(Cart::content()->map(function ($item) {return round($item->price * $item->qty, 2);})->sum(),2) + floatval($envio),2)}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-none" colspan="7"><span class="note-text-color"></span></td>
                        <td class="" colspan="1">
                            <span><strong>Ganancias</strong></span>
                        </td>
                        <td colspan="2">
                            <span
                                class="fw-bold">${{ number_format(Cart::content()->map(function ($item) {return $item->options->pCatalogo * $item->qty;})->sum() - number_format(Cart::content()->map(function ($item) {return round($item->price * $item->qty, 2);})->sum(),2),2) }}</span>
                        </td>
                    </tr>
                    @if (!empty($emp))
                        @if (count($emp->pedidos) == 0)
                            <tr>
                                <td class="border-none" colspan="7"> </td>
                                <td class="" colspan="3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" checked
                                            disabled>
                                        <label class="form-check-label">
                                            Enviar catálogo
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endif
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row mt-2 text-end">
        <button class="btn bg-ibizza w-25 m-3" wire:click='GuardarPedidos' wire:loading.attr="disabled"
        wire:target="GuardarPedidos">RESERVAR PEDIDO</button>
        <a wire:click="verificarYProcesar" class="btn btn-success w-25 m-3">CERRAR VENTA</a>
    </div>

    <div class="modal fade" wire:ignore.self id="modalDirecciones" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Dirección de envío</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" wire:model="localDpisar" id="customSwitch1">
                            <label class="custom-control-label" for="customSwitch1">Envio Local D'Pisar</label>
                        </div>
                        <input type="hidden" id="modalRowId">
                        <div class="row">
                            <div class="col">
                                <label class="form-label">Identificación:</label>
                                <input type="text" class="form-control p-1" wire:model="direccionData.identificacion" autocomplete="off">
                            </div>
                            <div class="col">
                                <label class="form-label">Nombre completo:</label>
                                <input type="text" class="form-control p-1" wire:model="direccionData.nombre" autocomplete="off">
                            </div>
                            <div class="col">
                                <label class="form-label">Teléfono:</label>
                                <input type="text" class="form-control p-1" wire:model="direccionData.telefono" autocomplete="off">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <label class="form-label">Dirección:</label>
                                <input type="text" class="form-control p-1" wire:model="direccionData.direccion" autocomplete="off">
                            </div>
                            <div class="col">
                                <label class="form-label">Referencia:</label>
                                <input type="text" class="form-control p-1" wire:model="direccionData.referencia" autocomplete="off">
                            </div>
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn bg-ibizza" wire:click="guardarDatos">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" wire:ignore.self id="modalPremios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Premios</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table ec-table" style="font-size: 14px">
                        <thead>
                            <tr>
                                <td>SKU</td>
                                <td>Descripción</td>
                                <td>Marca</td>
                                <td>Color</td>
                                <td>Talla</td>
                                <td>Stock</td>
                                <td>Acción</td>
                            </tr>

                        </thead>
                        <tbody>
                       
                            @if (count($productosPremios) > 0)
                                @foreach ($productosPremios as $item)
                                <tr>
                                    <td>{{$item->sku}}</td>
                                    <td>{{$item->descripcion}}</td>
                                    <td>{{$item->marca->nombre}}</td>
                                    <td>{{$item->color}}</td>
                                    <td>{{$item->talla}}</td>
                                    <td>{{$item->stock}}</td>
                                    <td><button wire:click="eliminarProducto({{ $item->id }})" class="btn btn-danger btn-sm">Eliminar</button></td>
                                </tr>

                                @endforeach
                                
                            @endif

                        </tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn bg-ibizza" id="agregarPremios" wire:click="agrgarPromocion">Guardar</button>
                </div>

            </div>
        </div>
    </div>

    @push('js')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>

            document.addEventListener('livewire:load', function () {
                    Livewire.on('showModalJs', () => {
                        var modal = new bootstrap.Modal(document.getElementById('modalDirecciones'));
                        modal.show();
                    });
                    Livewire.on('closeModal', () => {
                        $('#modalDirecciones').modal('hide');
                    });

                });

            
            
            $(document).ready(function() {
                /*$('#modalDirecciones').on('show.bs.modal', function(event) {
                    var button = event.relatedTarget;                    
                    var rowId = $(button).data('rowid');
                    console.log(button);
                    $('#modalRowId').val(rowId);
                    console.log(rowId);
                }); */


                $('#guardarButton').click(function() {
                    $('#modalDirecciones').on('show.bs.modal', function(event) {
                        var button = event.relatedTarget;
                        var rowId = $(button).data('rowid');
                        $('#modalRowId').val(rowId);
                    });
                    Livewire.emit('guardarDatos', {
                        rowId: $('#modalRowId').val(),
                        identificacion: $('#identificacion').val(),
                        nombre: $('#nombre').val(),
                        telefono: $('#telefono').val(),
                        direccion: $('#direccion').val(),
                        referencia: $('#referencia').val(),
                    });
                    $("#formulario_direcciones_envio").trigger("reset");
                    $('#modalDirecciones').modal('hide');
                });

                $('#modalPremios').on('show.bs.modal', function(event){

                });

                $('#agregarPremios').click(function() {

                    $('#modalPremios').modal('hide');
                });


            });

            document.addEventListener('DOMContentLoaded', function () {
                window.addEventListener('mostrar-alerta', function () {
                    Swal.fire({
                        title: '¿Qué deseas hacer?',
                        text: "Existen premios disponibles.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Agregar Premios',
                        cancelButtonText: 'Cerrar Venta'
                    }).then((result) => {
                    console.log(result, result.dismiss,  Swal.DismissReason.cancel);
                        if (result.isConfirmed) {
                            $('#modalPremios').modal('show');
                            Livewire.emit('aceptarAccion');

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            console.log("Deberia llamar a la funcion");
                            Livewire.emit('cerrarVenta');
                        }
                    });
                });
            });

            document.addEventListener('livewire:load', function () {
                window.livewire.on('mostrar-modal-premios', () => {
                    $('#modalPremios').modal('show');
                });
            });
        </script>
    @endpush
    @if (!empty($alert))
        @if (Auth::user()->role == 'Empresaria')
            <script>
                Swal.fire({
                    title: 'Pedido Guardado!',
                    text: 'Recuerda que tu pedido solo se guardará por 3 dias separando el stock del producto',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#009788',
                    cancelButtonColor: '#333333',
                    confirmButtonText: 'Ir a Pedidos Guardados',
                    cancelButtonText: 'Continuar en Pedidos',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('web.pedidos-guardados') }}";
                    }
                })
            </script>
        @else
            <script>
                Swal.fire({
                    title: 'Pedido Guardado!',
                    text: 'Recuerda que tu pedido solo se guardará por 3 dias separando el stock del producto',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#009788',
                    cancelButtonColor: '#333333',
                    confirmButtonText: 'Ir a Pedidos Guardados',
                    cancelButtonText: 'Continuar en Pedidos',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('venta.pedidos-guardados') }}";
                    }else{
                        window.location.href = "{{ route('venta.pedido' ) }}";
                    }
                })
            </script>
        @endif
    @endif
</div>
