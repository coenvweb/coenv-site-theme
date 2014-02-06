(function ($, window, document, undefined) {
	'use strict';

	var CoEnvFaculty = function () {
		this.init();
	};

	CoEnvFaculty.prototype = {

		// isotope item container
		$isoContainer: $('.Faculty-list-content'),

		// Roller container
		$roller: $('.Faculty-toolbox-roller-items'),

		// Roller inner container
        $rollerInner: $('.Faculty-toolbox-roller-items-inner'),
        rollerInnerPos: 0,

		// Roller items set
        $rollerSet: $('.Faculty-toolbox-roller-items-set'),
        rollerSetPrependPos: 0,
        rollerSetAppendPos: 0,

		// Roller items
		rollerItemSelector: '.Faculty-toolbox-roller-item',
		rollerItemActiveClass: 'Faculty-toolbox-roller-item--active',

		// Filter queue
		filterQ: {},

		// Toolbox form
		$toolboxForm: $('.Faculty-toolbox-form')
	};

	CoEnvFaculty.prototype.init = function () {

		// initialize roller
		this.rollerInit();

		// initialize isotope
		this.isoInit();

		// run filters passed through hash
		this.filterInit();
	};

	/**
	 * Initialize Roller
	 */
	CoEnvFaculty.prototype.rollerInit = function () {

		// track roller measurements
		this.rollerMeasure();

		// add roller item sets on roll
		this.rollerAddSets();

		// handle roller interactions
		this.rollerInteractions();

		// slide roller on filter event
		this.rollerSlider();
	};

	/**
	 * Track Roller measurements
	 */
	CoEnvFaculty.prototype.rollerMeasure = function () {
		var _this = this;

		var onResize = function () {
			_this.rollerHeight = _this.$roller.height();
			_this.rollerOffsetTop = _this.$roller.offset().top;
			_this.rollerCenter = _this.rollerOffsetTop + ( _this.rollerHeight / 2 );
			_this.rollerInnerOffset = _this.$rollerInner.offset().top;
		};

		onResize();
		$(window).one( 'debouncedresize', onResize );
	};

	/**
	 * Add Roller item sets on roll
	 */
	CoEnvFaculty.prototype.rollerAddSets = function () {
		var _this = this,
			$rollerItems,
			$firstItem,
			firstItemOffset,
			$lastItem,
			lastItemOffset,
			lastItemHeight;

		// listen for 'preroll' event on $roller
		this.$roller.on( 'preroll', function ( event, data ) {

			$rollerItems = _this.$roller.find( _this.rollerItemSelector );

			$firstItem = $rollerItems.first();
			firstItemOffset = $firstItem.offset().top;

			$lastItem = $rollerItems.last();
			lastItemOffset = $lastItem.offset().top;
			lastItemHeight = $lastItem.outerHeight();

			// if top of first item (will be) > top of roller - amount of change
			// prepend roller set
			if ( firstItemOffset > _this.rollerOffsetTop - data.change ) {
				_this.rollerPrependSet();
			}

			// if bottom of last item (will be) < bottom of roller
			if ( lastItemOffset + lastItemHeight < _this.rollerOffsetTop + _this.rollerHeight - data.change ) {
				_this.rollerAppendSet();
			}
		} );
	};

	/**
	 * Move roller to active item
	 */
	CoEnvFaculty.prototype.rollerSlider = function () {
		var _this = this,
			$item,
			itemOffset,
			itemPos,
			itemHeight,
			newInnerPos;

		function doRoll ( $item ) {

			if ( $item === undefined ) {
				return;
			}
	        
	        var innerOffset = _this.$rollerInner.offset().top;
	        var itemOffset = $item.offset().top;

	        var itemPos = itemOffset - innerOffset;
	        var itemHeight = $item.outerHeight();

	        var newInnerPos = ( -itemPos + ( _this.rollerCenter - _this.rollerOffsetTop ) ) - ( itemHeight / 2 );

	        // deactivate active items
	        _this.$roller.find( '.' + _this.rollerItemActiveClass ).removeClass( _this.rollerItemActiveClass );

	        // make item active
	        $item.addClass( _this.rollerItemActiveClass );

	        // trigger roller 'preroll' event
	        // need to pass change
	        _this.$roller.trigger( 'preroll', [{
	            change: newInnerPos - _this.rollerInnerPos
	        }] );

	        _this.$rollerInner.css( 'transform', 'translateY(' + newInnerPos + 'px)' );

	        // update rollerInnerPos
	        _this.rollerInnerPos = newInnerPos;

	        // trigger roller 'postroll'
	        _this.$roller.trigger( 'postroll', [{}] );
		}

		this.$isoContainer.on( 'filter', function ( event, data ) {
			doRoll( data.$rollerItem );
		} );
	};

	/**
	 * Prepend Roller set
	 * only called from this.rollerAddSets()
	 */
	CoEnvFaculty.prototype.rollerPrependSet = function () {
		var $newSet;

		// update roller set prepend position
		this.rollerSetPrependPos -= this.$rollerSet.outerHeight();

		// clone a new set to prepend
		$newSet = this.$rollerSet.clone(true);

		// position new set
		$newSet.css( 'top', this.rollerSetPrependPos );

		// prepend set
		this.$rollerInner.prepend( $newSet );
	};

	/**
	 * Append Roller set
	 * only called from this.rollerAddSets()
	 */
	CoEnvFaculty.prototype.rollerAppendSet = function () {
		var $newSet;

		// update roller set append position
		this.rollerSetAppendPos += this.$rollerSet.outerHeight();

		// clone a new set to append
		$newSet = this.$rollerSet.clone(true);

		// position new set
		$newSet.css( 'top', this.rollerSetAppendPos );

		// append set
		this.$rollerInner.append( $newSet );
	};

	/**
	 * Handle roller interactions
	 */
	CoEnvFaculty.prototype.rollerInteractions = function () {
		var _this = this,
			filterData;

		this.$roller.on( 'click', this.rollerItemSelector, function ( event ) {
			event.preventDefault();

			var $item = $(this).find('a');
			
			_this.doFilter({
				$rollerItem: $(this),
				theme: {
					name: $item.text(),
					slug: $item.data('theme')
				}
			});

		} );
	};

	/**
	 * Initialize Isotope
	 */
	CoEnvFaculty.prototype.isoInit = function () {

		

	};

	/**
	 * Run filters passed through hash
	 */
	CoEnvFaculty.prototype.filterInit = function () {
		var _this = this,
			hashFilters = this.hashFilters(),
			filters = {},
			theme,
			unit,
			$selectOpt;

		if (! hashFilters) {
			return;
		}

		$.each( hashFilters, function () {
			$selectOpt = _this.$toolboxForm.find('option[value="' + this + '"]');

			filters[ this.split('-')[0] ] = {
				name: $selectOpt.text(),
				slug: this
			};
		} );

		this.doFilter( filters );
	};

	/**
	 * Parse url hash
	 */
	CoEnvFaculty.prototype.hashFilters = function () {
		var hash = window.location.hash,
			filters;

		if ( hash === '' ) {
			return false;
		}

		filters = hash.substring('1').split('&');

		return filters;
	};

	/**
	 * Filter isotope and trigger 'filter' event on isoContainer
	 */
	CoEnvFaculty.prototype.doFilter = function ( data ) {
		var _this = this;

		// update filter queue with data properties
		// (theme or unit)
		for ( var prop in data ) {

			// translate '*' to 'theme-all' or 'unit-all'
			if ( data[ prop ].slug === '*' ) {
				data[ prop ].slug = prop + '-all';
			}

			this.filterQ[ prop ] = data[ prop ];
		}

		this.$isoContainer.trigger( 'filter', [ this.filterQ ] );
	};

	new CoEnvFaculty();

})(jQuery, window, document);