<?php if (is_front_page()): ?>
	<article class="story">
		<div class="inner">
            <?php if ( get_field('autocrop') == true) {
                $col_image = 'homepage-column-standard';
            } else {
                $col_image = 'homepage-column';
            }; ?>
            <?php if ( has_term( 'weekly-research', 'topic' ) || ( has_term( 'deans-letter', 'story_type' ) ) || ( has_term( 'podcast', 'story_type' ) ) ) : ?>
                    <a href="<?php the_permalink() ?>" class="img">
                        <?php the_post_thumbnail( $col_image ); ?>
                    </a>

                <?php if ( has_term( 'weekly-research', 'topic' ) ): ?> 
                    <div class="story-series">
                        <a href="<?php echo get_term_link( 'weekly-research', 'topic' ); ?>" name="View all Weekly Research Posts">Weekly Published Research</a>
                    </div>
                <?php endif ?>
                <?php if ( has_term( 'deans-letter', 'story_type' ) ): ?> 
                    <div class="story-series">
                        <a href="<?php echo get_term_link( 'deans-letter', 'story_type' ); ?>" name="View all Letters from the Dean">Letter from the Dean</a>
                    </div>
                <?php endif ?>
                <a class="content" href="<?php the_permalink() ?>">
                    <h3><?php the_title() ?></h3>
                </a>
			<?php else : ?>
				<a href="<?php the_permalink() ?>" class="img">
					<?php the_post_thumbnail( $col_image ); ?>
                    <div class="content">
                        <h3><?php the_title() ?></h3>
                    </div>
                </a>
            <?php endif ?>

		</div><!-- .inner -->

	</article>
<?php else: ?>
	<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header">
        <div class="article__meta">
   		<?php if ( !is_page() ) : ?>
			
			<div class="post-info">
				<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time> 
				<?php coenv_post_cats($post->ID); ?>
            </div>
		<?php endif ?>
		</div>

		<?php if ( is_page() || is_single() ) : ?>
			<h1 class="article__title"><?php the_title() ?></h1>
		<?php else : ?>
			<h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<?php endif ?>

	</header>
	<section class="article__content">
		<div class="coenv-thumb"><a style="float: right;" href="<?php echo the_permalink(); ?>"><?php the_post_thumbnail( 'small' ) ?></a></div>

		<?php if ( is_single() ) { ?>
			<?php $trimmed_content = breezer_addDivToImage(get_the_content()); ?>
			<?php $trimmed_content = strip_tags($trimmed_content,'<a>'); ?>
			<?php $trimmed_content = strip_shortcodes ($trimmed_content); ?>
			<?php echo '<p>' . $trimmed_content . '</p>'; ?>

			

		<?php } else { ?>
			<?php $trimmed_content = breezer_addDivToImage(get_the_excerpt()); ?>
			<?php $trimmed_content = strip_tags($trimmed_content,'<a>'); ?>
			<?php $trimmed_content = strip_shortcodes ($trimmed_content); ?>
			<?php echo '<p>' . $trimmed_content . '</p>'; ?>

				<?php if ( get_field('story_link_url') ) { ?>
        <?php if ( strpos(get_field('story_link_url'),"environment.") ) {
          $env_target = '_self';
        } else {
          $env_target = '_blank';
        }
        ?>
        <a href="<?php echo get_field('story_link_url'); ?>" class="button" target="<?php echo $env_target; ?>"><?php echo get_field('story_source_name'); ?> »</a>
				<?php } else { ?>
					<a href="<?php echo the_permalink(); ?>" class="button">Read more »</a>
				<?php } ?>

		<?php } ?>

	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->
<?php endif; ?>