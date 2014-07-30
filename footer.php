
                <footer id="footer" role="contentinfo" class="site-footer">

                    <div class="layout-container">

                        <header class="site-footer__header">
                            <h1><span>University of Washington College of the Environment</span></h1>
                        </header>

                        <div class="footer__info">
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
                            <?php wp_nav_menu( array(
                                'theme_location' => 'footer-units',
                                'depth' => 1,
                                'menu_class' => 'menu-footer-units',
                                'container' => false,
                                'fallback_cb' => false
                            ) ) ?>
                        </nav>

                        <div class="uw-footer">
                            <p class="copyright">&copy; <?php echo date('Y') ?> <a href="http://www.washington.edu/">University of Washington</a></p>

                            <?php wp_nav_menu( array(
                                'theme_location' => 'footer-links',
                                'depth' => 1,
                                'menu_class' => 'menu-footer-links',
                                'container' => false,
                                'fallback_cb' => false
                            ) ) ?>
                        </div>

                    </div><!-- .container -->

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