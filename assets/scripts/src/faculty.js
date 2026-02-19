(function ($, window, document, undefined) {
    'use strict';

    var CoEnvFaculty = function () {
        // We do not call init() here automatically anymore.
        // We call it manually inside the DOM ready block at the bottom.
    };

    CoEnvFaculty.prototype = {
        // Define null placeholders for properties that will be populated in init()
        // This prevents "undefined" errors if methods are called out of order
        $isoContainer: null,
        $toolbox: null,
        $roller: null,
        $rollerInner: null,
        $rollerSet: null,
        $isoItems: null,
        $formToggle: null,
        $form: null,
        $themeSelect: null,
        $unitSelect: null,
        $searchField: null,
        $searchFeedback: null,
        $feedback: null,
        $feedbackNumber: null,
        $feedbackMessage: null,
        $toolboxForm: null,
        $mobileForm: null,
        $mobileThemeSelect: null,
        $mobileUnitSelect: null,

        // Static Configuration
        toolboxSelector: '.Faculty-toolbox',
        rollerItemSelector: '.Faculty-toolbox-roller-item',
        rollerItemActiveClass: 'Faculty-toolbox-roller-item--active',
        isoItemSelector: '.Faculty-list-item',
        isoItemFeaturedClass: 'Faculty-list-item--featured',
        isoItemImageSelector: '.Faculty-list-item-image',
        formViewClass: 'Faculty-toolbox--show-form',
        
        // State variables
        rollerInnerPos: 0,
        rollerSetPrependPos: 0,
        rollerSetAppendPos: 0,
        feedbackMessageInclusive: '',
        feedbackMessage: 'Faculty members are working',
        feedbackMessageSingular: 'Faculty member is working',

        // Filter queue
        filterQ: {
            $rollerItem: $(),
            filters: {}
        }
    };

    CoEnvFaculty.prototype.init = function () {
        // 1. Initialize DOM Elements (Selectors)
        // We do this here to ensure the HTML exists before we try to find it.
        this.$isoContainer = $('.Faculty-list-content');
        this.$toolbox = $('.Faculty-toolbox');
        this.$roller = $('.Faculty-toolbox-roller-items');
        this.$rollerInner = $('.Faculty-toolbox-roller-items-inner');
        this.$rollerSet = $('.Faculty-toolbox-roller-items-set');
        this.$isoItems = $('.Faculty-list-item');
        this.$formToggle = $('.Faculty-toolbox-toggle');
        this.$form = $('.Faculty-toolbox-form');
        this.$toolboxForm = $('.Faculty-toolbox-form'); // Same as $form
        this.$themeSelect = $('.Faculty-toolbox-theme-select');
        this.$unitSelect = $('.Faculty-toolbox-unit-select');
        this.$searchField = $('.Faculty-toolbox-search');
        this.$searchFeedback = $('.Faculty-toolbox-search-feedback');
        this.$feedback = $('.Faculty-toolbox-feedback');
        this.$feedbackNumber = $('.Faculty-toolbox-feedback-number');
        this.$feedbackMessage = $('.Faculty-toolbox-feedback-message');
        
        // Grab initial text for inclusive message
        this.feedbackMessageInclusive = this.$feedbackMessage.text();

        // Mobile elements
        this.$mobileForm = $('.Faculty-selector');
        this.$mobileThemeSelect = $('.Faculty-selector-theme');
        this.$mobileUnitSelect = $('.Faculty-selector-unit');

        // 2. Initialize Logic
        this.rollerInit();
        this.updateHash();
        this.selectSync();
        this.feedback();
        this.feedbackLinks();
        this.isoInit();      // This calls isoFilter
        this.filterInit();
        this.formToggleButton();
        this.formSelects();
        this.handleSearch();
        this.mobileForm();
    };

    /**
     * Initialize Roller
     */
    CoEnvFaculty.prototype.rollerInit = function () {
        this.measurements();
        this.rollerAddSets();
        this.rollerInteractions();
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
            // Guard against undefined elements if DOM is missing parts
            if (_this.$roller.length) {
                _this.rollerOffsetTop = _this.$roller.offset().top;
                _this.rollerCenter = _this.rollerOffsetTop + (_this.rollerHeight / 2);
            }
            if (_this.$rollerInner.length) {
                _this.rollerInnerOffset = _this.$rollerInner.offset().top;
            }
        };

        onResize();
        $(window).one('debouncedresize', onResize);

        var onScroll = function () {
            _this.scrollTop = $(window).scrollTop();
        };

        onScroll();
        $(window).on('scroll', onScroll);
    };

    /**
     * Add Roller item sets on roll
     */
    CoEnvFaculty.prototype.rollerAddSets = function () {
        var _this = this;

        this.$roller.on('preroll', function (event, data) {
            var $rollerItems = _this.$roller.find(_this.rollerItemSelector);
            var $firstItem = $rollerItems.first();
            var $lastItem = $rollerItems.last();

            if (!$firstItem.length || !$lastItem.length) return;

            var firstItemOffset = $firstItem.offset().top;
            var lastItemOffset = $lastItem.offset().top;
            var lastItemHeight = $lastItem.outerHeight();

            if (firstItemOffset > _this.rollerOffsetTop - data.change) {
                _this.rollerPrependSet();
            }

            if (lastItemOffset + lastItemHeight < _this.rollerOffsetTop + _this.rollerHeight - data.change) {
                _this.rollerAppendSet();
            }
        });
    };

    /**
     * Move roller to active item
     */
    CoEnvFaculty.prototype.rollerSlider = function () {
        var _this = this;

        function doRoll($item) {
            if ($item === undefined || $item.length === 0) {
                return;
            }

            // deactivate active items
            _this.$roller.find('.' + _this.rollerItemActiveClass).removeClass(_this.rollerItemActiveClass);

            // Using eq(2) specifically per original logic
            $item.eq(2).addClass('scroll-here');

            // make item active
            $item.addClass(_this.rollerItemActiveClass);
        }

        this.$isoContainer.on('filter', function (event, data) {
            doRoll(data.$rollerItem);
        });
    };

    CoEnvFaculty.prototype.rollerPrependSet = function () {
        this.rollerSetPrependPos -= this.$rollerSet.outerHeight();
        var $newSet = this.$rollerSet.clone(true);
        $newSet.css('top', this.rollerSetPrependPos);
        this.$rollerInner.prepend($newSet);
    };

    CoEnvFaculty.prototype.rollerAppendSet = function () {
        this.rollerSetAppendPos += this.$rollerSet.outerHeight();
        var $newSet = this.$rollerSet.clone(true);
        $newSet.css('top', this.rollerSetAppendPos);
        this.$rollerInner.append($newSet);
    };

    CoEnvFaculty.prototype.rollerInteractions = function () {
        var _this = this;

        this.$roller.on('click', this.rollerItemSelector, function (event) {
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
        });
    };

    /**
     * Initialize Isotope
     */
    CoEnvFaculty.prototype.isoInit = function () {
        var _this = this;
        var isoOpts = {
            isInitLayout: false, // Don't layout immediately
            itemSelector: this.isoItemSelector,
            stamp: this.toolboxSelector,
            masonry: {
                columnWidth: '.grid-sizer'
            }
        };

        // Initialize Isotope
        this.$isoContainer.isotope(isoOpts);

        // Register layoutComplete listener
        this.$isoContainer.isotope('on', 'layoutComplete', function () {
            _this.$isoContainer.trigger('isoLayoutComplete');
        });

        // Handle isotope filtering
        // This is the function causing the error in the previous version
        if (typeof this.isoFilter === 'function') {
            this.isoFilter(); 
        } else {
            console.error('isoFilter is missing');
        }

        // Save item offsets
        this.isoItemOffsets();

        // Isotope image lazy loader
        this.isoLazyLoader();
        
        // Trigger initial layout
        this.$isoContainer.isotope('layout');
    };

    CoEnvFaculty.prototype.isoItemOffsets = function () {
        var _this = this;
        var saveOffset = function () {
            $.each(_this.$isoItems, function (index, el) {
                $(this).data('offset', $(this).offset().top);
            });
        };
        saveOffset();
        $(window).on('debouncedresize', saveOffset);
        this.$isoContainer.on('isoLayoutComplete', saveOffset);
    };

    CoEnvFaculty.prototype.isoLazyLoader = function () {
        var _this = this;

        var lazyload = function () {
            var $items = _this.$isoItems.not('[data-loaded]');
            if ($items.length === 0) return;

            $.each($items, function (index, el) {
                if (!_this.isoItemVisible(el)) return;
                $(el).find(_this.isoItemImageSelector).attr('data-picture', '');
                $(el).attr('data-loaded', '');
            });

            if (window.picturefill) {
                window.picturefill();
            }
        };

        lazyload();
        $(window).on('scroll', lazyload);
        this.$isoContainer.on('isoLayoutComplete', lazyload);
    };

    CoEnvFaculty.prototype.isoItemVisible = function (el) {
        return ($(el).data('offset') < (this.windowHeight + this.scrollTop));
    };

    /**
     * Isotope filtering
     */
    CoEnvFaculty.prototype.isoFilter = function () {
        var _this = this;

        this.$isoContainer.on('filter', function (event, data) {
            var filterString = _this.buildIsoFilterString(data.filters);

            // The first item in a filtered set should never be featured
            if (_this.$isoItems) {
                _this.$isoItems.filter(filterString).first().removeClass(_this.isoItemFeaturedClass);
            }

            // Filter isotope
            _this.$isoContainer.isotope({ filter: filterString });
        });
    };

    CoEnvFaculty.prototype.filterInit = function () {
        var _this = this;
        var hashFilters = this.hashFilters();
        var data = { filters: {} };
        var $optAllThemes = this.$themeSelect.find('option[value="theme-all"]');
        var $optAllUnits = this.$unitSelect.find('option[value="unit-all"]');

        if (!hashFilters) {
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
            $.each(hashFilters, function () {
                var $selectOpt = _this.$toolboxForm.find('option[value="' + this + '"]');
                data.filters[this.split('-')[0]] = {
                    name: $selectOpt.text(),
                    slug: this.toString() // ensure string
                };
            });

            if (data.filters.unit !== undefined && data.filters.unit.slug !== 'unit-all') {
                this.formToggleOn();
            }
        }

        this.doFilter(data);
    };

    CoEnvFaculty.prototype.hashFilters = function () {
        var hash = window.location.hash;
        if (hash === '' || hash === '#') {
            return false;
        }
        return hash.substring(1).split('&');
    };

    CoEnvFaculty.prototype.doFilter = function (data) {
        var _this = this;

        for (var prop in data.filters) {
            if (data.filters[prop].slug === '*') {
                data.filters[prop].slug = prop + '-all';
            }
            this.filterQ.filters[prop] = data.filters[prop];
        }

        if (data.$rollerItem === undefined && data.filters !== undefined && data.filters.theme !== undefined) {
            data.$rollerItem = this.$roller.find(this.rollerItemSelector).filter(function () {
                var theme = _this.filterQ.filters.theme.slug === 'theme-all' ? '*' : _this.filterQ.filters.theme.slug;
                if ($(this).find('a').data('theme') === theme) {
                    return true;
                }
            });
        }

        if (data.search !== undefined) {
            this.filterQ.filters = {
                search: data.search,
                theme: { slug: 'theme-all' },
                unit: { slug: 'unit-all' }
            };
        }

        this.filterQ.feedback = data.feedback;
        this.filterQ.$rollerItem = data.$rollerItem;
        this.$isoContainer.trigger('filter', [this.filterQ]);
    };

    CoEnvFaculty.prototype.updateHash = function () {
        var _this = this;
        this.$isoContainer.on('filter', function (event, data) {
            var hash = _this.buildHashFromFilters(data.filters);
            if (hash === 'theme-all&unit-all') {
                hash = '';
            }
            // Prevent scrolling when setting hash
            if(history.pushState) {
                history.pushState(null, null, hash ? '#' + hash : window.location.pathname);
            } else {
                window.location.hash = hash;
            }
        });
    };

    CoEnvFaculty.prototype.buildIsoFilterString = function (filters) {
        var filterString = $.map(filters, function (val) {
            if (val.slug !== undefined) {
                return '.' + val.slug;
            }
        }).join('');

        if (filters.search !== undefined) {
            filterString = '.' + filters.search.ids.join(',.');
        }

        return filterString;
    };

    CoEnvFaculty.prototype.buildHashFromFilters = function (filters) {
        return $.map(filters, function (val) {
            return val.slug;
        }).join('&');
    };

    CoEnvFaculty.prototype.formToggleButton = function () {
        var _this = this;
        this.$formToggle.on('click', function (event) {
            event.preventDefault();
            if (_this.$toolbox.hasClass(_this.formViewClass)) {
                _this.formToggleOff();
            } else {
                _this.formToggleOn();
            }
        });
    };

    CoEnvFaculty.prototype.formToggleOn = function () {
        if (!this.$toolbox.hasClass(this.formViewClass)) {
            this.$toolbox.addClass(this.formViewClass);
        }
    };

    CoEnvFaculty.prototype.formToggleOff = function () {
        if (this.$toolbox.hasClass(this.formViewClass)) {
            this.$toolbox.removeClass(this.formViewClass);
            this.clearSearch();
            this.resetFilter('unit');
        }
    };

    CoEnvFaculty.prototype.selectSync = function () {
        var _this = this;
        this.$isoContainer.on('filter', function (event, data) {
            if (data.filters.theme !== undefined) {
                var themeOptSelector = 'option[value="' + data.filters.theme.slug + '"]';
                _this.$themeSelect.find(themeOptSelector).prop('selected', true);
                _this.$mobileThemeSelect.find(themeOptSelector).prop('selected', true);
            }
            if (data.filters.unit !== undefined) {
                var unitOptSelector = 'option[value="' + data.filters.unit.slug + '"]';
                _this.$unitSelect.find(unitOptSelector).prop('selected', true);
                _this.$mobileUnitSelect.find(unitOptSelector).prop('selected', true);
            }
        });
    };

    CoEnvFaculty.prototype.resetFilter = function (filter) {
        var data = { filters: {} };
        data.filters[filter] = {
            slug: filter + '-all'
        };
        this.doFilter(data);
    };

    CoEnvFaculty.prototype.formSelects = function () {
        var _this = this;

        this.$themeSelect.on('change', function () {
            var $opt = $(this).find('option:selected');
            var data = { filters: {} };
            
            data.filters = {
                theme: {
                    name: $opt.text(),
                    slug: $opt.val(),
                    url: $opt.data('url')
                }
            };
            _this.clearSearch();
            _this.doFilter(data);
        });

        this.$unitSelect.on('change', function () {
            var $opt = $(this).find('option:selected');
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
        });
    };

    CoEnvFaculty.prototype.feedback = function () {
        var _this = this;

        var doFeedback = function (data) {
            var themeLink = '', unitLink = '';
            var number, message;

            if (data.filters.theme !== undefined) {
                themeLink = '<a href="' + data.filters.theme.url + '" data-slug="' + data.filters.theme.slug + '">' + data.filters.theme.name + '</a>';
            }
            if (data.filters.unit !== undefined) {
                unitLink = '<a href="' + data.filters.unit.url + '" data-slug="' + data.filters.unit.slug + '">' + data.filters.unit.name + '</a>';
            }

            // Get number of filtered items safely
            var isotopeInstance = _this.$isoContainer.data('isotope');
            if (isotopeInstance && isotopeInstance.filteredItems) {
                number = isotopeInstance.filteredItems.length;
            } else {
                number = 0;
            }

            message = number === 1 ? _this.feedbackMessageSingular : _this.feedbackMessage;

            if (data.filters.theme !== undefined && data.filters.theme.slug === 'theme-all') {
                if (_this.$toolbox.hasClass(_this.formViewClass)) {
                    if (data.filters.unit.slug === 'unit-all') {
                        message = _this.feedbackMessageInclusive;
                    } else {
                        message += ' in ' + unitLink;
                    }
                } else {
                    message = _this.feedbackMessageInclusive;
                }
            } else {
                message += ' on ' + themeLink;
                if (_this.$toolbox.hasClass(_this.formViewClass)) {
                    if (data.filters.unit.slug !== 'unit-all') {
                        message += ' in ' + unitLink;
                    }
                }
            }

            if (data.search !== undefined) {
                message = 'searching';
            }

            if (data.feedback !== undefined) {
                message = data.feedback;
            }

            _this.$feedbackNumber.text(number);
            _this.$feedbackMessage.html(message);
        };

        this.$isoContainer.on('filter', function (event, data) {
            _this.$isoContainer.one('isoLayoutComplete', function () {
                doFeedback(data);
            });
        });
    };

    CoEnvFaculty.prototype.feedbackLinks = function () {
        var _this = this;
        this.$feedback.on('click', 'a', function (event) {
            event.preventDefault();
            if ($(this).attr('href') === window.location.href) {
                return;
            }
            for (var filter in _this.filterQ.filters) {
                if (_this.filterQ.filters[filter].slug !== $(this).data('slug')) {
                    _this.resetFilter(filter);
                }
            }
        });
    };

    CoEnvFaculty.prototype.handleSearch = function () {
        var _this = this;

        this.$form.on('submit', function (event) {
            event.preventDefault();
            
            // Safety check for global vars
            var ajaxUrl = (typeof themeVars !== 'undefined') ? themeVars.ajaxurl : '/wp-admin/admin-ajax.php';

            var searchData = {
                action: 'coenv_member_api_search',
                data: _this.$searchField.val()
            };

            $.post(ajaxUrl, searchData, function (response) {
                var searchResponse = $.parseJSON(response);
                var memberIDs;

                if (searchResponse.number === 0) {
                    memberIDs = ['Faculty-list-item--*'];
                } else {
                    memberIDs = $.map(searchResponse.results, function (val) {
                        return 'Faculty-list-item--' + val.ID;
                    });
                }

                var data = {};
                data.feedback = searchResponse.message;
                data.search = {
                    ids: memberIDs,
                    keywords: searchResponse.message
                };

                _this.doFilter(data);
            });
        });
    };

    CoEnvFaculty.prototype.clearSearch = function () {
        this.$searchField.val('');
        if (this.filterQ.filters && this.filterQ.filters.search) {
            delete this.filterQ.filters.search;
        }
    };

    CoEnvFaculty.prototype.mobileForm = function () {
        var _this = this;

        this.$mobileForm.on('submit', function (event) {
            event.preventDefault();
        });

        this.$mobileThemeSelect.on('change', function () {
            var $opt = $(this).find('option:selected');
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
        });

        this.$mobileUnitSelect.on('change', function () {
            var $opt = $(this).find('option:selected');
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
        });
    };

    // DOCUMENT READY WRAPPER
    // Critical fix: We only instantiate the class when the DOM is fully loaded.
    $(function() {
        var facultyApp = new CoEnvFaculty();
        facultyApp.init();
    });

})(jQuery, window, document);