<?php
/**
 * The faculty directory home page
 *
 * Lists faculty
 */

// Redirect to /coenv-faculty/ if not logged in
if ( !is_user_logged_in() ) {
	wp_redirect( get_bloginfo('url') . '/coenv-faculty/' );
}

/**
 * The faculty archive page
 */
get_header();
wp_enqueue_script( 'coenv-faculty' );
//wp_enqueue_script( 'coenv-faculty-test' );

// get all themes
$themes = get_terms(
	array( 'member_theme' ),
	array( 'hide_empty' => false )
);

// get all units
$units = get_terms(
	array( 'member_unit' ),
	array( 'hide_empty' => false )
);

$query_args = wp_parse_args( $_SERVER['QUERY_STRING'] );

// build the faculty query based on $query_args
$query = array(
	'post_type' => 'faculty',
	'posts_per_page' => -1,
	'orderby' => 'rand',
	'tax_query' => array()
);

// add theme
if ( isset( $query_args['theme'] ) && !empty( $query_args['theme'] ) ) {
	$query['tax_query'][] = array(
		'taxonomy' => 'member_theme',
		'field' => 'slug',
		'terms' => $query_args['theme']
 	);
}

// add unit
if ( isset( $query_args['unit'] ) && !empty( $query_args['unit'] ) ) {
	$query['tax_query'][] = array(
		'taxonomy' => 'member_unit',
		'field' => 'slug',
		'terms' => $query_args['unit']
 	);
}

// Make query
$faculty = new WP_Query( $query );

// randomize featured (large) faculty members
// TODO: Make featured items always appear in the same
// space. Might fix the problem of the layout breaking
//$featured = range(9, 199);
//shuffle($featured);
//$featured = array_slice($featured, 0, 20);

$featured = array(6,14,29,38,42,56,64,77,85,93,103,115,124,139,144,156,161,172,188,198,200);
?>

	<section class="Faculty-list" id="faculty-archive">

		<div class="container">

			<?php get_template_part( 'partials/partial', 'faculty-selector' ); ?>

			<?php if ( $faculty->have_posts() ) : ?>

				<div class="Faculty-list-content">

					<?php $count = 0; ?>

					<?php get_template_part( 'partials/partial', 'faculty-toolbox' ); ?>

					<?php while ( $faculty->have_posts() ) : $faculty->the_post() ?>

						<?php get_template_part( 'partials/partial', 'faculty-list-item' ); ?>

						<?php $count++ ?>

					<?php endwhile ?>

					<div class="gutter-sizer"></div>

				</div><!-- .Faculty-list-content -->

			<?php else : ?>

				<p>No faculty were found in that combination.</p>

			<?php endif ?>

			<?php wp_reset_postdata(); ?>

		</div><!-- .container -->

	</section>

<?php get_footer(); ?>