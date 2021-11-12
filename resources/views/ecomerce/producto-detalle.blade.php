<x-plantilla>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Detalle de Producto</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{route('web')}}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Producto</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->
    <!-- Sart Single product -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-pro-rightside ec-common-rightside col-lg-9 col-md-12">

                    <!-- Single product content Start -->
                    <div class="single-pro-block">
                        <div class="single-pro-inner">
                            <div class="row">
                                <div class="single-pro-img">
                                    <div class="single-product-scroll">
                                        <div class="single-product-cover">
                                            @foreach ($productos_color as $producto )                                                
                                                <div class="single-slide zoom-image-hover">
                                                    <img class="img-responsive" src="{{'../storage/images/productos/'.$producto->imagen_path}}" alt="{{$producto->estilo}}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="single-nav-thumb">
                                            @foreach ($productos_color as $producto )                                                                                                
                                                <div class="single-slide">
                                                    <img class="img-responsive" src="{{'../storage/images/productos/'.$producto->imagen_path}}" alt="{{$producto->estilo}}">
                                                </div>
                                            @endforeach                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="single-pro-desc">
                                    <div class="single-pro-content">
                                        <h5 class="ec-single-title">{{$productos_color[0]->clasificacion}}</h5>
                                        <input type="hidden" id="estilo_producto" value="{{$productos_color[0]->estilo}}">
                                        <div class="ec-single-rating-wrap">
                                            <div class="ec-single-rating">
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star fill"></i>
                                                <i class="ecicon eci-star-o"></i>
                                            </div>
                                        </div>
                                        <div class="ec-single-desc">{{$productos_color[0]->descripcion}}</div>

                                        <div class="ec-single-sales">
                                            <div class="ec-single-sales-inner">
                                                <div class="ec-single-sales-title">sales accelerators</div>                                                
                                                <div class="ec-single-sales-progress">
                                                    @if ($productos_color[0]->stock > 0)                                                        
                                                        <span id="stock2" class="ec-single-progress-desc">¡Date Prisa! hay {{$productos_color[0]->stock}} en stock</span>
                                                    @else
                                                    <span id="stock2" class="ec-single-progress-desc">¡Lo sentimos! No hay stock de este producto</span>
                                                    @endif
                                                    <span class="ec-single-progressbar"></span>
                                                </div>
                                                <div class="ec-single-sales-countdown">
                                                    <div class="ec-single-countdown"><span
                                                            id="ec-single-countdown"></span></div>
                                                    <div class="ec-single-count-desc">Finaliza el Catalogo!</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ec-single-price-stoke">
                                            <div class="ec-single-price">
                                                <span class="ec-single-ps-title">Precio:</span>
                                                <span class="new-price">${{$productos_color[0]->valor_venta}}</span>
                                            </div>
                                            <div class="ec-single-stoke">
                                                <span class="ec-single-ps-title">En stock</span>
                                                <span id="stock" class="ec-single-sku">{{$productos_color[0]->stock}}</span>
                                            </div>
                                        </div>

                                        <div class="ec-pro-variation">
                                            <div class="ec-pro-variation-inner ec-pro-variation-color">
                                                <span>Color</span>
                                                <div class="ec-pro-variation-content">
                                                    <select class="form-select"  id="color_producto">
                                                        @foreach ($productos_color as $producto)
                                                            <option value="{{$producto->color}}">{{$producto->color}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="ec-pro-variation-inner ec-pro-variation-size">
                                                <span>Tallas</span>
                                                <div class="ec-pro-variation-content">
                                                    <ul>                                                        
                                                        <li class="active talla"><span>{{$productos_color[0]->talla}}</span></li>
                                                        @foreach ($tallas as $talla )
                                                            @if ($talla->talla != $productos_color[0]->talla)
                                                                <li class="talla"><span>{{$talla->talla}}</span></li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="ec-single-qty">
                                            <div class="qty-plus-minus">
                                                <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                                            </div>
                                            <div class="ec-single-cart ">
                                                @if ($productos_color[0]->stock == 0 )
                                                    <button id="addToCart" class="btn btn-primary" disabled>Add To Cart</button>
                                                @else
                                                    <button id="addToCart" class="btn btn-primary">Add To Cart</button>
                                                @endif
                                            </div>
                                            <div class="ec-single-wishlist">
                                                <a class="ec-btn-group wishlist" title="Wishlist"><img
                                                        src="{{url('assets/images/icons/wishlist.svg')}}" class="svg_img pro_svg"
                                                        alt="" /></a>
                                            </div>                                     
                                        </div>
                                        <div class="ec-single-social">
                                            <ul class="mb-0">
                                                <li class="list-inline-item facebook"><a href="#"><i
                                                            class="ecicon eci-facebook"></i></a></li>
                                                <li class="list-inline-item instagram"><a href="#"><i
                                                            class="ecicon eci-instagram"></i></a></li>
                                                <li class="list-inline-item whatsapp"><a href="#"><i
                                                            class="ecicon eci-whatsapp"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Single product content End -->
                    <!-- Single product tab start -->
                    <div class="ec-single-pro-tab">
                        <div class="ec-single-pro-tab-wrapper">
                            <div class="ec-single-pro-tab-nav">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#ec-spt-nav-details" role="tablist">Detalles</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content  ec-single-pro-tab-content">
                                <div id="ec-spt-nav-details" class="tab-pane fade show active">
                                    <div class="ec-single-pro-tab-desc">
                                        <p>{{$productos_color[0]->descripcion}}</p>
                                        <ul>
                                            <li id="sku">SKU: {{$productos_color[0]->sku}}</li>
                                            <li>Detalles de fabricación del producto</li>
                                            <li>etc</li>
                                            <li>etc</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- product details description area end -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="ec-pro-leftside ec-common-leftside col-lg-3 col-md-12">
                    <div class="ec-sidebar-slider">
                        <div class="ec-sb-slider-title">Best Sellers</div>
                        <div class="ec-sb-pro-sl">
                            <div>
                                <div class="ec-sb-pro-sl-item">
                                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                            src="{{url('assets/images/product-image/1_1.jpg')}}" alt="product" /></a>
                                    <div class="ec-pro-content">
                                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Beautiful Teddy
                                                Bear</a></h5>
                                        <div class="ec-pro-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>
                                        <span class="ec-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="ec-sb-pro-sl-item">
                                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                            src="{{url('assets/images/product-image/2_1.jpg')}}" alt="product" /></a>
                                    <div class="ec-pro-content">
                                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Gym Backpack</a>
                                        </h5>
                                        <div class="ec-pro-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>
                                        <span class="ec-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="ec-sb-pro-sl-item">
                                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                            src="{{url('assets/images/product-image/3_1.jpg')}}" alt="product" /></a>
                                    <div class="ec-pro-content">
                                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Beautiful Purse for
                                                Women</a></h5>
                                        <div class="ec-pro-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>
                                        <span class="ec-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="ec-sb-pro-sl-item">
                                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                            src="{{url('assets/images/product-image/4_1.jpg')}}" alt="product" /></a>
                                    <div class="ec-pro-content">
                                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Wool Felt Long Brim
                                                Hat</a></h5>
                                        <div class="ec-pro-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>
                                        <span class="ec-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="ec-sb-pro-sl-item">
                                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                            src="{{url('assets/images/product-image/5_1.jpg')}}" alt="product" /></a>
                                    <div class="ec-pro-content">
                                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Black Leather
                                                Belt</a></h5>
                                        <div class="ec-pro-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>
                                        <span class="ec-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="ec-sb-pro-sl-item">
                                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                            src="{{url('assets/images/product-image/6_2.jpg')}}" alt="product" /></a>
                                    <div class="ec-pro-content">
                                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Beautiful Tee for
                                                Women</a></h5>
                                        <div class="ec-pro-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>
                                        <span class="ec-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="ec-sb-pro-sl-item">
                                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                            src="{{url('assets/images/product-image/7_1.jpg')}}" alt="product" /></a>
                                    <div class="ec-pro-content">
                                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Cotton Shirt for
                                                Men</a></h5>
                                        <div class="ec-pro-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>
                                        <span class="ec-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="ec-sb-pro-sl-item">
                                    <a href="product-left-sidebar.html" class="sidekka_pro_img"><img
                                            src="{{url('assets/images/product-image/8_2.jpg')}}" alt="product" /></a>
                                    <div class="ec-pro-content">
                                        <h5 class="ec-pro-title"><a href="product-left-sidebar.html">I Watch for Men</a>
                                        </h5>
                                        <div class="ec-pro-rating">
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star fill"></i>
                                            <i class="ecicon eci-star"></i>
                                        </div>
                                        <span class="ec-price">
                                            <span class="old-price">$100.00</span>
                                            <span class="new-price">$80.00</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sidebar Area Start -->
            </div>
        </div>
    </section>
    <!-- End Single product -->
    @push('js')        
        <script>    
            /*----------------------------- Contador de tiempo restante de catalogo ------------------------------ */
            $("#ec-single-countdown").countdowntimer({
                startDate : "{{str_replace('-','/',$catalogo->fecha_publicacion).' 00:00:00'}}",
                dateAndTime : "{{str_replace('-','/',$catalogo->fecha_fin_catalogo).' 00:00:00'}}",
                labelsFormat : true,
                displayFormat : "DHMS"
            });
            $('#color_producto').change(function (event) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });
                let data = {
                    'color':  $(this).val(),
                    'estilo': $('#estilo_producto').val(),
                }
                $.post({
                    url: '{{route("web.tallas-color")}}',
                    data: data,
                    success: function(response) {
                       let data = JSON.parse(response)
                       $('.ec-pro-variation-content ul').html(' ')
                       $.each(data, function (i,v) {
                           if (i == 0) {
                                $('.ec-pro-variation-content ul').append('<li class="active talla"><span>'+v['talla']+'</span></li>')
                           }else{
                               $('.ec-pro-variation-content ul').append('<li class="talla"><span>'+v['talla']+'</span></li>')
                           }
                       })
                    }
                })
            })
            $(document).on('click', '.talla', function () {                
                $(this).addClass('active').siblings().removeClass('active');
                let data = {
                    'talla':  $(this).text(),
                    'estilo': $('#estilo_producto').val(),
                    'color': $('#color_producto').val(),
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                });
                $.post({
                    url: '{{route("web.stock-talla")}}',
                    data: data,
                    success: function(response) {
                       let data = JSON.parse(response)
                       $('#stock').text(data.stock);
                       if( parseInt(data.stock) != 0){
                            $('#stock2').html('¡Date Prisa! hay '+data.stock+' en stock')
                            $('#addToCart').attr('disabled',false);
                       }else{
                            $('#stock2').html('¡Lo sentimos! No hay stock de este producto')
                            $('#addToCart').attr('disabled',true);
                       }
                    }
                })
            });
        </script>
    @endpush
</x-plantilla>
