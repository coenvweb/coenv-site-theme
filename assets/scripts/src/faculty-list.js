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
		itemFeaturedClass: 'Faculty-list-item--featured',

		// item image selector
		itemImageSelector: '.Faculty-list-item-image',

		// toolbox selector
		toolboxSelector: '.Faculty-toolbox'
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
		this.itemOffsets();

		// lazy load images
		this.lazyloader();

		// initialize isotope
		this.isoInit();

		// handle isotope filtering when layout is complete
		this.isoFilter();

		// update url hash after filtering
		this.updateHash();

		// filter isotope based on url hash
		this.hashFilter();
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
	 *
	 * TODO: is there a way to register a layoutComplete event
	 * on the isotope container without initializing .isotope first?
	 * Right now we're initializing isotope twice.
	 */
	CoEnvFacultyList.prototype.isoInit = function () {
		var _this = this,
			isoOpts;

		// set up isotope options
		isoOpts = {
			isInitLayout: false,
			itemSelector: this.itemSelector,
			stamp: this.toolboxSelector,
			masonry: {
				columnWidth: '.grid-sizer'
			}
		};

		// initialize isotope without layout
		this.$itemContainer.isotope( isoOpts );

		// register layoutComplete listener
		// this will not fire on initialization,
		// only on subsequent layouts
		this.$itemContainer.isotope( 'on', 'layoutComplete', function () {
			_this.$itemContainer.trigger( 'isoLayoutComplete' );
		} );

		// layout isotope
		this.$itemContainer.isotope( isoOpts );
	};

	/**
	 * Filters isotope based on URL hash
	 */
	CoEnvFacultyList.prototype.hashFilter = function () {
		var filters = {},
			hashes;

		// check for url hash
		if ( window.location.hash ) {

			hashes = window.location.hash.replace( '#', '' ).split('&');

			filters.theme = {
				slug: hashes[0]
			};

			filters.unit = {
				slug: hashes[1]
			};

			this.$itemContainer.trigger( 'filter', [ filters ] );
		}
	};

	/**
	 * Isotope filtering
	 *
	 * Listens for 'filter' event on item container
	 */
	CoEnvFacultyList.prototype.isoFilter = function () {
		var _this = this,
			filters = '',
			$firstItem;

		// listen for 'filter' event on item container
		this.$itemContainer.on( 'filter', function ( event, data ) {

			// combine filters into filter string
			filters = $.map( data, function ( value ) {
				if ( value.slug === '*' ) {
					return value.slug;
				}
				return '.' + value.slug;
			} ).join('');

			// the first item in a filtered set should never be featured (i.e. big)
			// otherwise the layout will break.
			$firstItem = _this.$items.filter( filters ).first().removeClass( _this.itemFeaturedClass );

			// filter isotope
			_this.$itemContainer.isotope({ filter: filters });
		} );
	};

	/**
	 * Update URL hash after filtering
	 *
	 * Listens for 'filter' event on item container
	 */
	CoEnvFacultyList.prototype.updateHash = function () {
		var _this = this,
			hash = '';

		this.$itemContainer.on( 'filter', function ( event, data ) {

			// build hash
			hash = $.map( data, function ( value ) {
				return value.slug;
			} ).join('&');

			window.location.hash = hash;
		} );
	};

	/**
	 * Parse URL hash for isotope filters
	 */
	CoEnvFacultyList.prototype.filterFromHash = function () {
		var _this = this,
			hashes,
			filters;

		hashes = window.location.hash.replace( '#', '' ).split('&');

		// combine filters into filter string
		filters = $.map( hashes, function ( value ) {
			return '.' + value;
		} ).join('');

		return filters;
	};

	new CoEnvFacultyList();

})(jQuery, window, document);