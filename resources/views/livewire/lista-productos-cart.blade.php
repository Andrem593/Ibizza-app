{{-- <tr>
    <td data-label="Product" class="ec-cart-pro-name"><a href="product-left-sidebar.html"><img
                class="ec-cart-pro-img mr-4" src="/storage/images/productos/{{ $imagen }}"
                alt="" />{{ $nombre }}</a></td>
    <td data-label="Price" class="ec-cart-pro-price"><span class="amount">${{ $precio }}</span></td>
    <td data-label="Quantity" class="ec-cart-pro-qty" style="text-align: center;">
        <div class="cart-qty-plus-minus">
            <input class="cart-plus-minus" type="number" min="1" name="cartqtybutton" wire:model="cantidad" />
            <div class="ec_cart_qtybtn">
                <div class="inc ec_qtybtn" wire:click="incremento">+</div>
                <div class="dec ec_qtybtn" wire:click="decremento">-</div>
            </div>
        </div>
    </td>
    <td data-label="Total" class="ec-cart-pro-subtotal">${{ $precio * $cantidad }}
    </td>
    <td data-label="Remove" class="ec-cart-pro-remove">
        <a wire:click="eliminarItem"><i class="ecicon eci-trash-o"></i></a>
    </td>
</tr> --}}
<table>
    <thead>
        <tr>
            <th>Productos</th>
            <th>Precio</th>
            <th style="text-align: center;">Cantidad</th>
            <th>Total</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if (Cart::count() > 0)
            @foreach (Cart::content() as $item)
                <tr>
                    <td data-label="Product" class="ec-cart-pro-name"><a href="product-left-sidebar.html"><img
                                class="ec-cart-pro-img mr-4"
                                src="/storage/images/productos/{{ $item->options->image }}"
                                alt="" />{{ $item->name }}</a></td>
                    <td data-label="Price" class="ec-cart-pro-price"><span class="amount">${{ $item->price }}</span>
                    </td>
                    <td data-label="Quantity" class="ec-cart-pro-qty" style="text-align: center;">
                        <div class="cart-qty-plus-minus">
                            <input class="cart-plus-minus" type="number" min="1" name="cartqtybutton"
                                value="{{$item->qty}}" disabled/>
                            <div class="ec_cart_qtybtn">
                                <div class="inc ec_qtybtn" wire:click="incremento('{{ $item->rowId}}', '{{$item->qty}}')">+</div>
                                <div class="dec ec_qtybtn" wire:click="decremento('{{ $item->rowId}}','{{$item->qty}}')">-</div>
                            </div>
                        </div>
                    </td>
                    <td data-label="Total" class="ec-cart-pro-subtotal">${{ $item->qty * $item->price }}
                    </td>
                    <td data-label="Remove" class="ec-cart-pro-remove">
                        <a wire:click="eliminarItem('{{$item->rowId}}')"><i class="ecicon eci-trash-o"></i></a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="5" class="emp-cart-msg text-center"> Tu carrito
                    está vacio</td>
            </tr>
        @endif
    </tbody>
</table>
