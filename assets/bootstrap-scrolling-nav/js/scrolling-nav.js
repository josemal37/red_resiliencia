$(function() {
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        if ($($anchor.attr('href')).offset().top !== $(document).scrollTop()) {
            $('html, body').stop().animate({
                scrollTop: $($anchor.attr('href')).offset().top - 100
            }, 1500, 'easeInOutExpo');
        }
        event.preventDefault();
    });
});
