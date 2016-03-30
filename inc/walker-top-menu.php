<?php
/**
 * Walker: Top Menu
 */
class CoEnv_Top_Menu_Walker extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $current_page = 0) {
		parent::start_el( $output, $item, $depth, $args );
	}

}

function my_nav_notitle( $menu ){
  return $menu = preg_replace('/ title=\"(.*?)\"/', '', $menu );
}
add_filter( 'wp_nav_menu', 'my_nav_notitle' );