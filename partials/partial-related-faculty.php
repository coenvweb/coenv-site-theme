<?php
/**
 * Related Faculty
 */
global $coenv_member_api;
    $coenv_choice = get_field('related_faculty');
    if ( $coenv_choice == 'related' ) {
        coenv_related_faculty( $post->ID );
    } elseif ( $coenv_choice == 'choose' && $posts) {
        $coenv_chosen = get_field('related_faculty_post');
        echo '<div class="related-faculty">';
            echo '<div class="related-heading">';
                echo '<h3 class="title">Related Faculty</h3>';
            echo '</div>';
            echo '<div class="related-people">';
                foreach( $coenv_chosen as $post):
                    setup_postdata($post);
                    $units = get_the_terms( $post, 'member_unit' );
                    $unit = array_shift( $units );
                    $unit_color = $coenv_member_api->unit_color( $unit->term_id );
                    $unit_style = ' style="background-color: ' . $unit_color . ';"';
                    echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' )  . '"' . $unit_style . '" rel="bookmark">';
                        echo '<div class="related-container">';
                            $image_id = get_field( 'image', $post );
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
                endforeach;
            echo '</div>';
        echo '</div>';
        wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly

    } else {

    }

?>