(function($){
    
    window.ChevRes = {
        debounce: function (func, wait, immediate) {
            var timeout;
            return function() {
                var context = this, args = arguments;
                var later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                var callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func.apply(context, args);
            };
        },
        waypoint: function() {
            if("undefined" === typeof $.fn.waypoint){
                return;
            }
            $('.cr-animate-when-visible').waypoint(function() {
                $(this).addClass("cr_start_animation")
            },{offset:"85%"});
        },
        heroSlider: function() {
            if("undefined" === typeof $.fn.revolution){
                return;
            }
            $(".cr-rev-slider").each(function() {
                var $slider = $(this), delay = $slider.data("crdelay");
                delay = delay || 4000;
                $slider.closest('.wpb_row').addClass('cr-row-has-hero-slider');
                $slider.show().revolution({
                    delay: delay,
                    sliderLayout: "fullscreen",
                    lazyType: "smart",
                    spinner: "spinner2",
                });
            });
        },
        propertySlider: function() {
            if("undefined" === typeof $.fn.slick){
                return;
            }
            $(".property-slider-con").each(function(){
                var $slider = $(this);
                $slider.slick({
                    infinite: true,
                    centerMode: true,
                    centerPadding: '10%',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    prevArrow: $slider.closest(".property-slider-inner").find(".property-slider-arrow-left"),
                    nextArrow: $slider.closest(".property-slider-inner").find(".property-slider-arrow-right")
                });
            });
        },
        events: function() {
            
        },
        init: function() {
            this.heroSlider();
            this.waypoint();
            this.propertySlider();
            this.events();
        }
    };
    $(document).ready(function(){
        ChevRes.init();
    });
})(jQuery);
