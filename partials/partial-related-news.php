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
			echo '<h2 class="title">Related News</h2></div>';
			echo '<div class="related-posts">';
    		foreach( $coenv_chosen as $post):
        		setup_postdata($post);
        		echo '<div class="related-container">';
        		
			      echo '<div class="related-thumb">';
					if ( has_post_thumbnail() ) {
						echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
						echo the_post_thumbnail('medium');
						echo '</a>';
					}
			      echo '</div>';
        		echo '<div class="related-article-title">';
						echo '<h3>';
						echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
						echo the_title();
						echo '</a>';
						echo '</h3>';
        		echo '</div>';
            echo '</div>';
    		endforeach;
				echo '<br style="clear:both" />';
			echo '</div>';
            echo '</div>';
            
   			wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly

		} else {

		}

	?>