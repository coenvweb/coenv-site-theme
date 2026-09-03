<?php

if ( ! function_exists( 'coenv_render_single_slice' ) ) {
    function coenv_render_single_slice( $slice ) {
        if ( ! is_array( $slice ) ) {
            return '';
        }

        $slice_type = ! empty( $slice['slice_type'] ) ? $slice['slice_type'] : '';
        $slice_image = ! empty( $slice['slice_image'] ) ? $slice['slice_image'] : '';
        $slice_title = ! empty( $slice['slice_title'] ) ? $slice['slice_title'] : '';
        $slice_description = ! empty( $slice['slice_description'] ) ? $slice['slice_description'] : '';
        $slice_numbers = ! empty( $slice['slice_numbers'] ) ? $slice['slice_numbers'] : array();
        $slice_links = ! empty( $slice['slice_links'] ) ? $slice['slice_links'] : array();
        $newsletter_signup_text = ! empty( $slice['newsletter_signup_text'] ) ? $slice['newsletter_signup_text'] : '';

        $slice_type_key = $slice_type ? strtolower( $slice_type ) : 'default';
        $slice_type_class = $slice_type ? sanitize_html_class( $slice_type_key ) : 'default';
        $is_numbers = ( 'numbers' === $slice_type_key );
        $numbers_count = is_array( $slice_numbers ) ? count( $slice_numbers ) : 0;

        $slice_link_items = array();
        if ( is_array( $slice_links ) ) {
            foreach ( $slice_links as $slice_link_row ) {
                if ( ! is_array( $slice_link_row ) || empty( $slice_link_row['slice_link'] ) || ! is_array( $slice_link_row['slice_link'] ) ) {
                    continue;
                }

                $slice_link = $slice_link_row['slice_link'];
                $link_url = ! empty( $slice_link['url'] ) ? $slice_link['url'] : '';
                $link_text = ! empty( $slice_link['title'] ) ? $slice_link['title'] : '';
                $link_target = ! empty( $slice_link['target'] ) ? $slice_link['target'] : '';

                if ( $link_url && $link_text ) {
                    $slice_link_items[] = array(
                        'url' => $link_url,
                        'text' => $link_text,
                        'target' => $link_target,
                    );
                }
            }
        }

        $slice_links_count = count( $slice_link_items );
        $slice_has_multi_links = ( $slice_links_count > 1 );
        $slice_has_single_link = ( 1 === $slice_links_count );
        $slice_multi_links_class = $slice_has_multi_links ? ' slice-multi-links' : '';

        $image_url = '';
        if ( ! empty( $slice_image ) ) {
            $image_url = is_array( $slice_image ) && ! empty( $slice_image['url'] ) ? $slice_image['url'] : $slice_image;
        }

        $slice_has_bg = (bool) $image_url;
        $slice_bg_class = $slice_has_bg ? 'slice-has-bg' : 'slice-no-bg';

        $slice_style_rules = array();
        if ( $slice_has_bg ) {
            $slice_style_rules[] = "background-image: url('" . esc_url( $image_url ) . "')";
        }
        if ( $is_numbers && $numbers_count > 0 ) {
            $slice_style_rules[] = '--slice-columns: ' . intval( $numbers_count );
        }

        $slice_style = $slice_style_rules ? ' style="' . esc_attr( implode( '; ', $slice_style_rules ) ) . ';"' : '';
        $link_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 55.09 55.09" aria-hidden="true" focusable="false"><circle cx="27.55" cy="27.55" r="26.05" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><polyline points="29.52 37.68 40.72 27.55 29.52 17.41" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><line x1="39.27" y1="27.55" x2="15.37" y2="27.55" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>';

        ob_start();
        ?>
        <article class="slice slice-full-width <?php echo esc_attr( $slice_bg_class ); ?> slice-<?php echo esc_attr( $slice_type_class . $slice_multi_links_class ); ?>"<?php echo $slice_style; ?>>
            <div class="slice-content container">
                <?php if ( $slice_title ) : ?>
                    <h3 class="slice-title"><?php echo esc_html( $slice_title ); ?></h3>
                <?php endif; ?>

                <?php if ( ! $slice_has_multi_links && ( $slice_description || $slice_has_single_link ) ) : ?>
                    <div class="slice-description-area">
                        <?php if ( $slice_description ) : ?>
                            <p class="slice-description"><?php echo esc_html( $slice_description ); ?></p>
                        <?php endif; ?>
                        <?php if ( $slice_has_single_link ) :
                            $inline_link = $slice_link_items[0];
                            $inline_target = ! empty( $inline_link['target'] ) ? $inline_link['target'] : '';
                        ?>
                            <a class="slice-link slice-link-inline" href="<?php echo esc_url( $inline_link['url'] ); ?>"<?php echo $inline_target ? ' target="' . esc_attr( $inline_target ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $inline_link['text'] ); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $slice_has_multi_links && $slice_description ) : ?>
                    <p class="slice-description"><?php echo esc_html( $slice_description ); ?></p>
                <?php endif; ?>

                <?php if ( $is_numbers && $numbers_count > 0 ) : ?>
                    <ul class="slice-number-list">
                        <?php foreach ( $slice_numbers as $fact ) :
                            $fact_number = '';
                            $fact_text = '';

                            if ( is_array( $fact ) ) {
                                $fact_number = ! empty( $fact['number_value'] ) ? $fact['number_value'] : '';
                                $fact_text = ! empty( $fact['number_label'] ) ? $fact['number_label'] : '';
                            }
                        ?>
                            <?php if ( $fact_number || $fact_text ) : ?>
                                <li class="slice-number-item">
                                    <?php if ( $fact_number ) : ?>
                                        <span class="slice-number-value"><?php echo esc_html( $fact_number ); ?></span>
                                    <?php endif; ?>
                                    <?php if ( $fact_text ) : ?>
                                        <span class="slice-number-label"><?php echo esc_html( $fact_text ); ?></span>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( $slice_has_multi_links ) : ?>
                    <ul class="slice-links">
                        <?php foreach ( $slice_link_items as $slice_link_item ) :
                            $link_target = ! empty( $slice_link_item['target'] ) ? $slice_link_item['target'] : '';
                        ?>
                            <li>
                                <a class="slice-link" href="<?php echo esc_url( $slice_link_item['url'] ); ?>"<?php echo $link_target ? ' target="' . esc_attr( $link_target ) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html( $slice_link_item['text'] ); ?><?php echo $link_svg; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php if ( 'Events and Newsletter' === $slice_type ) : ?>
                    <div class="slice-events">
                        <h3 class="slice-events-newsletter-title">Events</h3> <a class="more-events right button" href="http://environment.uw.local/alumni-and-community/calendar-events/">See all events &raquo;</a>
                        <?php the_widget( 'CoEnv_Widget_Events', array( 'feed_url' => 'https://www.trumba.com/calendars/featuredevents-1.rss', 'posts_per_page' => 3 ) ); ?>
                    </div>
                    <div class="slice-newsletter">
                        <div class="newsletter-title-area">
                            <h3 class="slice-events-newsletter-title">Newsletter</h3>
                            <p><?php echo esc_html( $newsletter_signup_text ); ?></p>
                        </div>
                        <div class="newsletter-signup-form">
                            <?php echo do_shortcode( '[mkto_signup subID=378]' ); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </article>
        <?php

        return ob_get_clean();
    }
}

if ( ! function_exists( 'coenv_render_slices' ) ) {
    function coenv_render_slices( $post_id = 0, $slice_id = 0 ) {
        $post_id = $post_id ? absint( $post_id ) : get_the_ID();
        if ( ! $post_id ) {
            return '';
        }

        $slices = get_field( 'slices', $post_id );
        if ( ! is_array( $slices ) || empty( $slices ) ) {
            return '';
        }

        if ( $slice_id > 0 ) {
            $slice_index = $slice_id - 1;
            if ( ! isset( $slices[ $slice_index ] ) ) {
                return '';
            }

            return coenv_render_single_slice( $slices[ $slice_index ] );
        }

        $output = '<section class="container-slices">';
        foreach ( $slices as $slice ) {
            $output .= coenv_render_single_slice( $slice );
        }
        $output .= '</section>';

        return $output;
    }
}

if ( ! function_exists( 'coenv_slice_shortcode' ) ) {
    function coenv_slice_shortcode( $atts = array() ) {
        $a = shortcode_atts(
            array(
                'id' => 0,
                'post_id' => 0,
            ),
            $atts,
            'slice'
        );

        $slice_id = absint( $a['id'] );
        $post_id = absint( $a['post_id'] );

        $output = coenv_render_slices( $post_id, $slice_id );
        if ( ! $output ) {
            return '';
        }

        if ( $slice_id > 0 ) {
            return '<div class="container-slices container-slices-shortcode">' . $output . '</div>';
        }

        return str_replace(
            'class="container-slices"',
            'class="container-slices container-slices-shortcode"',
            $output
        );
    }

    add_shortcode( 'slice', 'coenv_slice_shortcode' );
}