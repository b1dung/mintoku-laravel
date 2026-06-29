jQuery(function ($) {
    $(function () {
        var topBanner = new Swiper(".topBanner", {
            lazy: true,
            loop: true,
            spaceBetween: 30,
            effect: "fade",
            simulateTouch: false,
            speed: 3000,
            autoplay: {
                delay: 3000,
                stopOnLastSlide: false,
                disableOnInteraction: false,
                reverseDirection: false
            },
        });
    });
});