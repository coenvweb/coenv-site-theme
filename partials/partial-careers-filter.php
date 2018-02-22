<?php

$exclude_slugs      = array( 'announcement', 'under-1-year', '1-2-years', '2-5-years', 'more-than-5-years', 'northwest-region-id-or-or', 'wa', 'seasonal', 'contract', 'permanent', 'organization-type', 'academia', 'tribal', 'gov', 'nonprofit', 'private-sector', 'careers', 'volunteer', 'uw-student-campus-jobs', 'uw-positions', 'us', 'field', 'compensation');           
$exclude_ids        = array();

foreach( $exclude_slugs as $slug ) { 
    $tmp_term = get_term_by( 'slug', $slug, 'career_category' );

    if( is_object( $tmp_term ) ) {
        $exclude_ids[] = $tmp_term->term_id;
    }
}

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
  'exclude'      => $exclude_ids,
);

?>
<a name="filters" id="filters"></a>
<div id="careers-filter" class="careers-filter" aria-controls="results" aria-multiselectable="true">
	<h3 class="title">Filter</h3>
	<div class="filters">
	<ul class="ajax-filters" id="career-filter">
		<?php wp_list_categories($args); ?>
	</ul>
</div>
</div><!-- #blog-header -->
