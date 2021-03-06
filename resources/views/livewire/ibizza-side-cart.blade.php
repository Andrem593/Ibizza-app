<div id="ec-side-cart" class="ec-side-cart">
    <div class="ec-cart-inner">
        <div class="ec-cart-top">
            <div class="ec-cart-title">
                <span class="cart_title">Ibizza Cart</span>
                <button class="ec-close">×</button>
            </div>
            <ul class="eccart-pro-items">
                @if (Cart::count() > 0)
                    @foreach (Cart::content() as $item)
                        <li>
                            <a href="" class="sidekka_pro_img"><img src="/storage/images/productos/{{$item->options->image}}"
                                    alt="product"></a>
                            <div class="ec-pro-content">
                                <a href="#" class="cart_pro_title">{{ $item->name }}</a>
                                <span class="cart-price"><span>{{ $item->price}}</span> x <span class="card-qty">{{$item->qty}}</span></span>
                                <span class="idItemCart d-none">{{ $item->rowId}}</span>
                                <a href="javascript:void(0)" class="remove">×</a>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>
                        <p class="emp-cart-msg"> Tu carrito está vacio</p>
                    </li>
                @endif
            </ul>
        </div>
        <div class="ec-cart-bottom">
            <div class="cart-sub-total">
                <table class="table cart-table">
                    <tbody>
                        <tr>
                            <td class="text-left">Sub-Total :</td>
                            <td id="subTotal" class="text-right">${{Cart::subtotal()}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">IVA (12%) :</td>
                            <td id="tax" class="text-right">${{Cart::tax()}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Total :</td>
                            <td id="total" class="text-right primary-color">${{Cart::total()}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cart_btn">
                <a href="{{ route('web.tomar-pedido')}}" class="btn btn-primary">Pedidos</a>
                <a href="{{ route('web.checkout')}}" class="btn btn-secondary">Liquidar</a>
            </div>
        </div>
    </div>
</div>
