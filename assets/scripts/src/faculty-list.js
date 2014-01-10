/**
 * Faculty list
 *
 * Acts on the .Faculty-list element (faculty index page).
 *
 * - Isotope filter and sort
 * - LazyLoading images
 */
(function ($, window, document, undefined) {
	'use strict';

	var CoEnvFacultyList = function () {
		this.init();
	};

	CoEnvFacultyList.prototype = {
		// General container for the faculty list page
		$facultyList: $('.Faculty-list'),

		// Container for faculty items (members)
		// Isotope acts on this
		$itemContainer: $('.Faculty-list-content'),

		// Individual items (members)
		$items: $('.Faculty-list-item'),
		itemSelector: '.Faculty-list-item'
	};

	/**
	 * Initialization
	 *
	 * Kick-off everything that happens on initialization here.
	 */
	CoEnvFacultyList.prototype.init = function () {

		// keep track of window height and scrolltop
		this.trackWindow();

		// save item offsets
		this.itemOffsets();

		// lazy load images
		this.lazyloader();

		// initialize isotope
		this.isoInit();
	};

	/**
	 * Track window height and scrolltop
	 */
	CoEnvFacultyList.prototype.trackWindow = function () {
		var _this = this;

		// track window height
		this.windowHeight = $(window).height();
		$(window).on( 'debouncedresize', function () {
			_this.windowHeight = $(window).height();
		} );

		// track scrolltop
		this.scrollTop = $(window).scrollTop();
		$(window).on( 'scroll', function () {
			_this.scrollTop = $(window).scrollTop();
		} );
	};

	/**
	 * Get item offsets
	 * 
	 * Saves item offsets (from top of page) on initialization
	 * and resize so we don't have to do it on each scroll
	 */
	CoEnvFacultyList.prototype.itemOffsets = function () {
		var _this = this;

		var saveOffset = function () {
			$.each( _this.$items, function ( index, el ) {
				$(this).data('offset', $(this).offset().top);
			} );
		};

		// run once on initialization
		saveOffset();

		// run again on window resize
		$(window).on( 'debouncedresize', saveOffset );

		// and again on isotope layout complete
		this.$itemContainer.on( 'isoLayoutComplete', saveOffset );
	};

	/**
	 * Lazy load list item images
	 */
	CoEnvFacultyList.prototype.lazyloader = function () {
		var _this = this;

		var lazyload = function() {
			var $items = _this.$items.not('[data-loaded]');

			if ( $items.length === 0 ) {
				return;
			}

			$.each( $items, function ( index, el ) {

				// return if item is not visible
				if ( !_this.isVisible( el ) ) {
					return;
				}

				// add data-picture attribute
				// which will flag this element for picturefill
				$(el).find('.Faculty-list-item-image').attr('data-picture', '');

				// add data-loaded attribute so
				// we don't have to loop over this item again
				$(el).attr('data-loaded', '');
			} );

			// run picturefill
			window.picturefill();
		};

		// run once on initialization
		lazyload();

		// run again on scroll
		$(window).on( 'scroll', lazyload );

		// also on isotope layoutComplete
		this.$itemContainer.on( 'isoLayoutComplete', lazyload );
	};

	/**
	 * Check if an element is visible
	 *
	 * This is run in a loop, so we use the saved data-offset
	 * instead of remeasuring every time.
	 */
	CoEnvFacultyList.prototype.isVisible = function ( el ) {
		var _this = this;
		return ( $(el).data('offset') < ( this.windowHeight + this.scrollTop ) );
	};

	/**
	 * Initialize Isotope
	 *
	 * - initialize isotope
	 * - relayout with new gutter width on resize
	 */
	CoEnvFacultyList.prototype.isoInit = function () {
		var _this = this,
			isotopeActive = false;

		// get gutter

		var isoOpts = {
			itemSelector: this.itemSelector,
			isInitLayout: false,
			masonry: {
				columnWidth: '.grid-sizer',
				//gutter: 4
			}
		};

		// on resize, do this.$itemContainer.isotope(isoOpts);
		// with new gutter width so that gutter updates

		this.$itemContainer.isotope(isoOpts);

		this.$itemContainer.isotope( 'on', 'layoutComplete', function () {
			_this.$itemContainer.trigger( 'isoLayoutComplete' );
		} );

		this.$itemContainer.isotope('layout');

	};

	new CoEnvFacultyList();

})(jQuery, window, document);