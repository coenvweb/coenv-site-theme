<?php
/**
 * Register staff
 */
add_action( 'init', 'coenv_register_staff' );

function coenv_register_staff() {

	$labels = array(
		'name' => __( 'Staff' ),
		'singular_name' => __( 'Staff Member' ),
		'add_new' => __( 'Add New Staff Member' ),
		'edit_item' => __( 'Edit Staff Member' ),
		'add_new_item' => __( 'New Staff Member' ),
		'view_item' => __( 'View Staff Member' ),
		'search_items' => __( 'Search Staff Members' ),
		'not_found' => __( 'No Staff Members found' ),
		'not_found_in_trash' => __( 'No Staff Members found in Trash' )
	);

	$rewrite = array(
		'slug' => 'staff',
		'with_front' => false
	);

	$args = array(
		'labels' => $labels,
		'menu_position' => null,
		'supports' => array('title','editor','page-attributes'),
		'public' => true,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
		'has_archive' => false,
		'hierarchical' => false,
		'menu_icon' => 'dashicons-nametag',
		'capability_type' => 'page',
		'rewrite' => $rewrite,
	);

	register_post_type( 'staff', $args );
}

function taxonomy_team() {

	$labels = array(
		'name'                       => _x( 'Team', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Team', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Team', 'text_domain' ),
		'all_items'                  => __( 'All Teams', 'text_domain' ),
		'parent_item'                => __( 'Parent Team', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Team:', 'text_domain' ),
		'new_item_name'              => __( 'New Team Name', 'text_domain' ),
		'add_new_item'               => __( 'Add New Team', 'text_domain' ),
		'edit_item'                  => __( 'Edit Team', 'text_domain' ),
		'update_item'                => __( 'Update Team', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate teams with commas', 'text_domain' ),
		'search_items'               => __( 'Search Team', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove teams', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most used teams', 'text_domain' ),
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
        
        'capabilities' => array (
            'manage_terms' => 'manage_teams', //by default only admin
            'edit_terms' => 'edit_teams',
            'delete_terms' => 'delete_teams',
            'assign_terms' => 'assign_teams' 
        ),
	);
	register_taxonomy( 'team', array( 'staff' ), $args );

}
add_action( 'init', 'taxonomy_team', 0 );

function posts_orderby_lastname ($orderby_statement) 
{
  $orderby_statement = "RIGHT(post_title, LOCATE(' ', REVERSE(post_title)) - 1) ASC";
    return $orderby_statement;
}