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

	<section id="blog" class="template-blog">

		<div class="container">

			<nav id="secondary-nav" class="side-col">

			<ul id="menu-secondary" class="menu">
                  <?php
                  $list_args = array(
                      'child_of' => $ancestor['id'],
                      'depth' => 3,
					  'title_li' => '',
					  'echo' => 0,
                      'walker' => new CoEnv_Secondary_Menu_Walker,
                      'sort_column' => 'menu_order' 
                  );
				  $secondary_nav_items = wp_list_pages($list_args);
				  echo '<li class="pagenav"><ul>' . $secondary_nav_items . '</ul></li>';
                  ?>
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