<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6  ec-product-content" data-animation="fadeIn">
    <div class="ec-product-inner">
        <div class="ec-pro-image-outer">
            <div class="ec-pro-image">
                <a href="{{route('web.detalle-producto', $estilo)}}" class="image">
                    <img loading='lazy' class="main-image" src="storage/images/productos/{{ $imagen }}" />
                    <img loading='lazy' class="hover-image" src="storage/images/productos/{{ $imagen }}" />
                </a>
                {{-- <a href="#" class="quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal"
                    data-bs-target="#ec_quickview_modal"><img loading='lazy' src="assets/images/icons/quickview.svg"
                        class="svg_img pro_svg" alt="" /></a> --}}
                <a href="#" class="quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal"
                data-bs-target="#ec_quickview_modal" wire:click="$emitTo('modal-quick-view', 'quickView', {{ "'". $estilo . "'"}} )" ><img loading='lazy' src="assets/images/icons/quickview.svg"
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
            <h5 class="ec-pro-title"><a href="{{route('web.detalle-producto', $estilo)}}">{{ $clasificacion }}</a>
            </h5>
            <div class="d-flex justify-content-between">
                <div class="ec-pro-rating my-auto">
                    <i class="ecicon eci-star fill"></i>
                    <i class="ecicon eci-star fill"></i>
                    <i class="ecicon eci-star fill"></i>
                    <i class="ecicon eci-star fill"></i>
                    <i class="ecicon eci-star"></i>
                </div>
                <span class="ec-price my-auto">
                    <span class="old-price">${{ $valor_venta }}</span>
                    <span class="new-price">${{ number_format($valor_venta, 2) }}</span>
                </span>
            </div>
            <div class="ec-pro-option row d-flex justify-content-start">
                <div class="ec-pro-color row mx-auto mb-1">
                    <span class="ec-pro-opt-label">Color</span>
                    <select class="p-1">
                        @foreach ($productos_all as $val)
                            @if ($estilo == $val->estilo)
                                <option> {{ $val->color }} </option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="ec-pro-size">
                    <span class="ec-pro-opt-label">Talla</span>
                    <ul class="ec-opt-size d-flex justify-content-start flex-wrap">
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
    {{-- <div class="ec-product-cbb">
        <div class="ec-product-image">
            <a href="{{route('web.detalle-producto', $estilo)}}" class="image">
                <img class="pic-1" src="storage/images/productos/{{ $imagen }}" alt="" />
                <img class="pic-2" src="storage/images/productos/{{ $imagen }}" alt="" />
            </a>
            <ul class="ec-product-links">
                <li><a href="#" data-tip="Add to Wishlist"><img src="assets/images/icons/wishlist.svg"
                            class="svg_img header_svg pro_svg" alt="wishlist" /></a></li>
                <li><a href="#" data-tip="Quick View"><img src="assets/images/icons/quickview.svg"
                            class="svg_img pro_svg pro_svg" alt="quick view" /></a></li>
                <li><a href="#" data-tip="Add To Cart"><img src="assets/images/icons/cart.svg"
                            class="svg_img pro_svg pro_svg" alt="add to cart" /></a></li>
            </ul>
        </div>
        <div class="ec-product-body">
            <ul class="ec-rating">
                <li class="ecicon eci-star fill"></li>
                <li class="ecicon eci-star fill"></li>
                <li class="ecicon eci-star fill"></li>
                <li class="ecicon eci-star fill"></li>
                <li class="ecicon eci-star"></li>
            </ul>
            <h3 class="ec-title"><a href="{{route('web.detalle-producto', $estilo)}}">{{ $clasificacion }}</a></h3>
            <div class="ec-price"><span>${{ $valor_venta }}</span> ${{ number_format($valor_venta, 2) }}</div>             
            <div class="ec-color">
                <select class="p-1">
                    @foreach ($productos_all as $val)
                        @if ($estilo == $val->estilo)
                            <option> {{ $val->color }} </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="ec-size">
                @foreach ($productos_tallas as $val)
                    @if ($color == $val->color)
                        <a href="#">{{ $val->talla }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div> --}}

    

</div>
