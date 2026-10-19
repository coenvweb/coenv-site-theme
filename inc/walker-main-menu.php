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

	public function __construct() {
		// Pull from cache or fetch once for 12 hours
		$menu_data = get_transient( 'coenv_main_menu_data' );

		if ( false === $menu_data ) {
			$menu_data = array(
				'items'           => $this->fetch_items(),
				'top_level'       => $this->fetch_top_level_items(),
				'subhead'         => $this->fetch_subhead_items(),
			);
			set_transient( 'coenv_main_menu_data', $menu_data, 12 * HOUR_IN_SECONDS );
		}

		$this->items             = $menu_data['items'];
		$this->item_ids          = $this->get_ids( $this->items );

		$this->top_level_items   = $menu_data['top_level'];
		$this->top_level_item_ids = $this->get_ids( $this->top_level_items );

		$this->subhead_items     = $menu_data['subhead'];
		$this->subhead_item_ids  = $this->get_ids( $this->subhead_items );

		// ID of blog home page
		$this->page_for_posts    = get_option( 'page_for_posts' );
		$this->current_page_obj = null;
		$this->current_page_id = 0;
		$this->current_page_ancestors = array();

		// Keep count of top-level items
		$this->top_level_counter = 0;
	}

	/**
	 * Actual database query methods (renamed from get_ to fetch_)
	 */
	public function fetch_items() {
		return get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'   => 'show_in_main_menu',
					'value' => '1',
					'compare' => '=='
				)
			)
		) );
	}

	public function fetch_top_level_items() {
		return get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => 'page',
			'post_parent'    => 0,
			'post_status'    => 'publish',
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'   => 'show_as_top-level_page',
					'value' => '1',
					'compare' => '=='
				)
			)
		) );
	}

	public function fetch_subhead_items() {
		return get_posts( array(
			'posts_per_page' => -1,
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'no_found_rows'  => true,
			'meta_query'     => array(
				array(
					'key'   => 'show_as_sub-header',
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
	public function walk( $elements, $max_depth, ...$args ) {	

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
	public function start_el( &$output, $page, $depth = 0, $args = array(), $current_page = 0 ) {

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
			$current_page_id = (int) $current_page;

			if ( $this->current_page_id !== $current_page_id ) {
				$this->current_page_id = $current_page_id;
				$this->current_page_obj = get_post( $this->current_page_id );
				$this->current_page_ancestors = $this->current_page_obj ? get_post_ancestors( $this->current_page_id ) : array();
			}

			$item_obj = $this->current_page_obj;

			if ( $item_obj && in_array( $page->ID, $this->current_page_ancestors ) ) {
				$css_class[] = 'current_page_ancestor';
			}

			if ( $page->ID == $current_page_id ) {
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
			// "Meet our faculty" for "Faculty".
			// Use the native post meta lookup here instead of ACF's get_field()
			// to avoid one database call per menu item.
			$alt_title = get_post_meta( $page->ID, 'drop-down_title', true );
			$alt_title = $alt_title ? ' title="' . esc_attr( $alt_title ) . '"' : '';

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

};