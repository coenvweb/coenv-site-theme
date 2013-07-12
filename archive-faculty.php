<?php
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

// choose random theme to start
//$selected_theme_key = array_rand( $themes );
//$selected_theme = $themes[ $selected_theme_key ];

// the faculty query
$faculty = new WP_Query(array(
	'post_type' => 'faculty',
	'posts_per_page' => -1,
	'orderby' => 'rand'
));

// randomize featured (large) faculty members
$featured = range(9, 199);
shuffle($featured);
$featured = array_slice($featured, 0, 20);

// set up demo images
// TODO: remove this
$images = array();
for ( $i = 1; $i < 13; $i++ ) {
	$images[] = array(
		'sm' => get_template_directory_uri() . '/assets/img/faculty-test-images/' . $i . '-sm.jpg',
		'lg' => get_template_directory_uri() . '/assets/img/faculty-test-images/' . $i . '.jpg'
	);
}
?>

	<section id="faculty-archive" class="archive-faculty" role="main">

		<div class="container">

			<?php if ( $faculty->have_posts() ) : ?>

				<div class="faculty-tiles">

					<?php get_template_part( 'partials/partial', 'faculty-toolbox' ); ?>

					<?php $count = 0; ?>

					<?php while ( $faculty->have_posts() ) : $faculty->the_post() ?>

						<?php get_template_part( 'partials/partial', 'faculty-member' ); ?>

						<?php $count++ ?>

					<?php endwhile ?>

				</div><!-- .faculty-tiles -->

			<?php endif ?>

			<?php wp_reset_postdata(); ?>

		</div><!-- .container -->

	</section><!-- #faculty-archive -->

<?php get_footer(); ?>