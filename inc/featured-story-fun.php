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
    

    $output = '<div class="element ' . $atts['align'] . ' element-' . $element_type . '">';
        if( !empty($photos) ){
            foreach ($photos as $photo) {
                if (!$primary_link) {
                    $top_link = $photo['url'];
                    $gallery = 'data-lightbox-gallery="gallery-1"';
                } else {
                    $top_link = $primary_link;
                }
                $output .= '<a class="photo" href="' . $top_link . '" title="' . $photo['description'] . '" ' . $gallery . '>' . wp_get_attachment_image( $photo['ID'], 'homepage-column-standard' ) . '</a>';
            }
        } else {
            // no rows found
        };
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
        
    $output .= '</div>'; 
    
return $output;
};
add_shortcode( 'element', 'element_func' );

function quote_func( $atts, $content = null ){
return '<i class="quote">"</i> <div class="feat-quote">' . $content . '</div>';
};
add_shortcode( 'quote', 'quote_func' );

function share_quote_func( $atts, $content = null ){
return '<a href="http://twitter.com/home?status=' . $content . ' ' . wp_get_shortlink() . '"><div class="share-quote">' . $content . '</div></a>';
};
add_shortcode( 'share_quote', 'share_quote_func' );


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