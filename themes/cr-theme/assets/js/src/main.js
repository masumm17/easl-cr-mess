(function($){
    window.CRT = {
        vp: {width: null, height: null, scrollTop: null},
        $body: null,
        $wrap: null,
        $menu: null,
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
        setViewPort: function(scroll) {
            scroll = scroll || false;
            if(!scroll) {
                this.vp.width = $(window).width();
                this.vp.height = $(window).height();
            }
            this.vp.scrollTop = $(window).scrollTop();
        },
        isMobile: function() {
            if(this.vp.width <= 767) {
                return true;
            }
            return false;
        },
        isTab: function() {
            if(this.vp.width <= 1024 && this.vp.width >= 768) {
                return true;
            }
            return false;
        },
        isMobileTab: function() {
            return this.isMobile() || this.isTab();
        },
        resetMenuProps: function() {
            this.$menu.find(".cr-menu-level-1.cr-menu-level-inline").css({
                "left": "auto",
                "right": "auto"
            });
        },
        setMenuProp: function() {
            if(this.isMobileTab()){
                this.resetMenuProps();
            }else{
                var o = this;
                this.$menu.find(".cr-menu-level-1.cr-menu-level-inline").each(function() {
                   var  $ul = $(this), 
                        $pl = $ul.closest("li"), 
                        plW = $pl.width(), 
                        plL = $pl.offset().left, 
                        ulW = 0, 
                        ulL = $ul.offset().left,
                        plC = plL + plW/2,
                        L, R;
                    $ul.find(">li").each(function() {
                        ulW += $(this).outerWidth();
                    });
                    
                    R = plC + ulW/2 > o.vp.width ? 0 : "auto";
                    L = plC - ulW/2 < 0 ? 0 : R === 0 ? "auto" : plC - ulW/2;
                    if(L === 0 && R === 0){
                        ulW = "auto";
                    }
                    $ul.css({
                        "width": ulW,
                        "left": L + "px",
                        "right": R + "px"
                    });
                    
                });
            }
        },
        scrollHeader: function() {
            if(!this.$body.hasClass('fixed-header')){
                return false;
            }
            if(this.vp.scrollTop > 0) {
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
            if(this.vp.scrollTop > footerTop + 50) {
                !this.$footer.hasClass('cr-animate-footer') && this.$body.addClass('cr-animate-footer');
            }else{
                this.$footer.hasClass('cr-animate-footer') && this.$body.removeClass('cr-animate-footer');
            }
        },
        scrollEvents: function() {
            this.setViewPort(true);
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
            this.setViewPort();
            this.setMenuProp();
            this.resizeFooter();
        },
        events: function() {
            $(window).scroll($.proxy(this.scrollEvents, this));
            $(window).on("resize", CRT.debounce(function(){
                CRT.resizeEevents();
            }, 250));
            $(".cr-menu-level-1 > li").on("mouseenter", function() {
                $(this).addClass("on-hover").removeClass("not-hover").siblings("li").removeClass("on-hover").addClass("not-hover");
            }).on("mouseleave", function() {
                console.log($(this));
                $(this).removeClass("on-hover").siblings("li").removeClass("not-hover");
            });
        },
        init: function() {
            this.setViewPort();
            this.$body = $("body");
            this.$wrap = $("#cr-wrap");
            this.$menu = $("#menu-header-primary");
            this.$footer = $("#site-footer");
            this.$footerLine = $("#footer-top-line");
            this.setMenuProp();
            this.resizeFooter();
            this.scrollHeader();
            this.events();
        }
    };
    $(document).ready(function(){
        CRT.init();
    });
})(jQuery);
