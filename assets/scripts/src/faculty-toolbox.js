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

        // Roller items
        rollerItemSelector: '.Faculty-toolbox-roller-item',
        rollerItemActiveClass: 'Faculty-toolbox-roller-item--active',
        activeRollerItem: '',

        // Feedback
        $feedback: $('.Faculty-toolbox-feedback'),
        $feedbackNumber: $('.Faculty-toolbox-feedback-number'),
        $feedbackMessage: $('.Faculty-toolbox-feedback-message'),
        feedbackMessageInclusive: $('.Faculty-toolbox-feedback-message').text(),
        feedbackMessage: 'Faculty members are working',
        feedbackMessageSingular: 'Faculty member is working',

        // Theme and unit selectors
        $themeSelect: $('.Faculty-toolbox-theme-select'),
        $unitSelect: $('.Faculty-toolbox-unit-select'),

        // Toggle between roller and form
        $formToggle: $('.Faculty-toolbox-toggle'),
        formViewClass: 'Faculty-toolbox--show-form'
    };

    /**
     * Events
     *
     * Page load:
     *      * Check for URL hash
     *      * Check for presence of theme and unit
     *      * update data-filters on isoContainer
     *      * trigger filter event on isoContainer
     * 
     * Selecting theme roller item,
     * Selecting theme or unit from form selects:
     *      * updates data-filters on isoContainer
     *      * triggers filter event on isoContainer
     *
     * Each element subscribes to 'filter' event on isoContainer:
     *      * if data.caller is self, don't do anything
     *      * if data.caller is not self, take action
     */

    /**
     * Initialize
     */
    CoEnvFacultyToolbox.prototype.init = function () {

        // initialize roller
        this.rollerInit();

        // initialize activeFilters
        this.activeFilters = this.resetActiveFilters();

        // slide to active roller item
        this.slideToActiveItem();

        // handle item selection
        this.rollerItemSelection();

        // handle feedback messages
        this.feedback();

        // toggle between roller and form
        this.formToggle();

        // sync select boxes
        this.selectSync();
    };

    /**
     * Set up roller structure, events and animation
     */
    CoEnvFacultyToolbox.prototype.rollerInit = function () {

        // keep track of rollermeasurements 
        this.rollerMeasure();

        // add roller item sets when roller rolls
        this.rollerSets();
    };

    /**
     * Keep track of roller measurements
     */
    CoEnvFacultyToolbox.prototype.rollerMeasure = function () {
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
     * Handle adding sets when roller rolls
     *
     * Listens for $roller 'preroll' event, and adds
     * roller item sets above or below depending on
     * roll direction.
     */
    CoEnvFacultyToolbox.prototype.rollerSets = function () {
        var _this = this,
            $firstItem,
            firstItemOffset,
            $lastItem,
            lastItemOffset,
            lastItemHeight;

        this.$roller.on( 'preroll', function ( event, data ) {

            $firstItem = _this.$roller.find( _this.rollerItemSelector ).first();
            firstItemOffset = $firstItem.offset().top;

            $lastItem = _this.$roller.find( _this.rollerItemSelector ).last();
            lastItemOffset = $lastItem.offset().top;
            lastItemHeight = $lastItem.outerHeight();

            // if top of first item (will be) > top of roller - amount of change
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
     * Prepend roller item set
     */
    CoEnvFacultyToolbox.prototype.rollerPrependSet = function () {
        var $newSet;

        // update roller set prepend position
        this.rollerSetPrependPos -= this.$rollerSet.outerHeight();

        // clone a new set to prepend
        $newSet = this.$rollerSet.clone(true);

        $newSet.css( 'top', this.rollerSetPrependPos );

        this.$rollerInner.prepend( $newSet );
    };

    /**
     * Append roller item set
     */
    CoEnvFacultyToolbox.prototype.rollerAppendSet = function () {
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

            _this.activeFilters.theme = {
                name: $item.text(),
                slug: $item.data('theme') === '*' ? 'theme-all' : $item.data('theme'),
                url: $item.attr('href')
            };

            _this.isoFilter();
        } );
    };

    /**
     * Slide to active theme item
     */
    CoEnvFacultyToolbox.prototype.slideToActiveItem = function () {
        var _this = this,
            themeSelector;

        var $item = this.$roller.find( this.rollerItemSelector ).filter(function () {

            themeSelector = $(this).find('a').data('theme');
            themeSelector = themeSelector === '*' ? 'theme-all' : themeSelector;

            if ( themeSelector === _this.activeFilters.theme.slug ) {
                return true;
            }
        });

        this.slideToItem( $item );
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
     * Triggers isotope filter
     * on active filters
     */
    CoEnvFacultyToolbox.prototype.isoFilter = function () {

        // trigger isotope
        this.$isoContainer.trigger( 'filter', [ this.activeFilters ] );
    };

    /**
     * Handle feedback messages
     */
    CoEnvFacultyToolbox.prototype.feedback = function () {
        var _this = this,
            number,
            message,
            themeLink,
            unitLink;

        var doFeedback = function () {

            themeLink = '<a href="' + _this.activeFilters.theme.url + '">' + _this.activeFilters.theme.name + '</a>';
            unitLink = '<a href="' + _this.activeFilters.unit.url + '">' + _this.activeFilters.unit.name + '</a>';

            // get number of filtered items
            number = _this.$isoContainer.data('isotope').filteredItems.length;

            // singular or plural message?
            message = number === 1 ? _this.feedbackMessageSingular : _this.feedbackMessage;

            // is 'all themes' selected?
            if ( _this.activeFilters.theme.slug === 'theme-all' ) {

                // is the form view active?
                if ( _this.$toolbox.hasClass( _this.formViewClass ) ) {



                } else {

                    // we're in the theme roller view
                    message = _this.feedbackMessageInclusive;
                }

            } else {

                // single theme is selected
                message += ' on ' + themeLink;

                // is the form view active?
                if ( _this.$toolbox.hasClass( _this.formViewClass ) ) {

                }
            }

            // update feedback message
            _this.$feedbackMessage.html( message );

        };

        doFeedback();

        this.$isoContainer.on( 'filter', function ( event, data ) {
            doFeedback( data );
        } );
    };

    /**
     * Reset filter queue
     */
    CoEnvFacultyToolbox.prototype.resetActiveFilters = function () {

        // check hash for passed filters
        var filters = {},
            hashes,
            themeSlug,
            unitSlug,
            $themeOpt,
            $unitOpt;

        if ( window.location.hash ) {

            hashes = window.location.hash.replace( '#', '' ).split('&');

            themeSlug = hashes[0];
            unitSlug = hashes[1];

            $themeOpt = this.$themeSelect.find('option').filter(function() {
                if ( $(this).val() === themeSlug ) {
                    return true;
                }
            });

            $unitOpt = this.$unitSelect.find('option').filter(function() {
                if ( $(this).val() === unitSlug ) {
                    return true;
                }
            });

            filters = {
                theme: {
                    name: $themeOpt.text(),
                    slug: themeSlug,
                    url: $themeOpt.data('url')
                },
                unit: {
                    name: $unitOpt.text(),
                    slug: unitSlug,
                    url: $unitOpt.data('url')
                }
            };

        } else {

            $themeOpt = this.$themeSelect.find('option').first();
            $unitOpt = this.$unitSelect.find('option').first();

            filters = {
                theme: {
                    name: $themeOpt.text(),
                    slug: 'theme-all',
                    url: '#'
                },
                unit: {
                    name: $unitOpt.text(),
                    slug: 'unit-all',
                    url: '#'
                }
            };

        }

        return filters;
    };

    /**
     * Toggle between roller and form
     */
    CoEnvFacultyToolbox.prototype.formToggle = function () {
        var _this = this;

        this.$formToggle.on( 'click', function ( event ) {
            event.preventDefault();

            if ( _this.$toolbox.hasClass( _this.formViewClass ) ) {
                _this.$toolbox.removeClass( _this.formViewClass );
            } else {
                _this.$toolbox.addClass( _this.formViewClass );
            }
        } );
    };

    /**
     * Sync select boxes with active filters
     */
    CoEnvFacultyToolbox.prototype.selectSync = function () {
        var _this = this,
            $themeOpt,
            $unitOpt;

        function doSync () {

            $themeOpt = _this.$themeSelect.find('option').filter( function () {
                if ( $(this).val() === _this.activeFilters.theme.slug ) {
                    return true;
                }
            } ).attr('selected', 'selected');

            $unitOpt = _this.$unitSelect.find('option').filter( function () {
                if ( $(this).val() === _this.activeFilters.unit.slug ) {
                    return true;
                }
            } ).attr('selected', 'selected');

        }

        doSync();

        this.$isoContainer.on( 'filter', doSync );
    };

    new CoEnvFacultyToolbox();

})(jQuery, window, document);