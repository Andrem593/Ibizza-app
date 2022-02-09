<div>
    @empty(!$message)
    <div class="alert alert-danger" role="alert">
        {{$message}}
    </div>
    @endempty
    <div class="row">
        <div class="col-md-3">
            <div class="card rounded">
                <img src="{{$imagen}}" alt="" height="100%" class="" style="object-fit: cover">
            </div>
        </div>
        <div class="col">
            @if (Auth::user()->role != 'Empresaria')                    
            <div class="row ">
                <div class="col mb-2">
                    <label class="form-label">Nombre del Cliente:</label>
                    <input type="text" class="form-control p-1" wire:model='cliente' placeholder="Ingrese el nombre del cliente para su pedido">
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col mb-3">
                    <label class="form-label">Codigo Artículo:</label>
                    <div class="input-group">
                        <input type="text" class="form-control p-1" placeholder="ingrese el codigo"
                            wire:model.defer="estilo" wire:keydown.enter='buscarEstilo'>
                        <button class="btn btn-primary rounded" type="button" id="search" wire:click='buscarEstilo'><i
                                class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="col mb-3">
                    <label class="form-label">Seleccionar Color:</label>
                    <select class="form-select p-2" id="optColor" wire:model='color' wire:change='buscarColor'>
                        @empty(!$colores)
                        @foreach ($colores as $color)
                        <option value="{{$color->color}}">{{$color->color}}</option>
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
                    <input type="number" class="form-control p-1" wire:model='cantidad' placeholder="unidades deseadas">
                </div>
                <div class="col mb-3">
                    <label class="form-label">Seleccionar Talla:</label>
                    <select class="form-select p-2" wire:model="talla" wire:change='stockProduct({{$talla}})'>
                        @empty(!$tallas)
                        @foreach ($tallas as $talla)
                        <option value="{{$talla->talla}}">{{$talla->talla}}</option>
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
                            <span>{{$tallas[0]->nombre_mostrar}}</span>
                            <br>
                            <span>Marca: {{$tallas[0]->nombre_marca}} | STOCK: <b>{{$stock}}</b></span>
                        </div>
                        <div class="col-6">
                            <span class="badge badge-pill badge-secondary" style="font-size: 0.9rem;">PVP: ${{$tallas[0]->valor_venta}}</span>
                            @empty(!$tallas[0]->descuento)
                            <span class="badge badge-pill bg-ibizza" style="font-size: 0.9rem;">Descuento: {{ $tallas[0]->descuento
                                }}%</span>
                            <span class="badge badge-pill badge-dark" style="font-size: 0.9rem;">P.Final: ${{
                                number_format(($tallas[0]->precio_empresaria-($tallas[0]->precio_empresaria *
                                ($tallas[0]->descuento /100))), 2) }}</span>
                            @else
                            <span class="badge badge-pill badge-dark" style="font-size: 0.9rem;">P.Final: ${{
                                number_format($tallas[0]->precio_empresaria, 2) }}</span>
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
                        <th scope="col">Foto</th>
                        <th scope="col">Productos</th>
                        <th scope="col">Color</th>
                        <th scope="col">Talla</th>
                        <th scope="col">Precio</th>
                        <th scope="col" width="15px">Cantidad</th>
                        <th scope="col" width="15px">Total</th>
                        <th scope="col" width="10px">Opc</th>
                    </tr>
                </thead>
                <tbody>
                    @if (Cart::count() > 0)
                    @foreach (Cart::content() as $item)
                    <tr>
                        <td><img src="{{'../storage/images/productos/'.$item->options->image}}" width="50px" height="50px"
                                style="object-fit: cover"></td>
                        <td>{{$item->name }}</td>
                        <td>{{$item->options->color}}</td>
                        <td>{{$item->options->talla}}</td>
                        <td>${{$item->price}}</td>
                        <td>{{$item->qty}}</td>
                        <td>${{ number_format($item->qty * $item->price,2) }}</td>
                        <td>
                            <a wire:click="eliminarItem('{{$item->rowId}}')"><i class="{{Auth::user()->role != 'Empresaria' ? 'fas fa-trash' : 'ecicon eci-trash-o '}}"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7" class="emp-cart-msg text-center"> SIN PRODUCTOS PEDIDOS</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="border-none" colspan="6">
                            <span></span>
                        </td>
                        <td class="" colspan="1">
                            <span><strong>Sub Total</strong></span>
                        </td>
                        <td class="">
                            <span class="fw-bold">${{ Cart::subtotal() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-none" colspan="6">
                            <span></span>
                        </td>
                        <td class="" colspan="1">
                            <span><strong>IVA (12%)</strong></span>
                        </td>
                        <td class="">
                            <span class="fw-bold">${{ Cart::tax() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-none" colspan="6">
                        <td class="" colspan="1">
                            <span><strong>Total</strong></span>
                        </td>
                        <td class="">
                            <span class="fw-bold">${{ Cart::total() }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-none" colspan="6"><span class="note-text-color">Informacion extra sobre ibizza
                                o datos de pago...</span></td>
                        <td class="" colspan="1">
                            <span><strong>Comisión</strong></span>
                        </td>
                        <td class="">
                            <span class="fw-bold">${{ number_format(Cart::total() * 0.30,2) }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row mt-2 text-end">
        <button class="btn btn-secondary w-25 m-3" wire:click='GuardarPedidos'>GUARDAR PEDIDO</button>
        <a href="{{route('web.checkout')}}" class="btn btn-primary w-25 m-3">LIQUIDAR PEDIDO</a>
    </div>
    @push('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
    @if (!empty($alert))
    <script>
       Swal.fire({
            title:'Pedido Guardado!',
            text:'Recuerda que tu pedido solo se guardará por 3 dias separando el stock del producto',
            icon:'success',
            showCancelButton: true,
            confirmButtonColor: '#009788',
            cancelButtonColor: '#333333',
            confirmButtonText: 'Ir a Pedidos Guardados',
            cancelButtonText: 'Continuar en Pedidos',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{route('web.pedidos-guardados')}}";
            }
        })
    </script>
    @endif
</div>