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
			echo '<a href="/news" name="See all College news">';
			echo '<p class="more">All News »</p></a></div>';
			echo '<div class="related-posts">';
    		foreach( $coenv_chosen as $post):
        		setup_postdata($post);
        		echo '<div class="related-container">';
        		echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
			      echo '<div class="related-thumb">';
						echo the_post_thumbnail('large');
			      echo '</div>';
        		echo '<div class="related-article-title">';
						echo '<h3>';
						echo the_title();
						echo '</h3>';
        		echo '</div></a></div>';
    		endforeach;
				echo '<br style="clear:both" />';
			echo '</div>';
   			wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly

		} else {

		}

	?>