(function($){
    /*! matchMedia() polyfill - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas, David Knight. MIT license */

    window.matchMedia || (window.matchMedia = function() {
        "use strict";

        // For browsers that support matchMedium api such as IE 9 and webkit
        var styleMedia = (window.styleMedia || window.media);

        // For those that don't support matchMedium
        if (!styleMedia) {
            var style       = document.createElement('style'),
                script      = document.getElementsByTagName('script')[0],
                info        = null;

            style.type  = 'text/css';
            style.id    = 'matchmediajs-test';

            if (!script) {
              document.head.appendChild(style);
            } else {
              script.parentNode.insertBefore(style, script);
            }

            // 'style.currentStyle' is used by IE <= 8 and 'window.getComputedStyle' for all other browsers
            info = ('getComputedStyle' in window) && window.getComputedStyle(style, null) || style.currentStyle;

            styleMedia = {
                matchMedium: function(media) {
                    var text = '@media ' + media + '{ #matchmediajs-test { width: 1px; } }';

                    // 'style.styleSheet' is used by IE <= 8 and 'style.textContent' for all other browsers
                    if (style.styleSheet) {
                        style.styleSheet.cssText = text;
                    } else {
                        style.textContent = text;
                    }

                    // Test if media query is true or false
                    return info.width === '1px';
                }
            };
        }

        return function(media) {
            return {
                matches: styleMedia.matchMedium(media || 'all'),
                media: media || 'all'
            };
        };
    }());
    function crRegexTestArray(regex, search) {
        for(var i = 0; i < search.length; i++) {
            if(regex.test(search[i])) {
                return true;
            }
        }
        return false;
    }
    function crDaysBetween( date1, date2 ){

        // The number of milliseconds in one day
        var ONE_DAY = 1000 * 60 * 60 * 24;

        // Convert both dates to milliseconds
        var date1_ms = date1.getTime();
        var date2_ms = date2.getTime();

        // Calculate the difference in milliseconds
        var difference_ms = Math.abs( date1_ms - date2_ms );

        // Convert back to days and return
        return Math.round( difference_ms / ONE_DAY );
    }
    function detectIE() {
        var ua = window.navigator.userAgent;

        // Test values; Uncomment to check result …

        // IE 10
        // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';

        // IE 11
        // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';

        // Edge 12 (Spartan)
        // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

        // Edge 13
        // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';

        var msie = ua.indexOf('MSIE ');
        if (msie > 0) {
          // IE 10 or older => return version number
          return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
        }

        var trident = ua.indexOf('Trident/');
        if (trident > 0) {
          // IE 11 => return version number
          var rv = ua.indexOf('rv:');
          return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
        }

        var edge = ua.indexOf('Edge/');
        if (edge > 0) {
          // Edge (IE 12+) => return version number
          return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
        }

        // other browser
        return false;
    }
    function CRCollapseBox($el, $tr) {
        this.$el = $el;
        this.$trigger = null;
        this.collapsed = false;
        this.collapsing = false;
        this.className = {
            COLLAPSE: "cr-collapse",
            SHOW: "cr-collapse-show",
            COLLAPSING:  "cr-collapsing",
            COLLAPSED: "cr-collapsed"
        };
        this.EventsName = {
            TRANSITION_END: "transitionEnd webkitTransitionEnd transitionend oTransitionEnd msTransitionEnd"
        };
        this.$el.removeClass(this.className.COLLAPSING).addClass(this.className.COLLAPSE);
        this.setTrigger($tr);
    };
    CRCollapseBox.prototype.show = function() {
        var ob = this;
        if(this.collapsing || this.$el.hasClass(this.className.SHOW)){
            return;
        }
        this.$el.removeClass(this.className.COLLAPSE).addClass(this.className.COLLAPSING);
        this.$trigger && this.$trigger.addClass("mobile-nav-arrow-flip");
        this.$el[0].style.height = 0;
        this.collapsing = true;
        this.$el.one(this.EventsName.TRANSITION_END, function(e) {
            ob.$el.removeClass(ob.className.COLLAPSING).addClass(ob.className.COLLAPSED).addClass(ob.className.SHOW);
            ob.$el[0].style.height = "";
            ob.collapsing = false;
        });
        this.$el[0].style.height = this.$el[0].scrollHeight + "px";
    };
    CRCollapseBox.prototype.hide = function() {
        var ob = this;
        if(this.collapsing || !this.$el.hasClass(this.className.SHOW)){
            return;
        }
        this.$el[0].style.height = this.$el[0].getBoundingClientRect().height + "px";
        this.$el[0].offsetHeight;
        this.$el.addClass(this.className.COLLAPSING).removeClass(this.className.COLLAPSE).removeClass(this.className.SHOW);
        this.$trigger && this.$trigger.removeClass("mobile-nav-arrow-flip");
        this.collapsing = true;
        this.$el.one(this.EventsName.TRANSITION_END, function(e) {
            ob.$el.removeClass(ob.className.COLLAPSING).addClass(ob.className.COLLAPSE);
            ob.collapsing = false;
        });
        this.$el[0].style.height = "";
    };
    CRCollapseBox.prototype.toggle = function() {
        if(this.$el.hasClass(this.className.SHOW)) {
            this.hide();
        }else{
            this.show();
        }
    };
    CRCollapseBox.prototype.setTrigger = function($tr) {
        var ob = this;
        var clickEvent = "click";
        if( $("html").hasClass("touchevents") ) {
            clickEvent = "touchstart";
        }
        if($tr && $tr.length){
            this.$trigger = $tr;
            this.$trigger.on(clickEvent, function(e) {
                e.preventDefault();
                ob.toggle();
            });
        }
    };
    
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
        $el.trigger("instagramfeedloaded");
        $el.waitForImages(function() {
            $el.addClass("cr-instagram-feed-image-loaded");
        })
            .find(".cr-instagram-feed-item")
            .waypoint(function() {
                $(this).addClass("cr_start_animation");
            },{offset:"96%"});
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
    CRInstagramFeed.prototype.fetchMedia = function() {
        var ob = this;
        var baseUrl = "https://api.instagram.com/v1/users/self/media/recent/?access_token=" + this.accesstoken + "&count=" + parseInt(this.number);
        $.ajax({
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
                    if ( (ob.feeds.length <= ob.number) &&  (response.data[i].type === "image") ) {
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
                if(this.vp.height < 768) {
                    this.$body.addClass("vp-lt-768");
                }else{
                    this.$body.removeClass("vp-lt-768");
                }
            }
            this.vp.scrollTop = $(window).scrollTop();
        },
        isIE: function() {
            return !!detectIE();
        },
        ieVersion: function() {
            return detectIE();
        },
        isMobile: function() {
            if(matchMedia && matchMedia('only screen and (max-width: 600px)').matches){
                return true;
            }
            return false;
        },
        isTabPort: function() {
            if(matchMedia && matchMedia('only screen and (min-width: 600px) and (max-width: 900px))').matches){
                return true;
            }
            return false;
        },
        isTab: function() {
            if(matchMedia && matchMedia('only screen and (min-width: 600px) and (max-width: 1365px))').matches){
                return true;
            }
            return false;
        },
        isMobileTabPort: function() {
            return this.isMobile() || this.isTabPort();
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
        mobileMenu: function() {
            var ob = this;
            $(".mobile-nav-arrow").each(function() {
                var $tr = $(this), $ul = $tr.siblings('.sub-menu');
                if($ul.length) {
                    new CRCollapseBox($ul, $tr);
                }
            });
        },
        bookingPanel: function() {
            
            var $el = $("#booking-panel"),
                $form = $('form', $el);
                $dummy = $("#residences-keyword-dummy", $el),
                $keywordWrap = $("#booking-panel-residences"),
                $residence = $("#residences-keyword", $el),
                $fieldsWrap = $(".booking-panel-fields", $el),
                $checkout = $("#booking-panel-departure-dummy", $el),
                $checkin = $("#booking-panel-checkin-dummy", $el), 
                $fieldDay = $("#booking-panel-day", $el),
                $fieldYM = $("#booking-panel-ym", $el),
                $fieldCI = $("#booking-panel-checkin", $el),
                $fieldNights = $("#booking-panel-nights", $el),
                $fieldPromo = $("#booking-panel-promo", $el),
                $fieldKeyword = $("#keyword", $el);
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
                        $fieldKeyword.val("*");
                        $form.addClass("booking-panel-keyword-error");
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
                        $form.removeClass("booking-panel-keyword-error");
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
                    if(this.currentResidene === item.value) {
                        $li.addClass("cr-state-active");
                    }
                    if(item.disable) {
                        $li.addClass("ui-state-disabled");
                    }
                    $li
                        .html(item.value)
                        .addClass("booking-panel-dd-item")
                        .data( "ui-autocomplete-item", item )
                        .appendTo(ul);
                },
                _resizeMenu: function() {
                    var wrapLi = this.menu.element.find(".booking-panel-dd-wrapli"),
                        wrap = this.menu.element.find(".booking-panel-dd-wrap");
                    this.menu.element.css({
                        width: this.panelCol.outerWidth(),
                        height: this.panelFields.outerHeight() - this.panelCol.outerHeight() - 3
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
                },
                _appendTo: function() {
                    var element = this.options.appendTo;

                    if ( element ) {
                        element = element.jquery || element.nodeType ?
                            $( element ) :
                            this.document.find( element ).eq( 0 );
                    }
                    if ( !element || !element[ 0 ] ) {
                        element = $( ".booking-panel-dd-position" );
                    }
                    
                    if ( !element || !element[ 0 ] ) {
                        element = this.element.closest( ".ui-front, dialog" );
                    }

                    if ( !element.length ) {
                        element = this.document[ 0 ].body;
                    }

                    return element;
                },
            });
            
            function crUpdateCalenderFields() {
                var d, m, y, n, dpCheckin, dpCheckout;
                dpCheckin = $checkin.datepicker("getDate");
                dpCheckout = $checkout.datepicker("getDate");
                d = dpCheckin.getDate();
                m = dpCheckin.getMonth() + 1;
                y = dpCheckin.getFullYear();
                $fieldDay.val(d);
                $fieldYM.val(y + '-' + m);
                $fieldCI.val(y + '-' + m + '-' + d);
                n = Math.max(1, crDaysBetween(dpCheckin, dpCheckout))
                $fieldNights.val(n);
            }
            
            $checkout.datepicker({
                dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],
                firstDay: 1,
                dateFormat: "dd MM yy",
                minDate: +1,
                onSelect: function(date, inst){
                    $checkout.removeClass("bp-date-picker-shown");
                    $("#bp-departure-date .booking-panel-day strong").html($.datepicker.formatDate( "dd", new Date(date) ));
                    $("#bp-departure-date .booking-panel-monthyear").html($.datepicker.formatDate( "MM yy", new Date(date) ));
                    crUpdateCalenderFields();
                }
            });
            $checkout.datepicker("setDate", 1 );
            $("#bp-departure-date .booking-panel-day strong").html($.datepicker.formatDate( "dd", $checkout.datepicker("getDate") ));
            $("#bp-departure-date .booking-panel-monthyear").html($.datepicker.formatDate( "MM yy", $checkout.datepicker("getDate") ));
            
            $checkin.datepicker({
                dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],
                firstDay: 1,
                dateFormat: "dd MM yy",
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
                    crUpdateCalenderFields();
                }
            });
            crUpdateCalenderFields();
            //$checkin.datepicker("setDate", 0 );
            $("#bp-arrival-date .booking-panel-day strong").html($.datepicker.formatDate( "dd", $checkin.datepicker("getDate") ));
            $("#bp-arrival-date .booking-panel-monthyear").html($.datepicker.formatDate( "MM yy", $checkin.datepicker("getDate") ));
            
            $("#bp-arrival-date").on("click", function(e) {
                $checkout.removeClass("bp-date-picker-shown");
                $(".booking-panel-select-box").removeClass("cr-show-selectbox");
                $checkin.toggleClass("bp-date-picker-shown");
            });
            $("#bp-departure-date").on("click", function(e) {
                $checkin.removeClass("bp-date-picker-shown");
                $(".booking-panel-select-box").removeClass("cr-show-selectbox");
                $checkout.toggleClass("bp-date-picker-shown");
            });
            $(".booking-panel-sb-trigger").on("click", function(e) {
                e.preventDefault();
                var $sb = $(this).closest(".booking-panel-col").find(".booking-panel-select-box");
                $checkin.removeClass("bp-date-picker-shown");
                $checkout.removeClass("bp-date-picker-shown");
                $(".booking-panel-select-box").not($sb).removeClass("cr-show-selectbox");
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
            if(!$residence.val()) {
                $keywordWrap.addClass("cr-booking-no-keyword");
            }else{
                $keywordWrap.removeClass("cr-booking-no-keyword");
            }
            $residence.on("change keyup", function(e) {
                if(!$residence.val()) {
                    $keywordWrap.addClass("cr-booking-no-keyword");
                }else{
                    $keywordWrap.removeClass("cr-booking-no-keyword");
                }
                $dummy.html($residence.val());
            }).bookingpanel({
                minLength: 0,
                source:BookingPanelData.source,
                position: {
                    my: "left top",
                    at: "left top",
                    of: $(".booking-panel-dd-position", $el)
                },
                open: function(event, ui) {
                    $checkin.removeClass("bp-date-picker-shown");
                    $checkout.removeClass("bp-date-picker-shown");
                    $(".booking-panel-select-box").removeClass("cr-show-selectbox");
                },
                select: function( event, ui ) {
                    $dummy.html(ui.item.value);
                    $fieldKeyword.val(ui.item.keyword);
                    $keywordWrap.removeClass("cr-booking-no-keyword");
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
                                    if( crRegexTestArray(matcher, item.search) ) {
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
            
            $form.on("submit", function(e) {
                var keyword = $fieldKeyword.val(), action = $fieldKeyword.find("option:selected").data("actionurl");
                $form.removeClass("booking-panel-action-error");
                if($form.hasClass("booking-panel-keyword-error")) {
                    console.log("No keyword found");
                    e.preventDefault();
                    return false;
                }
                
                if(!action) {
                   $form.addClass("booking-panel-action-error");
                    e.preventDefault();
                    return false;
                }
                
                $form.attr( "action", action);
                
                if ( keyword === "*" ) {
                    $form.append( '<input type="hidden" name="fw_submitted" id="fw_submitted" value="1" />' );
                }else if ( keyword === 'KNIGHTSBRIDGE' || keyword === 'KENSINGTON' || keyword === 'SLOANE' || keyword === 'CITY' ) {
                    $form.append( '<input type="hidden" name="fw_submitted" id="fw_submitted" value="1" />' );
                }
                if ( 
                    ( action.match( '/portal/' ) || [ ] ).length === 1 ||
                    ( action.match( '/sda.php' ) || [ ] ).length === 1 ||
                    ( action.match( '/mda.php' ) || [ ] ).length === 1 
                ){

                } else if ( $fieldPromo.val() ) {
                    $form.append( '<input type="hidden" name="fw_submitted" id="fw_submitted" value="1" />' );
                    $form.append( '<input type="hidden" name="av" id="av" value="promo" />' );
                } else
                {
                    $form.append( '<input type="hidden" name="fw_submitted" id="fw_submitted" value="1" />' );
                    $form.append( '<input type="hidden" name="av" id="av" value="search" />' );
                }
                window._gaq = window._gaq || [ ];
                window._gaq.push( [ '_linkByPost', $form.get( 0 ) ] );
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
            if(this.isTabPort()) {
                this.$body.css({
                "padding-bottom": "0px"
            });
            }
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
            
            var clickEvent = "click";
            if( $("html").hasClass("touchevents") ) {
                clickEvent = "touchstart";
            }
            $(window).scroll($.proxy(this.scrollEvents, this));
            $(window).on("resize", CRT.debounce(function(){
                CRT.resizeEevents();
            }, 250));
            $(".mobile-menu-humburger").on(clickEvent, function() {
                ob.$body.toggleClass("cr-mobile-menu-active");
            });
            $(".cr-menu-level-1 > li").on("mouseenter", function() {
                $(this).addClass("on-hover").removeClass("not-hover").siblings("li").removeClass("on-hover").addClass("not-hover");
            }).on("mouseleave", function() {
                var $t = $(this);
                if($t.hasClass("menu-item-has-children")) {
                    $t.closest(".menu-item-depth-0").addClass("tertiary-menu-strecthed");
                } else {
                    $t.closest(".menu-item-depth-0").removeClass("tertiary-menu-strecthed");
                }
                $(this).removeClass("on-hover").siblings("li").removeClass("not-hover");
            });
            $(".menu-item-depth-0").on("mouseleave", function() {
                $(this).removeClass("tertiary-menu-strecthed");
            });
            $(".booking-panel-trigger").on("click", function(e) {
                e.preventDefault();
                ob.$body.addClass("booking-panel-shown");
            });
            $(".booking-panel-close").on("click", function(e) {
                e.preventDefault();
                ob.$body.removeClass("booking-panel-shown");
            });
            
            $(".cr-scroll-up").on("click", function(e) {
                e.preventDefault();
                $('html, body').animate({ 
                    scrollTop: 0
                }, 750, 'linear');
            });
            
        },
        timeLine: function() {
            $(".sticky-side-nav").length && setTimeout(function(){
                $(".sticky-side-nav").addClass("sticky-side-nav-collasped");
            }, 5000);
        },
        instagramMobSlider: function($con) {
            if("undefined" === typeof $.fn.slick){
                return;
            }
            if(!this.isMobileTabPort()){
                $con.hasClass("cr-instagram-slider-activated") && $con.removeClass("cr-instagram-slider-activated").slick("unslick");
                return;
            }
            !$con.hasClass("cr-instagram-slider-activated") && $con.addClass("cr-instagram-slider-activated").slick({
                speed: 700,
                infinite: true,
                //centerMode: true,
                //centerPadding: '10%',
                //slidesToShow: 1,
                slidesToScroll: 1
                //prevArrow: $slider.closest(".property-slider-inner").find(".property-slider-arrow-left"),
                //nextArrow: $slider.closest(".property-slider-inner").find(".property-slider-arrow-right"),
            });
        },
        instagramFeed: function() {
            var ob = this;
            $(".cr-instagram-feed-wrap").on("instagramfeedloaded", function() {
                var $con = $(this).find(".cr-instagram-feed-con");
                ob.instagramMobSlider($con);
                $(window).on("resize", CRT.debounce(function(){
                    ob.instagramMobSlider($con);
                }, 250));
            }).each(function(){
                if($(this).hasClass("cr-fetch-feed")){
                    new CRInstagramFeed($(this));
                }else{
                    $(this).trigger("instagramfeedloaded");
                    $(this).waitForImages(function() {
                        $(this).addClass("cr-instagram-feed-image-loaded");
                    })
                        .find(".cr-instagram-feed-item")
                        .waypoint(function() {
                            $(this).addClass("cr_start_animation");
                        },{offset:"96%"});
                }
            });
        },
        init: function() {
            this.$body = $("body");
            this.$wrap = $("#cr-wrap");
            this.$menu = $("#menu-header-primary");
            this.$footer = $("#site-footer");
            this.$footerLine = $("#footer-top-line");
            if(this.isIE()) {
                this.$body.addClass("cr-ie " + "cr-ie" + this.ieVersion());
            }
            this.setViewPort();
            this.mobileMenu();
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
        var imagesLoaded = false, heroSliderLoaded = false, heroVideoLoaded = true;
        
        function crLoadPage() {
            if(imagesLoaded && heroSliderLoaded && heroVideoLoaded) {
                CRT.init();
                CRT.$body.addClass("page-loaded");
                CRT.hidePreloader();
            }
        }
        if("undefined" === typeof $.fn.revolution){
            heroSliderLoaded = true;
            heroVideoLoaded = true;
        }
        if($(".cr-rev-slider").length > 0) {
            $(".cr-rev-slider").one("revolution.slide.onloaded", function(e) {
                heroSliderLoaded = true;
                crLoadPage();
            });
        }else{
            heroSliderLoaded = true;
            heroVideoLoaded = true; 
        }
//        if($(".cr-background-video-layer").length > 0) {
//            $(".cr-background-video-layer").closest(".cr-rev-slider").one("revolution.slide.onvideoplay", function(e) {
//                heroVideoLoaded = true;
//                crLoadPage();
//            });
//        }else{
//            heroVideoLoaded = true; 
//        }
        $("body").waitForImages(function() {
            imagesLoaded = true;
            crLoadPage();
        });
    });
})(jQuery);
