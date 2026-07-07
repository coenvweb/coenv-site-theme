<!DOCTYPE html>
<html <?php language_attributes(); ?>>
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
<link rel="stylesheet" id="screen-css" href="<?php echo get_template_directory_uri(); ?>/assets/styles/build/screen.css?<?php echo time(); ?>" type="text/css" media="all" />

<!-- Resource hints for performance -->
<link rel="dns-prefetch" href="//use.typekit.net">
<link rel="preconnect" href="https://www.googletagmanager.com">
<link rel="preconnect" href="https://www.washington.edu">
        
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

<?php wp_head(); ?>

<?php 
    if ( !is_404() ) {
        $banner = coenv_banner();
        $banner_class = $banner ? 'has-banner' : '';
        $banner_class .= ' template-print';
    }
?>

</head>
    
<body <?php body_class(); ?>>
    <div class="skipnav">
        <a href="#main-col" class="skip-link">Skip to main content</a>
        <a href="#footer" class="skip-link">Skip to footer unit links</a>
    </div>

	<div id="outer" class="layout-outer">

            <div id="wrapper" class="layout-wrapper">

                <div class="uw-header">

                    <div class="container layout-container">

                        <div class="uw-header__logo">
                            <a href="https://www.washington.edu/" title="University of Washington" rel="home">
                                <img src="<?php echo get_template_directory_uri() ?>/assets/img/university-of-washington.svg" alt="University of Washington Logo" />
                            </a>
                        </div>

                    </div><!-- .container -->

                </nav>

                <div class="site-header">

                        <header id="header" role="banner" class="site-header">

                            <div class="container layout-container site-name-header">
                                <div class="logo-area">

                                    <h1 id="logo">
                                        <a href="<?php bloginfo('url') ?>" rel="home" title="<?php bloginfo('name') ?>">
                                            <?php include_once( get_template_directory() . '/assets/img/W.svg' ); ?>
                                            <span class="college-small">College of the</span>
                                            <span class="college-large">Environment</span>
                                        </a>
                                    </h1>

                                </div>

                                <div class="top-menu-area">
                                    <div id="show-menu">
                                        <button>
                                            <span>Menu</span>
                                        </button>
                                    </div><!-- #show-menu -->

                                    <nav aria-label="secondary" class="nav-secondary" role="navigation">
                                        
                                        <ul id="menu-top" class="top-menu  menu">
                                            <?php wp_nav_menu(array(
                                                'theme_location' => 'top-links', 
                                                'depth' => 1,
                                                'menu_id' => 'menu-top',
                                                'container' => false, 
                                                'walker' => new CoEnv_Top_Menu_Walker(),
                                                'fallback_cb' => false
                                            )); ?>
                                        </ul>

                                        <button class="search-toggle" type="button" aria-expanded="false" aria-controls="header-search-form" aria-label="Toggle site search">
                                            <i class="icon-search" aria-hidden="true"></i>
                                            <span>Search</span>
                                        </button>

                                        <div id="header-search-form" class="search-form-wrapper" aria-hidden="true">
                                            <?php get_search_form() ?>
                                        </div>
                                        
                                        <div class="close-mobile"><i class="icon-cross"></i></div>

                                    </nav>  
                                </div><!-- .top-menu-area -->

                            </div><!-- .container -->

                    </div>

                        <div class="menu-header">

                            <div class="container">

                                <nav aria-label="primary" class="nav-main main-menu normal-menu" role="navigation">

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
                            </div><!-- .container -->

                        </div>

                <div class="banner-wrapper"<?php if (!empty( $banner )) echo ' style="background-image: url(' . $banner['url'] . ');"' ?> >

                    
                <?php if (!(is_front_page())) { echo '</div> </header>'; } ?>