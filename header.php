<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php coenv_title() ?></title>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="title" content="<?php bloginfo('name'); ?>">
        
        <!--[if lt IE 8]>
            <link rel='stylesheet' id='screen-css'  href='<?php echo get_template_directory_uri() ?>/assets/styles/build/lt-ie8.css?<?php echo time(); ?>' type='text/css' media='all' />
        <![endif]-->
        <!--[if gte IE 8]><!--> 
            <link rel='stylesheet' id='screen-css'  href='<?php echo get_template_directory_uri() ?>/assets/styles/build/screen.css?<?php echo time(); ?>' type='text/css' media='all' />
        <!--<![endif]-->
        
        <!--prefetching-->
        <link rel="dns-prefetch" href="//p.typekit.net">
        <link rel="dns-prefetch" href="//use.typekit.net">
        <link rel="dns-prefetch" href="//www.google-analytics.com">
        <link rel="dns-prefetch" href="//www.washington.edu">
        
        <link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/bg-wave-cut.png">
        <link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/black-white-suz.jpg">
        <link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/boundless_logo.svg">
        <link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/boundless_logo_left.svg">
        <link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/boundless_logo_right.svg">
        <link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/logo.svg">
        <link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/img/uw-footer.svg">
        <link rel="prefetch" href="<?php echo get_template_directory_uri() ?>/assets/fonts/icomoon.woff">
        <!--end prefectching-->
        
        <?php
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
            $advancedExcerpt = preg_replace( "/\r|\n/", " ", $advancedExcerpt );
            
			endif;
		 ?>
        <meta name="description" content="<?php echo $advancedExcerpt ?>"></meta>
        
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

		<script src="//www.washington.edu/static/alert.min.js" type="text/javascript"></script>
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
    <?php
        $post = get_queried_object();
    if ( has_post_thumbnail( ) ) {
        $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
        $post_title = get_the_title().' | College of the Environment';
        $post_description = $advancedExcerpt;
        $post_link = get_permalink();
        $post_image = $thumb_src[0];
    } else {
        if ( !is_404() ) {
            if(!empty(get_field('social_image', $post->ID))) {
                $post_image = get_field('social_image', $post->ID);
            } else {
                $post_image = get_template_directory_uri().'/assets/img/logo-1200x1200.png';
            }
            $post_title = get_the_title().' | College of the Environment';
            $post_description = $advancedExcerpt;
            $post_link = get_the_permalink();
        }
    }
    
    ?>
    <meta property="og:title" content="<?php echo $post_title ?>" />
    <meta property="og:description" content="<?php echo $post_description ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="<?php echo $post_link ?>" />
    <meta property="og:image" content="<?php echo $post_image ?>" />
    <meta property="og:site_name" content="<?php bloginfo('name') ?>" />
        
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
          <div class="skipnav"><a href="#main-col">Skip to main content</a> <a href="#footer">Skip to footer unit links</a></div>

        <div id="outer" class="layout-outer">

            <div id="wrapper" class="layout-wrapper">

                <nav id="top-nav">

                    <div class="container layout-container">

                        <div class="top-menu normal-top-menu">

                            <?php wp_nav_menu(array(
                                'theme_location' => 'uw-links',
                                'depth' => 1,
                                'menu_id' => 'menu-university',
                                'container' => false,
                                'fallback_cb' => false
                            )) ?> 

                            <?php wp_nav_menu(array(
                                'theme_location' => 'top-links', 
                                'depth' => 1,
                                'menu_id' => 'menu-top',
                                'container' => false, 
                                'walker' => new CoEnv_Top_Menu_Walker(),
                                'fallback_cb' => false
                            )); ?>

                            <?php get_search_form() ?>

                            <?php wp_nav_menu(array(
                                'theme_location' => 'top-buttons', 
                                'depth' => 1, 
                                'menu_id' => 'menu-buttons',
                                'container' => false,
                                'fallback_cb' => false
                            )); ?>

                        </div><!-- .top-menu -->

                    </div><!-- .container -->

                </nav><!-- #top-nav -->

                <div class="banner-wrapper"<?php if (isset( $banner )) echo ' style="background-image: url(' . $banner['url'] . ');"' ?>>

                    <div class="layout-container layout-container--header">

                        <header id="header" role="banner" class="site-header">

                            <h1 id="logo">
                                <a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>">
                                    <span><?php bloginfo('name') ?></span>
                                    <!--[if lt IE 9]>
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/logo.png" alt="UW College of the Environment Logo" />
                                    <![endif]-->
                                    <!--[if gt IE 8]><!-->
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/logo.svg" alt="UW College of the Environment Logo" />
                                    <!--<![endif]-->
                                </a>
                            </h1>

                            <div id="show-menu">
                                <button>
                                    <span>Menu</span>
                                </button>
                            </div><!-- #show-menu -->

                            <nav class="nav-main main-menu normal-menu" role="navigation">

                                <?php get_search_form() ?>
                                
                                <div class="close-mobile"><i class="icon-cross"></i></div>

                                <ul id="menu-main" class="nav-main__menu  menu">
                                    <?php 
                                    wp_list_pages( array(
                                        'depth' => 3,
                                        'walker' => new CoEnv_Main_Menu_Walker(),
                                        'title_li' => false,
                                        'sort_column' => 'menu_order'
                                    ) );
                                    ?>
                                </ul>
                            </nav>
                            
                <?php if (!($post->ID == '38568' || is_page_template('templates/future-ug-sub.php') || $post->ID == '38585' || is_page_template('templates/future-grad-sub.php') )) {
    ?>
                        </header><!-- #header -->

                    </div><!-- .container.header-container -->

                </div><!-- .banner-wrapper -->
    
    <?php
                }
                            ?>
