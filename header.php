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
        <meta name="description" content="<?php
		wp_reset_query();   
		if (have_posts()) : while(have_posts()) the_post();
			if (is_singular('faculty')) {
				$advancedExcerpt = strip_tags(get_field('biography'));
			} elseif (is_post_type_archive( 'faculty' )) {		
				$advancedExcerpt = 'Our world-class faculty are at the center of our work at The UW College of the Environment.';
			} elseif (is_singular()&&is_front_page()==false ) {
				$advancedExcerpt = strip_tags(get_the_excerpt());
			} else {
				$advancedExcerpt = get_option('meta_description');
			}
			endif;
		echo $advancedExcerpt ?>">

        <link rel="shortcut icon" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon.ico">  

        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-144x144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-114x114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-72x72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon-57x57-precomposed.png">
        <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri() ?>/assets/img/apple-touch-icon.png">

        <script src="<?php echo get_template_directory_uri() ?>/assets/scripts/src/plugins/modernizr.custom.92408.js"></script>
        <script type="text/javascript" src="//use.typekit.net/dyq8fxo.js"></script>
		<script src="//www.washington.edu/static/alert.js" type="text/javascript"></script>
        <script type="text/javascript">try{Typekit.load();}catch(e){}</script>

        <!--[if lt IE 8]>
            <link rel='stylesheet' id='screen-css'  href='<?php echo get_template_directory_uri() ?>/assets/styles/build/lt-ie8.css?20130930' type='text/css' media='all' />
        <![endif]-->
        <!--[if gte IE 8]><!--> 
            <link rel='stylesheet' id='screen-css'  href='<?php echo get_template_directory_uri() ?>/assets/styles/build/screen.css' type='text/css' media='all' />
        <!--<![endif]-->

        <?php wp_head() ?>
		
<?php
		$post = get_queried_object();
	if ( has_post_thumbnail( $post->ID ) ) {
		$thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
		$post_title = get_the_title().' | College of the Environment';
		$post_description = $advancedExcerpt;
		$post_link = get_permalink();
		$post_image = $thumb_src[0];
	} else {
		$post_title = get_the_title().' | College of the Environment';
		$post_description = $advancedExcerpt;
		$post_link = get_the_permalink();
		$post_image = get_template_directory_uri().'/assets/img/logo-1200x1200.png';
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
            $banner = coenv_banner();
            $banner_class = $banner ? 'has-banner' : '';
            $banner_class .= ' template-print';
        ?>
    </head>
    <body <?php body_class( $banner_class ) ?>>
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

                <div class="banner-wrapper"<?php if ( $banner ) echo ' style="background-image: url(' . $banner['url'] . ');"' ?>>

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

                                <ul id="menu-main" class="nav-main__menu  menu">
                                    <?php 
                                    wp_list_pages( array(
                                        'depth' => 3,
                                        'walker' => new CoEnv_Main_Menu_Walker(),
                                        'title_li' => false,
                                        'sort_column' => 'menu_order, post_title'
                                    ) );
                                    ?>
                                </ul>
                            </nav>

                        </header><!-- #header -->

                    </div><!-- .container.header-container -->

                    <?php if ( isset( $banner['caption'] ) && !empty( $banner['caption'] ) ) : ?>
                        <div class="banner-info"><a href="<?php echo $banner['permalink'] ?>"><i class="icon-camera"></i>About the image</a></div>
                        <div class="banner-caption">
                            <h2><?php echo $banner['title'] ?></h2>
                            <?php echo $banner['caption'] ?>
                        </div>
                    <?php endif ?>

                </div><!-- .banner-wrapper -->