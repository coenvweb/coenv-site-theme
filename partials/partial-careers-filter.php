<?php
//list terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)
$taxonomy     = 'career_category';
$orderby      = 'name'; 
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no
$title        = '';
$walker = new CoEnv_Career_Category();

$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'walker' 		 => $walker
);
?>
<div id="careers-filter" class="careers-filter">
	<h3 class="title">Show Results</h3>
	<div class="filters">
	
	<ul>
		<?php wp_list_categories( $args ); ?>
	</ul>
	
	<div data-url="/students/career-opportunities/" data-cat="blog_category" class="select-month">
		<?php coenv_base_date_filter('careers',$coenv_month,$coenv_year); // Date filter ?>
	</div>
	<form role="search" method="get" class="search-form Form--inline" action="/students/career-opportunities/">
	  <div class="field-wrap">
	    <input type="text" name="st" id="st" placeholder="Search" />
	    <button type="submit"><i class="icon-search"></i><span>Search</span></button>
	  </div>
	</form>
</div>
</div><!-- #blog-header -->
