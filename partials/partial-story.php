<?php if (is_front_page()): ?>
	<article class="story">
		<div class="inner">
            <?php if ( get_field('autocrop') == true) {
                $col_image = 'homepage-column-standard';
            } else {
                $col_image = 'homepage-column';
            }; ?>
            <?php if ( has_term( 'weekly-research', 'topic' ) || ( has_term( 'deans-letter', 'story_type', 'podcast' ) ) ) : ?>
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
				<?php if ( has_term( 'podcast', 'story_type' ) ): ?> 
                    <div class="story-series">
                        <a href="<?php echo get_term_link( 'podcast', 'story_type' ); ?>" name="View all podcasts"><svg style="color: white" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 448 512"><!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. --><path d="M224 0C100.3 0 0 100.3 0 224c0 92.22 55.77 171.4 135.4 205.7c-3.48-20.75-6.17-41.59-6.998-58.15C80.08 340.1 48 285.8 48 224c0-97.05 78.95-176 176-176s176 78.95 176 176c0 61.79-32.08 116.1-80.39 147.6c-.834 16.5-3.541 37.37-7.035 58.17C392.2 395.4 448 316.2 448 224C448 100.3 347.7 0 224 0zM224 312c-32.88 0-64 8.625-64 43.75c0 33.13 12.88 104.3 20.62 132.8C185.8 507.6 205.1 512 224 512s38.25-4.375 43.38-23.38C275.1 459.9 288 388.8 288 355.8C288 320.6 256.9 312 224 312zM224 280c30.95 0 56-25.05 56-56S254.1 168 224 168S168 193 168 224S193 280 224 280zM368 224c0-79.53-64.47-144-144-144S80 144.5 80 224c0 44.83 20.92 84.38 53.04 110.8c4.857-12.65 14.13-25.88 32.05-35.04C165.1 299.7 165.4 299.7 165.6 299.7C142.9 282.1 128 254.9 128 224c0-53.02 42.98-96 96-96s96 42.98 96 96c0 30.92-14.87 58.13-37.57 75.68c.1309 .0254 .5078 .0488 .4746 .0742c17.93 9.16 27.19 22.38 32.05 35.04C347.1 308.4 368 268.8 368 224z" fill="white"></path></svg> Anecdotal Evidence</a>
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
			<div class="share align-right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
			data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
			data-article-permalink="<?php echo the_permalink(); ?>"><a><i class="icon-share"></i>Share</a>
            </div>
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
        <a href="<?php the_field('story_link_url'); ?>" class="button" target="<?php echo $env_target; ?>"><?php the_field('story_source_name'); ?> »</a>
				<?php } else { ?>
					<a href="<?php echo the_permalink(); ?>" class="button">Read more »</a>
				<?php } ?>

		<?php } ?>

	</section>
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->
<?php endif; ?>