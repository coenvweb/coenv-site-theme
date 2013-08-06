
                <footer id="footer" role="contentinfo" class="site-footer">

                    <div class="layout-container">

                        <header class="footer__header">
                            <h1><span>University of Washington College of the Environment</span></h1>
                        </header>

                        <nav id="footer-nav">
                            <?php wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'depth' => 2,
                                'menu_id' => 'menu-footer',
                                'container' => false,
                                'fallback_cb' => false
                            )) ?>
                        </nav><!-- #footer-nav -->

                        <nav id="bottom-links">

                            <?php wp_nav_menu(array(
                                'theme_location' => 'footer-links',
                                'depth' => 2,
                                'menu_id' => 'menu-footer-links',
                                'container' => false,
                                'fallback_cb' => false
                            )) ?>

                            <?php wp_nav_menu(array(
                                'theme_location' => 'footer-units',
                                'depth' => 2,
                                'menu_id' => 'menu-footer-units',
                                'container' => false,
                                'fallback_cb' => false
                            )) ?>
                        </nav>

                        <p class="copyright">&copy; <?php echo date('Y') ?> <a href="http://www.washington.edu/">University of Washington</a></p>

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