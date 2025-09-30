<?php
/**
 *
 * The newsletter page template
 */
get_header();

$ancestor_id = 5;

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);

$nl_title = get_the_title();
$nl_type = get_field('newsletter_type');
$feature = get_field('feature_story');
if($nl_type == 'headlines') {
    $nl_posts = get_field('news_items');
} else {
    $nl_posts = get_field('scicomm_news_items');
}


$events = get_field('events');
$links = get_field('outside_news');

?>


	<section id="page" role="main" class="template-newsletter">

		<div class="container">

            <nav id="secondary-nav" class="side-col">

			<ul id="menu-secondary" class="menu">
	              <?php wp_list_pages( array(
	                  'child_of' => $ancestor['id'],
	                  'depth' => 3,
	                  'title_li' => '<a href="' . $ancestor['permalink'] . '">' . $ancestor['title'] . '</a>',
	                  'link_after' => '<i class="icon-arrow-right"></i>',
	                  'walker' => new CoEnv_Secondary_Menu_Walker,
	                  'sort_column' => 'menu_order'
	              ) ) ?>
	          </ul>

            </nav><!-- #secondary-nav.side-col -->

			<main id="main-col" class="main-col">

                <div class="newsletter_header <?=($nl_type == 'headlines' ? 'headlines' : 'scicomm')?>">
                    <?php if($nl_type == 'headlines') { ?>
                        <img class="header_img" alt="Headlines newsletter page title" src="<?= get_template_directory_uri() ?>/assets/img/headlines_header.png" />
                    <?php } else { ?>
                        <img class="header_img" alt="Headlines newsletter page title" src="<?= get_template_directory_uri() ?>/assets/img/scicomm_header.png" />
                    <?php } ?>
                    <h1 class="newsletter_title"><?php echo $nl_title; ?></h1>
                </div>

                <section class="newsletter">

                    <h2 class="section-title">
                        <img class="title-tag" src="<?= get_template_directory_uri() ?>/assets/img/featureStory_tag.png" alt="Feature Story" />
                    </h2>
                    <div class="feature_story">
                        <?php
                            $post = get_post($feature->ID);
                            setup_postdata($post);
                            get_template_part( 'partials/partial', 'newsletter-article' );
                            wp_reset_postdata();
                        ?>
                    </div>
                </section>
                <section class="newsletter">
                    <h2 class="section-title">
                        <?php if($nl_type == 'headlines') { ?>
                            <img class="title-tag" src="<?= get_template_directory_uri() ?>/assets/img/moreNews_tag.png" alt="More News" />
                        <?php } else { ?>
                            <img class="title-tag" src="<?= get_template_directory_uri() ?>/assets/img/comm_tag.png" alt="Communication and Outreach Stories" />
                        <?php } ?>
                    </h2>
                    <section class="news_items">
                        <?php
                            foreach($nl_posts as $nl_post) {
                                if($nl_type == 'headlines') {
                                    $post = get_post($nl_post['news_item']->ID);
                                    setup_postdata($post);
                                    get_template_part( 'partials/partial', 'newsletter-article' );
                                } else {
                                      $image = $nl_post['image'];
                                      $title = $nl_post['title'];
                                      $link = $nl_post['link'];
                                    ?>
                                    <div class="scicomm_news_item">
                                        <header class="article__header">
                                        <?php if ( $image ) {
                                                $image = wp_get_attachment_image($image, '', false, array('class'=>'scicomm_image'));
                                                echo '<a href="'.$link.'">';
                                                    echo $image;
                                                echo '</a>';
                                        } ?>
                                            <h1 class="article__title"><a href="<?php echo $link; ?>" rel="bookmark"><?php echo $title; ?></a></h1>
                                        </header>

                                        <section class="article__content">

                                        </section>
                                    </div>
                                    <?php
                                }
                            }
                            wp_reset_postdata();
                        ?>
                    </section>
                </section>
          <?php if (!empty($events)) { ?>
                <section class="newsletter">
                    <h2 class="section-title">
                        <?php if($nl_type == 'headlines') { ?>
                            <img class="title-tag" src="<?= get_template_directory_uri() ?>/assets/img/events_tag.png" alt="Events" />
                        <?php } else { ?>
                            <img class="title-tag" src="<?= get_template_directory_uri() ?>/assets/img/scicomm_events_tag.png" alt="Events and Opportunities" />
                        <?php } ?>
                    </h2>
                    <div class="events row">
                        <?php foreach($events as $event) { ?>
                            <a class="event-single" href="<?php echo $event['link']; ?>">
                                <div class="event_container small-12 medium-6 columns">
                                    <img src="<?= get_template_directory_uri() ?>/assets/img/calendar_purple.png" alt="Calendar Icon" />
                                    <p class="event_date">
                                        <?php echo $event['start_date']; ?>
                                        <?php
                                        if ($event['end_date']) {
                                            echo " - " . $event['end_date'];
                                        }
                                        ?>
                                    </p>
                                    <p class="event_title">
                                        <?php echo $event['title']; ?>
                                    </p>
                                </div>
                            </a>
                        <?php } ?>
                        <h5 class="more_events"><img class="more_events_icon" src="<?= get_template_directory_uri() ?>/assets/img/calendar_purple.png" alt="Calendar Icon" />   Check out our calendar for <a href="http://environment.uw.edu/alumni-and-community/calendar-events/">more</a> events</h5>
                    </div>
                </section>
          <?php }; ?>
                <section class="newsletter">

                    <h2 class="section-title">
                        <?php if($nl_type == 'headlines') { ?>
                            <img class="title-tag" src="<?= get_template_directory_uri() ?>/assets/img/news_tag.png" alt="News From Around the College" />
                        <?php } else { ?>
                            <img class="title-tag" src="<?= get_template_directory_uri() ?>/assets/img/sci_tag.png" alt="Science of Science Communication" />
                        <?php } ?>
                    </h2>
                    <div class="college">
                        <ul class="around_list">
                        <?php foreach($links as $link) { ?>
                                <li class="around-list-item">
                                    <a href="<?php echo $link['link']; ?>" target="_blank"><?php echo $link['title']; ?>, <span><?php echo $link['source'];?></span></a>
                                </li>
                            </a>
                        <?php } ?>
                        </ul>
                    </div>
                </section>


				<footer class="related">
					<div class="related-news newsletter">
						<div class="related-heading">
							<h2 class="title">Stay Connected</h2>
						</div>
						<div class="related-posts">
							<div class="related-container">
                  <a href="<?=get_site_url()?>/news" title="More news from the College of the Environment" rel="bookmark">
                    <div class="related-article-title">
                                            <h3>
                                                <i class="dashicons-format-aside dashicons"></i>
                                                <span>More news from the <br />College of the Environment</span>
                                            </h3>

                    </div>
                  </a>
							</div>
							<div class="related-container">
                <a href="https://environment.uw.edu/news/college-newsletter/" title="Sign up to receive UW Headlines monthly" rel="bookmark">
                    <div class="related-article-title">
                            <h3>
                                <i class="icon-mail"></i>
                                <span>Sign up to receive <br />UW Headlines monthly</span>
                            </h3>
                    </div>
                </a>
							</div>
							<br style="clear:both">
						</div>
					</div>
				</footer>
			</main><!-- .main-col -->

            <div class="side-col">
                <?php the_widget('CoEnv_Widget_Newsletter', array('title' => 'Headlines Newsletter', 'newsletter_url' => get_site_url() . '/news/college-newsletter/')); ?>
                <?php dynamic_sidebar('News / Sidebar'); ?>
            </div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>

<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function(){
    (function($) {
		var hash = window.location.hash;
		$(hash).find('.read-more a')[0].click();
		$(window).on('hashchange', function() {
			var hash = window.location.hash;
			$(hash).find('.read-more a')[0].click();
		});
    })(jQuery);
});
/* ]]> */
</script>
