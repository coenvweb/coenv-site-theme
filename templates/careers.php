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
$coenv_year = urlencode(htmlentities($_GET['coenv-year']));
$coenv_month = urlencode(htmlentities($_GET['coenv-month']));
$coenv_date = $coenv_month . '/' . $coenv_year;

//Categories
$coenv_cat_term_1 = urlencode(htmlentities($_GET['term']));
$coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'career_category');
$coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;

//Tags
$coenv_cat_tag_1 = urlencode(htmlentities($_GET['tag']));
$coenv_cat_tag_1_arr = get_term_by('slug',$coenv_cat_tag_1,'career_post_tag');
$coenv_cat_tag_1_val = $coenv_cat_tag_1_arr->name;


//Search terms
$coenv_search_terms = urlencode(htmlentities($_GET['st']));

//Sort
$coenv_sort = urlencode(htmlentities($_GET['sort']));


// build the query based on $query_args
$query_args = array(

	'post_type' => 'careers',
	'post_status' => 'publish',
	'posts_per_page' => 20,
    'paged' => $paged,
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
?>
	<section id="page" role="main" class="template-page">

		<div class="container">

			<?php if ( in_array( $post->post_type, array('page') ) ) : ?>

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
<li class="page_item page-item-26003"><a href="/students/students-resources/">Student Resources</a>
<ul class='children'>
<li class="page_item page-item-26044"><a href="/students/students-resources/financing-funding/">Funding</a>
	<ul class='children'>
<li class="page_item page-item-26112"><a href="/students/students-resources/financing-funding/scholarships/">Scholarships</a></li>
<li class="page_item page-item-26114"><a href="/students/students-resources/financing-funding/student-meeting-travel-fund/">Student Travel &#038; Meeting Fund</a></li>
	</ul>
</li>
<li class="page_item page-item-26046"><a href="/students/students-resources/student-policies-help/">Student Policies &#038; Help</a></li>
<li class="page_item page-item-26048"><a href="/students/students-resources/get-involved/">Get Involved</a>
	<ul class='children'>
<li class="page_item page-item-26128"><a href="/students/students-resources/get-involved/student-advisory-council/">Student Advisory Council</a></li>
<li class="page_item page-item-26132"><a href="/students/students-resources/get-involved/student-groups/">Student Groups</a></li>
<li class="page_item page-item-26149"><a href="/students/students-resources/get-involved/study-abroad/">Study Abroad</a></li>
	</ul>
</li>
<li class="page_item page-item-26050"><a href="/students/students-resources/diversity-resources/">Diversity Resources</a></li>
</ul>
</li>
<li class="page_item page-item-26005 current_page_ancestor current_page_parent"><a href="/students/career-resources/">Career Resources</a>
<ul class='children'>
<li class="page_item page-item-26053 current_page_item"><a href="/students/career-resources/career-funding-opportunities/">Career Opportunities</a>
	<ul class='children'>
<li class="page_item page-item-29490"><a href="/students/career-resources/career-funding-opportunities/for-employers/">For Employers</a></li>
<li class="page_item page-item-29492"><a href="/students/career-resources/career-funding-opportunities/tips-for-jobinternship-seekers/">Tips for Job/Internship Seekers</a></li>
	</ul>
</li>
<li class="page_item page-item-26154"><a href="/students/career-resources/uw-environmental-career-fair/">UW Environmental Career Fair</a></li>
</ul>
</li>
<li class="page_item page-item-26007"><a href="/students/contact/">Contact</a></li>
</ul></li>	          </ul>

				</nav><!-- #secondary-nav.side-col -->

			<?php //endif ?>

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
									<p class="right"><a class="button" href="/students/career-resources/career-funding-opportunities/">all posts</a></p>
								</div>
							<?php endif; ?>
							<?php if($coenv_cat_tag_1): // Tag filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> posts tagged <strong>"<?php echo $coenv_cat_tag_1_val; ?>"</strong></p>
									<p class="right"><a class="button" href="/students/career-resources/career-funding-opportunities/">all posts</a></p>
								</div>
							<?php endif; ?>
							<?php if($coenv_year && $coenv_month): // Date filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> posts from <strong><?php echo $coenv_date; ?></strong></p>
									<p class="right"><a class="button" href="/students/career-resources/career-funding-opportunities/">all posts</a></p>
								</div>
							<?php endif; ?>
							<?php if($coenv_search_terms): // Date filter ?>
								<div class="panel results-text">
									<p class="left"><?php echo $wp_query->found_posts; ?> posts containing <strong>"<?php echo $coenv_search_terms; ?>"</strong></p>
									<p class="right"><a class="button" href="/students/career-resources/career-funding-opportunities/">all posts</a></p>
								</div>
							<?php endif; ?>
						</div>
					</header>


				<?php if ( $wp_query->have_posts() ) : ?>

					<?php while ( $wp_query->have_posts() ) : $wp_query->the_post() ?>

						<?php get_template_part( 'partials/partial', 'career' ); ?>

					<?php endwhile ?>
				<?php else: ?>
					<div class="no-results">
						<p>Sorry. No career opportunities were found with those criteria. <a href="/students/career-resources/career-funding-opportunities/">Please try your search again</a>.</p>
					</div>
				<?php endif ?>

				<footer class="pagination">
					<?php coenv_paginate() ?>
				</footer>
			</div>

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_template_part( 'partials/partial', 'careers-filter' ) ?>
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>