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
if(!is_paged() ) {
    $search_query = explode(' ', get_search_query());
    $fac_meta_query = array(
        'relation' => 'OR',
        'posts_per_page' => -1,
    );
    foreach($search_query as $keyword) {
        $fn = array('key' => 'first_name', 'value' => $keyword);
        $ln = array('key' => 'last_name', 'value' => $keyword);
        $fac_meta_query[] = $fn;
        $fac_meta_query[] = $ln;
    }

    $facArgs = array(
        'post_type' => 'faculty',
        'meta_query' => $fac_meta_query
    );

    $facSearch = new WP_Query($facArgs);
}
?>

	<section id="search" role="main" class="<?php echo implode( ' ', $classes ) ?>">

		<div class="layout-container">

			<nav id="secondary-nav" class="side-col">
				<ul>
					<li class="pagenav"><a href="#">Search results</a></li>
				</ul>
			</nav><!-- #secondary-nav.side-col -->

			<main id="main-col" class="main-col">

				<section class="article search-header">
					<header class="article__header">
						<h1 class="article__title">Search results for "<?php the_search_query() ?>"</h1>
					</header>
				</section>

				<div class="search-results">

                    <?php if ( isset($facSearch) && $facSearch->have_posts() ) { ?>

                        <?php while ( $facSearch->have_posts() ) : $facSearch->the_post(); ?>

                            <?php get_template_part( 'partials/partial', 'faculty-search' ) ?>

                        <?php endwhile ?>

                    <?php } ?>

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
                <?php get_sidebar() ?>
            </div>

		</div><!-- .layout-container -->

	</section><!-- #page -->

<?php get_footer(); ?>
