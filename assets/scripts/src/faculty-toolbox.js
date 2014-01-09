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
		// General container for the faculty list page
		$facultyList: $('.Faculty-list'),

		// Container for faculty items (members)
		// Isotope acts on this
		$itemContainer: $('.Faculty-list-content'),

		// The toolbox
		$toolbox: $('.Faculty-toolbox')
	};

	/**
	 * Initialize
	 */
	CoEnvFacultyToolbox.prototype.init = function () {
		var _this = this;
	};

	new CoEnvFacultyToolbox();

})(jQuery, window, document);