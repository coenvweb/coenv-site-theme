<?php  
/**
 * An individual Graduate Profile
 */

$first_name = get_field('first_name');
$last_name = get_field('last_name');
$image = get_field('photo');
$department_degree = get_field('department_and_pursued_degree');
$last_school = get_field('last_school');
$undergrad_degree = get_field('undergraduate_degree');
$hometown = get_field('hometown');
$kid_become = get_field('kid_become');
$research_interests = get_field('research_interests');
$location = get_field('location');
$career_aspiration = get_field('career_aspiration');
$why_study = get_field('why_study_environment');
$meaningful_moment = get_field('meaningful_moment');
$faculty_advisor = get_field('faculty_advisor');
$tags = get_the_term_list($post->ID, 'student_tag', '' , ', ');
$tags = strip_tags($tags);
$linkedin = get_field('linkedin_profile_link');
$twitter = get_field('twitter_profile_link');


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
<div id="bio-t-<?php echo $post->post_name ?>" class="contact accordion-title read" aria-label="Toggle more information" tabindex="0" aria-expanded="false">

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
            <div class="row"><div class="prompt">Degree and department:</div><ul class="answer-content"><?php echo $department_degree; ?></ul></div>
        <?php endif; ?>  
        <?php if (!empty($hometown)) : ?>
            <div class="row"><div class="prompt">Hometown:</div> <li class="answer-content"><?php echo $hometown; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($last_school)) : ?>
            <div class="row"><div class="prompt">Undergraduate institution:</div> <li class="answer-content"><?php echo $last_school; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($undergrad_degree)) : ?>
            <div class="row"><div class="prompt">Undergraduate degree:</div> <li class="answer-content"><?php echo $undergrad_degree; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($kid_become)) : ?>
            <div class="row"><div class="prompt">When I was a kid, I wanted to become:</div> <li class="answer-content"><?php echo $kid_become; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($research_interests)) : ?>
            <div class="row"><div class="prompt">Research interests:</div> <li class="answer-content"><?php echo $research_interests; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($location)) : ?>
            <div class="row"><div class="prompt">Research location:</div> <li class="answer-content"><?php echo $location; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($career_aspiration)) : ?>
            <div class="row"><div class="prompt">Career aspiration:</div> <li class="answer-content"><?php echo $career_aspiration; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($why_study)) : ?>
            <div class="row"><div class="prompt">Why do you study the environment?:</div> <li class="answer-content"><?php echo $why_study; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($meaningful_moment)) : ?>
            <div class="row"><div class="prompt">What has been your most meaningful moment in graduate school?:</div> <li class="answer-content"><?php echo $meaningful_moment; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($faculty_advisor)) : ?>
            <div class="row"><div class="prompt">Faculty advisor:</div> <li class="answer-content"><?php echo $faculty_advisor; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($tags)) : ?>
            <div class="row"><div class="prompt">Ask <?php echo $first_name ?> About:</div> <li class="answer-content"><?php echo $tags; ?></li></div>
        <?php endif; ?>
        <div class="row">
            <div class="prompt">Connect:</div>
            <ul class="answer-content">
            <li><a href="mailto:coenvamb@uw.edu?subject=Question%20for%20<?php the_title(); ?>"><i class="icon-mail"></i>Email <?php echo $first_name; ?></a></li>
            <?php if (!empty($twitter)) : ?>
                <li><a href="<?php echo $twitter; ?>"><i class="icon-twitter"></i>Follow <?php echo $first_name; ?> on Twitter</a></li>
            <?php endif; ?>
            <?php if (!empty($linkedin)) : ?>
                <li><a href="<?php echo $linkedin; ?>"><i class="icon-link"></i>Connect with <?php echo $first_name; ?> on LinkedIn</a></li>
            <?php endif; ?>                
            </ul>
        </div>
    </ul>
    </div>
