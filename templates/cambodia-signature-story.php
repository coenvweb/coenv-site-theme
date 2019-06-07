<?php
/*
 * Template Name: Cambodia Signature Story
 * Template Post Type: post
 */
?>
  
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
                               
<!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/bower_components/selectivizr/selectivizr.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/bower_components/respond/respond.min.js"></script>
<![endif]-->

<?php
        $mini_header = true;
        $banner_class .= ' mini-header';
?>

</head>
    
<body <?php if (isset( $banner_class )) { body_class( $banner_class ); } else { body_class(); }; ?>>
    <div id="outer" class="layout-outer">
      <div class="skipnav"><a href="#main-col">Skip to main content</a> <a href="#footer">Skip to footer unit links</a></div>
        <header class="mini-top-menu" role="banner">
            <div class="mini-top-menu-inner">
            <h1 id="logo">
                <a href="http://washington.edu/" rel="home" target="_blank">
                    <svg id="desktop-logo" width="108" height="73" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 108 73" enable-background="new 0 0 108 73" xml:space="preserve">
                  <path d="M79.343,0.112c0,0.858,0,12.238,0,13.098c0.856,0,9.206,0,9.206,0L78.271,51.461
                    c0,0-12.577-50.636-12.756-51.349c-0.687,0-12.626,0-13.303,0c-0.188,0.696-13.796,51.352-13.796,51.352L28.95,13.21
                    c0,0,8.726,0,9.585,0c0-0.859,0-12.239,0-13.098c-0.919,0-37.532,0-38.451,0c0,0.858,0,12.238,0,13.098c0.851,0,8.52,0,8.52,0
                    s14.703,58.809,14.88,59.522c0.708,0,19.942,0,20.639,0c0.183-0.697,9.852-37.454,9.852-37.454s9.188,36.747,9.364,37.454
                    c0.707,0,19.941,0,20.639,0C84.164,72.03,99.635,13.21,99.635,13.21s7.6,0,8.449,0c0-0.859,0-12.239,0-13.098
                    C107.176,0.112,80.251,0.112,79.343,0.112z"/>
                </svg><?php include( $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/coenv-wordpress-theme/assets/img/university-of-washington.svg'); ?><span class="visuallyhidden">University of Washington</span></a>
            </h1>
                <nav role="navigation">
                    <ul class="navigator">
                        <li class="navigator-link"><a href="#section-introduction">Introduction</a></li>
                        <li class="navigator-link"><a href="#section-the-forecast-for-fish">Fish</a></li>
                        <li class="navigator-link"><a href="#section-relying-on-rice">Rice</a></li>
                        <li class="navigator-link"><a href="#section-assessing-nutritional-needs">Nutrition</a></li>
                        <li class="navigator-link"><a href="#section-optimal-hydropower-operations">Hydropower</a></li>
                        <li class="navigator-link"><a href="#section-a-call-for-collaboration">Collaboration</a></li>
                    </ul>
                </nav>
            </div>
        </header>

<style type="text/css">
 .element a {
    color: <?php echo get_field('accent_color'); ?>;
     font-weight: 600;
 }
</style>
<script defer src="https://maps.googleapis.com/maps/api/js?key=***REMOVED***"></script>

<section id="blog" class="template-signature-story">

			<main id="main-col" role="main" class="main-col">
          
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

            <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
            
                <div id="section-video" class="feature homepage-hero-module scrollTo">
                    <div class="feature-image video-container banner-wrapper">
                    <div class="filter"></div>
                        <?php
                            echo '<video autoplay loop muted class="fillWidth fullfade show-for-medium-up" id="hero-video" poster="https://coenv-media-gene1ufvxiloffjq.stackpathdns.com/2018/05/20190114_CAMBODIA-FISH-C-OF-E_02263-e1559260230602.jpg">';
                            echo '<source src="' . get_bloginfo('template_directory') . '/assets/video/mekong-looper-720.mp4" type="video/mp4" />Your browser does not support the video tag. I suggest you upgrade your browser.';
                            echo '<source src="' . get_bloginfo('template_directory') . '/assets/video/mekong-video-720.webm" type="video/webm" />Your browser does not support the video tag. I suggest you upgrade your browser.';
                            echo '<source src="' . get_bloginfo('template_directory') . '/assets/video/mekong-video-720.ogg" type="video/ogg"/>Your browser does not support the video tag. I suggest you upgrade your browser.';
                            echo '</video>';
                         ?>
                        <div class="poster poster-hidden">
                            <?php
                            echo '<img src="https://coenv-media-gene1ufvxiloffjq.stackpathdns.com/2018/05/20190114_CAMBODIA-FISH-C-OF-E_02263-e1559260230602.jpg" alt="">';
                             ?>
                        </div>
                        <div class="layout-container layout-container--header">

                    </div><!-- .container.header-container -->

                    <div class="feature-info-container">
                        <button class="play-pause-hero right show-for-medium-up" tabindex="0" title="pause or play header video"></button>
                  </div><!-- .feature-info-container -->
                  </div>
                <div class="waves"></div><!-- waves -->
            </div>

              <div class="article__header" id="#share-<?php the_ID() ?>">
                  <div class="article__title">
                      <h1 class="big__title">Fueled by floods:</h1>
                      <p class="subtitle">The Cambodian People's Food Security is Threatened by Hydropower Demands</p>
                  </div>
              </div>
                
                <div id="section-introduction" class="scrollto">

              <section class="article__content">

                <?php the_content() ?>

              </section>

            </article><!-- .article -->

					<?php endwhile ?>

				<?php endif ?>
                
			</main><!-- .main-col -->

		</div><!-- .container -->

	</section><!-- #blog -->


                <footer id="footer" role="contentinfo" class="site-footer scrollTo">

                    <div class="layout-container">
                        <div class="colleges-schools">
                            <a href="http://environment.uw.edu/" rel="home" title="UW College of the Environment" class="environment"><img alt="College of the Environment Logo" src="<?php echo get_template_directory_uri() ?>/assets/img/mekong/Logo-Environment.svg"></a>
                            <a href="https://www.engr.washington.edu/" rel="home" title="UW College of Engineering" class="engineering"><img alt="College of Engineering Logo" src="<?php echo get_template_directory_uri() ?>/assets/img/mekong/Logo-Engineering.svg"></a>
                            <a href="https://sph.washington.edu/" rel="home" title="UW School of Public Health" class="public-health"><img alt="School of Public Health Logo" src="<?php echo get_template_directory_uri() ?>/assets/img/mekong/Logo-PublicHealth.svg"></a>
                        </div>
                    </div>

                    <div class="uw-footer scrollTo">
                        <div class="layout-container">
                            
                            <div class="be-boundless">
                                <a href="http://washington.edu/" rel="home" target="_blank"><?php include( $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/coenv-wordpress-theme/assets/img/university-of-washington.svg'); ?><span class="visuallyhidden">University of Washington</span></a><br />
                                <a href="http://www.washington.edu/boundless/" rel="home" target="_blank"><img class="boundless-logo" src='<?= get_template_directory_uri() ?>/assets/img/boundless_logo.png' alt="University of Washington - Be Boundless for Washington for the World" /><span class="visuallyhidden">Be Boundless - For Washington For the World</span></a>
                            </div>
                            
                            <div class="copyright"><p>&copy; <?php echo date('Y') ?> <a href="http://washington.edu/" target="_blank">University of Washington</a></p></div>
                            
                            <?php wp_nav_menu( array(
                                'theme_location' => 'footer-links',
                                'depth' => 1,
                                'menu_class' => 'menu-footer-links',
                                'container' => false,
                                'fallback_cb' => false
                            ) ) ?>
                        </div>
                    </div>
                </footer><!-- #footer -->
                    
            </div><!-- #wrapper -->

        </div><!-- #outer -->

        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <?php wp_footer() ?>

        <?php if (!WP_LOCAL_DEV): ?>
            <script>
							(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
							(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
							m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
							})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

							ga('create', 'UA-42374937-1', 'auto');
							ga('require', 'linkid', 'linkid.js');
							ga('send', 'pageview');
                            ga('set', 'anonymizeIp', true);

						</script>
						<script type="text/javascript">
							try{
							(function() {
							var afterPrint = function() { ga('send', 'event', 'Print Intent', document.location.pathname); };
							if (window.matchMedia) {
							var mediaQueryList = window.matchMedia('print');
							mediaQueryList.addListener(function(mql) {
							if (!mql.matches)
							afterPrint();
							});
							}
							window.onafterprint = afterPrint;
							}());
							} catch(e) {}
						</script>
        <?php endif; ?>
    </body>
</html>

