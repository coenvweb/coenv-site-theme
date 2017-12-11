<?php
/*
 * Template Name: Signature Story
 * Template Post Type: post
 */
  
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);

$banner = coenv_banner();
?>

<style type="text/css">
 .element a {
    color: <?php echo get_field('accent_color'); ?>;
     font-weight: 600;
 }
</style>
<script defer src="https://maps.googleapis.com/maps/api/js?key=***REMOVED***"></script>

<section id="blog" role="main" class="template-signature-story">

		<div class="container">

			<nav id="secondary-nav" class="side-col">

					<ul id="menu-secondary" class="menu">
						<li class="pagenav">
							<a href="<?php echo home_url("/news"); ?>">News</a>
						</li>
          </ul>
                
			</nav><!-- #secondary-nav.side-col -->
  </div>

			<main id="main-col" class="main-col">
          
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'article' ) ?>

					<?php endwhile ?>
                
                <footer class="related">
					<?php get_template_part( 'partials/partial', 'related-news' ) ?>
                    <?php get_template_part( 'partials/partial', 'related-faculty' ) ?>
                </footer>
				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>


				<?php endif ?>
                
			</main><!-- .main-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>
