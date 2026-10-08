<?php  
/**
 * The sidebar template
 *
 * Serves up sidebar widgets for individual top level pages
 */

$ancestor_id = coenv_get_ancestor('ID');

if ( is_tax( 'topic' ) || is_search() || is_date() || is_home() ) {
	$page_for_posts = (int) get_option( 'page_for_posts' );
	if ( ! $page_for_posts ) {
		$news_page = get_page_by_path( 'about/news' );
		$page_for_posts = $news_page ? (int) $news_page->ID : 0;
	}

	if ( $page_for_posts ) {
		$ancestor_id = $page_for_posts;
	}
}

if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )): endif;