// Funcion para enviar datos a session sobre el carrito

$("body").on("click", ".add-to-cart", function(){
    var clasificacion = $(this).parents().parents().parents().children(".ec-pro-content").find(".ec-pro-title a").html();
    var color = $(this).parents().parents().parents().children(".ec-pro-content").find('.ec-pro-option .ec-pro-color .p-0').val();
    var talla = $(this).parents().parents().parents().children(".ec-pro-content").find('.ec-pro-option .ec-pro-size .ec-opt-size .active .ec-opt-sz').html();
    data = {
        'clasificacion' : clasificacion,
        'color':color,
        'talla':talla,
    }
    $.post({
        url: '/store',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response == 'add'){
                Livewire.emit('render')
            }
        }
    })
});
// Function To Create New Cookie 
function ecCreateCookie(cookieName,cookieValue,daysToExpire)
{
    var date = new Date();
    date.setTime(date.getTime()+(daysToExpire*24*60*60*1000));
    document.cookie = cookieName + "=" + cookieValue + "; expires=" + date.toGMTString();
}

// Function To Delete Existing Cookie
function ecDeleteCookie(cookieName,cookieValue)
{
    var date = new Date(0).toGMTString();
    document.cookie = cookieName + "=" + cookieValue + "; expires=" + date;
}

// Function To Access Existing Cookie
function ecAccessCookie(cookieName)
{
    var name = cookieName + "=";
    var allCookieArray = document.cookie.split(';');
    for(var i=0; i<allCookieArray.length; i++)
    {
        var temp = allCookieArray[i].trim();
        if (temp.indexOf(name)==0){
            return temp.substring(name.length,temp.length);
        }
    }

    return "";
}

// Function To Check Existing Cookie
function ecCheckCookie()
{
    var bgImageMode = ecAccessCookie("bgImageModeCookie");
    if (bgImageMode != "")
    {     
        var bgIDClass = bgImageMode.split('||');
        var bgID = bgIDClass[0];
        var bgClass = bgIDClass[1];
        
        $("body").removeClass("body-bg-1");
        $("body").removeClass("body-bg-2");
        $("body").removeClass("body-bg-3");
        $("body").removeClass("body-bg-4");
    
        $("body").addClass(bgClass);
    
        $("#bg-switcher-css").attr("href", "assets/css/backgrounds/" + bgID + ".css");
    }

    var rtlMode = ecAccessCookie("rtlModeCookie");
    if (rtlMode != "")
    {
        // alert(rtlMode);    
        var $link = $('<link>', {
            rel: 'stylesheet',
            href: 'assets/css/rtl.css',
            class: 'rtl'
        });
        $(".ec-tools-sidebar .ec-change-rtl").toggleClass('active');
        $link.appendTo('head');                
    }

    // ecCreateCookie('bgImgModeCookie',bgIDClass,1);

    var darkMode = ecAccessCookie("darkModeCookie");
    if (darkMode != "")
    {
        var $link = $('<link>', {
            rel: 'stylesheet',
            href: 'assets/css/dark.css',
            class: 'dark'
        });
        
        $("link[href='assets/css/responsive.css']").before($link);

        $(".ec-tools-sidebar .ec-change-mode").toggleClass('active');
        $("body").addClass("dark");
    }
    else
    {
        var themeColor = ecAccessCookie("themeColorCookie");
        if (themeColor != "")
        {
            $('li[data-color = '+themeColor+']').toggleClass('active').siblings().removeClass('active');
            $('li[data-color = '+themeColor+']').addClass('active');
            
            if(themeColor != '01'){
                $("link[href='assets/css/responsive.css']").before('<link rel="stylesheet" href="assets/css/skin-'+themeColor+'.css" rel="stylesheet">');
            }
        }
    }
}

(function($) {
    "use strict";

    /*----------------------------- Site Cookie function --------------------*/
    // Calling Function On Each Time Site Load | Reload
    ecCheckCookie();

    // On click method for Clear Cookie
    $(".clear-cach").on("click", function (e) {
        ecDeleteCookie("rtlModeCookie", "");
        ecDeleteCookie("darkModeCookie", "");
        ecDeleteCookie("themeColorCookie", "");
        ecDeleteCookie("bgImageModeCookie", "");
        location.reload();
    });

    /*----------------------------- Site Loader  --------------------*/
    $(window).load(function () { 
        $("#ec-overlay").fadeOut("slow"); 
        setTimeout(function(){ 
            switch(window.location.protocol) {
                case 'file:':

                    var alertBody = '<div id="ec-direct-run" class="ec-direct-run"><div class="ec-direct-body"><h4>Template Running Directlly</h4><p>As we seeing you are try to load template without Local | Live server. it will affect missed or lost content. Please try to use Local | Live Server. </p></div></div>';
                    $("body").append(alertBody);

                  break;
                default: 
                  //some other protocol
            }
         }, 3000);    
    });

    /*----------------------------- Animate On Scroll --------------------*/

      
    

    /*----------------------------- Bootstrap dropdown   --------------------*/
    $('.dropdown').on('show.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
    });

    $('.dropdown').on('hide.bs.dropdown', function() {
        $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
    });

    /*----------------------------- Language and Currency Click to Active -------------------------------- */
    $(document).ready(function() {
        $(".header-top-lan li").click(function() {
            $(this).addClass('active').siblings().removeClass('active');
        });
        $(".header-top-curr li").click(function() {
            $(this).addClass('active').siblings().removeClass('active');
        });
    });

    /*----------------------------- Toggle Search Bar --------------------- */
    $(".search-btn").on("click", function() {
        $(this).toggleClass('active');
        $('.dropdown_search').slideToggle('medium');
    });


    /*----------------------------- Filter Icon OnClick Open filter Sidebar on shop page -----------------------------------*/
    $('#shop_sidebar').stickySidebar({
        topSpacing: 30,
        bottomSpacing: 30
    });

	$(".sidebar-toggle-icon").on("click", function () {
		$(".filter-sidebar-overlay").fadeIn();
		$(".filter-sidebar").addClass("toggle-sidebar-swipe");
	});

	$(".filter-cls-btn").on("click", function () {
		$(".filter-sidebar").removeClass("toggle-sidebar-swipe");
		$(".filter-sidebar-overlay").fadeOut();
	});

	$(".filter-sidebar-overlay").on("click", function () {
		$(".filter-sidebar").removeClass("toggle-sidebar-swipe");
		$(".filter-sidebar-overlay").fadeOut();
	});

    /*----------------------------- Remove product on compare and wishlish page -----------------------------------*/ 

    /*----------------------------- SideIbizzaCart And SideMenu -----------------------------------*/
    $("body").on("click", ".add-to-cart", function(){
        $(".ec-cart-float").fadeIn();

        var count = $(".cart-count-lable").html();        
        count++;
        $(".cart-count-lable").html(count);

        // Remove Empty message    
        // $(".emp-cart-msg").parent().remove();        

        setTimeout(function(){ 
            $(".ec-cart-float").fadeOut(); 
        }, 5000);
        
        // // get an image url
        // var img_url = $(this).parents().parents().children(".image").find(".main-image").attr("src");
        // var p_name = $(this).parents().parents().parents().children(".ec-pro-content").find(".ec-pro-title a").html();
        // var p_price = $(this).parents().parents().parents().children(".ec-pro-content").find(".ec-price .new-price").html();
        // var p_html = '<li>'+
        //                 '<a href="product-left-sidebar.html" class="sidekka_pro_img"><img src="'+ img_url +'" alt="product"></a>'+
        //                 '<div class="ec-pro-content">'+
        //                     '<a href="product-left-sidebar.html" class="cart_pro_title">'+ p_name +'</a>'+
        //                 '<span class="cart-price"><span>'+ p_price +'</span> x 1</span>'+
        //                     '<div class="qty-plus-minus"><div class="dec ec_qtybtn">-</div>'+
        //                         '<input class="qty-input" type="text" name="ec_qtybtn" value="1">'+
        //                     '<div class="inc ec_qtybtn">+</div></div>'+
        //                     '<a href="javascript:void(0)" class="remove">×</a>'+
        //                 '</div>'+
        //             '</li>';
        // $('.eccart-pro-items').append(p_html);    
        
    });

    (function() {
        var $ekkaToggle = $(".ec-side-toggle"),
        $ekka = $(".ec-side-cart"),
        $ecMenuToggle = $(".mobile-menu-toggle");

        $ekkaToggle.on("click", function(e) {
            e.preventDefault();
            var $this = $(this),
            $target = $this.attr("href");
            // $("body").addClass("ec-open");
            $(".ec-side-cart-overlay").fadeIn();
            $($target).addClass("ec-open");
            if ($this.parent().hasClass("mobile-menu-toggle")) {
                $this.addClass("close");
                $(".ec-side-cart-overlay").fadeOut();
            }
        });
        
        $(".ec-side-cart-overlay").on("click", function(e) {
            $(".ec-side-cart-overlay").fadeOut();
            $ekka.removeClass("ec-open");
            $ecMenuToggle.find("a").removeClass("close");
        });

        $(".ec-close").on("click", function(e) {
            e.preventDefault();
            $(".ec-side-cart-overlay").fadeOut();
            $ekka.removeClass("ec-open");
            $ecMenuToggle.find("a").removeClass("close");
        });

        $("body").on("click", ".ec-pro-content .remove", function(){

        // $(".ec-pro-content .remove").on("click", function () {
            
            var cart_product_count = $(".eccart-pro-items li").length;
            
            $(this).closest("li").remove();
            if (cart_product_count == 1) {
                $('.eccart-pro-items').html('<li><p class="emp-cart-msg">Tu carrito está vacio!</p></li>');
            }

            var count = $(".cart-count-lable").html();    
            // AM QUITAR LA CANTIDAD DE ELEMENTOS QUE HAYA ESCOGIDO   
            count = count - $(this).parents().children(".ec-pro-content").find(".card-qty").html()
            $(".cart-count-lable").html(count);

            cart_product_count--;
            //AM FUNCION DE REMOVER ARTICULOS DEL CARRITO DEL MODELO CART
            let data = {
                'id' : $(this).parents().children(".ec-pro-content").find(".idItemCart").html()
            }
            $.post({
                url: '/delete',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.message == 'deleted'){
                        $('#subTotal').html('$'+response.subtotal);
                        $('#tax').html('$'+response.tax);
                        $('#total').html('$'+response.total);
                    }
                }
            })
        });    
        
    })();

    /*----------------------------- ekka Responsive Menu -----------------------------------*/
    function ResponsiveMobileekkaMenu() {
        var $ekkaNav = $(".ec-menu-content, .overlay-menu"),
        $ekkaNavSubMenu = $ekkaNav.find(".sub-menu");
        $ekkaNavSubMenu.parent().prepend('<span class="menu-toggle"></span>');

        $ekkaNav.on("click", "li a, .menu-toggle", function(e) {
            var $this = $(this);
            if ($this.attr("href") === "#" || $this.hasClass("menu-toggle")) {
                e.preventDefault();
                if ($this.siblings("ul:visible").length) {
                    $this.parent("li").removeClass("active");
                    $this.siblings("ul").slideUp();
                    $this.parent("li").find("li").removeClass("active");
                    $this.parent("li").find("ul:visible").slideUp();
                } else {
                    $this.parent("li").addClass("active");
                    $this.closest("li").siblings("li").removeClass("active").find("li").removeClass("active");
                    $this.closest("li").siblings("li").find("ul:visible").slideUp();
                    $this.siblings("ul").slideDown();
                }
            }
        });
    }

    ResponsiveMobileekkaMenu();


    /*----------------------------- Menu Active -------------------------------- */        
    var current_page_URL = location.href;
    $( ".ec-main-menu ul li a" ).each(function() {
        if ($(this).attr("href") !== "#") {
         var target_URL = $(this).prop("href");
         if (target_URL == current_page_URL) {
           $('.ec-main-menu a').parents('li, ul').removeClass('active');
           $(this).parent('li').addClass('active');
            return false;
         }
        }
    });


    /*----------------------------- Footer Toggle -------------------------------- */    
    $(document).ready(function(){
        $("footer .footer-top .ec-footer-widget .ec-footer-links").addClass("ec-footer-dropdown");

        $('.ec-footer-heading').append( "<div class='ec-heading-res'><i class='ecicon eci-angle-down'></i></div>" );

        $(".ec-footer-heading .ec-heading-res").click(function() {
           var $this = $(this).closest('.footer-top .col-sm-12').find('.ec-footer-dropdown');
           $this.slideToggle('slow');
           $('.ec-footer-dropdown').not($this).slideUp('slow');
       });
    });

    /*----------------------------- List Grid View -------------------------------- */   
    $('.ec-gl-btn').on('click', 'button', function() {
        var $this = $(this);
        $this.addClass('active').siblings().removeClass('active');
    });

    // for 100% width list view
    function showList(e) {
        var $gridCont = $('.shop-pro-inner');
        var $listView = $('.pro-gl-content');
        e.preventDefault();
        $gridCont.addClass('list-view');
        $listView.addClass('width-100');
    }

    function gridList(e) {
        var $gridCont = $('.shop-pro-inner');
        var $gridView = $('.pro-gl-content');
        e.preventDefault();
        $gridCont.removeClass('list-view');
        $gridView.removeClass('width-100');
    }

    $(document).on('click', '.btn-grid', gridList);
    $(document).on('click', '.btn-list', showList);

    // for 50% width list view
    function showList50(e) {
        var $gridCont = $('.shop-pro-inner');
        var $listView = $('.pro-gl-content');
        e.preventDefault();
        $gridCont.addClass('list-view-50');
        $listView.addClass('width-50');
    }

    function gridList50(e) {
        var $gridCont = $('.shop-pro-inner');
        var $gridView = $('.pro-gl-content');
        e.preventDefault();
        $gridCont.removeClass('list-view-50');
        $gridView.removeClass('width-50');
    }

    $(document).on('click', '.btn-grid-50', gridList50);
    $(document).on('click', '.btn-list-50', showList50);

    /*----------------------------- Sidebar Block Toggle -------------------------------- */    
    $(document).ready(function(){
        $(".ec-shop-leftside .ec-sidebar-block .ec-sb-block-content,.ec-blogs-leftside .ec-sidebar-block .ec-sb-block-content,.ec-cart-rightside .ec-sidebar-block .ec-sb-block-content,.ec-checkout-rightside .ec-sidebar-block .ec-sb-block-content").addClass("ec-sidebar-dropdown");

        $('.ec-sidebar-title').append( "<div class='ec-sidebar-res'><i class='ecicon eci-angle-down'></i></div>" );

        $(".ec-sidebar-title .ec-sidebar-res").click(function() {
            var $this = $(this).closest('.ec-shop-leftside .ec-sidebar-block,.ec-blogs-leftside .ec-sidebar-block,.ec-cart-rightside .ec-sidebar-block,.ec-checkout-rightside .ec-sidebar-wrap').find('.ec-sidebar-dropdown');
            $this.slideToggle('slow');
            $('.ec-sidebar-dropdown').not($this).slideUp('slow');
        });
    });

    /*----------------------------- Load More Category -------------------------------- */
    $(document).ready(function() {
        $(".ec-more-toggle").click(function() {
            var elem = $(".ec-more-toggle #ec-more-toggle").text();
            if (elem == "More Categories") {
                $(".ec-more-toggle #ec-more-toggle").text("Less Categories");
                $(".ec-more-toggle").toggleClass('active');
                $("#ec-more-toggle-content").slideDown();
            } else {

                $(".ec-more-toggle  #ec-more-toggle").text("More Categories");
                $(".ec-more-toggle").removeClass('active');
                $("#ec-more-toggle-content").slideUp();
            }
        });
    });

    /*----------------------------- Sidebar Color Click to Active -------------------------------- */
    $(document).ready(function() {
        $(".ec-sidebar-block.ec-sidebar-block-clr li").click(function() {
        $(this).addClass('active').siblings().removeClass('active');
    });
    });

    /*----------------------------- Faq Block Toggle -------------------------------- */    
    $(document).ready(function(){
        $(".ec-faq-wrapper .ec-faq-block .ec-faq-content").addClass("ec-faq-dropdown");

        $(".ec-faq-block .ec-faq-title ").click(function() {
        var $this = $(this).closest('.ec-faq-wrapper .ec-faq-block').find('.ec-faq-dropdown');
        $this.slideToggle('slow');
        $('.ec-faq-dropdown').not($this).slideUp('slow');
    });
    });

    /*----------------------------- Product page category Toggle -------------------------------- */    
    $(document).ready(function(){
        $(".product_page .ec-sidebar-block .ec-sb-block-content ul li ul").addClass("ec-cat-sub-dropdown");

        $(".product_page .ec-sidebar-block .ec-sidebar-block-item").click(function() {
        var $this = $(this).closest('.product_page .ec-pro-leftside .ec-sidebar-block .ec-sb-block-content').find('.ec-cat-sub-dropdown');
        $this.slideToggle('slow');
        $('.ec-cat-sub-dropdown').not($this).slideUp('slow');


    });
    });



    /*
    /*----------------------------- Cart Page Qty Plus Minus Button  ------------------------------ */
    var CartQtyPlusMinus = $(".cart-qty-plus-minus");
    CartQtyPlusMinus.append('<div class="ec_cart_qtybtn"><div class="inc ec_qtybtn">+</div><div class="dec ec_qtybtn">-</div></div>');
    $(".cart-qty-plus-minus .ec_cart_qtybtn .ec_qtybtn").on("click", function() {
        var $cartqtybutton = $(this);
        var CartQtyoldValue = $cartqtybutton.parent().parent().find("input").val();
        if ($cartqtybutton.text() === "+") {
            var CartQtynewVal = parseFloat(CartQtyoldValue) + 1;
        } else {

            if (CartQtyoldValue > 1) {
                var CartQtynewVal = parseFloat(CartQtyoldValue) - 1;
            } else {
                CartQtynewVal = 1;
            }
        }
        $cartqtybutton.parent().parent().find("input").val(CartQtynewVal);
    });

    /*----------------------------- Cart  Shipping Toggle -------------------------------- */    
    $(document).ready(function(){
        $(".ec-sb-block-content .ec-ship-title").click(function() {
            $('.ec-sb-block-content .ec-cart-form').slideToggle('slow');
        });
    });

    $(document).ready(function(){
        $("button.add-to-cart").click(function() {
            //$("#addtocart_toast").addClass("show");
            // setTimeout(function(){ $("#addtocart_toast").removeClass("show") }, 3000);
        });
        $(".ec-btn-group.wishlist").click(function() {
        var isWishlist = $(this).hasClass("active");
        if(isWishlist){
            $(this).removeClass("active");
        } else {            
            $(this).addClass("active");
        }


        $("#wishlist_toast").addClass("show");
        setTimeout(function(){ $("#wishlist_toast").removeClass("show") }, 3000);
    });
    });

    $(document).ready(function(){
        $('.ec-pro-image').append( "<div class='ec-pro-loader'></div>" );
    });

    /*----------------------------- Apply Coupen Toggle -------------------------------- */   
    $(document).ready(function(){
        $(".ec-cart-coupan").click(function() {
        $('.ec-cart-coupan-content').slideToggle('slow');
        });
        $(".ec-checkout-coupan").click(function() {
        $('.ec-checkout-coupan-content').slideToggle('slow');
        });
    });

    /*----------------------------- Recent auto popup -----------------------------------*/
    setInterval(function () { $(".recent-purchase").stop().slideToggle('slow'); }, 10000);
    $(".recent-close").click(function () {
        $(".recent-purchase").stop().slideToggle('slow');
    });

    /*----------------------------- Whatsapp chat --------------------------------*/
    $(document).ready(function () {

        //click event on a tag
        $('.ec-list').on("click", function () {

            var number = $(this).attr("data-number");
            var message = $(this).attr("data-message");

            //checking for device type
            if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
                // redirect link for mobile WhatsApp chat awc
                window.open('https://wa.me/' + number + '/?text=' + message, '-blank');
            }
            else {
                // redirect link for WhatsApp chat in website
                window.open('https://web.WhatsApp.com/send?phone=' + number + '&text=' + message, '-blank');
            }
        })

        // chat widget open/close duration
        $('ec-style1').launchBtn({ openDuration: 400, closeDuration: 300 });
    });

    // chat panel open/close function
    $.fn.launchBtn = function (options) {
        var mainBtn, panel, clicks, settings, launchPanelAnim, closePanelAnim, openPanel, boxClick;

        mainBtn = $(".ec-button");
        panel = $(".ec-panel");
        clicks = 0;

        //default settings
        settings = $.extend({
            openDuration: 600,
            closeDuration: 200,
            rotate: true
        }, options);

        //Open panel animation
        launchPanelAnim = function () {
            panel.animate({
                opacity: "toggle",
                height: "toggle"
            }, settings.openDuration);
        };

        //Close panel animation
        closePanelAnim = function () {
            panel.animate({
                opacity: "hide",
                height: "hide"
            }, settings.closeDuration);
        };

        //Open panel and rotate icon
        openPanel = function (e) {
            if (clicks === 0) {
                if (settings.rotate) {
                    $(this).removeClass('rotateBackward').toggleClass('rotateForward');
                }

                launchPanelAnim();
                clicks++;
            } else {
                if (settings.rotate) {
                    $(this).removeClass('rotateForward').toggleClass('rotateBackward');
                }

                closePanelAnim();
                clicks--;
            }
            e.preventDefault();
            return false;
        };

        //Allow clicking in panel
        boxClick = function (e) {
            e.stopPropagation();
        };

        //Main button click
        mainBtn.on('click', openPanel);

        //Prevent closing panel when clicking inside
        panel.click(boxClick);

        //Click away closes panel when clicked in document
        $(document).click(function () {
            closePanelAnim();
            if (clicks === 1) {
                mainBtn.removeClass('rotateForward').toggleClass('rotateBackward');
            }
            clicks = 0;
        });
    };

    /*----------------------------- User Profile Change on Upload -----------------------------------*/
    $("body").on("change", ".ec-image-upload", function (e) {

        var lkthislk = $(this);

        if (this.files && this.files[0]) {

            var reader = new FileReader();
            reader.onload = function (e) {

                var ec_image_preview = lkthislk.parent().parent().children('.ec-preview').find('.ec-image-preview').attr('src', e.target.result);

                ec_image_preview.hide();
                ec_image_preview.fadeIn(650);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

    /*----------------------------- bg skin ---------------------- */
    (function() {
        $().appendTo($('body'));
    })();

    $(".bg-option-box").on("click", function (e) {
        e.preventDefault();
        if ($(this).hasClass("in-out")) {
            $(".bg-switcher").stop().animate({right: "0px"}, 100);
            if ($(".color-option-box").not("in-out")) {
                $(".skin-switcher").stop().animate({right: "-163px"}, 100);
                $(".color-option-box").addClass("in-out");
            }
            if ($(".layout-option-box").not("in-out")) {
                $(".layout-switcher").stop().animate({right: "-163px"}, 100);
                $(".layout-option-box").addClass("in-out");
            }
        } else {
            $(".bg-switcher").stop().animate({right: "-163px"}, 100);
        }
        
        $(this).toggleClass("in-out");
        return false;
        
    });
    
    /*----------------------------- bg Image ---------------------- */
    $('.back-bg-1').on('click', function(e) {
        var bgID = $(this).attr("id");
        var bgClass = "body-bg-1";
        setBGImage(bgID,bgClass);
    });

    $('.back-bg-2').on('click', function(e) {
        var bgID = $(this).attr("id");
        var bgClass = "body-bg-2";
        setBGImage(bgID,bgClass);
    });

    $('.back-bg-3').on('click', function(e) {
        var bgID = $(this).attr("id");
        var bgClass = "body-bg-3";
        setBGImage(bgID,bgClass);
    });

    $('.back-bg-4').on('click', function(e) {
        var bgID = $(this).attr("id");
        var bgClass = "body-bg-4";
        setBGImage(bgID,bgClass);
    });

    function setBGImage(bgID,bgClass){
        $("body").removeClass("body-bg-1");
        $("body").removeClass("body-bg-2");
        $("body").removeClass("body-bg-3");
        $("body").removeClass("body-bg-4");

        $("body").addClass(bgClass);

        $("#bg-switcher-css").attr("href", "assets/css/backgrounds/" + bgID + ".css");
    
        var bgIDClass =  bgID +'||'+ bgClass;

        ecCreateCookie('bgImageModeCookie',bgIDClass,1);
    }

    /*----------------------------- Language select options google translate ---------------------- */
    $(".lang-option-box").on("click", function (e) {
        e.preventDefault();
        if ($(this).hasClass("in-out")) {
            $(".lang-switcher").stop().animate({right: "0px"}, 100);
            if ($(".color-option-box").not("in-out")) {
                $(".skin-switcher").stop().animate({right: "-163px"}, 100);
                $(".color-option-box").addClass("in-out");
            }
            if ($(".layout-option-box").not("in-out")) {
                $(".layout-switcher").stop().animate({right: "-163px"}, 100);
                $(".layout-option-box").addClass("in-out");
            }
        } else {
            $(".lang-switcher").stop().animate({right: "-163px"}, 100);
        }
        
        $(this).toggleClass("in-out");
        return false;
        
    });

    /*----------------------------- Tools sidebar ---------------------- */
    $(".ec-tools-sidebar-toggle").on("click", function (e) {
        e.preventDefault();
        if ($(this).hasClass("in-out")) {
            $(".ec-tools-sidebar").stop().animate({right: "0px"}, 100);
            $(".ec-tools-sidebar-overlay").fadeIn();
            if ($(".ec-tools-sidebar-toggle").not("in-out")) {
                $(".ec-tools-sidebar").stop().animate({right: "-200px"}, 100);
                $(".ec-tools-sidebar-toggle").addClass("in-out");
                // $(".ec-tools-sidebar-overlay").fadeOut();
            }
            if ($(".ec-tools-sidebar-toggle").not("in-out")) {
                $(".ec-tools-sidebar").stop().animate({right: "0"}, 100);
                $(".ec-tools-sidebar-toggle").addClass("in-out");
                $(".ec-tools-sidebar-overlay").fadeIn();
            }
        } else {
            $(".ec-tools-sidebar").stop().animate({right: "-200px"}, 100);
            $(".ec-tools-sidebar-overlay").fadeOut();
        }
        
        $(this).toggleClass("in-out");
        return false;
        
    });

    $(".ec-tools-sidebar-overlay").on("click", function (e) {
        $(".ec-tools-sidebar-toggle").addClass("in-out");
        $(".ec-tools-sidebar").stop().animate({right: "-200px"}, 100);
        $(".ec-tools-sidebar-overlay").fadeOut();
    });

})(jQuery);
