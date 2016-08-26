<?php get_template_part("template-parts/carousel_partners"); ?>

<!-- Start Footer -->
<footer id="footer-wrapper">

       <div id="footer" class="container">

                <div class="row">

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-first-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-second-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="clearfix visible-tablet"></div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-third-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-fourth-column' ) ) : ?>
                            <?php endif; ?>
                        </div>
                </div>

       </div>

        <!-- Footer Bottom -->
        <div id="footer-bottom" class="container">

                <div class="row">
                        <div class="span6">
                            <?php
                            $copyright_text = get_option('theme_copyright_text');
                            echo ( $copyright_text ) ? '<p class="copyright">'.$copyright_text.'</p>' : '';
                            ?>
                        </div>
                        <div class="span6">
                            <?php
                            $designed_by_text = get_option('theme_designed_by_text');
                            echo ( $designed_by_text ) ? '<p class="designed-by">'.$designed_by_text.'</p>' : '';
                            ?>
                        </div>
                </div>

        </div>
        <!-- End Footer Bottom -->

</footer><!-- End Footer -->

<?php
if( !is_user_logged_in() ){
    get_template_part('template-parts/modal-login');
}
?>

<a href="#top" id="scroll-top"><i class="fa fa-chevron-up"></i></a>

<?php wp_footer(); ?>




</body>
</html>