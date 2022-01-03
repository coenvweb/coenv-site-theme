<?php

// Featured images
if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support('post-thumbnails');
}

add_filter('image_size_names_choose', 'my_image_sizes');
function my_image_sizes($sizes) {
$addsizes = array(
"half" => __( "50% of column"),
"one-third" => __( "33% of column"),
"homepage-column-standard" => __( "Hompage Column Standard Aspect"),
"homepage-hero-standard" => __( "Homepage Hero Standard Aspect")
);
$newsizes = array_merge($sizes, $addsizes);
return $newsizes;

	// Set media sizes
	// thumbnail: 200x200 square crop
  update_option( 'thumbnail_size_w', 200 );
  update_option( 'thumbnail_size_h', 200 );
  update_option( 'thumbnail_crop', 1 );

	if ( function_exists( 'add_image_size' ) ) {
		add_image_size( 'tiny', 129, 129, true );
		add_image_size( 'small', 262, 262 );
		add_image_size( 'banner', 1680 );
        add_image_size( 'homepage-column-retina', 528 );
        add_image_size( 'homepage-column', 253 );
		add_image_size( 'half', 375 );
		add_image_size( 'one-third', 250 );
        // restrained height
        add_image_size( 'homepage-column-standard', '253', '168', true );
        add_image_size( 'homepage-hero-standard', '680', '450', true );
	}

  // medium: 528x528
  update_option( 'medium_size_w', 528 );
  update_option( 'medium_size_h', 528 );

  // large: 750x750
  update_option( 'large_size_w', 794 );
  update_option( 'large_size_h', 794 );
}


/**
 * Adds divs around all inline images (for excerpts)
 **/
function breezer_addDivToImage( $content ) {

   // A regular expression of what to look for.
   $pattern = '/(<img([^>]*)>)/i';
   // What to replace it with. $1 refers to the content in the first 'capture group', in parentheses above
   $replacement = '<div class="myphoto">$1</div>';

   // run preg_replace() on the $content
   $content = preg_replace( $pattern, $replacement, $content );

   // return the processed content
   return $content;
}
if (is_archive()):
	add_filter( 'the_content', 'breezer_addDivToImage' );
endif;

/**
 * Add custom media metadata fields
 *
 * Be sure to sanitize your data before saving it
 * http://codex.wordpress.org/Data_Validation
 *
 * @param $form_fields An array of fields included in the attachment form
 * @param $post The attachment record in the database
 * @return $form_fields The final array of form fields to use
 */
function add_image_attachment_fields_to_edit( $form_fields, $post ) {		
	// Add a Credit field
	$form_fields["credit_text"] = array(
		"label" => __("Credit"),
		"input" => "text", // this is default if "input" is omitted
		"value" => esc_attr( get_post_meta($post->ID, "_credit_text", true) ),
		"helps" => __("The owner of the image."),
	);
	
	// Add a Credit field
	$form_fields["credit_link"] = array(
		"label" => __("Credit URL"),
		"input" => "text", // this is default if "input" is omitted
		"value" => esc_url( get_post_meta($post->ID, "_credit_link", true) ),
		"helps" => __("Attribution link to the image source or owners website."),
	);
	
	return $form_fields;
}
add_filter("attachment_fields_to_edit", "add_image_attachment_fields_to_edit", null, 2);

/**
 * Save custom media metadata fields
 *
 * Be sure to validate your data before saving it
 * http://codex.wordpress.org/Data_Validation
 *
 * @param $post The $post data for the attachment
 * @param $attachment The $attachment part of the form $_POST ($_POST[attachments][postID])
 * @return $post
 */
function add_image_attachment_fields_to_save( $post, $attachment ) {
	if ( isset( $attachment['credit_text'] ) )
		update_post_meta( $post['ID'], '_credit_text', esc_attr($attachment['credit_text']) );
		
	if ( isset( $attachment['credit_link'] ) )
		update_post_meta( $post['ID'], '_credit_link', esc_url($attachment['credit_link']) );

	return $post;
}
add_filter("attachment_fields_to_save", "add_image_attachment_fields_to_save", null , 2);

/**
 * Improves the caption shortcode with HTML5 figure & figcaption; microdata & wai-aria attributes
 * 
 * @param  string $val     Empty
 * @param  array  $attr    Shortcode attributes
 * @param  string $content Shortcode content
 * @return string          Shortcode output
 */
function jk_img_caption_shortcode_filter($val, $attr, $content = null)
{
	extract(shortcode_atts(array(
		'id'      => '',
		'align'   => 'aligncenter',
		'width'   => '',
		'caption' => ''
	), $attr));
	
	// No caption, no dice... But why width? 
	if ( 1 > (int) $width || empty($caption) )
		return $val;
 
	if ( $id )
		$id = esc_attr( $id );
		$attach_id = str_replace('attachment_', '', $id);
		$photo_source = get_post_meta( $attach_id, '_credit_text', true );
		$photo_source_url = get_post_meta( $attach_id, '_credit_link', true );
	
		if ( $photo_source ) {
		if (!empty($photo_source_url)) {
			$photo_source_div = "<div class=\"source\"><a href=\"$photo_source_url\" target=\"blank\">$photo_source</a></div>";
		} else 
			$photo_source_div = "<div class=\"source\">$photo_source</div>";
		} else
			$photo_source_div= " ";
		
	


	return '<figure title="' . $caption . '" id="' . $id . '" aria-describedby="figcaption_' . $id . '" class="wp-caption ' . esc_attr($align) . '" itemscope itemtype="http://schema.org/ImageObject" style="width: ' . (0 + (int) $width) . 'px">' . do_shortcode( $content ) . $photo_source_div . '<figcaption id="figcaption_'. $id . '" class="wp-caption-text" itemprop="description">' . $caption . '</figcaption></figure>';
	
}
add_filter( 'img_caption_shortcode', 'jk_img_caption_shortcode_filter', 10, 3 );



/**
 * Page banners
 *
 * 2013.07.31 | Darin | disabled check for post thumbnail, will always fall back to ancestor thumbnail.
 */

function inherited_featured_image( $page = NULL ) {
	if ( is_numeric( $page ) ) {
	  $page = get_post( $page );
	} elseif( is_null( $page ) ) {
	  $page = isset( $GLOBALS['post'] ) ? $GLOBALS['post'] : NULL;
	}
	if ( ! $page instanceof WP_Post ) return false;
	// if we are here we have a valid post object to check,
	// get the ancestors
	$ancestors = get_ancestors( $page->ID, $page->post_type );
	if ( empty( $ancestors ) ) return false;
	// ancestors found, let's check if there are featured images for them
	global $wpdb;
	$metas = $wpdb->get_results(
	  "SELECT post_id, meta_value
	  FROM {$wpdb->postmeta}
	  WHERE meta_key = '_thumbnail_id'
	  AND post_id IN (" . implode( ',', $ancestors ) . ");"
	);
	if ( empty( $metas ) ) return false;
	// extract only post ids from meta values
	$post_ids = array_map( 'intval', wp_list_pluck( $metas, 'post_id' ) ); 
	// compare each ancestor and if return meta value for nearest ancestor 
	foreach ( $ancestors as $ancestor ) {
	  if ( ( $i = array_search( $ancestor, $post_ids, TRUE ) ) !== FALSE ) {
		return $metas[$i]->meta_value;
	  }
	}
	return false;
  }

  add_action( "save_post_page", "inherited_featured", 20, 2 );

	function inherited_featured( $pageid, $page ) {
	if ( has_post_thumbnail( $pageid ) ) return;
	$img = inherited_featured_image();
	if ( $img ) {
		set_post_thumbnail( $page, $img );
	}
	}


function coenv_banner() {
	$obj = get_queried_object();

	$page_id = false;
	$banner = false;
    
    $ancestor = coenv_get_ancestor();
    if (is_singular('careers')) {
        unset($ancestor);
        $ancestor = 32;
    }

    if (is_singular('newsletter')) {
        unset($ancestor);
        $ancestor = 5;
    }
    
    if (is_page_template('templates/future-ug-sub.php')) {
        unset($ancestor);
        $ancestor = 38568;
    }
    
    if (is_page_template('templates/future-grad-sub.php')) {
        unset($ancestor);
        $ancestor = 38585;
    }

	if ((isset($obj->ID)) && has_post_thumbnail( $obj->ID ) && (!is_single() || is_page_template('templates/signature-story.php')) ) {
		$page_id = $obj->ID;

	} else if ( has_post_thumbnail( $ancestor ) ) {
		$thumb_id = inherited_featured_image();
		$page_id = 1;
    }

	if ( $page_id == false ) {
		return false;
	}

	if (!isset($thumb_id)) {
		$thumb_id = get_post_thumbnail_id( $page_id );
	};

	$image_src = wp_get_attachment_image_src( $thumb_id, 'banner' );
	$attachment_post_obj = get_post( $thumb_id );
    
  if (is_page_template('templates/signature-story.php')) {
      $thumb_id_custom = get_field('banner_image');
      $image_src = wp_get_attachment_image_src( $thumb_id_custom, 'banner' );
  }
  $banner = array(
    'url' => $image_src[0],
    'permalink' => get_permalink( $attachment_post_obj->ID ),
  );

	return $banner;
}

function my_gallery_default_type_set_link( $settings ) {
    $settings['galleryDefaults']['link'] = 'file';
    return $settings;
}
add_filter( 'media_view_settings', 'my_gallery_default_type_set_link');

/**
 * Remove WordPress's default padding on images with captions
 *
 * @param int $width Default WP .wp-caption width (image width + 10px)
 * @return int Updated width to remove 10px padding
 */
function remove_caption_padding( $width ) {
	return $width - 10;
}
add_filter( 'img_caption_shortcode_width', 'remove_caption_padding' );



// Add media categories with capabilities for career editors

function media_tax() {

	$media_labels = array(

		'name'                       => _x( 'Media Categories', 'Taxonomy General Name', 'text_domain' ),
		'singular_name'              => _x( 'Media Category', 'Taxonomy Singular Name', 'text_domain' ),
		'menu_name'                  => __( 'Media Categories', 'text_domain' ),
		'all_items'                  => __( 'All Media Categories', 'text_domain' ),
		'parent_item'                => __( 'Parent Media Category', 'text_domain' ),
		'parent_item_colon'          => __( 'Parent Media Category:', 'text_domain' ),
		'new_item_name'              => __( 'New Media Category', 'text_domain' ),
		'add_new_item'               => __( 'Add Media Category', 'text_domain' ),
		'edit_item'                  => __( 'Edit Media Category', 'text_domain' ),
		'update_item'                => __( 'Update Media Category', 'text_domain' ),
		'separate_items_with_commas' => __( 'Separate Media Categories with commas', 'text_domain' ),
		'search_items'               => __( 'Search Media Categories', 'text_domain' ),
		'add_or_remove_items'        => __( 'Add or remove Media Categories', 'text_domain' ),
		'choose_from_most_used'      => __( 'Choose from the most cited Media Categories', 'text_domain' ),
		'not_found'                  => __( 'Not Found', 'text_domain' ),

	);
	$media_args = array(

		'labels'                     => $media_labels,
		'hierarchical'               => true,
        'with_front'                 => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => false,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
		'capabilities' => array(
			'assign_terms' => 'assign_media_terms',
		),

	);
	register_taxonomy( 'media_stuff', array('post'), $media_args );
}



add_action( 'init', 'media_tax' );


?>