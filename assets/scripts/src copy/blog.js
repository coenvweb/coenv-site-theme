jQuery(function ($) {
	'use strict';

    $.fn.blogHeader = function () {
        'use strict';

        var $header = $(this),
                $selectCategory = $header.find('.select-category select'),
                $selectMonth = $header.find('.select-month select');

        $selectCategory.on( 'change', function () {
            var term_id = $(this).val(),
                    url = $(this).parent('div').attr('data-url');
            window.location.href = url + term_id;
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


