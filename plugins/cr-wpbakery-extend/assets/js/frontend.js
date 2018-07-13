if (!Object.is) {
  Object.is = function(x, y) {
    // SameValue algorithm
    if (x === y) { // Steps 1-5, 7-10
      // Steps 6.b-6.e: +0 != -0
      return x !== 0 || 1 / x === 1 / y;
    } else {
     // Step 6.a: NaN == NaN
     return x !== x && y !== y;
    }
  };
}
if (!String.prototype.padStart) {
    String.prototype.padStart = function padStart(targetLength,padString) {
        targetLength = targetLength>>0; //truncate if number or convert non-number to 0;
        padString = String((typeof padString !== 'undefined' ? padString : ' '));
        if (this.length > targetLength) {
            return String(this);
        }
        else {
            targetLength = targetLength-this.length;
            if (targetLength > padString.length) {
                padString += padString.repeat(targetLength/padString.length); //append to original to ensure we are longer than needed
            }
            return padString.slice(0,targetLength) + String(this);
        }
    };
}
(function($){
    function escapeHtml(string) {
        var entityMap = {
          "&": "&amp;",
          "<": "&lt;",
          ">": "&gt;",
          '"': "&quot;",
          "'": "&#39;",
          "/": "&#x2F;",
          "`": "&#x60;",
          "=": "&#x3D;"
        };

        return String(string).replace(/[&<>"'`=\/]/g, function(s) {
          return entityMap[s];
        });
    }
    function crArrayUnion(arr1, arr2) {
        var result = [], merged = arr1.concat(arr2);
        for(i = 0; i < merged.length; i++) {
            if(result.indexOf(merged[i]) === -1){
               result.push(merged[i]);
            }
        }
        return result;
    }
    function crArrayIntersection(arr1, arr2) {
        var result = [];
        if(!Array.isArray(arr1) || !Array.isArray(arr2)) {
            return false;
        }
        for(i = 0; i < arr1.length; i++) {
            if(arr2.indexOf(arr1[i]) !== -1){
               result.push(arr1[i]);
            }
        }
        return result;
    }
    function crArrayIntersected(arr1, arr2) {
        if(!Array.isArray(arr1) || !Array.isArray(arr2)) {
            return false;
        }
        for(i = 0; i < arr1.length; i++) {
            if(arr2.indexOf(arr1[i]) !== -1){
               return true;
            }
        }
        return false;
    }
    function AccommodationFilter($el) {
        this.$el = $el;
        this.$list = $el.find(".accommodations-list");
        this.termsData = {};
        this.filters = {location: -1, roomtype: -1, amenity: -1};
        this.lastState = {location: -1, roomtype: -1, amenity: -1};
        this.requesting = false;
        this.init();
    };
    AccommodationFilter.prototype.loadData = function() {
        var ob = this;
        $(".accommodations-filter-options", this.$el).each(function() {
            var $ul = $(this),
                taxonomy = $ul.data("taxonomy");
            ob.termsData[taxonomy] = {};
            $ul.find("li").each(function() {
                var $li = $(this),
                    id = parseInt($li.data("id")),
                    ids = '' + $li.data("ids");
                if(id !== -1 && ids.length > 0) {
                    ids = ids.length > 0 ? ids.split(",") : [];
                    ids = $.map(ids, function(n, i) {
                        return parseInt(n);
                    });
                    ob.termsData[taxonomy][id] = {
                        id: id,
                        ids: ids,
                        taxonomy: taxonomy
                    };
                }
            });
            
        });
    };
    AccommodationFilter.prototype.getRestrictedIds = function(filterType) {
        var restrictedIDs = [], counter = 0;
        for(var f in this.filters) {
            if(f === filterType) {
                continue;
            }
            if(this.filters[f] === -1) {
                continue;
            }
            counter ++;
            if(counter === 1) {
                restrictedIDs = this.termsData[f][this.filters[f]].ids;
            }else{
                restrictedIDs = crArrayIntersection(restrictedIDs, this.termsData[f][this.filters[f]].ids);
            }
        }
        return restrictedIDs;
    };
    AccommodationFilter.prototype.updateFiltersView = function(filterType) {
        var toHide = [], toShow = [], restrictedIDs = [], selectedFilter = [];
        for(var f in this.filters) {
            restrictedIDs = this.getRestrictedIds(f);
            for( var i in this.termsData[f]) {
                if(restrictedIDs.length === 0) {
                    toShow.push('[data-id="' + this.termsData[f][i].id + '"]');
                    continue;
                }
                if(!crArrayIntersected(restrictedIDs, this.termsData[f][i].ids)) {
                    toHide.push('[data-id="' + this.termsData[f][i].id + '"]');
                } else {
                    toShow.push('[data-id="' + this.termsData[f][i].id + '"]');
                }
            }
        }
        toHide = $(toHide.join(","));
        toShow = $(toShow.join(","));
        toHide.addClass("cr-filter-hide");
        toShow.removeClass("cr-filter-hide");
    };
    AccommodationFilter.prototype.events = function() {
        var ob = this;
        $(".accommodations-filter-selected", this.$el).on("click", function(e) {
            var $filter = $(this).closest(".accommodations-filter");
            $filter.hasClass("show-options") ? $filter.removeClass("show-options") : $filter.addClass("show-options");
        });
        $(".accommodations-filter-options li", this.$el).on("click", function(e) {
            var $li = $(this), 
                $list = $li.closest(".accommodations-filter-options"),
                $filter = $li.closest(".accommodations-filter"),
                $t = $filter.find(".accommodations-filter-selected"), 
                selectedID, filterType;
            if($li.hasClass("selected-option")){
                $filter.removeClass("show-options");
                return;
            }
            $list.find("li").removeClass("selected-option");
            $li.addClass("selected-option");
            $t.find(".accommodations-filter-selected-name").html($li.text());
            $filter.removeClass("show-options");

            selectedID = parseInt($li.data("id"));
            filterType = $filter.data("type");
            if(filterType && (typeof ob.filters[filterType] !== "undefined") ) {
                ob.filters[filterType] = selectedID;
                ob.updateFiltersView(filterType);
            }
        });
        $(".accommodations-filter-button", this.$el).on("click", function(e) {
            e.preventDefault();
            if(ob.requesting) {
                return;
            }
            //if(JSON.stringify(ob.lastState) === JSON.stringify(ob.filters)) {
            //    return;
            //}
            ob.lastState = $.extend({}, ob.filters);
            var filterData = {};
            filterData.action = "cr_get_accommodations";
            if(ob.filters.location > 0) {
                filterData.acmf_location = [ob.filters.location];
            }
            if(ob.filters.roomtype > 0) {
                filterData.acmf_room_type = [ob.filters.roomtype];
            }
            if(ob.filters.amenity > 0) {
                filterData.acmf_amenities = [ob.filters.amenity];
            }
            ob.requesting = true;
            ob.$el.addClass("cr-ajax-loading");
            ob.$list.html("");
            $.ajax({
                url: crSettings.ajaxURL,
                method: "get",
                data: filterData,
                dataType: "json",
                success: function(response){
                    ob.requesting = false;
                    if(!response || !response.status){
                        console.log("Failed!");
                        return;
                    }
                    if("NOTOK" === response.status){
                        ob.$list.html(response.msg);
                        return;
                    }
                    ob.$el.removeClass("cr-ajax-loading");
                    ob.$list
                        .html(response.html)
                        .find(".cr-animate-when-visible")
                        .waypoint(function(direction) {
                            $(this).addClass("cr_start_animation");
                        },{offset:"85%"});
                }
            }).fail(function() {
                ob.requesting = false;
                console.log("Failed!");
            });
        });
    };
    AccommodationFilter.prototype.init = function() {
        this.loadData();
        this.events();
    };
    window.ChevRes = {
        defaults: {
            YT: {
                autoplay: 0,
                autohide: 1,
                modestbranding: 1,
                rel: 0,
                showinfo: 0,
                controls: 0,
                disablekb: 1,
                enablejsapi: 0,
                iv_load_policy: 3,
                loop: 1
            }
        },
        Storage: {
            
        },
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
            }//triggerOnce: !0
            $('.cr-animate-when-visible').each(function(){
                var $el = $(this), reversible = $el.hasClass("cr-animate-bothway");
                if(!reversible) {
                    $el.waypoint(function(direction) {
                        $el.addClass("cr_start_animation");
                    },{offset:"85%"});
                }else{
//                    $el.waypoint(function(direction) {
//                        if(direction === "down") {
//                            console.log("Entering");
//                            // Entering from Bottom of the view port
//                            $el.addClass("cr_start_animation");
//                        }else{
//                            console.log("Exiting");
//                            $el.removeClass("cr_start_animation");
//                        }
//                    }, {
//                        offset: "100%", triggerOnce: false
//                    });
                    $el.waypoint(function(direction) {
                        if(direction === "up") {
                            // Exiting from bottom of the window
                            $el.removeClass("cr_start_animation");
                        }
                        if(direction === "down") {
                            // Exiting from bottom of the window
                            $el.addClass("cr_start_animation");
                        }
                    }, {
                        offset: "bottom-in-view", triggerOnce: false
                    });
                }
                    
            });
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
                    //delay: delay,
                    sliderLayout: "fullscreen",
                    lazyType: "all",
                    spinner: "spinner2"
                });
            });
        },
        propertySlider: function() {
            if("undefined" === typeof $.fn.slick){
                return;
            }
            $(".property-slider-con").each(function(){
                var $slider = $(this);
                $slider.on("beforeChange", function(event, slick, currentSlide){
                    $(this).removeClass("property-slider-start-animate");
                }).on("afterChange init", function(event, slick, currentSlide){
                    $(this).addClass("property-slider-start-animate");
                }).slick({
                    speed: 700,
                    infinite: true,
                    //centerMode: true,
                    //centerPadding: '10%',
                    //slidesToShow: 1,
                    slidesToScroll: 1,
                    prevArrow: $slider.closest(".property-slider-inner").find(".property-slider-arrow-left"),
                    nextArrow: $slider.closest(".property-slider-inner").find(".property-slider-arrow-right"),
                });
            });
        },
        miniGridGallery: function() {
            var o = this;
            o.Storage.MiniGridGalleries = {};
            $(".mini-gallery-slider").each(function(){
                var $gallery = $(this),
                    $pagination = $gallery.siblings(".mini-gallery-slider-pagination"),
                    $current = $pagination.find(".mg-current"),
                    galleryId = $gallery.attr("id"), 
                    galleryEffect = $gallery.data("effect"), 
                    gallerySpeed = parseInt($gallery.data("speed")),
                    galleryPagination = $gallery.data("pagination"),
                    effectRandom = false,
                    imageSlider = null;
                if(galleryId){
                    galleryEffect = galleryEffect ? '' + galleryEffect : "13";
                    if(galleryEffect === "random") {
                        galleryEffect = "13,17,14,7";
                        effectRandom = true;
                    }
                    
                    gallerySpeed = gallerySpeed ? gallerySpeed : 4000;
                    
                    var options = {
                        sliderId: galleryId,
                        startSlide: 0,
                        effect: galleryEffect,
                        effectRandom: effectRandom,
                        pauseTime: gallerySpeed,
                        transitionTime: 500,
                        slices: 8,
                        boxes: 7,
                        hoverPause: 2,
                        autoAdvance: true,
                        thumbnailsWrapperId: null,
                        m: false,
                        license: "mylicense"
                    };
                    if(galleryPagination === "yes" && $pagination.length){
                        options.beforeSlideChange = function(args){
                        };
                        options.afterSlideChange = function(args){
                            $current.html(args[0] + 1);
                        };
                    }
                    imageSlider = new mcImgSlider(options);
                    o.Storage.MiniGridGalleries[galleryId] = imageSlider;
                    if(galleryPagination === "yes" && $pagination.length){
                        $current.html(1);
                        $pagination.removeClass("cr-hide");
                    }
                }
            });
        },
        lightbox: function() {
            if("undefined" === typeof $.fn.fancybox){
                return;
            }
            var shareTpl =  '' + 
                '<li>' + 
                    '<a target="_blank" class="cr-lightbox-share-icon-pin" href="https://www.pinterest.com/pin/create/button/?url={{url}}&description={{descr}}&media={{media}}"></a>' +
                '</li><li>' +     
                    '<a target="_blank" class="cr-lightbox-share-icon-tw" href="https://twitter.com/intent/tweet?url={{url}}&text={{descr}}"></a>' + 
                '</li><li>' +  
                    '<a target="_blank" class="cr-lightbox-share-icon-fb" href="https://www.facebook.com/sharer/sharer.php?u={{url}}"></a>' +
                '</li>';
            $.fancybox.defaults.btnTpl.crshare = '<div class="cr-lightbox-share">' +
                '<button data-fancybox-crshare class="fancybox-button fancybox-button--crshare cr-lightbox-share-button" title="Share"></button>' + 
                '<ul class="cr-lightbox-share-icons">' +
                   
                '</ul>' + 
            '</div>';
            $(".cr-fancybox-minimum").fancybox({
                infobar: false,
                loop: true,
                idleTime: 10,
                //toolbar: false,
                buttons: ["close"],
                animationDuration: 500,
                transitionEffect: "fade",
                transitionDuration: 500,
                btnTpl: {
                    arrowLeft:
                        '<a data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}" href="javascript:;">' +
                        '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16.625px" height="18.125px" viewBox="0 0 16.625 18.125" enable-background="new 0 0 16.625 18.125" xml:space="preserve">' +
                            '<g>' + 
                                '<polyline fill="none" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.667,17.227 7.564,9.125 15.667,1.023"/>' + 
                                '<polyline fill="none" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.667,17.227 1.564,9.125 9.667,1.023"/>' + 
                            '</g>' + 
                        '</svg>' + 
                        '<span></span>' +
                        "</a>",

                    arrowRight:
                        '<a data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}" href="javascript:;">' +
                        '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16.625px" height="18.125px" viewBox="0 0 16.625 18.125" enable-background="new 0 0 16.625 18.125" xml:space="preserve">' +
                            '<g>' + 
                                '<polyline fill="none" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="1.667,1.023 9.769,9.125 1.667,17.227"/>' + 
                                '<polyline fill="none" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="7.666,1.023 15.769,9.125 7.666,17.227"/>' + 
                            '</g>' + 
                        '</svg>' + 
                        '<span></span>' +
                        "</a>"
                },
                
            });
            $(".cr-gallery-slider").fancybox({
                infobar: true,
                loop: true,
                idleTime: 100,
                buttons: ["close", "crshare"],
                animationDuration: 500,
                transitionEffect: "fade",
                transitionDuration: 500,
                // Base template for layout
                baseTpl:
                  '<div class="fancybox-container" role="dialog" tabindex="-1">' +
                  '<div class="fancybox-bg"></div>' +
                  '<div class="fancybox-inner">' +
                  '<div class="fancybox-infobar">' +
                  "<span data-fancybox-index></span>/<span data-fancybox-count></span>" +
                  "</div>" +
                  '<div class="fancybox-toolbar">{{buttons}}</div>' +
                  '<div class="fancybox-navigation">{{arrows}}</div>' +
                  '<div class="fancybox-stage"></div>' +
                  '<div class="fancybox-caption"></div>' +
                  "</div>" +
                  "</div>",
                btnTpl: {
                    arrowLeft:
                        '<a data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}" href="javascript:;">' +
                        '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16.625px" height="18.125px" viewBox="0 0 16.625 18.125" enable-background="new 0 0 16.625 18.125" xml:space="preserve">' +
                            '<g>' + 
                                '<polyline fill="none" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="15.667,17.227 7.564,9.125 15.667,1.023"/>' + 
                                '<polyline fill="none" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.667,17.227 1.564,9.125 9.667,1.023"/>' + 
                            '</g>' + 
                        '</svg>' + 
                        '<span></span>' +
                        "</a>",

                    arrowRight:
                        '<a data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}" href="javascript:;">' +
                        '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="16.625px" height="18.125px" viewBox="0 0 16.625 18.125" enable-background="new 0 0 16.625 18.125" xml:space="preserve">' +
                            '<g>' + 
                                '<polyline fill="none" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="1.667,1.023 9.769,9.125 1.667,17.227"/>' + 
                                '<polyline fill="none" stroke="#FFFFFF" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="7.666,1.023 15.769,9.125 7.666,17.227"/>' + 
                            '</g>' + 
                        '</svg>' + 
                        '<span></span>' +
                        "</a>"
                },
                caption: function(instance, item) {
                    return $(this).closest(".cr-gallery-item-inner").find(".cr-gallery-item-caption").html();
                },
                afterShow: function(instance, item) {
                    var $container = instance.$refs.container,
                        url,
                        caption,
                        current = instance.current || null,
                        $nextButton = $("[data-fancybox-next]"),
                        $prevButton = $("[data-fancybox-prev]");
                    
                    if ($.type(current.opts.share.url) === "function") {
                        url = current.opts.share.url.apply(current, [instance, current]);
                    }
                    caption = instance.$caption ? encodeURIComponent(instance.$caption.find(".cr-lightbox-caption-title").text()) : "";
                    var shareTplParsed = shareTpl.replace(/\{\{media\}\}/g, current.type === "image" ? encodeURIComponent(current.src) : "")
                        .replace(/\{\{url\}\}/g, encodeURIComponent(url))
                        .replace(/\{\{url_raw\}\}/g, escapeHtml(url))
                        .replace(/\{\{descr\}\}/g, caption);
                    $container.find(".cr-lightbox-share-icons").html(shareTplParsed);
                    if(instance.group.lengthn < 2){
                        return;
                    }
                    var currPos = instance.currPos % instance.group.length, prevPos, nextPos;
                    if(currPos === 0) {
                        prevPos = instance.group.length - 1;
                        nextPos = 1;
                    } else if(currPos < 0) {
                        prevPos = instance.group.length + currPos - 1;
                        nextPos = (instance.group.length + currPos + 1) % instance.group.length;
                    } else {
                        prevPos = currPos - 1;
                        nextPos = (currPos + 1) % instance.group.length;
                    }
                    
                    var prevImgSrc, nextImgSrc;
                    prevImgSrc = instance.group[prevPos].opts.$orig.closest(".cr-gallery-item-inner").find('.cr-gallery-item-image').attr("src");
                    nextImgSrc = instance.group[nextPos].opts.$orig.closest(".cr-gallery-item-inner").find('.cr-gallery-item-image').attr("src");
                    $prevButton.find("span").css("background-image", "url('" + prevImgSrc + "')");
                    $nextButton.find("span").css("background-image", "url('" + nextImgSrc + "')");
                }
            });
        },
        miniGalleryGridResize: function() {
            if (typeof this.Storage.MiniGridGalleries === 'undefined'){
                return;
            }
            for(var sliderID in ChevRes.Storage.MiniGridGalleries) {
                ChevRes.Storage.MiniGridGalleries[sliderID].reload();
            }
        },
        gallery: function() {
            if("undefined" === typeof $.fn.masonry){
                return;
            }
            $('.cr-gallery-isotope').each(function() {
                var $gallery = $(this);
                $gallery.waitForImages(function(){
                    $gallery.on("layoutComplete", function(e) {
                        $(".cr-gallery-item", $(this)).waypoint(function() {
                                $(this).addClass("cr_start_animation");
                            }, {
                                offset: '75%',
                                triggerOnce: true
                        });
                    }).masonry({
                        columnWidth: ".cr-gallery-item",
                        percentPosition: true,
                        itemSelector: ".cr-gallery-item",
                        //horizontalOrder: true,
                        resize: true
                    });
                });
                    
            });
        },
        accommodationFilter: function() {
           $(".accommodations-con").each(function() {
               new AccommodationFilter($(this));
           });
        },
        YoutubeVideosFrames: function() {
            var video_count = 0;
            
            ChevRes.Storage.YTPlayersData = {};
            ChevRes.Storage.YTPlayers = {};
            
            $(".cr-iframe-video").each(function() {
                var playerID;
                video_count++;
                playerID = "cr-youtube-player-" + video_count;
                $(this).data("playerid", playerID).append("<div id='"+ playerID +"'></div><span class='cr-yt-play-icon' id='play-"+ playerID +"'></span>");
                ChevRes.Storage.YTPlayersData[playerID] = $(this).data("videoid");
            });
            if(video_count && typeof YT === "undefined"){
                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
            }
        },
        createYTPlayer: function(playerID) {
            var $playerParent = $("#" + playerID).closest(".cr-iframe-video-parent");
            var player = this.Storage.YTPlayers[playerID] = new YT.Player(playerID, {
                height: '390',
                width: '640',
                videoId: this.Storage.YTPlayersData[playerID],
                playerVars: this.defaults.YT,
                events: {
                    "onReady": function(e) {
                        //if($playerParent.hasClass("cr-iframe-video-playalways"))
                        $playerParent.waypoint(function(direction) {
                            if(direction === "down") {
                                console.log("Entered from Down");
                                (window.innerWidth > 1024) && player.playVideo();
                                player.mute();
                            }
                            if(direction === "up") {
                                (window.innerWidth > 1024) && player.pauseVideo();
                                player.mute();
                            }
                        }, {
                            offset: "100%"
                        });
                        $playerParent.waypoint(function(direction) {
                            if(direction === "down") {
                                console.log("Exited from Down");
                                (window.innerWidth > 1024) && player.pauseVideo();
                                player.mute();
                            }
                            if(direction === "up") {
                                (window.innerWidth > 1024) && player.playVideo();
                                player.mute();
                            }
                        }, {
                            offset: function() {
                                return -$(this).outerHeight() + 100
                            }
                        });
                    },
                    "onStateChange": function(e){
                        if (e.data === YT.PlayerState.PLAYING) {
                            $playerParent.removeClass('cr-yt-not-started');
                        } else if (e.data === YT.PlayerState.ENDED) {
                            e.target.playVideo();
                            //$(e.target.a).closest(".cr-iframe-video-parent").addClass('cr-yt-ended');
                        } else if (e.data === -1) {
                            $playerParent.addClass('cr-yt-not-started');
                            //e.target.playVideo();
                        } else if (e.data === YT.PlayerState.PAUSED) {
                            $playerParent.addClass('cr-yt-paused');
                        }
                    }
                }
            });
        },
        rescaleYTPlayer: function(playerID) {
            var player = this.Storage.YTPlayers[playerID];
            var $playerParent = $(player.a).closest(".cr-iframe-video-parent");
            var $playerCon = $(player.a).closest('.cr-iframe-video');
            var w = $playerParent.width();
            var h = $playerParent.height();
            if (w/h > 16/9){
              $playerCon.css({
                  "height": w/16*9,
                  "width": w
              });
            } else {
              $playerCon.css({
                  "height": h,
                  "width": h/9*16
              });
            }
        },
        rescaleYTVideos: function() {
            if (typeof ChevRes.Storage.YTPlayers === 'undefined'){
                return;
            }
            for(var playerID in ChevRes.Storage.YTPlayers) {
                ChevRes.rescaleYTPlayer(playerID);
            }
        },
        maps: function() {
            if(typeof crMapData === "undefined" ||  !crMapData.KEY){
                return;
            }
            var map_count = 0;
            ChevRes.Storage.MapData = {
                appKey: crMapData.KEY,
                maps: {}
            };
            ChevRes.Storage.Maps = {};
            $(".cr-map").each(function(){
                var id = $(this).attr("id");
                if(id && crMapData && crMapData[id]){
                    map_count++;
                    ChevRes.Storage.MapData.maps[id] = crMapData[id];
                }
            });
            if(typeof google === "undefined" || typeof google.maps === "undefined"){
                if(map_count){
                    var tag = document.createElement('script');
                    tag.async = true;
                    tag.defer = true;
                    tag.src = "https://maps.googleapis.com/maps/api/js?key=" + ChevRes.Storage.MapData.appKey + "&callback=crInitMaps";
                    var firstScriptTag = document.getElementsByTagName('script')[0];
                    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                }
            }else{
                map_count && this.initMaps();
            }
        },
        initMaps: function() {
            if (typeof ChevRes.Storage.MapData === 'undefined'){
                return;
            }
            for(var mapID in ChevRes.Storage.MapData.maps) {
                ChevRes.createMap(mapID);
            }
            $(".cr-map-filter-icon").on("click", function(e){
                e.preventDefault();
                var $t = $(this), filterID = $t.data("filtername"), mapID = $t.data("mapid"), show = $t.hasClass("cr-map-marker-hidden");
                if(!mapID || !filterID){
                    return;
                }
                if(show){
                    return;
                }
                $t.addClass("cr-map-marker-hidden");
                $t.siblings().not($t).removeClass("cr-map-marker-hidden");
                if(ChevRes.Storage.Maps[mapID] === "undefined"){
                    return;
                }
                for(var i=0; i < ChevRes.Storage.Maps[mapID].markers.length; i++) {
                    var fid = ChevRes.Storage.Maps[mapID].markers[i].crFilterID;
                    ChevRes.Storage.Maps[mapID].markers[i].crInfoWindow.close();
                    ChevRes.Storage.Maps[mapID].markers[i].crInfoOpened = false;
                    if("nofilter" === fid){
                        continue;
                    }
                    if(filterID === fid){
                        !ChevRes.Storage.Maps[mapID].markers[i].getMap() && ChevRes.Storage.Maps[mapID].markers[i].setMap(ChevRes.Storage.Maps[mapID].map);
                    }else{
                        ChevRes.Storage.Maps[mapID].markers[i].setMap(null);
                    }
                    
                }
            });
        },
        markerContent: function(marker) {
            var html = "";
            html += '<div class="cr-map-infobox">';
                html += '<div class="cr-map-infobox-inner">';
                    html += '<h4 class="cr-map-infobox-title">' + marker.title + '</h4>';
                    html += '<div class="cr-map-infobox-text-image"><div class="cr-map-infobox-text-image-inner">';
                    if(marker.thumb) {
                        html += '<div class="cr-map-infobox-image">';
                        html += '<a href="' + marker.full_image + '"><img alt="" src="' + marker.thumb + '"/></a>';
                        html += '</div>';
                    }
                    if(marker.text) {
                        html += '<div class="cr-map-infobox-text">' 
                            html += '<p>' + marker.text + '</p>';
                            if(marker.cta_title) {
                                html += '<div class="cr-map-infobox-cta-wrap">';
                                    html += '<a class="cr-button-bordered" href="' + marker.cta_url + '"';
                                    if(marker.cta_nt === "yes") {
                                        html += ' target="_blank"';
                                    }
                                    html += '>' + marker.cta_title + '</a>';
                                html += '</div>';
                            }
                        html += '</div>';
                    }
                    html += '</div></div>';
                html += '</div>';
            html += '</div>';
            return html;
        },
        closeMapInfoboxes: function(mapID, index) {
            if(typeof ChevRes.Storage.Maps[mapID] === "undefined") {
                return;
            }
            var markers = ChevRes.Storage.Maps[mapID].markers;
            for(var i=0; i < markers.length; i++){
                if(markers[i].crMarkerIndex !== index) { 
                    markers[i].crInfoWindow.close();
                    markers[i].crInfoOpened = false;
                }
            }
        },
        createMap: function(mapID) {
            //ChevRes.Storage.Maps;
            var mapData = ChevRes.Storage.MapData.maps[mapID];
            ChevRes.Storage.Maps[mapID] = {
                map: null,
                markers: []
            };
            var map = new google.maps.Map(document.getElementById(mapID), {
                center: mapData.center,
                zoom: mapData.zoom,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                gestureHandling: "cooperative",
                //scrollwheel: false,
                styles: [
                    {
                      "featureType": "poi.business",
                      "stylers": [
                        {
                          "visibility": "off"
                        }
                      ]
                    },
                    {
                      "featureType": "poi.park",
                      "stylers": [
                        {
                          "visibility": "off"
                        }
                      ]
                    }
                  ]
            });
            for(var i = 0; i < mapData.markers.length; i++) {
                var marker = new google.maps.Marker({
                    map: map,
                    draggable: false,
                    position: {lat: mapData.markers[i].lat, lng: mapData.markers[i].lng},
                    icon: mapData.markers[i].icon,
                    zIndex: parseInt(mapData.markers[i].order)
                });
                marker.crMapID = mapID;
                marker.crMarkerIndex = i;
                marker.crFilterID = mapData.markers[i].filter ? mapData.markers[i].filter : "nofilter";
                ChevRes.Storage.Maps[mapID].markers.push(marker);
                marker.crInfoWindow = new google.maps.InfoWindow({
                    content: this.markerContent(mapData.markers[i]),
                    maxWidth: 425,
                    zIndex: 100
                });
                marker.crInfoOpened = false;
                marker.addListener('click', function() {
                    ChevRes.closeMapInfoboxes(this.crMapID, this.crMarkerIndex);
                    if(this.crInfoOpened){
                        this.crInfoWindow.close();
                        this.crInfoOpened = false;
                    }else{
                       this.crInfoWindow.open(this.getMap(), this); 
                       this.crInfoOpened = true;
                    }
                });
            }
            ChevRes.Storage.Maps[mapID].map = map;
        },
        resizeEevents: function() {
            this.miniGalleryGridResize();
            this.rescaleYTVideos();
        },
        events: function() {
            // Resize events
            $(window).on("resize", ChevRes.debounce(function(){
                ChevRes.resizeEevents();
            }, 250));
            // Expanding Images
            $(".expanding-image-item").on("mouseenter", function() {
                $(this).addClass("on-hover").removeClass("not-hover").siblings(".expanding-image-item").removeClass("on-hover").addClass("not-hover");
            }).on("mouseleave", function() {
                $(this).removeClass("on-hover").siblings(".expanding-image-item").removeClass("not-hover");
            });
            $(".expanding-image-item").on("touchstart", function() {
                $(this).toggleClass("on-hover");
            });
            $(".cr-scroll-down").on("click", function(e) {
                var $wrapp = $(this).closest(".cr-rev-slider-wrapper"), sh = $wrapp.offset().top + $wrapp.outerHeight() - $(".site-header").outerHeight();
                e.preventDefault();
                $('html, body').animate({ 
                    scrollTop: sh
                }, 500, 'linear');
            });
        },
        init: function() {
            this.heroSlider();
            this.waypoint();
            this.propertySlider();
            this.miniGridGallery();
            this.gallery();
            this.lightbox();
            this.YoutubeVideosFrames();
            this.maps();
            this.accommodationFilter();
            this.events();
        }
    };
    window.onYouTubeIframeAPIReady = function() {
        if (typeof ChevRes.Storage.YTPlayersData === 'undefined'){
            return;
        }
        for(var playerID in ChevRes.Storage.YTPlayersData) {
            ChevRes.createYTPlayer(playerID);
        }
        ChevRes.rescaleYTVideos();
    };
    window.crInitMaps = function() {
        ChevRes.initMaps();
    };
    $(document).ready(function(){
        ChevRes.init();
    });
})(jQuery);
