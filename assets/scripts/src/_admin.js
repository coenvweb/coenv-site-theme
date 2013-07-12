jQuery(function ($) {
	'use strict';

	$.fn.coenvCustomNavHeaders();

});

(function ($, window, document, undefined) {
	'use strict';

	/**
	 * Add custom nav header option to custom nav menu items
	 */
	$.fn.coenvCustomNavHeaders = function () {

		var $form = $('#update-nav-menu'),
				$secondTierItems = $form.find('.menu-item-depth-1'),
				secondTierItemIds = [],
				checkedItemIds;

		$.each( $secondTierItems, function () {
			secondTierItemIds.push( $(this).attr('id').split('-').pop() );
		} );

		//checkedItemIds = $.fn.coenvCustomNavHeaderChecked( secondTierItemIds );

		console.log( checkedItemIds );

		// add checkbox to second tier items only
		$secondTierItems.each( function () {

			var $item = $(this),
					$checkbox = $('<p class="field-subheader description"></p>'),
					itemID = $item.attr('id').split('-').pop();

			$checkbox.append('<label for="edit-menu-item-subheader-' + itemID + '"></label>');
			$checkbox.find('label').append('<input type="checkbox" id="edit-menu-item-subheader-' + itemID + '" value="subheader" name="menu-item-subheader[' + itemID + ']"> Use as subheader</input>');

			if ( $.inArray( itemID, checkedItemIds ) ) {
				$checkbox.find('input').attr('checked', 'checked');
			}

			$item.find('p.field-link-target').after( $checkbox );
		} );
	};

	/**
	 * Get ids of nav menu items that have been set as subheads
	 */
	$.fn.coenvCustomNavHeaderChecked = function ( ids ) {

		var dfd = new $.Deferred();

		var data = {
			action: 'coenv_ajax_get_menu_status',
			ids: ids
		};

		$.post( window.ajaxurl, data, function ( response ) {
			//return response;
			dfd.resolve();
		} );

		return dfd.promise();
	};

})(jQuery, window, document);