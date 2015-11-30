<?php
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

//Sort
$coenv_sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$coenv_sort = urlencode(htmlentities($coenv_sort));

?>


	<section id="page" role="main" class="template-page">

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
                <article>
                    <div id="blog-header" class="blog-header">
                        <form role="search" method="get" class="search-form Form--inline" action="<?php echo home_url( '/intranet' ); ?>">
                            <div class="field-wrap">
                                <input type="hidden" name="post_type" value="post" />
                                <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Search news" />
                                <button type="submit"><i class="icon-search"></i><span>Search</span></button>
                            </div>
                        </form>
                    <div class="input-item select-category" data-url="<?php echo get_bloginfo('url'); ?>">
                        <?php
                            $cats = get_categories(array(
                                'type' => array('post', 'intranet'),
                                'taxonomy' => array('topic')
                            ));
                                $output = '<select name="category-dropdown">';
                                $output .= '<option value="/intranet/">Choose a topic</option>';
                                if ( !empty( $cats ) ) {	
                                foreach ( $cats as $cat ) {
                                    if (term_is_ancestor_of(1232, $cat->term_id, 'topic')){
                                    $selected = $coenv_cat_term_id == $cat->term_id ? ' selected="selected"' : '';
                                    $output .= '<option value="/intranet/?term=' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					                    }
                                }
                                }	
                                $output .= '</select>';
                                echo $output;
                        ?>
                    </div>
                    <div class="input-item select-month">
			<?php coenv_base_date_filter('intranet',$coenv_month,$coenv_year); // Date filter ?>
                    </div>
                    <?php if (is_tax() || is_date()) { ?>
                        <div class="results-text">
                            <?php $coenv_post_count = $GLOBALS['wp_query']->found_posts;  ?>
                            <?php if ($queried_object->taxonomy == 'topic') { ?>
                                <p><?php echo $coenv_post_count; ?> news posts related to <span class="term-name"> <?php echo single_cat_title( '', true ); ?> </span></p>
                                <p class="all-news"><a href="/news/" class="button">Return to News</a></p>
                            <?php } elseif ($queried_object->taxonomy == 'story_type') { ?>
                                <p><?php echo $coenv_post_count; ?> posts of type: <span class="term-name"> <?php echo single_cat_title( '', true ); ?> </span></p>
                                <p class="all-news"><a href="/news/" class="button">Return to News</a></p>
                            <?php } elseif (is_date()) { ?>
                                <p><?php echo $coenv_post_count; ?> news posts from <span class="term-name"><?php echo single_month_title(' '); ?></span></p>
                                <p class="all-news"><a href="/news/" class="button">Return to News</a></p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div><!-- #blog-header -->
                </article>
                <?php
                // build the query based on $query_args
                $query_args = array(

                    'post_type' => array('post', 'intranet'),
                    'post_status' => 'publish',
                    'posts_per_page' => 20,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'topic',
                            'terms' => 1232
                        )
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

                
                <article <?php post_class( 'article' ) ?>>
                    <section class="article__content">
                        <div class="intranet-summary">
                            <?php the_content(); ?>
                        </div>
                    </section>
                </article>
							<?php if ($coenv_cat_term_1): // Category filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> news posts related to <strong>"<?php echo $coenv_cat_term_1_val; ?>"</strong></p>
									<p class="right"><a class="button" href="/intranet/">all posts</a></p>
								</div>
							<?php endif; ?>
							<?php if($coenv_year && $coenv_month): // Date filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> posts from <strong><?php echo $coenv_date; ?></strong></p>
									<p class="right"><a class="button" href="/intranet/">all posts</a></p>
								</div>
							<?php endif; ?>
							<?php if($coenv_search_terms): // Date filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> posts containing <strong>"<?php echo $coenv_search_terms; ?>"</strong></p>
									<p class="right"><a class="button" href="/intranet/">all posts</a></p>
								</div>
							<?php endif; ?>

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

				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>

			</main><!-- .main-col -->

			<div class="side-col">
                <?php 
                    get_sidebar('intranet');
                ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>