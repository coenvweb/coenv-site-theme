<?php

/**
 * Register careers & funding
 */
add_action( 'init', 'coenv_register_careers' );

function coenv_register_careers() {

	$labels = array(
		'name' => __( 'Careers' ),
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
        'taxonomies' => array('career_category'), array('career_post_tag'),
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
* Custom Taxonomies for Career Posts
**/

function career_tax() {

	$career_labels = array(
		'name'                       => _x( 'Career Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Career Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Career Categories', 'text_domain' ),
		'all_items'                  => __( 'All Career Categories', 'text_domain' ),
		'parent_item'                => __( 'Parent Career Category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Career Category:', 'text_domain' ),
		'new_item_name'              => __( 'New Career Category', 'text_domain' ),
		'add_new_item'               => __( 'Add Career Category', 'text_domain' ),
		'edit_item'                  => __( 'Edit Career Category', 'text_domain' ),
		'update_item'                => __( 'Update Career Category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate career categories with commas', 'text_domain' ),
		'search_items'               => __( 'Search career categories', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove career categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited career categories', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$career_args = array(
		'labels'                     => $career_labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'career_category', array( 'careers' ), $career_args );
	
	$career_labels_2 = array(
		'name'                       => _x( 'Career Tags', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Career Tag', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Career Tags', 'text_domain' ),
		'all_items'                  => __( 'All Career Tags', 'text_domain' ),
		'parent_item'                => __( 'Parent Career Tag', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Career Tag:', 'text_domain' ),
		'new_item_name'              => __( 'New Career Tag', 'text_domain' ),
		'add_new_item'               => __( 'Add Career Tag', 'text_domain' ),
		'edit_item'                  => __( 'Edit Career Tag', 'text_domain' ),
		'update_item'                => __( 'Update Career Tag', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate career tags with commas', 'text_domain' ),
		'search_items'               => __( 'Search career tags', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove career tags', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most commonly used career tags', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),
	);
	$career_args_2 = array(
		'labels'                     => $career_labels_2,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'career_post_tag', array( 'careers' ), $career_args_2 );
	
}

add_action( 'init', 'career_tax' );
