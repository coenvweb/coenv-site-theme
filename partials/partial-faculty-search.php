<?php  
/**
 * Individual article on the search results page.
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header">

        <?php 
            $image = get_field('image');
            $fac_bio = get_field ('biography');
        ?>
        <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?> - Faculty Profile</a></h1>

	</header>

	<section class="article__content row">
        <div class="fac_search_img">
            <?php echo wp_get_attachment_image($image, array(150, 150)); ?>
        </div>
        <div class="large-8 small-12 columns">
            <?php
            if ($fac_bio) {
                echo wp_trim_words($fac_bio, 75, '...');
            }
            ?>
        </div>
	</section>

</article><!-- .article -->	
