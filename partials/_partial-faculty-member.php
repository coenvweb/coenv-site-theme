<?php
/**
 * Partial for displaying a single faculty member within the faculty grid
 */
global $coenv_member_api;
global $count;
global $featured;

// set up theme classes
$themes = get_the_terms( get_the_ID(), 'member_theme' );
$member_classes = '';
if ( !empty( $themes ) ) {
	foreach ( $themes as $theme ) {
		$member_classes .= ' theme-' . $theme->slug;
	}
}

if ( in_array( $count, $featured ) ) {
	$member_classes .= ' featured';
}

//if ( in_array( $count, $numbers ) ) echo ' large';

// set up unit color style
$units = get_the_terms( get_the_ID(), 'member_unit' );
$unit = array_shift( $units );
$unit_color = $coenv_member_api->unit_color( $unit->term_id );
$unit_style = ' style="background-color: ' . $unit_color . ';"';

// set up demo image
// TODO: remove this
global $images;
$image = $images[ array_rand( $images ) ];

?>
<article class="faculty-member jsIsotopeItem<?php echo $member_classes ?>"<?php echo $unit_style ?>>

	<a href="<?php the_permalink() ?>">
			<div class="faculty-member-image">
				<img class="lazy" src="<?php echo get_template_directory_uri() ?>/assets/img/dot.png" data-original="<?php echo $image ?>" />
				<noscript><img src="<?php echo $image ?>" /></noscript>
			<div><!-- faculty-member-image -->

			<header class="faculty-member-header">
				<h1 class="faculty-member-name"><?php the_title() ?></h1>
				<h2 class="faculty-member-unit"><?php echo $unit->name ?></h2>
			</header>
	</a>

</article><!-- .faculty-member -->