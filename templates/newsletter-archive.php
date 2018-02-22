<?php
/**
 Template Name: Newsletter Archive Page
 * newsletter-archive.php
 *
 * Template page used for the newsletter archive 
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);

$banner = coenv_banner();

$current = new DateTime();
if($current->format('m') < 9) {
    $lowerBound = new DateTime('-2 year');
} else {
    $lowerBound = new DateTime('-1 year');
}
$lowerBoundStartYear = $lowerBound->format('Y');
$lowerBoundEndYear = $lowerBoundStartYear + 1;
$upperBoundEndYear = $lowerBoundEndYear + 1;

$lowerBoundStart = '09/02/' . $lowerBoundStartYear;
$lowerBoundEnd = '09/01/' . $lowerBoundEndYear;
$upperBoundEnd = '09/01/' . $upperBoundEndYear;
//I messed around here to get the dates working correctly. - Drew 9/1/17

$lowerArgs = array(
    'post_type' => 'newsletter',
    'meta_key' => 'newsletter_type',
    'meta_value' => 'headlines',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1,
    'date_query' => array(
        'after' => $lowerBoundStart,
        'before' => $lowerBoundEnd
    ),
);
$lowerQuery = new WP_Query($lowerArgs);

$upperArgs = array(
    'post_type' => 'newsletter',
    'meta_key' => 'newsletter_type',
    'meta_value' => 'headlines',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1,
    'date_query' => array(
        'after' => $lowerBoundEnd,
        'before' => $upperBoundEnd
    ),
);
$upperQuery = new WP_Query($upperArgs);
?>

	<section id="blog" role="main" class="template-blog template-newsletter-archive">

		<div class="container">

			<nav id="secondary-nav" class="side-col">

					<ul id="menu-secondary" class="menu">
						<li class="pagenav">
							<a href="<?php echo home_url("/news"); ?>">News</a>
						</li>
          </ul>

			</nav><!-- #secondary-nav.side-col -->

			<main id="main-col" class="main-col">
				<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>> 

					<header class="article__header">
							<h1 class="article__title"><?php the_title() ?></h1>
					</header>

					<section class="article__content">

						<?php the_content() ?>


							<?php if($upperQuery->have_posts()) { ?>
							    <h2>Recent Headlines Newsletters</h2>
							<?php } ?>

						    <?php if($upperQuery->have_posts()) { ?>
								<h3><?=$lowerBoundEndYear?>-<?=substr($upperBoundEndYear, -2)?> Academic Year</h3>
                                <ul>
                                    <?php while ($upperQuery->have_posts()) : $upperQuery->the_post(); ?>
                                        <?php
                                            $nl_link = get_the_permalink();
                                            $nl_title = get_the_title();
                                        ?>
                                        <li><a href="<?=$nl_link?>"><?=$nl_title?></a></li>
                                    <?php endwhile; ?>
                                </ul>
							<?php } ?>

                            <?php if($lowerQuery->have_posts()) { ?>
								<h3><?=$lowerBoundStartYear?>-<?=substr($lowerBoundEndYear, -2)?> Academic Year</h3>
                                <ul>
                                    <?php while ($lowerQuery->have_posts()) : $lowerQuery->the_post(); ?>
                                        <?php
                                            $nl_link = get_the_permalink();
                                            $nl_title = get_the_title();
                                        ?>
                                        <li><a href="<?=$nl_link?>"><?=$nl_title?></a></li>
                                    <?php endwhile; ?>
                                </ul>
							<?php } ?>	
                            <p><a href="/intranet/marketing-communications/college-newsletter-archive/" target="_blank"><span class="button">Full Archive</span></a></p>
					</section>
				</article>
			</main><!-- .main-col -->

			<div class="side-col">
                <div class="active">
                    <?php the_widget('CoEnv_Widget_Newsletter', array('title' => 'Headlines Newsletter', 'newsletter_url' => 'https://environment.uw.edu/news/college-newsletter/')); ?>
                </div>
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>
