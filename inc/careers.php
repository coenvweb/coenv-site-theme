<?php

// do not use on live/production servers
add_action( 'init','maybe_rewrite_rules' );
function maybe_rewrite_rules() {

	$ver = filemtime( __FILE__ ); // Get the file time for this file as the version number
	$defaults = array( 'version' => 0, 'time' => time() );
	$r = wp_parse_args( get_option( __CLASS__ . '_flush', array() ), $defaults );

	if ( $r['version'] != $ver || $r['time'] + 172800 < time() ) { // Flush if ver changes or if 48hrs has passed.
		flush_rewrite_rules();
		// trace( 'flushed' );
		$args = array( 'version' => $ver, 'time' => time() );
		if ( ! update_option( __CLASS__ . '_flush', $args ) )
			add_option( __CLASS__ . '_flush', $args );
	}

}

// add to our plugin init function
global $wp_rewrite;
$careers_structure = '/students/careers/%year%/%monthnum%/%careers%';
$wp_rewrite->add_rewrite_tag("%careers%", '([^/]+)', "careers=");
$wp_rewrite->add_permastruct('careers', $careers_structure, false);

// Add filter to plugin init function
add_filter('post_type_link', 'careers_permalink', 10, 3);   
// Adapted from get_permalink function in wp-includes/link-template.php
function careers_permalink($permalink, $post_id, $leavename) {
    $post = get_post($post_id);
    $rewritecode = array(
        '%year%',
        '%monthnum%',
        '%day%',
        '%hour%',
        '%minute%',
        '%second%',
        $leavename? '' : '%postname%',
        '%post_id%',
        '%category%',
        '%author%',
        $leavename? '' : '%pagename%',
    );
 
    if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
        $unixtime = strtotime($post->post_date);
     
        $category = '';
        if ( strpos($permalink, '%category%') !== false ) {
            $cats = get_the_category($post->ID);
            if ( $cats ) {
                usort($cats, '_usort_terms_by_ID'); // order by ID
                $category = $cats[0]->slug;
                if ( $parent = $cats[0]->parent )
                    $category = get_category_parents($parent, false, '/', true) . $category;
            }
            // show default category in permalinks, without
            // having to assign it explicitly
            if ( empty($category) ) {
                $default_category = get_category( get_option( 'default_category' ) );
                $category = is_wp_error( $default_category ) ? '' : $default_category->slug;
            }
        }
     
        $author = '';
        if ( strpos($permalink, '%author%') !== false ) {
            $authordata = get_userdata($post->post_author);
            $author = $authordata->user_nicename;
        }
     
        $date = explode(" ",date('Y m d H i s', $unixtime));
        $rewritereplace =
        array(
            $date[0],
            $date[1],
            $date[2],
            $date[3],
            $date[4],
            $date[5],
            $post->post_name,
            $post->ID,
            $category,
            $author,
            $post->post_name,
        );
        $permalink = str_replace($rewritecode, $rewritereplace, $permalink);
    } else { // if they're not using the fancy permalink option
    }
    return $permalink;
}

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
		'with_front'=> false
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
		'rewrite' => false,
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
        'with_front'                 => false,
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

define( 'CAREERS_PAGE_PARENT_ID', '25157' );

/**
 * save careers parent
 */
function coenv_base_careers_parent( $data, $postarr ) {
    global $post;
 
 
    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $data;
 
    if ( $post->post_type == "careers" ){
        $data['post_parent'] = CAREERS_PAGE_PARENT_ID;
    }
 
    return $data;
}
add_action( 'wp_insert_post_data', 'coenv_base_careers_parent', '25157', 2  );