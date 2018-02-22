
                <footer id="footer" role="contentinfo" class="site-footer">

                    <div class="layout-container">
                        <div class="logo-headers">
                            <div class="right-college">
                                <a href="http://environment.uw.edu/" rel="home" title="UW College of the Environment"><img alt="College of the Environment Logo" src="<?php echo get_template_directory_uri() ?>/assets/img/uw-footer.svg" width="350"></a>
                            </div>
                        
                            <div class="left-college">
                               <header class="site-footer__header">
                                    <h1><span>College of the Environment</span></h1>
                                </header>
                            </div>
                        </div>
                        <div class="footer__info">
                            <p><a href="http://maps.google.com/?q=1492+NE+Boat+St" title="Google Maps link">1492 NE Boat St., Seattle, WA 98105</a></p>
                            <p><a href="mailto:<?=antispambot("coenv@uw.edu")?>" title="Send us an Email"><?php echo antispambot("coenv@uw.edu") ?></a></p>
                            <?php get_search_form() ?>
                            <?php wp_nav_menu(array(
                                'theme_location' => 'footer-top-links', 
                                'depth' => 1,
                                'menu_class' => 'top-links',
                                'container' => false, 
                                'walker' => new CoEnv_Top_Menu_Walker(),
                                'fallback_cb' => false
                            )); ?>
                        </div>

                        <nav class="footer-nav">
                            <!--<h1 class="footer-nav__title">Units and programs</h1>-->
                            <?php $footer_menu = wp_nav_menu( array(
                                'theme_location' => 'footer-units',
                                'depth' => 1,
                                'menu_class' => 'menu-footer-units',
                                'container' => false,
                                'fallback_cb' => false,
                                'echo' => false,
                            ) ); 
                            $footer_menu = substr($footer_menu, 0, -5);
                            echo $footer_menu;
                            echo '<li></li>';
                            echo '</ul>';
                            ?>
                        </nav>

                </footer><!-- #footer -->

                    <div class="uw-footer">
                        <div class="layout-container">
                            
                            <div class="be-boundless">
                                <a href="http://washington.edu/" rel="home" target="_blank"><?php include('assets/img/university-of-washington.svg'); ?><span class="visuallyhidden">University of Washington</span></a><br />
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
