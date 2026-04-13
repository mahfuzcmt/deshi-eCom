;(function ($) {

    "use strict";

    $(document).ready(function () {

        $('.widget_product_search .search-field').find("input[type='text']").each(function (ev) {
            if (!$(this).val()) {
                $(this).attr("placeholder", "Search and Press Enter");
            }
        });

        $('.product-layout-list').parents('ul.products').addClass('products-list');
        $('.single_variation_wrap').addClass('clearfix');
        $('.woocommerce-variation-add-to-cart').addClass('clearfix');

        $('.cart-total-wrap').on('click', function () {
            $('.widget-cart-sidebar').toggleClass('open');
            $(this).toggleClass('cart-open');
            $('.site-overlay').toggleClass('open');
        });

        $('.site-overlay').on('click', function () {
            $(this).removeClass('open');
            $(this).parents('#page').find('.widget-cart-sidebar').removeClass('open');
        });

        $('.woocommerce-tab-heading').on('click', function () {
            $(this).toggleClass('open');
            $(this).parent().find('.woocommerce-tab-content').slideToggle('');
        });

        $('.site-menu-right .h-btn-cart, .mobile-menu-cart .h-btn-cart').on('click', function (e) {
            e.preventDefault();
            $(this).parents('#ct-header-wrap').find('.widget_shopping_cart').toggleClass('open');
            $('.ct-hidden-sidebar').removeClass('open');
            $('.ct-search-popup').removeClass('open');
        });

        $('.woocommerce-add-to-cart a.button:not(".no-animate")').append( '<i class="flaticon-next"></i>' );
        $('.woocommerce-add-to-cart a.button:not(".no-animate")').addClass('btn btn-animate');

        $('.woocommerce-add-to-cart a.button').on('click', function () {
            $(this).parents('.woocommerce-product-inner').addClass('cart-added');
        });

        $('.woocommerce-archive-layout .layout-grid').on('click', function () {
            $(this).addClass('active');
            $(this).parent().find('.layout-list').removeClass('active');
            $(this).parents('.site-main').find('ul.products').addClass('ct-products-grid').removeClass('ct-products-list');
        });
         $('.woocommerce-archive-layout .layout-list').on('click', function () {
            $(this).addClass('active');
            $(this).parent().find('.layout-grid').removeClass('active');
            $(this).parents('.site-main').find('ul.products').addClass('ct-products-list').removeClass('ct-products-grid');
        });

        $('.woocommerce-archive-layout .layout-list.active').parents('.site-main').find('ul.products').addClass('ct-products-list').removeClass('ct-products-grid');

        setTimeout(function () {
            $('.ct-grid .product_type_variable, .ct-slick-slider .product_type_variable').removeAttr('data-product_id');
            $('.ct-product-carousel6.woocommerce .woocommerce-product-inner .woocommerce-add-to--cart .button').append( '<i class="flaticon-shopping-cart-1"></i>' );
            $('.ct-product-carousel9.woocommerce .woocommerce-product-inner .woocommerce-add-to--cart .button').append( '<i class="flaticon-shopping-cart-1"></i>' );
        }, 300);

        $(".woocommerce .products").on("click", ".quantity input", function() {
            return false;
        });
        $(".woocommerce .products").on("change input", ".quantity .qty", function() {
            var add_to_cart_button = $(this).parents( ".product" ).find(".add_to_cart_button");
            // For AJAX add-to-cart actions
            add_to_cart_button.attr('data-quantity', $(this).val());
            // For non-AJAX add-to-cart actions
            add_to_cart_button.attr("href", "?add-to-cart=" + add_to_cart_button.attr("data-product_id") + "&quantity=" + $(this).val());
        });

        $(".woocommerce-shipping-totals.shipping td").attr("colspan","2");

    });

})(jQuery);


jQuery( document ).on( 'qv_loader_stop', function () {
    jQuery( this ).ready( function ( $ ) {
        $('#yith-quick-view-modal .quantity').append('<span class="quantity-icon"><i class="quantity-down">-</i><i class="quantity-up">+</i></span>');
        $('#yith-quick-view-modal .quantity-up').on('click', function () {
            $(this).parents('.quantity').find('input[type="number"]').get(0).stepUp();
        });
        $('#yith-quick-view-modal .quantity-down').on('click', function () {
            $(this).parents('.quantity').find('input[type="number"]').get(0).stepDown();
        });
    } );
} );
