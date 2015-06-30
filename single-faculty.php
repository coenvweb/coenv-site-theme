<?php
/**
 * Template to show single faculty member
 */


get_header();

$obj = get_queried_object();

$member = $coenv_member_api->setup_faculty_attributes( $obj, 'heavy' );

?>

<section class="Faculty-single" role="main">
	
	<div class="container">

		<div class="Faculty-single-container">
		
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

			<header id="main-col" class="Faculty-member-header">
				
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

		</div><!-- .Faculty-single-container -->

	</div><!-- .container -->

	<div class="Faculty-member-content">
		
		<div class="container">

			<div class="side-col">

				<ul class="Faculty-member-contact-list">
					
					<?php if ( ! empty( $member['email'] ) ) : ?>
						<li><a href="mailto:<?php echo eae_encode_emails($member['email']) ?>"><i class="icon-contact-link-email"></i> <?php echo eae_encode_emails($member['email']) ?></a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['phone'] ) ) : ?>
						<li><a href="tel:<?php echo $member['phone'] ?>"><i class="icon-contact-link-phone"></i> <?php echo $member['phone'] ?></a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['website'] ) ) : ?>
						<li><a href="<?php echo $member['website'] ?>" target="_blank"><i class="icon-contact-link-web"></i> Website</a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['scival'] ) ) : ?>
						<li><a href="<?php echo $member['scival'] ?>" target="_blank"><i class="icon-contact-link-scival"></i> SciVal</a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['twitter'] ) ) : ?>
						<li><a href="<?php echo $member['twitter'] ?>" target="_blank"><i class="icon-contact-link-twitter"></i> Twitter</a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['facebook'] ) ) : ?>
						<li><a href="<?php echo $member['facebook'] ?>" target="_blank"><i class="icon-contact-link-facebook"></i> Facebook</a></li>
					<?php endif ?>



				</ul>

			</div><!-- .side-col -->

			<div class="main-col">

				<section class="Faculty-member-tabs">

					<article class="Faculty-member-tab Faculty-member-tab--bio active-tab">

						<div class="entry-content">

							<?php if ( !empty( $member['pullquote'] ) ) : ?>

								<blockquote class="Faculty-member-pullquote">

									<p><?php echo $member['pullquote'] ?></p>

								</blockquote>

							<?php endif ?>

							<?php if ( !empty( $member['biography'] ) ) : ?>

								<div class="Faculty-member-bio">
									<?php echo $member['biography'] ?>
								</div>
                            </ul><!-- .Faculty-member-tabs -->
                    </div><!-- .entry-content -->

                    <?php endif ?>
                    
			</div><!-- .main-col -->

			<div class="side-col">

				<?php 
					the_widget( 'CoEnv_Widget_Faculty', array(
						//'location' => 'external', 
						'id' => 'coenv_faculty_widget-' . str_replace( ' ', '-', preg_replace("/[^A-Za-z0-9 ]/", '', $member['full_name'] ) ),
						'theme' => $member['themes'][0]['slug'],
						'unit' => 'all'
					) ) 
				?>

			</div><!-- .side-col -->
                
        </div><!-- .container -->

	</div><!-- .Faculty-member-content -->
    <div class="container">
            
            <div class="main-col">
        
                <footer class="related">
                    <?php get_template_part( 'partials/partial', 'related-faculty' ) ?>
                    <?php get_template_part( 'partials/partial', 'related-news' ) ?>
                </footer>
                </article>
            
            </div><!-- .main-col -->

    </div><!-- .container -->
    
</section><!-- .Faculty-single -->

<?php get_footer() ?>
