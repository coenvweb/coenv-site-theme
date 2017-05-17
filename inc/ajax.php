<?php 

//Enqueue Ajax Scripts
function enqueue_ajax_scripts() {
    wp_register_script( 'ajax-js', get_bloginfo('template_url') . '/assets/scripts/build/ajax.js', array( 'jquery' ), '', true );
    wp_localize_script( 'ajax-js', 'ajax_params', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		wp_enqueue_script( 'ajax-js' );
}
add_action('wp_enqueue_scripts', 'enqueue_ajax_scripts');

