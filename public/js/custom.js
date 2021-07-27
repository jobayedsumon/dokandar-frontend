$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var URL = 'https://103.108.140.52/~dokandar/frontend/public';

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
