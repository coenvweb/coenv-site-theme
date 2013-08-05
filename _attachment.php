<?php
/**
 * attachment.php
 *
 * Single attachment template
 */
get_header();
?>

	<section id="page" role="main" class="page-area">

		<div class="container">

			<div class="main-col">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<article class="article attachment">

							<header>
								<h1><?php the_title() ?></h1>

								<?php
								$metadata = wp_get_attachment_metadata();
									printf( __( '<span class="meta-prep meta-prep-entry-date">Published </span> <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%8$s</a>.', 'coenv' ),
										esc_attr( get_the_date( 'c' ) ),
										esc_html( get_the_date() ),
										esc_url( wp_get_attachment_url() ),
										$metadata['width'],
										$metadata['height'],
										esc_url( get_permalink( $post->post_parent ) ),
										esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
										get_the_title( $post->post_parent )
									);
								?>
							</header>

							<div class="entry-content">
								<?php echo wp_get_attachment_image( $post->ID, $attachment_size ) ?>
							</div>

						</article>

					<?php endwhile ?>

				<?php endif ?>

			</div><!-- .main-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>