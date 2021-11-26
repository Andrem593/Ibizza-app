<x-plantilla>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Tienda</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('web') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Tienda</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->
    <!-- Ec Shop page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-shop-rightside col-lg-9 col-md-12 order-lg-last order-md-first margin-b-30">
                    <!-- Shop Top Start -->
                    <div class="ec-pro-list-top d-flex">
                        <div class="col-md-6 ec-grid-list">
                            <div class="ec-gl-btn">
                                <button class="btn btn-grid active"><img src="assets/images/icons/grid.svg"
                                        class="svg_img gl_svg" alt="" /></button>
                                <button class="btn btn-list"><img src="assets/images/icons/list.svg"
                                        class="svg_img gl_svg" alt="" /></button>
                            </div>
                        </div>
                        <div class="col-md-6 ec-sort-select">
                            <span class="sort-by">Ordenar por</span>
                            <div class="ec-select-inner">
                                <select name="ec-select" id="ec-select">
                                    <option selected disabled>Posición</option>
                                    <option value="1">Relevancia</option>
                                    <option value="2">Nombre, A a Z</option>
                                    <option value="3">Nombre, Z a A</option>
                                    <option value="4">Precio, +bajo al +alto</option>
                                    <option value="5">Price, +alto al +bajo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Shop Top End -->

                    <!-- Shop content Start -->
                    <div class="shop-pro-content">
                        <div class="shop-pro-inner">
                            <div class="row">
                                @foreach ($productos as $producto)
                                    @livewire('card-producto-tienda' , ['id_producto'=>$producto->id,'imagen' =>
                                    $producto->imagen_path,'clasificacion' => $producto->clasificacion ,'valor_venta'
                                    => $producto->valor_venta,'color' => $producto->color, 'estilo' =>
                                    $producto->estilo,'nombre_producto'=>$producto->nombre_mostrar,'precio_empresaria'=>$producto->precio_empresaria,'descuento'=>$producto->descuento])
                                @endforeach
                            </div>
                        </div>
                        <!-- Ec Pagination Start -->
                        <div class="ec-pro-pagination">
                            <span>Mostrando 1-12 of 21 Productos(s)</span>
                            <ul class="ec-pro-pagination-inner">
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a class="next" href="#">Next <i class="ecicon eci-angle-right"></i></a></li>
                            </ul>
                        </div>
                        <!-- Ec Pagination End -->
                    </div>
                    <!--Shop content End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="ec-shop-leftside col-lg-3 col-md-12 order-lg-first order-md-last">
                    <div id="shop_sidebar">
                        <div class="ec-sidebar-heading">
                            <h1>Filtra Los producto por:</h1>
                        </div>
                        <div class="ec-sidebar-wrap">
                            <!-- Sidebar Category Block -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Categorias</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" /> <a href="#">clothes</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" /> <a href="#">Bags</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" /> <a href="#">Shoes</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" /> <a href="#">cosmetics</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" /> <a href="#">electrics</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" /> <a href="#">phone</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li id="ec-more-toggle-content" style="padding: 0; display: none;">
                                            <ul>
                                                <li>
                                                    <div class="ec-sidebar-block-item">
                                                        <input type="checkbox" /> <a href="#">Watch</a><span
                                                            class="checked"></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="ec-sidebar-block-item">
                                                        <input type="checkbox" /> <a href="#">Cap</a><span
                                                            class="checked"></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item ec-more-toggle">
                                                <span class="checked"></span><span id="ec-more-toggle">Mas
                                                    Categorias</span>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <!-- Sidebar Size Block -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Tallas</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" value="" checked /><a href="#">S</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" value="" /><a href="#">M</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" value="" /> <a href="#">L</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" value="" /><a href="#">XL</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item">
                                                <input type="checkbox" value="" /><a href="#">XXL</a><span
                                                    class="checked"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Sidebar Color item -->
                            <div class="ec-sidebar-block ec-sidebar-block-clr">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Color</h3>
                                </div>
                                <div class="ec-sb-block-content">
                                    <ul>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#c4d6f9;"></span></div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#ff748b;"></span></div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#000000;"></span></div>
                                        </li>
                                        <li class="active">
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#2bff4a;"></span></div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#ff7c5e;"></span></div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#f155ff;"></span></div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#ffef00;"></span></div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#c89fff;"></span></div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#7bfffa;"></span></div>
                                        </li>
                                        <li>
                                            <div class="ec-sidebar-block-item"><span
                                                    style="background-color:#56ffc1;"></span></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- Sidebar Price Block -->
                            <div class="ec-sidebar-block">
                                <div class="ec-sb-title">
                                    <h3 class="ec-sidebar-title">Precio</h3>
                                </div>
                                <div class="ec-sb-block-content es-price-slider">
                                    <div class="ec-price-filter">
                                        <div id="ec-sliderPrice" class="filter__slider-price" data-min="0"
                                            data-max="250" data-step="10"></div>
                                        <div class="ec-price-input">
                                            <label class="filter__label"><input type="text"
                                                    class="filter__input"></label>
                                            <span class="ec-price-divider"></span>
                                            <label class="filter__label"><input type="text"
                                                    class="filter__input"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop page -->
</x-plantilla>
