<?php
/**
 * Related Posts
 */
		$coenv_choice = get_field('related_posts');
		if ( $coenv_choice == 'related' ) {
			coenv_related_news( $post->ID );
		} elseif ( $coenv_choice == 'choose' && $posts) {
			$coenv_chosen = get_field('related_posts_post');
			echo '<h3 style="margin: 2rem 0;">Related News</h3>';
			echo '<ul>';
    		foreach( $coenv_chosen as $post):
        		setup_postdata($post);
        		echo '<li>';
        		echo '<p>' . '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' . the_post_thumbnail('small') . '</a></p>';
        		echo '<p>' . the_title( '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' ) . '</p>';
        		echo '</li>';
    		endforeach;
    		echo '</ul>';
   			wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly

		} else {

		}

	?>