<?php

function widget($atts) {
    
    global $wp_widget_factory;
    
    extract(shortcode_atts(array(
        'widget_name' => FALSE,
        'widget_args' => FALSE
    ), $atts));
    
    $widget_name = wp_specialchars($widget_name);
    $widget_args = wp_specialchars($widget_args);
    
    $instance = str_ireplace("&amp;", '&' ,$widget_args);
    
    ob_start();

    the_widget($widget_name, $instance, array('widget_id'=>'arbitrary-instance-'.$id, $widget_classes
    ));
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
    
}
add_shortcode('widget','widget'); 

