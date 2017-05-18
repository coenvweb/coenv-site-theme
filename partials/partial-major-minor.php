<?php  
/**
 * A major or minor
 */

$name = get_sub_field('name');
$type_of_degree = get_sub_field('type_of_degree');
$description = get_sub_field('description');
$image = get_sub_field('image');
$link = get_sub_field('link');


if( !empty($image) ) {

	// vars
	$alt = $image['alt'];

	// thumbnail
	$size = 'thumbnail';
	$thumb = $image['sizes'][ $size ];
}

if(!empty($description)) {
    $accordionclass = accordion-title;
}

?>
<div id="bio-t-<?php echo sanitize_title($name); ?>" class="contact <?php if(!empty($description)) { ?>accordion-title read" aria-label="Toggle more information" tabindex="0<?php } ?>" aria-expanded="false">

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="major-info">
        <div class="major-title">
            <h3><?php echo $name; ?></h3>
            <span class="type"><?php echo $type_of_degree; ?></span>
        </div>
    </div>
<div id="bio-c-<?php echo sanitize_title($name); ?>" class="accordion-content" aria-labelledby="bio-t-<? echo sanitize_title($name); ?>" aria-hidden="true" aria-controlled-by="bio-t-<? echo sanitize_title($name); ?>" style="display: none;">
            
    <ul class="major-info">
        <?php if (!empty($description)) : ?>
            <div class="row">
                <div class="prompt">Description:</div><li class="answer-content"><?php echo $description; ?></li></div>
        <?php endif; ?>
        <div class="row">
            <div class="prompt">Connect:</div>
            <ul class="answer-content">
            <li><a href="mailto:coenvamb@uw.edu?subject=Question%20for%20<?php the_title(); ?>"><i class="icon-mail"></i>Email <?php echo $name; ?></a></li>
            <?php if (!empty($link)) : ?>
                <li><a href="<?php echo $link; ?>"><?php echo $name; ?> Website</a></li>
            <?php endif; ?>            
            </ul>
        </div>
    </ul>
    </div>
