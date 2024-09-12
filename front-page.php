<?php
/**
 * The home page template
 */
get_header();

// Get all home page features and sort posts using post-types-order
$features = new WP_Query( array(
    'post_type' => 'post',
    'posts_per_page' => 1,
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
        'posts_per_page' => 8,
        'post__not_in' => array($features->post->ID),
        'tax_query' => array(
            array(
                'taxonomy' => 'story_type',
                'field' => 'term_id',
                'terms' => array ( 7239, 7240, 7242, 7243, 7244 ),
                'operator' => 'NOT IN'
            )
        )
    ) );
}else{
    $post_sort = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => 9,
        'post__not_in' => array($features->post->ID),
        'tax_query' => array(
            array(
                'taxonomy' => 'story_type',
                'field' => 'term_id',
                'terms' => array ( 7239, 7240, 7242, 7243, 7244 ),
                'operator' => 'NOT IN'
            )
        )
    ) );
}

?>

    <?php if ( $features->have_posts() ) : ?>

		<main id="main-col">

        <section id="features">

            <div class="features-container">

                <?php while ( $features->have_posts() ) : $features->the_post() ?>

                    <?php get_template_part( 'partials/partial', 'feature' ) ?>

                <?php endwhile  ?>

            </div><!-- .features-container -->

        </section><!-- #features -->

    <?php endif ?>

    <?php wp_reset_postdata() ?>

    <div class="container">
        <?php $page = ($post_sort->post_count + 1) / get_option('posts_per_page') + 1; ?>
        <?php if ( $post_sort->have_posts() ) : ?>
            <section class="widget featured-stories">

                <header>

                    <h2><span><a href="<?php echo get_permalink( get_option('page_for_posts') ) ?>page/<?=$page?>/">News from the College</a></span> <a href="<?php echo get_permalink( get_option('page_for_posts') ) ?>">All news &raquo;</a></h2>
                </header>

                <div class="stories-container">
                    <div class="story-sizer"></div>
                    <?php while ( $post_sort->have_posts() ) : $post_sort->the_post() ?>

                        <?php get_template_part( 'partials/partial', 'story' ) ?>

                    <?php endwhile  ?>

                </div><!-- .stories-container -->

            </section><!-- #featured-stories --> 
        <?php endif ?>

        <?php get_sidebar() ?>
        
    </div><!-- .container -->
			
</main><!-- main-col -->

<?php get_footer() ?>
