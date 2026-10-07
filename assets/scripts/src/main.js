jQuery(function ($) {
    var $heroVideo = $('#hero-video');
    var $playPauseHero = $('.play-pause-hero');

    if ($heroVideo.length && $playPauseHero.length) {
        var video = $heroVideo.get(0);
        var initialAutoPauseTimer = null;
        var didInitialAutoPause = false;
        var prefersReducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        function shouldServeHeroHighResVideo() {
            if (prefersReducedMotion) {
                return false;
            }

            if (!window.matchMedia || !window.matchMedia('(min-width: 1024px)').matches) {
                return false;
            }

            var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
            if (connection && connection.saveData) {
                return false;
            }

            if (connection) {
                if (connection.effectiveType === 'slow-2g' || connection.effectiveType === '2g' || connection.effectiveType === '3g') {
                    return false;
                }

                if (connection.effectiveType === '4g' || connection.effectiveType === '5g' || (connection.downlink && connection.downlink >= 8)) {
                    return true;
                }
            }

            return true;
        }

        function loadHeroVideoSource() {
            var highResSrc = $heroVideo.attr('data-high-res-src');
            var defaultSrc = $heroVideo.attr('data-default-src') || $heroVideo.find('source').first().attr('src');

            if (prefersReducedMotion || !highResSrc || !defaultSrc || !shouldServeHeroHighResVideo()) {
                return;
            }

            if (video.currentSrc && video.currentSrc.indexOf(highResSrc) !== -1) {
                return;
            }

            video.src = highResSrc;
            video.load();
        }

        function setHeroProgress() {
            if (!video || !isFinite(video.duration) || !video.duration) {
                return;
            }

            $playPauseHero[0].style.setProperty('--hero-video-progress', ((video.currentTime / video.duration) * 100) + '%');
        }

        function setHeroButtonState(isPlaying) {
            if (isPlaying) {
                $playPauseHero.html('<i class="fi-pause">▐▐</i>');
                $playPauseHero.attr('aria-label', 'Pause background video');
                $playPauseHero.attr('title', 'Pause background video');
            } else {
                $playPauseHero.html('<i class="fi-play"> ►</i>');
                $playPauseHero.attr('aria-label', 'Play background video');
                $playPauseHero.attr('title', 'Play background video');
            }
        }

        function syncHeroVideoVisibility() {
            var isPaused = video.paused || video.ended;
            $heroVideo.toggleClass('is-paused', isPaused);
            $heroVideo.closest('.hero-wrapper').toggleClass('is-paused', isPaused);
        }

        function scheduleInitialAutoPause() {
            if (didInitialAutoPause || initialAutoPauseTimer) {
                return;
            }

            initialAutoPauseTimer = setTimeout(function () {
                initialAutoPauseTimer = null;
                didInitialAutoPause = true;

                if (!video.paused) {
                    video.pause();
                }

                setHeroButtonState(false);
                setHeroProgress();
            }, 40000);
        }

        if (prefersReducedMotion) {
            video.pause();
            video.removeAttribute('autoplay');
            setHeroButtonState(false);
            setHeroProgress();
            syncHeroVideoVisibility();
        } else {
            loadHeroVideoSource();
            setHeroButtonState(!video.paused);
            syncHeroVideoVisibility();

            if (!video.paused) {
                scheduleInitialAutoPause();
            }
        }

        $heroVideo.on('loadedmetadata timeupdate play pause ended', function () {
            setHeroProgress();
            syncHeroVideoVisibility();
        });
        $heroVideo.on('play', function () {
            setHeroButtonState(true);
            syncHeroVideoVisibility();
            scheduleInitialAutoPause();
        });
        $heroVideo.on('pause ended', function () {
            setHeroButtonState(false);
            syncHeroVideoVisibility();
        });

        if (video.readyState >= 1) {
            setHeroProgress();
            syncHeroVideoVisibility();
        }

        $playPauseHero.on('click', function () {
            if (video.paused) {
                setHeroButtonState(true);
                video.play();
            } else {
                video.pause();
                setHeroButtonState(false);
            }

            setHeroProgress();
            syncHeroVideoVisibility();
        });
    }

    /**
     * Handle responsive videos
     */
    $.fn.handleFitVids = function () {
        'use strict';

        $(this).fitVids();

        $('.fluid-width-video-wrapper').each( function () {
            var $this = $(this),
                    maxWidth = parseFloat( $this.css('max-width') ),
                    paddingTop = parseFloat( $this[0].style['padding-top'] );

            // increase padding-top relative to max-width set on this element
            var adjustment = maxWidth * ( paddingTop * 0.01 ) + '%';

            $this.css( 'padding-top', adjustment );
        } );
    };

    /**
     * Faculty member tabs
     */

    $.fn.memberTabs = function () {
        'use strict';

        var $nav = $(this),
            $tabs = $('.Faculty-member-tabs'),
            activeClass = 'active-tab';

        $nav.find('a').click( function (e) {
            e.preventDefault();

            var $navItem = $(this),
                    $tab = $tabs.find('.' + $(this).attr('data-tab') );

            $nav.find('.' + activeClass).removeClass( activeClass );
            $(this).parent('li').addClass( activeClass );

            $tabs.find('.' + activeClass).removeClass( activeClass );
            $tab.addClass( activeClass );
        } );
    };
    
    if ($('body').is('.postid-62064, .post-template-cambodia-signature-story')) {
        $("html").addClass("smooth-scroll");
        autoplay = true;
        var ppbutton = $('.play-pause-hero');
        var poster = $('.poster');
        var hero = $('#hero-video');
        ppbutton.html('<i class="fi-pause">▐▐</i>');
        hero.removeClass("fullfade");
        if (window.matchMedia('(prefers-reduced-motion)').matches) {
            hero.removeAttribute("autoplay");
            hero.get(0).pause()
            hero.addClass("fade");
            console.log(poster);
            poster.removeClass("poster-hidden");
            ppbutton.html('<i class="fi-play"> ►</i>');
            autoplay = false;
        }
        ppbutton.click(function () {
            hero.toggleClass("fade");
            hero.get(0).pause()
            if (autoplay == null || autoplay === false) {
                $(this).html('<i class="fi-pause">▐▐</i>');
                hero.get(0).play()
                autoplay = true;
                ppbutton.html('<i class="fi-pause">▐▐</i>');
                $('.poster').addClass('poster-hidden');
                
                setTimeout(function(){
                    hero.get(0).pause()
                    hero.addClass("fade");
                    ppbutton.html('<i class="fi-play"> ►</i>');
                    autoplay = false;
                    $('.poster').removeClass("poster-hidden");
                }, 40000);
            } else {
                $(this).html('<i class="fi-play"> ►</i>');
                hero.get(0).pause()
                autoplay = false;
                $('.poster').removeClass("poster-hidden");
            }
        });
        $(ppbutton).keypress(function(e){
            if(e.which == 13){//Enter key pressed
                $(ppbutton).click();//Trigger search button click event
            }
        });
        setTimeout(function(){
                hero.get(0).pause()
                hero.addClass("fade");
                ppbutton.html('<i class="fi-play"> ►</i>');
                $('.poster').removeClass("poster-hidden");
                autoplay = false;
        }, 40000);
};
});

/**
 * Close UW Alert
 */

jQuery(document).ready(function($) {
    function closeUWAlert () {
      if($('#uwalert-alert-message').is(':hidden')){ //if the container is visible on the page
        if ($('#uwalert-alert-message')){
            $('#uwalert-alert-header').append('<div class="button right" id="closer">X</div>');
            var alertHeading = $('#uwalert-alert-header')[0];
            $('#closer').on('click', function(e){
                $('#uwalert-alert-message').removeClass('please-unhide');
                $('#uwalert-alert-message').hide();
                localStorage.clicked = alertHeading.innerHTML;
            });
            if(localStorage.clicked === alertHeading.innerHTML){
                console.log('UW Alert is hidden ' + localStorage.clicked);
                $('#uwalert-alert-message').hide();
            } else {
                $('#uwalert-alert-message').addClass('please-unhide');
            }
        }
      } else {
        setTimeout(closeUWAlert, 50); //wait 50 ms, then try again
      }
    }

    closeUWAlert();

   var $el, $ps, $up, totalHeight;

    $(".article__content .read-more .button").on('click', function() {

      totalHeight = 0

      $el = $(this);
      $p  = $el.parent();
      $up = $p.parent();
      $ps = $up.find("p:not('.read-more')");
      $e  = $up.find(".external");

      // measure how tall inside should be by adding together heights of all inside paragraphs (except read-more paragraph)
      $ps.each(function() {
        totalHeight += $(this).outerHeight(true);
      });
      totalHeight += $e.outerHeight(true) + 10;

      $up
        .animate({
          "max-height": 9999
        });

      // fade out read-more
      $p.fadeOut();

      // prevent jump-down
      return false;

    });

});

jQuery(function ($) {
	'use strict';

	if ( !$('body').hasClass('lt-ie8') ) {

		// placeholders for older browsers
		$('input, textarea').placeholder();

		// fitvids for responsive videos
		$('article').fitVids();

		// single faculty member tabs
		$('.Faculty-member-tab-nav').memberTabs();
		
		// share buttons
		$('.share').coenvshare();

        // header search toggle
        var $searchToggle = $('.search-toggle');
        var $searchWrapper = $('#header-search-form');

        if ( $searchToggle.length && $searchWrapper.length ) {
            $searchToggle.on('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var isOpen = $searchWrapper.hasClass('is-open');
                $searchWrapper.toggleClass('is-open', !isOpen);
                $searchToggle.attr('aria-expanded', !isOpen);
                $searchWrapper.attr('aria-hidden', isOpen);

                if ( !isOpen ) {
                    $searchWrapper.find('input[type="search"], input[type="text"]').first().focus();
                }
            });

            $(document).on('click', function (e) {
                if ( !$(e.target).closest('.search-toggle, #header-search-form').length ) {
                    $searchWrapper.removeClass('is-open').attr('aria-hidden', true);
                    $searchToggle.attr('aria-expanded', false);
                }
            });

            $(document).on('keydown', function (e) {
                if ( e.key === 'Escape' || e.keyCode === 27 ) {
                    $searchWrapper.removeClass('is-open').attr('aria-hidden', true);
                    $searchToggle.attr('aria-expanded', false);
                }
            });
        }
      
    //$('a').each(function () { //outbound link tracking
    //    if( location.hostname === this.hostname || !this.hostname.length ) {
    //    } else {
    //        var href = $(this).attr('href');
    //        var func = 'trackOutboundLink("' + href + '");';
    //        $(this).attr('onclick', func);
    //    }
    //});
		
		// lightbox
		$('a:not([href*=youtube]):not([href*=youtu]):not([href*=vimeo])').nivoLightbox();
        
        $('figure a img').each(function () {
            var $this = $(this);
            var $caption = $(this).closest('figure').attr('title');
            $this.parent().attr('title', $caption);
		});
        
        $('div.gallery img').each(function () {
            var $this = $(this);
            $this.parent().attr('title', $this.attr('alt'));
		});

        // split galleries using parent id 
		$('div.gallery a').each(function () {
            var $this = $(this);
            $this.attr('data-lightbox-gallery', $this.closest('div').attr('id'));
		});
        
        if ( $('body').hasClass('post-type-archive-faculty') ) {
        
            // custom scrollbar
            $('.js .faculty-toolbox-roller-items').mCustomScrollbar({
                autoHideScrollbar: false,
                setHeight:175,
                theme: 'minimal-dark',
                scrollInteria: 1,
            });

            // scroll to selection
            $('.js .faculty-toolbox-roller-items').mCustomScrollbar(
                'scrollTo', '.Faculty-toolbox-roller-item--active'
            );
        }
        
        $('.Faculty-member-contact-list').click(function(event){
            event.stopPropagation();
        });

	}
    
});

jQuery("document").ready(function($){
	
	var nav = $('#careers-filter');
	
	$(window).scroll(function () {
		if ($(this).scrollTop() > 355) {
			nav.addClass("f-nav");
		} else {
			nav.removeClass("f-nav");
		}

        // distance from top of footer to top of document
        footertotop = ($('#footer').position().top);
        // distance user has scrolled from top, adjusted to take in height of sidebar (850 pixels inc. padding)
        scrolltop = $(document).scrollTop()+850;
        // difference between the two
        difference = scrolltop-footertotop;

        // if user has scrolled further than footer,
        // pull sidebar up using a negative margin

        if (scrolltop > footertotop) {
            nav.css('margin-top',  0-difference);
        } else  {
            nav.css('margin-top', 0);
        }
	});
 
    
});




