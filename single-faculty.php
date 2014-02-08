<?php
/**
 * Template to show single faculty member
 */
// Redirect to /coenv-faculty/ if not logged in
if ( !is_user_logged_in() ) {
	wp_redirect( get_bloginfo('url') . '/coenv-faculty/' );
}


get_header();

$obj = get_queried_object();

$member = $coenv_member_api->setup_faculty_attributes( $obj->ID, 'heavy' );

// set up member tab nav
$member_tabs = array();
if ( !empty( $member['pullquote'] ) || !empty( $member['biography'] ) ) {
	$member_tabs[] = array(
		'data-tab' => 'member-tab-bio',
		'title' => 'About ' . $member['full_name'],
		'active' => true
	);
}

if ( !empty( $member['publications'] ) ) {
	$member_tabs[] = array(
		'data-tab' => 'member-tab-publications',
		'title' => 'Publications'
	);
}

if ( !empty( $member['stories'] ) ) {
	$member_tabs[] = array(
		'data-tab' => 'member-tab-stories',
		'title' => 'Stories from CoEnv Currents'
	);
}

?>

<section class="Faculty-single" role="main">
	
	<div class="container">
		
		<nav class="Faculty-header">

			<div class="Faculty-header-inner">
				
				<div class="Faculty-header-top">
					<a class="Faculty-header-link" href="<?php bloginfo('url') ?>/faculty/"><i class="icon-faculty-grid-alt-2"></i> Search and filter faculty</a>
				</div>

				<div class="Faculty-header-bottom">
					<h1 class="Faculty-header-title">Faculty</h1>
				</div>

			</div><!-- .Faculty-header-inner -->

		</nav><!-- .Faculty-header -->

		<header class="Faculty-member-header">
			
			<div class="Faculty-member-image">

				<div class="Faculty-member-image-inner">
						
					<?php if ( !empty( $member['images']['large'] ) ) : ?>

						<img src="<?php echo $member['images']['medium']['url'] ?>" alt="Portrait of <?php echo $member['full_name'] ?>" />

					<?php endif ?>

				</div><!-- .Faculty-member-image-inner -->

			</div><!-- .Faculty-member-image -->

			<div class="Faculty-member-vcard">

				<div class="Faculty-member-vcard-inner" style="background-color: <?php echo $member['units'][0]['color'] ?>;">

					<div class="Faculty-member-vcard-content">

						<div class="Faculty-member-vcard-content-inner">
							
							<h1 class="Faculty-member-name"><?php echo $member['full_name'] ?></h1>

							<?php if ( !empty( $member['academic_title'] ) ) : ?>
								<h2 class="Faculty-member-academic-title"><?php echo $member['academic_title'] ?></h2>
							<?php endif ?>

							<?php if ( !empty( $member['units'] ) ) : ?>
								<h3 class="Faculty-member-unit"><a href="<?php echo $member['units'][0]['url'] ?>"><?php echo $member['units'][0]['name'] ?></a></h3>
							<?php endif ?>

							<?php if ( !empty( $member['themes'] ) ) : ?>

								<div class="Faculty-member-themes">

									Working on: 

									<ul>

										<?php foreach ( $member['themes'] as $theme ) : ?>

											<li><a href="<?php echo $theme['url'] ?>"><?php echo $theme['name'] ?></a></li>

										<?php endforeach ?>

									</ul>

								</div><!-- .Faculty-member-themes -->

							<?php endif ?>

						</div><!-- .Faculty-member-vcard-content-inner -->
						
					</div><!-- .Faculty-member-vcard-content -->

				</div><!-- .Faculty-member-vcard-inner -->

			</div><!-- .Faculty-member-vcard -->

		</header><!-- .Faculty-member-header -->

	</div><!-- .container -->

</section><!-- .Faculty-single -->







<?php get_footer() ?>