<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 mb-6 pro-gl-content">
    <div class="ec-product-inner">
        <div class="ec-pro-image-outer">
            <div class="ec-pro-image">
                <a href="{{route('web.detalle-producto', $estilo)}}" class="image">
                    <img load='lazy' class="main-image"
                        src="{{url("/storage/images/productos/$imagen") }}" alt="{{$estilo}}" width="300rem" height="200rem" style="object-fit: cover" />
                    <img load='lazy' class="hover-image"
                        src="{{url("/storage/images/productos/$imagen") }}" alt="{{$estilo}}" width="300rem" height="200rem" style="object-fit: cover" />
                </a>
                @empty(!$descuento)
                    <span class="percentage">{{$descuento}}%</span>
                @endempty                
                <a href="#" class="quickview" data-link-action="quickview" title="Quick view" data-bs-toggle="modal"
                    data-bs-target="#ec_quickview_modal"><img loading='lazy' src="{{url('assets/images/icons/quickview.svg')}}"
                        class="svg_img pro_svg" alt="" /></a>
                <div class="ec-pro-actions">
                    <button title="Add To Cart" class=" add-to-cart"><img loading='lazy'
                            src="{{url('assets/images/icons/cart.svg')}}" class="svg_img pro_svg" alt="" /> Add To
                        Cart</button>
                    <a class="ec-btn-group wishlist" title="Wishlist"><img loading='lazy'
                            src="{{url('assets/images/icons/wishlist.svg')}}" class="svg_img pro_svg" alt="" /></a>
                </div>
            </div>
        </div>
        <div class="ec-pro-content">
            <h5 class="ec-pro-title"><a href="{{route('web.detalle-producto', $estilo)}}">{{ $nombre_producto }}</a></h5>
            <input type="hidden" class="estilo-producto" value="{{$estilo}}">
            <div class="ec-pro-rating">
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star"></i>
            </div>
            <div class="ec-pro-list-desc">{{$descripcion}}</div>
            <span class="ec-price">
                @empty(!$descuento)                        
                    <span class="old-price">${{ $precio_empresaria }}</span>
                    <span class="new-price">${{ number_format(($precio_empresaria-($precio_empresaria * ($descuento /100))), 2) }}</span>
                @else
                    <span class="new-price">${{ number_format($precio_empresaria, 2) }}</span>
                @endempty
            </span>
            <div class="ec-pro-option row d-flex justify-content-start">
                <div class="ec-pro-color row mx-auto mb-1">
                    <span class="ec-pro-opt-label">Color</span>
                    <select class="p-1">
                        @foreach ($productos_all as $val)            
                                <option> {{ $val->color }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="ec-pro-size">
                    <span class="ec-pro-opt-label">Talla</span>
                    <ul class="ec-opt-size d-flex justify-content-start flex-wrap">
                        @foreach ($productos_tallas as $val)
                            @if ($color == $val->color && $estilo == $val->estilo)
                                <li><a href="#" class="ec-opt-sz">{{ $val->talla }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
