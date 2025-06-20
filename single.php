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

						<?php get_template_part( 'partials/partial', 'article' ) ?>

					<?php endwhile ?>
                
                <footer class="related">
                    <?php
                        global $post;
                        $tempPost = $post;
                        get_template_part( 'partials/partial', 'related-news' );
                        $post = $tempPost;
                        get_template_part( 'partials/partial', 'related-faculty' );
                        $post = $tempPost;
                    ?>
                </footer>
				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>


				<?php endif ?>
                
			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>