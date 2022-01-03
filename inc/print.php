<?php

/**
 * Print styles and scripts in header and footer
 */
add_action( 'wp_enqueue_scripts', 'coenv_styles_and_scripts' );
function coenv_styles_and_scripts() {

	// for public side only
	if ( is_admin() ) {
		return false;
	}

	// include theme scripts in footer
	wp_register_script( 'coenv-main2', get_template_directory_uri() . '/assets/scripts/build/main2.min.js', null, true );
	wp_enqueue_script( 'coenv-main2' );
    
    
    if (is_post_type_archive('faculty') || is_singular('faculty')) {

        // register faculty scripts, enqueued within template files
        wp_register_script( 'coenv-faculty', get_template_directory_uri() . '/assets/scripts/build/faculty.min.js', array( 'coenv-main2' ), null, true );
    }

	// make variables available to theme scripts
	wp_localize_script( 'coenv-main2', 'themeVars', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'themeurl' => get_template_directory_uri() ) );
}

/**
 * Print breadcrumbs
 * For print stylesheet only
 */
function coenv_print_breadcrumbs() {
	global $post;

	print '<pre>';
	print_r($post->ancestors);
	print '</pre>';

	$output = get_bloginfo('url');
	echo $output;
}

?>