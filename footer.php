
                <footer id="footer" role="contentinfo">

                    <div class="container">

                        <header>
                            <h1><span>Explore the College of the Environment</span></h1>
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
                            <p class="copyright">&copy; <?php echo date('Y') ?> <a href="http://www.washington.edu/">University of Washington</a></p>

                            <?php wp_nav_menu(array(
                                'theme_location' => 'bottom',
                                'depth' => 2,
                                'menu_id' => 'menu-bottom',
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