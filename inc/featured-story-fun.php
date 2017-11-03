<?php
function element_func( $atts ){
    
    $a = shortcode_atts( array(
        'id' => '1',
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
    
    ob_start ();
    ?>

    <div class="element">
        <h2><?php echo $title ?></h2>
        <h3><?php echo $sub_title ?></h3>
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
        <?php
    
        print_r($photos);
        
        ?>
        
    </div>


    <?  
    $content = ob_get_contents();
    ob_end_clean();
    
return $content;
};
add_shortcode( 'element', 'element_func' );