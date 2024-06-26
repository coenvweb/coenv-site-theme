<?php

/**
 * Add taxonomies
 */
function taxonomy_unit() {

	$labels = array(
		'name'                       => _x( 'Units', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Unit', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Units', 'text_domain' ),
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
        'capabilities'               => array(
            'manage_terms' => 'edit_posts',
            'edit_terms' => 'edit_posts',
            'delete_terms' => 'edit_posts',
            'assign_terms' => 'edit_posts'  // means administrator', 'editor', 'author', 'contributor'
        ),
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'unit', array( 'post', 'faculty' ), $args );

}

add_action( 'init', 'taxonomy_unit', 0 );

function taxonomy_story_type() {

	$labels = array(
		'name'                       => _x( 'Story Types', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Story Type', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Story Types', 'text_domain' ),
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
        'capabilities'               => array(
            'manage_terms' => 'edit_posts',
            'edit_terms' => 'edit_posts',
            'delete_terms' => 'edit_posts',
            'assign_terms' => 'edit_posts'  // means administrator', 'editor', 'author', 'contributor'
        ),
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'story_type', array( 'post' ), $args );

}
add_action( 'init', 'taxonomy_story_type', 0 );

function taxonomy_topic() {

	$labels = array(
		'name'                       => _x( 'Topics', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Topic', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Topics', 'text_domain' ),
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
        'capabilities'               => array(
            'manage_terms' => 'edit_posts',
            'edit_terms' => 'edit_posts',
            'delete_terms' => 'edit_posts',
            'assign_terms' => 'edit_posts'  // means administrator', 'editor', 'author', 'contributor'
        ),
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true
	);
	register_taxonomy( 'topic', array( 'post', 'intranet' ), $args );

}
add_action( 'init', 'taxonomy_topic', 0 );

/**
 *   Move taxonomy meta boxes from sidebar to bottom of editing view.
 */
function default_metabox_loc(){

	remove_meta_box('topicdiv', 'post', 'side');
	remove_meta_box('story_typediv', 'post', 'side');
	remove_meta_box('locationdiv', 'post', 'side');
	remove_meta_box('unitdiv', 'post', 'side');

	add_meta_box( 'topicdiv', 'Topic', 'post_categories_meta_box', 'post', 'normal', 'high', array( 'taxonomy' => 'topic' ));
	add_meta_box( 'story_typediv', 'Story Type', 'post_categories_meta_box', 'post', 'normal', 'high', array( 'taxonomy' => 'story_type' ));
	add_meta_box( 'unitdiv', 'Unit', 'post_categories_meta_box', 'post', 'normal', 'high', array( 'taxonomy' => 'unit' ));

}

add_action( 'add_meta_boxes', 'default_metabox_loc', 0 );


//remove default tag and category taxonomies

function coenv_unregister_taxonomy(){
    register_taxonomy('post_tag', array());
    register_taxonomy('category', array());
}
add_action('init', 'coenv_unregister_taxonomy');

//clean up taxonomies with three columns

function custom_admin_columns() {
   echo '<style type="text/css">
       @media only screen and (min-width: 850px) {
           #topicdiv{width: 32%; display: inline-block;}
           #story_typediv{width: 32%; display: inline-block;}
           #unitdiv{width: 32%; display: inline-block;}
       }
         </style>';
}

add_action('admin_head', 'custom_admin_columns');

/**
 *  Add new categories to user facing topic filter <select>.
 */
function coenv_post_cats($id, $content_type = 'post') {
	$coenv_categories = get_the_terms($id, 'topic');
	if ( $coenv_categories ) {
		$i = 0;
        $coenv_cats = null;
		foreach ($coenv_categories as $category) {
			if ($i==4) break;
            if ($content_type == 'post'){
                $coenv_cats .= '<li><a href="/news/'. $category->taxonomy . '/'.$category->slug.'">'. $category->name.'</a></li>';
                $i++;
            } elseif (($content_type == 'intranet') && ($category->term_id != 1239)) {
                if (term_is_ancestor_of(1239, $category->term_id, 'topic')) {
                    $coenv_cats .= '<li><a href="/intranet/?term='.$category->slug.'">'. $category->name.'</a></li>';
                    $i++;
                }
                
            }
		}
		echo '<ul class="article__categories">'. $coenv_cats . '</ul>';
	}	
}

/**
 *  Maintain state on user facing date filter <select>.
 */
function coenv_get_archives_link ( $link_html ) {
    global $wp;
    static $current_url;

    if ( empty( $current_url ) ) {
        $current_url = add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
    }
    if ( stristr( $current_url, 'page' ) !== false ) {
		$current_url = substr($current_url, 0, strrpos($current_url, 'page'));
    }
    if ( is_date() && stristr( $link_html, $current_url ) !== false ) {
        $link_html = preg_replace( '/(<[^\s>]+)/', '\1 selected="selected"', $link_html, 1 );
    }
    return $link_html;
}

add_filter('get_archives_link', 'coenv_get_archives_link');

/**
 * Format post dates
 */
function coenv_post_date() {
	global $post;
	return '<time class="updated" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" pubdate>' . esc_html( get_the_date() ) . '</time>';
}
