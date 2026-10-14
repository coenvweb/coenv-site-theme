<?php
/**
 * Template Name: Homepage
 */
get_header(); ?>


<div class="hero-wrapper">
    <div class="hero-video-poster" aria-hidden="true" style="background-image:url('<?php echo get_template_directory_uri(); ?>/assets/img/PNSN-still.jpg');" fetchpriority=high></div>
    <video loading="lazy" id="hero-video" class="hero-video" autoplay loop muted playsinline data-default-src="<?php echo get_template_directory_uri(); ?>/assets/video/hero-video-v2.mp4" data-high-res-src="<?php echo get_template_directory_uri(); ?>/assets/video/hero-video-high-res.mp4" poster="<?php echo get_template_directory_uri(); ?>/assets/img/PNSN-still.jpg" style="position:absolute; inset:0; width:100%; height:100%; object-fit:cover; background:#000; z-index:0;">
        <source src="<?php echo get_template_directory_uri(); ?>/assets/video/hero-video-v2.mp4" type="video/mp4" />
    </video>
    <button type="button" class="play-pause-hero" aria-label="Pause background video">
        <i class="fi-pause">▐▐</i>
    </button>
    <div class="container hero-container" style="position:relative; z-index:1;">
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
                    
                    <?php if ( get_option('youtube') ) { ?>
                        <li>
                            <a href="<?php echo esc_url( get_option('youtube') ); ?>" target="_blank" rel="noopener noreferrer" title="Follow <?php bloginfo('name'); ?> on YouTube">
                                <span class="visuallyhidden">YouTube</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34" aria-hidden="true" focusable="false">
                                    <path d="M31.681 9.6c0 0-0.313-2.206-1.275-3.175-1.219-1.275-2.581-1.281-3.206-1.356-4.475-0.325-11.194-0.325-11.194-0.325h-0.012c0 0-6.719 0-11.194 0.325-0.625 0.075-1.987 0.081-3.206 1.356-0.963 0.969-1.269 3.175-1.269 3.175s-0.319 2.588-0.319 5.181v2.425c0 2.587 0.319 5.181 0.319 5.181s0.313 2.206 1.269 3.175c1.219 1.275 2.819 1.231 3.531 1.369 2.563 0.244 10.881 0.319 10.881 0.319s6.725-0.012 11.2-0.331c0.625-0.075 1.988-0.081 3.206-1.356 0.962-0.969 1.275-3.175 1.275-3.175s0.319-2.587 0.319-5.181v-2.425c-0.006-2.588-0.325-5.181-0.325-5.181zM12.694 20.15v-8.994l8.644 4.513-8.644 4.481z"></path>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>

                    <?php if ( get_option('bluesky') ) { ?>
                        <li>
                            <a href="<?php echo esc_url( get_option('bluesky') ); ?>" target="_blank" rel="noopener noreferrer" title="Follow <?php bloginfo('name'); ?> on Bluesky">
                                <span class="visuallyhidden">Bluesky</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34" aria-hidden="true" focusable="false">
                                    <g transform="scale(0.055 0.055)">
                                        <path d="M123.121 33.6637C188.241 82.5526 258.281 181.681 284 234.873C309.719 181.681 379.759 82.5526 444.879 33.6637C491.866 -1.61183 568 -28.9064 568 57.9464C568 75.2916 558.055 203.659 552.222 224.501C531.947 296.954 458.067 315.434 392.347 304.249C507.222 323.8 536.444 388.56 473.333 453.32C353.473 576.312 301.061 422.461 287.631 383.039C285.169 375.812 284.017 372.431 284 375.306C283.983 372.431 282.831 375.812 280.369 383.039C266.939 422.461 214.527 576.312 94.6667 453.32C31.5556 388.56 60.7778 323.8 175.653 304.249C109.933 315.434 36.0535 296.954 15.7778 224.501C9.94525 203.659 0 75.2916 0 57.9464C0 -28.9064 76.1345 -1.61183 123.121 33.6637Z"></path>
                                    </g>
                                </svg>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div><!-- .social-media -->
        </div><!-- .social-media-container -->
        
    </div><!-- .container -->

    <?php echo coenv_render_slices(); ?>
    
			
</main><!-- main-col -->

<?php get_footer() ?>
