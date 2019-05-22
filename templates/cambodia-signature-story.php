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
<script defer src="https://maps.googleapis.com/maps/api/js?key=***REMOVED***"></script>

<section id="blog" role="main" class="template-signature-story">

			<main id="main-col" class="main-col">
          
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

            <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

              <header class="article__header" id="#share-<?php the_ID() ?>">
                  <div class="article__title">
                      <h1 class="big__title">Fueled by floods:</h1>
                      <p class="subtitle">The Cambodian People's Food Security is Threatened by Hydropower Demands</p>
                  </div>
              </header>
                
                <div class="waves"></div><!-- waves -->
                <div id="section-introduction" class="scrollto">

              <section class="article__content">

                <?php the_content() ?>

              </section>

            </article><!-- .article -->

					<?php endwhile ?>

				<?php endif ?>
                
			</main><!-- .main-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>
