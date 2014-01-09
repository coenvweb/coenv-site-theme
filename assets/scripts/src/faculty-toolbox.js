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

		this.scrollList();
	};

	/**
	 * 
	 */
	CoEnvFacultyToolbox.prototype.scrollList = function () {
		var _this = this;
	};

	new CoEnvFacultyToolbox();

})(jQuery, window, document);