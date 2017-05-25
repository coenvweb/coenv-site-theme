<?php  
/**
 * A major or minor
 */

$name = get_sub_field('name');
$type_of_degree = get_sub_field('type_of_degree');
$unit_color = get_sub_field('unit_color');
$description = get_sub_field('description');
$image = get_sub_field('image_array');
$adviser = get_sub_field('adviser_name');
$adviser_email = get_sub_field('adviser_email');
$adviser_phone = get_sub_field('adviser_phone_number');
$link = get_sub_field('link');
$facebook = get_sub_field('facebook_link');
$twitter = get_sub_field('twitter_link');
$faculty_link = get_sub_field('faculty_link');



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
<div id="major-t-<?php echo sanitize_title($name); ?>" class="major-minor accordion-title read <?php if($unit_color){ echo 'unit-color" style="background-color:' . $unit_color . ';';} ?>" aria-label="Toggle more information" tabindex="0" aria-expanded="false">

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="major-info">
        <div class="major-title">
            <h3><?php echo $name; ?></h3>
            <span class="type"><?php echo $type_of_degree; ?></span>
        </div>
    </div>
</div>
<div id="major-c-<?php echo sanitize_title($name); ?>" class="accordion-content major-content" aria-labelledby="major-t-<? echo sanitize_title($name); ?>" aria-hidden="true" aria-controlled-by="major-t-<? echo sanitize_title($name); ?>" style="display: none;">
            
    <ul class="major-info">
        <?php if (!empty($description)) : ?>
            <div class="row">
                <div class="prompt">Description:</div><li class="answer-content"><?php echo $description; ?></li></div>
        <?php endif; ?>
        <div class="row">
            <div class="prompt">Adviser:</div>
            <ul class="answer-content">
                <?php if (!empty($adviser)) : ?>
                <li><i class="dashicons dashicons-admin-users"></i><?php echo $adviser; ?></li>
                <?php endif; ?>
                <li><a href="mailto:<?php echo $adviser_email; ?>?subject=Question%20about%20<?php echo $name; ?>"><i class="icon-mail"></i><?php echo $adviser_email; ?></a></li>
                <li><a href="tel:<?php echo $adviser_phone; ?>"><i class="icon-phone"></i><?php echo $adviser_phone; ?></a></li>
            </ul>
        </div>
        <div class="row">
            <div class="prompt">Connect:</div>
            <ul class="answer-content">
                <li><a href="<?php echo $link; ?>"><i class="icon-link"></i>Visit website</a></li>
                <?php if (!empty($faculty_link)) : ?>
                    <li><a href="<?php echo $faculty_link; ?>"><i class="icon-faculty-grid-alt-2"></i>Meet faculty</a></li>
                <?php endif; ?>       
                <?php if (!empty($facebook)) : ?>
                    <li><a href="<?php echo $facebook; ?>"><i class="icon-facebook"></i>Like on Facebook</a></li>
                <?php endif; ?>    
                <?php if (!empty($twitter)) : ?>
                    <li><a href="<?php echo $twitter; ?>"><i class="icon-twitter"></i>Follow on Twitter</a></li>
                <?php endif; ?>            
            </ul>
        </div>
    </ul>
    </div>
