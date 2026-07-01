<?php
/**
 * Theme Scripts and Styles
 * Load external scripts and inline initialization code
 */

add_action( 'wp_enqueue_scripts', 'coenv_enqueue_scripts' );
function coenv_enqueue_scripts() {
	// External scripts
	wp_enqueue_script( 'uw-alert', 'https://www.washington.edu/static/alert.min.js', array(), null, false );
	wp_enqueue_script( 'ga4', 'https://www.googletagmanager.com/gtag/js?id=G-5R657MZJ8Q', array(), null, false );
	
	// Add inline initialization scripts
	add_action( 'wp_head', 'coenv_ga4_init' );
}

//Enqueue the Dashicons script
add_action( 'wp_enqueue_scripts', 'amethyst_enqueue_dashicons' );
function amethyst_enqueue_dashicons() {
    wp_enqueue_style( 'dashicons' );
}



/**
 * Admin only scripts
 */
add_action( 'admin_enqueue_scripts', 'coenv_admin_scripts' );
function coenv_admin_scripts() {
	wp_register_script( 'coenv_admin', get_template_directory_uri() . '/assets/scripts/build/admin.min.js' );
	wp_enqueue_script( 'coenv_admin' );
}

/**
 * Google Analytics 4 initialization
 */
function coenv_ga4_init() {
	?>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());
	gtag('config', 'G-5R657MZJ8Q');
	</script>
	<?php
}