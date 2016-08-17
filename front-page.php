<?php
/**
 * The home page template
 */
get_header();

// Get all home page features and sort posts using post-types-order
$features = new WP_Query( array(
    'post_type' => 'post',
    'posts_per_page' => 1,
    'post__in' => get_option('sticky_posts'),
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'ignore_sticky_posts' => 1
) );
// Get posts and sort using post-types-order
$post_sort = new WP_Query( array(
    'post_type' => 'post',
    'posts_per_page' => 9,
    'post__not_in' => get_option('sticky_posts'),
    'orderby' => array('menu_order' => 'ASC', 'date' => 'DESC'),
    'ignore_sticky_posts' => 1
) );
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
        <?php if ( $post_sort->have_posts() ) : ?>
            <section class="widget featured-stories">

                <header>

                    <h1><span><a href="<?php echo get_permalink( get_option('page_for_posts') ) ?>">News from the College</a></span> <a href="<?php echo get_permalink( get_option('page_for_posts') ) ?>">More &raquo;</a></h1>
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
