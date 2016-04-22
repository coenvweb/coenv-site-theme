<?php  
/**
 * An individual staff member
 */

$image = get_field('photo');
$email = get_field('email');
$phone_number = get_field('phone_number');

?>
<div class="contact">

    <img class="alignleft" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="130" height="130" />

    <div class="contact-info">
        <div class="contact-title">
            <h3><?php the_title(); ?></h3>
            <h4><?php the_field('job_title'); ?></h4>
        </div>
        <ul class="Faculty-member-contact-list">
            <li><a href="mailto:<?php echo $email; ?>"><i class="icon-contact-link-email"></i><?php echo $email; ?></a></li>
            <li><a href="tel:<?php echo $phone_number; ?>"><i class="icon-contact-link-phone"></i><?php echo $phone_number; ?></a></li>
        </ul>
    </div>
</div>