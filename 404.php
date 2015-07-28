<?php
/**
 * 404.php
 *
 * The 404 not found template
 */
get_header();

?>

	<section id="404" role="main" class="template-page">

		<div class="container">

				<section class="article error">

					<header class="article__header">
						<h1 class="article__title">Page not found</h1>
					</header>

					<div class="entry-content">
						
						<p>The page you requested could not be found (Error 404).</p>
                        <p>If you reached this page from clicking on a hyperlink, please contact <a href="mailto:coenvweb@uw.edu?subject=404 on environment.uw.edu">coenvweb@uw.edu</a> and let us know what page or link you clicked on to get here.</p>
                        <p>Otherwise, try using the search field below to find what you are looking for.</p>

						<?php get_search_form() ?>

					</div><!-- .entry-content -->

				</section><!-- .entry -->

		</div><!-- .container -->

	</section><!-- #404 -->

<?php get_footer(); ?>