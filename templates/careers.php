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

// Dates
$coenv_year = isset($_GET['coenv-year']) ? $_GET['coenv-year'] : '';
$coenv_month = isset($_GET['coenv-month']) ? $_GET['coenv-month'] : '';
$coenv_year = urlencode(htmlentities($coenv_year));
$coenv_month = urlencode(htmlentities($coenv_month));
$coenv_date = $coenv_month . '/' . $coenv_year;

//Categories
$coenv_cat_term_1 = isset($_GET['term']) ? $_GET['term'] : '';
$coenv_cat_term_1 = urlencode(htmlentities($coenv_cat_term_1));
$coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'career_category');
if ($coenv_cat_term_1_arr) {
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
}

//Tags
$coenv_cat_tag_1 = isset($_GET['tag']) ? $_GET['tag'] : '';
$coenv_cat_tag_1 = urlencode(htmlentities($coenv_cat_tag_1));
$coenv_cat_tag_1_arr = get_term_by('slug',$coenv_cat_tag_1,'career_post_tag');
if ($coenv_cat_tag_1_arr) {
    $coenv_cat_tag_1_val = $coenv_cat_tag_1_arr->name;
}

//Search terms
$coenv_search_terms = isset($_GET['st']) ? $_GET['st'] : '';
$coenv_search_terms = urlencode(htmlentities($coenv_search_terms));

//Sort
$coenv_sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$coenv_sort = urlencode(htmlentities($coenv_sort));


// build the query based on $query_args
$query_args = array(

	'post_type' => 'careers',
	'post_status' => 'publish',
	'posts_per_page' => 20,
    'paged' => $paged,
    'category__not_in' => array( 1972 ),
    'tax_query' => array(
        array(
            'taxonomy' => 'career_category',
            'terms' => array('announcement'),
            'field' => 'slug',
            'operator' => 'NOT IN',
        ),
    ),
    'meta_query' => array(
    	'relation'    => 'OR',
        array(
            'key' => 'deadline',
            'value' => date('Ymd'),
    		'type' => 'date',
    		'compare' => '>='
        ),
        array(
            'key' => '_expiration-date',
            'value' => time(),
            'type' => 'char',
            'compare' => '>='
        ),
    )
);

$announcement_query_args = array(
	'post_type' => 'careers',
	'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'career_category',
            'terms' => array('announcement'),
            'field' => 'slug',
            'operator' => 'IN',
        ),
    ),
);

// Category filter
if($coenv_cat_term_1) :
	$query_args['taxonomy'] = 'career_category';
	$query_args['term'] = $coenv_cat_term_1;
endif;

// Tag filter
if($coenv_cat_tag_1) :
	$query_args['taxonomy'] = 'career_post_tag';
	$query_args['term'] = $coenv_cat_tag_1 ;
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

if (empty($coenv_cat_term_1) && empty($coenv_cat_tag_1) && empty($coenv_year) && empty($coenv_month) && empty($coenv_search_terms) && $paged == 0) {
    $first_page = true;
}

//Sort/*
	if ($coenv_sort == 'deadline') {
		$query_args['meta_key'] = '_expiration-date';
		$query_args['orderby'] = 'meta_value';
		$query_args['order'] = 'ASC';
	} else {
		$query_args['orderby'] = 'date';
		$query_args['order'] = 'DESC';
	}
// Make query
$wp_query = new WP_Query( $query_args ); 
$wp_announcement_query = new WP_Query( $announcement_query_args ); 
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
				<div class="article">
					<header class="article__header">
						<div class="article__meta">
							<h1 class="article__title">Career Opportunities</h1>
							<div class="career-intro">
							<?php the_content(); ?>
							</div>
							<?php if ($coenv_cat_term_1): // Category filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> opportunities found in <strong>"<?php echo $coenv_cat_term_1_val; ?>"</strong></p>
									<p class="right"><a class="button" href="/students/career-resources/career-opportunities/">all posts</a></p>
								</div>
							<?php endif; ?>
							<?php if($coenv_cat_tag_1): // Tag filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> posts tagged <strong>"<?php echo $coenv_cat_tag_1_val; ?>"</strong></p>
									<p class="right"><a class="button" href="/students/career-resources/career-opportunities/">all posts</a></p>
								</div>
							<?php endif; ?>
							<?php if($coenv_year && $coenv_month): // Date filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> posts from <strong><?php echo $coenv_date; ?></strong></p>
									<p class="right"><a class="button" href="/students/career-resources/career-opportunities/">all posts</a></p>
								</div>
							<?php endif; ?>
							<?php if($coenv_search_terms): // Date filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> posts containing <strong>"<?php echo $coenv_search_terms; ?>"</strong></p>
									<p class="right"><a class="button" href="/students/career-resources/career-opportunities/">all posts</a></p>
								</div>
							<?php endif; ?>
						</div>
					</header>
                    
                <?php if ( ($wp_announcement_query->have_posts()) && $first_page == true ) : ?>
                    <div class="featured-career">
					<?php while ( $wp_announcement_query->have_posts() ) : $wp_announcement_query->the_post() ?>

						<article id="post-<?php the_ID() ?>" <?php post_class( 'career' ) ?>>

                        <header class="article__header">
                            <div class="article__meta">
                                <div class="post-info">
                                    Announcement | Posted: 
                                    <time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time>         	
                                </div>
                            </div>

                            <?php
                            $location = get_field('location');
                            ?>

                            <?php if ( is_single() ) : ?>
                                <h1 class="article__title"><?php the_title(); ?></h1>
                                <h3 class="location"><?php echo $location; ?></h3>
                            <?php else : ?>
                                <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                <h3 class="location"><?php echo $location; ?></h3>
                            <br />
                            <?php endif; ?>
                            <?php the_content(); ?>
                            <?php if (current_user_can( 'edit_career', get_the_ID() ) ) { echo '<a class="button" href="/wordpress/wp-admin/post.php?post='. get_the_ID() . '&action=edit">Edit this announcement post</a>'; } ?>
                        </header>

                        <?php remove_filter( 'the_title', 'wptexturize' );
                        remove_filter( 'the_excerpt', 'wptexturize' ); ?>

                    </article><!-- .article -->


					<?php endwhile ?>
                    </div>
				<?php endif; ?>


				<?php if ( $wp_query->have_posts() ) : ?>

					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post() ?>

						<?php get_template_part( 'partials/partial', 'career' ); ?>

					<?php endwhile ?>
				<?php else: ?>
					<div class="no-results">
						<p>Sorry. No career opportunities were found with those criteria. <a href="/students/career-resources/career-opportunities/">Please try your search again</a>.</p>
					</div>
				<?php endif ?>

				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>
			</div>

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_template_part( 'partials/partial', 'careers-filter' ) ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>