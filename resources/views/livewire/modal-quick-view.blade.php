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
                            <h5 class="ec-quick-title"><a href="product-left-sidebar.html">Handbag leather purse
                                    for women</a>
                            </h5>
                            <input type="hidden" wire:model="productos_color">
                            <div class="ec-quickview-rating">
                                <i class="ecicon eci-star fill"></i>
                                <i class="ecicon eci-star fill"></i>
                                <i class="ecicon eci-star fill"></i>
                                <i class="ecicon eci-star fill"></i>
                                <i class="ecicon eci-star"></i>
                            </div>

                            <div class="ec-quickview-desc">Lorem Ipsum is simply dummy text of the printing and
                                typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever
                                since the 1500s,</div>
                            <div class="ec-quickview-price">
                                <span class="old-price">$100.00</span>
                                <span class="new-price">$80.00</span>
                            </div>

                            <div class="ec-pro-variation">
                                <div class="ec-pro-variation-inner ec-pro-variation-color">
                                    <span>Color</span>
                                    <div class="ec-pro-color">
                                        <ul class="ec-opt-swatch">
                                            <li><span style="background-color:#ebbf60;"></span></li>
                                            <li><span style="background-color:#75e3ff;"></span></li>
                                            <li><span style="background-color:#11f7d8;"></span></li>
                                            <li><span style="background-color:#acff7c;"></span></li>
                                            <li><span style="background-color:#e996fa;"></span></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="ec-pro-variation-inner ec-pro-variation-size ec-pro-size">
                                    <span>Size</span>
                                    <div class="ec-pro-variation-content">
                                        <ul class="ec-opt-size">
                                            <li class="active"><a href="#" class="ec-opt-sz"
                                                    data-tooltip="Small">S</a></li>
                                            <li><a href="#" class="ec-opt-sz" data-tooltip="Medium">M</a>
                                            </li>
                                            <li><a href="#" class="ec-opt-sz" data-tooltip="Large">X</a>
                                            </li>
                                            <li><a href="#" class="ec-opt-sz" data-tooltip="Extra Large">XL</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="ec-quickview-qty">
                                <div class="qty-plus-minus">
                                    <input class="qty-input" type="text" name="ec_qtybtn" value="1" />
                                </div>
                                <div class="ec-quickview-cart ">
                                    <button class="btn btn-primary"><img loading='lazy'
                                            src="assets/images/icons/cart.svg" class="svg_img pro_svg" alt="" />
                                        Add To Cart</button>
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

</div>
