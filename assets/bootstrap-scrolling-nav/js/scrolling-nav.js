$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $opcion = $(this);
        var $menu = $("#menu");
        var altura = 0;
        if ($menu.hasClass("navbar-fixed-top")) {
            altura = $($opcion.attr('href')).offset().top - 58;
        } else {
            altura = $($opcion.attr('href')).offset().top - 110;
        }
        if (altura !== $(document).scrollTop()) {
            $('html, body').stop().animate({
                scrollTop: altura + "px"
            }, 1600, 'easeInOutExpo');
        }
        $opcion.blur();
        event.preventDefault();
    });
});

$(window).scroll(function() {
    if ($(document).scrollTop() < $("#menu").offset().top) {
        $($("a.page-scroll").parent()).removeClass("active");
        $(".seccion").removeClass("active");
    }
    $(".seccion").each(function() {
        var distancia_seccion_arriba = $(this).offset().top - $(document).scrollTop();
        if (distancia_seccion_arriba < 60) {
            if (!$(this).hasClass("active")) {
                $(".seccion.active").removeClass("active");
                $(this).addClass("active");
                $($("a.page-scroll").parent(".active")).removeClass("active");
                $($("a.page-scroll[href=#" + $(this).attr("id") + "]").parent()).addClass("active");
            }
        }
    });
});