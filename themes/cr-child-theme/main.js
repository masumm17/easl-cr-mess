(function($){
    window.CRT = {
        $body = null,
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
            console.log($(window).scrollTop());
            if(!this.$body.hasClass('fixed-header')){
                return false;
            }
            if($(window).scrollTop() > 0) {
                !this.$body.hasClass('fixed-header-enabled') && this.$body.addClass('fixed-header-enabled');
            }else{
                this.$body.hasClass('fixed-header-enabled') && this.$body.removelass('fixed-header-enabled');
            }
        },
        scrollEvents: function() {
            this.scrollHeader();
        },
        events: function() {
            console.log("Event niti");
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
