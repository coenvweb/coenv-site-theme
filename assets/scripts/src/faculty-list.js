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
		// general container for the faculty list page
		$facultyList: $('.Faculty-list'),

		// container for faculty items (members)
		// isotope acts on this
		$itemContainer: $('.Faculty-list-content'),

		// individual items (members)
		$items: $('.Faculty-list-item'),
		itemSelector: '.Faculty-list-item',

		// item image selector
		itemImageSelector: '.Faculty-list-item-image',

		// toolbox selector
		toolboxSelector: '.Faculty-toolbox',

		// isotope filter queue
		isoFilterQueue: {}
	};

	/**
	 * Initialization
	 *
	 * Kick-off everything that happens on initialization here.
	 */
	CoEnvFacultyList.prototype.init = function () {
		var _this = this;

		// keep track of window height and scrolltop
		this.trackWindow();

		// save item offsets
		//this.itemOffsets();

		// lazy load images
		//this.lazyloader();

		// initialize isotope
		this.isoInit();

		// handle isotope filtering when layout is complete
		this.isoFilter();
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
				$(el).find( _this.itemImageSelector ).attr('data-picture', '');

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
	 */
	CoEnvFacultyList.prototype.isoInit = function () {
		var _this = this;

		// initialize isotope without layout
		this.$itemContainer.isotope({
			//isInitLayout: false,
			itemSelector: this.itemSelector,
			isResizeBound: false,
			masonry: {
				columnWidth: $('.grid-sizer').width()
			}
		});

		// listen for window resize to update columnWidth
		$(window).on( 'debouncedresize', function () {
			_this.$itemContainer.isotope({
				masonry: {
					columnWidth: $('.grid-sizer').width()
				}
			});
		} );

		// register layoutComplete listener
		// this will not fire on initialization,
		// only on subsequent layouts
		this.$itemContainer.isotope( 'on', 'layoutComplete', function () {
			_this.$itemContainer.trigger( 'isoLayoutComplete' );
		} );

		// layout isotope
		this.$itemContainer.isotope('layout');
	};

	/**
	 * Isotope filtering
	 */
	CoEnvFacultyList.prototype.isoFilter = function () {
		var _this = this,
			filters;

		// listen for 'filter' event on item container
		this.$itemContainer.on( 'filter', function ( event, data ) {
			var isoOpts = {
				masonry: {
					columnWidth: $('.grid-sizer').width()
				}
			};

			// check if filters were passed
			if ( data.filters !== undefined ) {

				// add filters to filter queue
				for ( var prop in data.filters ) {
					_this.isoFilterQueue[ prop ] = data.filters[ prop ];
				}
			}

			// combine filters from filter queue
			filters = $.map( _this.isoFilterQueue, function ( value ) {
				return '.' + value.slug;
			} ).join('');


			// add filters to data.options
			// toolbox should *not* be filtered out
			isoOpts.filter = filters + ', ' + _this.toolboxSelector;

			// filter isotope
			_this.$itemContainer.isotope( isoOpts );
		} );
	};

	new CoEnvFacultyList();

})(jQuery, window, document);