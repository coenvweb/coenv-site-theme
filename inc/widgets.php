<?php



function coenv_widgets_init() {

	$before_widget	= '<section id="%1$s" class="widget %2$s">';
	$before_title 	= '<header class="section-header"><h3>';
	$after_title	= '</h3></header> <!-- end .section-header -->';
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
            if ((get_field('show_as_top-level_page', $page->ID) == true ) || has_post_thumbnail($page->ID) || (get_option('page_on_front') == $page->ID) && ($page->post_title !== 'Home')){
                register_sidebar( array(
                    'name' 			=> $page->post_title . ' / Sidebar',
                    'id'			=> 'sidebar-' . $page->ID,
                    'before_widget' => $before_widget,
                    'after_widget'	=> $after_widget,
                    'before_title' 	=> $before_title,
                    'after_title'	=> $after_title
                ) );
                register_sidebar( array(
                    'name' 			=> $page->post_title . ' / Footer',
                    'id'			=> 'sidebar-footer-' . $page->ID,
                    'before_widget' => $before_widget,
                    'after_widget'	=> $after_widget,
                    'before_title' 	=> $before_title,
                    'after_title'	=> $after_title
                ) );
            }
            if( ($page->post_title == 'Home')){
                register_sidebar( array(
                    'name' 			=> 'Homepage / Sidebar',
                    'id'			=> 'sidebar-' . $page->ID,
                    'before_widget' => $before_widget,
                    'after_widget'	=> $after_widget,
                    'before_title' 	=> '<header class="section-header"><h2>',
                    'after_title'	=> '</h2></header> <!-- end .section-header -->'
                ) );
            }
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

add_action( 'widgets_init', 'coenv_widgets_init' );

?>