<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
    <div class="ec-product-inner">
        <div class="ec-pro-image-outer">
            <div class="ec-pro-image">
                <a href="product-left-sidebar.html" class="image">
                    <img load='lazy' class="main-image"
                        src="storage/images/productos/{{ $imagen }}" alt="Product" />
                    <img load='lazy' class="hover-image"
                        src="storage/images/productos/{{ $imagen }}" alt="Product" />
                </a>                
                <a href="#" class="quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal"
                    data-bs-target="#ec_quickview_modal"><img loading='lazy' src="assets/images/icons/quickview.svg"
                        class="svg_img pro_svg" alt="" /></a>
                <div class="ec-pro-actions">
                    <button title="Add To Cart" class=" add-to-cart"><img loading='lazy'
                            src="assets/images/icons/cart.svg" class="svg_img pro_svg" alt="" /> Add To
                        Cart</button>
                    <a class="ec-btn-group wishlist" title="Wishlist"><img loading='lazy'
                            src="assets/images/icons/wishlist.svg" class="svg_img pro_svg" alt="" /></a>
                </div>
            </div>
        </div>
        <div class="ec-pro-content">
            <h5 class="ec-pro-title"><a href="{{route('web.detalle-producto', $estilo)}}">{{ $clasificacion }}</a></h5>
            <div class="ec-pro-rating">
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star"></i>
            </div>
            <div class="ec-pro-list-desc">{{$descripcion}}</div>
            <span class="ec-price">
                <span class="old-price">${{ $valor_venta }}</span>
                <span class="new-price">${{ number_format($valor_venta, 2) }}</span>
            </span>
            <div class="ec-pro-option">
                <div class="ec-pro-color">
                    <span class="ec-pro-opt-label">Color</span>
                    <select class="p-0">
                        @foreach ($productos_all as $val)
                            @if ($clasificacion == $val->clasificacion)
                                <option> {{ $val->color }} </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="ec-pro-size">
                    <span class="ec-pro-opt-label">Talla</span>
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
