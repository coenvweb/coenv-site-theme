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

function marketo_signup_form($atts) {
    remove_filter( 'the_content', 'eae_encode_emails', 'EAE_FILTER_PRIORITY' );
    $mkto = shortcode_atts( array(
        'subid' => 378,
        'fromname' => 'UW Email Sign Up',
        'fromemail' => 'advsti@uw.edu',
    ), $atts);
    $output = '<script type="text/javascript" src="https://subscribe.gifts.washington.edu/Scripts/SubManBuilder/submanbuilder.js" id="uwSubscriptionManager"></script>
    <script type="text/javascript">
        SUBMANBUILDER.makeIframe({
            subscriptionID: '.$mkto['subid'].',
            fromEmail: "'.$mkto['fromemail'].'",
            fromName: "'.$mkto['fromname'].'",
            showPlaceHolders: false,
            hideLabels: false,
            returnURL: ""
        });
    </script>';
    return $output;
}
add_shortcode('mkto_signup','marketo_signup_form');

function marketo_prefCenter($atts) {
    remove_filter( 'the_content', 'eae_encode_emails', EAE_FILTER_PRIORITY );
    $mkto = shortcode_atts( array(
        'subid' => 378,
        'fromname' => 'UW Email Sign Up',
        'fromemail' => 'advsti@uw.edu',
    ), $atts);
    $output = '<script type="text/javascript" src="https://subscribe.gifts.washington.edu/Scripts/SubManBuilder/submanbuilder.js" id="uwSubscriptionManager"></script>
    <script type="text/javascript">
        SUBMANBUILDER.makeIframe({
            preferenceID: '.$mkto['subid'].',
            managePreferences: true,
            fromEmail: "'.$mkto['fromemail'].'",
            fromName: "'.$mkto['fromname'].'",
            showHeader: false,
        });
    </script>';
    return $output;
}
add_shortcode('mkto_pref_center','marketo_prefCenter');
