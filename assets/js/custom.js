/**
 *
 * --------------------------------------------------------------------
 *
 * Template : Custom Js Template
 * Author : reacthemes
 * Author URI : http://www.reactheme.com/
 *
 * --------------------------------------------------------------------
 *
 **/
(function ($) {
    "use strict";
    $(document).ready(function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });


    if ($('.product-image--slider').length) {
        const swiper = new Swiper('.product-image--slider', {
            // Optional parameters
            // direction: 'vertical',
            loop: true,
            
            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },
            
            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            
            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        });
    }

    $(window).on('elementor/frontend/init', function () { 
     elementorFrontend.hooks.addAction( 'frontend/element_ready/global', function( $scope ) {
        const cartParent = $('.cart-icon-instedof-text');
        const addToCart = $('.cart-icon-instedof-text .add_to_cart_button');
        addToCart.html('<i class="rt-basket-shopping"></i>');
        addToCart.attr({"data-bs-toggle":"tooltip","data-bs-title": "Add to Cart", "title":"Add to Cart", "data-bs-original-title":"Add to Cart" });
        });
    });
    // const filterBOX = $('.wpnp-product-filter');
    const filterBOX = document.querySelectorAll('.wpnp-product-filter');

    filterBOX.forEach(function(sF){
        const unique = sF.dataset.unique;
        // window['NiceIsotop'+unique] ;

            // init Isotope
            window['NiceIsotop'+unique] = jQuery(`.wpnp-filter-${unique}`).isotope({
                itemSelector: '.product-item',
                layoutMode: 'fitRows',
            });

            // bind filter button click
            jQuery(`.filter-box${unique}`).on( 'click', '.btn-flt', function() {
                var filterValue = jQuery( this ).attr('data-filter');
                window['NiceIsotop'+unique].isotope({ filter: filterValue });
            });

            // change is-checked class on buttons
            jQuery(`.button-group${unique}`).each( function( i, buttonGroup ) {
                var $buttonGroup = jQuery( buttonGroup );
                $buttonGroup.on( 'click', 'button', function() {
                $buttonGroup.find('.is-checked').removeClass('is-checked');
                jQuery( this ).addClass('is-checked');
                });
            });      
    });
    $(window).load(function() {
        jQuery('[data-bs-toggle="tooltip"]').tooltip();
    });


})(jQuery);


const addToCartBox = document.querySelectorAll('.wpnp-grid-8 .cart-icon-instedof-text');
addToCartBox.forEach( item => {
    const changeAddedToCartIcon = function(e){
        if (e.target.classList.contains('add_to_cart_button') || e.target.classList.contains('rt-basket-shopping') ) {
            const innerItem = e.target;
            const addedToCartBox = innerItem.closest('.cart-icon-instedof-text');
            const anchorAdd = addedToCartBox.querySelector('.add_to_cart_button');
            console.log(anchorAdd);
            anchorAdd.querySelector('i').style.display = 'none';
        }
    }
    item.addEventListener('click', changeAddedToCartIcon.bind(1));

})

