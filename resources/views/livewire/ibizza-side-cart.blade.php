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
                            <a href="product-left-sidebar.html" class="sidekka_pro_img"><img src="/storage/images/productos/{{$item->options->image}}"
                                    alt="product"></a>
                            <div class="ec-pro-content">
                                <a href="product-left-sidebar.html" class="cart_pro_title">{{ $item->name }}</a>
                                <span class="cart-price"><span>{{ $item->price}}</span> x {{$item->qty}}</span>
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
                            <td class="text-right">${{Cart::subtotal()}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">IVA (12%) :</td>
                            <td class="text-right">${{Cart::tax()}}</td>
                        </tr>
                        <tr>
                            <td class="text-left">Total :</td>
                            <td class="text-right primary-color">${{Cart::total()}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="cart_btn">
                <a href="cart.html" class="btn btn-primary">Ver Carrito</a>
                <a href="checkout.html" class="btn btn-secondary">Checkout</a>
            </div>
        </div>
    </div>
</div>
