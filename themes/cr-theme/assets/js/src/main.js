(function($){
    window.CRT = {
        $body: null,
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
        events: function() {
            $(window).scroll($.proxy(this.scrollEvents, this));
        },
        init: function() {
            this.$body = $("body");
            this.events();
        }
    };
    $(document).ready(function(){
        CRT.init();
    });
})(jQuery);
