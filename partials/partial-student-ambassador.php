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
$tags = get_the_term_list($post->ID, 'student_tag', '' , ', ');
$tags = strip_tags($tags);


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
                    $majors = '';
                    $minors = '';
                    // loop through the rows of data
                    while ( have_rows('majors_and_minors') ) : the_row();

                        // display a sub field value
                        $raw_major = get_sub_field('major__minor');
                        $concentration = get_sub_field('concentration');
                        $primary = get_sub_field('primary_majors');
                        $minor = get_sub_field('minor');
                        $other_major = get_sub_field('other_major');
                        $link_to_major_info = get_sub_field('link_to_major_info');
                        if (!empty($other_major)){
                            $major = $other_major;
                        } else {
                            $major = $raw_major;
                        }
                        if (empty($link_to_major_info) && empty($other_major)){
                            $link_to_major_info = '/students/degrees-programs-and-courses/undergraduate-degrees/#' . sanitize_title($major);
                        }
                        if (empty($primary)) {
                            $primary = "not-primary";
                        } else {
                            $primary = "primary";
                        }
                        if ($minor) {
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

                    // no rows found

                endif;
            ?>
        </div>
    </div>
<div id="bio-c-<?php echo $post->post_name ?>" class="accordion-content" aria-labelledby="bio-t-<? echo $post->post_name ?>" aria-hidden="true" aria-controlled-by="bio-t-<? echo $post->post_name ?>" style="display: none;">
            
    <ul class="ambassador-info">
        <?php if (!empty($majors)) : ?>
            <div class="row"><div class="prompt">Major(s):</div><ul class="answer-content"><?php echo $majors; ?></ul></div>
        <?php endif; ?>  
        <?php if (!empty($minor)) : ?>
        <div class="row"><div class="prompt">Minor(s):</div><ul class="answer-content"><?php echo $minors; ?></ul></div>
        <?php endif; ?>  
        <?php if (!empty($hometown)) : ?>
            <div class="row"><div class="prompt">Hometown:</div> <li class="answer-content"><?php echo $hometown; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($last_school)) : ?>
            <div class="row"><div class="prompt">Last School:</div> <li class="answer-content"><?php echo $last_school; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($description)) : ?>
            <div class="row"><div class="prompt">Ask <?php echo $first_name ?> About:</div> <li class="answer-content"><?php echo $tags; ?></li></div>
        <?php endif; ?>
        <?php if (!empty($description)) : ?>
            <div class="row"><div class="prompt">About <?php echo $first_name ?>:</div> <li class="answer-content"><?php echo $description; ?></li></div>
        <?php endif; ?>
        <div class="row">
            <div class="prompt">Connect:</div>
            <ul class="answer-content">
            <li><a href="mailto:coenvamb@uw.edu?subject=Question%20for%20<?php the_title(); ?>"><i class="icon-mail"></i>Email <?php echo $first_name; ?></a></li>
            <?php if (!empty($twitter)) : ?>
                <li><a href="<?php echo $twitter; ?>"><i class="icon-twitter"></i>Follow <?php echo $first_name; ?> on Twitter</a></li>
            <?php endif; ?>
            <?php if (!empty($linkedin)) : ?>
                <li><a href="<?php echo $linked_in; ?>"><i class="icon-link"></i>Connect with <?php echo $first_name; ?> on LinkedIn</a></li>
            <?php endif; ?>                
            </ul>
        </div>
    </ul>
    </div>