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
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'unit', array( 'post', 'page', 'faculty', 'careers' ), $args );

}

add_action( 'init', 'taxonomy_unit', 0 );

function taxonomy_audience() {

	$labels = array(
		'name'                       => _x( 'Audiences', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Audience', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Audiences', 'text_domain' ),
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
	register_taxonomy( 'audience', array( 'post', 'page' ), $args );

}

add_action( 'init', 'taxonomy_audience', 0 );

function taxonomy_location() {

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
	register_taxonomy( 'location', array( 'post', 'page', 'faculty' ), $args );

}

add_action( 'init', 'taxonomy_location', 0 );

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
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'story_type', array( 'post', 'page' ), $args );

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
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true
	);
	register_taxonomy( 'topic', array( 'post', 'page' ), $args );

}
add_action( 'init', 'taxonomy_topic', 0 );

/**
 *   Move taxonomy meta boxes from sidebar to bottom of editing view.
 */
function default_metabox_loc(){

	remove_meta_box('topicdiv', 'post', 'side');
	remove_meta_box('story_typediv', 'post', 'side');
	remove_meta_box('locationdiv', 'post', 'side');
	remove_meta_box('audiencediv', 'post', 'side');
	remove_meta_box('unitdiv', 'post', 'side');
	add_meta_box( 'topicdiv', 'Topic', 'post_categories_meta_box', 'post', 'normal', 'high', array( 'taxonomy' => 'topic' ));
	add_meta_box( 'story_typediv', 'Story Type', 'post_categories_meta_box', 'post', 'normal', 'high', array( 'taxonomy' => 'story_type' ));
	add_meta_box( 'locationdiv', 'Location', 'post_categories_meta_box', 'post', 'normal', 'high', array( 'taxonomy' => 'location' ));
	add_meta_box( 'audiencediv', 'Audience', 'post_categories_meta_box', 'post', 'normal', 'high', array( 'taxonomy' => 'audience' ));
	add_meta_box( 'unitdiv', 'Unit', 'post_categories_meta_box', 'post', 'normal', 'high', array( 'taxonomy' => 'unit' ));

}

add_action( 'add_meta_boxes', 'default_metabox_loc', 0 );

/**
 *  Add new categories to user facing topic filter <select>.
 */
function coenv_post_cats($id) {
	$coenv_categories = get_the_terms($id, array('topic'));
	if ( $coenv_categories ) {
		$i = 0;
		foreach ($coenv_categories as $category) {
			if ($i==4) break;
			$coenv_cats .= '<li><a href="/news/'. $category->taxonomy . '/'.$category->slug.'">'. $category->name.'</a></li>';
			$i++;
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
 *  Display related news based on admin selection or auto based on category.
 */
function coenv_related_news ($id) {

	$_coenv_terms = get_the_terms( $id, 'topic' );
	$coenv_terms = array();

	foreach ( $_coenv_terms as $term) {
		$coenv_terms[] = $term->slug;
	}

	$args = array (

		'post_type' => 'post',
		'posts_per_page' => '2',
		'post__not_in' => array($id),
		'tax_query' => array(
		'relation' => 'AND',
			array(
			'taxonomy' => 'topic',
			'field' => 'slug',
			'terms' => $coenv_terms,
			'operator' => 'IN'
			)
		)

    );

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		echo '<div class="related-news">';
		echo '<div class="related-heading">';
		echo '<h2 class="title">Related News</h2>';
		echo '</div>';
		echo '<div class="related-posts">';
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<div class="related-container">';
			if ( has_post_thumbnail() ) {
				echo '<div class="related-thumb">';
				echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
				echo the_post_thumbnail('medium');
				echo '</a>';
				echo '</div>';
			}	
			echo '<div class="related-article-title">';
			echo '<h3>';
			echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
			echo the_title();
			echo '</a>';
			echo '</h3>';
			
		echo '</div>';
		echo '<br style="clear:both" />';
		echo '</div>';
		echo '</div>';
		}

	} else {
		// no posts found
	}

	wp_reset_postdata();

}

/**
 * Format post dates
 */
function coenv_post_date() {
	global $post;
	return '<time class="updated" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" pubdate>' . esc_html( get_the_date() ) . '</time>';
}