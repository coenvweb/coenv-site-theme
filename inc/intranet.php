<?php
/**
 * Register Intranet Posts
 */
add_action( 'init', 'coenv_register_intranet' );

function coenv_register_intranet() {

	$labels = array(
		'name' => __( 'Intranet Posts' ),
		'singular_name' => __( 'Intranet Post' ),
		'add_new' => __( 'Add New Intranet Post' ),
		'edit_item' => __( 'Edit Intranet Post' ),
		'add_new_item' => __( 'New Intranet Post' ),
		'view_item' => __( 'View Intranet Post' ),
		'search_items' => __( 'Search Intranet Posts' ),
		'not_found' => __( 'No Intranet Posts found' ),
		'not_found_in_trash' => __( 'No Intranet Posts found in Trash' )
	);

	$rewrite = array(
		'slug' => 'intranet/post',
		'with_front' => false
	);

	$args = array(
		'labels' => $labels,
		'menu_position' => null,
		'supports' => array('title','editor','author','page-attributes'),
		'public' => true,
		'has_archive' => false,
		'hierarchical' => false,
		'menu_icon' => 'dashicons-building',
		'capability_type' => 'page',
		'rewrite' => $rewrite,
		'exclude_from_search' => true
	);

	register_post_type( 'intranet', $args );
}