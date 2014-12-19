<?php
/**
 * Walker: Main Menu
 *
 * Called by wp_list_pages() in header.php for the main menu.
 *
 * Extends Walker_Page rather than Walker_Nav_Menu to give
 * us more flexibility in splitting menu items into columns.
 */
class CoEnv_Main_Menu_Walker extends Walker_Page {

	/**
	 * Intialization
	 */
	public function __construct() {

		// All menu items
		$this->items = $this->get_items();
		$this->item_ids = $this->get_ids( $this->items );

		// Items that are set as top-level
		$this->top_level_items = $this->get_top_level_items();
		$this->top_level_item_ids = $this->get_ids( $this->top_level_items );

		// Items that are set to appear as sub-headers
		$this->subhead_items = $this->get_subhead_items();
		$this->subhead_item_ids = $this->get_ids( $this->subhead_items );

		// ID of blog home page
		$this->page_for_posts = get_option( 'page_for_posts' ); 

		// Keep count of top-level items
		$this->top_level_counter = 0;
	}

	/**
	 * Get post objects for all pages that are set to 
	 * appear in the menu.
	 */
	public function get_items() {

		return get_posts( array(
			'posts_per_page' => -1,
			'post_type' => 'page',
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'show_in_main_menu',
					'value' => '1',
					'compare' => '=='
				)
			)
		) );
	}

	/**
	 * Get post objects for pages that are set to appear 
	 * as top-level menu items.
	 */
	public function get_top_level_items() {

		return get_posts( array(
			'posts_per_page' => -1,
			'post_type' => 'page',
			'post_parent' => 0,
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'show_as_top-level_page',
					'value' => '1',
					'compare' => '=='
				)
			)
		) );
	}

	/**
	 * Get post objects for pages that are set to appear
	 * as subheaders (current example: GRADUATE | UNDERGRADUATE)
	 */
	public function get_subhead_items() {

		return get_posts( array(
			'posts_per_page' => -1,
			'post_type' => 'page',
			'post_status' => 'publish',
			'meta_query' => array(
				array(
					'key' => 'show_as_sub-header',
					'value' => '1',
					'compare' => '=='
				)
			)
		) );
	}

	/**
	 * Return array of IDs from menu items
	 */
	public function get_ids( $items ) {

		$ids = array();

		foreach ( $items as $item ) {
			$ids[] = $item->ID;
		}

		return $ids;
	}

	/**
	 * Places top-level items in one array, and children in another.
	 */
	public function walk( $elements, $max_depth ) {	

		$args = array_slice( func_get_args(), 2 );

		$output = '';

		// Invalide parameter
		if ( $max_depth < -1 ) {
			return $output;
		}

		// Nothing to walk
		if ( empty( $elements ) ) {
			return $output;
		}

		// Get field names to use in loop below
		$id_field = $this->db_fields['id'];
		$parent_field = $this->db_fields['parent'];

		/**
		 * Separate elements into two buckets:
		 * top-level and children.
		 */
		$top_level = array();
		$children = array();

		foreach ( $elements as $element ) {

			// Top-level element?
			if ( $element->{$parent_field} == 0 ) {
				$top_level[] = $element;
				continue;
			}

			// Child elements must be set to appear in the main menu
			if ( ! in_array( $element->ID, $this->item_ids ) ) {
				continue;
			}

			// Add to children array, indexed by parent ID
			$children[ $element->{$parent_field} ][] = $element;
		}

		// Display items
		foreach ( $top_level as $element ) {

			// Filter out items that are not set to appear as a
			// top-level menu item
			if ( ! in_array( $element->ID, $this->top_level_item_ids ) ) {
				continue;
			}

			$this->display_element( $element, $children, $max_depth, 0, $args, $output );
		}

		return $output;
	}

	/**
	 * Displays an element of the tree. Responsible for calling 
	 * start_lvl(), end_lvl(), start_el() and end_el()
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}

	/**
	 * Return the HTML for the start of a new level. In this case,
	 * the start of a new <ul>
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		parent::start_lvl( $output, $depth, $args );
	}

	/**
	 * Return the HTML to finish a level. In this case: </ul>
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		parent::end_lvl( $output, $depth, $args );
	}

	/**
	 * Displays the current element. In this case: <li>...
	 */
	public function start_el( &$output, $page, $depth, $args, $current_page = 0 ) {

		extract( $args, EXTR_SKIP );

		// Add item CSS classes
		$css_class = array(

			// Current depth
			'page-depth-' . $depth,

			// Is this needed?
			'page_item',
			
			// Is this needed?
			'page-item-' . $page->ID
		);

		// Check if current item is a subheader item
		if ( $depth == 1 && in_array( $page->ID, $this->subhead_item_ids ) ) {
			$css_class[] = 'menu-item-subheader';
		}

		if ( ! empty( $current_page ) ) {

			$item_obj = get_post( $current_page );

			if ( in_array( $page->ID, $item_obj->ancestors ) ) {
				$css_class[] = 'current_page_ancestor';
			}

			if ( $page->ID == $current_page ) {
				$css_class[] = 'current_page_item';
			}

			if ( $item_obj && $page->ID == $item_obj->post_parent ) {
				$css_class[] = 'current_page_parent';
			}
		
		}

		// If we're on the 'faculty' item
		if ( $page->post_name == 'faculty' ) {

			if ( is_post_type_archive( 'faculty' ) ) {
				$css_class[] = 'current_page_item';
			}

			if ( get_post_type() == 'faculty' ) {
				$css_class[] = 'current_page_parent';
			}

		}

		// Prepare CSS classes
		$css_class = implode( ' ', apply_filters( 'page_css_class', $css_class, $page, $depth, $args, $current_page ) );

		$output .= '<li class="' . $css_class . '">';
        
		$alt_title = '';

		// Wrap top-level items in <span>
		if ( $depth == 0 ) {

			// Check for alternate drop-down title such as
			// "Meet our faculty" for "Faculty"
			$alt_title = get_field( 'drop-down_title', $page->ID );
			$alt_title = $alt_title ? ' title=' . $alt_title . '"' : '';

			$output .= '<span>';
		}
        
		$output .= '<a' . $alt_title . ' href="' . get_permalink($page->ID) . '">' . $link_before . apply_filters( 'the_title', $page->post_title, $page->ID ) . $link_after . '</a>';

		// Wrap top-level item in <span>
		if ( $depth == 0 ) {
			$output .= '</span>';
		}
	}

	/**
	 * Finishes an element. In this case: </li>
	 */
	public function end_el( &$output, $page, $depth = 0, $args = array() ) {
		
		// Continue with original end_el()
		parent::end_el( $output, $depth, $args );

		if ( $depth != 0 ) {
			return;
		}

	}

}