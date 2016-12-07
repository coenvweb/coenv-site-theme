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


function add_custom_fields_to_rss() {
    if(get_post_type() == 'careers' ) {
        $my_meta_value = get_field('location', get_the_ID());
        ?>
        <source><?php echo $my_meta_value ?></source>
        <?php
    }
}
add_action('rss2_item', 'add_custom_fields_to_rss');