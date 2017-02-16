<?php
/*
Template Name: Careers & Funding Blog
*/
/**
 * page.php
 *
 * The main page template
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);

?>
	<section id="page primary" role="main" class="template-page content-area">

		<div class="container">

			<?php if ( in_array( $post->post_type, array('page') ) ) : ?>

				<nav id="secondary-nav" class="side-col">

			<ul id="menu-secondary" class="menu">
                <li class="pagenav">
	              <?php echo '<a href="' . $ancestor['permalink'] . '"><span>Back to</span>' . $ancestor['title'] . '</a>'; ?>
                    <ul class="career-actions">
                    <li><a href="/for-employers/"><span class="dashicons dashicons-welcome-add-page"></span> Post an Opportunity</a></li>
                    <li><a href="/tips-for-jobinternship-seekers/"><span class="dashicons dashicons-star-filled"></span> Tips for Seekers</a></li>
                    <li><a href="../uw-environmental-career-fair/"><span class="dashicons dashicons-businessman"></span> UW Environmental Career Fair</a></li>
                </ul>
                </li>
	          </ul>

				</nav><!-- #secondary-nav.side-col -->

			<?php endif ?>

			<main id="main-col content" class="main-col site-content">
				<div class="article">
					<header class="article__header">
						<div class="article__meta">
							<h1 class="article__title">Career Opportunities</h1>
							<div class="career-intro article__content">
							<?php the_content(); ?>
                           
							</div>
                        </div>
                    </header>
                </div>
            </main><!-- .main-col -->
            		</div><!-- .container -->
        <div class="container career-container">
            <div class="career-col main-col article">
                <div class="sorter-search-row">
                    <form role="search" class="search-form Form--inline" id="post-search">
                        Search
                      <div class="field-wrap">
                        <input type="text" name="st" id="st" placeholder="e.g. Faculty, Bellevue, Wildlife, etc." class="text-search" />
                        <button id="submit-search" type="submit"><i class="icon-search"></i><span>Search</span></button>
                      </div>
                    </form>
                    <li class="sorter right">Sort By
                        <ul>
                            <li class="button selected" data-value="postdate" aria-pressed="true">Post date</a></li>
                            <li class="button"  data-value="deadline" aria-pressed="false">Deadline</li>
                        </ul>
                    </li>
                    <li class="subscribe">Subscribe
                    <ul>
                        <a class="button" href="/students/career-resources/career-opportunities/subscribe-via-email/"><i class="icon-mail"></i></a>
                        <a class="button" href="/feed/?post_type=careers"><i class="icon-rss"></i></a>
                    </ul></li>
                </div>
                 
                <div id="results" data-action="careers_filter" aria-live="polite">
                    <?php
                    if( have_posts() ):
                        while( have_posts() ): the_post(); ?>
                            <?php get_template_part( 'partials/partial', 'career' ); ?>
                        <?php endwhile ?>
                    <?php else: ?>
                        <div class="no-results">
                            <p>Sorry. No career opportunities were found with those criteria. <a href="/students/career-resources/career-opportunities/">Please try your search again</a>.</p>
                        </div>
                    <?php endif ?>
                </div>
                
                <footer class="pagination">
                    <?php coenv_paginate() ?>
                </footer>

                
            </div><!-- .career-col -->
            <div class="side-col">
                <?php include(locate_template( 'partials/partial-careers-filter.php' )) ?>
            </div><!-- .side-col -->
        </div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>