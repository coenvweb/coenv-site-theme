<?php  
/**
 * An individual Graduate Profile
 */

$first_name = get_field('first_name');
$last_name = get_field('last_name');
$department_degree = get_field('department_and_pursued_degree');
$faculty_advisor = get_field('faculty_advisor');
$undergrad_degree = get_field('undergraduate_degree');
$research_interests = get_field('research_interests');
$disseration_title = get_field('dissertation_title');
$location = get_field('location');
$image = get_field('photo');


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

?>
<div role="button" id="bio-t-<?php echo $post->post_name ?>" class="contact accordion-title read" aria-label="Toggle more information" tabindex="0" aria-expanded="false">

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="contact-info">
        <div class="contact-title">
            <h3><?php echo $first_name; ?><span class="last"> <?php echo $last_name; ?></span></h3>
            <span class="class"><?php echo $class; ?></span>
             <?php  // check if the repeater field has rows of data
                echo '<ul class="primary-majors">';
                echo '<li>' . $department_degree . '</li>';
                echo '</ul>';
                echo '</div>';
            ?>
        </div>
    </div>
<div id="bio-c-<?php echo $post->post_name ?>" class="accordion-content" aria-labelledby="bio-t-<? echo $post->post_name ?>" aria-hidden="true" aria-controlled-by="bio-t-<? echo $post->post_name ?>" style="display: none;">
            
    <ul class="ambassador-info">
        <?php if (!empty($department_degree)) : ?>
            <div class="row"><div class="prompt">Department and pursued degree:</div><ul class="answer-content"><?php echo $department_degree; ?></ul></div>
        <?php endif; ?>
        <?php if (!empty($faculty_advisor)) : ?>
            <div class="row"><div class="prompt">Faculty advisor(s):</div> <li class="answer-content"><?php echo $faculty_advisor; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($undergrad_degree)) : ?>
            <div class="row"><div class="prompt">Previous institution and degree:</div> <li class="answer-content"><?php echo $undergrad_degree; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($research_interests)) : ?>
            <div class="row"><div class="prompt">Research interest:</div> <li class="answer-content"><?php echo $research_interests; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($disseration_title)) : ?>
            <div class="row"><div class="prompt">Dissertation title:</div> <li class="answer-content"><?php echo $disseration_title; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($location)) : ?>
            <div class="row"><div class="prompt">Research location:</div> <li class="answer-content"><?php echo $location; ?></li></div>
        <?php endif; ?>
        <?php if(current_user_can('ow_make_revision') && current_user_can('ow_make_revision_others')) { ?>
        <div class="row">
            <div class="prompt">Logged in users:</div>
            <li class="answer-content">
                <?php echo do_shortcode('[ow_make_revision_link text="Make a revision" class="" type="text" post_id="'.$post->ID.'"]'); ?>
            </li>
        </div>
        <?php } ?>
    </ul>
    </div>
