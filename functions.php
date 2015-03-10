<?php

/**
 * Custom menu walkers
 */
require_once locate_template( '/inc/walker-main-menu.php' );
require_once locate_template( '/inc/walker-secondary-menu.php' );
require_once locate_template( '/inc/walker-top-menu.php' );

/**
 * Print styles and scripts in header and footer
 */
add_action( 'wp_enqueue_scripts', 'coenv_styles_and_scripts' );
function coenv_styles_and_scripts() {

	// for public side only
	if ( is_admin() ) {
		return false;
	}

	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', get_template_directory_uri() . '/bower_components/jquery/jquery.min.js', array(), '1.9.1', false );
	wp_enqueue_script( 'jquery' );

	// include jQuery migrate plugin
	wp_register_script( 'jquery-migrate', get_template_directory_uri() . '/bower_components/jquery/jquery-migrate.min.js', array( 'jquery' ), '1.1.0', false );
	wp_enqueue_script( 'jquery-migrate' );

	// include theme scripts in footer
	wp_register_script( 'coenv-main', get_template_directory_uri() . '/assets/scripts/build/main.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'coenv-main' );

	// register faculty scripts, enqueued within template files
	wp_register_script( 'coenv-faculty', get_template_directory_uri() . '/assets/scripts/build/faculty.min.js', array( 'jquery', 'coenv-main' ), null, true );

	// make variables available to theme scripts
	wp_localize_script( 'coenv-main', 'themeVars', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'themeurl' => get_template_directory_uri() ) );
}

/**
 * Incorporate CoEnv Member API into the theme
 * this used to be a separate plugin, but it makes more sense to include it in the theme
 */
require 'member-api.php';

/**
 * Admin only scripts
 */
add_action( 'admin_enqueue_scripts', 'coenv_admin_scripts' );
function coenv_admin_scripts() {
	wp_register_script( 'coenv_admin', get_template_directory_uri() . '/assets/scripts/build/admin.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'coenv_admin' );
}

/**
 * Print the <title> tag based on what is being viewed
 * @return 
 * - echo string
 */
function coenv_title() {
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name
	bloginfo( 'name' );

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 ) {
		echo ' | ' . sprintf( __( 'Page %s', 'vpc' ), max( $paged, $page ) );
	}
}

/**
 * Open graph doctype
 */
add_filter( 'language_attributes', 'coenv_language_attributes' );
function coenv_language_attributes( $output ) {
	return $output . ' xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml"';
}

/**
 * Admin settings
 */
add_action( 'admin_init', 'coenv_admin_settings' );
function coenv_admin_settings() {

	add_option( 'meta_description' );
	add_settings_field( 'meta_description', 'Site description', 'coenv_setting_meta_description', 'general' );
	register_setting( 'general', 'meta_description' );

	add_option( 'facebook' );
	add_settings_field( 'facebook', 'Facebook', 'coenv_setting_facebook', 'general' );
	register_setting( 'general', 'facebook' );

	add_option( 'twitter' );
	add_settings_field( 'twitter', 'Twitter', 'coenv_setting_twitter', 'general' );
	register_setting( 'general', 'twitter' );

	add_option( 'google_plus' );
	add_settings_field( 'google_plus', 'Google+', 'coenv_setting_google_plus', 'general' );
	register_setting( 'general', 'google_plus' );

	add_option( 'youtube' );
	add_settings_field( 'youtube', 'YouTube', 'coenv_setting_youtube', 'general' );
	register_setting( 'general', 'youtube' );

//	add_option( 'feeds' );
//	add_settings_field( 'feeds', 'Feeds', 'coenv_setting_feeds', 'general' );
//	register_setting( 'general', 'feeds' );

	add_option( 'uw_social' );
	add_settings_field( 'UW Social', 'UW Social', 'coenv_setting_uw_social', 'general' );
	register_setting( 'general', 'uw_social' );
}

/**
 * Meta description setting
 */
function coenv_setting_meta_description() {
	$value = get_option('meta_description');

	?>	
		<p>In one or two short sentences, describe your site. This description is used in the search results of search engines like Google.</p>
		<textarea name="meta_description" id="meta_description" cols="30" rows="10" style="width: 100%"><?php echo $value ?></textarea>
	<?php
}

/**
 * Facebook setting
 */
function coenv_setting_facebook() {
	$value = get_option('facebook');

	?>	
		<input name="facebook" type="text" id="facebook" value="<?php echo $value; ?>" class="regular-text">
		<p class="description">Full URL to your Facebook page (e.g. https://facebook.com&hellip;).</p>
	<?php
}

/**
 * Twitter setting
 */
function coenv_setting_twitter() {
	$value = get_option('twitter');

	?>	
		<input name="twitter" type="text" id="twitter" value="<?php echo $value; ?>" class="regular-text">
		<p class="description">Just the handle ONLY (e.g. @handle).</p>
	<?php
}

/**
 * Google Plus setting
 */
function coenv_setting_google_plus() {
	$value = get_option('google_plus');

	?>	
		<input name="google_plus" type="text" id="google_plus" value="<?php echo $value; ?>" class="regular-text">
		<p class="description">Full URL to your Google+ profile.</p>
	<?php
}

/**
 * YouTube setting
 */
function coenv_setting_youtube() {
	$value = get_option('youtube');

	?>	
		<input name="youtube" type="text" id="youtube" value="<?php echo $value; ?>" class="regular-text">
		<p class="description">Full URL to your YouTube Channel.</p>
	<?php
}

/**
 * Feeds setting
 */
function coenv_setting_feeds() {
	$value = get_option('feeds');

	?>	
		<input name="feeds" type="text" id="feeds" value="<?php echo $value; ?>" class="regular-text">
		<p class="description">Full URL to your Feeds aggregation page (e.g. http://www.feedburner&hellip;).</p>
	<?php
}

/**
 * UW Social setting
 */
function coenv_setting_uw_social() {
	$value = get_option('uw_social');

	?>	
		<input name="uw_social" type="text" id="uw_social" value="<?php echo $value; ?>" class="regular-text">
	<?php
}

/**
 * Theme setup
 */
add_action( 'after_setup_theme', 'coenv_theme_setup' );
function coenv_theme_setup() {

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support('automatic-feed-links');

	// Register nav menus
	register_nav_menus(array(
		'uw-links' => 'UW links',
		'top-links' => 'Top links',
		'top-buttons' => 'Top buttons',
        'footer-top-links' => 'Footer Top Links',
		'footer-links' => 'Footer links',
		'footer-units' => 'Footer academic units'
	));

	// Featured images
	if ( function_exists( 'add_theme_support' ) ) {
		add_theme_support('post-thumbnails');
	}

	// Set media sizes
	// thumbnail: 200x200 square crop
  update_option( 'thumbnail_size_w', 200 );
  update_option( 'thumbnail_size_h', 200 );
  update_option( 'thumbnail_crop', 1 );

	if ( function_exists( 'add_image_size' ) ) { 
		add_image_size( 'tiny', 129, 129, true );
		add_image_size( 'small', 262, 262 );
		add_image_size( 'banner', 1680 );
		add_image_size( 'half', 375 );
		add_image_size( 'one-third', 250 );
	}

  // medium: 528x528
  update_option( 'medium_size_w', 528 );
  update_option( 'medium_size_h', 528 );

  // large: 750x750
  update_option( 'large_size_w', 794 );
  update_option( 'large_size_h', 794 );
}

if ( function_exists( 'add_image_size' ) ) {

}
add_filter('image_size_names_choose', 'my_image_sizes');
function my_image_sizes($sizes) {
$addsizes = array(
"half" => __( "50% of column"),
"one-third" => __( "33% of column")
);
$newsizes = array_merge($sizes, $addsizes);
return $newsizes;
}










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
		'capability_type' => 'page',
		'rewrite' => $rewrite,
		'exclude_from_search' => true
	);

	register_post_type( 'feature', $args );
}

/**
 * Returns a unit color (hex value)
 *
 * @param int Unit post ID
 * @return string Color hex value
 */
function coenv_unit_color( $unit_id ) {
	global $coenv_member_api;
	return $coenv_member_api->unit_color( $unit_id );
}

/**
 * Excerpt "more" link
 */
add_filter( 'excerpt_more', 'coenv_excerpt_more' );
function coenv_excerpt_more( $more ) {
	return ' <a class="read-more" href="' . get_permalink() . '">[continue]</a>';
}

/**
 * Register sidebars for all pages, format widget HTML,
 * include widgets.php
 */
add_action( 'widgets_init', 'coenv_widgets_init' );

function coenv_widgets_init() {

	// include custom widgets
	$file = dirname(__FILE__) . '/widgets.php';

	if ( file_exists( $file ) ) {
		require( $file );
	}

	$before_widget	= '<section id="%1$s" class="widget %2$s">';
	$before_title 	= '<header class="section-header"><h1>';
	$after_title	= '</h1></header> <!-- end .section-header -->';
	$after_widget	= '</section> <!-- end #%1$s -->';

	// this will return only top-level pages
	$pages = get_pages('parent=0&sort_column=menu_order&sort_order=ASC');

	// remove specific pages by page name
	$pages_to_remove = array( );

	if ( empty( $pages ) ) {
		return false;
	}

	foreach( $pages as $page ) {
		// remove specific pages
		if( !in_array( $page->post_name, $pages_to_remove ) ) {
			register_sidebar( array(
				'name' 			=> $page->post_title,
				'id'			=> 'sidebar-' . $page->ID,
				'before_widget' => $before_widget,
				'after_widget'	=> $after_widget,
				'before_title' 	=> $before_title,
				'after_title'	=> $after_title
			) );
		}
	}

	$additional_sidebars = array('Search');

	if ( !empty( $additional_sidebars ) ) {
		foreach ( $additional_sidebars as $sidebar ) {
			register_sidebar( array(
				'name' => $sidebar,
				'id' => 'sidebar-' . str_replace(' ', '-', strtolower( $sidebar ) ),
				'before_widget' => $before_widget,
				'after_widget'	=> $after_widget,
				'before_title' 	=> $before_title,
				'after_title'	=> $after_title
			) );
		}
	}

}

/**
 * Add class 'page-top-level' class to top level page body_class
 */
add_filter( 'body_class', 'coenv_page_top_ancestor_class' );
function coenv_page_top_ancestor_class( $classes ) {
	$post = get_queried_object();
	$ancestor_id = coenv_get_ancestor('ID');

	if ( isset( $post->ID ) && $post->ID == $ancestor_id ) {
		$classes[] = 'page-top-level';
	}
	return $classes;
}

/**
 * Gets the top-level ancestor for pages, posts and custom post types
 * Credit: https://github.com/elcontraption/wp-tools 
 * @param
 * - string
 * @return 
 * - array
 */
function coenv_get_ancestor($attr = 'ID') {
	
	$post = get_queried_object();

	// test for search
	if ( is_search() ) {
		return false;
	}

	if ( ($post->post_type == 'post' || is_archive() || is_search()) && !is_post_type_archive( array( 'faculty' ) ) ) {

		$page_for_posts = get_option( 'page_for_posts' );

		if ( $page_for_posts == 0 ) {
			return false;
		}

		$ancestor = get_post( $page_for_posts );
		return $ancestor->$attr;
	}

	// test for pages
	if ( $post->post_type == 'page' ) {

		// test for top-level pages
		if ( $post->post_parent == 0 ) {
			return $post->$attr;
		}

		// must be a child page
		$ancestors = get_post_ancestors( $post->ID );
		$ancestor = get_post( array_pop( $ancestors ) );
		return $ancestor->$attr;
	}

	// test for custom post types
	$custom_post_types = get_post_types( array( '_builtin' => false ), 'object' );
	if ( !empty( $custom_post_types ) && array_key_exists( $post->post_type, $custom_post_types ) ) {

		// is parent_page slug defined?
		if ( isset( $custom_post_types[ $post->post_type ]->parent_page ) ) {

			// parent_page slug is defined.
			$parent = get_page_by_path( $custom_post_types[ $post->post_type ]->parent_page );

		} else {

			// parent_page slug is not defined
			// find custom slug
			$slug = $custom_post_types[ $post->post_type ]->rewrite[ 'slug' ];

			// if a page exists with the same slug, assume that's the parent page
			$parent = get_page_by_path( $slug );
		}

		// get ancestors of $parent
		$ancestors = get_post_ancestors( $parent->ID );

		// if ancestors is empty, just return $parent;
		if ( empty( $ancestors ) ) {
			return $parent->$attr;
		}

		$ancestor = get_post( array_pop( $ancestors ) );
		return $ancestor->$attr;
	}
}

/**
 * Customize TinyMCE editor formats
 */
add_filter('tiny_mce_before_init', 'coenv_editor_formats');
function coenv_editor_formats( $init )
{
	$init['theme_advanced_blockformats'] = 'p, h1, h2, h3, h4';
	
	return $init;
}

/**
 * Page banners
 *
 * 2013.07.31 | Darin | disabled check for post thumbnail, will always fall back to ancestor thumbnail.
 */
function coenv_banner() {
	$obj = get_queried_object();

	$page_id = false;
	$banner = false;

	$ancestor_id = coenv_get_ancestor('ID');
	if ( has_post_thumbnail( $ancestor_id ) ) {
		$page_id = $ancestor_id;
	}

	if ( $page_id == false ) {
		return false;
	}

	$thumb_id = get_post_thumbnail_id( $page_id );
	$image_src = wp_get_attachment_image_src( $thumb_id, 'banner' );
	$attachment_post_obj = get_post( $thumb_id );

	$banner = array(
		'url' => $image_src[0],
		'permalink' => get_permalink( $attachment_post_obj->ID ),
		'title' => $attachment_post_obj->post_title,
		'caption' => $attachment_post_obj->post_excerpt
	);

	return $banner;
}

/**
 * Prevent default gallery style
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Remove WordPress's default padding on images with captions
 *
 * @param int $width Default WP .wp-caption width (image width + 10px)
 * @return int Updated width to remove 10px padding
 */
function remove_caption_padding( $width ) {
	return $width - 10;
}
add_filter( 'img_caption_shortcode_width', 'remove_caption_padding' );

/**
 * Display breadcrumb links for a page, post or faculty
 */
function coenv_breadcrumbs() {
	global $post;

	$post_type_obj = get_post_type_object( get_post_type( $post ) );

	switch ( $post_type_obj->labels->singular_name ) {
		case 'Post':
			$post_type = 'News';
			break;
		default:
			$post_type = $post_type_obj->labels->singular_name;
			break;
	}

	$output = '<div class="breadcrumbs">';
	$output .= $post_type . ': ';

	// for news, output date
	if ( $post_type == 'News' ) {
		$output .= '<ul class="breadcrumbs__list">';
		$output .= '<li>' . coenv_post_date() . '</li>';
		$output .= '</ul>';
	}

	if ( isset( $post->ancestors ) && !empty( $post->ancestors ) ) {
		$output .= '<ul class="breadcrumbs__list">';
		
		foreach ( $post->ancestors as $ancestor ) {
			$output .= '<li><a href="' . get_permalink( $ancestor ) . '">' . get_the_title( $ancestor ) . '</a></li>';
		}

		$output .= '</ul>';
	}

	$output .= '</div>';

	echo $output;
}

/**
 * Add submenu checkbox to wp custom nav menus
 */
add_action( 'wp_update_nav_menu', 'coenv_save_nav_menu_custom_fields' );
function coenv_save_nav_menu_custom_fields() {

	$ids_to_save = array();

	// collect ids submitted in $_POST['menu-item-subheader']
	$checked_ids = isset( $_POST['menu-item-subheader'] ) ? $_POST['menu-item-subheader'] : array();

	foreach ( $checked_ids as $key => $value ) {
		$ids_to_save[] = "$key";
	}

	update_option( 'coenv_main_menu_subheaders', $ids_to_save );

	// this gets called twice for some reason
	remove_action( 'wp_update_nav_menu', __FUNCTION__ );
}

/**
 * Add ajax action to check if checkbox is checked for subhead nav item
 */
add_action( 'wp_ajax_coenv_ajax_get_menu_status', 'coenv_ajax_get_menu_status' );
function coenv_ajax_get_menu_status() {

	// get items saved as subheaders
	$subheaders = get_option( 'coenv_main_menu_subheaders' );

	exit( json_encode( $subheaders ) );
}

/**
 * Checks if a page's ancestor is assigned in a custom menu
 * Returns true/false
 */
function coenv_has_menu( $menu_slug ) {

	global $post;

	$top_level_nav_item_permalinks = array();

	$ancestor_permalink = get_permalink( coenv_get_ancestor( 'ID' ) );

	$nav_menu_items = wp_get_nav_menu_items( $menu_slug );

	foreach ( $nav_menu_items as $item ) {

		// filter for top level items
		// add permalink to array
		if ( empty( $item->post_parent ) ) {
			$top_level_nav_item_permalinks[] = $item->url;
		}
	}

	// check if the ancestor permalink is in permalinks array
	if ( in_array( $ancestor_permalink, $top_level_nav_item_permalinks ) ) {
		return true;
	}

	return false;
}

/*
|---------------------------------------------------------------------------
| Pagination
|---------------------------------------------------------------------------
*/
function coenv_paginate() {

	if( is_singular() )
		return;

	global $wp_query;

	$prev_label = '&laquo;';
	$next_label = '&raquo;';

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="navigation"><ul>' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link( $prev_label ) );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="current"' : '';
		printf( '<li><a%s href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="current"' : '';
		printf( '<li><a%s href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", get_next_posts_link( $next_label ) );

	echo '</ul></div>' . "\n";
}

/**
 * Format post dates
 */
function coenv_post_date() {
	global $post;
	return '<time class="updated" datetime="' . esc_attr( get_the_date( 'c' ) ) . '" pubdate>' . esc_html( get_the_date() ) . '</time>';
}

/*
|---------------------------------------------------------------------------
| Archive titles
|---------------------------------------------------------------------------
*/
if ( !function_exists( 'coenv_archive_title' ) ) {

	function coenv_archive_title()
	{
		if ( is_category() ) {
			printf( __( 'Category Archives: %s', 'coenv' ), '<span>' . single_cat_title( '', false ) . '</span>' );

		} elseif ( is_tag() ) {
			printf( __( 'Tag Archives: %s', 'coenv' ), '<span>' . single_tag_title( '', false ) . '</span>' );

		} elseif ( is_author() ) {
			/* Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			*/
			the_post();
			printf( __( 'Author Archives: %s', 'coenv' ), '<span class="vcard"><a class="url fn n" href="' . get_author_posts_url( get_the_author_meta( "ID" ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
			/* Since we called the_post() above, we need to
			 * rewind the loop back to the beginning that way
			 * we can run the loop properly, in full.
			 */
			rewind_posts();

		} elseif ( is_day() ) {
			printf( __( 'Daily Archives: %s', 'coenv' ), '<span>' . get_the_date() . '</span>' );

		} elseif ( is_month() ) {
			printf( __( 'Monthly Archives: %s', 'coenv' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

		} elseif ( is_year() ) {
			printf( __( 'Yearly Archives: %s', 'coenv' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

		} else {
			_e( 'Archives', 'coenv' );

		}
	}

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

/**
 * Add Read More button links to RSS
 */

function fields_in_feed($content) {  
    if(is_feed()) {  
        $post_id = get_the_ID();  
        $output = '<a href="' . get_field('story_link_url', $post_id) . '" name="' . get_field('story_source_name', $post_id) . '">' . get_field('story_source_name', $post_id) . '</a>';  
        $content = $content.$output;  
    }  
    return $content;  
}  
add_filter('the_content','fields_in_feed');

/**
 * Remove comment RSS
 */
remove_action( 'wp_head','feed_links', 2 );
remove_action( 'wp_head','feed_links_extra', 3 );
add_action( 'wp_head', 'reinsert_rss_feed', 1 );

function reinsert_rss_feed() {
	echo '<link rel="alternate" type="application/rss+xml" title="' . get_bloginfo('sitename') . ' &raquo; RSS Feed" href="' . get_bloginfo('rss2_url') . '" />';
}

/**
 * Blank search searches for ' ' instead.
 **/
if(!is_admin()){
	add_action('init', 'search_query_fix');
	function search_query_fix(){
		if(isset($_GET['s']) && $_GET['s']==''){
			$_GET['s']=' ';
		}
	}
}

/**
 * Adds divs around all inline images (for excerpts)
 **/
function breezer_addDivToImage( $content ) {

   // A regular expression of what to look for.
   $pattern = '/(<img([^>]*)>)/i';
   // What to replace it with. $1 refers to the content in the first 'capture group', in parentheses above
   $replacement = '<div class="myphoto">$1</div>';

   // run preg_replace() on the $content
   $content = preg_replace( $pattern, $replacement, $content );

   // return the processed content
   return $content;
}
if (is_archive()):
	add_filter( 'the_content', 'breezer_addDivToImage' );
endif;

/**
 * Add custom media metadata fields
 *
 * Be sure to sanitize your data before saving it
 * http://codex.wordpress.org/Data_Validation
 *
 * @param $form_fields An array of fields included in the attachment form
 * @param $post The attachment record in the database
 * @return $form_fields The final array of form fields to use
 */
function add_image_attachment_fields_to_edit( $form_fields, $post ) {		
	// Add a Credit field
	$form_fields["credit_text"] = array(
		"label" => __("Credit"),
		"input" => "text", // this is default if "input" is omitted
		"value" => esc_attr( get_post_meta($post->ID, "_credit_text", true) ),
		"helps" => __("The owner of the image."),
	);
	
	// Add a Credit field
	$form_fields["credit_link"] = array(
		"label" => __("Credit URL"),
		"input" => "text", // this is default if "input" is omitted
		"value" => esc_url( get_post_meta($post->ID, "_credit_link", true) ),
		"helps" => __("Attribution link to the image source or owners website."),
	);
	
	return $form_fields;
}
add_filter("attachment_fields_to_edit", "add_image_attachment_fields_to_edit", null, 2);

/**
 * Save custom media metadata fields
 *
 * Be sure to validate your data before saving it
 * http://codex.wordpress.org/Data_Validation
 *
 * @param $post The $post data for the attachment
 * @param $attachment The $attachment part of the form $_POST ($_POST[attachments][postID])
 * @return $post
 */
function add_image_attachment_fields_to_save( $post, $attachment ) {
	if ( isset( $attachment['credit_text'] ) )
		update_post_meta( $post['ID'], '_credit_text', esc_attr($attachment['credit_text']) );
		
	if ( isset( $attachment['credit_link'] ) )
		update_post_meta( $post['ID'], '_credit_link', esc_url($attachment['credit_link']) );

	return $post;
}
add_filter("attachment_fields_to_save", "add_image_attachment_fields_to_save", null , 2);

/**
 * Improves the caption shortcode with HTML5 figure & figcaption; microdata & wai-aria attributes
 * 
 * @param  string $val     Empty
 * @param  array  $attr    Shortcode attributes
 * @param  string $content Shortcode content
 * @return string          Shortcode output
 */
function jk_img_caption_shortcode_filter($val, $attr, $content = null)
{
	extract(shortcode_atts(array(
		'id'      => '',
		'align'   => 'aligncenter',
		'width'   => '',
		'caption' => ''
	), $attr));
	
	// No caption, no dice... But why width? 
	if ( 1 > (int) $width || empty($caption) )
		return $val;
 
	if ( $id )
		$id = esc_attr( $id );
		$attach_id = str_replace('attachment_', '', $id);
		$photo_source = get_post_meta( $attach_id, '_credit_text', true );
		$photo_source_url = get_post_meta( $attach_id, '_credit_link', true );
	
		if ( $photo_source ) {
		if (!empty($photo_source_url)) {
			$photo_source_div = "<div class=\"source\"><a href=\"$photo_source_url\" target=\"blank\">$photo_source</a></div>";
		} else 
			$photo_source_div = "<div class=\"source\">$photo_source</div>";
		} else
			$photo_source_div= " ";
		
	


	return '<figure title="' . $caption . '" id="' . $id . '" aria-describedby="figcaption_' . $id . '" class="wp-caption ' . esc_attr($align) . '" itemscope itemtype="http://schema.org/ImageObject" style="width: ' . (0 + (int) $width) . 'px">' . do_shortcode( $content ) . $photo_source_div . '<figcaption id="figcaption_'. $id . '" class="wp-caption-text" itemprop="description">' . $caption . '</figcaption></figure>';
	
}
add_filter( 'img_caption_shortcode', 'jk_img_caption_shortcode_filter', 10, 3 );

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
	register_taxonomy( 'unit', array( 'post', 'page', 'faculty' ), $args );

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
		'meta_key' => '_thumbnail_id',
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
add_action( 'add_meta_boxes', 'default_metabox_loc', 0 );

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