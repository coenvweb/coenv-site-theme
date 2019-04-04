<?php  
/**
 * Individual article on the search results page.
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

    <header class="article__header">
        
        <?php
            $post_type = get_post_type();
            $post_type_object = get_post_type_object( $post_type );
            echo '<div class="article__meta"><p class="post-info">' . $post_type_object->labels->singular_name . '</p></div>';
        ?>

        <?php if ( $post_type == 'staff') : ?>
            <h1 class="article__title"><a href="/about/office-of-the-dean/deans-office-staff/#<?php echo 'bio-t-' . sanitize_title(get_the_title()); ?>" rel="bookmark">Dean's Office Staff</a></h1>
            </header>
            <section class="article__content row">
                <?php echo get_the_title() . ' | ' . get_field( 'job_title', get_the_id() ); ?>
            </section>
        <?php elseif ( is_page() || is_single() ) : ?>
            <h1 class="article__title"><?php the_title() ?></h1>
            </header>
            <section class="article__content row">
                <?php echo get_the_excerpt(); ?>
            </section>
        <?php else : ?>
            <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
            </header>
            <section class="article__content row">
                <?php echo get_the_excerpt(); ?>
            </section>
        <?php endif ?>

</article><!-- .article -->
