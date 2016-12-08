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
  'walker' 		 => $walker,
  'hide_empty'   => 0,
);

?>
<a name="filters" id="filters"></a>
<div id="careers-filter" class="careers-filter" aria-controls="results" aria-multiselectable="true">
	<h3 class="title">Filter</h3>
	<div class="filters">
	<ul>
	<ul class="ajax-filters" id="career-filter">
		<?php wp_list_categories($args); ?>
	</ul>
</div>
</div><!-- #blog-header -->
