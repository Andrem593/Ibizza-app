<div>
    <div class="ec-sb-pro-sl-item row d-flex flex-direction-center">

        <a href="{{ route('web.detalle-producto', $estilo) }}" class="sidekka_pro_img col-6 me-0 pe-0">
            <img src="{{ url('storage/images/productos/' . $imagen) }}" style="" />
        </a>
        <div class="ec-pro-content col-6">
            <h5 class="ec-pro-title"><a href="{{ route('web.detalle-producto', $estilo) }}">{{ $nombre_producto }}</a>
            </h5>
            <div class="ec-pro-rating">
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star fill"></i>
                <i class="ecicon eci-star"></i>
            </div>
            <span class="ec-price">
                @empty(!$descuento)
                    <span class="old-price">${{ $precio_empresaria }}</span>
                    <span
                        class="new-price">${{ number_format($precio_empresaria - $precio_empresaria * ($descuento / 100), 2) }}</span>
                @else
                    <span class="new-price">${{ number_format($precio_empresaria, 2) }}</span>
                @endempty
            </span>
        </div>
    </div>
</div>
