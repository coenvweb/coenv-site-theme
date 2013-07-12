jQuery(function ($) {
	'use strict';

	// only for faculty archive pages
	if ( !$('#faculty-archive').length ) {
		return;
	}

	// handle hash changes
//	$.fn.facultyHashChange();

	$('#faculty-archive .faculty-toolbox').facultyToolbox();

	// isotope for faculty tile grid
	$('#faculty-archive').find('.faculty-tiles').facultyIsotope();

	// handle theme roller
	$('.theme-roller').themeRoller();

	// tab navigation
//	$('#member-tab-nav').memberTabNav();

});

/**
 * Handle URL hashes for Faculty Archive
 */
$.fn.facultyHashChange = function() {
	'use strict';

	$('.theme-roller').on( 'themeChange', function ( e, theme ) {

		// update hash
		window.location.hash = theme.replace( 'theme-', '' );
	} );

};

/**
 * Set up Isotope for faculty tile grid
 */
$.fn.facultyIsotope = function() {
	'use strict';

	var $container = $(this),
			$themeRoller = $('.theme-roller'),
			$lazyImgs = $container.find('img.lazy');

	// lazyload images
	// http://stackoverflow.com/questions/11337291/combining-jquery-isotope-and-lazy-load/13919010#13919010
	$lazyImgs.show().lazyload({
		failure_limit: Math.max( $lazyImgs.length - 1, 0 )
	});

	// initialize isotope
	$container.isotope({
		itemSelector: '.jsIsotopeItem',
		masonry: {
			columnWidth: 133,
			cornerStampSelector: '.faculty-toolbox'
		}
	});

	// check for url hash
	if ( window.location.hash.length ) {
	//	filter = '.theme-' + window.location.hash.replace('#', '');
	}

	// listen for themeChange
	$themeRoller.on( 'themeChange', function ( event, theme ) {
		$container.isotope({
			filter: '.' + theme + ', .faculty-toolbox',
			onLayout: function () {
				$(window).trigger('scroll');
			}
		});
	});

};

/**
 * Handle Faculty Toolbox interactions
 */
$.fn.facultyToolbox = function() {
	'use strict';

	var $container = $(this),
			$toolbox = $container.find('.faculty-toolbox-tools'),
			$themeRoller = $container.find('.theme-roller'),
			$feedback = $container.find('.faculty-toolbox-feedback'),
			$facultyLink = $container.find('.faculty-toolbox-header a'),
			$showToolsButton = $container.find('.faculty-toolbox-more-search-tools a');

	$showToolsButton.click( function (e) {
		e.preventDefault();
		$(this).parent('.faculty-toolbox-more-search-tools').addClass('disable');
		$feedback.addClass('expanded');
		$toolbox.find('.faculty-toolbox-inner').addClass('show-tools');
	} );

	$facultyLink.click( function (e) {
		e.preventDefault();
		$showToolsButton.parent('.faculty-toolbox-more-search-tools').removeClass('disable');
		$feedback.removeClass('expanded');
		$toolbox.find('.faculty-toolbox-inner').removeClass('show-tools');
	} );

};

/**
 * Handle Faculty Theme Roller interaction
 */
$.fn.themeRoller = function() {
	'use strict';

	var $container = $(this),
			$interactionLayer = $container.find('.interaction-layer'),
			theme;

	function doSelect( $item ) {
		$('#select-theme').find('option[selected="selected"]').removeAttr('selected');
		$('#select-theme').find('option[value="' + $item.attr('data-theme') + '"]').attr('selected', 'selected');
	}

	function doFeedback( $item ) {
		$('.feedback-theme').text( $item.text() );
		$('.feedback-number').text( $item.attr('data-number') );
	}

	function getItems() {
		return $container.find('.theme-roller-item');
	}

	$container.procession({
		innerSelector: '.theme-roller-inner',
		itemSelector: '.theme-roller-item',
		orientation: 'vertical',
		origin: 'center',
		transitionDuration: 300,
		keyNav: true
	});

//	// check for url hash
//	if ( window.location.hash.length ) {
//		theme = 'theme-' + window.location.hash.replace('#', '');
//
//		var $item = $container.find('.theme-roller-item').filter(function () {
//			if ( $(this).attr('data-theme') === theme ) {
//				return $(this);
//			}
//		});
//
//		$item.click();
//		doFeedback( $item );
//		doSelect( $item );
//	}

	$container.dblclick( function (e) {
		e.preventDefault();
	} );

	// interactionLayer sits on top of theme roller
	// to intercept interactions
	$interactionLayer.click( function (e) {

		var posY = $(this).offset().top,
				clickY = e.pageY,
				$items = getItems(),
				coordinates = getCoordinates( $items ),
				targetIndex,
				$item;

		for ( var i = 0, len = $items.length; i < len; i++ ) {
			if ( clickY >= coordinates[i].rangeA && clickY < coordinates[i].rangeB ) {
				targetIndex = coordinates[i].index;
			}
		}

		$item = $items.eq( targetIndex );

		$container.trigger('themeChange', [ $item.attr('data-theme') ]);

		$item.click();
		doFeedback( $item );
		doSelect( $item );
	} );

	function getCoordinates( $items ) {
		var coordinates = [];
		$items.each( function () {
			var posY = $(this).offset().top;
			coordinates.push({
				index: $(this).index(),
				rangeA: posY,
				rangeB: posY + $(this).outerHeight()
			});
		} );
		return coordinates;
	}
};

/**
 * Handle tab navigation for faculty member profiles
 */
$.fn.memberTabNav = function() {
	'use strict';

	var $nav = $(this),
			$tabs = $('.member-tabs'),
			activeClass = 'active-tab';

	$nav.find('a').click( function(e) {
		e.preventDefault();

		var $navItem = $(this),
				$tab = $tabs.find('.' + $(this).attr('data-tab') );

		$tabs.find('.' + activeClass).removeClass(activeClass);
		$tab.addClass(activeClass);
	} );
};