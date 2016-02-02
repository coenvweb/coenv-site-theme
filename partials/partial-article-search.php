<?php  
/**
 * Individual article on the search results page.
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header">

		<?php if ( is_page() || is_single() ) : ?>
			<h1 class="article__title"><?php the_title() ?></h1>
		<?php else : ?>
            <?php 
                $fac_bio = get_field ('biography');
                if ($fac_bio) { echo 'Faculty Profile '; } ?>
			<h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<?php endif ?>

	</header>

	<section class="article__content">
		<?php
        if ($fac_bio) {
            echo $fac_bio;
        } elseif (function_exists(the_advanced_excerpt)) {
			the_advanced_excerpt('length=20&length_type=words&no_custom=1&ellipsis=%26hellip;&exclude_tags=img,p,strong,table&no_shortcode=1');
		} else {
			echo get_the_excerpt();
		}
		?>
		
	</section>

</article><!-- .article -->	