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
								<?php if ( !empty( $member['units'] ) ) : ?>
                  <h3 class="Faculty-member-unit"><a href="<?php echo $member['units'][0]['url'] ?>" title="See all faculty members in <?php echo $member['units'][0]['name'] ?>">
                <?php echo $member['units'][0]['name'] ?></a></h3>
								<h1 class="Faculty-member-name"><?php echo $member['full_name'] ?></h1>
								<?php endif ?>
								<?php if ( !empty( $member['academic_title'] ) ) : ?>
									<h2 class="Faculty-member-academic-title"><?php echo $member['academic_title'] ?></h2>
								<?php endif ?>
                <!--<?php //if ( !empty( $member['endowments_chairs'] ) ) : ?>
									<!--<h3 class="Faculty-member-endowment"><?php //echo $member['endowments_chairs'] ?></h3>-->
								<?php //endif ?>

								<?php if ( !empty( $member['themes'] ) ) : ?>

									<div class="Faculty-member-themes">

										Working on: 

										<ul>

											<?php foreach ( $member['themes'] as $theme ) : ?>

												<li><a href="<?php echo $theme['url'] ?>" title="See all faculty members in <?php echo $theme['name'] ?>"><?php echo $theme['name'] ?></a></li>

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
						<li><a href="mailto:<?php echo antispambot($member['email']) ?>"><i class="icon-contact-link-email"></i> <?php echo antispambot($member['email']) ?></a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['phone'] ) ) : ?>
						<li><a href="tel:<?php echo $member['phone'] ?>"><i class="icon-contact-link-phone"></i> <?php echo $member['phone'] ?></a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['website'] ) ) : ?>
						<li><a href="<?php echo $member['website'] ?>" target="_blank"><i class="icon-contact-link-web"></i> Website</a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['twitter'] ) ) : ?>
						<li><a href="<?php echo $member['twitter'] ?>" target="_blank"><i class="icon-contact-link-twitter"></i> Twitter</a></li>
					<?php endif ?>
						
					<?php if ( ! empty( $member['bluesky'] ) ) : ?>
						<li class="contact-link bluesky"><a href="<?php echo $member['bluesky'] ?>" target="_blank"><svg width="13" height="13" viewBox="0 0 34 34" style="display: inline-table; "><g transform="scale(0.055 0.055)">
								<path d="M123.121 33.6637C188.241 82.5526 258.281 181.681 284 234.873C309.719 181.681 379.759 82.5526 444.879 33.6637C491.866 -1.61183 568 -28.9064 568 57.9464C568 75.2916 558.055 203.659 552.222 224.501C531.947 296.954 458.067 315.434 392.347 304.249C507.222 323.8 536.444 388.56 473.333 453.32C353.473 576.312 301.061 422.461 287.631 383.039C285.169 375.812 284.017 372.431 284 375.306C283.983 372.431 282.831 375.812 280.369 383.039C266.939 422.461 214.527 576.312 94.6667 453.32C31.5556 388.56 60.7778 323.8 175.653 304.249C109.933 315.434 36.0535 296.954 15.7778 224.501C9.94525 203.659 0 75.2916 0 57.9464C0 -28.9064 76.1345 -1.61183 123.121 33.6637Z"></path>
							</svg>  Bluesky</a></li>
					<?php endif ?>

					<?php if ( ! empty( $member['instagram'] ) ) : ?>
						<li class="contact-link instagram"><a href="<?php echo $member['instagram'] ?>" target="_blank"><svg width="13" height="13" viewBox="0 0 34 34" style="display: inline-table; ">
								<path d="M16 2.881c4.275 0 4.781 0.019 6.462 0.094 1.563 0.069 2.406 0.331 2.969 0.55 0.744 0.288 1.281 0.638 1.837 1.194 0.563 0.563 0.906 1.094 1.2 1.838 0.219 0.563 0.481 1.412 0.55 2.969 0.075 1.688 0.094 2.194 0.094 6.463s-0.019 4.781-0.094 6.463c-0.069 1.563-0.331 2.406-0.55 2.969-0.288 0.744-0.637 1.281-1.194 1.837-0.563 0.563-1.094 0.906-1.837 1.2-0.563 0.219-1.413 0.481-2.969 0.55-1.688 0.075-2.194 0.094-6.463 0.094s-4.781-0.019-6.463-0.094c-1.563-0.069-2.406-0.331-2.969-0.55-0.744-0.288-1.281-0.637-1.838-1.194-0.563-0.563-0.906-1.094-1.2-1.837-0.219-0.563-0.481-1.413-0.55-2.969-0.075-1.688-0.094-2.194-0.094-6.463s0.019-4.781 0.094-6.463c0.069-1.563 0.331-2.406 0.55-2.969 0.288-0.744 0.638-1.281 1.194-1.838 0.563-0.563 1.094-0.906 1.838-1.2 0.563-0.219 1.412-0.481 2.969-0.55 1.681-0.075 2.188-0.094 6.463-0.094zM16 0c-4.344 0-4.887 0.019-6.594 0.094-1.7 0.075-2.869 0.35-3.881 0.744-1.056 0.412-1.95 0.956-2.837 1.85-0.894 0.888-1.438 1.781-1.85 2.831-0.394 1.019-0.669 2.181-0.744 3.881-0.075 1.713-0.094 2.256-0.094 6.6s0.019 4.887 0.094 6.594c0.075 1.7 0.35 2.869 0.744 3.881 0.413 1.056 0.956 1.95 1.85 2.837 0.887 0.887 1.781 1.438 2.831 1.844 1.019 0.394 2.181 0.669 3.881 0.744 1.706 0.075 2.25 0.094 6.594 0.094s4.888-0.019 6.594-0.094c1.7-0.075 2.869-0.35 3.881-0.744 1.050-0.406 1.944-0.956 2.831-1.844s1.438-1.781 1.844-2.831c0.394-1.019 0.669-2.181 0.744-3.881 0.075-1.706 0.094-2.25 0.094-6.594s-0.019-4.887-0.094-6.594c-0.075-1.7-0.35-2.869-0.744-3.881-0.394-1.063-0.938-1.956-1.831-2.844-0.887-0.887-1.781-1.438-2.831-1.844-1.019-0.394-2.181-0.669-3.881-0.744-1.712-0.081-2.256-0.1-6.6-0.1v0z"></path>
								<path d="M16 7.781c-4.537 0-8.219 3.681-8.219 8.219s3.681 8.219 8.219 8.219 8.219-3.681 8.219-8.219c0-4.537-3.681-8.219-8.219-8.219zM16 21.331c-2.944 0-5.331-2.387-5.331-5.331s2.387-5.331 5.331-5.331c2.944 0 5.331 2.387 5.331 5.331s-2.387 5.331-5.331 5.331z"></path>
								<path d="M26.462 7.456c0 1.060-0.859 1.919-1.919 1.919s-1.919-0.859-1.919-1.919c0-1.060 0.859-1.919 1.919-1.919s1.919 0.859 1.919 1.919z"></path>
							</svg>  Instagram</a></li>
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
