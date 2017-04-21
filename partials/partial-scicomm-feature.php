<?php
	$feature_image = get_field('feature_image');
	$feature_title = get_field('feature_title');
	$feature_content = get_field('feature_content');
	$feature_link = get_field('feature_link');
?>
<div class="news_item">
    <header class="article__header">
        <h1 class="article__title"><a href="<?php echo $feature_link; ?>" rel="bookmark"><?php echo $feature_title; ?></a></h1>
    </header>

    <section class="article__content scicomm_feature">

		<?php if ( $feature_image ) {
            $image = wp_get_attachment_image($feature_image, '', false, array('class'=>'scicomm_image'));
            echo $image;
		} ?>

        <p>
        <?php echo $feature_content; ?>
        </p>

        <?php if ( $feature_link ) { ?>

                <p><a href="<?php echo $feature_link; ?>" class="button" target="_blank">Read More »</a>

        <?php } ?>

    </section>
</div>
