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
                    centerMode: true,
                    centerPadding: '10%',
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    prevArrow: $slider.closest(".property-slider-inner").find(".property-slider-arrow-left"),
                    nextArrow: $slider.closest(".property-slider-inner").find(".property-slider-arrow-right"),
                });
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
        events: function() {
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
            this.YoutubeVideosFrames();
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
    $(document).ready(function(){
        ChevRes.init();
    });
})(jQuery);
