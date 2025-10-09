<?php
/*
Template Name: Academic Opportunities Board
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
	<section id="page" role="main" class="template-page content-area">

		<div class="container">

        <?php if ( in_array( $post->post_type, array('page') ) ) : ?>

<nav id="secondary-nav" class="side-col">

<ul id="menu-secondary" class="menu">
  <?php
  $list_args = array(
      'child_of' => $ancestor['id'],
      'depth' => 3,
      'title_li' => '<a href="' . $ancestor['permalink'] . '">' . $ancestor['title'] . '</a>',
      'link_after' => '<i class="icon-arrow-right"></i>',
      'walker' => new CoEnv_Secondary_Menu_Walker,
      'sort_column' => 'menu_order' 
  );
  wp_list_pages($list_args);
  ?>
</ul>
<div>&nbsp;</div>
<?php include(locate_template( 'partials/partial-careers-filter.php' )) ?>
</nav><!-- #secondary-nav.side-col -->

<?php endif ?>

			<main id="main-col content" class="main-col site-content">
				<div class="article">
					<header class="article__header">
						<div class="article__meta">
							<h1 class="article__title"><?php the_title()?></h1>
							<div class="career-intro article__content">
							<?php the_content(); ?>
            
                <div class="sorter-search-row">
                    <form role="search" class="search-form Form--inline" id="post-search">
                        <label for="st">Search</label>
                      <div class="field-wrap">
                        <input type="text" name="st" id="st" placeholder="e.g. Faculty, Bellevue, Wildlife, etc." class="text-search" />
                        <button id="submit-search" type="submit"><i class="icon-search"></i><span>Search</span></button>
                      </div>
                    </form>
                    <div class="sorter right">Sort By
                        <ul>
                            <li class="button selected" role="button" data-value="postdate" aria-pressed="true">Post date</li>
                            <li class="button" role="button" data-value="deadline" aria-pressed="false">Deadline</li>
                        </ul>
                    </div>
                    <div class="mobile-filter">Filter By
                      <ul>
                          <a class="filter-anchor" href="#filters"><li class="button"><span class="plus">+</span> Add Filter</li></a>
                          <a class="filter-clear" href=""><li class="button"><i class="icon-cross"></i> Clear Filters</li></a>
                      </ul>
                    </div>
                </div>
                 
                <div id="results" data-action="careers_filter" aria-live="polite">
                    <?php
                    if( have_posts() ):
                        while( have_posts() ): the_post(); ?>
                            <?php get_template_part( 'partials/partial', 'career' ); ?>
                        <?php endwhile ?>
                    <?php else: ?>
                        <div class="no-results">
                            <p>Sorry. No opportunities were found with those criteria. <a href="/students/career-resources/career-opportunities/">Please try your search again</a>.</p>
                        </div>
                    <?php endif ?>
                </div>
                
                <footer class="pagination">
                    <?php coenv_paginate() ?>
                </footer>

                
            </div><!-- .career-col -->
            <!--<div class="side-col">
                <?php //include(locate_template( 'partials/partial-careers-filter.php' )) ?>
            </div><!-- .side-col -->
                           
							</div>
                        </div>
                    </header>
                </div>
            </main><!-- .main-col -->
            		</div><!-- .container -->
        

	</section><!-- #page -->

<?php get_footer() ?>