<?php

/**
 * Register careers taxonomy categories and tags
 *
 * Must be registered before careers post type
 *
 * @return void
 */

function taxonomy_degree_level() {

	$labels = array(
		'name'                       => _x( 'Degree Levels', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Degree Level', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Degree Levels', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'degree_level', 'careers', $args );
	register_taxonomy_for_object_type( 'degree_level', 'careers' );

}

add_action( 'init', 'taxonomy_degree_level', 0 );

function taxonomy_location_careers() {

	$labels = array(
		'name'                       => _x( 'Locations', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Locations', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'location_careers', 'careers', $args );
	register_taxonomy_for_object_type( 'location_careers', 'careers' );

}

add_action( 'init', 'taxonomy_location_careers', 0 );

function taxonomy_time_commitment() {

	$labels = array(
		'name'                       => _x( 'Time Commitments', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Time Commitment', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Time Commitments', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'time_commitment', 'careers', $args );
	register_taxonomy_for_object_type( 'time_commitemnt', 'careers' );

}
add_action( 'init', 'taxonomy_time_commitment', 0 );

function taxonomy_organization() {

	$labels = array(
		'name'                       => _x( 'Organizations', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Organization', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Organizations', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true
	);
	register_taxonomy( 'organization', 'careers', $args );
	register_taxonomy_for_object_type( 'organization', 'careers' );

}
add_action( 'init', 'taxonomy_organization', 0 );

function taxonomy_work_type() {

	$labels = array(
		'name'                       => _x( 'Work Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Work Types', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Work Types', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true
	);
	register_taxonomy( 'work_type', array( 'careers' ), $args );
	register_taxonomy_for_object_type( 'work_type', 'careers' );

}
add_action( 'init', 'taxonomy_work_type', 0 );

function taxonomy_educational_funding() {

	$labels = array(
		'name'                       => _x( 'Educational Funding', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Educational Funding', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Educational Funding', 'text_domain' ),
		'all_items'                  => __( 'All Items', 'text_domain' ),
		'parent_item'                => __( 'Parent Item', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Item:', 'text_domain' ),
		'new_item_name'              => __( 'New Item Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Item', 'text_domain' ),
		'edit_item'                  => __( 'Edit Item', 'text_domain' ),
		'update_item'                => __( 'Update Item', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
		'search_items'               => __( 'Search Items', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used items', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true
	);
	register_taxonomy( 'educational_funding', 'careers', $args );
	register_taxonomy_for_object_type( 'educational_funding', 'careers' );

}
add_action( 'init', 'taxonomy_educational_funding', 0 );



/**
 * Register careers & funding
 */
add_action( 'init', 'coenv_register_careers' );

function coenv_register_careers() {

	$labels = array(
		'name' => __( 'Careers Blog' ),
		'singular_name' => __( 'Posting' ),
		'add_new' => __( 'Add New Posting' ),
		'edit_item' => __( 'Edit Posting' ),
		'add_new_item' => __( 'New Posting' ),
		'view_item' => __( 'View Posting' ),
		'search_items' => __( 'Search Postings' ),
		'not_found' => __( 'No Postings found' ),
		'not_found_in_trash' => __( 'No Postings found in Trash' )
	);

	$rewrite = array(
		'slug' => 'careers',
		'with_front' => false
	);

	$args = array(
		'labels' => $labels,
		'menu_position' => null,
		'supports' => array('title','editor','page-attributes'),
		'public' => true,
		'has_archive' => true,
		'hierarchical' => false,
		'capability_type' => 'post',
		'rewrite' => $rewrite,
		'menu_icon' => 'dashicons-businessman',
		'exclude_from_search' => false
	);

	register_post_type( 'careers', $args );
}

/**
 *   Move taxonomy meta boxes from sidebar to bottom of editing view.
 */
function default_metabox_loc_careers(){

	remove_meta_box('degree_leveldiv', 'careers', 'side');
	remove_meta_box('location_careersdiv', 'careers', 'side');
	remove_meta_box('time_commitmentdiv', 'careers', 'side');
	remove_meta_box('organizationdiv', 'careers', 'side');
	remove_meta_box('work_typediv', 'careers', 'side');
	remove_meta_box('educational_fundingdiv', 'careers', 'side');
	add_meta_box( 'degree_leveldiv', 'Degree Level', 'post_categories_meta_box', 'careers', 'normal', 'high', array( 'taxonomy' => 'degree_level' ));
	add_meta_box( 'location_careersdiv', 'Location', 'post_categories_meta_box', 'careers', 'normal', 'high', array( 'taxonomy' => 'location_careers' ));
	add_meta_box( 'time_commitmentdiv', 'Time Commitment', 'post_categories_meta_box', 'careers', 'normal', 'high', array( 'taxonomy' => 'time_commitment' ));
	add_meta_box( 'organizationdiv', 'Organization', 'post_categories_meta_box', 'careers', 'normal', 'high', array( 'taxonomy' => 'organization' ));
	add_meta_box( 'work_typediv', 'Work Type', 'post_categories_meta_box', 'careers', 'normal', 'high', array( 'taxonomy' => 'work_type' ));
	add_meta_box( 'educational_fundingdiv', 'Educational Funding', 'post_categories_meta_box', 'careers', 'normal', 'high', array( 'taxonomy' => 'educational_funding' ));

}

add_action('add_meta_boxes', 'default_metabox_loc_careers', 0 );
