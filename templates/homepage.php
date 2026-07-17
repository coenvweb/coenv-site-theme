<?php
/**
 * Template Name: Homepage
 */
get_header(); ?>


<div class="hero-wrapper" <?php if (!empty( $banner )) echo ' style="background-image: url(' . $banner['url'] . ');"' ?> >    
    <div class="container hero-container">
        <div class="hero-content">
            <?php if ( get_field('big_hero_text_line_1') ) : ?>
                <h2 class="hero-heading hero-heading-line-1"><?php echo get_field('big_hero_text_line_1'); ?>
            <?php endif; ?>
            <?php if ( get_field('big_hero_text_line_2') ) : ?>
                <span class="hero-heading hero-heading-line-2"><a href="<?php echo get_field('hero_link'); ?>"><?php echo get_field('big_hero_text_line_2'); ?></a></span>
            <?php endif; ?>
            </h2>
            <?php if ( get_field('hero_small_text') ) : ?>
                <p class="hero-subheading"><?php echo get_field('hero_small_text'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
</div><!-- .banner-wrapper  holdover from header.php -->
            </div>
        </header>

<?php

// Get all home page features and sort posts using post-types-order
$features = new WP_Query( array(
    'post_type' => 'post',
    'post_not_in' => array ( 110160, 110636 ),
    'posts_per_page' => 1,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'story_type',
            'field' => 'slug',
            'terms' => 'featured-story'
        )
    ),
    'orderby' => 'menu_order',
    'order' => 'ASC',
) );

$sticky = get_option( 'sticky_posts' );
if( $sticky ) {
    $post_sort = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => 2,
        'post_status' => 'publish',
        'post__not_in' => array($features->post->ID),
        'tax_query' => array(
            array(
                'taxonomy' => 'story_type',
                'field' => 'term_id',
                'terms' => array ( 7239,7240,7241,7242,7243,7274, ),
                'operator' => 'NOT IN'
            ),
        )
    ) );
}else{
    $post_sort = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post_status' => 'publish',
        'post__not_in' => array($features->post->ID),
        'tax_query' => array(
            array(
                'taxonomy' => 'story_type',
                'field' => 'term_id',
                'terms' => array ( 7239,7240,7242,7243,7244,7274, ),
                'operator' => 'NOT IN'
            )
        )
    ) );
}

?>



    <main id="main-col">

    <div class="container container-news">

        <header>

            <a class="more-news right" href="<?php echo get_permalink( get_option('page_for_posts') ) ?>">See all news &raquo;</a> <h2 class="news-heading"><a href="/news">Latest News</a></h2>

        </header>

        <section class="featured-stories">

            <?php if ( $features->have_posts() ) : ?>

                <div id="features">

                    <div class="features-container">

                        <?php while ( $features->have_posts() ) : $features->the_post() ?>

                            <?php get_template_part( 'partials/partial', 'feature' ) ?>

                        <?php endwhile;  ?>

                        <?php wp_reset_postdata(); ?>

                    </div><!-- .features-container -->

                </div><!-- #features -->

            <?php endif; ?>

            <div class="stories-container">

                <?php $page = ($post_sort->post_count + 1) / get_option('posts_per_page') + 1; ?>

                <?php if ( $post_sort->have_posts() ) : ?>

                    <div class="story-sizer"></div>

                    <?php while ( $post_sort->have_posts() ) : $post_sort->the_post(); ?>

                        <?php get_template_part( 'partials/partial', 'story' ); ?>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                <?php endif; ?>

            </div><!-- .stories-container -->

        </section><!-- #featured-stories --> 

        <div class="social-media-container">

            <div class="social-media">

                <ul class="social-media-links">
                    <?php if ( get_option('instagram') ) { ?>
                        <li>
                            <a href="<?php echo esc_url( get_option('instagram') ); ?>" target="_blank" rel="noopener noreferrer" title="Follow <?php bloginfo('name'); ?> on Instagram">
                                <span class="visuallyhidden">Instagram</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34" aria-hidden="true" focusable="false">
                                    <path d="M16 2.881c4.275 0 4.781 0.019 6.462 0.094 1.563 0.069 2.406 0.331 2.969 0.55 0.744 0.288 1.281 0.638 1.837 1.194 0.563 0.563 0.906 1.094 1.2 1.838 0.219 0.563 0.481 1.412 0.55 2.969 0.075 1.688 0.094 2.194 0.094 6.463s-0.019 4.781-0.094 6.463c-0.069 1.563-0.331 2.406-0.55 2.969-0.288 0.744-0.637 1.281-1.194 1.837-0.563 0.563-1.094 0.906-1.837 1.2-0.563 0.219-1.413 0.481-2.969 0.55-1.688 0.075-2.194 0.094-6.463 0.094s-4.781-0.019-6.463-0.094c-1.563-0.069-2.406-0.331-2.969-0.55-0.744-0.288-1.281-0.637-1.838-1.194-0.563-0.563-0.906-1.094-1.2-1.837-0.219-0.563-0.481-1.413-0.55-2.969-0.075-1.688-0.094-2.194-0.094-6.463s0.019-4.781 0.094-6.463c0.069-1.563 0.331-2.406 0.55-2.969 0.288-0.744 0.638-1.281 1.194-1.838 0.563-0.563 1.094-0.906 1.838-1.2 0.563-0.219 1.412-0.481 2.969-0.55 1.681-0.075 2.188-0.094 6.463-0.094zM16 0c-4.344 0-4.887 0.019-6.594 0.094-1.7 0.075-2.869 0.35-3.881 0.744-1.056 0.412-1.95 0.956-2.837 1.85-0.894 0.888-1.438 1.781-1.85 2.831-0.394 1.019-0.669 2.181-0.744 3.881-0.075 1.713-0.094 2.256-0.094 6.6s0.019 4.887 0.094 6.594c0.075 1.7 0.35 2.869 0.744 3.881 0.413 1.056 0.956 1.95 1.85 2.837 0.887 0.887 1.781 1.438 2.831 1.844 1.019 0.394 2.181 0.669 3.881 0.744 1.706 0.075 2.25 0.094 6.594 0.094s4.888-0.019 6.594-0.094c1.7-0.075 2.869-0.35 3.881-0.744 1.050-0.406 1.944-0.956 2.831-1.844s1.438-1.781 1.844-2.831c0.394-1.019 0.669-2.181 0.744-3.881 0.075-1.706 0.094-2.25 0.094-6.594s-0.019-4.887-0.094-6.594c-0.075-1.7-0.35-2.869-0.744-3.881-0.394-1.063-0.938-1.956-1.831-2.844-0.887-0.887-1.781-1.438-2.831-1.844-1.019-0.394-2.181-0.669-3.881-0.744-1.712-0.081-2.256-0.1-6.6-0.1v0z"></path>
                                    <path d="M16 7.781c-4.537 0-8.219 3.681-8.219 8.219s3.681 8.219 8.219 8.219 8.219-3.681 8.219-8.219c0-4.537-3.681-8.219-8.219-8.219zM16 21.331c-2.944 0-5.331-2.387-5.331-5.331s2.387-5.331 5.331-5.331c2.944 0 5.331 2.387 5.331 5.331s-2.387 5.331-5.331 5.331z"></path>
                                    <path d="M26.462 7.456c0 1.060-0.859 1.919-1.919 1.919s-1.919-0.859-1.919-1.919c0-1.060 0.859-1.919 1.919-1.919s1.919 0.859 1.919 1.919z"></path>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ( get_option('linkedin') ) { ?>
                        <li>
                            <a href="<?php echo esc_url( get_option('linkedin') ); ?>" target="_blank" rel="noopener noreferrer" title="Follow <?php bloginfo('name'); ?> on LinkedIn">
                                <span class="visuallyhidden">LinkedIn</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34" aria-hidden="true" focusable="false">
                                    <g transform="scale(0.03125 0.03125)">
                                        <path d="M928 0h-832c-52.8 0-96 43.2-96 96v832c0 52.8 43.2 96 96 96h832c52.8 0 96-43.2 96-96v-832c0-52.8-43.2-96-96-96zM384 832h-128v-448h128v448zM320 320c-35.4 0-64-28.6-64-64s28.6-64 64-64c35.4 0 64 28.6 64 64s-28.6 64-64 64zM832 832h-128v-256c0-35.4-28.6-64-64-64s-64 28.6-64 64v256h-128v-448h128v79.4c26.4-36.2 66.8-79.4 112-79.4 79.6 0 144 71.6 144 160v288z"></path>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ( get_option('facebook') ) { ?>
                        <li>
                            <a href="<?php echo esc_url( get_option('facebook') ); ?>" target="_blank" rel="noopener noreferrer" title="Follow <?php bloginfo('name'); ?> on Facebook">
                                <span class="visuallyhidden">Facebook</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 2 37 34" aria-hidden="true" focusable="false">
                                    <path d="M19 6h5v-6h-5c-3.86 0-7 3.14-7 7v3h-4v6h4v16h6v-16h5l1-6h-6v-3c0-0.542 0.458-1 1-1z"></path>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div><!-- .social-media -->
        </div><!-- .social-media-container -->
        
    </div><!-- .container -->

    <?php if ( have_rows('slices') ) : ?>

        <section class="container-slices">
            <?php while ( have_rows('slices') ) : the_row();
                $slice_type = get_sub_field('slice_type');
                $slice_image = get_sub_field('slice_image');
                $slice_title = get_sub_field('slice_title');
                $slice_description = get_sub_field('slice_description');
                $slice_numbers = get_sub_field('slice_numbers');
                $slice_links = get_sub_field('slice_links');
                $slice_type_key = $slice_type ? strtolower($slice_type) : 'default';
                $slice_type_class = $slice_type ? sanitize_html_class($slice_type_key) : 'default';
                $is_big_picture = ( 'big picture' === $slice_type_key );
                $is_numbers = ( 'numbers' === $slice_type_key );
                $numbers_count = is_array($slice_numbers) ? count($slice_numbers) : 0;
                $slice_link_items = array();
                if ( is_array($slice_links) ) {
                    foreach ( $slice_links as $slice_link_row ) {
                        if ( !is_array($slice_link_row) || empty($slice_link_row['slice_link']) || !is_array($slice_link_row['slice_link']) ) {
                            continue;
                        }

                        $slice_link = $slice_link_row['slice_link'];
                        $link_url = !empty($slice_link['url']) ? $slice_link['url'] : '';
                        $link_text = !empty($slice_link['title']) ? $slice_link['title'] : '';
                        $link_target = !empty($slice_link['target']) ? $slice_link['target'] : '';

                        if ( $link_url && $link_text ) {
                            $slice_link_items[] = array(
                                'url' => $link_url,
                                'text' => $link_text,
                                'target' => $link_target,
                            );
                        }
                    }
                }
                $slice_links_count = count($slice_link_items);
                $slice_has_multi_links = ( $slice_links_count > 1 );
                $slice_has_single_link = ( 1 === $slice_links_count );
                $slice_multi_links_class = $slice_has_multi_links ? ' slice-multi-links' : '';

                $image_url = '';
                $image_alt = $slice_title;
                if ( !empty($slice_image) ) {
                    $image_url = is_array($slice_image) ? $slice_image['url'] : $slice_image;
                    if ( is_array($slice_image) && !empty($slice_image['alt']) ) {
                        $image_alt = $slice_image['alt'];
                    }
                }

                $slice_has_bg = ( $image_url );
                $slice_bg_class = $slice_has_bg ? 'slice-has-bg' : 'slice-no-bg';

                $slice_style_rules = array();
                if ( $slice_has_bg ) {
                    $slice_style_rules[] = "background-image: url('" . esc_url($image_url) . "')";
                }
                if ( $is_numbers && $numbers_count > 0 ) {
                    $slice_style_rules[] = '--slice-columns: ' . intval($numbers_count);
                }

                $slice_style = $slice_style_rules ? ' style="' . esc_attr(implode('; ', $slice_style_rules)) . ';"' : '';
            ?>
                <article class="slice slice-full-width <?php echo esc_attr($slice_bg_class); ?> slice-<?php echo esc_attr($slice_type_class . $slice_multi_links_class); ?>"<?php echo $slice_style; ?>>

                    <div class="slice-content container">
                        <?php if ( $slice_title ) : ?>
                            <h3 class="slice-title"><?php echo esc_html($slice_title); ?></h3>
                        <?php endif; ?>

                        <?php if ( !$slice_has_multi_links && ( $slice_description || $slice_has_single_link ) ) : ?>
                            <div class="slice-description-area">
                                <?php if ( $slice_description ) : ?>
                                    <p class="slice-description"><?php echo esc_html($slice_description); ?></p>
                                <?php endif; ?>
                                <?php if ( $slice_has_single_link ) :
                                    $inline_link = $slice_link_items[0];
                                ?>
                                    <a class="slice-link slice-link-inline" href="<?php echo esc_url($inline_link['url']); ?>"<?php echo $inline_link['target'] ? ' target="' . esc_attr($inline_link['target']) . '"' : ''; ?>><?php echo esc_html($inline_link['text']); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ( $slice_has_multi_links && $slice_description ) : ?>
                            <p class="slice-description"><?php echo esc_html($slice_description); ?></p>
                        <?php endif; ?>

                        <?php if ( $is_numbers && $numbers_count > 0 ) : ?>
                            <ul class="slice-number-list">
                                <?php foreach ( $slice_numbers as $fact ) :
                                    $fact_number = '';
                                    $fact_text = '';

                                    if ( is_array($fact) ) {
                                        $fact_number = !empty($fact['number_value']) ? $fact['number_value'] : '';
                                        $fact_text = !empty($fact['number_label']) ? $fact['number_label'] : '';
                                    }
                                ?>
                                    <?php if ( $fact_number || $fact_text ) : ?>
                                        <li class="slice-number-item">
                                            <?php if ( $fact_number ) : ?>
                                                <span class="slice-number-value"><?php echo esc_html($fact_number); ?></span>
                                            <?php endif; ?>
                                            <?php if ( $fact_text ) : ?>
                                                <span class="slice-number-label"><?php echo esc_html($fact_text); ?></span>
                                            <?php endif; ?>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ( $slice_has_multi_links ) : ?>
                            <ul class="slice-links">
                                <?php foreach ( $slice_link_items as $slice_link_item ) :
                                    $link_url = $slice_link_item['url'];
                                    $link_text = $slice_link_item['text'];
                                    $link_target = $slice_link_item['target'];
                                    $link_svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 55.09 55.09" aria-hidden="true" focusable="false"><circle cx="27.55" cy="27.55" r="26.05" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><polyline points="29.52 37.68 40.72 27.55 29.52 17.41" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/><line x1="39.27" y1="27.55" x2="15.37" y2="27.55" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"/></svg>';
                                ?>
                                    <li>
                                        <a class="slice-link" href="<?php echo esc_url($link_url); ?>"<?php echo $link_target ? ' target="' . esc_attr($link_target) . '"' : ''; ?>><?php echo esc_html($link_text); ?><?php if ( $slice_has_multi_links ) { echo $link_svg; } ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if ($slice_type == "Events and Newsletter") : ?>
                            <div class="slice-events">
                                <h3 class="slice-events-newsletter-title">Events</h3> <a class="more-events right button" href="http://environment.uw.local/alumni-and-community/calendar-events/">See all events &raquo;</a>
                                <?php the_widget('CoEnv_Widget_Events', array( 'feed_url' => 'https://www.trumba.com/calendars/featuredevents-1.rss', 'posts_per_page' => 3)); ?>
                            </div>
                            <div class="slice-newsletter">
                                <div class="newsletter-title-area">
                                    <h3 class="slice-events-newsletter-title">Newsletter</h3>
                                    <p><?php echo esc_html(get_sub_field('newsletter_signup_text')); ?></p>
                                </div>
                                <div class="newsletter-signup-form">
                                    <?php echo do_shortcode('[mkto_signup subID=378]'); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </section>
    <?php endif; ?>
    
			
</main><!-- main-col -->

<?php get_footer() ?>
