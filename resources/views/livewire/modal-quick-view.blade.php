<div wire:ignore.self class="modal fade" id="ec_quickview_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <button type="button" class="btn-close qty_close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div id="qv_modal" class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <!-- Swiper -->
                        <div class="qty-product-cover">
                            @isset($productos_color)
                                @foreach ($productos_color as $producto)
                                    <div class="qty-slide" wire:loading.remove wire:target="quickView">
                                        <img loading='lazy' class="img-responsive"
                                            src="{{ '../storage/images/productos/' . $producto->imagen_path }}"
                                            alt="{{ $producto->estilo }}">
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                        <div class="qty-nav-thumb">
                            @isset($productos_color)
                                @foreach ($productos_color as $producto)
                                    <div class="qty-slide" wire:loading.remove wire:target="quickView">
                                        <img loading='lazy' class="img-responsive"
                                            src="{{ '../storage/images/productos/' . $producto->imagen_path }}"
                                            alt="{{ $producto->estilo }}">
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="quickview-pro-content">
                            <h5 class="ec-quick-title clasificacion">
                                {{ isset($productos_color) ? $productos_color[0]->clasificacion : '' }}</h5>
                            <input type="hidden" wire:model="productos_color">
                            <div class="ec-quickview-rating">
                                <i class="ecicon eci-star fill"></i>
                                <i class="ecicon eci-star fill"></i>
                                <i class="ecicon eci-star fill"></i>
                                <i class="ecicon eci-star fill"></i>
                                <i class="ecicon eci-star"></i>
                            </div>

                            <div class="ec-quickview-desc">
                                {{ isset($productos_color) ? $productos_color[0]->descripcion : '' }}</div>
                            <div class="ec-quickview-price">
                                <span
                                    class="new-price">${{ isset($productos_color) ? $productos_color[0]->valor_venta : '' }}</span>
                                {{-- <span class="old-price">$100.00</span>
                                <span class="new-price">$80.00</span> --}}
                            </div>

                            <div class="ec-pro-variation">
                                <div class="ec-pro-variation-inner ec-pro-variation-color">
                                    <input type="hidden" id="estilo_producto" value="{{isset($productos_color) ? $productos_color[0]->estilo : ''}}">
                                    <span>Color</span>
                                    <div class="ec-pro-color">
                                        <select class="form-select" id="color_producto">
                                            @isset($productos_color)
                                                @foreach ($productos_color as $producto)
                                                    <option value="{{ $producto->color }}">{{ $producto->color }}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                </div>
                                <div class="ec-pro-variation-inner ec-pro-variation-size ec-pro-size">
                                    <span>Talla</span>
                                    <div class="ec-pro-variation-content">
                                        <ul class="ec-opt-size">
                                            <li class="active talla">
                                                <span>{{ isset($productos_color) ? $productos_color[0]->talla : '' }}</span>
                                            </li>
                                            @isset($productos_color)
                                                @foreach ($tallas as $talla)
                                                    @if ($talla->talla != $productos_color[0]->talla)
                                                        <li class="talla"><span>{{ $talla->talla }}</span></li>
                                                    @endif
                                                @endforeach
                                            @endisset
                                        </ul>
                                    </div>

                                </div>
                            </div>
                            <div class="ec-quickview-qty">
                                <div class="qty-plus-minus">
                                    <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                                </div>
                                <div class="ec-quickview-cart ">
                                    @isset($productos_color)
                                        @if ($productos_color[0]->stock == 0)
                                            <button id="addToCart" class="btn btn-primary add-to-cart-product" disabled>Add
                                                To Cart</button>
                                        @else
                                            <button id="addToCart" class="btn btn-primary add-to-cart-product">Add To
                                                Cart</button>
                                        @endif
                                    @endisset
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="qv_spinner" class="d-flex justify-content-center d-none">
                    <div class="spinner-border-qv" role="status">
                        <span class="sr-only">cargando...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            $('#color_producto').change(function(event) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });
                let data = {
                    'color': $(this).val(),
                    'estilo': $('#estilo_producto').val(),
                }
                $.post({
                    url: '{{ route('web.tallas-color') }}',
                    data: data,
                    success: function(response) {
                        let data = JSON.parse(response)
                        $('.ec-pro-variation-content ul').html(' ')
                        $.each(data, function(i, v) {
                            if (i == 0) {
                                $('.ec-pro-variation-content ul').append(
                                    '<li class="active talla"><span>' + v['talla'] +
                                    '</span></li>')
                            } else {
                                $('.ec-pro-variation-content ul').append(
                                    '<li class="talla"><span>' + v['talla'] + '</span></li>')
                            }
                        })
                    }
                })
            })
            $(document).on('click', '.talla', function() {
                $(this).addClass('active').siblings().removeClass('active');
                let data = {
                    'talla': $(this).text(),
                    'estilo': $('#estilo_producto').val(),
                    'color': $('#color_producto').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });
                $.post({
                    url: '{{ route('web.stock-talla') }}',
                    data: data,
                    success: function(response) {
                        let data = JSON.parse(response)
                        // $('#stock').text(data.stock);
                        // if (parseInt(data.stock) != 0) {
                        //     $('#stock2').html('¡Date Prisa! hay ' + data.stock + ' en stock')
                        //     $('#addToCart').attr('disabled', false);
                        // } else {
                        //     $('#stock2').html('¡Lo sentimos! No hay stock de este producto')
                        //     $('#addToCart').attr('disabled', true);
                        // }
                    }
                })
            });
            $('.ec-opt-size').each(function() {

                $(document).on('click', 'li', function() {
                    // alert("2");
                    onSizeChange($(this));
                });

                function onSizeChange(thisObj) {
                    // alert("3");
                    var $this = thisObj;
                    var $old_data = $this.find('a').attr('data-old');
                    var $new_data = $this.find('a').attr('data-new');
                    var $old_price = $this.closest('.ec-pro-content').find('.old-price');
                    var $new_price = $this.closest('.ec-pro-content').find('.new-price');

                    $old_price.text($old_data);
                    $new_price.text($new_data);

                    $this.addClass('active').siblings().removeClass('active');
                }
            });
        </script>
    @endpush
</div>
