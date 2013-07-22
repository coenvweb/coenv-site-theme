<?php
/**
 * index.php
 *
 * Main template
 * Used for blog posts
 */
get_header();
?>

	<section id="blog" role="main">

		<div class="container">

			<nav id="secondary-nav" class="side-col">

				<?php get_template_part( 'partials/partial', 'blog-nav' ) ?>

			</nav><!-- #secondary-nav -->

			<div class="main-col">

				<?php get_template_part( 'partials/partial', 'blog-header' ) ?>

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'post' ) ?>

					<?php endwhile ?>

				<?php endif ?>

				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>

			</div><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>