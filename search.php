<?php
/**
 * search.php
 *
 * The search results template.
 */
get_header();
?>

	<section id="search" role="main" class="page-area">

		<div class="container">

			<nav id="secondary-nav" class="side-col">
				<ul>
					<li class="pagenav"><a href="#">Search results</a></li>
				</ul>
			</nav><!-- #secondary-nav.side-col -->

			<div class="main-col">

				<section class="entry">
					<header class="entry-header">
						<h1>Search results for "<?php the_search_query() ?>"</h1>
					</header>
				</section>

				<div class="search-results">

					<?php if ( have_posts() ) : ?>

						<?php while ( have_posts() ) : the_post() ?>

							<?php// if ( get_post_type() === 'post' ) continue; // filter for pages only ?>

							<section class="entry">

								<header class="entry-header">

									<?php echo coenv_breadcrumbs() ?>

									<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>

								</header><!-- .entry-header -->

								<section class="entry-content entry-excerpt">

									<?php the_excerpt() ?>

								</section><!-- .entry-content -->

								<footer class="entry-footer">

								</footer><!-- .entry-footer -->

							</section><!-- .entry -->

						<?php endwhile ?>

					<?php endif ?>

				</div><!-- .search-results -->

			</div><!-- .main-col -->

			<div class="side-col">

				<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-search')): endif; ?>

			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer(); ?>