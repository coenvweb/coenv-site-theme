<?php 

/**
 * Print optional metas based on ACF options.
 * @return 
 * - echo string
 */
function coenv_custom_metas() {
    // Post info
    $page_id = get_queried_object_id(); 
    
    // Set ancestors for featured image inheritance
    if (is_search() || is_404()) {
        $ancestor = HOME_ANCESTOR_ID; // 2 = homepage
    } elseif (is_post_type_archive('faculty') || is_singular('faculty')) {
        $ancestor = FACULTY_ANCESTOR_ID; // faculty archive and detail pages
    } else {
        $ancestor = coenv_get_ancestor();
    }
    
    // Source code line breaks
    $break = PHP_EOL;
 
    // Meta ACFs
    $meta_description_on_page = trim(get_field('meta_description_on_page', $page_id));
    $meta_robots = trim(get_field('meta_robots', $page_id));
        
    // Social ACFs
    if (get_field('social_share_title')) {
        $social_share_title = trim(get_field('social_share_title', $page_id));
    } else {
        $social_share_title = get_the_title($page_id);
    }
    if (get_field('social_share_description')) {
        $social_share_description = trim(get_field('social_share_description', $page_id));
    } else {
        $social_share_description = get_the_excerpt($page_id);
    }
    
    $social_image = trim(get_field('social_image', $page_id)); 

    // Get featured image, or use ancestor's if empty, or fallback to logo
    if ($social_image) {
        $featured_img = $social_image;   
    } elseif (has_post_thumbnail($page_id)) {
        $featured_img = get_the_post_thumbnail_url($page_id, 'large' );
    } elseif (has_post_thumbnail($ancestor)) {
        $featured_img = get_the_post_thumbnail_url($ancestor, 'large' );
    } else {
        $featured_img = get_template_directory_uri() . '/assets/img/logo-1200x1200.jpg';
    }
    
    // Get featured image width and heights
    list($featured_img_width,$featured_img_height,$featured_img_type,$featured_img_attr) = @getimagesize($featured_img);
    
    $html = '';
    
    // Add custom meta description if added.
    if ($meta_description_on_page) {
        $html .= '<meta name="description" content="' . $meta_description_on_page . '"/>' . $break;
    } 
    // Add meta robots if added
    if ($meta_robots) {
        $html .= '<meta name="robots" content="' . $meta_robots . '"/>' . $break;
    }  
    // Add social image if declared in ACF. Default will use featured img.  
    if ($featured_img) {
        $html .= '<meta property="og:image" content="' . $featured_img . '"/>' . $break;
        $html .= '  <meta property="og:image:width" content="' . $featured_img_width . '" />' . $break;
        $html .= '  <meta property="og:image:height" content="' . $featured_img_height . '" />' . $break;
        $html .= '<meta property="twitter:image" content="' . $featured_img . '"/>' . $break;
    } 
    // Add social title if declared in ACF. Default will use meta title.
    if (!empty($social_share_title)) {
        $html .= '<meta property="og:title" content="' . $social_share_title . '"/>' . $break;
        $html .= '<meta property="twitter:title" content="' . $social_share_title . '"/>' . $break;
    } 
    // Add social description if declared in ACF. 
    if (!empty($social_share_description)) {
        $html .= '<meta property="og:description" content="' . $social_share_description . '"/>' . $break;
        $html .= '<meta property="twitter:description" content="' . $social_share_description . '"/>';
    } 

    return $html;
} 

?>