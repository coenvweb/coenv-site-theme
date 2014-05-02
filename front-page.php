<?php
/**
 * The home page template
 */
get_header();

// Get all home page features
$features = new WP_Query( array(
    'post_type' => 'feature',
    'posts_per_page' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC'
) );
// Get all home page news items
$news_home = new WP_Query( array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'orderby' => 'menu_order',
    'order' => 'ASC'
) );
?>

    <?php if ( $features->have_posts() ) : ?>

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

            <section class="widget featured-stories">

                <header>
                    <h1><span><a href="<?php echo get_permalink( get_option('page_for_posts') ) ?>">News from the College</a></span> <a href="<?php echo get_permalink( get_option('page_for_posts') ) ?>">More &raquo;</a></h1>
                </header>

                <div class="stories-container">

                    <?php while ( $news_home->have_posts() ) : $news_home->the_post() ?>

                        <?php get_template_part( 'partials/partial', 'story' ) ?>

                    <?php endwhile  ?>

                </div><!-- .stories-container -->

            </section><!-- #featured-stories --> 

        <?php get_sidebar() ?>
        
    </div><!-- .container -->

<?php get_footer() ?>