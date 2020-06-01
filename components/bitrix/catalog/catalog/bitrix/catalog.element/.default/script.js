$(function () {


    $('.detail-left__slider .owl-carousel').owlCarousel({
        loop:false,
        margin:10,
        nav:false,
        dots:true,
        URLhashListener:true,
        autoplayHoverPause:true,
        startPosition: 'URLHash',
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
    $('.detail-left__slider .owl-carousel').on('changed.owl.carousel', function(e) {
        var hash = $('.detail-left__hash-link');
        hash.removeClass('active');
        $(hash[e.item.index]).addClass('active');
    });
    $(function(s) {
        var n;
        s(".tabs").on("click", "li:not(.active)", function() {
            n = s(this).parents(".tabs_block"), s(this).dmtabs(n)
        }), s.fn.dmtabs = function(n) {
            s(this).addClass("active").siblings().removeClass("active"), n.find(".box").eq(s(this).index()).show(1, function() {
                s(this).addClass("open_tab")
            }).siblings(".box").hide(1, function() {
                s(this).removeClass("open_tab")
            })
        }
    })
});