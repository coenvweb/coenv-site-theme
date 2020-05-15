<?php /**
 * Set up the new field in the media module.
 *
 * @return void
 */
function additional_gallery_settings() {
  ?>

    <script type="text/html" id="tmpl-custom-gallery-setting">
        <span>Style</span>
        <select data-setting="style">
            <option value="default-style">Default Grid Style</option>
            <option value="slideshow-style">Slideshow Style</option>
        </select>
    </script>

    <script type="text/javascript">
        jQuery( document ).ready( function() {
            _.extend( wp.media.gallery.defaults, {
                style: 'default-style'
            } );

            wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend( {
                template: function( view ) {
                    return wp.media.template( 'gallery-settings' )( view )
                         + wp.media.template( 'custom-gallery-setting' )( view );
                }
            } );
        } );
    </script>

  <?php
}
add_action( 'print_media_templates', 'additional_gallery_settings' );

/**
 * HTML Wrapper - Support for a custom class attribute in the native gallery shortcode
 *
 * @param string $html
 * @param array $attr
 * @param int $instance
 *
 * @return $html
 */
function customize_gallery_abit( $html, $attr, $instance ) {

    if( isset( $attr['style'] ) && $style = $attr['style'] ) { 

        // Unset attribute to avoid infinite recursive loops
        unset( $attr['style'] );

        if ($style == 'default-style') {
            // Our custom HTML wrapper
            $html = sprintf( 
                '<div class="gallery-wrapper-%s">%s</div>',
                esc_attr( $style ),
                gallery_shortcode( $attr )
            );
        }

        if ($style == 'slideshow-style') {
            // Our custom HTML wrapper
            $html = sprintf( 
                '<div class="element-slider_gallery rsDefault gallery-wrapper-%s">%s</div>',
                esc_attr( $style ),
                gallery_shortcode( $attr )
            );
        }
        
    }

    return $html;
}
add_filter( 'post_gallery', 'customize_gallery_abit', 10, 3 );