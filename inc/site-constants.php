<?php 

// add a filter
add_filter('get_user_option_admin_color', 'wpse_313419_conditional_admin_color');
// 
function wpse_313419_conditional_admin_color($result) {
    if(get_site_url() == 'http://environment.uw.local/wordpress') {
        return 'light';
    } elseif(get_site_url() == 'https://staging.environment.uw.edu/wordpress') {
        return 'ocean';
    } else {
    }
}

define("HOME_ANCESTOR_ID", 2); // post id for ancestor - home
define("FACULTY_ANCESTOR_ID", 51037); // post id for ancestor - faculty 

