$(function(){
	'use strict';

    // preloader
    $(".wrap-preloader").fadeOut();
    
    // link back
    $('.link-back').on('click', function() {
        window.history.back();
        return false;
    });

    // carousel
    $(".carousel-slide").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: true
    });

    // product-d-slide
    $(".product-d-slide").owlCarousel({
        items: 1,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        loop: false,
        margin: 10
    });

    // walkthrough
    $('.walkthrough-slider').owlCarousel({
        items: true,
        loop: false,
        nav: true,
        marign: 0,
        dots: true,
        navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        onTranslated: function(event) {
            console.dir(event)
            if((event.item.count - 1) <= event.item.index) {
                $("[data-click=next]").show();
            } else {
                $("[data-click=next]").hide();
            }
        }
    });

    // all slider
    $(".slide-show").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: true,
        autoplay: true
    });

    $('.menu-link').bigSlide({
        menu: '#menu',
        side: 'left',
        easyClose: true,
        menuWidth: '260px',
        afterOpen: function(){
        $('body').addClass('menu-open');
        },
        afterClose: function(){
        $('body').removeClass('menu-open');
        }
    });

    // slider home
    $(".slide-show-home").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: true
    });    

    // testimonial
    $(".testimonial-slide").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        autoplay: true,
        loop: true
    });

    // product-d-slide
    $(".b-seller-slide").owlCarousel({
        items: 2,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        loop: false,
        margin: 10
    });

    // slide walkthrough
    $(".wt-slide").owlCarousel({
        items: 1,
        navigation: true,
        slideSpeed: 1000,
        dots: true,
        paginationSpeed: 400,
        singleItem: true,
        loop: false
    });

    // link to chat detail
    $('.wrap-chat-l .content-text').on('click', function() {
        window.location='chat-detail.html'
    });


});