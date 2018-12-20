<?php  
/**
 * An individual Graduate Profile
 */

$first_name = get_field('first_name');
$last_name = get_field('last_name');
$image = get_field('photo');
$academic_unit = get_field('academic_unit');
$faculty_advisor = get_field('faculty_advisor');
$last_school = get_field('last_school');
$year_joined_uw = get_field('year_joined_uw');
$quarter_joined_uw = get_field('quarter_joined_uw');
$current_research_project = get_field('current_research_project');
$research_description = get_field('research_description');
$citations = get_field('citations');
$research_image = get_field('research_image');


if( !empty($image) ) {

    // vars
    $alt = $image['alt'];

    // thumbnail
    $size = 'thumbnail';
    $thumb = $image['sizes'][ $size ];
}

?>
<div id="bio-t-<?php echo $post->post_name ?>" class="contact accordion-title read" aria-label="Toggle more information" tabindex="0" aria-expanded="false">

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="contact-info">
        <div class="contact-title">
            <h3><?php echo $first_name; ?><span class="last"> <?php echo $last_name; ?></span></h3>
            <span class="class"><?php echo $class; ?></span>
             <?php  // check if the repeater field has rows of data
                echo '<ul class="primary-majors">';
                echo '<li>' . $academic_unit[0]->name . '</li>';
                echo '</ul>';
                echo '</div>';
            ?>
        </div>
    </div>
<div id="bio-c-<?php echo $post->post_name ?>" class="accordion-content" aria-labelledby="bio-t-<? echo $post->post_name ?>" aria-hidden="true" aria-controlled-by="bio-t-<? echo $post->post_name ?>" style="display: none;">
            
    <ul class="ambassador-info">
        <?php if (!empty($academic_unit)) : ?>
            <div class="row"><div class="prompt">Academic Unit:</div><ul class="answer-content"><?php echo $academic_unit[0]->name; ?></ul></div>
        <?php endif; ?>  
        <?php if (!empty($faculty_advisor)) : ?>
            <div class="row"><div class="prompt">Faculty Advisor:</div> <li class="answer-content"><?php echo $faculty_advisor; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($last_school)) : ?>
            <div class="row"><div class="prompt">Doctorate from:</div> <li class="answer-content"><?php echo $last_school; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($year_joined_uw)) : ?>
            <div class="row"><div class="prompt">Joined UW:</div> <li class="answer-content"><?php echo $quarter_joined_uw . ' ' . $year_joined_uw; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($current_research_project)) : ?>
            <div class="row"><div class="prompt">Current project:</div> <li class="answer-content"><?php echo $current_research_project; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($research_description)) : ?>
            <div class="row"><div class="prompt">Research description:</div> <li class="answer-content"><?php echo $research_description; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($research_image)) : ?>
            <div class="row"><div class="prompt">Research graphic:</div> <li class="answer-content"><img src="<?php echo $research_image['url']; ?>" alt="<?php echo $research_image['alt']; ?>" /></li></div>
        <?php endif; ?>
        <?php if (!empty($citations)) : ?>
            <div class="row"><div class="prompt">Top two citations:</div> <li class="answer-content"><?php echo $citations; ?></li></div>
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
