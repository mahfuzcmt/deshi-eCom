/**
 * Deshi eCom - Frontend JavaScript
 *
 * @package DeshiEcom
 */

(function ($) {
    'use strict';

    /**
     * Search Bar Typing Animation
     */
    function initSearchAnimation() {
        if (typeof tot_vars === 'undefined' || !tot_vars.search_texts || tot_vars.search_texts.length === 0) {
            return;
        }

        var texts = tot_vars.search_texts;
        var searchInputs = $('input[data-tot-animate="1"]');

        if (searchInputs.length === 0) {
            // Fallback: try common selectors
            searchInputs = $('input[type="search"], .search-field, input[name="s"]').not('[data-tot-animate]');
            searchInputs.attr('data-tot-animate', '1');
        }

        if (searchInputs.length === 0) {
            return;
        }

        searchInputs.each(function () {
            var input = $(this);
            var textIndex = 0;
            var charIndex = 0;
            var isDeleting = false;
            var isPaused = false;
            var isFocused = false;
            var originalPlaceholder = input.attr('placeholder') || '';

            // Stop animation when user focuses on input
            input.on('focus', function () {
                isFocused = true;
                input.attr('placeholder', originalPlaceholder);
            });

            input.on('blur', function () {
                isFocused = false;
                if (input.val() === '') {
                    typeLoop();
                }
            });

            function typeLoop() {
                if (isFocused || input.val() !== '') {
                    setTimeout(typeLoop, 500);
                    return;
                }

                var currentText = texts[textIndex];

                if (isPaused) {
                    isPaused = false;
                    isDeleting = true;
                    setTimeout(typeLoop, 50);
                    return;
                }

                if (!isDeleting) {
                    // Typing
                    charIndex++;
                    input.attr('placeholder', currentText.substring(0, charIndex));

                    if (charIndex >= currentText.length) {
                        isPaused = true;
                        setTimeout(typeLoop, 2000); // Pause at end
                        return;
                    }
                    setTimeout(typeLoop, 80);
                } else {
                    // Deleting
                    charIndex--;
                    input.attr('placeholder', currentText.substring(0, charIndex));

                    if (charIndex <= 0) {
                        isDeleting = false;
                        textIndex = (textIndex + 1) % texts.length;
                        setTimeout(typeLoop, 300);
                        return;
                    }
                    setTimeout(typeLoop, 40);
                }
            }

            // Start the animation loop
            setTimeout(typeLoop, 1000);
        });
    }

    /**
     * Coupon Toggle (Click-to-reveal)
     */
    function initCouponToggle() {
        $(document).on('click', '#tot-show-coupon', function (e) {
            e.preventDefault();
            $('#tot-coupon-form').slideToggle(200);
        });

        $(document).on('click', '#tot-apply-coupon', function () {
            var couponCode = $('#tot-coupon-code').val().trim();
            if (!couponCode) {
                return;
            }

            // Use WC's own hidden coupon form (hidden by CSS but still in DOM)
            var $wcCouponInput = $('form.woocommerce-cart-form input[name="coupon_code"]');
            var $wcApplyBtn = $('form.woocommerce-cart-form button[name="apply_coupon"]');

            if ($wcCouponInput.length && $wcApplyBtn.length) {
                // Fill WC's native coupon input and trigger its button
                $wcCouponInput.val(couponCode);
                $wcApplyBtn.trigger('click');
                // Clear our input after applying
                $('#tot-coupon-code').val('');
            }
        });

        // Allow Enter key in coupon field
        $(document).on('keypress', '#tot-coupon-code', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                $('#tot-apply-coupon').trigger('click');
            }
        });
    }

    /**
     * Product Grid Equal Heights
     */
    function initEqualHeights() {
        var $products = $('ul.products li.product');
        if ($products.length === 0) {
            return;
        }

        function equalize() {
            var maxHeight = 0;
            $products.find('.product-block, .product-inner, > a').css('height', '');

            $products.each(function () {
                var h = $(this).outerHeight();
                if (h > maxHeight) {
                    maxHeight = h;
                }
            });

            if (maxHeight > 0) {
                $products.css('min-height', maxHeight + 'px');
            }
        }

        // Run after images load
        $(window).on('load', equalize);
        $(window).on('resize', debounce(equalize, 250));
    }

    /**
     * Utility: Debounce function
     */
    function debounce(func, wait) {
        var timeout;
        return function () {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                func.apply(context, args);
            }, wait);
        };
    }

    /**
     * Initialize all modules on DOM ready
     */
    $(function () {
        initSearchAnimation();
        initCouponToggle();
        initEqualHeights();
    });

})(jQuery);
