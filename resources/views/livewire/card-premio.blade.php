<div class="col-sm-12 mb-6">
    <div class="ec-product-inner">
        <div class="ec-pro-image-outer">
            <div class="ec-pro-image">
                <a href="#" class="image">
                    <img class="main-image" width="80rem" src="{{ empty($imagen) ? 'https://catalogoibizza.com/img/imagen-no-disponible.jpg' : '../storage/images/productos/' . $imagen }}" alt="Product" />
                    <img class="hover-image" width="80rem" src="{{ empty($imagen) ? 'https://catalogoibizza.com/img/imagen-no-disponible.jpg' : '../storage/images/productos/' . $imagen }}" alt="Product" />
                </a>
            </div>
        </div>
        <div class="ec-pro-content datos-premios">
            <h5 class="ec-pro-title"><a href="#" style="font-size: 12px">{{ $nombre }}</a>
            </h5>
            <input type="hidden" class="estiloPro" value="{{$estilo}}">
            <span class="ec-price">
                <span class="new-price">$Gratis</span>
            </span>
            <div class="ec-pro-option">
                <div class="ec-pro-color">
                    <span class="ec-pro-opt-label">Color</span>
                    <select class="p-1">
                        @foreach ($productos_all as $val)
                            @if ($estilo == $val->estilo)
                                <option value="{{ $val->color }}"> {{ $val->color }} </option>
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
