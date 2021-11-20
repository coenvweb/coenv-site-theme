<?php

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Inline related links + shortcode
function coenv_related_news_inline($atts) {

	extract(shortcode_atts(array(
        "cat" => '',
        "title" => 'Related News'
    ), $atts));


    $cat_raw = get_terms('topic');
	$cat_raw = wp_list_pluck( $cat_raw, 'slug' );

	if ($cat != '') {
		$cat = $cat;
		$cat_out = 'topic/' . $cat;
	} else {
		$cat = $cat_raw;
		$cat_out = '';
	}

	$rel_args = array (
		'post_type' => 'post',
		'posts_per_page' => '2',
		'meta_key' => '_thumbnail_id',
		'order' => 'DESC',
		'orderby' => 'date',
		'tax_query' => array(
		'relation' => 'AND',
			array(
			'taxonomy' => 'topic',
			'field' => 'slug',
			'terms' => $cat,
			'operator' => 'IN'
			)
		)
    );
	$rel_query = new WP_Query( $rel_args );
	$rel_title = $title; 
	$rel_out = '<div class="related-news related-news-inline"><div class="related-heading"><div class="related-news-more"><a href="/news/' . $cat_out . '">More &raquo;</a></div><h2 class="title">' . $rel_title . '</h2></div><div class="related-news-blocks">';
	while ( $rel_query->have_posts() ) {
		$rel_query->the_post();
		$rel_out .= '<div class="related-container"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '"><div class="related-thumb">' . get_the_post_thumbnail(get_the_ID(),'thumb') . '</div><div class="related-text-container"><div class="related-article-title"><h3>' . get_the_title() . '</h3></div></div></a></div>';
		//$news_out .= get_the_title();
	}
	$rel_out .= '</div></div>';
	wp_reset_postdata();
	return $rel_out;

}
add_shortcode('related', 'coenv_related_news_inline');

?>