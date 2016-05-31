<?php
/**
 * Walker: Secondary Menu
 * 
 * Used for secondary nav on pages that don't appear within the main menu
 * Use "sub-menu" class on child menus instead of "children", to mirror
 * display of nav menus.
 */
class CoEnv_Secondary_Menu_Walker extends Walker_Page {

	function __construct() {
		$this->menu_pages = array();

		// get all pages that are set to appear in the main menu
		$menu_pages = get_posts( array(
			'posts_per_page' => -1,
			'post_type' => 'page',
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'show_in_main_menu',
					'value' => 1,
					'compare' => 'LIKE'
				)
			)
		) );

		if ( !empty( $menu_pages ) ) {
			foreach ( $menu_pages as $page ) {
				$this->menu_pages[] = $page->ID;

				if ( empty( $page->ancestors ) ) {
					$this->top_level_pages[] = $page->ID;
				}
			}
		}
	}

	function in_main_menu( $item, $depth ) {

		// item must be in menu pages
		if ( !in_array( $item->ID, $this->menu_pages ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Starts a branch of the tree (<ul>)
	 */
	function start_lvl ( &$output, $depth = 0, $args = array() ) {
        
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class='children'>\n";
	}

	/**
	 * Ends a branch of the tree (</ul>)
	 */
	function end_lvl ( &$output, $depth = 0, $args = array() ) {

		// continue with original end_lvl()
		parent::end_lvl( $output, $depth, $args );
	}

	/**
	 * Starts an element of a branch (<li>)
	 */
	function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {
        
        global $post;

		// check that this page is set to appear in the main menu
		if ( !$this->in_main_menu( $page, $depth ) ) {
			return false;
		}

		// continue with original start_el()
		parent::start_el( $output, $page, $depth, $args,  $current_page );

	}

	/**
	 * Ends an element of a branch (</li>)
	 */
	function end_el ( &$output, $page, $depth = 0, $args = array() ) {

		// check that this element is set to appear in main menu
		if ( !$this->in_main_menu( $page, $depth ) ) {
			return false;
		}

		// continue with original end_el()
		parent::end_el( $output, $page, $depth, $args );

	}

}


function my_page_css_class( $css_class, $page ) {
	global $post;
	if ( $post->ID == $page->ID ) {
		$css_class[] = 'current_page_item';
	}
    if (is_singular('careers') && $page->ID == 27023) {
        $css_class[] = 'current_page_item';
    }
	return $css_class;
}
add_filter( 'page_css_class', 'my_page_css_class', 10, 2 );