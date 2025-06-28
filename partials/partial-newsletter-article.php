<?php  
/**
 * An individual article featured in the newsletter
 */
?>
<div class="news_item post-<?php the_ID() ?>" id="<?php the_ID() ?>" >
    <header class="article__header">
        <div class="article__meta">
        <?php if ( !is_page() && !is_singular('intranet') ) : ?>
            <div class="post-info">
                <time class="article__time" datetime="<?php get_the_date( '' ); ?>"><?php echo get_the_date('M j, Y'); ?></time>
                <?php coenv_post_cats($post->ID); ?>
            </div>
        <?php endif ?>

        <?php if ( is_page() || is_single() ) : ?>
            <h1 class="article__title"><?php the_title() ?></h1>
        <?php else : ?>
            <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
        <?php endif ?>

    </header>

    <section class="article__content">
            <div>
                <a class="button" href="<?php echo get_the_permalink(); ?>">Read More</a>
            </div>
    </section>

    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>
</div>
