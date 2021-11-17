<div class="ec-checkout-pro">
    <h3 class="ec-sidebar-title">Premios por pedido</h3>
    <div class="col-sm-12 mb-6">
        <div class="ec-product-inner">
            <div class="ec-pro-image-outer">
                <div class="ec-pro-image">
                    <a href="{{ route('web.detalle-producto', $estilo) }}"
                        class="image">
                        <img class="main-image"
                            src="storage/images/productos/{{ $imagen }}"
                            alt="Product" />
                        <img class="hover-image"
                            src="storage/images/productos/{{ $imagen }}"
                            alt="Product" />
                    </a>
                </div>
            </div>
            <div class="ec-pro-content">
                <h5 class="ec-pro-title"><a
                        href="{{ route('web.detalle-producto', $estilo) }}">{{ $clasificacion }}</a>
                </h5>
                <span class="ec-price">
                    <span
                        class="old-price">${{ $pvp }}</span>
                    <span class="new-price">$Gratis</span>
                </span>
                <div class="ec-pro-option">
                    <div class="ec-pro-color">
                        <span class="ec-pro-opt-label">Color</span>
                        <select class="p-1">
                            @foreach ($productos_all as $val)
                                @if ($clasificacion == $val->clasificacion)
                                    <option> {{ $val->color }} </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="ec-pro-size">
                        <span class="ec-pro-opt-label">Size</span>
                        <ul class="ec-opt-size">
                            @foreach ($productos_tallas as $val)
                                @if ($color == $val->color)
                                    <li><a href="#" class="ec-opt-sz">{{ $val->talla }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>