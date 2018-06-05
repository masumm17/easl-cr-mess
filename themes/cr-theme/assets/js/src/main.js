(function($){
    function CRInstagramFeed($el) {
        this.$el = $el;
        this.accesstoken = this.getData("secretkey");
        this.number = parseInt(this.getData("number")) * 2;
        this.ccenabled = this.getData("ccenabled");
        this.ccpos = parseInt(this.getData("ccpos"));
        
        
        this.feeds = [];
        this.fetchError = false;
        this.imageSize = "standard_resolution";
        if(this.accesstoken && this.number > 0){
            this.init();
        }
    }
    CRInstagramFeed.prototype.getData = function(key) {
        var data = this.$el.data(key);
        return typeof data !== "undefined" ? data : false;
    };
    CRInstagramFeed.prototype.parseItem = function(item) {
        var caption = (item.caption !== null) ? item.caption.text : "";
        var imgUrl = item.images[this.imageSize].url;
        return {
            id: item.id,
            caption: caption,
            url: imgUrl,
            likes: item.likes.count,
            comments: item.comments.count,
            plink: item.link,
            username: item.user.username
        };
    };
    CRInstagramFeed.prototype.displayFeed = function(html) {
        var $el = this.$el;
        $el.find(".cr-instagram-feed-con").html(html);
        $el.waitForImages(function() {
            $el.addClass("cr-instagram-feed-image-loaded");
        })
            .find(".cr-instagram-feed-item")
            .waypoint(function() {
                $(this).addClass("cr_start_animation");
            },{offset:"85%"});
    };
    CRInstagramFeed.prototype.updateFeeds = function() {
        var ob = this;
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: CRTSettings.ajaxURL,
            data: {
                action: "cr_update_instagram_feed_cache",
                feeds: ob.feeds
            },
            success: function (response) {
                if(typeof response !== "undefined" || response.status === "OK"){
                    ob.displayFeed(response.html);
                }
            },
            error: function (response) {
                console.log("Feed update errror");
            }
        });
    };
    CRInstagramFeed.prototype.fetchMedia = function(key) {
        var ob = this;
        var baseUrl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=" + this.accesstoken + "&count=" + parseInt(this.number);
        jQuery.ajax({
            type: 'POST',
            dataType: 'jsonp',
            url: baseUrl,
            success: function (response) {
                if(!response || typeof response === "undefined"){
                    ob.fetchError = true;
                    return;
                }
                if (response.meta.code !== 200) {
                    ob.fetchError = true;
                    return;
                }
                for (var i = 0; i < response.data.length; i++) {
                    if (response.data[i].type === "image") {
                        ob.feeds.push(ob.parseItem(response.data[i]));
                    }
                }
                ob.feeds.length > 0 && ob.updateFeeds();
            },
            error: function (response) {
                ob.fetchError = true;
            }
        });
    };
    CRInstagramFeed.prototype.init = function() {
        this.fetchMedia();
    };
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
        bookingPanel: function() {
            
            var $el = $("#booking-panel"), 
                $dummy = $("#residences-keyword-dummy", $el),
                $residence = $("#residences-keyword", $el),
                $fieldsWrap = $(".booking-panel-fields", $el),
                $keywordSelect = $("#keyword", $el);
            if(!$el.length || typeof BookingPanelData === "undefined") {
                return;
            }
            
            
            $.widget( "custom.bookingpanel", $.ui.autocomplete, {
                _create: function() {
                    var self = this;
                    this.currentResidene;
                    this.panelCol = this.element.closest(".booking-panel-col");
                    this.panelFields = this.element.closest(".booking-panel-fields");
                    this.scrollerWrap = this.panelFields.find(".booking-panel-dd-scroller");
                    this.errorMessage = this.element.data("errormessage");
                    this._super();
                    this.widget().menu( "option", "items", ".booking-panel-dd-item" );
                    this.menu.element.addClass('booking-panel-dd-menu');
                    this._on(this.element, {
                        bookingpanelopen: function(event, ui) {
                            self.menu.element.addClass("booking-panel-dd-menu-active");
                        },
                        bookingpanelclose: function(event, ui) {
                            self.menu.element.removeClass("booking-panel-dd-menu-active");
                        }
                    });
                 },
                _renderMenu: function(ul, columns) {
                    var self = this;
                    this.currentResidene = this.element.val();
                    var ul2 = $('<ul>').addClass("booking-panel-dd-wrap");
                    if(typeof columns.error !== "undefined" && columns.error) {
                        this.errorMessage && $("<li>").addClass("bookig-panel-dd-error").html(this.errorMessage.replace("%search_term%", "<strong>" + this._value() + "</strong>")).appendTo(ul2);
                        ul2.appendTo(ul);
                    }else{
                        $.each(columns, function(i, column) {
                            self._renderColumn(ul2, column);
                        });
                        if(ul2.find(">li").length>0) {
                            $("<li>").addClass("booking-panel-dd-wrapli").append(ul2).appendTo(ul);
                            $("<li>").addClass("booking-panel-dd-scroller").append("<span></span>").appendTo(ul);
                        }else{
                            this.errorMessage && $("<li>").addClass("bookig-panel-dd-error").html(this.errorMessage).appendTo(ul);
                        }
                    }
                    
                },
                _renderColumn: function(ul, column) {
                    var self = this;
                    var col = $('<li class="booking-panel-dd-col"></li>');
                    $.each(column, function(i, group) {
                        
                        var ul2 = $("<ul>").addClass("booking-panel-dd-group");
                        $.each(group.items, function(e, item) {
                            self._renderItem(ul2, item);
                        });
                        if(ul2.find(">li").length > 0) {
                            col.append('<span class="booking-panel-dd-group-name">' + group.groupName + '</span>');
                            col.append(ul2);
                        }
                    });
                    return col.appendTo(ul);
                },
                _renderItem: function(ul, item) {
                    var $li = $("<li>");
                    if(this.currentResidene === item.label) {
                        $li.addClass("cr-state-active");
                    }
                    if(item.disable) {
                        $li.addClass("ui-state-disabled");
                    }
                    $li
                        .html(item.label)
                        .addClass("booking-panel-dd-item")
                        .data( "ui-autocomplete-item", item )
                        .appendTo(ul);
                },
                _resizeMenu: function() {
                    var wrapLi = this.menu.element.find(".booking-panel-dd-wrapli"),
                        wrap = this.menu.element.find(".booking-panel-dd-wrap");
                    this.menu.element.css({
                        width: this.panelCol.outerWidth(),
                        height: this.panelFields.outerHeight() - this.panelCol.outerHeight() - 4
                    });
                    if(wrapLi.outerHeight() < wrap.outerHeight()){
                        wrapLi.mCustomScrollbar({
                            axis: "y"
                        });
                        this.menu.element.addClass("booking-panel-dd-hasscroller");
                        $(".booking-panel-dd-scroller span").on("click", function(e) {
                            e.preventDefault();
                            wrapLi.mCustomScrollbar("scrollTo", "-=" + wrapLi.outerHeight() );
                        });
                    }else{
                        this.menu.element.removeClass("booking-panel-dd-hasscroller");
                    }
                },
                __response: function( content ) {
                    if ( content ) {
                        content = this._normalize( content );
                    }
                    this._trigger( "response", null, { content: content } );
                    if ( !this.options.disabled && content && content.length && !this.cancelSearch ) {
                        this._suggest( content );
                        this._trigger( "open" );
                    } else {
                        this._suggest( {error: true} );
                        this._trigger( "open" );
                        // use ._close() instead of .close() so we don't cancel future searches
                        //this._close();
                    }
                }
            });
            $residence.bookingpanel({
                minLength: 0,
                source:BookingPanelData.source,
                position: {
                    my: "left top",
                    at: "left top",
                    of: $(".booking-panel-dd-position", $el)
                },
                select: function( event, ui ) {
                    $dummy.html(ui.item.label);
                    $keywordSelect.val(ui.item.value);
                },
                source: function( request, response ) {
                    var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                    var groupMatcher = new RegExp( '^' + $.ui.autocomplete.escapeRegex(request.term), "i" );
                    var suggestions = [];
                    $.each(BookingPanelData.column, function(colIndex, column) {
                        var col = [];
                        $.each(column, function(groupName, items) {
                            var cgroup = {}, gitems = [];
                            if( !request.term ||  groupMatcher.test(groupName) ) {
                                cgroup = {groupName: groupName, items: items};
                            }else{
                                $.each(items, function(itemIndex, item) {
                                    if( matcher.test(item.label) || matcher.test(item.value) ) {
                                        gitems.push(item);
                                    }
                                });
                                if(gitems.length > 0) {
                                    cgroup.groupName = groupName;
                                    cgroup.items = gitems;
                                }
                            }
                            if(typeof cgroup.items !== "undefined" && cgroup.items.length > 0) {
                                col.push(cgroup);
                            }
                        });
                        col.length > 0 && suggestions.push(col);
                    });
                    response(suggestions);
                  },
            });
            $el.find("#booking-panel-dd-keywords").on("click", function(e) {
                e.preventDefault();
                !$residence.bookingpanel( "widget" ).is( ":visible" ) ? $residence.bookingpanel( "search", "" ) : $residence.bookingpanel( "close" );
            });
            
            var $checkout = $("#booking-panel-departure-dummy").datepicker({
                dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],
                firstDay: 1,
                altField: "#booking-panel-departure",
                altFormat: "dd MM yy",
                minDate: +1,
                onSelect: function(date, inst){
                    $checkout.removeClass("bp-date-picker-shown");
                    $("#bp-departure-date .booking-panel-day strong").html($.datepicker.formatDate( "dd", new Date(date) ));
                    $("#bp-departure-date .booking-panel-monthyear").html($.datepicker.formatDate( "MM yy", new Date(date) ));
                }
            });
            $checkout.datepicker("setDate", 1 );
            $("#bp-departure-date .booking-panel-day strong").html($.datepicker.formatDate( "dd", $checkout.datepicker("getDate") ));
            $("#bp-departure-date .booking-panel-monthyear").html($.datepicker.formatDate( "MM yy", $checkout.datepicker("getDate") ));
            
            var $checkin = $("#booking-panel-checkin-dummy").datepicker({
                dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],
                firstDay: 1,
                altField: "#booking-panel-checkin",
                altFormat: "dd MM yy",
                minDate: 0,
                onSelect: function(date, inst){
                    if(date){
                        var dateObject = new Date(date);
                        dateObject.setDate(dateObject.getDate()+1);                                 
                        $checkout.datepicker("option", "minDate", dateObject);
                        $checkin.removeClass("bp-date-picker-shown");
                        
                        $("#bp-departure-date .booking-panel-day strong").html($.datepicker.formatDate( "dd", $checkout.datepicker("getDate") ));
                        $("#bp-departure-date .booking-panel-monthyear").html($.datepicker.formatDate( "MM yy", $checkout.datepicker("getDate") ));
                    }
                    $("#bp-arrival-date .booking-panel-day strong").html($.datepicker.formatDate( "dd", new Date(date) ));
                    $("#bp-arrival-date .booking-panel-monthyear").html($.datepicker.formatDate( "MM yy", new Date(date) ));
                }
            });
            //$checkin.datepicker("setDate", 0 );
            $("#bp-arrival-date .booking-panel-day strong").html($.datepicker.formatDate( "dd", $checkin.datepicker("getDate") ));
            $("#bp-arrival-date .booking-panel-monthyear").html($.datepicker.formatDate( "MM yy", $checkin.datepicker("getDate") ));
            
            $("#bp-arrival-date").on("click", function(e) {
                $checkin.toggleClass("bp-date-picker-shown");
            });
            $("#bp-departure-date").on("click", function(e) {
                $checkout.toggleClass("bp-date-picker-shown");
            });
            $(".booking-panel-sb-trigger").on("click", function(e) {
                e.preventDefault();
                var $sb = $(this).closest(".booking-panel-col").find(".booking-panel-select-box");
                $sb.toggleClass("cr-show-selectbox");
            });
            $(".booking-panel-select-box li").on("click", function(e) {
                e.preventDefault();
                var $li = $(this), val = $li.data('value');
                $li.siblings(".cr-sb-selected").not($li).removeClass("cr-sb-selected");
                $li
                    .addClass("cr-sb-selected")
                    .closest(".booking-panel-col")
                        .find(".booking-panel-sb-trigger strong")
                            .html($li.text())
                            .end()
                        .find("select").val($li.data('value'));
                $li.closest(".booking-panel-select-box").removeClass("cr-show-selectbox");
            });
            
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
            var footerTop = this.$footerLine.offset().top + this.$footer.outerHeight() - 100 ;
            if( (this.vp.scrollTop + this.vp.height) > footerTop) {
                !this.$body.hasClass('cr-animate-footer') && this.$body.addClass('cr-animate-footer');
            }else{
                this.$body.hasClass('cr-animate-footer') && this.$body.removeClass('cr-animate-footer');
            }
        },
        scrollEvents: function() {
            this.setViewPort(true);
            this.scrollHeader();
            this.scrollFooter();
        },
        resizeFooter: function() {
            var h = this.$footer.outerHeight(true);
            this.$body.css({
                "padding-bottom": h + "px"
            });
        },
        resizeEevents: function() {
            this.setViewPort();
            this.setMenuProp();
            this.resizeFooter();
        },
        hidePreloader: function() {
            $(".loading-animation").length && $(".loading-animation").fadeOut(250, function() {
                $(".loading-animation").remove();
            });
        },
        events: function() {
            var ob = this;
            $(window).scroll($.proxy(this.scrollEvents, this));
            $(window).on("resize", CRT.debounce(function(){
                CRT.resizeEevents();
            }, 250));
            $(".cr-menu-level-1 > li").on("mouseenter", function() {
                $(this).addClass("on-hover").removeClass("not-hover").siblings("li").removeClass("on-hover").addClass("not-hover");
            }).on("mouseleave", function() {
                $(this).removeClass("on-hover").siblings("li").removeClass("not-hover");
            });
            $(".booking-panel-trigger").on("click", function(e) {
                e.preventDefault();
                ob.$body.addClass("booking-panel-shown");
            });
            $(".booking-panel-close").on("click", function(e) {
                e.preventDefault();
                ob.$body.removeClass("booking-panel-shown");
            });
            $(window).on("load", $.proxy(function(){
                this.$body.addClass("page-loaded");
                this.hidePreloader();
                this.resizeFooter();
            }, this));
        },
        timeLine: function() {
            $(".sticky-side-nav").length && setTimeout(function(){
                $(".sticky-side-nav").addClass("sticky-side-nav-collasped");
            }, 5000);
        },
        instagramFeed: function() {
            $(".cr-instagram-feed-wrap").each(function(){
                if($(this).hasClass("cr-fetch-feed")){
                    new CRInstagramFeed($(this));
                }else{
                    $(this).waitForImages(function() {
                        $(this).addClass("cr-instagram-feed-image-loaded");
                    })
                        .find(".cr-instagram-feed-item")
                        .waypoint(function() {
                            $(this).addClass("cr_start_animation");
                        },{offset:"85%"});
                }
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
            this.bookingPanel();
            this.scrollHeader();
            this.events();
            this.timeLine();
            this.instagramFeed();
        }
    };
    $(document).ready(function(){
        CRT.init();
    });
})(jQuery);
