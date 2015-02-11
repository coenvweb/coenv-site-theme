<article id="post-<?php the_ID() ?>" <?php post_class( 'career' ) ?>>

	<header class="article__header">
        <div class="article__meta">
			<div class="share align-right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
			data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
			data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="icon-share"></i>Share</a>
            </div>
			<div class="post-info">
                Posted: 
				<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time>
                | Deadline: 
                <?php $timestamp = strtotime(do_shortcode('[postexpirator type="full"]')) ?>
                <time class="article__time" datetime="<?php echo date('Y-m-d h:i:s', $timestamp) ?>"><?php echo date('M j, Y', $timestamp) ?></time>
                
                
				<?php coenv_post_cats($post->ID); ?>
            </div>
		</div>

		<?php if ( is_single() ) : ?>
			<h1 class="article__title"><?php the_title() ?></h1>
		<?php else : ?>
			<h3 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h3>
		<?php endif ?>

	</header>
	<section class="career__content">
		<div class="coenv-thumb"><a style="float: right;" href="<?php echo the_permalink(); ?>"><?php the_post_thumbnail( 'small' ) ?></a></div>
		<?php if ( get_field('story_link_url') ): ?>
			<?php echo '<p>' . get_the_content() . '</p>'; ?>
			<p class="expiration">Deadline: <?php echo do_shortcode('[postexpirator]') ?></p>
			<a href="<?php the_field('story_link_url'); ?>" class="button" target="_blank"><?php the_field('story_source_name'); ?> »</a> 
		<?php else: ?>
			<?php echo '<p>' . get_the_content() . '</p>'; ?>
			<a href="<?php echo the_permalink(); ?>" class="button">Read more »</a>
		<?php endif; ?>

	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->