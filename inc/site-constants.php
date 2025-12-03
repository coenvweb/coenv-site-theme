<?php 

// add a filter
add_filter('get_user_option_admin_color', 'wpse_313419_conditional_admin_color');
// 
function wpse_313419_conditional_admin_color($result) {
    // Dev: use 'light' color scheme
    if(get_site_url() == 'http://environment.uw.local/wordpress') {
        return 'light';
    // Staging: use 'blue' color scheme
    } elseif(get_site_url() == 'http://staging.environment.uw.edu/wordpress') {
        return 'blue';
    // Production (all other cases): use 'sunrise' color scheme
    } else {
    }
}

define("HOME_ANCESTOR_ID", 2); // post id for ancestor - home
define("FACULTY_ANCESTOR_ID", 51037); // post id for ancestor - faculty 

