<?php  
/**
 * An individual article featured in the newsletter
 */
?>
<div class="news_item post-<?php the_ID() ?>" id="<?php the_ID() ?>" >
    <div class="article__header">
        <div class="article__meta">
        <?php if ( !is_page() && !is_singular('intranet') ) : ?>
            <div class="post-info">
                <time class="article__time" datetime="<?php get_the_date( '' ); ?>"><?php echo get_the_date('M j, Y'); ?></time>
                <?php coenv_post_cats($post->ID); ?>
            </div>
        <?php endif ?>

            <h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>

        </div>

    <div class="article__content">
            <div style="overflow:hidden; float:right; margin-left: 10px;">
                <?php the_post_thumbnail('thumbnail'); ?>
            </div>
            <?php the_advanced_excerpt('no_custom=1&no_shortcode=1&length=30&length_type=words') ?>
            <br> <br>
            <a class="button"  aria-label="Read more about <?php echo get_the_title(); ?>" href="<?php echo get_the_permalink(); ?>">Read More</a>
    
        </div>

    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>
</div>
