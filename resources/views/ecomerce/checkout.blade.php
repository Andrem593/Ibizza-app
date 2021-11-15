<x-plantilla>
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec  ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Checkout</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <!-- ec-breadcrumb-list start -->
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{route('web')}}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Checkout</li>
                            </ul>
                            <!-- ec-breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-checkout-leftside col-lg-8 col-md-12 ">
                    <!-- checkout content Start -->
                    <div class="ec-checkout-content">
                        <div class="ec-checkout-inner">
                            @auth                                
                            <div class="ec-checkout-wrap margin-bottom-30">
                                <div class="ec-checkout-block ec-check-new">
                                    <h3 class="ec-checkout-title">Nuevo Cliente</h3>
                                    <div class="ec-check-block-content">
                                        <div class="ec-check-subtitle">Opciones Checkout</div>
                                        <form action="#">
                                            <span class="ec-new-option">
                                                <span>
                                                    <input type="radio" id="account1" name="radio-group" checked>
                                                    <label for="account1">Registrarme como Empresaria</label>
                                                </span>
                                            </span>
                                        </form>
                                        <div class="ec-new-desc">Si deseas ser parte de nuestras empresarias solo dale click al boton continuar para poder comunicarte
                                            con uno de nuestro asesores y puedas hacer tu primera compra.
                                        </div>
                                        <div class="ec-new-btn"><a href="#" class="btn btn-primary">Continuar</a></div>

                                    </div>
                                </div>
                                <div class="ec-checkout-block ec-check-login">
                                    <h3 class="ec-checkout-title">Soy Cliente</h3>
                                    <div class="ec-check-login-form">
                                        <form action="#" method="post">
                                            <span class="ec-check-login-wrap">
                                                <label>Email</label>
                                                <input type="text" name="name" placeholder="Enter your email address"
                                                    required />
                                            </span>
                                            <span class="ec-check-login-wrap">
                                                <label>Contraseña</label>
                                                <input type="password" name="password" placeholder="Enter your password"
                                                    required />
                                            </span>

                                            <span class="ec-check-login-wrap ec-check-login-btn">
                                                <button class="btn btn-primary" type="submit">Login</button>
                                                <a class="ec-check-login-fp" href="#">Forgot Password?</a>
                                            </span>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endauth                            
                            <div class="ec-checkout-wrap margin-bottom-30 padding-bottom-3">
                                <div class="ec-checkout-block ec-check-bill">
                                    <h3 class="ec-checkout-title">Detalles de Facturación</h3>
                                    <div class="ec-bl-block-content">
                                        <div class="ec-check-subtitle">Checkout Options</div>
                                        <span class="ec-bill-option">
                                            <span>
                                                <input type="radio" id="bill1" name="radio-group">
                                                <label for="bill1">I want to use an existing address</label>
                                            </span>
                                            <span>
                                                <input type="radio" id="bill2" name="radio-group" checked>
                                                <label for="bill2">I want to use new address</label>
                                            </span>
                                        </span>
                                        <div class="ec-check-bill-form">
                                            <form action="#" method="post">
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>First Name*</label>
                                                    <input type="text" name="firstname"
                                                        placeholder="Enter your first name" required />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Last Name*</label>
                                                    <input type="text" name="lastname"
                                                        placeholder="Enter your last name" required />
                                                </span>
                                                <span class="ec-bill-wrap">
                                                    <label>Address</label>
                                                    <input type="text" name="address" placeholder="Address Line 1" />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>City *</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="ec_select_city" id="ec-select-city"
                                                            class="ec-bill-select">
                                                            <option selected disabled>City</option>
                                                            <option value="1">City 1</option>
                                                            <option value="2">City 2</option>
                                                            <option value="3">City 3</option>
                                                            <option value="4">City 4</option>
                                                            <option value="5">City 5</option>
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Post Code</label>
                                                    <input type="text" name="postalcode" placeholder="Post Code" />
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Country *</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="ec_select_country" id="ec-select-country"
                                                            class="ec-bill-select">
                                                            <option selected disabled>Country</option>
                                                            <option value="1">Country 1</option>
                                                            <option value="2">Country 2</option>
                                                            <option value="3">Country 3</option>
                                                            <option value="4">Country 4</option>
                                                            <option value="5">Country 5</option>
                                                        </select>
                                                    </span>
                                                </span>
                                                <span class="ec-bill-wrap ec-bill-half">
                                                    <label>Region State</label>
                                                    <span class="ec-bl-select-inner">
                                                        <select name="ec_select_state" id="ec-select-state"
                                                            class="ec-bill-select">
                                                            <option selected disabled>Region/State</option>
                                                            <option value="1">Region/State 1</option>
                                                            <option value="2">Region/State 2</option>
                                                            <option value="3">Region/State 3</option>
                                                            <option value="4">Region/State 4</option>
                                                            <option value="5">Region/State 5</option>
                                                        </select>
                                                    </span>
                                                </span>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <span class="ec-check-order-btn">
                                <a class="btn btn-primary" href="#">Place Order</a>
                            </span>
                        </div>
                    </div>
                    <!--cart content End -->
                </div>
                <!-- Sidebar Area Start -->
                <div class="ec-checkout-rightside col-lg-4 col-md-12">
                    <div class="ec-sidebar-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Summary</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-summary">
                                    <div>
                                        <span class="text-left">Sub-Total</span>
                                        <span class="text-right">$80.00</span>
                                    </div>
                                    <div>
                                        <span class="text-left">Delivery Charges</span>
                                        <span class="text-right">$80.00</span>
                                    </div>
                                    <div>
                                        <span class="text-left">Coupan Discount</span>
                                        <span class="text-right"><a class="ec-checkout-coupan">Apply Coupan</a></span>
                                    </div>
                                    <div class="ec-checkout-coupan-content">
                                        <form class="ec-checkout-coupan-form" name="ec-checkout-coupan-form"
                                            method="post" action="#">
                                            <input class="ec-coupan" type="text" required=""
                                                placeholder="Enter Your Coupan Code" name="ec-coupan" value="">
                                            <button class="ec-coupan-btn button btn-primary" type="submit"
                                                name="subscribe" value="">Apply</button>
                                        </form>
                                    </div>
                                    <div class="ec-checkout-summary-total">
                                        <span class="text-left">Total Amount</span>
                                        <span class="text-right">$80.00</span>
                                    </div>
                                </div>
                                <div class="ec-checkout-pro">
                                    <div class="col-sm-12 mb-6">
                                        <div class="ec-product-inner">
                                            <div class="ec-pro-image-outer">
                                                <div class="ec-pro-image">
                                                    <a href="product-left-sidebar.html" class="image">
                                                        <img class="main-image"
                                                            src="assets/images/product-image/1_1.jpg" alt="Product" />
                                                        <img class="hover-image"
                                                            src="assets/images/product-image/1_2.jpg" alt="Product" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Baby toy
                                                        teddy bear</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$95.00</span>
                                                    <span class="new-price">$79.00</span>
                                                </span>
                                                <div class="ec-pro-option">
                                                    <div class="ec-pro-color">
                                                        <span class="ec-pro-opt-label">Color</span>
                                                        <ul class="ec-opt-swatch ec-change-img">
                                                            <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                    data-src="assets/images/product-image/1_1.jpg"
                                                                    data-src-hover="assets/images/product-image/1_1.jpg"
                                                                    data-tooltip="Gray"><span
                                                                        style="background-color:#6d4c36;"></span></a>
                                                            </li>
                                                            <li><a href="#" class="ec-opt-clr-img"
                                                                    data-src="assets/images/product-image/1_2.jpg"
                                                                    data-src-hover="assets/images/product-image/1_2.jpg"
                                                                    data-tooltip="Orange"><span
                                                                        style="background-color:#ffb0e1;"></span></a>
                                                            </li>
                                                            <li><a href="#" class="ec-opt-clr-img"
                                                                    data-src="assets/images/product-image/1_3.jpg"
                                                                    data-src-hover="assets/images/product-image/1_3.jpg"
                                                                    data-tooltip="Green"><span
                                                                        style="background-color:#8beeff;"></span></a>
                                                            </li>
                                                            <li><a href="#" class="ec-opt-clr-img"
                                                                    data-src="assets/images/product-image/1_4.jpg"
                                                                    data-src-hover="assets/images/product-image/1_4.jpg"
                                                                    data-tooltip="Sky Blue"><span
                                                                        style="background-color:#74f8d1;"></span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="ec-pro-size">
                                                        <span class="ec-pro-opt-label">Size</span>
                                                        <ul class="ec-opt-size">
                                                            <li class="active"><a href="#" class="ec-opt-sz"
                                                                    data-old="$95.00" data-new="$79.00"
                                                                    data-tooltip="Small">S</a></li>
                                                            <li><a href="#" class="ec-opt-sz" data-old="$90.00"
                                                                    data-new="$70.00" data-tooltip="Medium">M</a></li>
                                                            <li><a href="#" class="ec-opt-sz" data-old="$80.00"
                                                                    data-new="$60.00" data-tooltip="Large">X</a></li>
                                                            <li><a href="#" class="ec-opt-sz" data-old="$70.00"
                                                                    data-new="$50.00" data-tooltip="Extra Large">XL</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-0">
                                        <div class="ec-product-inner">
                                            <div class="ec-pro-image-outer">
                                                <div class="ec-pro-image">
                                                    <a href="product-left-sidebar.html" class="image">
                                                        <img class="main-image"
                                                            src="assets/images/product-image/8_1.jpg" alt="Product" />
                                                        <img class="hover-image"
                                                            src="assets/images/product-image/8_2.jpg" alt="Product" />
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ec-pro-content">
                                                <h5 class="ec-pro-title"><a href="product-left-sidebar.html">Smart I
                                                        watch 2GB</a></h5>
                                                <div class="ec-pro-rating">
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star fill"></i>
                                                    <i class="ecicon eci-star"></i>
                                                </div>
                                                <span class="ec-price">
                                                    <span class="old-price">$58.00</span>
                                                    <span class="new-price">$45.00</span>
                                                </span>
                                                <div class="ec-pro-option">
                                                    <div class="ec-pro-color">
                                                        <span class="ec-pro-opt-label">Color</span>
                                                        <ul class="ec-opt-swatch ec-change-img">
                                                            <li class="active"><a href="#" class="ec-opt-clr-img"
                                                                    data-src="assets/images/product-image/8_2.jpg"
                                                                    data-src-hover="assets/images/product-image/8_2.jpg"
                                                                    data-tooltip="Gray"><span
                                                                        style="background-color:#f3f3f3;"></span></a>
                                                            </li>
                                                            <li><a href="#" class="ec-opt-clr-img"
                                                                    data-src="assets/images/product-image/8_3.jpg"
                                                                    data-src-hover="assets/images/product-image/8_3.jpg"
                                                                    data-tooltip="Orange"><span
                                                                        style="background-color:#fac7f3;"></span></a>
                                                            </li>
                                                            <li><a href="#" class="ec-opt-clr-img"
                                                                    data-src="assets/images/product-image/8_4.jpg"
                                                                    data-src-hover="assets/images/product-image/8_4.jpg"
                                                                    data-tooltip="Green"><span
                                                                        style="background-color:#c5f1ff;"></span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="ec-pro-size">
                                                        <span class="ec-pro-opt-label">Size</span>
                                                        <ul class="ec-opt-size">
                                                            <li class="active"><a href="#" class="ec-opt-sz"
                                                                    data-old="$48.00" data-new="$45.00"
                                                                    data-tooltip="Small">S</a></li>
                                                            <li><a href="#" class="ec-opt-sz" data-old="$90.00"
                                                                    data-new="$70.00" data-tooltip="Medium">M</a></li>
                                                            <li><a href="#" class="ec-opt-sz" data-old="$80.00"
                                                                    data-new="$60.00" data-tooltip="Large">X</a></li>
                                                            <li><a href="#" class="ec-opt-sz" data-old="$70.00"
                                                                    data-new="$50.00" data-tooltip="Extra Large">XL</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                    <div class="ec-sidebar-wrap ec-checkout-del-wrap">
                        <!-- Sidebar Summary Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Delivery Method</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-del">
                                    <div class="ec-del-desc">Please select the preferred shipping method to use on this
                                        order.</div>
                                    <form action="#">
                                        <span class="ec-del-option">
                                            <span>
                                                <span class="ec-del-opt-head">Free Shipping</span>
                                                <input type="radio" id="del1" name="radio-group" checked>
                                                <label for="del1">Rate - $0 .00</label>
                                            </span>
                                            <span>
                                                <span class="ec-del-opt-head">Flat Rate</span>
                                                <input type="radio" id="del2" name="radio-group">
                                                <label for="del2">Rate - $5.00</label>
                                            </span>
                                        </span>
                                        <span class="ec-del-commemt">
                                            <span class="ec-del-opt-head">Add Comments About Your Order</span>
                                            <textarea name="your-commemt" placeholder="Comments"></textarea>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Summary Block -->
                    </div>
                    <div class="ec-sidebar-wrap ec-checkout-pay-wrap">
                        <!-- Sidebar Payment Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Payment Method</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-checkout-pay">
                                    <div class="ec-pay-desc">Please select the preferred payment method to use on this
                                        order.</div>
                                    <form action="#">
                                        <span class="ec-pay-option">
                                            <span>
                                                <input type="radio" id="pay1" name="radio-group" checked>
                                                <label for="pay1">Cash On Delivery</label>
                                            </span>
                                        </span>
                                        <span class="ec-pay-commemt">
                                            <span class="ec-pay-opt-head">Add Comments About Your Order</span>
                                            <textarea name="your-commemt" placeholder="Comments"></textarea>
                                        </span>
                                        <span class="ec-pay-agree"><input type="checkbox" value=""><a href="#">I have
                                                read and agree to the <span>Terms & Conditions</span></a><span
                                                class="checked"></span></span>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Payment Block -->
                    </div>
                    <div class="ec-sidebar-wrap ec-check-pay-img-wrap">
                        <!-- Sidebar Payment Block -->
                        <div class="ec-sidebar-block">
                            <div class="ec-sb-title">
                                <h3 class="ec-sidebar-title">Payment Method</h3>
                            </div>
                            <div class="ec-sb-block-content">
                                <div class="ec-check-pay-img-inner">
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment1.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment2.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment3.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment4.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment5.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment6.png" alt="">
                                    </div>
                                    <div class="ec-check-pay-img">
                                        <img src="assets/images/icons/payment7.png" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Sidebar Payment Block -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('js')
        <script>
            $('body').addClass('checkout_page')
        </script>
    @endpush
</x-plantilla>
