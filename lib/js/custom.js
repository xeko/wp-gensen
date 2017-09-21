jQuery(document).ready(function ($) {
    var slider = $('#main-slider');
    $(slider).bxSlider({
        speed: 800,
        captions: false,
        pager: false,
        auto: true,
        pause: 6000,
        autoHover: true,
        adaptiveHeight: true,
        useCSS: true,
        mode: 'fade',
        easing: 'easeInOutCubic',
        controls: true,
        nextText: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
        prevText: '<i class="fa fa-angle-left" aria-hidden="true"></i>'
    });
    // Set options
    var options = {
        offset: '#content',
        offsetSide: 'top',
        classes: {
            clone: 'navbar--clone',
            stick: 'navbar--stick',
            unstick: 'navbar--unstick'
        }
    };
    // Initialise with options
    new Headhesive('.navbar', options);
    $(".tabs-menu a").click(function (event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
//        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
    $('.item').matchHeight();
    //Back to top
    var showFlag = false;
    var topBtn = $('.pagetop');
    topBtn.css('bottom', '-100px');
    var showFlag = false;
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            if (showFlag === false) {
                showFlag = true;
                topBtn.stop().animate({'bottom': '20px'}, 500);
            }
        } else {
            if (showFlag) {
                showFlag = false;
                topBtn.stop().animate({'bottom': '-100px'}, 500);
            }
        }
    });
    topBtn.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
    //Menu
    $('button.navbar-toggle').click(function () {
        if ($(this).next().is(":hidden")) {
            $('.navbar-toggle').removeClass('open');
            $(this).addClass('open');
            $('.menu_togglein').slideUp(300);
            $(this).next().slideToggle(300);
        } else {
            $(this).removeClass('open');
            $('.menu_togglein').slideUp(300);
        }
    });
    //Sub Menu
    $('#gnav .menu-item-has-children a').click(function () {
//        if ($(this).next().css("visibility") === "visible") {            
//            $(this).next().css({"visibility": "hidden", "max-height":"0"}, "slow");            
//        } else {
//            $(".sub-menu").css({"visibility": "hidden", "max-height":"0"}, "slow");
//            $(this).next().css({"visibility": "visible", "max-height":"500px"}, "slow");
//        }
    });
    var sel_config = {
        '.chosen-area': {placeholder_text_single: "エリアから選ぶ", allow_single_deselect: true},
        '.chosen-feature': {max_selected_options: 2}
    };
    for (var selector in sel_config) {
        $(selector).chosen(sel_config[selector]);
    }
    $("#filter input[type=checkbox]").on("change", function (e) {
        e.preventDefault();
        $("#filter").submit();
    });
    
    //Instagram
    $('#list-gal').bxSlider({
        slideWidth: 230,
        minSlides: 2,
        maxSlides: 5,
        slideMargin: 0,
        auto: true,
        speed: 1000,
        controls: true,
        pause: 10000,
        captions: false,
        pager: false,
        nextText: '<i class="fa fa-angle-right" aria-hidden="true"></i>',
        prevText: '<i class="fa fa-angle-left" aria-hidden="true"></i>'
    });
    
});

