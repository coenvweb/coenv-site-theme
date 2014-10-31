<?php
/*
Template Name: Careers Blog
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
); 

$query_args = wp_parse_args( $_SERVER['QUERY_STRING'] );

// build the query based on $query_args
$query = array(
	'post_type' => 'careers',
	'posts_per_page' => 20,
	'tax_query' => array()
);

// Make query
$careers = new WP_Query( $query ); 

?>

	<section id="blog" role="main" class="template-blog">

		<div class="container">
			
			<?php if ( in_array( $post->post_type, array('page') ) ) : ?>

				<nav id="secondary-nav" class="side-col">

					<ul id="menu-secondary" class="menu">
						  <?php wp_list_pages( array(
								'child_of' => $ancestor['id'],
							  'depth' => 0,
							  'title_li' => '<a href="' . $ancestor['permalink'] . '">' . $ancestor['title'] . '</a>',
							  'link_after' => '<i class="icon-arrow-right"></i>',
							  'walker' => new CoEnv_Secondary_Menu_Walker,
							  'sort_column' => 'menu_order'
						  ) ) ?>
					  </ul>

				</nav><!-- #secondary-nav.side-col -->

			<?php endif ?>

			<main id="main-col" class="main-col">

				<?php while ( $careers->have_posts() ) : $careers->the_post() ?>

						<?php get_template_part( 'partials/partial', 'career' ); ?>

						<?php $count++ ?>

					<?php endwhile ?>

				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_template_part( 'partials/partial', 'careers-filter' ) ?>
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>