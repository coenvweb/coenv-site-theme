<?php
/**
 * page.php
 *
 * The main page template
 */
get_header();

$ancestor_id = 32;

$ancestor = array(
	'id' => 32,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);
?>

	<section id="page" role="main" class="template-page">

		<div class="container">

            <?php if ( in_array( $post->post_type, array('page', 'careers') ) ) : ?>

				<nav id="secondary-nav" class="side-col">

                    <ul id="menu-secondary" class="menu">
                        <li class="pagenav">
                          <?php echo '<a href="' . $ancestor['permalink'] . '"><span>Back to</span>' . $ancestor['title'] . '</a>'; ?>
                            <ul class="career-actions">
                                <li><a class="back-side" href="/students/career-resources/career-opportunities/">← Back to All Career Opportunities</a>
                                </li>
                            </ul>
                            <ul class="career-actions">
                                <li><a href="/students/career-resources/career-opportunities/for-employers/"><span class="dashicons dashicons-welcome-add-page"></span> Post an Opportunity</a></li>
                                <li><a href="/students/career-resources/career-opportunities/tips-for-jobinternship-seekers/"><span class="dashicons dashicons-star-filled"></span> Tips for Seekers</a></li>
                                <li><a href="/students/career-resources/career-opportunities/uw-environmental-career-fair/"><span class="dashicons dashicons-businessman"></span> UW Environmental Career Fair</a></li>
                            </ul>
                        </li>
                    </ul>
				</nav><!-- #secondary-nav.side-col -->

			<?php endif ?>


			<main id="main-col" class="main-col">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>
					<?php 
                	$deadline = get_post_meta( get_the_ID(), '_expiration-date', true );
					$timestamp = time();
					$timeexpired = (int) strtotime(do_shortcode('[postexpirator type="full"]'));
					
					if ( $timeexpired < $timestamp ) {

					$expired = 'expired';
                        
                } elseif ( $deadline > ($timestamp + 63072000) ) {
                        
						$expired = 'openuntilfilled';

				} else {

					$expired = 'current';
				}
                $open_until_filled = get_field('open_until_filled');
                
                ?>                

						<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

							<header class="article__header">
						        <div class="article__meta">

								<?php if ( is_page() || is_single() ) : ?>
									<h1 class="article__title">Career Opportunities</h1>
								<?php else : ?>
									<h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
								<?php endif ?>

							</header>
                                
                                <?php
        $location = get_field('location');
        if (isset($location)) {
            $location= ' - '.$location;
        }
        ?>

							<section class="article__content">
								<div class="post-info">
									<span class="posted">Posted: <time class="article__time" datetime="<?php get_the_date( '' ); ?>"><?php echo get_the_date('M j, Y'); ?></time></span>
									<span class="deadline">
									<?php if (isset($open_until_filled[0])) { ?>
                                        Deadline: Open Until Filled
                                    <?php } elseif ($expired == 'current') { ?>
                                        Deadline: <time class="article__time" datetime="<?php echo date('Y-m-d h:i:s', $timestamp) ?>"><?php echo date('M j, Y', $timeexpired) ?></time>
                                        
                                    <?php } elseif ($expired == 'openuntilfilled') { ?>
                                        Deadline: Open Until Filled
                                    <?php } else { ?>
                                        Deadline passed (<time class="article__time expired" datetime="<?php echo date('Y-m-d h:i:s', $timestamp) ?>"><?php echo date('M j, Y', $timeexpired) ?></time>)
                                    <?php } ?>               	
					                </span>            	
									<h2><?php the_title(); echo $location; ?></h2>
								</div>
								
								<p class="back"><a class="button" href="/students/career-resources/career-opportunities/">← Back to Career Opportunities</a></p>
								<section class="career__content">
								<?php strip_tags(the_content(), '<a>'); ?>
								</section>
								<?php $career_tags = get_the_terms(get_the_ID(),'career_post_tag'); ?>
								<?php if ( $career_tags && ! is_wp_error( $career_tags ) ) : 
									foreach ( $career_tags as $tag ) {
										$career_tag_links .= '<a href="/students/career-resources/career-funding-opportunities/?tag=' . $tag->slug . '" title="' . $tag->name . '">' . $tag->name . '</a>, ';
									}
								?>
								<div class="career-terms">
									<?php echo rtrim($career_tag_links,', '); ?>
								</div>
								<?php endif; ?>
								
									
							</section>
								
						    <?php remove_filter( 'the_title', 'wptexturize' );
						    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

						</article><!-- .article -->

					<?php endwhile ?>

				<?php endif ?>

			</main><!-- .main-col -->

			<div class="side-col">

			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>