<?php
/**
 * Partial for displaying a single faculty member within the faculty grid
 */
global $coenv_member_api, $count, $featured;

// set up theme classes
$themes = get_the_terms( get_the_ID(), 'member_theme' );
$member_classes = ' theme-all';
if ( !empty( $themes ) ) {
	foreach ( $themes as $theme ) {
		$member_classes .= ' theme-' . $theme->slug;
	}
}

// set up unit color style
$units = get_the_terms( get_the_ID(), 'member_unit' );
$unit = array_shift( $units );
$unit_color = $coenv_member_api->unit_color( $unit->term_id );
$unit_style = ' style="background-color: ' . $unit_color . ';"';

$member_classes .= ' unit-all';

if ( !empty( $unit ) ) {
	$member_classes .= ' unit-' . $unit->slug;
}

$image_id = get_field( 'image' );
if ( in_array( $count, $featured ) ) {
	$member_classes .= ' featured';
	// TODO: update these sizes for retina images
	$image = wp_get_attachment_image_src( $image_id, 'small' );
} else {
	// TODO: update these sizes for retina images
	$image = wp_get_attachment_image_src( $image_id, 'small' );
}

?>

<article class="Faculty-list-item Faculty-list-item--<?php the_ID() ?> jsIsotopeItem<?php echo $member_classes ?>" id="<?php the_ID() ?>">
	
	<a href="<?php the_permalink() ?>" class="Faculty-list-item-inner jsIsotopeItemInner" title="<?php the_title() ?>"<?php echo $unit_style ?>>

		<div class="Faculty-list-item-image" data-image="<?php echo $image[0] ?>">
			<img src="<?php echo $image[0] ?>" alt="<?php the_title() ?>" />
			<noscript><img src="<?php echo $image ?>" alt="<?php the_title() ?>" /></noscript>
		</div>

		<header class="Faculty-list-item-header">
			<h2 class="Faculty-list-item-title"><?php the_title() ?></h2>
			<h3 class="Faculty-list-item-subtitle"><?php echo $unit->name ?></h3>
		</header>

	</a><!-- .Faculty-list-item-inner -->

</article><!-- .Faculty-list-item -->






















