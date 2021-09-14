<?php
/**
 * Related Faculty
 */
global $coenv_member_api;
    $coenv_choice = get_field('related_faculty');
    if ( $coenv_choice == 'related' ) {
        coenv_related_faculty( $post->ID );
    } elseif ( $coenv_choice == 'choose' ) {
        $coenv_chosen = get_field('related_faculty_post');
        coenv_related_faculty( $post->ID, $coenv_chosen );
    } else {

    }

?>