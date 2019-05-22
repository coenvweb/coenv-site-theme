<?php
/*
 * Template Name: Cambodia Signature Story
 * Template Post Type: post
 */
  
get_header();

$banner = coenv_banner();
?>

<style type="text/css">
 .element a {
    color: <?php echo get_field('accent_color'); ?>;
     font-weight: 600;
 }
</style>
<script defer src="https://maps.googleapis.com/maps/api/js?key=***REMOVED***"></script>

<section id="blog" role="main" class="template-signature-story">

			<main id="main-col" class="main-col">
          
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

            <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

              <header class="article__header" id="#share-<?php the_ID() ?>">
                  <div class="article__title">
                      <h1 class="big__title">Fueled by floods:</h1>
                      <p class="subtitle">The Cambodian People's Food Security is Threatened by Hydropower Demands</p>
                  </div>
              </header>
                
                <div class="waves"></div><!-- waves -->
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


                <footer id="footer" role="contentinfo" class="site-footer">

                    <div class="layout-container">
                        <div class="colleges-schools">
                            <a href="http://environment.uw.edu/" rel="home" title="UW College of the Environment" class="environment"><img alt="College of the Environment Logo" src="<?php echo get_template_directory_uri() ?>/assets/img/mekong/Logo-Environment.svg"></a>
                            <a href="https://www.engr.washington.edu/" rel="home" title="UW College of Engineering"><img alt="College of Engineering Logo" src="<?php echo get_template_directory_uri() ?>/assets/img/mekong/Logo-Engineering.svg"></a>
                            <a href="https://sph.washington.edu/" rel="home" title="UW School of Public Health"><img alt="School of Public Health Logo" src="<?php echo get_template_directory_uri() ?>/assets/img/mekong/Logo-PublicHealth.svg"></a>
                        </div>
                    </div>

                </footer><!-- #footer -->

                    <div class="uw-footer">
                        <div class="layout-container">
                            
                            <div class="be-boundless">
                                <a href="http://washington.edu/" rel="home" target="_blank"><?php include( $_SERVER['DOCUMENT_ROOT'] . 'wp-content/themes/coenv-wordpress-theme/assets/img/university-of-washington.svg'); ?><span class="visuallyhidden">University of Washington</span></a><br />
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

