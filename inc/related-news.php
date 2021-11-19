<?php

/**
 *  Display related news based on admin selection or auto based on category.
 */
function coenv_related_news ($id) {
    
	$coenv_choice = get_field('related_posts');
	$coenv_related_news_label = get_field('related_news_label');

	if ( !$coenv_related_news_label ) { 
		$coenv_related_news_label = 'Related news';
	};

    if ( $coenv_choice == 'related' ) {
        $post_tax = 'topic';
		$_coenv_terms = get_the_terms( $id, $post_tax );
		$coenv_terms = array();
		$field = 'slug';
	
		if($_coenv_terms) {
			foreach ( $_coenv_terms as $term) {
				$coenv_terms[] = $term->slug;
			}
		}
		$args = array (

			'post_type' => 'post',
			'posts_per_page' => '2',
			'post__not_in' => array($id),
			'post_in' => $coenv_chosen,
			'tax_query' => array(
			'relation' => 'AND',
				array(
				'taxonomy' => $post_tax,
				'field' => $field,
				'terms' => $coenv_terms,
				'operator' => 'IN'
				)
			)
	
		);
    }
    
    if ( $coenv_choice == 'unit') {
        $post_tax = 'unit';
		$coenv_terms = get_field('choose_related_unit');
		$field = 'id';

		$args = array (

			'post_type' => 'post',
			'posts_per_page' => '2',
			'post__not_in' => array($id),
			'post_in' => $coenv_chosen,
			'tax_query' => array(
			'relation' => 'AND',
				array(
				'taxonomy' => $post_tax,
				'field' => $field,
				'terms' => $coenv_terms,
				'operator' => 'IN'
				)
			)
	
		);
    }

	if ( $coenv_choice == 'choose') {
		$coenv_chosen = get_field('related_posts_post');

		$args = array (
			'post_type' => 'post',
			'posts_per_page' => '2',
			'post__not_in' => array($id),
			'post__in' => $coenv_chosen,	
			'ignore_sticky_posts' => 1,
		);
	}

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		echo '<div class="related-news">';
		echo '<div class="related-heading">';
		echo '<h2 class="title">' . $coenv_related_news_label  . '</h2>';
		echo '</div>';
		echo '<div class="related-posts">';
		while ( $query->have_posts() ) {
			$query->the_post();
			echo '<div class="related-container">';
			if ( has_post_thumbnail() ) {
				echo '<div class="related-thumb">';
				echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
				echo the_post_thumbnail('medium');
				echo '</a>';
				echo '</div>';
			}	
			echo '<div class="related-article-title">';
			echo '<h3>';
			echo '<a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
			echo the_title();
			echo '</a>';
			echo '</h3>';
			
		echo '</div>';
        echo '</div>';
		}
        echo '<br style="clear:both" />';
		echo '</div>';
        echo '</div>';

	} else {
		// no posts found
	}

	wp_reset_postdata();

}

?>