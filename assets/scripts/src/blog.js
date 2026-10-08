jQuery(function ($) {
	'use strict';

    $.fn.blogHeader = function () {
        'use strict';

        var $header = $(this),
                $selectCategory = $header.find('.select-category select'),
                $selectMonth = $header.find('.select-month select'),
                $selects = $header.find('.input-item select'),
                $searchWrap = $header.find('.Faculty-toolbox-search-wrap'),
                $searchInput = $searchWrap.find('input[type="text"]'),
                $searchButton = $searchWrap.find('.Faculty-toolbox-search-button');

        function updateSelectState($select) {
            var hasValue = $.trim($select.val()) !== '' && $select.prop('selectedIndex') > 0;
            $select.closest('.Faculty-toolbox-select-wrap').toggleClass('has-value', hasValue);
        }

        function updateSearchState() {
            var hasSearch = $.trim($searchInput.val()) !== '' && /(?:\?|&)s=/.test(window.location.search);
            $searchWrap.toggleClass('has-active-search', hasSearch);
        }

        $selects.each(function () {
            updateSelectState($(this));
        });

        updateSearchState();

        $selects.on('change', function () {
            updateSelectState($(this));
        });

        $header.on('click', '.Faculty-toolbox-select-clear', function (event) {
            var $select = $(this).siblings('select');
            event.preventDefault();
            $select.prop('selectedIndex', 0).trigger('change');
        });

        $searchWrap.on('click', '.Faculty-toolbox-search-button-icon--clear', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $searchInput.val('');
            updateSearchState();
            $searchInput.trigger('focus');
        });

        $searchButton.on('click', function (event) {
            if ($searchWrap.hasClass('has-active-search')) {
                event.preventDefault();
                $searchInput.val('');
                window.location.href = $header.find('.select-category').attr('data-news-url') || '/about/news/';
            }
        });

        $selectCategory.on( 'change', function () {
            var selectedUrl = $(this).val(),
                    $container = $(this).closest('.select-category'),
                    newsUrl = $container.attr('data-news-url') || '/about/news/';

            if (!selectedUrl) {
                window.location.href = newsUrl;
                return;
            }

            window.location.href = selectedUrl;
        } );

        $selectMonth.on( 'change', function () {
            var url = $(this).val();
            window.location.href = url;
        } );
    };

	// handle blog header form
	$('#blog-header').blogHeader();
	$('#careers-filter').blogHeader();

});


