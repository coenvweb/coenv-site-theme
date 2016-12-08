<?php



// do not use on live/production servers
add_action( 'init','maybe_rewrite_rules' );
function maybe_rewrite_rules() {

    $ver = filemtime( __FILE__ ); // Get the file time for this file as the version number
    $defaults = array( 'version' => 0, 'time' => time() );
    $r = wp_parse_args( get_option( __CLASS__ . '_flush', array() ), $defaults );

    if ( $r['version'] != $ver || $r['time'] + 172800 < time() ) { // Flush if ver changes or if 48hrs has passed.
        flush_rewrite_rules();
        // trace( 'flushed' );
        $args = array( 'version' => $ver, 'time' => time() );
        if ( ! update_option( __CLASS__ . '_flush', $args ) )
            add_option( __CLASS__ . '_flush', $args );
    }

}



// add to our plugin init function
global $wp_rewrite;
$careers_structure = '/students/careers/%year%/%monthnum%/%careers%';
$wp_rewrite->add_rewrite_tag("%careers%", '([^/]+)', "careers=");
$wp_rewrite->add_permastruct('careers', $careers_structure, false);

// Add filter to plugin init function
add_filter('post_type_link', 'careers_permalink', 10, 3);   
// Adapted from get_permalink function in wp-includes/link-template.php
function careers_permalink($permalink, $post_id, $leavename) {
    $post = get_post($post_id);
    $rewritecode = array(
        '%year%',
        '%monthnum%',
        '%day%',
        '%hour%',
        '%minute%',
        '%second%',
        $leavename? '' : '%postname%',
        '%post_id%',
        '%category%',
        '%author%',
        $leavename? '' : '%pagename%',
    );
 
    if ( '' != $permalink && !in_array($post->post_status, array('draft', 'pending', 'auto-draft')) ) {
        $unixtime = strtotime($post->post_date);
     
        $category = '';
        if ( strpos($permalink, '%category%') !== false ) {
            $cats = get_the_category($post->ID);
            if ( $cats ) {
                usort($cats, '_usort_terms_by_ID'); // order by ID
                $category = $cats[0]->slug;
                if ( $parent = $cats[0]->parent )
                    $category = get_category_parents($parent, false, '/', true) . $category;
            }
            // show default category in permalinks, without
            // having to assign it explicitly
            if ( empty($category) ) {
                $default_category = get_category( get_option( 'default_category' ) );
                $category = is_wp_error( $default_category ) ? '' : $default_category->slug;
            }
        }
     
        $author = '';
        if ( strpos($permalink, '%author%') !== false ) {
            $authordata = get_userdata($post->post_author);
            $author = $authordata->user_nicename;
        }
     
        $date = explode(" ",date('Y m d H i s', $unixtime));
        $rewritereplace =
        array(
            $date[0],
            $date[1],
            $date[2],
            $date[3],
            $date[4],
            $date[5],
            $post->post_name,
            $post->ID,
            $category,
            $author,
            $post->post_name,
        );
        $permalink = str_replace($rewritecode, $rewritereplace, $permalink);
    } else { // if they're not using the fancy permalink option
    }
    return $permalink;
}

add_action( 'pre_get_posts', 'my_slice_orderby' );
function my_slice_orderby( $query ) {
    if( ! is_admin() )
        return;
 
    $orderby = $query->get( 'orderby');
 
    if( 'expirationdate' == $orderby ) {
        $query->set('meta_key','_expiration-date');
        $query->set('orderby','meta_value_num');
    }
}

function mbe_change_sortable_columns($columns){
    $columns['expirationdate'] = 'expirationdate';
    return $columns;
}
add_filter('manage_edit-careers_sortable_columns', 'mbe_change_sortable_columns');


//Add Ajax Actions
add_action('wp_ajax_careers_filter', 'careers_filter');
add_action('wp_ajax_nopriv_careers_filter', 'careers_filter');

//Construct Loop & Results
function careers_filter()
{
	$query_data = $_GET;
	
	$career_terms = ($query_data['terms']) ? explode(',',$query_data['terms']) : false;
	
	$tax_query = ($career_terms) ? array( array(
		'taxonomy' => 'career_category',
		'field' => 'id',
		'terms' => $career_terms,
        'operator' => 'AND'
	) ) : false;
	
	$search_value = ($query_data['search']) ? $query_data['search'] : false;
	
	$paged = (isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;
    
    $coenv_sort = ($query_data['sorter']) ? $query_data['sorter'] : false;
    
    
    // build the query based on $query_args
    $career_args = array(

        'post_type' => 'careers',
        'post_status' => 'publish',
        'posts_per_page' => 5,
        's' => $search_value,
        'tax_query' => $tax_query,
        'paged' => $paged,
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
    
        //Sort/*
	if ($coenv_sort == 'deadline') {
		$career_args['meta_key'] = '_expiration-date';
		$career_args['orderby'] = 'meta_value';
		$career_args['order'] = 'ASC';
	} else {
		$career_args['orderby'] = 'date';
		$career_args['order'] = 'DESC';
	}

	$career_loop = new WP_Query($career_args);
		
    if ( ($career_terms || $search_value) && ($paged == 1)) {
        echo '<div class="filter-crumbs">';
        echo '<h3>' . $career_loop->found_posts . ' careers tagged:</h3>';
        foreach ( $career_terms as $term ) {
            $term = get_term($term);
            $career_filter_links .= '<li class="button selected term_id_' . $term->term_id . '" name="filter_career[]" value="' . $term->term_id . '"><i class="icon-cross"></i> ' . $term->name . '</li>';
        }
        echo $career_filter_links;
        if ($search_value) {
        echo '<li class="button selected search-filter" name="filter_career[]"><i class="icon-cross"></i> Results containing "' . $search_value . '"</li>';
        }
        echo '</div>';
    }
	
	if( $career_loop->have_posts() ):
        echo '<span id="counter" data-page-count="' . $career_loop->max_num_pages . '"></span>';
		while( $career_loop->have_posts() ): $career_loop->the_post();
			get_template_part( 'partials/partial', 'career' );
		endwhile;		
	endif;
	wp_reset_postdata();
	
	die();
}
