<?php  
/**
 * An individual staff member
 */

$image = get_field('photo');
$email = get_field('email');
$phone_number = get_field('phone_number');
$description = get_field('details');


if( !empty($image) ) {

	// vars
	$alt = $image['alt'];

	// thumbnail
	$size = 'thumbnail';
	$thumb = $image['sizes'][ $size ];
}

if(!empty($description) || have_rows('job_responsibilities')) {
    $accordionclass = 'accordion-title';
}

?>
<div id="bio-t-<?php echo $post->post_name ?>" class="contact <?php if( (is_page('deans-office-staff') || is_page('our-advancement-team')) && (!empty($description) || have_rows('job_responsibilities'))) { ?>accordion-title read" aria-label="Toggle more information" aria-expanded="false" tabindex="0<?php } ?>" >

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="contact-info">
        <div class="contact-title">
            <h3><?php the_title(); ?></h3>
            <h4><?php echo get_field('job_title'); ?></h4>
        </div>
        <?php if (!empty($email) || !empty($phone_number)) : ?>
            <ul class="Faculty-member-contact-list">
                <?php if (!empty($email)) : ?>
                    <li><a href="mailto:<?php echo antispambot($email); ?>"><i class="icon-contact-link-email"></i><?php echo antispambot($email); ?></a></li>
                <?php endif; ?>
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
    </div>
</div>
<?php if( (is_page('deans-office-staff') || is_page('our-advancement-team')) && (!empty($description) || have_rows('job_responsibilities'))) {
    echo '<div id="bio-c-' . $post->post_name . '" class="accordion-content" aria-labelledby="bio-t-' . $post->post_name . '" aria-hidden="true" aria-controlled-by="bio-t-' . $post->post_name .'" style="display: none;">';
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
<?php } ?>
<?php if(is_page('deans-office-staff') && (current_user_can('ow_make_revision') && current_user_can('ow_make_revision_others'))) { ?>
    <p class="revision"><?php echo do_shortcode('[ow_make_revision_link text="Make a revision" class="" type="text" post_id="'.$post->ID.'"]'); ?></p>
<?php } ?>
<?php if( (is_page('deans-office-staff') || is_page('our-advancement-team')) && (!empty($description) || have_rows('job_responsibilities'))) { ?>
</div>
<?php } ?>
