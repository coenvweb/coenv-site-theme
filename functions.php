<?php

// Load constants
require_once locate_template( '/inc/site-constants.php' );

// Custom Menu Walkers
require_once locate_template( '/inc/walker-main-menu.php' );
require_once locate_template( '/inc/walker-secondary-menu.php' );
require_once locate_template( '/inc/walker-top-menu.php' );
require_once locate_template( '/inc/walker-career-cat.php' );

// Rewrites
require_once locate_template( '/inc/rewrites.php' );

// Ajax
require_once locate_template( '/inc/ajax.php' );

// Widgets
require_once locate_template( '/inc/widgets.php' );

// Signature Story
require_once locate_template( '/inc/signature-story-fun.php' );
//require_once locate_template( '/inc/gallery.php' ); (this is kinda working, but switched to slickslider plugin)

// Unique Meta Titles 
require_once locate_template( '/inc/meta-title.php' );

// Custom Metas (SEO and Social)
require_once locate_template( '/inc/custom-metas.php' );

// Shortcodes
require_once locate_template( '/inc/shortcodes.php' );
require_once locate_template( '/inc/shortcodes-tiles.php' );
require_once locate_template( '/inc/shortcodes-widget.php' );
require_once locate_template( '/inc/shortcodes-related-news.php' );
require_once locate_template( '/inc/shortcodes-degrees.php' );

// Images
require_once locate_template( '/inc/images.php' );

// Faculty
require_once locate_template( 'member-api.php' );
require_once locate_template( '/inc/faculty.php' );

// News
require_once locate_template( '/inc/news.php' );
require_once locate_template( '/inc/related-news.php' );
require_once locate_template( '/inc/intranet.php' );

// Print Styles
require_once locate_template( '/inc/print.php' );

//Enqueue the Dashicons script
add_action( 'wp_enqueue_scripts', 'amethyst_enqueue_dashicons' );
function amethyst_enqueue_dashicons() {
    wp_enqueue_style( 'dashicons' );
}



/**
 * Admin only scripts
 */
add_action( 'admin_enqueue_scripts', 'coenv_admin_scripts' );
function coenv_admin_scripts() {
	wp_register_script( 'coenv_admin', get_template_directory_uri() . '/assets/scripts/build/admin.min.js' );
	wp_enqueue_script( 'coenv_admin' );
}

/**
 * Hide ACF editor for non-admins
 **/

add_filter('acf/settings/show_admin', 'my_acf_show_admin');

function my_acf_show_admin( $show ) {
    
    return current_user_can('manage_options');
    
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

	add_option( 'linkedin' );
	add_settings_field( 'linkedin', 'LinkedIn', 'coenv_setting_linkedin', 'general' );
	register_setting( 'general', 'linkedin' );

	add_option( 'youtube' );
	add_settings_field( 'youtube', 'YouTube', 'coenv_setting_youtube', 'general' );
	register_setting( 'general', 'youtube' );
    
    add_option( 'instagram' );
	add_settings_field( 'instagram', 'Instagram', 'coenv_setting_instagram', 'general' );
	register_setting( 'general', 'instagram' );

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
 * LinkedIn setting
 */
function coenv_setting_linkedin() {
	$value = get_option('linkedin');

	?>	
		<input name="linkedin" type="text" id="linkedin" value="<?php echo $value; ?>" class="regular-text">
		<p class="description">Full URL to the LinkedIn page.</p>
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
 * YouTube setting
 */
function coenv_setting_instagram() {
	$value = get_option('instagram');

	?>	
		<input name="instagram" type="text" id="instagram" value="<?php echo $value; ?>" class="regular-text">
		<p class="description">Full URL to your Instagram profile.</p>
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
}

/**
 * Register Careers
 */

require_once locate_template( '/inc/careers.php' );
require_once locate_template( '/inc/infinite-scroll.php' );

/**
 * Register Staff
 */

require_once locate_template( '/inc/staff.php' );

/**
 * Register Students
 */

require_once locate_template( '/inc/student-ambassadors.php' );

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
    

	if ( (is_archive() || $post->post_type == 'post' || $post->post_type == 'intranet' || is_search()) && !is_post_type_archive( array( 'faculty' ) ) && !is_post_type_archive( array( 'careers' ) ) ) {

		$page_for_posts = get_option( 'page_for_posts' );

		if ( $page_for_posts == 0 ) {
			return false;
		}

		$ancestor = get_post( $page_for_posts );
        
        
        if ((isset($post->post_type)) && $post->post_type == 'intranet') {
            unset ($ancestor);
            $ancestor = get_post( 267 );
        }
		return $ancestor->$attr;
        
	}

	// test for pages
    if ((isset($post->post_type)) && $post->post_type == 'page' ) {

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
	if ( !empty( $custom_post_types ) && (isset($post->post_type)) && array_key_exists( $post->post_type, $custom_post_types ) ) {

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




function youtube_nocookie( $data, $url, $args ){
  
  $data = str_replace( 'www.youtube.com', 'www.youtube-nocookie.com', $data );
  
  return $data;
  
}

add_filter( 'oembed_result', 'youtube_nocookie', 10, 3 );



function coenv_base_date_filter($post_type,$coenv_month,$coenv_year) {
	$counter = 0;
	$ref_month = '';
	$monthly = new WP_Query(array('posts_per_page' => -1, 'post_type'	=> $post_type));
	echo '<select name="select-category" class="select-category" id="date-filter">';
	echo '<option value="' . strtok($_SERVER['REQUEST_URI'],'?') . '">By Date</option>';
	if( $monthly->have_posts() ) :
		while( $monthly->have_posts() ) : $monthly->the_post();
		    if( get_the_date('mY') != $ref_month ) {
		    	$month_num = get_the_date('m');
		    	$month_str = get_the_date('F');
		    	$year_num = get_the_date('Y');
		    	if ($year_num == $coenv_year && $month_num == $coenv_month) {
		    	 $selected = ' selected="selected"';
		    	} else {
		    		$selected = '';
		    	}
		    	echo '<option value="page/1/?coenv-year=' . $year_num . '&coenv-month=' . $month_num  . '"' . $selected . '>' . $month_str . ' ' . $year_num . '</option>';
		       // echo "\n".get_the_date('F Y');
		        $ref_month = get_the_date('mY');
		        $counter = 0;
		    }
		endwhile; 
	endif;
	echo '</select>';
	wp_reset_postdata();
	wp_reset_query();
}

if($_SERVER['HTTP_HOST'] !== 'environment.uw.dev' && $_SERVER['HTTP_HOST'] !== 'environment.uw.local' && $_SERVER['HTTP_HOST'] !== 'uwenvironment.local' && $_SERVER['HTTP_HOST'] !== 'beta.environment.uw.edu') {
    function cdn_upload_url() {
        return 'https://uw-env-media.b-cdn.net/wp-content/uploads';
    }
    add_filter( 'pre_option_upload_url_path', 'cdn_upload_url' );
}

function add_pending_revision_status(){
	register_post_status( 'pending_revision', array(
		'label'                     => 'Pending Revision',
		'public'                    => false,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( '<span class="count">(%s)</span> Pending Revision', 'Unread <span class="count">(%s)s</span> Pending Revision' ),
	) );
}
add_action( 'init', 'add_pending_revision_status' );

add_action( 'admin_bar_menu', 'add_revision_link', 999 );
function add_revision_link( $wp_admin_bar ) {
    if(current_user_can('ow_make_revision') && current_user_can('ow_make_revision_others') && is_page() && !is_front_page() && !is_preview()) {
        $args = array(
            'id'    => 'revision',
            'title' => do_shortcode('[ow_make_revision_link text="Make Revision" class="" type="text" post_id="'.get_the_ID().'"]'),
            'href'  => '',
        );
        $wp_admin_bar->add_node( $args );
    }
}
add_action('template_redirect', 'theme_add_last_modified_header');

function theme_add_last_modified_header($headers) {
    global $post;
    if(isset($post) && isset($post->post_modified)){
        $post_mod_date=date("D, d M Y H:i:s",strtotime($post->post_modified));
        header('Last-Modified: '.$post_mod_date.' GMT');
     }
}

// Add no-cache <meta> to the homepage
/**
 * Conditionally add metatag to specific page
 * 
 * @return void
 */
function wpse359922_metatag_conditional() {

    if( is_page( 2 ) ) {
        echo '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"><meta http-equiv="Pragma" content="no-cache">';
    } else {
        echo '';
    }

}
add_action( 'wp_head', 'wpse359922_metatag_conditional' );