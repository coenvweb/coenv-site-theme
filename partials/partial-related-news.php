<?php
/**
 * Related Posts
 */
		$coenv_choice = get_field('related_posts');
		if ( $coenv_choice == 'related' ) {
			coenv_related_news( $post->ID );
		} elseif ( $coenv_choice == 'choose' && $posts) {
			$coenv_chosen = get_field('related_posts_post');
			echo '<div class="related-news"><div class="related-heading">';
			echo '<h2 class="title">Related News</h2>';
			echo '<p class="more">More »</p></div>';
			echo '<ul>';
    		foreach( $coenv_chosen as $post):
        		setup_postdata($post);
        		echo '<li>';
        		echo '<div class="related-thumb">' . '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' . the_post_thumbnail('small') . '</a></div>';
        		echo '<div class="related-article-title"><h3>';
						echo the_title( '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' ) . '</h3>';
        		echo '</div></li>';
    		endforeach;
    		echo '</ul>';
			echo '</div>';
   			wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly

		} else {

		}

	?>