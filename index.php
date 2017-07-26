<?php
/**
 * index.php
 *
 * Main template
 * Used for blog posts
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

	<section id="blog" role="main" class="template-blog">

		<div class="container">

			<nav id="secondary-nav" class="side-col">

					<ul id="menu-secondary" class="menu">
						<li class="pagenav">
							<a href="<?php echo home_url("/news"); ?>">News</a>
						</li>
          </ul>

			</nav><!-- #secondary-nav.side-col -->

			<main id="main-col" class="main-col">

				<?php get_template_part( 'partials/partial', 'blog-header' ) ?>

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'story' ) ?>

					<?php endwhile ?>
                
                <?php else : ?>
                	<article <?php post_class( 'article' ) ?>>

                        <header class="article__header">
                        </header>
                        <section class="">
                            <p><strong>No Results Found</strong><br />
                            Please try searching with different terms.</p>
                        </section>
                </article>
				<?php endif ?>

				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>

			</main><!-- .main-col -->

			<div class="side-col">
                <?php the_widget('CoEnv_Widget_Newsletter', array('title' => 'Headlines Newsletter', 'newsletter_url' => 'https://environment.uw.edu/news/college-newsletter')); ?>
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>
