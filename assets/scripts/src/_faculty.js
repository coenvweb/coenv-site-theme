jQuery(function ($) {
	'use strict';

	// initialize CoEnvFaculty plugin
	// on faculty index page
	$('.post-type-archive-faculty').coenvfaculty();

});

(function ($, window, document, undefined) {
	'use strict';

	// Plugin definition
	// =========================================================================
	$.CoEnvFaculty = function ( options, element ) {
		this.options = options;
		this.element = $(element);

		this._create( options );
	};

	$.CoEnvFaculty.settings = {
		itemSelector: '.jsIsotopeItem'
	};

	// Create
	// =========================================================================
	$.CoEnvFaculty.prototype._create = function ( options ) {

		// set options
		this.options = $.extend(true, {}, $.CoEnvFaculty.settings, options);

		// initialize
		this._init();

	};

	// Initialize
	// =========================================================================
	$.CoEnvFaculty.prototype._init = function () {

		/*
		 * On page load, you see the theme roller spin to land on a random research theme.
		 * Isotope then loads up all faculty for that theme, and loads their images.
		 * Once the isotope action is complete, it will add
		 */

		this.$grid = $('.faculty-tiles');

		this.$toolbox = $('.faculty-toolbox');

		this.$roller = $('.faculty-toolbox-theme-roller');

		this.$feedback = this.$toolbox.find('.faculty-toolbox-feedback');

		this.$form = this.$toolbox.find('.faculty-toolbox-form form');

		this.$themeSelect = this.$form.find('#select-theme');
		this.$unitSelect = this.$form.find('#select-unit');
		this.$searchField = this.$form.find('#keyword-search');

		this.$tiles = this.$grid.find( this.options.itemSelector );

		// set initial isotope filters
		this.isoFilters = this._isoFilters();

		// modify isotope masonry layout mode
		this._isotopeModifyMasonry();

		// isotope for grid items
		this._handleIsotope();

		// Set up theme roller
		this._themeRoller();

		// toggle between theme roller and form
		this._toggleState();

		// handle selects
		this._handleSelects();

		// handle search
		this._handleSearch();

		// update selected
		this._updateSelect();

		// update feedback
		this._updateFeedback(); // Remove this
		this._feedback();

		// register themeChange subscriptions
		this._subscribeToThemeChange();
	};

	// Handle theme roller
	// =========================================================================
	$.CoEnvFaculty.prototype._themeRoller = function () {
		var $interactionLayer = this.$roller.find('.faculty-toolbox-interaction-layer'),
				_this = this,
				isoData;

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

		this._doProcession();

		// disable double click
		this.$roller.on( 'dblclick', function (e) {
			e.preventDefault();
		} );

		$interactionLayer.on( 'click', function (e) {
			var posX = $(this).offset().top,
					clickY = e.pageY,
					$items = _this.$roller.find('.faculty-toolbox-theme-roller-item'),
					coordinates = getCoordinates( $items ),
					targetIndex,
					$item;

			for ( var i = 0, len = $items.length; i < len; i++ ) {
				if ( clickY >= coordinates[i].rangeA && clickY < coordinates[i].rangeB ) {
					targetIndex = coordinates[i].index;
				}
			}

			$item = $items.eq( targetIndex );

			// update isoFilters.theme
			_this.isoFilters.theme = {
				name: $item.text(),
				slug: $item.attr('data-theme'),
				number: $item.attr('data-number'),
				message: $item.attr('data-feedback'),
				permalink: $item.attr('data-permalink')
			};

			_this.element.trigger('themeChange' );

			$item.click();
		} );

	};

	// Register themeChange subscriptions
	// =========================================================================
	$.CoEnvFaculty.prototype._subscribeToThemeChange = function () {
		var _this = this;

		this.element.on( 'themeChange', function () {

			// handle isotope filtering
			_this._filterIsotope( {}, function () {

				// update feedback message
				_this._updateFeedback();

			} );

			// if isotope callback does not fire
			_this._updateFeedback();

			// update theme select input
			_this._updateSelect();

		} );
	};

	// Toggle between theme roller and form
	// =========================================================================
	$.CoEnvFaculty.prototype._toggleState = function () {

		var $showToolsButton = this.$toolbox.find('.faculty-toolbox-more-search-tools'),
				$facultyButton = this.$toolbox.find('.faculty-toolbox-header a'),
				_this = this,
				isoData;

		// if a specific theme or unit is set in this.isoFilters
		// immediately show tools
		if (
			this.isoFilters.theme.slug !== 'theme-all' ||
			this.isoFilters.unit.slug !== 'unit-all'
		) {
			this.$toolbox.addClass('show-tools');
		}

		$showToolsButton.click( function (e) {
			e.preventDefault();
			_this.$toolbox.addClass('show-tools');

			// reset themeRoller
			_this.$roller.procession('destroy');
			_this._doProcession();
		} );

		$facultyButton.click( function (e) {
			e.preventDefault();
			_this.$toolbox.removeClass('show-tools');

			// reset isoFilters
			_this.isoFilters = _this._isoFilters( true );

			//console.log(_this.isoFilters.theme.slug, _this.isoFilters.unit.slug);

			// reset isotope
			_this.element.trigger( 'themeChange' );

			// reset form selects
			_this._resetForm();
		} );

	};

	// Reset form
	// =========================================================================
	$.CoEnvFaculty.prototype._resetForm = function () {
		this._resetSelects();
		this._resetSearch();
	};

	// Reset selects
	// =========================================================================
	$.CoEnvFaculty.prototype._resetSelects = function () {
		this.$themeSelect.find('option[selected="selected"]').removeAttr('selected');
		this.$themeSelect.find('option').first().attr('selected', 'selected');
		this.$themeSelect.trigger('liszt:updated');

		this.$unitSelect.find('option[selected="selected"]').removeAttr('selected');
		this.$unitSelect.find('option').first().attr('selected', 'selected');
		this.$unitSelect.trigger('liszt:updated');
	};

	// Reset search
	// =========================================================================
	$.CoEnvFaculty.prototype._resetSearch = function () {
		this.$searchField.val('');
	};

	// Handle feedback
	// Subscribed to this.$feedback.on('updateFeedback');
	// =========================================================================
	$.CoEnvFaculty.prototype._feedback = function () {

		var $message = this.$feedback.find('.feedback-message'),
				$number = this.$feedback.find('.feedback-number'),
				_this = this,
				$filteredItems;

		this.$feedback.on( 'updateFeedback', function ( e, data ) {

			//console.log(_this.$grid);

			// if no number is passed, get filtered number from isotope
			if ( data.number === undefined ) {
				$filteredItems = _this.$grid.data('isotope').$filteredAtoms;
				data.number = $filteredItems.length - 1; // subtract one to account for toolbox
			}

			$number.text( data.number );
			$message.html( data.message );

		} );

	};

	// Update feedback message on themeChange (registered as isotope callback)
	// TODO: make this DRYer
	// =========================================================================
	$.CoEnvFaculty.prototype._updateFeedback = function () {

		var $filteredItems = this.$grid.data('isotope').$filteredAtoms,
				itemCount = $filteredItems.length - 1, // need to subtract one to account for toolbox, which is an isotope item
				themeMessage = this.isoFilters.theme.message.replace('theme', '<a href="' + this.isoFilters.theme.permalink + '">' + this.isoFilters.theme.name + '</a>') + ' ',
				unitMessage = this.isoFilters.unit.message.replace('unit', '<a href="' + this.isoFilters.unit.permalink + '">' + this.isoFilters.unit.name + '</a>'),
				message = '';

		// if an isotope has no change,
		// feedback doesn't update

		// is 'all themes' selected?
		if ( this.isoFilters.theme.slug === 'theme-all' ) {

			// are we in the form view?
			if ( this.$toolbox.hasClass('show-tools') ) {

				// form view
				message += 'Faculty are working ';
				message += unitMessage;

			} else {

				// theme roller view
				message += themeMessage;
			}

		} else {

			// single theme is selected
			message += themeMessage;

			// are we in the form view?
			if ( this.$toolbox.hasClass('show-tools') ) {

				// is 'all units' NOT selected?
				if ( this.isoFilters.unit.slug !== 'unit-all' ) {
					message += unitMessage;
				}
			}
		}

		this.$feedback.find('.feedback-message').html( message );
		this.$feedback.find('.feedback-number').text( itemCount );

		// click event feedback
		//this.$feedback.find('a').click( function (e) {
			//e.preventDefault();

			//_this.isoFilters = _this._isoFilters();
		//} );
	};

	// When theme is selected in theme roller, select that theme in the form as well
	// =========================================================================
	$.CoEnvFaculty.prototype._updateSelect = function () {

		// exit if not on the theme-roller
//		if ( this.$toolbox.hasClass('show-tools') ) {
//			return;
//		}

		var $themeSelect = this.$themeSelect,
				$unitSelect = this.$unitSelect;

		$themeSelect.find('option[selected="selected"]').removeAttr('selected');
		$themeSelect.find('option[value="' + this.isoFilters.theme.slug + '"]').attr('selected', 'selected');
		$themeSelect.trigger('liszt:updated');

		$unitSelect.find('option[selected="selected"]').removeAttr('selected');
		$unitSelect.find('option[value="' + this.isoFilters.unit.slug + '"]').attr('selected', 'selected');
		$unitSelect.trigger('liszt:updated');

		this.$unitSelect.find('option[value="' + this.isoFilters.theme.slug + '"]').attr('selected', 'selected');
	};

	// Handle form selects
	// =========================================================================
	$.CoEnvFaculty.prototype._handleSelects = function () {

		var $form = this.$grid.find('.faculty-toolbox-form form'),
				$themeSelect = $form.find('#select-theme'),
				$unitSelect = $form.find('#select-unit'),
				_this = this,
				isoData,
				$opt;

		$themeSelect.chosen().change( function (e, obj) {

			// exit if this.$grid is not showing the form tools
			// necessary because selecting a theme in the theme roller
			// triggers a change on the themeSelect
			if ( !_this.$toolbox.hasClass('show-tools') ) {
				return false;
			}

			$opt = $themeSelect.find('option[value="' + obj.selected + '"]');

			// TODO:
			// need to add filters to this.filterQueue
			// which keeps track of active theme and unit filters
			// this theme filter would overwrite this.filterQueue.theme
			// but the current unit filter would stay active
			//
			// also add a method to clear the filterQueue
			// which would happen when changing back to the themeRoller
			// or submitting the search form

			// run isotope
			_this._isotope({
				filter: '.' + obj.selected
			}, function () {

				// update feedback
				_this.$feedback.trigger( 'updateFeedback', [{
					message: 'Faculty are working on <a href="' + $opt.attr('data-permalink') + '">' + $opt.text() + '</a>'
				}] );
			});

			// reset search
			_this._resetSearch();
		} );

		$unitSelect.chosen().change( function (e, obj) {

			$opt = $unitSelect.find('option[value="' + obj.selected + '"]');

			// run isotope
			_this._isotope({
				filter: '.' + obj.selected
			}, function () {

				// update feedback
			});

			// update isoFilters.unit
			_this.isoFilters.unit = {
				name: $opt.text(),
				slug: $opt.attr('value'),
				number: $opt.attr('data-number'),
				message: $opt.attr('data-feedback'),
				permalink: $opt.attr('data-permalink')
			};

			//_this.element.trigger( 'themeChange' );
		} );

	};

	// Handle search
	// Subscription: this.$form.on( 'submit' )
	// =========================================================================
	$.CoEnvFaculty.prototype._handleSearch = function () {

		var _this = this,
				searchData,
				searchResponse,
				memberIDs;

		this.$form.on( 'submit', function (e) {
			e.preventDefault();

			// reset selects
			_this._resetSelects();

			searchData = {
				action: 'coenv_member_api_search',
				data: _this.$searchField.val()
			};

			$.post( themeVars.ajaxurl, searchData, function ( response ) {
				searchResponse = $.parseJSON( response );

				if ( !searchResponse.results.length ) {

					// no results
					_this.$feedback.trigger( 'updateFeedback', [{
						number: searchResponse.number,
						message: searchResponse.message
					}] );
					return;
				}

				// map memberIDs
				memberIDs = $.map( searchResponse.results, function ( value ) {
					return '.search-' + value.ID;
				} ).join(', ');

				// run isotope, filter by member id
				_this._isotope({
					filter: memberIDs
				}, function () {
					// trigger feedback
				});

//				// filter grid by id
//				_this.$grid.isotope({
//					filter: memberIDs + ', .faculty-toolbox'
//				}, function () {
//
//					// trigger feedback
//					_this.$feedback.trigger( 'updateFeedback', [{
//						number: searchResponse.number,
//						message: searchResponse.message
//					}] );
//				});

			} );

		} );

	};

	// Run Procession
	// =========================================================================
	$.CoEnvFaculty.prototype._doProcession = function () {
		this.$roller.procession({
			innerSelector: '.faculty-toolbox-theme-roller-inner',
			itemSelector: '.faculty-toolbox-theme-roller-item',
			orientation: 'vertical',
			origin: 'center',
			transitionDuration: 300
		});
	};

	// Handle initial isotope
	// =========================================================================
	$.CoEnvFaculty.prototype._handleIsotope = function () {
		var _this = this,
				filters,
				isoArgs,
				isoCallback;

		filters = $.map( this.isoFilters, function ( value ) {
			return '.' + value.slug;
		} ).join('');

		isoArgs = {
			itemSelector: _this.options.itemSelector,
			resizable: false,
			masonry: {
				columnWidth: _this.$grid.width() / 8,
				cornerStampSelector: '.faculty-toolbox'
			},
			filter: filters + ', .faculty-toolbox'
		};

		isoCallback = function () {
			_this.$tiles.find('.jsIsotopeItemInner').addClass('visible');
		};

		// run initial isotope
		this.$grid.isotope( isoArgs, isoCallback );

		// listen for window resize
		$(window).smartresize( function () {
			_this.$grid.isotope({
				masonry: {
					columnWidth: _this.$grid.width() / 8
				}
			});
		} );
	};

	// Get number of items after isotope filter
	// =========================================================================
	$.CoEnvFaculty.prototype._filteredItemsNumber = function () {


		//console.log( this.$grid );

		//var $filteredItems = this.$grid.data('isotope').$filteredAtoms;
		//console.log( $filteredItems.length );
	};

	// Filter grid by theme, unit, or keyword (via search)
	// =========================================================================
	$.CoEnvFaculty.prototype._isotope = function ( args, callback ) {

		var filters;

		// this.filterQueue contains active theme and unit filters

		// check for passed filters
		if ( args.filter !== undefined ) {
			args.filter += ', .faculty-toolbox'; // prevent filtering of toolbox
		}

		// run isotope
		this.$grid.isotope( args, callback );
	};

	// DEPRECATED
	// Filter isotope by theme/unit
	// Subscribed to themeChange on this.element
	// =========================================================================
	$.CoEnvFaculty.prototype._filterIsotope = function ( args, callback ) {

		var filters,
				hash;

		// check for args
		if ( args === undefined ) {
			args = {};
		}

		filters = $.map( this.isoFilters, function ( value ) {
			return '.' + value.slug;
		} ).join('');

		hash = $.map( this.isoFilters, function ( value ) {
			return value.slug;
		} ).join('&');

		// update URL hash
		window.location.hash = hash;

		args.filter = filters + ', .faculty-toolbox';

		// filter isotope
		this.$grid.isotope( args, callback );
	};

	// Get current isotope filters
	// Subscribed to hash change event
	// =========================================================================
	$.CoEnvFaculty.prototype._isoFilters = function ( reset ) {
		var _this = this,
				$themeOpt = this.$themeSelect.find('option').first(),
				$unitOpt = this.$unitSelect.find('option').first(),
				isoFilters,
				hash;

		// not reseting isoFilters, so check for URL hash
		hash = window.location.hash.replace('#', '').split('&');

		// parse URL hash
		$.each( hash, function () {

			// test for theme
			if ( this.indexOf('theme') !== -1 ) {
				$themeOpt = _this.$themeSelect.find('option[value="' + this + '"]');
			}

			// test for unit
			if ( this.indexOf('unit') !== -1 ) {
				$unitOpt = _this.$unitSelect.find('option[value="' + this + '"]');
			}

		} );

		if ( reset === true ) {
			$themeOpt = this.$themeSelect.find('option').first();
			$unitOpt = this.$unitSelect.find('option').first();
		}

		isoFilters = {
			theme: {
				name: $themeOpt.text(),
				slug: $themeOpt.attr('value'),
				number: $themeOpt.attr('data-number'),
				message: $themeOpt.attr('data-feedback'),
				permalink: $themeOpt.attr('data-permalink')
			},
			unit: {
				name: $unitOpt.text(),
				slug: $unitOpt.attr('value'),
				number: $unitOpt.attr('data-number'),
				message: $unitOpt.attr('data-feedback'),
				permalink: $unitOpt.attr('data-permalink')
			}
		};

		return isoFilters;
	};

	// Modify Isotope's masonry layout mode to use getSize() for more precise measurements
	// =========================================================================
	$.CoEnvFaculty.prototype._isotopeModifyMasonry = function () {

		$.Isotope.prototype._masonryLayout = function ( $elems ) {
			var instance = this,
					props = instance.masonry;

			$elems.each(function(){
				var $this  = $(this),
						brickSize = getSize( $this[0] ),
						//how many columns does this brick span
						colSpan = Math.ceil( brickSize.width / props.columnWidth );

				colSpan = Math.min( colSpan, props.cols );

				if ( colSpan === 1 ) {
					// if brick spans only one column, just like singleMode
					instance._masonryPlaceBrick( $this, props.colYs );
				} else {
					// brick spans more than one column
					// how many different places could this brick fit horizontally
					var groupCount = props.cols + 1 - colSpan,
							groupY = [],
							groupColY,
							i;

					// for each group potential horizontal position
					for ( i=0; i < groupCount; i++ ) {
						// make an array of colY values for that one group
						groupColY = props.colYs.slice( i, i+colSpan );
						// and get the max value of the array
						groupY[i] = Math.max.apply( Math, groupColY );
					}

					instance._masonryPlaceBrick( $this, groupY );
				}
			});
		};

		$.Isotope.prototype._masonryPlaceBrick = function ( $brick, setY ) {
			// get the minimum Y value from the columns
			var minimumY = Math.min.apply( Math, setY ),
					brickSize = getSize( $brick[0] ),
					shortCol = 0;

			// Find index of short column, the first from the left
			for (var i=0, len = setY.length; i < len; i++) {
				if ( setY[i] === minimumY ) {
					shortCol = i;
					break;
				}
			}

			// position the brick
			var x = this.masonry.columnWidth * shortCol,
					y = minimumY;
			this._pushPosition( $brick, x, y );

			// apply setHeight to necessary columns
			var setHeight = minimumY + brickSize.height,
					setSpan = this.masonry.cols + 1 - len;
			for ( i=0; i < setSpan; i++ ) {
				this.masonry.colYs[ shortCol + i ] = setHeight;
			}
		};

	};



	// Plugin bridge
	// =========================================================================
	// Leverages data method to either create or return plugin constructor
	//
	// Pattern developed by desandro for Masonry
	//		https://github.com/desandro/masonry/blob/master/jquery.masonry.js
	// Based off of jQuery UI's widget factory
	//		https://github.com/jquery/jquery-ui/blob/master/ui/jquery.ui.widget.js
	// And a bit from jcarousel
	//		https://github.com/jsor/jcarousel/blob/master/lib/jquery.jcarousel.js

	$.CoEnvFaculty.prototype.option = function( key ){
		if ( $.isPlainObject( key ) ){
			this.options = $.extend(true, this.options, key);
		}
	};

	$.fn.coenvfaculty = function( options ) {
		if ( typeof options === 'string' ) {
			// call method
			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {
				var instance = $.data( this, 'coenvfaculty' );
				if ( !instance ) {
					console.log( 'error', 'cannot call methods on coenvfaculty prior to initialization; ' +
						'attempted to call method "' + options + '"' );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === '_' ) {
					console.log( 'error', 'no such method "' + options + '" for coenvfaculty instance' );
					return;
				}

				// apply method
				instance[ options ].apply( instance, args );
			});
		} else {
			this.each(function() {
				var instance = $.data( this, 'coenvfaculty' );
				if ( instance ){
					// apply options & init
					instance.option( options || {} );
					instance._init();
				} else {
					// initialize new instance
					$.data( this, 'coenvfaculty', new $.CoEnvFaculty( options, this ) );
				}
			});
		}
		return this;
	};

})(jQuery, window, document);