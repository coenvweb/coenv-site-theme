<?php
function element_wrapper_func( $atts, $content = null ){
    $a = shortcode_atts( array(
        'align' => 'right',
    ), $atts );
    $output = '<div class="element-wrapper ' . $a['align'] . '">';
    $output .= do_shortcode($content);
    $output .= '</div>';
return $output;
};
add_shortcode( 'element_wrapper', 'element_wrapper_func' );

function element_func( $atts ){
    
    $a = shortcode_atts( array(
        'id' => '1',
        'align' => 'right',
    ), $atts );
    $element_id = ($atts['id'] - 1);
    $rows = get_field('element');
    $active_row = $rows[$element_id];
    $element_type = $active_row['element_type'];
    $title = $active_row['element_title'];
    $sub_title = $active_row['element_subtitle'];
    $text = $active_row['text_area'];
    $links = $active_row['links'];
    $photos = $active_row['photos'];
    if ($element_type !== 'gallery') {
        $primary_link = $links[0]['link']['url'];
    } else {
        $primary_link = null;
    }
    
    if( !empty($photos) ){
        $photo_holder = '';
        foreach ($photos as $photo) {
            $photo_url = wp_get_attachment_image_src( $photo['ID'] , 'original');
            if (!$primary_link) {
                $top_link = $photo['url'];
                $gallery = 'data-lightbox-gallery="gallery-' . $atts['id'] . '"';
            } else {
                $top_link = $primary_link;
            }
            
            if ($element_type == 'big_gallery' && ($i == 0)) {
                $photo_el = wp_get_attachment_image( $photo['ID'], 'large' );
                $caption = $photo['caption'];
            } else {
                $photo_el = wp_get_attachment_image( $photo['ID'], 'homepage-column-standard' );
                $caption = $photo['caption'];
            }
            
            $photo_url = wp_get_attachment_image_src( $photo['ID'] , 'original');
            
            if ($element_type == 'slider_gallery') {
                $photo_el = wp_get_attachment_image( $photo['ID'], 'original' );
                $photo_holder .= $photo_el;
                //$photo_holder .= '<div class="photo rsImg">' . $photo_el . '<p class="caption">' . $photo['caption'] . '</p></div>';
            } else {
                $photo_holder .= '<a class="photo" href="' . $top_link . '" title="' . $photo['caption'] . '" ' . $gallery . '>' . $photo_el . '</a>';
            }
            
        }
    } else {
        // no rows found
    };

    $output = '<div class="element ' . $atts['align'] . ' element-' . $element_type . ' element-' . sanitize_title($title) . ' element-' . $element_type . $atts['id'] . '"';
    
        if ($element_type == 'call_to_action'){
            $output .= ' style="background: url(' . $photo_url[0] . '); background-size: cover; background-position: center;" ><div class="cta-content">';
        } else {
            $output .= '>' . $photo_holder;
        }
        if (!empty($title)) {
            $output .= '<h2 class="title">' . $title . '</h2>';
        }
        if (!empty($sub_title)) {
            $output .= '<h3 class="subtitle">' . $sub_title . '</h3>';
        }
        if (!empty($text)) {
            $output .= '<p>' . $text . '</p>';
        }
            
        if( !empty($links) ){
            foreach ($links as $link) {
                $link = $link['link'];
                $output .=  '<a class="button" href="' . $link['url'] . '" target="' . $link['target'] . '">' . $link['title'] . '</a>';
            }
        } else {
            // no rows found
        }
        
    $output .= '</div>'; 
    
return $output;
};
add_shortcode( 'element', 'element_func' );

function big_element_func( $atts ){
    
    $a = shortcode_atts( array(
        'id' => '1',
    ), $atts );
    $element_id = ($atts['id'] - 1); //start element index at 1
    $rows = get_field('element');
    $active_row = $rows[$element_id];

    $element_type = $active_row['element_type'];
    $title = $active_row['element_title'];
    $sub_title = $active_row['element_subtitle'];
    $text = $active_row['text_area'];
    $links = $active_row['links'];
    $photos = $active_row['photos'];

    if ($element_type !== 'big_gallery' && $links) {
        $primary_link = $links[0]['link']['url'];
    } else {
        $primary_link = null;
    }
    
    if( !empty($photos) ){
        $photo_holder = '';
        $i = 0;
        foreach ($photos as $photo) {
            
            if (!$primary_link) {
                $top_link = $photo['url'];
                $gallery = 'data-lightbox-gallery="gallery-' . $atts['id'] . '"';
            } else {
                $top_link = $primary_link;
            }
            
            if ($element_type == 'big_gallery' && ($i == 0)) {
                $photo_el = wp_get_attachment_image( $photo['ID'], 'original' );
                $caption = $photo['caption'];
            } else {
                $photo_el = wp_get_attachment_image( $photo['ID'], 'large' );
                $caption = $photo['caption'];
            }
            
            $photo_url = wp_get_attachment_image_src( $photo['ID'] , 'original');
            
            if ($element_type == 'slider_gallery') {
                $photo_el = wp_get_attachment_image( $photo['ID'], 'original' );
                $photo_holder .= $photo_el;
                //$photo_holder .= '<div class="photo rsImg">' . $photo_el . '<p class="caption">' . $photo['caption'] . '</p></div>';
            } else {
                $photo_holder .= '<a class="photo" href="' . $top_link . '" title="' . $photo['caption'] . '" ' . $gallery . '>' . $photo_el . '</a>';
            }
            
            $i++;
        }
    } else {
        // no rows found
    };

    $output = '</section><div class="big-element ' . $atts['align'] . ' element-' . $element_type . ' element-' . $element_type . $atts['id'] . '"';
    
        switch($element_type) {
            case 'call_to_action':
                $output .= ' style="background: url(' . $photo_url[0] . '); background-size: cover; background-position: center;" ><div class="cta-content">';
                if (!empty($title)) {
                    $output .= '<h2 class="title">' . $title . '</h2>';
                }
                if (!empty($sub_title)) {
                    $output .= '<h3 class="subtitle">' . $sub_title . '</h3>';
                }
                if (!empty($text)) {
                    $output .= '<p>' . $text . '</p>';
                }
                if( !empty($links) ){
                    foreach ($links as $link) {
                        $link = $link['link'];
                        $output .=  '<a class="button" href="' . $link['url'] . '" target="' . $link['target'] . '">' . $link['title'] . '</a>';
                    }
                } else {
                    // no rows found
                }
				break;
            case 'map':
				$locations = $active_row['locations'];
				$map_instructions = $active_row['map_instructions'];
				$marker_icons = $active_row['marker_icons'][0];
				$active_icon = $marker_icons['active_icon'];
				$inactive_icon = $marker_icons['inactive_icon'];
                $output .= '>';
				$output .= '<div class="acf-map-container">';
					$output .= '<div class="map-instructions right">'.$map_instructions.'</div>';
                    $output .= '<div class="map-box left"></div>';
					$output .= '<div class="acf-map" style="height: 400px">';
						foreach($locations as $location) {
							$output .= '<div class="marker" data-lat="'.$location['lat'].'" data-lng="'.$location['lng'].'" data-active="'.$active_icon.'" data-inactive="'.$inactive_icon.'">';
                                if(!empty($photo_url)) {
                                    $output .= '<img class="icon" src="'.$photo_url[0].'" />';
                                }
								$output .= '<h2>'.$location['title'].' </h2>';
								$output .= '<div class="marker_text">'.$location['text_area'].'</div>';
							$output .= '</div>';
						}
					$output .= '</div>';
				$output .= '</div>';
				break;
            case 'profile':
            case 'gallery':
            case 'content':
                $output .= '>' . $photo_holder;
                if (!empty($title)) {
                    $output .= '<h2 class="title">' . $title . '</h2>';
                }
                if (!empty($sub_title)) {
                    $output .= '<h3 class="subtitle">' . $sub_title . '</h3>';
                }
                if (!empty($text)) {
                    $output .= '<p>' . $text . '</p>';
                }
                if( !empty($links) ){
                    foreach ($links as $link) {
                        $link = $link['link'];
                        $output .=  '<a class="button" href="' . $link['url'] . '" target="' . $link['target'] . '">' . $link['title'] . '</a>';
                    }
                } else {
                    // no rows found
                }
				break; 
            case 'big_gallery':
                $output .= '>' . $photo_holder;
                $output .= '<p class="gallery-caption"><strong>Gallery</strong> // ' . $caption . '</p>';
				break;
            case 'slider_gallery':
                $output .= '>' . $photo_holder;
                if (!empty($title)) {
                    $output .= '<h2 class="title">' . $title . '</h2>';
                }
                if (!empty($sub_title)) {
                    $output .= '<h3 class="subtitle">' . $sub_title . '</h3>';
                }
                if (!empty($text)) {
                    $output .= '<p>' . $text . '</p>';
                }
                if( !empty($links) ){
                    foreach ($links as $link) {
                        $link = $link['link'];
                        $output .=  '<a class="button" href="' . $link['url'] . '" target="' . $link['target'] . '">' . $link['title'] . '</a>';
                    }
                } else {
                    // no rows found
                }
        break;      
        }
    $output .= '</div><section class="article__content">';
	return $output;
};
add_shortcode( 'big_element', 'big_element_func' );

function quote_func( $atts, $content = null ){
return '<i class="open-quote"></i> <div class="feat-quote">' . $content . '</div>';
};
add_shortcode( 'quote', 'quote_func' );

function tweetable_func( $atts, $content = null ){
    $a = shortcode_atts( array(
        'alter' => '',
    ), $atts );
   
     if (isset($atts['alter'])) {
        $tweet_text = $atts['alter'];
    }else {
        $tweet_text = $content;
    }
return '<span class="tweetable"><a href="http://twitter.com/home?status=' . $tweet_text  . ' Read more via @UW_CoEnv:' . wp_get_shortlink() . '" target="_blank">' . $content . '</a></span>';
};
add_shortcode( 'tweetable', 'tweetable_func' );

function define_term_func( $atts, $content = null ){
    $a = shortcode_atts( array(
        'definition' => '',
    ), $atts );
return '<span class="define-term"><span class="element left element-content define-element"><img src="'. get_template_directory_uri() . '/assets/img/definition.jpg" alt="definition"><i class="underline"></i><span class="definition-text"><strong>'. $content  . ':</strong> ' . $atts['definition'] . '</span></span><a>' . $content . '</a></span>';
};
add_shortcode( 'define_term', 'define_term_func' );


function photo_divider_func( $atts, $content = null ){
    $a = shortcode_atts( array(
        'src' => '',
        'class' => '',
        'title' => '',
        'subtitle' => '',
    ), $atts );
     if (isset($atts['class'])) {
        $divider_class = $atts['class'];
    }else {
        $divider_class = 'default';
    }
    if (isset($atts['title'])) {
        $divider_title = '<h2 class="section-title">' . $atts['title'] . '</h2>';
    }else {
        $divider_title = null;
    }
    if (isset($atts['subtitle'])) {
        $divider_subtitle = '<p class="subtitle">' . $atts['subtitle'] . '</p>';
    }else {
        $divider_subtitle = null;
    }
    preg_match_all('/wp-image-([\d]+)/', $content, $matches);
    $output = '</section></div><div id="section-' . sanitize_title($atts['title']) . '" class="scrollto"><div class="photo-divider photo-divider-1 ' . $divider_class . ' divider-' . sanitize_title($atts['title']) . '" style="background-image:url(' . wp_get_attachment_url($matches[1][0]) . ')"><div class="inner-divider-content"><div class="title-block">' . $divider_title . $divider_subtitle . '</div></div></div>';
    if (isset($matches[1][1])) {
        $output .= '<div class="photo-divider photo-divider-2" style="background-image:url(' . wp_get_attachment_url($matches[1][1]) . ')"><div class="inner-divider-content"><div class="title-block">' . $divider_title . $divider_subtitle . '</div></div></div><section class="article__content">';
    } else {
        $output .= '<section class="article__content">';
    }
    return $output;
};
add_shortcode( 'photo_divider', 'photo_divider_func' );