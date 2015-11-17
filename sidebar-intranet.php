<?php  
/**
 * The sidebar template
 *
 * Serves up sidebar widgets for individual top level pages
 */
$ancestor_id = 267;

if (!function_exists('dynamic_sidebar') || !dynamic_sidebar( $ancestor_id )): endif;