<?php
/**
 *  Display related faculty based on admin selection or auto based on category.
 */
function coenv_related_faculty ($id) {
    
    global $coenv_member_api;
    
    if (is_singular('post')) {
        $post_tax = 'topic';        
    }
    
    if (is_singular('faculty')) {
        $post_tax = 'member_theme';        
    }
    
    $coenv_term = get_field('related_research_area', $id);
    $term = get_term($coenv_term, 'member_theme');

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

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		echo '<div class="related-faculty">';
            echo '<div class="related-heading">';
                $label = get_field('related_faculty_label');
                if ($label) {
                    echo '<h2 class="title">' . get_field('related_faculty_label') . '</h2>';
                } else {
                    echo '<h2 class="title">Related Faculty</h2>';
                }
                
            echo '</div>';
            echo '<div class="related-people">';
            while ( $query->have_posts() ) {
                $query->the_post();
                // set up unit color style
                $units = get_the_terms( $post, 'member_unit' );
                $unit = array_shift( $units );
                $unit_color = $coenv_member_api->unit_color( $unit->term_id );
                $unit_style = ' style="background-color: ' . $unit_color . ';"';
                echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"' . $unit_style . '" rel="bookmark">';
                    echo '<div class="related-container" >';
                    $image_id = get_field( 'image' );
                    if ( $image_id ) {
                        echo '<div class="related-thumb">';
                        echo wp_get_attachment_image( $image_id, 'thumbnail' );
                        echo '</div>';
                    }	
                    echo '<div class="related-faculty-name">';
                        echo '<h3>';
                            echo the_title();
                        echo '</h3>';
                    echo '</div>';
                echo '</div>';
            echo '</a>';
		}
        echo '<a href="/faculty/#theme-' . $term->slug . '&unit-all" title="Browse ' . $term->count.' more faculty in ' . $term->name . '" class="count" >';
        echo '<div class="related-container">';
        echo '<div class="related-thumb">';
        echo '<i class="icon-faculty-grid-alt-2"></i>';
        echo '</div>';
        echo '<span class="number">+' . ($term->count - 6) . ' more';
        echo '</span></div>';
        echo '</a>';
        echo '</div>';
        echo '</div>';
        
	} else {
		// no posts found
	}

	wp_reset_postdata();

}
