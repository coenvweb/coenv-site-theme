<?php  
/**
 * An individual staff member
 */

$first_name = get_field('first_name');
$last_name = get_field('last_name');
$image = get_field('photo');
$class = get_field('class');
$last_school = get_field('last_school');
$hometown = get_field('hometown');
$linkedin = get_field('linkedin_profile_link');
$twitter = get_field('twitter_profile_link');
$description = get_field('response');


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
<div id="bio-t-<?php echo $post->post_name ?>" class="contact <?php if(!empty($description)) { ?>accordion-title read" aria-label="Toggle more information" tabindex="0<?php } ?>" aria-expanded="false">

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="contact-info">
        <div class="contact-title">
            <h3><?php echo $first_name; ?><span class="last"> <?php echo $last_name; ?></span></h3>
            <span class="class"><?php echo $class; ?></span>
             <?php  // check if the repeater field has rows of data
                if( have_rows('majors_and_minors') ) :
                    echo '<ul class="primary-majors">';
                    $minors = '';
                    // loop through the rows of data
                    while ( have_rows('majors_and_minors') ) : the_row();

                        // display a sub field value
                        $major = get_sub_field('major__minor');
                        $concentration = get_sub_field('concentration');
                        $primary = get_sub_field('primary_majors');
                        $minor = get_sub_field('minor');
                        if (empty($primary)) {
                            $primary = "not-primary";
                        } else {
                            $primary = "primary";
                        }
                        if ($minor) {
                            $minors .= '<li>' . $major;
                            if (!empty($concentration)){
                                $minors .= '<span class="concentration"> ' . $concentration . ' </span></li>';
                            } else {
                                $minors .= '</li>';
                            }
                        } else {
                            echo '<li class="' . $primary . ' ' . $minor . '">' . $major;
                            if (!empty($concentration)){
                                echo '<span class="concentration"> ' . $concentration . '</span></li>';
                            }
                        }

                    endwhile;

                    echo '</div>';
                else :

                    // no rows found

                endif;
            ?>
        </div>
    </div>
<div id="bio-c-<?php echo $post->post_name ?>" class="accordion-content" aria-labelledby="bio-t-<? echo $post->post_name ?>" aria-hidden="true" aria-controlled-by="bio-t-<? echo $post->post_name ?>" style="display: none;">
            
    <ul class="ambassador-info">
        <?php if (!empty($hometown)) : ?>
            <li><span class="prompt">Hometown:</span> <?php echo $hometown; ?></li>
        <?php endif; ?>
        <?php if (!empty($last_school)) : ?>
            <li><span class="prompt">Last School:</span> <?php echo $last_school; ?></li>
        <?php endif; ?>
        <?php if (!empty($minor)) : ?>
            <ul class="minors"><span class="prompt">Minor(s):</span> <?php echo $minors; ?></ul>
        <?php endif; ?>  
    </ul>

    <?php echo $description; ?>
    <ul class="ambassador-links">
            <li><a class="button" href="mailto:coenvamb@uw.edu?subject=Question%20for%20<?php the_title(); ?>"><i class="icon-mail"></i>Email <?php echo $first_name; ?></a></li>
        <?php if (!empty($twitter)) : ?>
            <li><a class="button" href="<?php echo $twitter; ?>"><i class="icon-twitter"></i>Follow <?php echo $first_name; ?> on Twitter</a></li>
        <?php endif; ?>
        <?php if (!empty($linkedin)) : ?>
            <li><a class="button" href="<?php echo $linked_in; ?>"><i class="icon-link"></i>Connect with <?php echo $first_name; ?> on LinkedIn</a></li>
        <?php endif; ?>                
    </ul>
    </div>
