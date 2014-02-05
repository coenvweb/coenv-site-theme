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

		// handle adding sets when roller rolls
		this.addItemSets();

		// slide to first item
		this.slideToItem( this.$roller.find( this.rollerItemSelector ).first() );

		// handle item selection
		this.rollerItemSelection();
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
			var $item = $(this).find('a');

			_this.slideToItem( $(this) );

			_this.isoFilter({
				name: $item.text(),
				slug: $item.data('theme'),
				url: $item.attr('href')
			});
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

		// deactivate active items
		this.$roller.find( '.' + this.rollerItemActiveClass ).removeClass( this.rollerItemActiveClass );

		// make item active
		$item.addClass( this.rollerItemActiveClass );

		// trigger roller 'preroll' event
		// need to pass change
		this.$roller.trigger( 'preroll', [{
			change: newInnerPos - this.rollerInnerPos
		}] );

		this.$rollerInner.css( 'transform', 'translateY(' + newInnerPos + 'px)' );

		// update rollerInnerPos
		this.rollerInnerPos = newInnerPos;

		// trigger roller 'postroll'
		this.$roller.trigger( 'postroll', [{}] );
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

	/**
	 * Triggers isotope filter
	 */
	CoEnvFacultyToolbox.prototype.isoFilter = function ( filter ) {
		var _this = this,
			data = {};

		data.filters = { theme: filter };

		// trigger isotope
		_this.$isoContainer.trigger( 'filter', [ data ] );
	};

	new CoEnvFacultyToolbox();

})(jQuery, window, document);