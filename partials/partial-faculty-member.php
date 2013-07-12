<?php
/**
 * Partial for displaying a single faculty member within the faculty grid
 */
global $coenv_member_api;
global $count;
global $featured;

// set up demo image
// TODO: remove this
global $images;

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

// set up demo image
// TODO: remove this
if ( in_array( $count, $featured ) ) {
	$member_classes .= ' featured';
	$image = $images[ array_rand( $images ) ]['lg'];
} else {
	$image = $images[ array_rand( $images ) ]['sm'];
}

?>
<article class="faculty-member search-<?php the_ID() ?> jsIsotopeItem<?php echo $member_classes ?>">

	<a href="<?php bloginfo('url') ?>/faculty/katharine-w-huntington/" class="faculty-member-inner jsIsotopeItemInner"<?php echo $unit_style ?>>

		<div class="faculty-member-image" data-image="<?php echo $image ?>">
			<img src="<?php echo $image ?>" />
			<noscript><img src="<?php echo $image ?>" /></noscript>
		</div><!-- .faculty-member-image -->

		<header class="faculty-member-header">
			<h1 class="faculty-member-name"><?php the_title() ?></h1>
			<h2 class="faculty-member-unit"><?php echo $unit->name ?></h2>
		</header><!-- .faculty-member-header -->

	</a><!-- .faculty-member-inner -->

</article><!-- .faculty-member -->