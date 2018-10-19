<?php

/**
 * Print the <title> tag based on what is being viewed
 * @return 
 * - echo string
 * - updated 10.2018 to add conditionals with ACF/on page overrides option.
 * - updated 10.2018 to move into separate file. 
 */
function coenv_meta_title() {
    global $page, $paged;
    
    // "You Are Here" info
    $page_id = get_queried_object_id(); 
    //$page_for_posts_id = get_option( 'page_for_posts' );
    $page_title = wp_title('|', FALSE, 'right');
    $taxonomy_title = single_term_title('', FALSE);
    $site_title = get_bloginfo('name');
    $site_description = get_bloginfo('description');
    $meta_title = trim(get_field('meta_title', $page_id));
    $search_query = apply_filters( 'get_search_query', get_query_var( 's' ) );
    
    // Page numbers for archive pages
    if ( $paged >= 2 || $page >= 2 ) {
        $page_number = ' | ' . sprintf( __( 'Page %s', 'vpc' ), max( $paged, $page ) );
    } else {
        $page_number = '';
    }
    
    // Return the custom title if supplied
    if ($meta_title) {
        $html = '<title>' . $meta_title . $page_number . '</title>';
    } 
    // If it's the faculty page, return a custom design title. 
    elseif (is_post_type_archive('faculty') ) {
        $html = '<title>Faculty Profiles | '. $site_title . $page_number . '</title>';
    }
    // If it's a taxonomy category, return a custom title. 
    elseif (is_archive()) {
        $html = '<title>' . $taxonomy_title . ' News | '. $site_title . $page_number . '</title>';
    } 
    // If it's the search results page, return a standard title.
    elseif ( is_search() ) {
        $html = '<title>' . 'Search for "' . esc_attr($search_query) . '" | ' . $site_title . '</title>';
    // If 404 page page, return a standard title.
    } elseif ( is_404() ) {
        $html = '<title>' . 'Error 404 Not Found | ' . $site_title . '</title>';
    // If it's the homepage, return a standard title.
    } elseif ( is_front_page() ) {
        $html = '<title>' . $site_title . ' | ' . $site_description . '</title>';
    // If all else fails, build a title. 
    } else {
        $html = '<title>' . $page_title . $site_title . $page_number . '</title>';
    }
    
    return $html;   
}

