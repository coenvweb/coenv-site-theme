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

            <h2><a href="/news">Latest News</a></h2> <a class="right" href="<?php echo get_permalink( get_option('page_for_posts') ) ?>">See all news &raquo;</a>

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
        
    </div><!-- .container -->

    <?php if ( have_rows('slices') ) : ?>

        <section class="container-slices">
            <?php while ( have_rows('slices') ) : the_row();
                $slice_type = get_sub_field('slice_type');
                $slice_image = get_sub_field('slice_image');
                $slice_title = get_sub_field('slice_title');
                $slice_description = get_sub_field('slice_description');
                $slice_numbers = get_sub_field('slice_numbers');
                $slice_type_class = $slice_type ? sanitize_html_class($slice_type) : 'default';
                $is_big_picture = ( 'big_picture' === $slice_type );
                $is_numbers = ( 'numbers' === $slice_type );
                $numbers_count = is_array($slice_numbers) ? count($slice_numbers) : 0;

                $image_url = '';
                $image_alt = $slice_title;
                if ( !empty($slice_image) ) {
                    $image_url = is_array($slice_image) ? $slice_image['url'] : $slice_image;
                    if ( is_array($slice_image) && !empty($slice_image['alt']) ) {
                        $image_alt = $slice_image['alt'];
                    }
                }

                $slice_has_bg = ( $is_big_picture && $image_url );
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
                <article class="slice slice-full-width <?php echo esc_attr($slice_bg_class); ?> slice-<?php echo esc_attr($slice_type_class); ?>"<?php echo $slice_style; ?>>
                    <?php if ( !$is_big_picture && $image_url ) : ?>
                        <div class="slice-image">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="slice-content container">
                        <?php if ( $slice_title ) : ?>
                            <h3 class="slice-title"><?php echo esc_html($slice_title); ?></h3>
                        <?php endif; ?>

                        <?php if ( $slice_description ) : ?>
                            <p class="slice-description"><?php echo esc_html($slice_description); ?></p>
                        <?php endif; ?>

                        <?php if ( $is_numbers && $numbers_count > 0 ) : ?>
                            <ul class="slice-numbers">
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

                        <?php if ( have_rows('slice_links') ) : ?>
                            <ul class="slice-links">
                                <?php while ( have_rows('slice_links') ) : the_row();
                                    $link = get_sub_field('slice_link');
                                    $link_url = ( is_array($link) && !empty($link['url']) ) ? $link['url'] : '';
                                    $link_text = ( is_array($link) && !empty($link['title']) ) ? $link['title'] : '';
                                    $link_target = ( is_array($link) && !empty($link['target']) ) ? $link['target'] : '';
                                ?>
                                    <?php if ( $link_url && $link_text ) : ?>
                                        <li>
                                            <a href="<?php echo esc_url($link_url); ?>"<?php echo $link_target ? ' target="' . esc_attr($link_target) . '"' : ''; ?>><?php echo esc_html($link_text); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endwhile; ?>
        </section>
    <?php endif; ?>
    
			
</main><!-- main-col -->

<?php get_footer() ?>
