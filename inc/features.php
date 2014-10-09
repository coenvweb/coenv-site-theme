<?php
/**
 * Register features
 */
add_action( 'init', 'coenv_register_features' );

function coenv_register_features() {

	$labels = array(
		'name' => __( 'Features' ),
		'singular_name' => __( 'Featiure' ),
		'add_new' => __( 'Add New Feature' ),
		'edit_item' => __( 'Edit Feature' ),
		'add_new_item' => __( 'New Feature' ),
		'view_item' => __( 'View Feature' ),
		'search_items' => __( 'Search Features' ),
		'not_found' => __( 'No Features found' ),
		'not_found_in_trash' => __( 'No Features found in Trash' )
	);

	$rewrite = array(
		'slug' => 'feature',
		'with_front' => false
	);

	$args = array(
		'labels' => $labels,
		'menu_position' => null,
		'supports' => array('title','editor','page-attributes'),
		'public' => true,
		'has_archive' => false,
		'hierarchical' => false,
		'menu_icon' => 'dashicons-slides',
		'capability_type' => 'page',
		'rewrite' => $rewrite,
		'exclude_from_search' => true
	);

	register_post_type( 'feature', $args );
}