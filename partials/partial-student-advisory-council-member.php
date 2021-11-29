<?php  
/**
 * An individual Student Ambassador
 */

$first_name = get_field('first_name');
$first_name_san = sanitize_title($first_name);
$last_name = get_field('last_name');
$last_name_san = sanitize_title($last_name);
$pronouns = get_field('pronouns');
$image = get_field('photo');
$class = get_field('class');
$department_degree = get_field('department_and_pursued_degree');
$academic_unit = get_field('academic_unit');
$description = get_field('sac_about_me');
$representing_org = get_field('sac_representing');
$random_fact = get_field('sac_random_fact');
//$email = get_field('email');


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
<div id="bio-t-<?php echo $post->post_name; ?>" class="contact <?php if(!empty($description)) { ?>accordion-title read" aria-label="Toggle more information" tabindex="0<?php } ?>" aria-expanded="false">

    <img class="alignleft" src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" width="130" height="130" />

    <div class="contact-info">
        <div class="contact-title">
            <h3><?php echo $first_name; ?><span class="last"> <?php echo $last_name; ?></span></h3>
            <span class="class"><?php echo $class; ?></span>
             <?php  // check if the repeater field has rows of data
             $majors = '';
                if( have_rows('majors_and_minors') ) :
                    echo '<ul class="primary-majors">';
                    // loop through the rows of data
                    while ( have_rows('majors_and_minors') ) : the_row();

                        // display a sub field value
                        $raw_major = get_sub_field('major__minor');
                        $concentration = get_sub_field('concentration');
                        $primary = get_sub_field('primary_majors');
                        $minor = get_sub_field('minor');
                        $other_major = get_sub_field('other_major');
                        $link_to_major_info = get_sub_field('link_to_major_info');
                        if ($raw_major == 'Other'){
                            $major = $other_major;
                        } else {
                            $major = $raw_major;
                        }
                        if (empty($link_to_major_info) && ($raw_major !== 'Other')){
                            if ($major == 'Aquatic and Fishery Sciences') {
                                $link_to_major_info = 'https://fish.uw.edu/students/about-undergraduate-program/degrees-offered/';
                            }
                            if ($major == 'Atmospheric Sciences') {
                                $link_to_major_info = 'http://www.atmos.washington.edu/academics/undergrads/degrees.shtml#bs';
                            }
                            if ($major == 'Bioresource Science and Engineering') {
                                $link_to_major_info = 'http://depts.washington.edu/sefsbse/';
                            }
                            if ($major == 'Earth and Space Sciences') {
                                $link_to_major_info = 'http://www.ess.washington.edu/education/undergrad/';
                            }
                            if ($major == 'Environmental Science and Terrestrial Resource Management') {
                                $link_to_major_info = 'http://www.sefs.washington.edu/academicPrograms/undergrad/index.shtml';
                            }
                            if ($major == 'Environmental Studies') {
                                $link_to_major_info = 'https://envstudies.uw.edu/undergraduate-students/prospective-students-undergrad/';
                            }
                            if ($major == 'Oceanography') {
                                $link_to_major_info = 'http://www.ocean.washington.edu/story/Undergraduate_Education';
                            }
                            if ($major == 'Climate Science') {
                                $link_to_major_info = 'https://pcc.uw.edu/education/undergraduate-minor/';
                            }
                            if ($major == 'Marine Biology') {
                                $link_to_major_info = 'https://marinebiology.uw.edu/students/marine-biology-minor/';
                            }
                            if ($major == 'Quantitative Science') {
                                $link_to_major_info = 'http://depts.washington.edu/cqs/minor.html';
                            }
                        }
                        if (empty($primary)) {
                            $primary = "not-primary";
                        } else {
                            $primary = "primary";
                        }
                        if ($minor) {
                            $minors = '';
                            $minors .= '<li>' . $major;
                            if (!empty($concentration)){
                                $minors .= '<span class="concentration">: ' . $concentration . ' </span></li>';
                            } else {
                                $minors .= '</li>';
                            }
                        } else {
                            $this_major = $major;
                            if (!empty($concentration)){
                                $this_major .= '<span class="concentration">: ' . $concentration . '</span>';
                            }
                            echo '<li class="' . $primary . ' ' . $minor . '">' . $this_major . '</li>';
                            if (!empty ($link_to_major_info)) {
                                $this_major = '<li class="' . $primary . ' ' . $minor . '"><a href="' . $link_to_major_info . '">' . $this_major . '</a></li>';
                            } else {
                                $this_major = '<li class="' . $primary . ' ' . $minor . '">' . $this_major . '</li>';
                            }
                            $majors .= $this_major;
                        }

                    endwhile;

                    echo '</div>';
                else :
                    if (isset($department_degree)) {
                        echo '<ul class="primary-majors"><li class="primary">' . $department_degree . '</li></ul></div>';
                    } elseif (isset($academic_unit)) {
                        echo '<ul class="primary-majors"><li class="primary">' . $academic_unit[0]->name . '</li></ul></div>';
                    }

                endif;
            ?>
        </div>
    </div>
<div id="bio-c-<?php echo $post->post_name; ?>" class="accordion-content" aria-labelledby="bio-t-<?php echo $post->post_name ?>" aria-hidden="true" aria-controlled-by="bio-t-<?php echo $post->post_name ?>" style="display: none;">
            
    <ul class="ambassador-info">
        <?php if (!empty($majors)) : ?>
            <div class="row"><div class="prompt">Major(s):</div><ul class="answer-content"><?php echo $majors; ?></ul></div>
        <?php endif; ?>  
        <?php if (!empty($minor)) : ?>
        <div class="row"><div class="prompt">Minor(s):</div><ul class="answer-content"><?php echo $minors; ?></ul></div>
        <?php endif; ?>
        <?php if (!empty($department_degree)) : ?>
            <div class="row"><div class="prompt">Department and pursued degree:</div><ul class="answer-content"><?php echo $department_degree; ?></ul></div>
        <?php endif; ?> 
        <?php if (!empty($academic_unit)) : ?>
            <div class="row"><div class="prompt">Academic Unit:</div><ul class="answer-content"><?php echo $academic_unit[0]->name; ?></ul></div>
        <?php endif; ?>  
        <?php if (!empty($representing_org)) : ?>
            <div class="row"><div class="prompt">Representing:</div> <li class="answer-content"><?php echo $representing_org; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($pronouns)) : ?>
            <div class="row"><div class="prompt">Pronouns:</div> <li class="answer-content"><?php echo $pronouns; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($description)) : ?>
            <div class="row"><div class="prompt">About <?php echo $first_name ?>:</div> <li class="answer-content"><?php echo $description; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($random_fact)) : ?>
            <div class="row"><div class="prompt">Random fact about <?php echo $first_name ?>:</div> <li class="answer-content"><?php echo $random_fact; ?></li></div>
        <?php endif; ?>
        <!--<div class="row">
            <div class="prompt">Connect:</div>
            <ul class="answer-content">
            <li><a href="mailto:envamb@uw.edu?subject=Question%20for%20<?php //the_title(); ?>"><i class="icon-mail"></i>Email <?php //echo $first_name; ?></a></li>      
            </ul>
        </div>-->
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
