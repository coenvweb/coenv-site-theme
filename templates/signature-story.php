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

if ( is_singular( 'post' ) ) {
	$posts_page_id = (int) get_option( 'page_for_posts' );

	if ( $posts_page_id ) {
		$posts_page_ancestors = get_post_ancestors( $posts_page_id );
		$nav_root_id = !empty( $posts_page_ancestors ) ? (int) array_pop( $posts_page_ancestors ) : $posts_page_id;

		$ancestor = array(
			'id' => $nav_root_id,
			'permalink' => get_permalink( $nav_root_id ),
			'title' => get_the_title( $nav_root_id )
		);
	}
}

$banner = coenv_banner();
?>

	<section id="blog" class="template-signature-story">

		<div class="container">
			<br />

			<main id="main-col" class="main-col">

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