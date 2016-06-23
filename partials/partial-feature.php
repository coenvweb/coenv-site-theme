<?php  
/**
 * Home page feature
 */

//if ( get_field('story_link_url') && the_field('story_source_name') ) {
//    $content_name = the_field('story_link_url');
//    $content_url = the_field('story_source_name');
//    $content_target = ' target="_blank" ';
 //} else {
    $content_name = "Read more »";
    $content_url = get_the_permalink();
    $content_target = '';
//}

$feature_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
$feature_caption = get_post_meta(get_post_thumbnail_id(), "_credit_text", true);

$units = get_the_terms( $post->ID, 'unit' );
$unit = $units[0]->term_id;

$unit_color = coenv_unit_color($unit);
if (!$unit_color){
    $unit_color = '#333333';
} 
$feature = array(
	'label' => get_field('feature_label'),
	'content_link' => array(
		'title' => $content_name,
		'url' => $content_url,
		'target' => $content_target
	),
	'image' => array(
		'url' => $feature_image[0],
		'caption' => $feature_caption
	),
	'color' => $unit_color != '' ? $unit_color : get_field('color_picker')
);
?>

<article class="feature loading">
    
    <a class="feature-title" href="<?php echo $feature['content_link']['url'] ?>"<?php echo $feature['content_link']['target'] ?>>
        
    <span class="visuallyhidden">Link to article</span>

    <div class="feature-image" style="background-color: <?php echo $feature['color'] ?>">
        <?php the_post_thumbnail(); ?>
    </div>
        
    </a>
    
	<div class="feature-info-container">
            
		<div class="feature-info" style="background-color: <?php echo $feature['color'] ?>">

			<div class="feature-content">
                <a class="feature-title" href="<?php echo $feature['content_link']['url'] ?>"<?php echo $feature['content_link']['target'] ?>>

                    <h1><?php the_title() ?></h1>

                    <p><?php the_advanced_excerpt('length=20&length_type=words'); ?></p>
                    
                </a>
                
                    <a class="button feature-button" href="<?php echo $feature['content_link']['url'] ?>"<?php echo $feature['content_link']['target'] ?>><?php echo $feature['content_link']['title'] ?></a>

                <?php if ( !empty( $feature['image']['caption'] ) ) : ?>
                    <p class="feature-caption"><?php echo  'Photo: ' . $feature['image']['caption'] ?></p>
                <?php endif ?>

			</div><!-- .feature-content -->

		</div><!-- .feature-info -->
            
	</div><!-- .feature-info-container -->

</article><!-- .feature -->
