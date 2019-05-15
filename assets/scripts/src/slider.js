jQuery(function ($) {
	'use strict';

	// no slider animations for < ie8
    if ( !$('body').is('.lt-ie8 .post-template-cambodia-signature-story' )) {
        if ( $('body').is('.post-template-cambodia-signature-story' )) {
            $('.element-slider_gallery').sliderGallery();
        }
    }
});

$.fn.sliderGallery = function() {
	'use strict';

	var $container = $(this),
			$rsContainer = $container.find('.element-slider_gallery'),
			$features = $container.find('.photo'),
			$nav = $('<div></div>'),
			offsetTop,
			rsInstance,
			navOutput;
    

	if ( !$rsContainer.length ) {
		//return;
	}

	//offsetTop = $rsContainer.offset().top;
    
  

	// init royalSlider
	$('.element-slider_gallery').royalSlider({
		loop: true,
		autoScaleSlider: true,
    autoScaleSliderWidth: 3,
    autoScaleSliderHeight: 1,
    imageScaleMode: 'fill',
    height: 300,
    width: 750,
    controlNavigation: 'bullets',
    arrowsNav: true,
    transitionType: 'fade',
    controlsInside: false,
    arrowsNavAutoHide: false,
    block: {
        fadeEffect: true,
    }
	});

	rsInstance = $rsContainer.data('royalSlider');

	$features.removeClass('loading');

	// start/stop autoplay when scrolling up or down past 
	// halfway point of feature
	//$(window).on( 'scroll', $.debounce( 200, function () {
	//	var scrollTop = $(window).scrollTop(),
//				rsContainerOffset = $rsContainer.offset().top,
	//			rsContainerHeight = $rsContainer.outerHeight(true);

		//if ( scrollTop > rsContainerOffset + ( rsContainerHeight / 2 ) ) {
	//		rsInstance.stopAutoPlay();
//		} else {
	//		rsInstance.startAutoPlay();
		//}
	//} ) );

	// set up nav links
	navOutput = '<ul>';

	$nav.addClass('features-nav');

	//for ( var i = 0, len = rsInstance.numSlides; i < len; i++ ) {
	//	navOutput += '<li><a href="#"><span>' + ( i + 1 ) + '</span></a></li>';
	//}

	navOutput += '</ul>';

	$nav.append( $(navOutput) );
	$nav.appendTo( $container );

	//$nav.find('a').eq( rsInstance.currSlideId ).addClass( 'active' );

	$nav.find('a').on( 'click', function (e) {
		e.preventDefault();
		$rsContainer.royalSlider( 'goTo', $(this).parent().index() );
		$nav.find('a').removeClass( 'active' );
		$(this).addClass( 'active' );
	} );

	// update nav on slide change
	//rsInstance.ev.on( 'rsAfterSlideChange', function () {
	//	$nav.find('a').removeClass( 'active' );
	//	$nav.find('a').eq( rsInstance.currSlideId ).addClass( 'active' );
	//} );

};