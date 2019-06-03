jQuery(function ($) {
    /**
     * Banner image reveals
     */
    $.fn.bannerReveals = function () {
        'use strict';

        return this.each( function () {

            var $container = $(this),
                    $revealBtn = $('.banner-info'),
                    activeClass = 'banner-revealed';



            $revealBtn.on( 'click', function ( e ) {
                e.preventDefault();
                e.stopPropagation();

                $('body').toggleClass( activeClass );
            } );

            $container.on( 'click', function () {
                if ( $('body').hasClass( activeClass ) ) {
                    $('body').removeClass( activeClass );
                }
            } );

        } );
    };

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
            poster.removeClass("visuallyhidden");
            ppbutton.html('<i class="fi-play"> ►</i>');
            autoplay = false;
        }
        ppbutton.click(function () {
            hero.toggleClass("fade");
            hero.get(0).pause()
            if (autoplay == null || autoplay === false) {
                $(this).html('<i class="fi-pause">▐▐</i>');
                hero.get(0).play()
                //$('.poster').addClass('visuallyhidden');
                autoplay = true;
                ppbutton.html('<i class="fi-pause">▐▐</i>');
                
                setTimeout(function(){
                    hero.get(0).pause()
                    hero.addClass("fade");
                    ppbutton.html('<i class="fi-play"> ►</i>');
                    autoplay = false;
                    //$('.poster').removeClass("visuallyhidden");
                }, 120000);
            } else {
                $(this).html('<i class="fi-play"> ►</i>');
                hero.get(0).pause()
                autoplay = false;
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
                $('.poster').removeClass("visuallyhidden");
                autoplay = false;
        }, 120000);
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

		// banner image reveals
		$('.banner-wrapper').bannerReveals();
		
		// share buttons
		$('.share').coenvshare();
		
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
        
        if ( $('body').hasClass('home') ) {
            var $boxes = $('.story-thung');
            $boxes.hide();

            $('.stories-container').imagesLoaded( function() {
                setTimeout(function(){ 
                    $boxes.fadeIn();
                    $('.stories-container').masonry({
                        // options
                        itemSelector: '.story',
                        columnWidth: '.story-sizer',
                        percentPosition: true
                    });
                }, 200);
                
            });
            
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




