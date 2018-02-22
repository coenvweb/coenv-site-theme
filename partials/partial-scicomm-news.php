<?php
	$image = $nl_post['image'];
	$title = $nl_post['title'];
	$link = $nl_post['link'];
?>
<div class="scicomm_news_item">
    <header class="article__header">
		<?php if ( $image ) {
            $image = wp_get_attachment_image($image, '', false, array('class'=>'scicomm_image'));
            echo '<a href="'.$link.'">';
                echo $image;
            echo '</a>';
		} ?>
        <h1 class="article__title"><a href="<?php echo $link; ?>" rel="bookmark"><?php echo $title; ?></a></h1>
    </header>

    <section class="article__content">

    </section>
</div>
