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
    $link = $active_row['link'];
    $photos = $active_row['photos'];
    
    ob_start ();
    ?>

    <div class="element">
        <h2><?php echo $title ?></h2>
        <h3><?php echo $sub_title ?></h3>
        <p><?php echo $text ?></p>
        <?php
        // check if the repeater field has rows of data
        if( have_rows('link') ):
          // loop through the rows of data
            while ( have_rows('link') ) : the_row();
                // display a sub field value
                $link = the_sub_field('link');
                ?><a class="button" href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a> <?
            endwhile;
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