/**
 * The Faculty Toolbox
 *
 * A fancier theme/unit selector to replace the default
 * theme/unit selector that shows for smaller screens
 * or users with javascript disabled.
 */
(function ($, window, document, undefined) {
	'use strict';

	var CoEnvFacultyToolbox = function () {
		this.init();
	};

	CoEnvFacultyToolbox.prototype = {

		// Container for faculty items (members)
		// isotope acts on this
		$isoContainer: $('.Faculty-list-content'),

		// Toolbox container
		$toolbox: $('.Faculty-toolbox'),

		// Roller items container
		$roller: $('.Faculty-toolbox-roller-items'),
		rollerHeight: 0,
		rollerOffsetTop: 0,

		// Roller inner container
		$rollerInner: $('.Faculty-toolbox-roller-items-inner'),
		rollerInnerPos: 0,

		// Roller items set
		$rollerSet: $('.Faculty-toolbox-roller-items-set'),
		rollerSetPrependPos: 0,
		rollerSetAppendPos: 0,

		rollerItemSelector: '.Faculty-toolbox-roller-item',
		rollerItemActiveClass: 'Faculty-toolbox-roller-item--active',
		activeRollerItem: ''
	};

	/**
	 * Initialize
	 */
	CoEnvFacultyToolbox.prototype.init = function () {
		var _this = this;

		// keep track of roller measurements
		this.rollerMeasurements();

		// handle item selection
		this.rollerItemSelection();

		// handle adding sets when roller rolls
		this.addItemSets();

		// slide to first item
		this.slideToItem( this.$roller.find( this.rollerItemSelector ).first() );

//		// get roller items
//		this.getRollerItems();
//
//		this.$rollerItemsClone = this.$rollerItemsWrap.clone(true);
//
//		// keep track of roller measurements
//		this.rollerMeasurements();
//
//		// handle roller scrolling
//		this.rollerScroller();
//
//		// handle roller item selection
//		this.itemSelection();
	};

	/**
	 * Keep track of roller measurements
	 */
	CoEnvFacultyToolbox.prototype.rollerMeasurements = function () {
		var _this = this;

		var onResize = function () {
			_this.rollerHeight = _this.$roller.height();
			_this.rollerOffsetTop = _this.$roller.offset().top;
			_this.rollerCenter = _this.rollerOffsetTop + ( _this.rollerHeight / 2 );
		};

		onResize();

		$(window).on( 'debouncedresize', onResize );
	};

	/**
	 * Prepend roller set
	 */
	CoEnvFacultyToolbox.prototype.prependRollerSet = function () {
		var $newSet;

		// update roller set prepend position
		this.rollerSetPrependPos -= this.$rollerSet.outerHeight();

		// clone a new set to prepend
		$newSet = this.$rollerSet.clone(true);

		$newSet.css( 'top', this.rollerSetPrependPos );

		this.$rollerInner.prepend( $newSet );
	};

	/**
	 * Append roller set
	 */
	CoEnvFacultyToolbox.prototype.appendRollerSet = function () {
		var $newSet;

		// update roller set append position
		this.rollerSetAppendPos += this.$rollerSet.outerHeight();

		// clone a new set to append
		$newSet = this.$rollerSet.clone(true);

		$newSet.css( 'top', this.rollerSetAppendPos );

		this.$rollerInner.append( $newSet );
	};

	/**
	 * Handle roller item selection
	 */
	CoEnvFacultyToolbox.prototype.rollerItemSelection = function () {
		var _this = this;

		this.$roller.on( 'click', this.rollerItemSelector, function ( event ) {
			event.preventDefault();

			_this.slideToItem( $(this) );
		} );
	};

	/**
	 * Slide roller inner to center on item
	 */
	CoEnvFacultyToolbox.prototype.slideToItem = function ( $item ) {
		var _this = this;

		var rollerHeight = this.$roller.height();
		var rollerOffset = this.$roller.offset().top;
		var rollerCenter = rollerOffset + ( rollerHeight / 2 );
		
		var innerOffset = this.$rollerInner.offset().top;
		var itemOffset = $item.offset().top;

		var itemPos = itemOffset - innerOffset;
		var itemHeight = $item.outerHeight();

		var newInnerPos = ( -itemPos + ( rollerCenter - rollerOffset ) ) - ( itemHeight / 2 );

		// trigger roller 'preroll' event
		// need to pass change
		this.$roller.trigger( 'preroll', [{
			change: newInnerPos - this.rollerInnerPos
		}] );

		this.$rollerInner.css( 'transform', 'translateY(' + newInnerPos + 'px)' );

		// update rollerInnerPos
		this.rollerInnerPos = newInnerPos;

		// trigger roller 'postroll'
		this.$roller.trigger( 'postroll', [{
		}] );
	};

	/**
	 * Handle adding sets when roller rolls
	 */
	CoEnvFacultyToolbox.prototype.addItemSets = function () {
		var _this = this;

		this.$roller.on( 'preroll', function ( event, data ) {

			var $firstItem = _this.$roller.find( _this.rollerItemSelector ).first();
			var firstItemOffset = $firstItem.offset().top;

			var $lastItem = _this.$roller.find( _this.rollerItemSelector ).last();
			var lastItemOffset = $lastItem.offset().top;
			var lastItemHeight = $lastItem.outerHeight();

			// if top of first item (will be) > top of roller - amount of change
			if ( firstItemOffset > _this.rollerOffsetTop - data.change ) {
				_this.prependRollerSet();
			}

			// if bottom of last item (will be) < bottom of roller
			if ( lastItemOffset + lastItemHeight < _this.rollerOffsetTop + _this.rollerHeight - data.change ) {
				_this.appendRollerSet();
			}
		
		} );
	};

//	/**
//	 * Handle roller scrolling
//	 */
//	CoEnvFacultyToolbox.prototype.rollerScroller = function () {
//		var _this = this,
//			firstItemOffsetTop,
//			lastItemOffsetTop;
//
//		this.prependRollerItems();
//
//		this.$roller.on( 'scroll', function () {
//			firstItemOffsetTop = _this.$firstRollerItem.offset().top;
//			lastItemOffsetTop = _this.$lastRollerItem.offset().top;
//
//			// append items?
//			if ( lastItemOffsetTop < _this.rollerOffsetTop + _this.rollerHeight ) {
//				_this.appendRollerItems();
//			}
//
//			// prepend items?
//			if ( firstItemOffsetTop === _this.rollerOffsetTop ) {
//				_this.prependRollerItems();
//			}
//
//		} );
//	};

//	/**
//	 * Prepend new list items
//	 */
//	CoEnvFacultyToolbox.prototype.prependRollerItems = function () {
//		var _this = this,
//			$newItems = this.$rollerItemsClone.clone(true);
//
//		$newItems.find( this.rollerItemSelector ).filter( function () {
//			if ( $(this).find('a').attr('href') === _this.activeRollerItem ) {
//				return true;
//			}
//		} ).addClass( this.rollerItemActiveClass );
//
//		this.$roller.prepend( $newItems );
//
//		this.$roller.scrollTop( $newItems.height() );
//
//		// update items
//		this.getRollerItems();
//	};

//	/**
//	 * Get roller items
//	 */
//	CoEnvFacultyToolbox.prototype.getRollerItems = function () {
//		this.$rollerItems = this.$roller.find( this.rollerItemSelector );
//		this.$firstRollerItem = this.$rollerItems.first();
//		this.$lastRollerItem = this.$rollerItems.last();
//	};
//
//	/**
//	 * Append new list items
//	 */
//	CoEnvFacultyToolbox.prototype.appendRollerItems = function () {
//		var _this = this,
//			$newItems = this.$rollerItemsClone.clone(true);
//
//		$newItems.find( this.rollerItemSelector ).filter( function () {
//			if ( $(this).find('a').attr('href') === _this.activeRollerItem ) {
//				return true;
//			}
//		} ).addClass( this.rollerItemActiveClass );
//
//		this.$roller.append( $newItems );
//
//		// update items
//		this.getRollerItems();
//	};
//
//	/**
//	 * Handle item selection
//	 *
//	 * Triggers isotope filter
//	 */
//	CoEnvFacultyToolbox.prototype.itemSelection = function () {
//		var _this = this;
//
//		this.$roller.on( 'click', this.rollerItemSelector, function ( event ) {
//			event.preventDefault();
//
//			var $item = $(this),
//				$itemLink = $item.find('a'),
//				data = {};
//
//			if ( $item.hasClass( _this.rollerItemActiveClass ) ) {
//				return;
//			}
//
//			// deactivate other items
//			_this.$rollerItems.filter( '.' + _this.rollerItemActiveClass ).removeClass( _this.rollerItemActiveClass );
//			
//			_this.$rollerItems.filter( function () {
//				if ( $(this).find('a').attr('href') === $itemLink.attr('href') ) {
//					return true;
//				}
//			} ).addClass( _this.rollerItemActiveClass );
//
//			_this.activeRollerItem = $itemLink.attr('href');
//
//			// scroll to active roller item
//			_this.$roller.scrollTo( _this.$roller.scrollTop() + ( $(this).offset().top - _this.rollerOffsetTop ), {
//				duration: 250
//			} );
//
//			data.filters = {
//				theme: {
//					name: $itemLink.text(),
//					slug: $itemLink.data('theme'),
//					url: $itemLink.attr('href')
//				}
//			};
//
//			// trigger isotope
//			_this.$isoContainer.trigger( 'filter', [ data ] );
//		} );
//	};

	new CoEnvFacultyToolbox();

})(jQuery, window, document);