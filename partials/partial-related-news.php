<?php
/**
 * Related Posts
 */
		$coenv_choice = get_field('related_posts');
		if ( $coenv_choice == 'related' ) {
			coenv_related_news( $post->ID );
		} elseif ( $coenv_choice == 'unit') {
			coenv_related_news( $coenv_choice );
		} elseif ( $coenv_choice == 'choose') {
			coenv_related_news( $post->ID );
		} else {

		}

	?>