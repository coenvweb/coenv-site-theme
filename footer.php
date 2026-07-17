
                <footer id="footer" role="contentinfo" class="site-footer">

                    <div class="layout-container">

                        <div class="footer-social-address">
                            <p><a href="http://maps.google.com/?q=1492+NE+Boat+St" title="Google Maps link">1492 NE Boat St., Seattle, WA 98105</a></p>
                            <p><a href="mailto:<?=antispambot("coenv@uw.edu")?>" title="Send us an Email"><?php echo antispambot("coenv@uw.edu") ?></a> | <a href="tel:<?=antispambot("206-685-5410")?>" title="Call us">206-685-5410</a></p>
                            <p><a href="/intranet" title="Intranet">Intranet</a> | <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Staff Login</a></p>
                        </div>

                        <div class="footer-logo-links">
                            <div class="footer-social">
                                <a href="https://environment.uw.edu/" rel="home" title="UW College of the Environment"><img alt="College of the Environment Logo" src="<?php echo get_template_directory_uri() ?>/assets/img/uw-footer.svg" width="350" height="39"></a>
                            </div>
                        </div>

                        <div class="footer-end-row">
                            <div class="copyright"><p>&copy; <?php echo date('Y') ?> <a href="http://washington.edu/" target="_blank">University of Washington, College of the Environment</a></p></div>
                            <div class="uw-links right"><p><a href="http://washington.edu/privacy/" target="_blank">Privacy</a> | <a href="http://washington.edu/terms/" target="_blank">Terms</a> | <a href="http://washington.edu/link-policy/" target="_blank">Link Policy</a> | <a href="http://environment.uw.edu/intranet/report/" target="_blank">Intranet</a></p></div>
                        </div>

                    </div>

                </footer><!-- #footer -->
                    
            </div><!-- #wrapper -->

        </div><!-- #outer -->

        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        
        <?php wp_footer() ?>
    </body>
</html>
