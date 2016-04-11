<?php
/**
 * The faculty directory home page
 *
 * Lists faculty
 */


/**
 * The faculty archive page
 */
get_header();
wp_enqueue_script( 'coenv-faculty' );

$themes = $coenv_member_api->get_themes();
$units = $coenv_member_api->get_units();

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
//$featured = range(9, 199);
//shuffle($featured);
//$featured = array_slice($featured, 0, 20);

$featured = array(6,14,29,38,42,56,64,77,85,93,103,115,124,139,144,156,161,172,188,198,200);?>

<div class="container">
		 <div class="print">
			<h1>Faculty</h1>
				<p>The College of the Environment Faculty Profiles can be viewed on your computer or mobile device on the web at the <a href="/faculty" name="Faculty Profiles">College of the Environment website</a>.</p>
<img src="<?php echo get_template_directory_uri() ?>/assets/img/faculty-slide-light.jpg" title="Faculty Profiles preview" alt="Preview of Faculty Profiles feature">
			</div>
</div>

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
