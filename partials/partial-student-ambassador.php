<?php  
/**
 * An individual staff member
 */

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
            <h3><?php the_field('first_name'); ?></h3>
            <span class="class"><?php echo $class; ?></span>
             <?php  // check if the repeater field has rows of data
                if( have_rows('majors_and_minors') ) :
                    echo '<ul class="primary-majors">';

                    // loop through the rows of data
                    while ( have_rows('majors_and_minors') ) : the_row();

                        // display a sub field value
                        $major = get_sub_field('major__minor');
                        $concentration = get_sub_field('concentration');
                        $primary = get_sub_field('primary_majors');
                        if (empty($primary)) {
                            $primary = "not-primary";
                        } else {
                            $primary = "primary";
                        }
                        echo '<li class="' . $primary . '">' . $major;
                        if (!empty($concentration)){
                            echo '<span class="concentration"> ' . $concentration . '</span></li>';
                        }

                    endwhile;

                    echo '</div>';
                else :

                    // no rows found

                endif;
            ?>
        </div>
    </div>
</div>
<div id="bio-c-<?php echo $post->post_name ?>" class="accordion-content" aria-labelledby="bio-t-<? echo $post->post_name ?>" aria-hidden="true" aria-controlled-by="bio-t-<? echo $post->post_name ?>" style="display: none;">
<? if(!empty($description) || have_rows('job_responsibilities')) { ?>
    <?php if (!empty($class)) : ?>
            <ul class="Faculty-member-contact-list">
                    <li><a href="mailto:coenvamb@uw.edu?subject=Question%20for%20<?php the_title(); ?>"><i class="icon-contact-link-email"></i>Email <?php the_field('first_name'); ?></a></li>
                <?php if (!empty($phone_number)) : ?>
                    <li><a href="tel:<?php echo $phone_number; ?>"><i class="icon-contact-link-phone"></i><?php echo $phone_number; ?></a></li>
                <?php endif; ?>
                <?php  // check if the repeater field has rows of data
                    if( have_rows('links') ) :
                        echo '<div class="left">';

                        // loop through the rows of data
                        while ( have_rows('links') ) : the_row();

                            // display a sub field value
                            $link_text = get_sub_field('link_text');
                            $link_url = get_sub_field('link_url');
                            $link_icon = get_sub_field('link_icon');
                            echo '<li><a class="left-link" href="' . $link_url . '"><i class=' . $link_icon . ' /></i>' . $link_text . '</a></li>';

                        endwhile;

                        echo '</div>';
                    else :

                        // no rows found

                    endif;
                ?>
                
            </ul>
        <?php endif; ?>
<?php
    
    // check if the repeater field has rows of data
    if( have_rows('job_responsibilities') ):
        echo '<ul class="responsibilities">';

        // loop through the rows of data
        while ( have_rows('job_responsibilities') ) : the_row();

            // display a sub field value
            $responsibility = get_sub_field('responsibility');
            echo '<li class="responsibility">' . $responsibility . '</li>';

        endwhile;
                             
        echo '</ul>';
    else :
        echo '<br/>';
        // no rows found

    endif;

    echo $description;
?>
<? } ?></div>
