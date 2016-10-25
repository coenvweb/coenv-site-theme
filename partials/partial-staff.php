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

if(!empty($description)) {
    $accordionclass = accordion-title;
}

?>
<div id="accordion-1-t<?php echo $i ?>" class="contact <? if(!empty($description)) { ?>accordion-title read<? } ?>" role="tab">

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="contact-info">
        <div class="contact-title">
            <h3><?php the_title(); ?></h3>
            <h4><?php the_field('job_title'); ?></h4>
        </div>
        <?php if (!empty($email) && !empty($phone_number)) : ?>
            <ul class="Faculty-member-contact-list" id="ignore">
                <?php if (!empty($email)) : ?>
                    <li><a id="ignore" href="mailto:<?php echo antispambot($email); ?>"><i class="icon-contact-link-email"></i><?php echo antispambot($email); ?></a></li>
                <?php endif; ?>
                <?php if (!empty($phone_number)) : ?>
                    <li><a id="ignore" href="tel:<?php echo $phone_number; ?>"><i class="icon-contact-link-phone"></i><?php echo $phone_number; ?></a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<div id="accordion-1-c<?php echo $i ?>" class="accordion-content" role="tabpanel" aria-labelledby="accordion-1-t<? echo $i ?>" aria-hidden="true" style="display: none;">
<? if(!empty($description)) { ?>
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

        // no rows found

    endif;

    echo $description;    
?>
<? } ?></div>
