<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>    

<?php 
global $wp;
$post_link = home_url( add_query_arg( array(), $wp->request ) );
?>

<?php echo coenv_meta_title(); ?> 
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta property="og:type" content="article" />
<meta property="og:site_name" content="<?php bloginfo('name') ?>" />
<meta property="og:url" content="<?php echo $post_link; ?>"/>
<meta name="twitter:dnt" content="on"> 
<?php echo coenv_custom_metas(); ?>            
<!--[if lt IE 8]>
<link rel='stylesheet' id='screen-css'  href='<?php echo get_template_directory_uri() ?>/assets/styles/build/lt-ie8.css?<?php echo time(); ?>' type='text/css' media='all' />
<![endif]-->
<!--[if gte IE 8]><!--> 
<link rel='stylesheet' id='screen-css'  href='<?php echo get_template_directory_uri() ?>/assets/styles/build/screen.css?<?php echo time(); ?>' type='text/css' media='all' />
<!--<![endif]-->
        
<!--prefetching-->
<link rel="dns-prefetch" href="//p.typekit.net">
<link rel="dns-prefetch" href="//use.typekit.net">
<link rel="preconnect" href="https://www.googletagmanager.com">
<link rel="preconnect" href="https://www.google-analytics.com">
<link rel="preconnect" href="https://www.washington.edu">

        
<link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/bg-wave-cut.png">
<link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/black-white-suz.jpg">
<link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/boundless_logo.svg">
<link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/boundless_logo_left.svg">
<link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/boundless_logo_right.svg">
<link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/logo.svg">
<link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/uw-footer.svg">
<link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/fonts/icomoon.woff">
<!--end prefectching-->
    
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri() ?>/assets/img/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_template_directory_uri() ?>/assets/img/manifest.json">

<meta name="msapplication-TileColor" content="#613ba9">
<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri() ?>/assets/img/ms-icon-144x144.png">
<meta name="theme-color" content="#613ba9">
        
<?php
    // Build advancedExcerpt
    wp_reset_query();   
      if (have_posts()) : while(have_posts()) the_post();
      if (is_singular('faculty')) {
	      $advancedExcerpt = strip_tags(substr(get_field('biography'),0,500));
      } elseif (is_post_type_archive( 'faculty' )) {		
          $advancedExcerpt = 'Our world-class faculty are at the center of our work at The UW College of the Environment.';
      } elseif (is_page( 357 ) ) {
          $advancedExcerpt = 'The events calendar shows happenings across the UW College of the Environment.';
      } elseif (is_singular()&&is_front_page()==false ) {
          $excerpt = get_the_excerpt();
      if (strlen($excerpt) > 500 ) {
          $length = strpos($excerpt, ' ', 500);
      } else {
          $length = 500;
      }
          $advancedExcerpt = substr($excerpt,0, $length);
      } else {
          $advancedExcerpt = get_option('meta_description');
      }
        $advancedExcerpt = strip_tags($advancedExcerpt);
        $advancedExcerpt = preg_replace( "/\r|\n/", " ", $advancedExcerpt);

      endif;
?>
<!-- uw munchkin -->
<!-- UWMunchkin.init('munchkinID', 'serviceKey', 'testIP')-->
<script type="text/javascript">
    (function () {
        var didInit = false,
            s = document.createElement('script');

        s.type = 'text/javascript';
        s.async = true;
        s.src = 'https://subscribe.gifts.washington.edu/Scripts/uwmunchkin/uwmunchkin.min.js';
        s.onreadystatechange = function () {
            if (this.readyState == 'complete' || this.readyState == 'loaded') {
                initUWMunchkin();
            }
        };
        s.onload = initUWMunchkin;
        document.getElementsByTagName('head')[0].appendChild(s);

        function initUWMunchkin() {
            if (didInit === false) {
                didInit = true;
                UWMunchkin.init('131-AQO-225', '555556', null);
            }
        }
    })();
</script>       
<script async src="//www.washington.edu/static/alert.min.js" type="text/javascript"></script>
<script>
    (function(d) {
             var config = {
              kitId: 'dyq8fxo',
              scriptTimeout: 3000
    },
        h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='//use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
    })(document);
</script>

<?php wp_head() ?>

<!-- Global site tag (gtag.js) - Google Analytics 4 - old in footer.php -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-5R657MZJ8Q"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-5R657MZJ8Q');
</script>
                               
<!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/bower_components/selectivizr/selectivizr.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/bower_components/respond/respond.min.js"></script>
<![endif]-->

<?php 
    if ( !is_404() ) {
        $banner = coenv_banner();
        $banner_class = $banner ? 'has-banner' : '';
        $banner_class .= ' template-print';
    }
?>

</head>
    
<body <?php if (isset( $banner_class )) { body_class( $banner_class ); } else { body_class(); }; ?>>
     <!-- Skip link for accessibility -->
    <a href="#main-content" class="skip-link">Skip to main content</a>
    
    <div class="grid-container">
        <!-- Top Black Bar -->
        <div class="top-bar">
            <div class="top-bar-content">
                <div class="top-bar-left">
                    <a href="https://washington.edu" class="uw-logo-link" aria-label="University of Washington">
                        <svg id="uw_logo" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 307.43 56.97" aria-hidden="true">
                            <path fill="white" d="M299.18,11.74V2.34l6.53,10.48h.64V1.36l1.08-1.08h-3.28l1.08,1.08v7.97l-5.66-9.06h-2.6l1.06,1.08v10.38l-1.06,1.08h3.28l-1.08-1.08ZM289.49,12.14c-2.51,0-3.38-3-3.38-5.59s.87-5.59,3.38-5.59,3.4,3,3.4,5.59-.87,5.59-3.4,5.59M284.47,6.55c0,3.19,1.81,6.55,5.02,6.55s5.04-3.36,5.04-6.55-1.81-6.55-5.04-6.55-5.02,3.36-5.02,6.55M278.79,11.82V1.21h2.38l1.34,1.34V.28h-8.83v2.28l1.36-1.34h2.36v10.61l-.98,1h3.36l-1-1ZM269.5,7.12v4.04c-.3.3-.89.89-2.06.89-2.79,0-4.19-2.81-4.19-5.51s1.77-5.51,4.19-5.51c.64,0,1.11.15,1.53.6l1.38,1.36V.83c-.74-.38-1.49-.72-2.91-.72-3.42,0-5.83,3.06-5.83,6.44s2.4,6.44,5.83,6.44c1.94,0,2.76-.47,3.45-.91v-4.96l.98-1h-3.36l1,1ZM250.9,11.74V2.34l6.6,10.49h.57V1.36l1.08-1.08h-3.28l1.08,1.08v7.97l-5.66-9.06h-2.59l1.06,1.08v10.38l-1.06,1.08h3.28l-1.08-1.08ZM241.9.28l1,1v10.55l-1,1h3.38l-1-1V1.28l1-1h-3.38ZM230.76,6.53h5.27v5.3l-1,1h3.38l-1-1V1.28l1-1h-3.38l1,1v4.32h-5.27V1.28l1-1h-3.36l.98,1v10.55l-.98,1h3.36l-1-1v-5.3ZM225.1,9.34c0-1.23-.58-2-1.17-2.4l-2.55-1.85c-.91-.66-1.38-1.51-1.38-2.15,0-1.32,1.13-1.79,1.81-1.79.36,0,.62.15.81.15l1.11,1.19,1.17-1.74-2.49-.47c-.17-.04-.28-.06-.6-.06-2.19,0-3.19,1.87-3.19,3.08,0,.96.49,2.04,1.62,2.87l2.57,1.85c.7.49.89,1.21.89,1.83,0,1.06-.66,2.21-2.08,2.21-.34,0-.64-.06-.87-.17l-1.19-1.4-1.08,1.96,2.4.47s.41.08.75.08c1.51,0,3.49-1.28,3.49-3.66M211.07,3.06l1.72,5.19h-3.51l1.79-5.19ZM208.05,11.84l.91-2.66h4.15l.87,2.66-.98.98h3.55l-1-1.02-3.91-11.53h-.64l-3.98,11.53-1.02,1.02h3.02l-.98-.98ZM194.71,12.82l2.87-9.08,2.79,9.08h.64l3.64-11.55,1.02-1h-3.02l.98.98-2.66,8.68-2.57-8.68.98-.98h-3.55l1,1,.25.83-2.4,7.83-2.57-8.68.98-.98h-3.55l1.02,1,3.53,11.55h.64ZM176.11,5.3l-.48.46.05.18h1.47c-.23,1.59-.44,2.97-.78,5.19-.48,3.3-.88,4.47-1.22,4.75-.11.11-.28.16-.44.16-.21,0-.55-.16-.78-.26-.21-.11-.39.02-.49.12-.14.16-.3.41-.3.6,0,.35.46.53.76.53.34,0,1.18-.28,1.94-1.22.6-.74,1.41-2.45,2.1-6.45.12-.74.27-1.48.57-3.43l1.8-.18.39-.46h-2.08c.53-3.27.97-4.26,1.73-4.26.53,0,.97.21,1.36.58.12.12.32.12.49-.02.14-.12.35-.41.35-.65.02-.35-.46-.74-1.06-.74-1.03,0-2.1.6-2.84,1.48-.69.83-1.15,2.17-1.4,3.6h-1.15ZM168.16,9.93c0-2.61,1.32-4.03,1.87-4.26.16-.07.41-.14.58-.14.88,0,1.4.67,1.4,2.03.04,2.3-1.17,4.38-1.91,4.63-.14.05-.37.12-.55.12-.99,0-1.4-1.06-1.4-2.38M171.18,4.88c-.46,0-1.18.21-1.91.64-1.22.72-2.54,2.37-2.54,4.84,0,1.24.58,2.62,2.23,2.62.78,0,1.89-.51,2.63-1.18,1.17-1.06,1.85-2.88,1.85-4.45,0-1.47-.78-2.46-2.26-2.46M150.71,1.28l3.17,5.72v4.83l-1,1h3.38l-1-1v-4.83l3.23-5.7,1.04-1.02h-3.1l.98.98-2.64,4.7-2.51-4.7.98-.98h-3.55l1.02,1ZM144.1,11.82V1.21h2.38l1.34,1.34V.28h-8.83v2.28l1.36-1.34h2.36v10.61l-.98,1h3.36l-1-1ZM132.72.28l1,1v10.55l-1,1h3.38l-1-1V1.28l1-1h-3.38ZM129.08,9.34c0-1.23-.58-2-1.17-2.4l-2.55-1.85c-.91-.66-1.38-1.51-1.38-2.15,0-1.32,1.13-1.79,1.81-1.79.36,0,.62.15.81.15l1.11,1.19,1.17-1.74-2.49-.47c-.17-.04-.28-.06-.6-.06-2.19,0-3.19,1.87-3.19,3.08,0,.96.49,2.04,1.62,2.87l2.57,1.85c.7.49.89,1.21.89,1.83,0,1.06-.66,2.21-2.08,2.21-.34,0-.64-.06-.87-.17l-1.19-1.4-1.08,1.96,2.4.47s.4.08.74.08c1.51,0,3.49-1.28,3.49-3.66M112.96,1.21h1.53c1.34,0,2.4,1.15,2.4,2.51s-1.09,2.32-2.4,2.32h-1.53V1.21ZM112.96,11.82v-4.85h1.89l3.04,5.85h2.08l-.98-1-2.81-5.15c1.4-.42,2.36-1.74,2.36-2.93,0-2.13-1.98-3.47-4.06-3.47h-3.89l.98,1v10.55l-.98,1h3.36l-1-1ZM107.33,12.82v-2.3l-1.34,1.36h-3.81v-5.27h2.83l1,1v-2.93l-1,1h-2.83V1.21h3.81l1.34,1.34V.28h-7.51l.98,1v10.55l-.98,1h7.51ZM91.06.28h-3.55l1.02,1,3.53,11.55h.64l3.64-11.55,1.02-1h-3.02l.98.98-2.66,8.68-2.57-8.68.98-.98ZM81.32.28l1,1v10.55l-1,1h3.38l-1-1V1.28l1-1h-3.38ZM69.64,11.74V2.34l6.73,10.48h.44V1.36l1.08-1.08h-3.28l1.08,1.08v7.97L70.05.28h-2.59l1.06,1.08v10.38l-1.06,1.08h3.28l-1.08-1.08ZM55.52,9.46c0,2.06,1.74,3.64,3.89,3.64s4.06-1.51,4.06-3.64V1.36l1.06-1.08h-3.27l1.08,1.08v8.1c0,1.45-1.15,2.6-2.59,2.6s-2.76-1.13-2.76-2.6V1.36l1.08-1.08h-3.64l1.09,1.08v8.1Z"/>
                        </svg>
                    </a>
                </div>
                <div class="top-bar-right">
                    <!-- Right side content -->
                </div>
            </div>
        </div>
        
        <!-- Header with full-width background -->
        <header class="header" role="banner">
        
        <div class="header-content">
             <h1 id="logo">
                <a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>">
                    <?php bloginfo('name') ?>
                </a>
            </h1>
        </div>
    </header>
    <nav class="navbar" role="navigation" aria-label="Primary navigation">
            <div class="nav-content">
                <ul class="nav-menu">
                    <?php
                // Get all pages that should show in main menu - more restrictive approach
                $all_published_pages = get_posts(array(
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'numberposts' => -1,
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                ));
                
                // Filter pages manually to ensure we only get explicitly checked ones
                $main_menu_pages = array();
                
                foreach ($all_published_pages as $page) {
                    // Get the raw meta value to check if it was explicitly set
                    $meta_value = get_post_meta($page->ID, 'show_in_main_menu', true);
                    $meta_exists = metadata_exists('post', $page->ID, 'show_in_main_menu');
                    
                    // Only include if:
                    // 1. Meta field exists (was explicitly set)
                    // 2. Meta value is 1 or "1" 
                    if ($meta_exists && ($meta_value === 1 || $meta_value === '1')) {
                        $main_menu_pages[] = $page;
                    }
                }
                
                // Get all pages to find parent-child relationships
                $all_pages = get_pages(array(
                    'sort_column' => 'menu_order',
                    'hierarchical' => 1
                ));
                
                // Build array of pages with children for dropdown indicators
                $pages_with_children = array();
                $menu_page_ids = array_map(function($page) { return $page->ID; }, $main_menu_pages);
                
                foreach ($all_pages as $page) {
                    if ($page->post_parent != 0) {
                        // Only mark as having children if the parent is in our menu
                        if (in_array($page->post_parent, $menu_page_ids)) {
                            // Check if this child should also be shown (for level 2)
                            $show_child = get_field('show_in_main_menu', $page->ID);
                            if ($show_child) {
                                $pages_with_children[$page->post_parent] = true;
                            }
                        }
                    }
                }
                
                // Create include array with only pages that should show in menu and their eligible children
                $include_pages = array();
                foreach ($main_menu_pages as $page) {
                    $include_pages[] = $page->ID;
                    
                    // Add children if they also have show_in_main_menu checked (level 2 only)
                    $children = get_children(array(
                        'post_parent' => $page->ID,
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    ));
                    
                    foreach ($children as $child) {
                        $show_child = get_field('show_in_main_menu', $child->ID);
                        if ($show_child) {
                            $include_pages[] = $child->ID;
                        }
                    }
                }
                
                if (!empty($include_pages)) {
                    wp_list_pages(array(
                        'title_li' => '',
                        'walker' => new CoEnv_Top_Nav_Walker(),
                        'depth' => 2,
                        'sort_column' => 'menu_order',
                        'include' => implode(',', $include_pages),
                        'pages_with_children' => $pages_with_children
                    ));
                }
                ?>
                </ul>
                
                <!-- Search toggle -->
                <button class="search-toggle" aria-label="Toggle search form" aria-expanded="false">
                    <span class="dashicons dashicons-search" aria-hidden="true"></span>
                </button>
                
                <!-- Mobile menu toggle -->
                <button class="mobile-menu-toggle" aria-label="Toggle navigation menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </nav>
        
        <!-- Search form overlay -->
        <div class="search-overlay" id="search-overlay" aria-hidden="true">
            <div class="search-container">
                <button class="search-close" aria-label="Close search form">
                    <span class="dashicons dashicons-no-alt" aria-hidden="true"></span>
                </button>
                <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                    <label for="search-field" class="screen-reader-text">Search for:</label>
                    <input type="search" id="search-field" class="search-field" placeholder="Search..." value="<?php echo get_search_query(); ?>" name="s" />
                    <button type="submit" class="search-submit" aria-label="Submit search">
                        <span class="dashicons dashicons-search" aria-hidden="true"></span>
                    </button>
                </form>
            </div>
        </div>