<?php
/*
Template Name: Full width
*/
get_header();
?>

	<section id="page" role="main" class="template-page">

		<div class="container">

			<main id="main-col" class="main-col" style="width: 100%;">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'article' ) ?>

					<?php endwhile ?>

				<?php endif ?>

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>