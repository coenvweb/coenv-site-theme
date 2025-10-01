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
            <a class="button"  aria-label="Read more about <?php echo get_the_title(); ?>" href="<?php echo get_the_permalink(); ?>">Read More</a>

        <?php if(get_field('feature_label') == 'Signature Story') { ?>
            <div style="overflow:hidden; float:right; margin-left: 10px;">
                <?php //the_post_thumbnail('thumbnail'); ?>
            </div>
            <?php //the_advanced_excerpt('no_custom=1&no_shortcode=1&length=50&length_type=words') ?>
            <?php //the_excerpt(); ?>

        <?php //} else { ?>
            <?php //the_content() ?>
            <?php //if ( !is_page() && get_field('story_link_url') ) { ?>
                <!--<a href="<?php //echo get_field('story_link_url'); ?>" class="button" target="_blank"><?php //echo get_field('story_source_name'); ?> »</a> -->
            <?php // } ?>
            <!--<p class="read-more"><a href="javascript();" class="button">Read More</a></p>-->
        <?php } ?>

        
    </section>

    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>
</div>
