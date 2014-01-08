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

		// Theme/unit select form shown for small viewports
		// and users without javascript
		$selector: $('.Faculty-selector'),

		// The toolbox
		$toolbox: $('.Faculty-toolbox')
	};

	/**
	 * Initialize
	 */
	CoEnvFacultyToolbox.prototype.init = function () {

		// replace selector with toolbox
		this.setupToolbox();
	};

	/**
	 * Replace selector with toolbox
	 */
	CoEnvFacultyToolbox.prototype.setupToolbox = function () {
		var _this = this;


	};

	new CoEnvFacultyToolbox();

})(jQuery, window, document);