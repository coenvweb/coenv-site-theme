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
            if (!$primary_link) {
                $top_link = $photo['url'];
                $gallery = 'data-lightbox-gallery="gallery-1"';
            } else {
                $top_link = $primary_link;
            }
            $photo_url = wp_get_attachment_image_src( $photo['ID'] , 'original');
            $photo_holder .= '<a class="photo" href="' . $top_link . '" title="' . $photo['description'] . '" ' . $gallery . '>' . wp_get_attachment_image( $photo['ID'], 'homepage-column-standard' ) . '</a>';
        }
    } else {
        // no rows found
    };
    
    if ($element_type == 'call_to_action'){
        $opener = '</section>';
        $ender = '</div><section class="article__content">';
    } else {
        $opener = $ender = '';
    }

    $output = $opener . '<div class="element ' . $atts['align'] . ' element-' . $element_type . '"';
    
        if ($element_type == 'call_to_action'){
            $output .= ' style="background-image: url(' . $photo_url[0] . ');" ><div class="cta-content">';
        } else {
            $output .= '>' . $photo_holder;
        }
        $output .= '<h2 class="title">' . $title . '</h2>';
        $output .= '<h3 class="subtitle">' . $sub_title . '</h3>';
        $output .= '<p>' . $text . '</p>';
            
        if( !empty($links) ){
            foreach ($links as $link) {
                $link = $link['link'];
                $output .=  '<a class="button" href="' . $link['url'] . '" target="' . $link['target'] . '">' . $link['title'] . '</a>';
            }
        } else {
            // no rows found
        }
        
    $output .= '</div>' . $ender; 
    
return $output;
};
add_shortcode( 'element', 'element_func' );

function quote_func( $atts, $content = null ){
return '<i class="quote">"</i> <div class="feat-quote">' . $content . '</div>';
};
add_shortcode( 'quote', 'quote_func' );

function tweetable_func( $atts, $content = null ){
    $a = shortcode_atts( array(
        'alter' => '',
    ), $atts );
    if ($atts['alter']) {
        $tweet_text = $atts['alter'];
    }else {
        $tweet_text = $content;
    }
return '<span class="tweetable"><a href="http://twitter.com/home?status=' . $tweet_text  . ' ' . wp_get_shortlink() . ' - @UW_CoEnv">' . $content . '</a></span>';
};
add_shortcode( 'tweetable', 'tweetable_func' );


function photo_divider_func( $atts, $content = null ){
    $a = shortcode_atts( array(
        'src' => 'none',
    ), $atts );
    $regex = '/https?\:\/\/[^\" ]+/i';
    preg_match($regex, $content, $matches);
    $output = '</section><div class="photo-divider" style="background-image:url(' . $matches[0] . ')"></div><section class="article__content">';
return $output;
};
add_shortcode( 'photo_divider', 'photo_divider_func' );