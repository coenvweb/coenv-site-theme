<?php
/**
 * page.php
 *
 * The main page template
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => 32,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);
?>

	<section id="page" role="main" class="template-page">

		<div class="container">

												<nav id="secondary-nav" class="side-col">

			<ul id="menu-secondary" class="menu">
	              <li class="pagenav"><a href="/students/">Students</a><ul><li class="page_item page-item-25988"><a href="/students/meet-students/">Why Study Here?</a></li>
<li class="page_item page-item-25999"><a href="/students/meet-our-students/">Meet Our Students</a>
<ul class='children'>
<li class="page_item page-item-26122"><a href="/students/meet-our-students/undergraduates/">Undergraduates</a></li>
<li class="page_item page-item-26124"><a href="/students/meet-our-students/graduates/">Graduates</a></li>
</ul>
</li>
<li class="page_item page-item-26001"><a href="/students/degrees-programs-and-courses/">Degrees, Programs, and Courses</a>
<ul class='children'>
<li class="page_item page-item-26022"><a href="/students/degrees-programs-and-courses/undergraduate-degrees/">Undergraduate Degrees</a></li>
<li class="page_item page-item-26024"><a href="/students/degrees-programs-and-courses/graduate-degrees/">Graduate Degrees</a></li>
<li class="page_item page-item-26029"><a href="/students/degrees-programs-and-courses/general-education-requirements/">General Education Requirements</a></li>
<li class="page_item page-item-26034"><a href="/students/degrees-programs-and-courses/mesa/">MESA</a></li>
<li class="page_item page-item-26036"><a href="/students/degrees-programs-and-courses/doris-duke-conservation-scholars/">Doris Duke Conservation Scholars</a></li>
</ul>
</li>
<li class="page_item page-item-26003"><a href="/students/student-resources/">Student Resources</a>
<ul class='children'>
<li class="page_item page-item-26044"><a href="/students/student-resources/financing-funding/">Funding</a>
	<ul class='children'>
<li class="page_item page-item-26112"><a href="/students/student-resources/financing-funding/scholarships/">Scholarships</a></li>
<li class="page_item page-item-26114"><a href="/students/student-resources/financing-funding/student-meeting-travel-fund/">Student Travel &#038; Meeting Fund</a></li>
	</ul>
</li>
<li class="page_item page-item-26046"><a href="/students/student-resources/student-policies-help/">Student Policies &#038; Help</a></li>
<li class="page_item page-item-26048"><a href="/students/student-resources/get-involved/">Get Involved</a>
	<ul class='children'>
<li class="page_item page-item-26128"><a href="/students/student-resources/get-involved/student-advisory-council/">Student Advisory Council</a></li>
<li class="page_item page-item-26132"><a href="/students/student-resources/get-involved/student-groups/">Student Groups</a></li>
<li class="page_item page-item-26149"><a href="/students/student-resources/get-involved/study-abroad/">Study Abroad</a></li>
	</ul>
</li>
<li class="page_item page-item-26050"><a href="/students/student-resources/diversity-resources/">Diversity Resources</a></li>
</ul>
</li>
<li class="page_item page-item-26005 current_page_ancestor current_page_parent"><a href="/students/career-resources/">Career Resources</a>
<ul class='children'>
<li class="page_item page-item-26053 current_page_item"><a href="/students/career-resources/career-opportunities/">Career Opportunities</a>
	<ul class='children'>
<li class="page_item page-item-29490"><a href="/students/career-resources/career-opportunities/for-employers/">For Employers</a></li>
<li class="page_item page-item-29492"><a href="/students/career-resources/career-opportunities/tips-for-jobinternship-seekers/">Tips for Job/Internship Seekers</a></li>
	</ul>
</li>
<li class="page_item page-item-26154"><a href="/students/career-resources/uw-environmental-career-fair/">UW Environmental Career Fair</a></li>
</ul>
</li>
<li class="page_item page-item-26007"><a href="/students/contact/">Contact</a></li>
</ul></li>	          </ul>

				</nav><!-- #secondary-nav.side-col -->

			<?php //endif ?>


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
                	?>

						<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

							<header class="article__header">
						        <div class="article__meta">
						   		<?php if ( !is_page() ) : ?>
									<div class="share align-right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
									data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
									data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="icon-share"></i>Share</a>
						            </div>
									
								<?php endif ?>

								<?php if ( is_page() || is_single() ) : ?>
									<h1 class="article__title">Career Opportunities</h1>
								<?php else : ?>
									<h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
								<?php endif ?>

							</header>

							<section class="article__content">
								<div class="post-info">
									<span class="posted">Posted: <time class="article__time" datetime="<?php get_the_date( '' ); ?>"><?php echo get_the_date('M j, Y'); ?></time></span>
									<span class="deadline">
									<?php if ($expired == 'current') { ?>
					                	Deadline: <time class="article__time" datetime="<?php echo date('Y-m-d h:i:s', $timestamp) ?>"><?php echo date('M j, Y', $timeexpired) ?></time>
					                <?php } elseif ($expired == 'openuntilfilled') { ?>
					                	Deadline: Open Until Filled
					                <?php } else { ?>
					                	Deadline passed (<time class="article__time expired" datetime="<?php echo date('Y-m-d h:i:s', $timestamp) ?>"><?php echo date('M j, Y', $timeexpired) ?></time>)
					                <?php } ?>
					                </span>            	
									<h2><?php the_title() ?></h2>
								</div>
								
								<p class="back"><a class="button" href="/students/career-resources/career-funding-opportunities/">Back to Career Opportunities</a></p>
								<section class="career__content">
								<?php the_content() ?>
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
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>