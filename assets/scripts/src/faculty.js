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
		$searchField: $('.Faculty-toolbox-search'),
		$searchFeedback: $('.Faculty-toolbox-search-feedback'),

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
		$toolboxForm: $('.Faculty-toolbox-form'),

		// Mobile view select form
		$mobileForm: $('.Faculty-selector'),
		$mobileThemeSelect: $('.Faculty-selector-theme'),
		$mobileUnitSelect: $('.Faculty-selector-unit'),
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

		// handle clicking on feedback link
		this.feedbackLinks();

		// initialize isotope
		this.isoInit();

		// run filters passed through hash
		this.filterInit();

		// handle toggle between roller and form
		this.formToggleButton();

		// handle form selects
		this.formSelects();

		// handle search
		this.handleSearch();

		// handle mobile form
		this.mobileForm();
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
			$item;
			//itemOffset,
			//itemPos,
			//itemHeight,
			//newInnerPos;

		function doRoll ( $item ) {

			if ( $item === undefined || $item.length === 0 ) {
				return;
			}
	        
	        //var innerOffset = _this.$rollerInner.offset().top;
	        //var itemOffset = $item.offset().top;

	        //var itemPos = itemOffset - innerOffset;
	        //var itemHeight = $item.outerHeight();

	        //var newInnerPos = ( -itemPos + ( _this.rollerCenter - _this.rollerOffsetTop ) ) - ( itemHeight / 2 );

	        // deactivate active items
	        _this.$roller.find( '.' + _this.rollerItemActiveClass ).removeClass( _this.rollerItemActiveClass );
            
            $item.eq(2).addClass( 'scroll-here' );

	        // make item active
	        $item.addClass( _this.rollerItemActiveClass );

	        // trigger roller 'preroll' event
	        // need to pass change
	        // _this.$roller.trigger( 'preroll', [{
	        //     change: newInnerPos - _this.rollerInnerPos
	        //}] );

	        //_this.$rollerInner.css( 'transform', 'translateY(' + newInnerPos + 'px)' );

	        // update rollerInnerPos
	        //_this.rollerInnerPos = newInnerPos;

	        // trigger roller 'postroll'
	        //_this.$roller.trigger( 'postroll', [{
            //    change: _this.rollerInnerPos
            //}] );
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
						slug: $item.data('theme'),
						url: $item.attr('href')
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
	 * Run filters passed through hash on page load
	 */
	CoEnvFaculty.prototype.filterInit = function () {
		var _this = this,
			hashFilters = this.hashFilters(),
			data = { filters: {} },
			theme,
			unit,
			$selectOpt,
			$item,
			$optAllThemes,
			$optAllUnits;

		$optAllThemes = this.$themeSelect.find('option[value="theme-all"]');
		$optAllUnits = this.$unitSelect.find('option[value="unit-all"]');

		if (! hashFilters) {

			// fill out filter defaults
			data.filters = {
				theme: {
					name: $optAllThemes.text(),
					slug: $optAllThemes.val(),
					url: $optAllThemes.data('url')
				},
				unit: {
					name: $optAllUnits.text(),
					slug: $optAllUnits.val(),
					url: $optAllUnits.data('url')
				}
			};

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
			if ( data.filters.unit !== undefined && data.filters.unit.slug !== 'unit-all' ) {
				this.formToggleOn();
			}
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

		// if data.$rollerItem is not passed, find the roller item based on theme filter
		if ( data.$rollerItem === undefined && data.filters !== undefined && data.filters.theme !== undefined ) {

			data.$rollerItem = this.$roller.find( this.rollerItemSelector ).filter( function () {
				var theme = _this.filterQ.filters.theme.slug === 'theme-all' ? '*' : _this.filterQ.filters.theme.slug;

				if ( $(this).find('a').data('theme') === theme ) {
					return true;
				}
			} );
		}

		// check if search was passed (overrides filters)
		if ( data.search !== undefined ) {

			this.filterQ.filters = {
				search: data.search,
				theme: {
					slug: 'theme-all'
				},
				unit: {
					slug: 'unit-all'
				}
			};
		}

		// pass through feedback or overwrite if undefined
		this.filterQ.feedback = data.feedback;

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
		var filterString;

		filterString = $.map( filters, function ( val ) {
			if ( val.slug !== undefined ) {
				return '.' + val.slug;
			}
		} ).join('');

		if ( filters.search !== undefined ) {
			filterString = '.' + filters.search.ids.join(',.');
		}

		return filterString;
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

			// clear search
			this.clearSearch();

			// clear units from filter
			this.resetFilter('unit');
		}
	};

	/**
	 * Sync form selects after 'filter' event
	 */
	CoEnvFaculty.prototype.selectSync = function () {
		var _this = this,
			themeOptSelector,
			unitOptSelector;

		this.$isoContainer.on( 'filter', function ( event, data ) {

			if ( data.filters.theme !== undefined ) {

				themeOptSelector = 'option[value="' + data.filters.theme.slug + '"]';
				_this.$themeSelect.find( themeOptSelector ).attr( 'selected', 'selected' );
				_this.$mobileThemeSelect.find( themeOptSelector ).attr( 'selected', 'selected' );
			}

			if ( data.filters.unit !== undefined ) {

				unitOptSelector = 'option[value="' + data.filters.unit.slug + '"]';
				_this.$unitSelect.find( unitOptSelector ).attr( 'selected', 'selected' );
				_this.$mobileUnitSelect.find( unitOptSelector ).attr( 'selected', 'selected' );
			}
		} );
	};

	/**
	 * Reset either 'theme' or 'unit' filter
	 */
	CoEnvFaculty.prototype.resetFilter = function ( filter ) {
		var data = { filters: {} };

		data.filters[ filter ] = {
			slug: filter + '-all'
		};

		this.doFilter( data );
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
					slug: $opt.val(),
					url: $opt.data('url')
				}
			};

			_this.clearSearch();

			_this.doFilter( data );
		} );

		this.$unitSelect.on( 'change', function () {

			$opt = $(this).find('option:selected');

			_this.clearSearch();

			_this.doFilter({
				filters: {
					unit: {
						name: $opt.text(),
						slug: $opt.val(),
						url: $opt.data('url')
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

			if ( data.filters.theme !== undefined ) {
				themeLink = '<a href="' + data.filters.theme.url + '" data-slug="' + data.filters.theme.slug + '">' + data.filters.theme.name + '</a>';
			}

			if ( data.filters.unit !== undefined ) {
				unitLink = '<a href="' + data.filters.unit.url + '" data-slug="' + data.filters.unit.slug + '">' + data.filters.unit.name + '</a>';
			}

			// get number of filtered items
			number = _this.$isoContainer.data('isotope').filteredItems.length;

			// singular or plural message?
			message = number === 1 ? _this.feedbackMessageSingular : _this.feedbackMessage;

			if ( data.filters.theme !== undefined && data.filters.theme.slug === 'theme-all' ) {

				// all themes are selected
				// is the form view active?
				if ( _this.$toolbox.hasClass( _this.formViewClass ) ) {

					if ( data.filters.unit.slug === 'unit-all' ) {

						message = _this.feedbackMessageInclusive;

					} else {

						// show unit message
						message += ' in ' + unitLink;

					}

				} else {

					// we're in the theme roller view
					message = _this.feedbackMessageInclusive;
				}

			} else {

				// single theme is selected
				message += ' on ' + themeLink;

				// is the form view active?
				if ( _this.$toolbox.hasClass( _this.formViewClass ) ) {

					if ( data.filters.unit.slug !== 'unit-all' ) {

						message += ' in ' + unitLink;

					}
				}
			}

			// search
			if ( data.search !== undefined ) {
				message = 'searching';
			}

			// data.feedback overrides the above
			if ( data.feedback !== undefined ) {
				message = data.feedback;
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

	/**
	 * Handle clicking on feedback links
	 */
	CoEnvFaculty.prototype.feedbackLinks = function () {
		var _this = this,
			data = {};

		this.$feedback.on( 'click', 'a', function ( event ) {
			event.preventDefault();

			if ( $(this).attr('href') === window.location ) {
				return;
			}

			for ( var filter in _this.filterQ.filters ) {
				if ( _this.filterQ.filters[ filter ].slug !== $(this).data('slug') ) {
					_this.resetFilter( filter );
				}
			}

		} );
	};

	/**
	 * Handle search
	 * Sanitization/validation is handled by member-api
	 */
	CoEnvFaculty.prototype.handleSearch = function () {
		var _this = this,
			searchData,
			searchResponse,
			memberIDs,
			data = {};

		this.$form.on( 'submit', function ( event ) {
			event.preventDefault();

			searchData = {
				action: 'coenv_member_api_search',
				data: _this.$searchField.val()
			};

			$.post( themeVars.ajaxurl, searchData, function ( response ) {
				searchResponse = $.parseJSON( response );

				if ( searchResponse.number === 0 ) {

					memberIDs = [ 'Faculty-list-item--*' ];
				} else {

					// map memberIDs
					memberIDs = $.map( searchResponse.results, function ( val ) {
						return 'Faculty-list-item--' + val.ID;
					} );
				}

				data.feedback = searchResponse.message;

				data.search = {
					ids: memberIDs,
					keywords: searchResponse.message
				};

				// filter isotope by member ids
				_this.doFilter( data );
			} );

		} );
	};

	/**
	 * Clear search
	 */
	CoEnvFaculty.prototype.clearSearch = function () {
		this.$searchField.val('');
		delete this.filterQ.filters.search;
	};

	/**
	 * this.$themeSelect.on( 'change', function () {

			$opt = $(this).find('option:selected');

			data.filters = {
				theme: {
					name: $opt.text(),
					slug: $opt.val(),
					url: $opt.data('url')
				}
			};

			_this.clearSearch();

			_this.doFilter( data );
		} );

		this.$unitSelect.on( 'change', function () {

			$opt = $(this).find('option:selected');

			_this.clearSearch();

			_this.doFilter({
				filters: {
					unit: {
						name: $opt.text(),
						slug: $opt.val(),
						url: $opt.data('url')
					}
				}
			});
		} );
	 */

	/**
	 * Handle mobile form
	 * This only shows for smaller viewports instead of the toolbox
	 */
	CoEnvFaculty.prototype.mobileForm = function () {
		var _this = this,
			$opt;

		this.$mobileForm.on( 'submit', function ( event ) {
			event.preventDefault();
		} );

		this.$mobileThemeSelect.on( 'change', function () {

			$opt = $(this).find('option:selected');

			_this.clearSearch();

			_this.doFilter({
				filters: {
					theme: {
						name: $opt.text(),
						slug: $opt.val(),
						url: $opt.data('url')
					}
				}
			});
		} );

		this.$mobileUnitSelect.on( 'change', function () {

			$opt = $(this).find('option:selected');

			_this.clearSearch();

			_this.doFilter({
				filters: {
					unit: {
						name: $opt.text(),
						slug: $opt.val(),
						url: $opt.data('url')
					}
				}
			});
		} );

		// reset selects
	};

	new CoEnvFaculty();

})(jQuery, window, document);