<?php
/**
 * Intranet - Diversity Equity Inclusion
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);

// Dates
$coenv_year = isset($_GET['coenv-year']) ? $_GET['coenv-year'] : '';
$coenv_month = isset($_GET['coenv-month']) ? $_GET['coenv-month'] : '';
$coenv_year = urlencode(htmlentities($coenv_year));
$coenv_month = urlencode(htmlentities($coenv_month));
$coenv_date = $coenv_month . '/' . $coenv_year;

//Categories
$coenv_cat_term_1 = isset($_GET['term']) ? $_GET['term'] : '';
$coenv_cat_term_1 = urlencode(htmlentities($coenv_cat_term_1));
$coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'topic');
if ($coenv_cat_term_1_arr) {
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    $coenv_cat_term_1_id = $coenv_cat_term_1_arr->term_id;
}

//Tags
$coenv_cat_tag_1 = isset($_GET['tag']) ? $_GET['tag'] : '';
$coenv_cat_tag_1 = urlencode(htmlentities($coenv_cat_tag_1));
$coenv_cat_tag_1_arr = get_term_by('slug',$coenv_cat_tag_1,'post_tag');
if ($coenv_cat_tag_1_arr) {
    $coenv_cat_tag_1_val = $coenv_cat_tag_1_arr->name;
}

//Search terms
$coenv_search_terms = isset($_GET['st']) ? $_GET['st'] : '';
$coenv_search_terms = urlencode(htmlentities($coenv_search_terms));

?>


	<section id="page" role="main" class="template-page intranet-blog">

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

			<main id="main-col" class="main-col">
                
                <?php if (!$coenv_cat_term_1 && !$coenv_year && !$coenv_month && !$coenv_search_terms): ?>
                <article <?php post_class( 'article' ) ?>>
                    <section class="article__content">
                        <div class="intranet-summary">
                            <?php the_content(); ?>
                        </div>
                    </section>
                </article>
                <?php endif ?>
                
                <?php get_template_part( 'partials/partial', 'intranet-filter' ); ?>
                
                <?php
                // build the query based on $query_args
                $query_args = array(

                    'post_type' => array('post', 'intranet'),
                    'post_status' => 'publish',
                    'posts_per_page' => 10,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'topic',
                            'terms' => 'diversity-equity-and-inclusion',
                            'field' => 'slug',
                        ),
                    ),
                    'paged' => $paged,
                    'meta_query' => array(),
                    'order' => 'DSC'
                );


                // Category filter
                if($coenv_cat_term_1) :
                    $query_args['taxonomy'] = 'topic';
                    $query_args['term'] = $coenv_cat_term_1;
                endif;

                // Date filters
                if ($coenv_year) :
                    $query_args['year'] = $coenv_year;
                endif; 
                if($coenv_month) :
                    $query_args['monthnum'] = $coenv_month;
                endif;

                // Search filters
                if ($coenv_search_terms) :
                    $query_args['s'] = $coenv_search_terms;
                endif;

                // Make query
                $wp_query = new WP_Query( $query_args ); 

                ?>
                <div class="blog-header">
                    <?php if ($coenv_cat_term_1): // Category filter ?>
                        <div class="panel results-text">
                            <p class="left"><?php echo $wp_query->found_posts; ?> intranet posts related to <strong>"<?php echo $coenv_cat_term_1_val; ?>"</strong></p>
                            <p class="right"><a class="button" href="/intranet/">all posts</a></p>
                        </div>
                    <?php endif; ?>
                    <?php if($coenv_year && $coenv_month): // Date filter ?>
                        <div class="panel results-text">
                            <p class="left"><?php echo $wp_query->found_posts; ?> intranet posts from <strong><?php echo $coenv_date; ?></strong></p>
                            <p class="right"><a class="button" href="/intranet/">all posts</a></p>
                        </div>
                    <?php endif; ?>
                    <?php if($coenv_search_terms): // Date filter ?>
                        <div class="panel results-text">
                            <p class="left"><?php echo $wp_query->found_posts; ?> intranet posts containing <strong>"<?php echo $coenv_search_terms; ?>"</strong></p>
                            <p class="right"><a class="button" href="/intranet/">all posts</a></p>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="blogtime">

				<?php if ( $wp_query->have_posts() ) : ?>

					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post() ?>
                        
                        
						<?php get_template_part( 'partials/partial', 'intranet-story' ); ?>
                        

					<?php endwhile ?>
				<?php else: ?>
                <article <?php post_class( 'article' ) ?>>
                    <section class="article__content">
                        <div class="no-results">
                            <p>Sorry. No intranet posts were found with those criteria. Please try your search again.</p>
                        </div>
                    </section>
                </article>
                    
				<?php endif ?>
                </div>
            <?php wp_reset_query(); ?>

				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>
                
                <?php wp_reset_query(); ?>

			</main><!-- .main-col -->

			<div class="side-col">
                <?php 
                    get_sidebar('intranet');
                ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>