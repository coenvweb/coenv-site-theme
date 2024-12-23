<?php

/**
 * Register careers & funding
 */

add_action( 'init', 'coenv_register_careers' );

function coenv_register_careers() {

	$labels = array(
		
		'name' => __( 'Academic Opportunities' ),
		'singular_name' => __( 'Opportunity' ),
		'add_new' => __( 'Add New Opportunity' ),
		'edit_item' => __( 'Edit Opportunity' ),
		'add_new_item' => __( 'New Opportunity' ),
		'view_item' => __( 'View Opportunities' ),
		'search_items' => __( 'Search Opportunities' ),
		'not_found' => __( 'No Opportunities found' ),
		'not_found_in_trash' => __( 'No Opportunities found in Trash' )

	);

	$args = array(

		'labels' => $labels,
		'menu_position' => null,
		'supports' => array( 'editor','revisions', 'title' ),
        'taxonomies' => array( 'career_category' ),
		'public' => true,
		'has_archive' => false,
		'hierarchical' => false,
		'rewrite' => false,
		'menu_icon' => 'dashicons-businessman',
		'exclude_from_search' => false,
        'map_meta_cap' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'opportunities', 'with_front' => false),
        'capability_type' => 'post',
			'capabilities' => array(
				'publish_posts' => 'publish_careers',
				'delete_others_posts' => 'delete_others_careers',
				'delete_post' => 'delete_career',
				'delete_posts' => 'delete_careers',
				'delete_private_posts' => 'delete_private_careers',
				'delete_published_posts' => 'delete_published_careers',
				'edit_others_posts' => 'edit_others_careers',
				'edit_post' => 'edit_career',
				'edit_posts' => 'edit_careers',
				'edit_private_posts' => 'edit_private_careers',
				'edit_published_posts' => 'edit_published_careers',
				'read_post' => 'read_career',
				'read_private_posts' => 'read_private_careers',
			),

	);
	register_post_type( 'careers', $args );

}

/**
* Custom Taxonomies for Career Posts
**/

function career_tax() {

	$career_labels = array(

		'name'                       => _x( 'Opportunity Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Opportunity Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Opportunity Categories', 'text_domain' ),
		'all_items'                  => __( 'All Opportunity Categories', 'text_domain' ),
		'parent_item'                => __( 'Parent Opportunity Category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Opportunity Category:', 'text_domain' ),
		'new_item_name'              => __( 'New Opportunity Category', 'text_domain' ),
		'add_new_item'               => __( 'Add Opportunity Category', 'text_domain' ),
		'edit_item'                  => __( 'Edit Opportunity Category', 'text_domain' ),
		'update_item'                => __( 'Update Opportunity Category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate opportunity categories with commas', 'text_domain' ),
		'search_items'               => __( 'Search opportunity categories', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove opportunity categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited opportunity categories', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),

	);
	$career_args = array(

		'labels'                     => $career_labels,
		'hierarchical'               => true,
        'with_front'                 => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'capabilities' => array(
			'assign_terms' => 'assign_career_terms',
	        'edit_terms' => 'edit_career_terms',
			'manage_terms' => 'manage_career_terms',
			'delete_terms' => 'delete_career_terms',
		),

	);

	register_taxonomy( 'career_category', array( 'careers' ), $career_args );
}

add_action( 'init', 'career_tax' );

/**
 * Add a role for Careers editors
 */
function coenv_add_careers_role() {

	remove_role( 'careers_editor' );

 	add_role('careers_editor',
            'Academic Opportunities Editor',
            array(
                'read' => true,
                'edit_posts' => false,
                'delete_posts' => false,
                'publish_posts' => false,
                'upload_files' => true,
            )
        );
   }

register_activation_hook( __FILE__, 'coenv_add_careers_role' );

add_action('admin_init','coenv_add_role_caps',999);

/**
 * Add role permissions for Careers editors
 */
function coenv_add_role_caps() {

// Add the roles you'd like to administer the custom post types
	$roles = array('careers_editor', 'administrator');

// Loop through each role and assign capabilities
	foreach($roles as $the_role) { 

	    $role = get_role($the_role);

		$role->add_cap( 'publish_careers' );
		$role->add_cap( 'delete_others_careers' );
		$role->add_cap( 'delete_career' );
		$role->add_cap( 'delete_careers' );
		$role->add_cap( 'delete_private_careers' );
		$role->add_cap( 'delete_published_careers' );
		$role->add_cap( 'edit_others_careers' );
		$role->add_cap( 'edit_career' );
		$role->add_cap( 'edit_careers' );
		$role->add_cap( 'edit_private_careers' );
		$role->add_cap( 'edit_published_careers' );
		$role->add_cap( 'read_career' );
		$role->add_cap( 'read_private_careers' );
		$role->add_cap( 'assign_career_terms' );
	    $role->add_cap( 'edit_career_terms' );
		$role->add_cap( 'manage_career_terms' );
		$role->add_cap( 'delete_career_terms' );

	}
}


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

function custom_columns($columns)
{
    return array_merge(
        $columns,
        array(
            'location' => __('Location'),
        )
    );
}
add_filter('manage_careers_posts_columns', 'custom_columns');

function display_custom_columns($column, $post_id)
{
    switch ($column) {
        case 'location':
            echo get_post_meta($post_id, 'location', true);
            break;
    }
}
add_action('manage_careers_posts_custom_column', 'display_custom_columns', 10, 2);



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
	
	$tax_query = ($career_terms) ? array(
		'taxonomy' => 'career_category',
		'field' => 'id',
		'terms' => $career_terms,
        'operator' => 'AND'
	) : false;
    
    $tax_query = 
    array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'career_category',
            'terms' => array('announcement'),
            'field' => 'slug',
            'operator' => 'NOT IN',
        ),
        $tax_query,
    );
        
        
    
	
	$search_value = ($query_data['search']) ? $query_data['search'] : false;
	
	$paged = (isset($query_data['paged']) ) ? intval($query_data['paged']) : 1;
    
    $coenv_sort = ($query_data['sorter']) ? $query_data['sorter'] : false;
    
    
    // build the query based on $query_args
    $career_args = array(

        'post_type' => 'careers',
        'post_status' => 'publish',
        'posts_per_page' => 20,
        's' => $search_value,
        'tax_query' => $tax_query,
        'paged' => $paged,
        'meta_query' => array(
            'relation'    => 'OR',
            array(
                'key' => 'deadline',
                'compare' => 'NOT EXISTS',
                'value' => ''
            ),
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
            array(
                'key' => 'location',
                'value' => $search_value,
                'compare' => 'LIKE'
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
        echo '<h3>' . $career_loop->found_posts . ' opportunities tagged:</h3>';
        foreach ( $career_terms as $term ) {
            $term = get_term($term);
            $career_filter_links .= '<li class="button term-filter selected term_id_' . $term->term_id . '" name="filter_career[]" value="' . $term->term_id . '"><i class="icon-cross"></i> ' . $term->name . '</li>';
        }
        echo $career_filter_links;
        if ($search_value) {
        echo '<li class="button selected search-crumb" name="filter_career[]" data-last-search="' . $search_value . '"><i class="icon-cross"></i> Results containing "' . $search_value . '"</li>';
        }
        echo '</div>';
    } elseif ($paged == 1) {
        // Make query
        $announcement_query_args = array(
            'post_type' => 'careers',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'career_category',
                    'terms' => array('announcement'),
                    'field' => 'slug',
                    'operator' => 'IN',
                ),
            ),
        );
        $wp_announcement_query = new WP_Query( $announcement_query_args ); 
        if ( ($wp_announcement_query->have_posts()) ) { ?>
            <div class="featured-career sticky top">
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
                    <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                    <h3 class="location"><?php echo $location; ?></h3>
                    <br />
                    <?php the_content(); ?>
                    <?php if (current_user_can( 'edit_career', get_the_ID() ) ) { echo '<a class="button" href="/wordpress/wp-admin/post.php?post='. get_the_ID() . '&action=edit">Edit this announcement post</a>'; } ?>
                </header>

            </article><!-- .article -->


            <?php endwhile ?>
            </div>
        <?php }; ?>
    <?php };
	
	if( $career_loop->have_posts() ):
        echo '<span id="counter" data-page-count="' . $career_loop->max_num_pages . '"></span>';
		while( $career_loop->have_posts() ): $career_loop->the_post();
			get_template_part( 'partials/partial', 'career' );
		endwhile;		
	endif;
	wp_reset_postdata();
	
	die();
}


function add_custom_fields_to_rss() {
    if(get_post_type() == 'careers' ) {
        $my_meta_value = get_field('location', get_the_ID());
        ?>
        <source url="https://environment.uw.edu/"><?php echo htmlspecialchars($my_meta_value) ?></source>
        <?php
    }
}
add_action('rss2_item', 'add_custom_fields_to_rss');
