(function($){
    window.CRT = {
        $body: null,
        $wrap: null,
        $footer: null,
        $footerLine: null,
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
                !this.$body.hasClass('header-scrolled') && this.$body.addClass('header-scrolled');
            }else{
                this.$body.hasClass('header-scrolled') && this.$body.removeClass('header-scrolled');
            }
        },
        scrollFooter: function() {
            if(this.$footer.hasClass('cr-animate-footer')){
                return false;
            }
            var footerTop = this.$footerLine.offset().top - this.$footer.outerHeight();
            if($(window).scrollTop() > footerTop + 50) {
                !this.$footer.hasClass('cr-animate-footer') && this.$body.addClass('cr-animate-footer');
            }else{
                this.$footer.hasClass('cr-animate-footer') && this.$body.removeClass('cr-animate-footer');
            }
        },
        scrollEvents: function() {
            this.scrollHeader();
            this.scrollFooter();
        },
        resizeFooter: function() {
            var h = this.$footer.outerHeight();
            this.$body.css({
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
            this.$footer = $("#site-footer");
            this.$footerLine = $("#footer-top-line");
            this.resizeFooter();
            this.scrollHeader();
            this.events();
        }
    };
    $(document).ready(function(){
        CRT.init();
    });
})(jQuery);
