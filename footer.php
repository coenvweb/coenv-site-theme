
                <footer id="footer" role="contentinfo" class="site-footer">

                    <div class="layout-container">

                        <header class="site-footer__header">
                            <h1><span>University of Washington College of the Environment</span></h1>
                        </header>

                        <div class="footer__info">
                            <?php get_search_form() ?>
                            <p class="copyright">&copy; <?php echo date('Y') ?> <a href="http://www.washington.edu/">University of Washington</a></p>
                        </div>

                        <nav class="footer-nav">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'footer-units',
                                'depth' => 1,
                                'menu_class' => 'menu-footer-units',
                                'container' => false,
                                'fallback_cb' => false
                            )) ?>
                        </nav>

                    </div><!-- .container -->

                </footer><!-- #footer -->

            </div><!-- #wrapper -->

        </div><!-- #outer -->

        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->
        
        <?php wp_footer() ?>

        <!--
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
        -->
    </body>
</html>