<?php
/**
 *  Display related faculty based on admin selection or auto based on category.
 */
function coenv_related_faculty ($id, $term = 0) {
    
    global $coenv_member_api;
    
    if (is_singular('post')) {
        $post_tax = 'topic';        
    }
    
    if (is_singular('faculty')) {
        $post_tax = 'member_theme';        
    }
    
    if (empty($term)) {
        $coenv_term = get_field('related_research_area', $id);
        if (!empty($coenv_term)) {
            $term = get_term($coenv_term, 'member_theme');
        }
    }
   
    
    if (empty($term)) {
        $args = array (
            'post_type' => 'faculty',
            'posts_per_page' => '6',
            'post__not_in' => array($id),
            'orderby' => 'rand',
        );
        
        $label = 'Related faculty';
     
        
    } elseif ($coenv_term) {

       $args = array (

            'post_type' => 'faculty',
            'posts_per_page' => '6',
            'post__not_in' => array($id),
            'orderby' => 'rand',
            'tax_query' => array(
            'relation' => 'AND',
                array(
                'taxonomy' => 'member_theme',
                'terms' => $coenv_term,
                'operator' => 'IN',
                )
            )

        );
        
        $label = "Related faculty";
    } else {
        $manual_choice = 1;
        $args = array (
 
             'post_type' => 'faculty',
             'posts_per_page' => '7',
             'post__not_in' => array($id),
             'orderby' => 'rand',
             'post__in' => $term,
         );
         
         $label = "Related faculty";
     }

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		echo '<div class="related-faculty">';
            echo '<div class="related-heading">';
            if (empty($term)) {
                echo '<a href="/faculty/" title="Browse more faculty in the College of the Environment">';
            } else {
                echo '<a href="/faculty/#theme-' . $term->slug . '&unit-all" title="Browse ' . ($query->post_count - 6) . ' more faculty in ' . $term->name . '" >';
            }
                echo '<h2 class="title">Related Faculty</h2></a>';
                
            echo '</div>';
            echo '<div class="related-people">';
            while ( $query->have_posts() ) {
                $query->the_post();
                // set up unit color style
                $units = get_the_terms( get_the_id(), 'unit' );
                $unit = array_shift( $units );
                $unit_color = $coenv_member_api->unit_color( $unit->term_id );
                $unit_style = ' style="background-color: ' . $unit_color . ';"';
                echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"' . $unit_style . '" rel="bookmark">';
                    echo '<div class="related-container" >';
                    $image_id = get_field( 'image' );
                    if ( $image_id ) {
                        echo '<div class="related-thumb">';
                        $image_attributes = wp_get_attachment_image_src( $image_id, 'thumbnail' );
                        echo '<img alt="" src=' . $image_attributes[0] . '>';
                        echo '</div>';
                    }	
                    echo '<div class="related-faculty-name">';
                        echo '<p>';
                            echo the_title();
                        echo '</p>';
                    echo '</div>';
                echo '</div>';
            echo '</a>';
		}
        if (empty($manual_choice)) {
            if (empty($term)) {
                $profile_count = wp_count_posts('faculty');
                $profile_count = $profile_count->publish;
                echo '<a href="/faculty/" title="Browse ' . ($profile_count - 6) . ' more faculty in the College of the Environment" class="count" >';
            } else {
                echo '<a href="/faculty/#theme-' . $term->slug . '&unit-all" title="Browse ' . ($query->post_count - 6) . ' more faculty in ' . $term->name . '" class="count" >';
            }
            echo '<div class="related-container">';
            echo '<div class="related-thumb">';
            echo '<i class="icon-faculty-grid-alt-2"></i>';
            echo '</div>';
            if (empty($term)) {
                echo '<span class="number">+' . ($profile_count - 6) . ' more';
            } else {
                echo '<span class="number">+' . ($term->count - 6) . ' more';
            }
            echo '</span></div>';
            echo '</a>';
        }
        echo '</div>';
        echo '</div>';
        
	} else {
		// no posts found
	}

	wp_reset_postdata();

}

function faculty_sidebar_shortcode( $atts, $content = null ) {
	ob_start();
    echo '<div class="widget-column">';
    echo '<div class="grey-widget faculty-sidebar">';
    echo '<a href="/faculty" class="faculty-sidebar-title"><h2><i class="icon-faculty-grid-alt-2"></i> Faculty Profiles</h2></a>';
    echo '<span class="caption">' . $content . '</span>'; 
    coenv_related_faculty( $post->ID );
    echo '</div></div>';
    return ob_get_clean();
}
add_shortcode( 'faculty_sidebar', 'faculty_sidebar_shortcode' );

function remove_faculty_search( $query ) {
    // Run only on search
    if ( $query->is_search() && $query->is_main_query() ) {
        //dont set post type if one is already specified
        if(!$query->query_vars['post_type']) {
            $types = get_post_types(array('exclude_from_search'=>false));
            // remove faculty from post types to search
            unset($types['faculty']);
            unset($types['careers']);
            $query->query_vars['post_type'] = $types;
        }
        $query->query_vars['posts_per_page'] = 15;

    }
}
add_action( 'pre_get_posts', 'remove_faculty_search' );