(function($){
    window.ChevRes = {
        defaults: {
            YT: {
                autoplay: 0,
                autohide: 0,
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
                    $el.waypoint(function(direction) {
                        if( direction === "down" ) {
                            $el.addClass("cr_start_animation");
                        }

                    },{offset:"75%", triggerOnce: false});
                    $el.waypoint(function(direction) {
                        if( direction === "up" ) {
                            $el.removeClass("cr_start_animation");
                        }

                    },{offset:"75%", triggerOnce: false});
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
            $(".cr-fancybox-minimum").fancybox({
                infobar: false,
                loop: true,
                //toolbar: false,
                buttons: ["close"],
                animationDuration: 500,
                transitionEffect: "fade",
                transitionDuration: 500
                
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
            var player = this.Storage.YTPlayers.playerID = new YT.Player(playerID, {
                height: '390',
                width: '640',
                videoId: this.Storage.YTPlayersData[playerID],
                playerVars: this.defaults.YT,
                events: {
                    "onReady": function(e) {
                        $(player.a).waypoint(function() {
                            (window.innerWidth > 1024) && player.playVideo();
                            player.mute();
                        }, {
                            offset: '75%',
                            triggerOnce: !0
                        })
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
                            $playerParent.addClass('cr-yt-not-paused');
                        }
                    }
                }
            });
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
                show ? $t.removeClass("cr-map-marker-hidden"): $t.addClass("cr-map-marker-hidden");
                
                if(ChevRes.Storage.Maps[mapID] === "undefined"){
                    return;
                }
                for(var i=0; i < ChevRes.Storage.Maps[mapID].markers.length; i++) {
                    var fid = ChevRes.Storage.Maps[mapID].markers[i].crFilterID;
                    if("nofilter" === fid){
                        continue;
                    }
                    if(filterID !== fid){
                        show ? ChevRes.Storage.Maps[mapID].markers[i].setMap(ChevRes.Storage.Maps[mapID].map):ChevRes.Storage.Maps[mapID].markers[i].setMap(null);
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
                zoom: 12
            });
            for(var i = 0; i < mapData.markers.length; i++) {
                var marker = new google.maps.Marker({
                    map: map,
                    draggable: false,
                    position: {lat: mapData.markers[i].lat, lng: mapData.markers[i].lng},
                    icon: mapData.markers[i].icon,
                });
                marker.crMapID = mapID;
                marker.crMarkerIndex = i;
                marker.crFilterID = mapData.markers[i].filter ? mapData.markers[i].filter : "nofilter";
                ChevRes.Storage.Maps[mapID].markers.push(marker);
                marker.crInfoWindow = new google.maps.InfoWindow({
                    content: this.markerContent(mapData.markers[i]),
                    maxWidth: 425,
                    setZIndex: 10
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
        },
        init: function() {
            this.heroSlider();
            this.waypoint();
            this.propertySlider();
            this.miniGridGallery();
            this.lightbox();
            this.YoutubeVideosFrames();
            this.maps();
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
    };
    window.crInitMaps = function() {
        ChevRes.initMaps();
    }
    $(document).ready(function(){
        ChevRes.init();
    });
})(jQuery);
