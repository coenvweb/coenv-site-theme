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
		// Isotope acts on this
		$isoContainer: $('.Faculty-list-content'),

		// The toolbox
		$toolbox: $('.Faculty-toolbox'),

		// Roller and roller items
		$roller: $('.Faculty-toolbox-roller'),
		$rollerItems: $('.Faculty-toolbox-roller-item')

	};

	/**
	 * Initialize
	 */
	CoEnvFacultyToolbox.prototype.init = function () {
		var _this = this;

		// item selection
		this.itemSelection();
	};

	/**
	 * Handle item selection
	 *
	 * Triggers isotope filter
	 */
	CoEnvFacultyToolbox.prototype.itemSelection = function () {
		var _this = this;

		this.$rollerItems.on( 'click', 'a', function ( event ) {
			event.preventDefault();

			var $item = $(this),
				data = {};

			data.filters = {
				theme: {
					name: $item.text(),
					slug: $item.data('theme'),
					url: $item.attr('href')
				}
			};

			// trigger isotope
			_this.$isoContainer.trigger( 'filter', [ data ] );
		} );
	};

	new CoEnvFacultyToolbox();

})(jQuery, window, document);