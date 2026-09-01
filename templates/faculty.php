<?php
/**
 * Template Name: Faculty
 *
 * Lists faculty
 */


/**
 * The faculty archive page
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);

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

$faculty_facts = array();
if ( have_rows( 'faculty_facts', 'option' ) ) {
	while ( have_rows( 'faculty_facts', 'option' ) ) {
		the_row();

		$factoid = get_sub_field( 'factoid' );
		if ( empty( $factoid ) ) {
			continue;
		}

		$faculty_facts[] = array(
			'number_value' => get_sub_field( 'number_value' ),
			'factoid' => $factoid,
		);
	}
}

if ( count( $faculty_facts ) > 1 ) {
	shuffle( $faculty_facts );
}
?>

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

				<div class="Faculty-list-content" id="main-col">

					<?php get_template_part( 'partials/partial', 'faculty-toolbox' ); ?>

					<?php
					$faculty_count = (int) $faculty->post_count;
					$fact_count = count( $faculty_facts );
					$faculty_index = 0;
					$fact_index = 0;
					$fact_positions = array();

					if ( $fact_count > 0 ) {
						for ( $i = 0; $i < $fact_count; $i++ ) {
							$base_position = ( ( $i + 0.5 ) * $faculty_count ) / $fact_count;
							$jitter = mt_rand( -3, 3 );
							$position = (int) round( $base_position + $jitter );

							if ( $i > 0 ) {
								$position = max( $position, $fact_positions[ $i - 1 ] + 1 );
							}

							$max_position = $faculty_count - ( $fact_count - $i - 1 );
							$position = max( 0, min( $position, $max_position ) );

							$fact_positions[] = $position;
						}
					}

					$render_fact_tile = function ( $fact ) {
						?>
						<article class="Faculty-list-item Faculty-list-item--fact jsIsotopeItem theme-all unit-all">
							<div class="Faculty-list-item-inner Faculty-list-item-inner--fact">

								<?php if ( !empty( $fact['number_value'] ) ) : ?>
									<p class="Faculty-list-item-fact-number"><?php echo esc_html( $fact['number_value'] ); ?></p>
								<?php endif; ?>

								<p class="Faculty-list-item-fact-text"><?php echo esc_html( $fact['factoid'] ); ?></p>

							</div>
						</article>
						<?php
					};
					?>

					<?php while ( $faculty->have_posts() ) : $faculty->the_post() ?>

						<?php while ( $fact_index < $fact_count && $faculty_index >= $fact_positions[$fact_index] ) : ?>
							<?php $render_fact_tile( $faculty_facts[$fact_index] ); ?>
							<?php $fact_index++; ?>
						<?php endwhile; ?>

						<?php get_template_part( 'partials/partial', 'faculty-list-item' ); ?>
						<?php $faculty_index++; ?>

					<?php endwhile ?>

					<?php while ( $fact_index < $fact_count ) : ?>
						<?php $render_fact_tile( $faculty_facts[$fact_index] ); ?>
						<?php $fact_index++; ?>
					<?php endwhile; ?>

					<div class="gutter-sizer"></div>

				</div><!-- .Faculty-list-content -->

			<?php else : ?>

				<p>No faculty were found in that combination.</p>

			<?php endif ?>

			<?php wp_reset_postdata(); ?>

		</div><!-- .container -->

	</section>

<?php get_footer(); ?>
