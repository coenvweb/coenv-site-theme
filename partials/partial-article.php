<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article_header">

		<?php if ( is_page() || is_single() ) : ?>
			<h1 class="article_title"><?php the_title() ?></h1>
		<?php else : ?>
			<h1 class="article_title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<?php endif ?>

	</header>

	<section class="article_content">

		<?php the_content() ?>

	</section>

	<footer class="article_footer">

		<?php if ( !is_page() ) : ?>
			<div class="article_meta">
				Posted <time class="article_time" datetime="<?php get_the_date( 'c' ) ?>"><?php echo get_the_date() ?></time>
				<?php $categories = get_the_category_list() ?>
				<?php if ( $categories ) : ?>
					<div class="article_categories">
					in: <?php echo $categories ?>
					</div>
				<?php endif ?>
			</div>
		<?php endif ?>

	</footer>

</article><!-- .article -->