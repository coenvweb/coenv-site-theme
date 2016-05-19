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

if ($facSearch->have_posts() ) {
?>

    <section class="coenv-faculty-search">

        <div class="fac-search-feedback">

            <p class="fac-sidebar-feedback-number"><?php echo $facSearch->found_posts ?> faculty result<?php echo ( $facSearch->found_posts > 1 ? 's' : '') ?> for "<?php the_search_query() ?>"</p>

        </div>
    <?php
        foreach($facSearch->posts as $post) {
            $unit = get_the_terms( get_the_id(), 'unit' );
            $unit_color = $coenv_member_api->unit_color( $unit[0]->term_id );
            $unit_style = ' style="background-color: ' . $unit_color . ';"';
            $image = get_field('image');
    ?>
          <a href="<?php the_permalink() ?>" rel="bookmark">
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
                    <h3 class="more-faculty">+<?php echo $remainder ?> more</h3>
                </div>
            </a>  
        <?php } ?>
    </section>
<?php } ?>
