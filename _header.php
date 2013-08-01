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
        <meta name="description" content="<?php echo get_option('meta_description'); ?>">

        <link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon.ico">  

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-57x57-precomposed.png">
        <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon.png">

        <script src="<?php echo get_template_directory_uri() ?>/assets/styles/src/plugins/modernizr.custom.29825.js"></script>

        <script src="//use.typekit.net/ymr3xiv.js"></script>
        <script>try{Typekit.load();}catch(e){}</script>

        <?php wp_head() ?>
        
        <!--[if lt IE 9]>
            <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/components/selectivizr/selectivizr.js"></script>
            <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/components/respond/respond.min.js"></script>
        <![endif]-->

        <?php 
            $banner = coenv_banner();
            $banner_class = $banner ? 'has-banner' : '';
        ?>
    </head>
    <body <?php body_class( $banner_class ) ?>>

        <div id="outer">

            <div id="wrapper">

                <nav id="top-nav">

                    <div class="container">

                        <nav class="top-menu normal-top-menu">

                            <?php wp_nav_menu(array(
                                'theme_location' => 'university',
                                'depth' => 1,
                                'menu_id' => 'menu-university',
                                'container' => false,
                                'fallback_cb' => false
                            )) ?>

                            <?php wp_nav_menu(array(
                                'theme_location' => 'top', 
                                'depth' => 1,
                                'menu_id' => 'menu-top',
                                'container' => false, 
                                'fallback_cb' => false
                            )); ?>

                            <?php get_search_form() ?>

                            <?php wp_nav_menu(array(
                                'theme_location' => 'buttons', 
                                'depth' => 1, 
                                'menu_id' => 'menu-buttons',
                                'container' => false,
                                'fallback_cb' => false
                            )); ?>

                        </nav><!-- .top-menu -->

                    </div><!-- .container -->

                </nav><!-- #top-nav -->

                <div class="banner-wrapper"<?php if ( $banner ) echo ' style="background-image: url(' . $banner['url'] . ');"' ?>>

                    <div class="container header-container">

                        <header id="header" role="banner">

                            <h1 id="logo">
                                <a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>">
                                    <!--[if lt IE 9]>
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/logo.png" />
                                    <![endif]-->
                                    <!--[if gt IE 8]><!-->
                                        <img src="<?php echo get_template_directory_uri() ?>/assets/img/logo.svg" />
                                    <!--<![endif]-->
                                </a>
                            </h1>

                            <div id="show-menu">
                                <button>
                                    <span>Menu</span>
                                </button>
                            </div><!-- #show-menu -->

                            <nav class="main-menu normal-menu" role="navigation">

                                <?php get_search_form() ?>

                                <?php wp_nav_menu( array(
                                    'menu' => 'main-menu',
                                    'theme_location' => 'main', 
                                    'depth' => 3,
                                    'menu_id' => 'menu-main',
                                    'container' => false,
                                    'fallback_cb' => false,
                                    'walker' => new CoEnv_Main_Menu_Walker
                                ) ); ?>
                            </nav>

                        </header><!-- #header -->

                    </div><!-- .container.header-container -->

                </div><!-- .banner-wrapper -->