<section class="entry">
	
	<header class="entry-header">

		<div class="meta">
			<?php echo coenv_post_date() ?>
		</div><!-- .meta -->

		<?php if ( is_single() ) : ?>

			<h1><?php the_title() ?></h1>			

		<?php else : ?>

			<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>

		<?php endif ?>

	</header><!-- .entry-header -->

	<section class="entry-content">

		<?php if ( is_single() ) : ?>

			<?php the_content() ?>

		<?php else : ?>

			<?php the_content() ?>

		<?php endif ?>

	</section><!-- .entry-content -->

	<footer class="entry-footer">

	</footer><!-- .entry-footer -->

</section><!-- .entry -->