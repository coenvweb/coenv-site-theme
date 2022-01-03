<?php function degrees_func($atts, $content = null) {
    $attributes = shortcode_atts( array(
        'ids' => '',
        'type' => ''
    ), $atts);

    if($attributes['type'] === "undergrad-majors") {
        $major_page = get_page_by_title( 'Undergraduate Degrees and Minors*' );
        $major_field = 'majors';
    }

    if($attributes['type'] === "undergrad-minors") {
        $major_page = get_page_by_title( 'Undergraduate Degrees and Minors*' );
        $major_field = 'minors';
    }

    if($attributes['type'] === "grad-research-degrees") {
        $major_page = get_page_by_title( 'Graduate Degrees*' );
        $major_field = 'research_degrees';
    }

    if($attributes['type'] === "grad-dual-title-research-degrees") {
        $major_page = get_page_by_title( 'Graduate Degrees*' );
        $major_field = 'dt_research_degrees';
    }

    if($attributes['type'] === "grad-professional-degrees") {
        $major_page = get_page_by_title( 'Graduate Degrees*' );
        $major_field = 'professional_degrees';
    }

    if($attributes['type'] === "grad-certificate-programs") {
        $major_page = get_page_by_title( 'Graduate Degrees*' );
        $major_field = 'certificate_degrees';
    }

    if($attributes['ids']) {
        $degrees = get_field($major_field, $major_page);
        $degrees = array($degrees[$attributes['ids']]);
        $ids = explode(',', $attributes['ids']);
        $degrees_acf = get_field($major_field, $major_page);
        $degrees = array();
        foreach($ids as $id) {
            $id = $id - 1;
            if($degrees_acf[$id]) {
                $degrees[] = $degrees_acf[$id];
            }
        }
    } else {
        $degrees = get_field($major_field, $major_page);
    }

    ob_start();


        // check if the repeater field has rows of data
        if( have_rows($major_field, $major_page->ID) ):

            // loop through the rows of data
            while ( have_rows($major_field, $major_page->ID) ) : the_row();

                // display a sub field value
                
                get_template_part( 'partials/partial', 'major-minor' );

            endwhile;

        else :

            // no rows found

        endif;

    return ob_get_clean();
}
add_shortcode('degrees', 'degrees_func');