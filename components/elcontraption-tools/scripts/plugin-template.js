(function ($, window, document, undefined) {

	'use strict';

	// Plugin definition
	// =========================================================================
	$.PluginName = function ( options, element ) {
		this.options = options;
		this.element = $(element);

		this._create( options );
	};

	$.PluginName.settings = {};

	// Create
	// =========================================================================
	$.PluginName.prototype._create = function ( options ) {

		// set options
		this.options = $.extend(true, {}, $.PluginName.settings, options);

		// initialize
		this._init();

	};

	// Initialize
	// =========================================================================
	$.PluginName.prototype._init = function () {

	};

	// Plugin bridge
	// =========================================================================
	// Leverages data method to either create or return plugin constructor
	//
	// Pattern developed by desandro for Masonry
	//		https://github.com/desandro/masonry/blob/master/jquery.masonry.js
	// Based off of jQuery UI's widget factory
	//		https://github.com/jquery/jquery-ui/blob/master/ui/jquery.ui.widget.js
	// And a bit from jcarousel
	//		https://github.com/jsor/jcarousel/blob/master/lib/jquery.jcarousel.js

	$.PluginName.prototype.option = function( key ){
		if ( $.isPlainObject( key ) ){
			this.options = $.extend(true, this.options, key);
		}
	};

	$.fn.pluginname = function( options ) {
		if ( typeof options === 'string' ) {
			// call method
			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {
				var instance = $.data( this, 'pluginname' );
				if ( !instance ) {
					console.log( 'error', 'cannot call methods on pluginname prior to initialization; ' +
						'attempted to call method "' + options + '"' );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === '_' ) {
					console.log( 'error', 'no such method "' + options + '" for pluginname instance' );
					return;
				}

				// apply method
				instance[ options ].apply( instance, args );
			});
		} else {
			this.each(function() {
				var instance = $.data( this, 'pluginname' );
				if ( instance ){
					// apply options & init
					instance.option( options || {} );
					instance._init();
				} else {
					// initialize new instance
					$.data( this, 'pluginname', new $.PluginName( options, this ) );
				}
			});
		}
		return this;
	};

})(jQuery, window, document);