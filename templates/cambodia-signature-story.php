<?php
/*
 * Template Name: Cambodia Signature Story
 * Template Post Type: post
 */
  
get_header();

$banner = coenv_banner();
?>

<style type="text/css">
 .element a {
    color: <?php echo get_field('accent_color'); ?>;
     font-weight: 600;
 }
</style>
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbky381Xxqtk8LVWJEENojL44RG2oYR14"></script>

<section id="blog" role="main" class="template-signature-story">

		<div class="container">

			<nav id="secondary-nav" class="side-col">
                
			</nav><!-- #secondary-nav.side-col -->
  </div>

			<main id="main-col" class="main-col">
          
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'article' ) ?>

					<?php endwhile ?>

				<?php endif ?>
                
			</main><!-- .main-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>
