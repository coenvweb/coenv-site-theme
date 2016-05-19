<?php
/**
 * search.php
 *
 * The search results template.
 */
get_header();

$classes = array( 'template-search' );
if ( get_query_var('post_type') == 'post') {
    $classes[] = 'template-page news-search';
} elseif ( get_query_var('intranet') == 'intranet' ) {
	$classes[] = 'template-page intranet';
} else {
	$classes[] = 'template-page base_search';
}
?>

	<section id="search" role="main" class="<?php echo implode( ' ', $classes ) ?>">

		<div class="layout-container">

			<nav id="secondary-nav" class="side-col">
				<ul>
					<li class="pagenav"><a href="#">Search results</a></li>
				</ul>
			</nav><!-- #secondary-nav.side-col -->

			<main id="main-col" class="main-col search-wrap">

				<section class="article search-header">
					<header class="article__header">
						<h1 class="article__title"><?php echo $wp_query->found_posts ?> search results for "<?php the_search_query() ?>"</h1>
					</header>
				</section>

				<div class="search-results">

					<?php if ( have_posts() ) { ?>

						<?php while ( have_posts() ) : the_post() ?>

								<?php get_template_part( 'partials/partial', 'article-search' ) ?>

						<?php endwhile ?>

                    <?php } else { ?>

                        <article class="article">

                            <section class="article__content">

                                <p>No results found. Please try searching with different terms.</p>
                                <?php get_search_form() ?>

                            </section>

                        </article><!-- .article -->

					<?php } ?>

				</div><!-- .search-results -->

				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>

			</main><!-- .main-col -->
            
            <div class="side-col">
                <?php get_sidebar('search') ?>
            </div>

		</div><!-- .layout-container -->

	</section><!-- #page -->

<?php get_footer(); ?>
