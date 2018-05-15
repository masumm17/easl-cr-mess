(function($){
    window.CRT = {
        $body: null,
        $wrap: null,
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
        scrollHeader: function() {
            if(!this.$body.hasClass('fixed-header')){
                return false;
            }
            if($(window).scrollTop() > 0) {
                !this.$body.hasClass('fixed-header-enabled') && this.$body.addClass('fixed-header-enabled');
            }else{
                this.$body.hasClass('fixed-header-enabled') && this.$body.removeClass('fixed-header-enabled');
            }
        },
        scrollEvents: function() {
            this.scrollHeader();
        },
        resizeFooter: function() {
            var h = $("#site-footer").outerHeight();
            this.$wrap.css({
                "padding-bottom": h + "px"
            });
        },
        resizeEevents: function() {
            this.resizeFooter();
        },
        events: function() {
            $(window).scroll($.proxy(this.scrollEvents, this));
            $(window).on("resize", CRT.debounce(function(){
                CRT.resizeEevents();
            }, 250));
        },
        init: function() {
            this.$body = $("body");
            this.$wrap = $("#cr-wrap");
            this.resizeFooter();
            this.scrollHeader();
            this.events();
        }
    };
    $(document).ready(function(){
        CRT.init();
    });
})(jQuery);
