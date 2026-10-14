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
$bluesky = get_sub_field('bluesky_link');
$faculty_link = get_sub_field('faculty_link');

if( !empty($image) ) {

	// vars
	$alt = $image['alt'];

	// thumbnail
	$size = 'thumbnail';
	$thumb = $image['sizes'][ $size ];
}

if(!empty($description)) {
    $accordionclass = 'accordion-title';
}

$major_minor_slug = sanitize_title( $name );
if ( ! isset( $GLOBALS['coenv_major_minor_ids'] ) ) {
    $GLOBALS['coenv_major_minor_ids'] = array();
}

$major_minor_count = isset( $GLOBALS['coenv_major_minor_ids'][ $major_minor_slug ] ) ? $GLOBALS['coenv_major_minor_ids'][ $major_minor_slug ] + 1 : 1;
$GLOBALS['coenv_major_minor_ids'][ $major_minor_slug ] = $major_minor_count;
$major_minor_id = $major_minor_slug . ( $major_minor_count > 1 ? (string) $major_minor_count : '' );
$title_id = 'major-t-' . $major_minor_id;
$content_id = 'major-c-' . $major_minor_id;

?>
<div id="<?php echo esc_attr( $title_id ); ?>" class="major-minor accordion-title read <?php if($unit_color){ echo 'unit-color" style="background-color:' . $unit_color . ';';} ?>" aria-label="Toggle more information" tabindex="0" aria-expanded="false" aria-controls="<?php echo esc_attr( $content_id ); ?>">

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="major-info">
        <div class="major-title">
            <h3><?php echo $name; ?></h3>
            <span class="type"><?php echo $type_of_degree; ?></span>
        </div>
    </div>
</div>
<div id="<?php echo esc_attr( $content_id ); ?>" class="accordion-content major-content" aria-labelledby="<?php echo esc_attr( $title_id ); ?>" aria-hidden="true" aria-controls="<?php echo esc_attr( $title_id ); ?>" style="display: none;">
            
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
                    <li><a href="<?php echo $twitter; ?>"><i class="icon-twitter"></i>Follow on X</a></li>
                <?php endif; ?>            
                <?php if (!empty($bluesky)) : ?>
                    <li>
                        <a href="<?php echo $bluesky; ?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 34 34" aria-hidden="true" focusable="false">
                            <g transform="scale(0.055 0.055)">
                                <path d="M123.121 33.6637C188.241 82.5526 258.281 181.681 284 234.873C309.719 181.681 379.759 82.5526 444.879 33.6637C491.866 -1.61183 568 -28.9064 568 57.9464C568 75.2916 558.055 203.659 552.222 224.501C531.947 296.954 458.067 315.434 392.347 304.249C507.222 323.8 536.444 388.56 473.333 453.32C353.473 576.312 301.061 422.461 287.631 383.039C285.169 375.812 284.017 372.431 284 375.306C283.983 372.431 282.831 375.812 280.369 383.039C266.939 422.461 214.527 576.312 94.6667 453.32C31.5556 388.56 60.7778 323.8 175.653 304.249C109.933 315.434 36.0535 296.954 15.7778 224.501C9.94525 203.659 0 75.2916 0 57.9464C0 -28.9064 76.1345 -1.61183 123.121 33.6637Z"></path>
                            </g>
                        </svg>Follow on Bluesky</a>
                    </li>
                <?php endif; ?>            
            </ul>
        </div>
    </ul>
    </div>
