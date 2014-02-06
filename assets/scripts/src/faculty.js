(function ($, window, document, undefined) {
	'use strict';

	var CoEnvFaculty = function () {
		this.init();
	};

	CoEnvFaculty.prototype = {

		// isotope item container
		$isoContainer: $('.Faculty-list-content'),

		// toolbox
		$toolbox: $('.Faculty-toolbox'),
		toolboxSelector: '.Faculty-toolbox',

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

		// isotope items
		$isoItems: $('.Faculty-list-item'),
		isoItemSelector: '.Faculty-list-item',
		isoItemFeaturedClass: 'Faculty-list-item--featured',
		isoItemImageSelector: '.Faculty-list-item-image',

		// Roller/form toggle
		$formToggle: $('.Faculty-toolbox-toggle'),
		formViewClass: 'Faculty-toolbox--show-form',

		// Form selects
		$form: $('.Faculty-toolbox-form'),
		$themeSelect: $('.Faculty-toolbox-theme-select'),
		$unitSelect: $('.Faculty-toolbox-unit-select'),

		// Feedback messages
		$feedback: $('.Faculty-toolbox-feedback'),
        $feedbackNumber: $('.Faculty-toolbox-feedback-number'),
        $feedbackMessage: $('.Faculty-toolbox-feedback-message'),
        feedbackMessageInclusive: $('.Faculty-toolbox-feedback-message').text(),
        feedbackMessage: 'Faculty members are working',
        feedbackMessageSingular: 'Faculty member is working',

		// Filter queue
		filterQ: {
			$rollerItem: $(),
			filters: {}
		},

		// Toolbox form
		$toolboxForm: $('.Faculty-toolbox-form')
	};

	CoEnvFaculty.prototype.init = function () {

		// initialize roller
		this.rollerInit();

		// update hash on 'filter' event
		this.updateHash();

		// sync form selects
		this.selectSync();

		// handle feedback
		this.feedback();

		// initialize isotope
		this.isoInit();

		// run filters passed through hash
		this.filterInit();

		// handle toggle between roller and form
		this.formToggleButton();

		// handle form selects
		this.formSelects();
	};

	/**
	 * Initialize Roller
	 */
	CoEnvFaculty.prototype.rollerInit = function () {

		// track measurements
		this.measurements();

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
	CoEnvFaculty.prototype.measurements = function () {
		var _this = this;

		var onResize = function () {
			_this.windowHeight = $(window).height();
			_this.rollerHeight = _this.$roller.height();
			_this.rollerOffsetTop = _this.$roller.offset().top;
			_this.rollerCenter = _this.rollerOffsetTop + ( _this.rollerHeight / 2 );
			_this.rollerInnerOffset = _this.$rollerInner.offset().top;
		};

		onResize();
		$(window).one( 'debouncedresize', onResize );

		var onScroll = function () {
			_this.scrollTop = $(window).scrollTop();
		};

		onScroll();
		$(window).on( 'scroll', onScroll );
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
				filters: {
					theme: {
						name: $item.text(),
						slug: $item.data('theme')
					}
				}
			});

		} );
	};

	/**
	 * Initialize Isotope
	 */
	CoEnvFaculty.prototype.isoInit = function () {
		var _this = this,
			isoOpts;

		// set up isotope options
		isoOpts = {
			isInitLayout: false,
			itemSelector: this.isoItemSelector,
			stamp: this.toolboxSelector,
			masonry: {
				columnWidth: '.grid-sizer'
			}
		};

		// initialize isotope without layout
		this.$isoContainer.isotope( isoOpts );

		// register layoutComplete listener
		// this will not fire on initialization,
		// only on subsequent layouts
		this.$isoContainer.isotope( 'on', 'layoutComplete', function () {
			_this.$isoContainer.trigger( 'isoLayoutComplete' );
		} );

		// layout isotope
		this.$isoContainer.isotope( isoOpts );

		// handle isotope filtering
		this.isoFilter();

		// save item offsets
		this.isoItemOffsets();

		// isotope image lazy loader
		this.isoLazyLoader();
	};

	/**
	 * Save isotope item offsets
	 */
	CoEnvFaculty.prototype.isoItemOffsets = function () {
		var _this = this;

		var saveOffset = function () {
			$.each( _this.$isoItems, function ( index, el ) {
				$(this).data( 'offset', $(this).offset().top );
			} );
		};

		saveOffset();
		$(window).on( 'debouncedresize', saveOffset );
		this.$isoContainer.on( 'isoLayoutComplete', saveOffset );
	};

	/**
	 * Isotope image lazy loader
	 */
	CoEnvFaculty.prototype.isoLazyLoader = function () {
		var _this = this,
			$items;

		var lazyload = function () {
			$items = _this.$isoItems.not('[data-loaded]');

			if ( $items.length === 0 ) {
				return;
			}

			$.each( $items, function ( index, el ) {

				// return if item is visible
				if ( !_this.isoItemVisible( el ) ) {
					return;
				}

				// add data-picture attribute
				// which will flag this element for picturefill
				$(el).find( _this.isoItemImageSelector ).attr('data-picture', '');

				// add data-loaded attribute so
				// we don't have to loop over this item again
				$(el).attr('data-loaded', '');
			} );

			// run picturefill
			window.picturefill();
		};

		lazyload();
		$(window).on( 'scroll', lazyload );
		this.$isoContainer.on( 'isoLayoutComplete', lazyload );
	};

	/**
	 * Check if an isotope item is visible
	 */
	CoEnvFaculty.prototype.isoItemVisible = function ( el ) {
		return ( $(el).data('offset') < ( this.windowHeight + this.scrollTop ) );
	};

	/**
	 * Isotope filtering
	 */
	CoEnvFaculty.prototype.isoFilter = function () {
		var _this = this,
			filterString,
			$firstItem;

		// listen for filter event
		this.$isoContainer.on( 'filter', function ( event, data ) {

			filterString = _this.buildIsoFilterString( data.filters );

			// the first item in a filtered set should never be featured
			// (i.e. big), otherwise the layout will break
			$firstItem = _this.$isoItems.filter( filterString ).first().removeClass( _this.isoItemFeaturedClass );

			// filter isotope
			_this.$isoContainer.isotope( { filter: filterString } );

		} );
	};

	/**
	 * Run filters passed through hash on page load
	 */
	CoEnvFaculty.prototype.filterInit = function () {
		var _this = this,
			hashFilters = this.hashFilters(),
			data = { filters: {} },
			theme,
			unit,
			$selectOpt,
			$item;

		if (! hashFilters) {

			// fill out filter defaults
			data.filters = {
				theme: {
					name: 'All Research Themes',
					slug: 'theme-all'
				},
				unit: {
					name: 'All Schools/Departments',
					slug: 'unit-all'
				}
			};

			// go to first roller item
			data.$rollerItem = this.$roller.find( this.rollerItemSelector ).first();

		} else {

			$.each( hashFilters, function () {
				$selectOpt = _this.$toolboxForm.find('option[value="' + this + '"]');

				data.filters[ this.split('-')[0] ] = {
					name: $selectOpt.text(),
					slug: this
				};
			} );

			// if a unit is passed through the hash,
			// show form view
			if ( data.filters.unit.slug !== 'unit-all' ) {
				this.formToggleOn();
			}

			data.$rollerItem = this.$roller.find( this.rollerItemSelector ).filter( function () {
				if ( $(this).find('a').data('theme') === data.filters.theme.slug ) {
					return true;
				}
			} );

		}

		this.doFilter( data );
	};

	/**
	 * Parse url hash
	 */
	CoEnvFaculty.prototype.hashFilters = function () {
		var hash = window.location.hash,
			filters;

		// return false if hash is blank or plain hash
		if ( hash === '' || hash === '#' ) {
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

		for ( var prop in data.filters ) {

			// translate '*' to 'theme-all' or 'unit-all'
			if ( data.filters[ prop ].slug === '*' ) {
				data.filters[ prop ].slug = prop + '-all';
			}

			this.filterQ.filters[ prop ] = data.filters[ prop ];
		}

		this.filterQ.$rollerItem = data.$rollerItem;

		this.$isoContainer.trigger( 'filter', [ this.filterQ ] );
	};

	/**
	 * Update hash on 'filter' event
	 */
	CoEnvFaculty.prototype.updateHash = function () {
		var _this = this,
			hash;

		this.$isoContainer.on( 'filter', function ( event, data ) {
			hash = _this.buildHashFromFilters( data.filters );

			if ( hash === 'theme-all&unit-all' ) {
				hash = '';
			}

			window.location.hash = hash;
		} );
	};

	/**
	 * Build an isotope filter string
	 */
	CoEnvFaculty.prototype.buildIsoFilterString = function ( filters ) {
		return $.map( filters, function ( val ) {
			return '.' + val.slug;
		} ).join('');
	};

	/**
	 * Build hash from isotope filters
	 */
	CoEnvFaculty.prototype.buildHashFromFilters = function ( filters ) {
		return $.map( filters, function ( val ) {
			return val.slug;
		} ).join('&');
	};

	/**
	 * Handle toggling between form and roller in toolbox
	 */
	CoEnvFaculty.prototype.formToggleButton = function () {
		var _this = this;

		this.$formToggle.on( 'click', function ( event ) {
			event.preventDefault();

			if ( _this.$toolbox.hasClass( _this.formViewClass ) ) {
				_this.formToggleOff();
			} else {
				_this.formToggleOn();
			}
		} );
	};

	/**
	 * Toggle toolbox form view on
	 */
	CoEnvFaculty.prototype.formToggleOn = function () {

		if ( ! this.$toolbox.hasClass( this.formViewClass ) ) {
			this.$toolbox.addClass( this.formViewClass );
		}
	};

	/**
	 * Toggle toolbox form view off
	 */
	CoEnvFaculty.prototype.formToggleOff = function () {

		if ( this.$toolbox.hasClass( this.formViewClass ) ) {
			this.$toolbox.removeClass( this.formViewClass );

			// clear units from filter
			this.resetUnits();
		}
	};

	/**
	 * Sync form selects after 'filter' event
	 */
	CoEnvFaculty.prototype.selectSync = function () {
		var _this = this,
			$themeOpt,
			$unitOpt;

		this.$isoContainer.on( 'filter', function ( event, data ) {

			$themeOpt = _this.$themeSelect.find('option[value="' + data.filters.theme.slug + '"]');
			$themeOpt.attr( 'selected', 'selected' );

			$unitOpt = _this.$unitSelect.find('option[value="' + data.filters.unit.slug + '"]');
			$unitOpt.attr( 'selected', 'selected' );
		} );
	};

	/**
	 * Reset 'unit' filter to all
	 */
	CoEnvFaculty.prototype.resetUnits = function () {
		this.doFilter({
			filters: {
				unit: {
					slug: 'unit-all'
				}
			}
		});
	};

	/**
	 * Handle form selects
	 */
	CoEnvFaculty.prototype.formSelects = function () {
		var _this = this,
			data = {},
			$opt;

		this.$themeSelect.on( 'change', function () {

			$opt = $(this).find('option:selected');

			data.filters = {
				theme: {
					name: $opt.text(),
					slug: $opt.val()
				}
			};

			data.$rollerItem = _this.$roller.find( _this.rollerItemSelector ).filter( function () {
				if ( $(this).find('a').data('theme') === data.filters.theme.slug ) {
					console.log();
					return true;
				}
			} );

			_this.doFilter( data );
		} );

		this.$unitSelect.on( 'change', function () {

			$opt = $(this).find('option:selected');

			_this.doFilter({
				filters: {
					unit: {
						name: $opt.text(),
						slug: $opt.val()
					}
				}
			});
		} );
	};

	/**
	 * Handle feedback messages
	 */
	CoEnvFaculty.prototype.feedback = function () {
		var _this = this,
		number,
		message,
		themeLink,
		unitLink;

		var doFeedback = function ( data ) {

			themeLink = '<a href="' + data.filters.theme.url + '">' + data.filters.theme.name + '</a>';
			unitLink = '<a href="' + data.filters.unit.url + '">' + data.filters.unit.name + '</a>';

			// get number of filtered items
			number = _this.$isoContainer.data('isotope').filteredItems.length;

			console.log(number);

			// singular or plural message?
			message = number === 1 ? _this.feedbackMessageSingular : _this.feedbackMessage;

			if ( data.filters.theme.slug === 'theme-all' ) {

				// all themes are selected
				// is the form view active?
				if ( _this.$toolbox.hasClass( _this.formViewClass ) ) {

					// show unit message
					message += ' in ' + unitLink;

				} else {

					// we're in the theme roller view
					message = _this.feedbackMessageInclusive;
				}

			} else {

				// single theme is selected
				message += ' on ' + themeLink;

				// is the form view active?
				if ( _this.$toolbox.hasClass( _this.formViewClass ) ) {

					message += ' in ' + unitLink;

				}
			}

			// update feedback number
			_this.$feedbackNumber.text( number );

			// update feedback message
			_this.$feedbackMessage.html( message );

		};

		this.$isoContainer.on( 'filter', function ( event, data ) {

			_this.$isoContainer.one( 'isoLayoutComplete', function () {

				doFeedback( data );

			} );

		} );

	};

	new CoEnvFaculty();

})(jQuery, window, document);