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

		// keep track of current breakpoint
		this.breakpoint();

		// toggle selector or toolbox depending on breakpoint
		this.toggleSelectorToolbox();
	};

	/**
	 * Keep track of current breakpoint
	 */
	CoEnvFacultyToolbox.prototype.breakpoint = function () {
		var _this = this;

		var getBreakpoint = function () {
			_this.breakpoint = window.getComputedStyle( document.body, ':after' ).getPropertyValue( 'content' );
		};

		getBreakpoint();

		$(window).on( 'debouncedresize', getBreakpoint );
	};

	/**
	 * Replace selector with toolbox
	 */
	CoEnvFacultyToolbox.prototype.toggleSelectorToolbox = function () {
		var _this = this,
			toolboxBreakpoints = ['bp-3', 'desktop'];

		var doToggle = function () {

			if ( $.inArray( _this.breakpoint, toolboxBreakpoints ) !== -1 ) {

				// hide selector
				_this.hideSelector();

				// show toolbox
				_this.showToolbox();
			} else {

				// hide toolbox
				_this.hideToolbox();

				// show selector
				_this.showSelector();
			}
		};

		doToggle();

		$(window).on( 'debouncedresize', doToggle );
	};

	/**
	 * Hide Selector
	 */
	CoEnvFacultyToolbox.prototype.hideSelector = function () {
		this.$selector.hide();
	};

	/**
	 * Show Selector
	 */
	CoEnvFacultyToolbox.prototype.showSelector = function () {
		this.$selector.show();
	};

	/**
	 * Hide Toolbox
	 */
	CoEnvFacultyToolbox.prototype.hideToolbox = function () {
	};

	/**
	 * Show Toolbox
	 */
	CoEnvFacultyToolbox.prototype.showToolbox = function () {
	};

	new CoEnvFacultyToolbox();

})(jQuery, window, document);