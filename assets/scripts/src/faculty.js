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
        $isoItems: null,
        $formToggle: null,
        $form: null,
        $themeSelect: null,
        $unitSelect: null,
        $themeSelectWrap: null,
        $unitSelectWrap: null,
        $themeClear: null,
        $unitClear: null,
        $searchField: null,
        $searchButton: null,
        $searchWrap: null,
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
        isoItemSelector: '.Faculty-list-item',
        isoItemFactClass: 'Faculty-list-item--fact',
        isoItemImageSelector: '.Faculty-list-item-image',
        formViewClass: 'Faculty-toolbox--show-form',
        
        // State variables
        feedbackMessageInclusive: '',
        feedbackMessage: 'Faculty members are working',
        feedbackMessageSingular: 'Faculty member is working',

        // Filter queue
        filterQ: {
            filters: {}
        },

        currentSearchRequest: null,
		activeSearchTerm: '',
        isSearchLoading: false
    };

    CoEnvFaculty.prototype.init = function () {
        var _this = this;

        // 1. Initialize DOM Elements (Selectors)
        // We do this here to ensure the HTML exists before we try to find it.
        this.$isoContainer = $('.Faculty-list-content');
        this.$toolbox = $('.Faculty-toolbox');
        this.$isoItems = $('.Faculty-list-item');
        this.$formToggle = $('.Faculty-toolbox-toggle');
        this.$form = $('.Faculty-toolbox-form');
        this.$toolboxForm = this.$form;
        this.$themeSelect = $('.Faculty-toolbox-theme-select');
        this.$unitSelect = $('.Faculty-toolbox-unit-select');
        this.$themeSelectWrap = this.$themeSelect.closest('.Faculty-toolbox-select-wrap');
        this.$unitSelectWrap = this.$unitSelect.closest('.Faculty-toolbox-select-wrap');
        this.$themeClear = this.$themeSelectWrap.find('.Faculty-toolbox-select-clear');
        this.$unitClear = this.$unitSelectWrap.find('.Faculty-toolbox-select-clear');
        this.$searchField = $('.Faculty-toolbox-search');
        this.$searchWrap = $('.Faculty-toolbox-search-wrap');
        this.$searchButton = this.$searchWrap.find('.Faculty-toolbox-search-button');
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
        this.measurements();
        this.updateHash();
        this.selectSync();
        this.feedback();
        this.feedbackLinks();
        this.isoInit();      // This calls isoFilter
        this.filterInit();
        this.formToggleOn();
        this.formToggleButton();
        this.formSelects();
        this.handleSearch();
        this.mobileForm();
        this.syncSearchState();
    };

    CoEnvFaculty.prototype.isDefaultFilterSet = function (filters) {
        var f = filters || {};

        if (f.search !== undefined) {
            return false;
        }

        var themeSlug = (f.theme && f.theme.slug) ? f.theme.slug : 'theme-all';
        var unitSlug = (f.unit && f.unit.slug) ? f.unit.slug : 'unit-all';

        return themeSlug === 'theme-all' && unitSlug === 'unit-all';
    };

    CoEnvFaculty.prototype.measurements = function () {
        var _this = this;

        var onResize = function () {
            _this.windowHeight = $(window).height();
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
     * Initialize Isotope
     */
    CoEnvFaculty.prototype.isoInit = function () {
        var _this = this;
        var isoOpts = {
            isInitLayout: false, // Don't layout immediately
            itemSelector: this.isoItemSelector,
            stamp: this.toolboxSelector,
            masonry: {
                columnWidth: '.grid-sizer',
                horizontalOrder: true
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
        var windowHeight = this.windowHeight || $(window).height();
        var scrollTop = this.scrollTop || $(window).scrollTop();
        return ($(el).data('offset') < (windowHeight + scrollTop));
    };

    /**
     * Isotope filtering
     */
    CoEnvFaculty.prototype.isoFilter = function () {
        var _this = this;

        this.$isoContainer.on('filter', function (event, data) {
            var filterString = _this.buildIsoFilterString(data.filters);

            // Filter isotope
            _this.$isoContainer.isotope({ filter: filterString });
        });
    };

    CoEnvFaculty.prototype.filterInit = function () {
        var queryFilters = this.queryFilters();
        var data = { filters: {} };
        var $optAllThemes = this.$themeSelect.find('option[value="theme-all"]');
        var $optAllUnits = this.$unitSelect.find('option[value="unit-all"]');

        if (!queryFilters) {
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
            data.filters.theme = this.filterDataBySlug('theme', queryFilters.theme);
            data.filters.unit = this.filterDataBySlug('unit', queryFilters.unit);

            if (queryFilters.unit !== 'unit-all') {
                this.formToggleOn();
            }
        }

        this.doFilter(data);
    };

    CoEnvFaculty.prototype.queryFilters = function () {
        var params = new URLSearchParams(window.location.search);
        var theme = params.get('theme');
        var unit = params.get('unit');
        var hasAny = false;

        var normalize = function (value, prefix) {
            if (!value) {
                return prefix + '-all';
            }

            hasAny = true;

            if (value.indexOf(prefix + '-') === 0) {
                return value;
            }

            if (value === 'all') {
                return prefix + '-all';
            }

            return prefix + '-' + value;
        };

        var filters = {
            theme: normalize(theme, 'theme'),
            unit: normalize(unit, 'unit')
        };

        if (!hasAny) {
            return false;
        }

        return filters;
    };

    CoEnvFaculty.prototype.filterDataBySlug = function (filter, slug) {
        var $select = filter === 'theme' ? this.$themeSelect : this.$unitSelect;
        var $opt = $select.find('option[value="' + slug + '"]');

        if ($opt.length) {
            return {
                name: $opt.text(),
                slug: slug,
                url: $opt.data('url')
            };
        }

        return {
            slug: slug
        };
    };

    CoEnvFaculty.prototype.applyThemeUnitFilters = function (themeSlug, unitSlug) {
        this.doFilter({
            filters: {
                theme: this.filterDataBySlug('theme', themeSlug || 'theme-all'),
                unit: this.filterDataBySlug('unit', unitSlug || 'unit-all')
            }
        });
    };

    CoEnvFaculty.prototype.doFilter = function (data) {
        var incomingFilters = data.filters || {};
        var defaults = this.defaultFilterData();
        var nextFilters;

        if (data.search !== undefined) {
            this.filterQ.filters = {
                search: data.search,
                theme: defaults.theme,
                unit: defaults.unit
            };
            this.filterQ.feedback = data.feedback;
            this.$isoContainer.trigger('filter', [this.filterQ]);
            return;
        }

        nextFilters = $.extend(true, {}, this.filterQ.filters || {});

        if (nextFilters.search !== undefined) {
            delete nextFilters.search;
        }

        if (nextFilters.theme === undefined) {
            nextFilters.theme = defaults.theme;
        }
        if (nextFilters.unit === undefined) {
            nextFilters.unit = defaults.unit;
        }

        for (var prop in incomingFilters) {
            if (!incomingFilters.hasOwnProperty(prop)) {
                continue;
            }

            var slug = incomingFilters[prop].slug;
            if (slug === '*') {
                slug = prop + '-all';
            }

            if (prop === 'theme' || prop === 'unit') {
                nextFilters[prop] = this.filterDataBySlug(prop, slug);
            } else {
                nextFilters[prop] = incomingFilters[prop];
            }
        }

        if (this.isDefaultFilterSet(nextFilters)) {
            nextFilters = defaults;
        }

        this.filterQ.filters = nextFilters;
        this.filterQ.feedback = data.feedback;
        this.$isoContainer.trigger('filter', [this.filterQ]);
    };

    CoEnvFaculty.prototype.updateHash = function () {
        var _this = this;
        this.$isoContainer.on('filter', function (event, data) {
            var query = _this.buildHashFromFilters(data.filters);
            var url = window.location.pathname + (query ? '?' + query : '');

            if(history.pushState) {
                history.pushState(null, null, url);
            } else {
                window.location.search = query;
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
        var params = [];

        if (filters.theme && filters.theme.slug) {
            var themeSlug = filters.theme.slug.replace(/^theme-/, '');
            if (themeSlug !== 'all') {
                params.push('theme=' + encodeURIComponent(themeSlug));
            }
        }

        if (filters.unit && filters.unit.slug) {
            var unitSlug = filters.unit.slug.replace(/^unit-/, '');
            if (unitSlug !== 'all') {
                params.push('unit=' + encodeURIComponent(unitSlug));
            }
        }

        return params.join('&');
    };

    CoEnvFaculty.prototype.formToggleButton = function () {
        if (!this.$formToggle.length) {
            return;
        }

        this.$formToggle.remove();
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
                _this.syncSelectState('theme');
            }
            if (data.filters.unit !== undefined) {
                var unitOptSelector = 'option[value="' + data.filters.unit.slug + '"]';
                _this.$unitSelect.find(unitOptSelector).prop('selected', true);
                _this.$mobileUnitSelect.find(unitOptSelector).prop('selected', true);
                _this.syncSelectState('unit');
            }

            _this.syncSearchState();
        });
    };

    CoEnvFaculty.prototype.syncSelectState = function (filter) {
        var $select = filter === 'theme' ? this.$themeSelect : this.$unitSelect;
        var $wrap = filter === 'theme' ? this.$themeSelectWrap : this.$unitSelectWrap;
        var $clear = filter === 'theme' ? this.$themeClear : this.$unitClear;
        var hasValue = $select.val() !== filter + '-all';

        $clear.prop('disabled', false);
        $wrap.toggleClass('has-value', hasValue);
        $clear.attr('aria-hidden', !hasValue);
    };

    CoEnvFaculty.prototype.resetFilter = function (filter) {
        var themeSlug = this.$themeSelect.val() || 'theme-all';
        var unitSlug = this.$unitSelect.val() || 'unit-all';

        if (filter === 'theme') {
            themeSlug = 'theme-all';
        }
        if (filter === 'unit') {
            unitSlug = 'unit-all';
        }

        this.$themeSelect.val(themeSlug);
        this.$mobileThemeSelect.val(themeSlug);
        this.$unitSelect.val(unitSlug);
        this.$mobileUnitSelect.val(unitSlug);

        this.syncSelectState('theme');
        this.syncSelectState('unit');

        this.applyThemeUnitFilters(themeSlug, unitSlug);
    };

    CoEnvFaculty.prototype.hasActiveSearch = function () {
        return !!(this.filterQ.filters && this.filterQ.filters.search);
    };

    CoEnvFaculty.prototype.getSearchTerm = function () {
        return $.trim(this.$searchField.val());
    };

    CoEnvFaculty.prototype.shouldClearSearch = function () {
        return this.hasActiveSearch() && this.getSearchTerm() === this.activeSearchTerm;
    };

    CoEnvFaculty.prototype.syncSearchState = function () {
        var hasActiveSearch = this.hasActiveSearch();
        var shouldClearSearch = this.shouldClearSearch();

		this.$searchWrap.toggleClass('has-active-search', shouldClearSearch);
        this.$searchWrap.toggleClass('is-loading', this.isSearchLoading);
        this.$searchButton.prop('disabled', this.isSearchLoading);

        if (this.isSearchLoading) {
            this.$searchButton.attr('aria-label', 'Searching faculty');
        } else if (shouldClearSearch) {
            this.$searchButton.attr('aria-label', 'Clear faculty search');
        } else {
            this.$searchButton.attr('aria-label', 'Search faculty');
        }
    };

    CoEnvFaculty.prototype.setSearchLoading = function (isLoading) {
        this.isSearchLoading = isLoading;
        this.syncSearchState();
    };

    CoEnvFaculty.prototype.defaultFilterData = function () {
        var $optAllThemes = this.$themeSelect.find('option[value="theme-all"]');
        var $optAllUnits = this.$unitSelect.find('option[value="unit-all"]');

        return {
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
    };

    CoEnvFaculty.prototype.resetSearch = function (applyFilter) {
        if (this.currentSearchRequest && typeof this.currentSearchRequest.abort === 'function') {
            this.currentSearchRequest.abort();
            this.currentSearchRequest = null;
        }

        this.activeSearchTerm = '';
        this.setSearchLoading(false);
        this.clearSearch();

        if (applyFilter) {
            this.doFilter({ filters: this.defaultFilterData() });
        } else {
            this.syncSearchState();
        }
    };

    CoEnvFaculty.prototype.formSelects = function () {
        var _this = this;

        this.$themeSelect.on('change', function () {
            _this.clearSearch();
            _this.applyThemeUnitFilters(_this.$themeSelect.val(), _this.$unitSelect.val());
        });

        this.$unitSelect.on('change', function () {
            _this.clearSearch();
            _this.applyThemeUnitFilters(_this.$themeSelect.val(), _this.$unitSelect.val());
        });

        this.$toolbox.on('click', '.Faculty-toolbox-select-clear', function (event) {
            event.preventDefault();

            var filter = $(this).data('filter');
            if (filter !== 'theme' && filter !== 'unit') {
                return;
            }

            _this.clearSearch();
            _this.resetFilter(filter);
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
                number = isotopeInstance.filteredItems.filter(function (item) {
                    return !$(item.element).hasClass(_this.isoItemFactClass);
                }).length;
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
                if ((filter !== 'theme' && filter !== 'unit') || !_this.filterQ.filters[filter].slug) {
                    continue;
                }

                if (_this.filterQ.filters[filter].slug !== $(this).data('slug')) {
                    _this.resetFilter(filter);
                }
            }
        });
    };

    CoEnvFaculty.prototype.handleSearch = function () {
        var _this = this;

		this.$searchField.on('input', function () {
			_this.syncSearchState();
		});

        this.$searchButton.on('click', function (event) {
            if (_this.isSearchLoading) {
                event.preventDefault();
                return;
            }

            if (_this.shouldClearSearch()) {
                event.preventDefault();
                _this.resetSearch(true);
            }
        });

        this.$form.on('submit', function (event) {
            event.preventDefault();
            var keywords = _this.getSearchTerm();

            if (keywords === '') {
                if (_this.hasActiveSearch()) {
                    _this.resetSearch(true);
                }
                return;
            }

            if (_this.currentSearchRequest && typeof _this.currentSearchRequest.abort === 'function') {
                _this.currentSearchRequest.abort();
            }

            _this.setSearchLoading(true);
            
            // Safety check for global vars
            var ajaxUrl = (typeof themeVars !== 'undefined') ? themeVars.ajaxurl : '/wp-admin/admin-ajax.php';

            var searchData = {
                action: 'coenv_member_api_search',
                data: keywords
            };

            _this.currentSearchRequest = $.post(ajaxUrl, searchData, function (response) {
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
                    keywords: keywords
                };

                _this.activeSearchTerm = keywords;
                _this.doFilter(data);
            }).fail(function (jqXHR, textStatus) {
                if (textStatus === 'abort') {
                    return;
                }

                _this.$feedbackMessage.text('Search is taking longer than expected. Please try again.');
            }).always(function () {
                _this.currentSearchRequest = null;
                _this.setSearchLoading(false);
            });
        });
    };

    CoEnvFaculty.prototype.clearSearch = function () {
        this.$searchField.val('');
        if (this.filterQ.filters && this.filterQ.filters.search) {
            delete this.filterQ.filters.search;
        }
        this.syncSearchState();
    };

    CoEnvFaculty.prototype.mobileForm = function () {
        var _this = this;

        this.$mobileForm.on('submit', function (event) {
            event.preventDefault();
        });

        this.$mobileThemeSelect.on('change', function () {
            _this.clearSearch();
            _this.$themeSelect.val(_this.$mobileThemeSelect.val());
            _this.applyThemeUnitFilters(_this.$themeSelect.val(), _this.$unitSelect.val());
        });

        this.$mobileUnitSelect.on('change', function () {
            _this.clearSearch();
            _this.$unitSelect.val(_this.$mobileUnitSelect.val());
            _this.applyThemeUnitFilters(_this.$themeSelect.val(), _this.$unitSelect.val());
        });
    };

    // DOCUMENT READY WRAPPER
    // Critical fix: We only instantiate the class when the DOM is fully loaded.
    $(function() {
        var facultyApp = new CoEnvFaculty();
        facultyApp.init();
    });

})(jQuery, window, document);