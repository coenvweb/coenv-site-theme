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

// Make query
?>
	<section id="page primary" role="main" class="template-page content-area">

		<div class="container">

			<?php if ( in_array( $post->post_type, array('page') ) ) : ?>

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

			<?php endif ?>

			<main id="main-col content" class="main-col site-content">
				<div class="article">
					<header class="article__header">
						<div class="article__meta">
							<h1 class="article__title">Career Opportunities</h1>
							<div class="career-intro">
							<?php the_content(); ?>
							</div>
                            <div class="sorter-search-row">
                                <form role="search" class="search-form Form--inline" id="career-search">
                                  <div class="field-wrap">
                                    <input type="text" name="st" id="st" placeholder="Search" class="text-search" />
                                    <input type="submit" value="Search" id="submit-search" />
                                  </div>
                                </form>
                                <li class="sorter right">Sort By
                                    <ul>
                                        <li><a class="button <?php echo $post_date_class ?>" href="/students/career-resources/career-opportunities/?sort=post_date">Post date</a></li>
                                        <li><a class="button <?php echo $deadline_class ?>" href="/students/career-resources/career-opportunities/?sort=deadline">Deadline</a></li>
                                    </ul>
                                </li>
                            </div>

<div id="career-results">
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

			</div>

			</main><!-- .main-col -->

			<div class="side-col">
                <?php include(locate_template( 'partials/partial-careers-filter.php' )) ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>