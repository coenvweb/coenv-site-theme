<?php
/**
 * Walker: Career Opportunities Links
 *
 * Called by wp_list_categories() in partials/partial-careers-filter.php for filter links in sidebar.
 *
 */

class CoEnv_Career_Category extends Walker_Category{
    function start_el(&$output, $category, $depth = 0, $args = array(), $current_page = 0) {
        extract($args);
 
        $cat_name = esc_attr( $category->name );
        $cat_name = apply_filters( 'list_cats', $cat_name, $category );
        $cat_slug = esc_attr( $category->slug);
        if ( $category->parent > 0 ) {
        	// Link to career opportunities url is hard-coded below
            $link = '<li class="term_id_'.$category->term_id.' button"  name="filter_career[]" aria-pressed="false" value="'.$category->term_id.'">';
        }
            $link .= $cat_name;
 
        if ( $category->parent > 0 ) {
            $link .= '</li>';
        }
 
        if ( !empty($feed_image) || !empty($feed) ) {
            $link .= ' ';
 
            if ( empty($feed_image) )
                $link .= '(';
 
            $link .= '<a href="' . get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) . '"';
 
            if ( empty($feed) ) {
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
            } else {
                $title = ' title="' . $feed . '"';
                $alt = ' alt="' . $feed . '"';
                $name = $feed;
                $link .= $title;
            }
 
            $link .= '>';
 
            if ( empty($feed_image) )
                $link .= $name;
            else
                $link .= "<img src='$feed_image'$alt$title" . ' />';
 
            $link .= '</a>';
 
            if ( empty($feed_image) )
                $link .= ')';
        }
 
        if ( !empty($show_count) )
            $link .= ' (' . intval($category->count) . ')';
 
        if ( !empty($show_date) )
            $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
 
        if ( 'list' == $args['style'] ) {
            if ( $category->parent == 0 ) {
            $output .= "\t<li";
            $class = 'cat-item cat-item-' . $category->term_id;
            if ( !empty($current_category) ) {
                $_current_category = get_term( $current_category, $category->taxonomy );
                if ( $category->term_id == $current_category )
                    $class .=  ' current-cat';
                elseif ( $category->term_id == $_current_category->parent )
                    $class .=  ' current-cat-parent';
            }
            $output .=  ' class="' . $class . '">';
            }
            $output .= "$link\n";
        } else {
            $output .= "\t$link<br />\n";
        }
    }
}