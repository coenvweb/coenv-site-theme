<?php
global $coenv_member_api;

$search_query = explode(' ', get_search_query());
$fac_meta_query = array(
    'relation' => 'OR',
    'posts_per_page' => -1,
);
foreach($search_query as $keyword) {
    $fn = array('key' => 'first_name', 'value' => $keyword);
    $ln = array('key' => 'last_name', 'value' => $keyword);
    $fac_meta_query[] = $fn;
    $fac_meta_query[] = $ln;
}

$facArgs = array(
    'post_type' => 'faculty',
    'meta_query' => $fac_meta_query
);

$facSearch = new WP_Query($facArgs);

$careerArgs = array(
    's' => get_search_query(),
    'post_type' => 'careers',
    'posts_per_page' => get_option('posts_per_page'),
    'order' => 'DESC',
    'orderby' => 'date'

);

$careerSearch = new WP_Query($careerArgs);

if ($facSearch->have_posts() ) {
?>
    <section class="coenv-sidebar-search">
        <div class="search-feedback">
            <p class="sidebar-feedback-number">FACULTY RESULTS</p>
        </div>
    <?php
        foreach($facSearch->posts as $post) {
            $unit = get_the_terms( get_the_id(), 'unit' );
            $unit_color = $coenv_member_api->unit_color( $unit[0]->term_id );
            $unit_style = ' style="background-color: ' . $unit_color . ';"';
            $image = get_field('image');
    ?>
          <a class="fac-link" href="<?php the_permalink() ?>" rel="bookmark">
                <div class="search-faculty" <?php echo $unit_style ?> >
                    <div class="faculty-info">
                        <div class="faculty-container">
                            <h3 class="article__title"><?php the_title() ?></h3>
                            <p class="faculty-unit"><?php echo $unit[0]->name ?></p>
                        </div>
                    </div>
                    <div class="faculty-img">
                        <?php echo wp_get_attachment_image($image, 'thumbnail', '', array('class'=>'attachment-thumbnail')); ?>
                    </div>
                </div>
            </a> 
            <?php wp_reset_postdata(); ?>
        <?php } ?>
        <?php if($facSearch->found_posts > get_option('posts_per_page')) { ?>
            <?php $remainder = $facSearch->found_posts - get_option('posts_per_page'); ?>
            <a href="<?php site_url() ?>faculty/" rel="bookmark">
                <div class="search-faculty" style="background-color:#333" >
                    <h3 class="more-sidebar">+<?php echo $remainder ?> more</h3>
                </div>
            </a>  
        <?php } ?>
    </section>
<?php } ?>

<?php if($careerSearch->have_posts()) { ?>
    <section class="coenv-sidebar-search">
        <div class="search-feedback">
            <p class="sidebar-feedback-number">CAREER OPPORTUNITY RESULTS</p>
        </div>
    <?php
        foreach($careerSearch->posts as $post) {
            setup_postdata($post);
    ?>
            <a href="<?php the_permalink(); ?>">
                <article class="career-op">
                    <h3 class="career__title"><?php the_title() ?></h3>
                </article>
            </a>
            <?php wp_reset_postdata(); ?>
    <?php
        }
    ?>
        <?php if($careerSearch->found_posts > get_option('posts_per_page')) { ?>
            <?php $remainder = $careerSearch->found_posts - get_option('posts_per_page'); ?>
            <a href="<?php site_url() ?>students/career-resources/career-opportunities/?st=<?php echo get_search_query() ?>" rel="bookmark">
                <div class="search-faculty" style="background-color:#333;">
                    <h3 class="more-sidebar">+<?php echo $remainder ?> more</h3>
                </div>
            </a>  
        <?php } ?>    
    </section>

<?php } ?>
