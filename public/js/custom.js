$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        items: 1,
        nav: true,
        navText: [
            "<i class='fa fa-caret-left'></i>",
            "<i class='fa fa-caret-right'></i>"
        ],
        loop: true,
        autoplay: true,
        autoplayTimeout:3000,
        responsive: {
            0: {
                items: 1
            }
        }
    });
});
