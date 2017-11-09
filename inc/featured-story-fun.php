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
    if ($element_type == 'gallery') {
        $primary_link = $links[0]['link']['url'];
    } else {
        $primary_link = null;
    }
    
    ob_start ();
    ?>

    <div class="element <?php echo $atts['align'] . ' element-' . $element_type; ?>">
        <?php
        if( !empty($photos) ):
            foreach ($photos as $photo) {
        ?>        
                <a class="photo" href="<?php echo (!$primary_link) ? $photo['url'] : $primary_link; ?>" title="<?php echo $photo['description']; ?>" <?php echo (!$primary_link) ? 'data-lightbox-gallery="gallery-1"' : 'none' ; ?>><?php echo wp_get_attachment_image( $photo['ID'], 'homepage-column-standard' ); ?></a>
        <?php
            }
        else :
            // no rows found
        endif;
        ?>
        <h2 class="title"><?php echo $title ?></h2>
        <h3 class="subtitle"><?php echo $sub_title ?></h3>
        <p><?php echo $text ?></p>
        <?php
        if( !empty($links) ):
            foreach ($links as $link) {
                $link = $link['link']
        ?>        
                <a class="button" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
        <?php
            }
        else :
            // no rows found
        endif;
        ?>
        
    </div>


    <?  
    $content = ob_get_contents();
    ob_end_clean();
    
return $content;
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