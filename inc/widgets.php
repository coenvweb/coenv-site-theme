<?php



function coenv_widgets_init() {

	$before_widget	= '<section id="%1$s" class="widget %2$s">';
	$before_title 	= '<header class="section-header"><h3>';
	$after_title	= '</h3></header> <!-- end .section-header -->';
	$after_widget	= '</section> <!-- end #%1$s -->';

	// this will return only top-level pages
	$pages = get_pages('parent=0&sort_column=menu_order&sort_order=ASC');

	// remove specific pages by page name
	$pages_to_remove = array( );

	if ( empty( $pages ) ) {
		return false;
	}

	foreach( $pages as $page ) {
        // remove specific pages
		if( !in_array( $page->post_name, $pages_to_remove ) ) {
            if ((get_field('show_as_top-level_page', $page->ID) == true ) || has_post_thumbnail($page->ID) || (get_option('page_on_front') == $page->ID) && ($page->post_title !== 'Home')){
                register_sidebar( array(
                    'name' 			=> $page->post_title . ' / Sidebar',
                    'id'			=> 'sidebar-' . $page->ID,
                    'before_widget' => $before_widget,
                    'after_widget'	=> $after_widget,
                    'before_title' 	=> $before_title,
                    'after_title'	=> $after_title
                ) );
                register_sidebar( array(
                    'name' 			=> $page->post_title . ' / Footer',
                    'id'			=> 'sidebar-footer-' . $page->ID,
                    'before_widget' => $before_widget,
                    'after_widget'	=> $after_widget,
                    'before_title' 	=> $before_title,
                    'after_title'	=> $after_title
                ) );
            }
            if( ($page->post_title == 'Home')){
                register_sidebar( array(
                    'name' 			=> 'Homepage / Sidebar',
                    'id'			=> 'sidebar-' . $page->ID,
                    'before_widget' => $before_widget,
                    'after_widget'	=> $after_widget,
                    'before_title' 	=> '<header class="section-header"><h2>',
                    'after_title'	=> '</h2></header> <!-- end .section-header -->'
                ) );
            }
		}
	}

	$additional_sidebars = array('Search');

	if ( !empty( $additional_sidebars ) ) {
		foreach ( $additional_sidebars as $sidebar ) {
			register_sidebar( array(
				'name' => $sidebar,
				'id' => 'sidebar-' . str_replace(' ', '-', strtolower( $sidebar ) ),
				'before_widget' => $before_widget,
				'after_widget'	=> $after_widget,
				'before_title' 	=> $before_title,
				'after_title'	=> $after_title
			) );
		}
	}

}

add_action( 'widgets_init', 'coenv_widgets_init' );

/*
|---------------------------------------------------------------------------
| Register custom widgets
|---------------------------------------------------------------------------
*/

// deactivate new widget block editor
function phi_theme_support() {
	remove_theme_support( 'widgets-block-editor' );
}
add_action( 'after_setup_theme', 'phi_theme_support' );

/**
 * Social Links Widget
 */
register_widget( 'CoEnv_Widget_Social' );

class CoEnv_Widget_Social extends WP_Widget {
 
  public function __construct() {
		$args = array(
			'classname' => 'widget-social',
			'description' => __( 'Display a grid of social media links from the General Settings', 'coenv' )
		);
 
		parent::__construct(
			'social_links', // base ID
			'Social Media Links', // name
			$args
		);
	}
 
	public function form( $instance ) {
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Connect with the College', 'coenv' );
		}
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		 
		return $instance;
	}
 
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
 
		echo $before_widget;
		?>

        <?php if(!empty($title)) { ?>	
			<?php echo $before_title ?><span><?php echo $title; ?></span><?php echo $after_title ?><?php }; ?>
			<ul>
				<?php if ( !is_front_page() ) { ?>
					<li class="newsletter">
						<a href="/news/college-newsletter/" title="Subscribe to the <?php bloginfo('name'); ?> email newsletter">
							<svg width="30" height="30" viewBox="0 0 34 34" style="display: inline-table; fill: #000; ">
								<path d="M28 11.094v12.406c0 1.375-1.125 2.5-2.5 2.5h-23c-1.375 0-2.5-1.125-2.5-2.5v-12.406c0.469 0.516 1 0.969 1.578 1.359 2.594 1.766 5.219 3.531 7.766 5.391 1.313 0.969 2.938 2.156 4.641 2.156h0.031c1.703 0 3.328-1.188 4.641-2.156 2.547-1.844 5.172-3.625 7.781-5.391 0.562-0.391 1.094-0.844 1.563-1.359zM28 6.5c0 1.75-1.297 3.328-2.672 4.281-2.438 1.687-4.891 3.375-7.313 5.078-1.016 0.703-2.734 2.141-4 2.141h-0.031c-1.266 0-2.984-1.437-4-2.141-2.422-1.703-4.875-3.391-7.297-5.078-1.109-0.75-2.688-2.516-2.688-3.938 0-1.531 0.828-2.844 2.5-2.844h23c1.359 0 2.5 1.125 2.5 2.5z"></path>
							</svg>
							<span class="social-widget-text">Headlines Newsletter</span>
						</a>
					</li>
				<li class="podcast">
					<a href="/alumni-and-community/fieldsound-podcast/" title="Subscribe to the FieldSound podcast ?>" target="_blank" rel="nofollow" class="external">
						<svg width="30" height="30" viewBox="0 0 34 34" style="display: inline-table; fill: #000; ">
							<path d="M29 0h-26c-1.65 0-3 1.35-3 3v26c0 1.65 1.35 3 3 3h26c1.65 0 3-1.35 3-3v-26c0-1.65-1.35-3-3-3zM8.719 25.975c-1.5 0-2.719-1.206-2.719-2.706 0-1.488 1.219-2.712 2.719-2.712 1.506 0 2.719 1.225 2.719 2.712 0 1.5-1.219 2.706-2.719 2.706zM15.544 26c0-2.556-0.994-4.962-2.794-6.762-1.806-1.806-4.2-2.8-6.75-2.8v-3.912c7.425 0 13.475 6.044 13.475 13.475h-3.931zM22.488 26c0-9.094-7.394-16.5-16.481-16.5v-3.912c11.25 0 20.406 9.162 20.406 20.413h-3.925z"></path>
						</svg>
						<span class="social-widget-text">Podcast</span>
					</a>
				</li>
				<?php } ?>
				<?php if (get_option('instagram')) { ?>
					<li class="instagram">
						<a href="<?php echo get_option('instagram'); ?>" title="Follow <?php bloginfo('name'); ?> on Instagram" target="_blank" rel="nofollow" class="external">
							<svg width="30" height="30" viewBox="0 0 34 34" style="display: inline-table; fill: #000; ">
								<path d="M16 2.881c4.275 0 4.781 0.019 6.462 0.094 1.563 0.069 2.406 0.331 2.969 0.55 0.744 0.288 1.281 0.638 1.837 1.194 0.563 0.563 0.906 1.094 1.2 1.838 0.219 0.563 0.481 1.412 0.55 2.969 0.075 1.688 0.094 2.194 0.094 6.463s-0.019 4.781-0.094 6.463c-0.069 1.563-0.331 2.406-0.55 2.969-0.288 0.744-0.637 1.281-1.194 1.837-0.563 0.563-1.094 0.906-1.837 1.2-0.563 0.219-1.413 0.481-2.969 0.55-1.688 0.075-2.194 0.094-6.463 0.094s-4.781-0.019-6.463-0.094c-1.563-0.069-2.406-0.331-2.969-0.55-0.744-0.288-1.281-0.637-1.838-1.194-0.563-0.563-0.906-1.094-1.2-1.837-0.219-0.563-0.481-1.413-0.55-2.969-0.075-1.688-0.094-2.194-0.094-6.463s0.019-4.781 0.094-6.463c0.069-1.563 0.331-2.406 0.55-2.969 0.288-0.744 0.638-1.281 1.194-1.838 0.563-0.563 1.094-0.906 1.838-1.2 0.563-0.219 1.412-0.481 2.969-0.55 1.681-0.075 2.188-0.094 6.463-0.094zM16 0c-4.344 0-4.887 0.019-6.594 0.094-1.7 0.075-2.869 0.35-3.881 0.744-1.056 0.412-1.95 0.956-2.837 1.85-0.894 0.888-1.438 1.781-1.85 2.831-0.394 1.019-0.669 2.181-0.744 3.881-0.075 1.713-0.094 2.256-0.094 6.6s0.019 4.887 0.094 6.594c0.075 1.7 0.35 2.869 0.744 3.881 0.413 1.056 0.956 1.95 1.85 2.837 0.887 0.887 1.781 1.438 2.831 1.844 1.019 0.394 2.181 0.669 3.881 0.744 1.706 0.075 2.25 0.094 6.594 0.094s4.888-0.019 6.594-0.094c1.7-0.075 2.869-0.35 3.881-0.744 1.050-0.406 1.944-0.956 2.831-1.844s1.438-1.781 1.844-2.831c0.394-1.019 0.669-2.181 0.744-3.881 0.075-1.706 0.094-2.25 0.094-6.594s-0.019-4.887-0.094-6.594c-0.075-1.7-0.35-2.869-0.744-3.881-0.394-1.063-0.938-1.956-1.831-2.844-0.887-0.887-1.781-1.438-2.831-1.844-1.019-0.394-2.181-0.669-3.881-0.744-1.712-0.081-2.256-0.1-6.6-0.1v0z"></path>
								<path d="M16 7.781c-4.537 0-8.219 3.681-8.219 8.219s3.681 8.219 8.219 8.219 8.219-3.681 8.219-8.219c0-4.537-3.681-8.219-8.219-8.219zM16 21.331c-2.944 0-5.331-2.387-5.331-5.331s2.387-5.331 5.331-5.331c2.944 0 5.331 2.387 5.331 5.331s-2.387 5.331-5.331 5.331z"></path>
								<path d="M26.462 7.456c0 1.060-0.859 1.919-1.919 1.919s-1.919-0.859-1.919-1.919c0-1.060 0.859-1.919 1.919-1.919s1.919 0.859 1.919 1.919z"></path>
							</svg>
							<span class="social-widget-text">Instagram</span>
						</a>
					</li>
				<?php } ?>
				<?php if (get_option('linkedin')) { ?>
					<li class="linkedin">
						<a href="<?php echo get_option('linkedin'); ?>" title="Follow <?php bloginfo('name'); ?> on LinkedIn" target="_blank" rel="nofollow" class="external">
							<svg width="30" height="30" viewBox="0 0 34 34" style="display: inline-table; fill: #000; ">
								<g transform="scale(0.03125 0.03125)">
									<path d="M928 0h-832c-52.8 0-96 43.2-96 96v832c0 52.8 43.2 96 96 96h832c52.8 0 96-43.2 96-96v-832c0-52.8-43.2-96-96-96zM384 832h-128v-448h128v448zM320 320c-35.4 0-64-28.6-64-64s28.6-64 64-64c35.4 0 64 28.6 64 64s-28.6 64-64 64zM832 832h-128v-256c0-35.4-28.6-64-64-64s-64 28.6-64 64v256h-128v-448h128v79.4c26.4-36.2 66.8-79.4 112-79.4 79.6 0 144 71.6 144 160v288z"></path>
								</g>
							</svg>
							<span class="social-widget-text">LinkedIn</span>
						</a>
					</li>
			<?php } ?>
			<?php if (get_option('facebook')) { ?>
					<li class="facebook">
						<a href="<?php echo get_option('facebook'); ?>" title="Follow <?php bloginfo('name'); ?> on Facebook" target="_blank" rel="nofollow" class="external">
							<svg width="30" height="30" viewBox="0 2 37 34" style="display: inline-table; fill: #000; ">
								<path d="M19 6h5v-6h-5c-3.86 0-7 3.14-7 7v3h-4v6h4v16h6v-16h5l1-6h-6v-3c0-0.542 0.458-1 1-1z"></path>
							</svg>
							<span class="social-widget-text">Facebook</span>
						</a>
					</li>
			<?php } ?>					
					<li class="bluesky">
						<a href="https://bsky.app/profile/uwenvironment.bsky.social" title="Follow <?php bloginfo('name'); ?> on Bluesky" target="_blank" rel="nofollow" class="external">
							<svg width="30" height="30" viewBox="0 0 34 34" style="display: inline-table; fill: #000; "><g transform="scale(0.055 0.055)">
								<path d="M123.121 33.6637C188.241 82.5526 258.281 181.681 284 234.873C309.719 181.681 379.759 82.5526 444.879 33.6637C491.866 -1.61183 568 -28.9064 568 57.9464C568 75.2916 558.055 203.659 552.222 224.501C531.947 296.954 458.067 315.434 392.347 304.249C507.222 323.8 536.444 388.56 473.333 453.32C353.473 576.312 301.061 422.461 287.631 383.039C285.169 375.812 284.017 372.431 284 375.306C283.983 372.431 282.831 375.812 280.369 383.039C266.939 422.461 214.527 576.312 94.6667 453.32C31.5556 388.56 60.7778 323.8 175.653 304.249C109.933 315.434 36.0535 296.954 15.7778 224.501C9.94525 203.659 0 75.2916 0 57.9464C0 -28.9064 76.1345 -1.61183 123.121 33.6637Z"></path>
							</svg>
							<span class="social-widget-text">Bluesky</span>
						</a>
					</li>
			<?php if (get_option('youtube')) { ?>
					<li class="youtube">
						<a href="https://www.youtube.com/user/UWEnvironment" title="Follow <?php bloginfo('name'); ?> on YouTube" target="_blank" rel="nofollow" class="external">
							<svg width="30" height="30" viewBox="0 0 34 34" style="display: inline-table; fill: #000; ">
								<path d="M31.681 9.6c0 0-0.313-2.206-1.275-3.175-1.219-1.275-2.581-1.281-3.206-1.356-4.475-0.325-11.194-0.325-11.194-0.325h-0.012c0 0-6.719 0-11.194 0.325-0.625 0.075-1.987 0.081-3.206 1.356-0.963 0.969-1.269 3.175-1.269 3.175s-0.319 2.588-0.319 5.181v2.425c0 2.587 0.319 5.181 0.319 5.181s0.313 2.206 1.269 3.175c1.219 1.275 2.819 1.231 3.531 1.369 2.563 0.244 10.881 0.319 10.881 0.319s6.725-0.012 11.2-0.331c0.625-0.075 1.988-0.081 3.206-1.356 0.962-0.969 1.275-3.175 1.275-3.175s0.319-2.587 0.319-5.181v-2.425c-0.006-2.588-0.325-5.181-0.325-5.181zM12.694 20.15v-8.994l8.644 4.513-8.644 4.481z"></path>
							</svg>
							<span class="social-widget-text">YouTube</span>
						</a>
					</li>
			<?php } ?>

			<?php if ( is_front_page() ) { ?>
				<li class="newsletter">
						<a href="/news/college-newsletter/" title="Subscribe to the <?php bloginfo('name'); ?> email newsletter">
							<svg width="30" height="30" viewBox="0 0 34 34" style="display: inline-table; fill: #000; ">
								<path d="M28 11.094v12.406c0 1.375-1.125 2.5-2.5 2.5h-23c-1.375 0-2.5-1.125-2.5-2.5v-12.406c0.469 0.516 1 0.969 1.578 1.359 2.594 1.766 5.219 3.531 7.766 5.391 1.313 0.969 2.938 2.156 4.641 2.156h0.031c1.703 0 3.328-1.188 4.641-2.156 2.547-1.844 5.172-3.625 7.781-5.391 0.562-0.391 1.094-0.844 1.563-1.359zM28 6.5c0 1.75-1.297 3.328-2.672 4.281-2.438 1.687-4.891 3.375-7.313 5.078-1.016 0.703-2.734 2.141-4 2.141h-0.031c-1.266 0-2.984-1.437-4-2.141-2.422-1.703-4.875-3.391-7.297-5.078-1.109-0.75-2.688-2.516-2.688-3.938 0-1.531 0.828-2.844 2.5-2.844h23c1.359 0 2.5 1.125 2.5 2.5z"></path>
							</svg>
							<span class="social-widget-text">Headlines Newsletter</span>
						</a>
					</li>
			<?php } ?>
			</ul>
		<?php
		echo $after_widget;
	}
}

/**
 * Undergrad Majors and Minors Widget
 */
register_widget( 'CoEnv_Widget_UG_majors' );

class CoEnv_Widget_UG_majors extends WP_Widget {
 
  public function __construct() {
		$args = array(
			'classname' => 'widget-majors',
			'description' => __( 'Display a grid of the college\'s degrees', 'coenv' )
		);
 
		parent::__construct(
			'major_links', // base ID
			'Majors and Minors Links', // name
			$args
		);
	}
 
	public function form( $instance ) {
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Graduate Degrees', 'coenv' );
		}
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		 
		return $instance;
	}
 
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
 
		echo $before_widget;
		?>
			<?php if (!empty($title)) { ?>
			<?php echo $before_title ?><span><?php echo $title; ?></span><?php echo $after_title ?>
            <?php }; ?>
			<article class="majors-minors-section">
                <section class="majors-minors accordion" id="major">
                <?php
                
                $major_page = get_page_by_title( 'Undergraduate Degrees' ); 

                // check if the repeater field has rows of data
                if( have_rows('majors', $major_page->ID) ):

                    // loop through the rows of data
                    while ( have_rows('majors', $major_page->ID) ) : the_row();

                        // display a sub field value
                        get_template_part( 'partials/partial', 'major-minor' );

                    endwhile;

                else :

                    // no rows found

                endif;

                ?>
                </section>
                </article>
 
		<?php
		echo $after_widget;
	}
 
}

/**
 * Grad Majors and Minors Widget
 */
register_widget( 'CoEnv_Widget_G_degrees' );

class CoEnv_Widget_G_degrees extends WP_Widget {
 
  public function __construct() {
		$args = array(
			'classname' => 'widget-majors',
			'description' => __( 'Display a grid of the college\'s graduate degrees', 'coenv' )
		);
 
		parent::__construct(
			'grad_degree_links', // base ID
			'Graduate Degree Links', // name
			$args
		);
	}
 
	public function form( $instance ) {
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Graduate Degrees', 'coenv' );
		}
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		 
		return $instance;
	}
 
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
 
		echo $before_widget;
		?>
			<?php if (!empty($title)) { ?>
			<?php echo $before_title ?><span><?php echo $title; ?></span><?php echo $after_title ?>
            <?php }; ?>
			<article class="majors-minors-section">
        <section class="majors-minors accordion" id="major">
        <?php

        $major_page = get_page_by_title( 'Graduate Degrees' ); 

        // check if the repeater field has rows of data
        if( have_rows('majors', $major_page->ID) ):

            // loop through the rows of data
            while ( have_rows('majors', $major_page->ID) ) : the_row();

                // display a sub field value
                get_template_part( 'partials/partial', 'major-minor' );

            endwhile;

        else :

            // no rows found

        endif;

        ?>
        </section>
    </article>
 
		<?php
		echo $after_widget;
	}
 
}

/**
 * Events Widget
 */
register_widget( 'CoEnv_Widget_Events' );
class CoEnv_Widget_Events extends WP_Widget {

	public function __construct() {
		$args = array(
			'classname' => 'widget widget-events',
			'description' => __( 'Display a short list of Trumba calendar events.', 'coenv' )
		);
 
		parent::__construct(
			'trumba_events', // base ID
			'Trumba Events', // name
			$args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$feed_url = apply_filters( 'feed_url', $instance['feed_url'] );
		$events_url = apply_filters( 'events_url', $instance['events_url'] );
		$posts_per_page = (int) $instance['posts_per_page'];

		if ( !isset( $feed_url ) || empty( $feed_url ) ) {
			return;
		}

		// get cached XML from WP transient API
        unset ($events_xml);
        $events_xml = get_transient( 'trumba_events_xml' );
        $ctx = stream_context_create(array('http'=>
                array(
                    'timeout' => 3,  //1200 Seconds is 20 Minutes
                    'ignore_errors' => true
                ),
                'ssl' => array('verify_peer' => false, 'verify_peer_name' => false),
            ));

            if ($events_xml = @file_get_contents( $feed_url, false, $ctx )) {
            } else {
                return;
            };

        $xml = new SimpleXmlElement($events_xml);
		
		$events = array();

		foreach ($xml->channel->item as $item) {     
			$events[] = array(
				'title' => $item->title,
				'date'	=> $item->category,
				'url'	=> $item->link
			);
		}

		if ( empty( $events ) ) {
			return;
		}

		$events = array_slice( $events, 0, $posts_per_page );

		?>
			<?php echo $before_widget ?>
			
				<?php echo $before_title ?>

					<span><a href="<?php echo $events_url; ?>"><?php echo $title ?></a></span>

					<?php if ( $events_url != '' ) : ?>
                                   
						<a class="more" href="<?php echo $events_url; ?>" title="View All Events">More events &raquo;</a>
					<?php endif ?>

				<?php echo $after_title ?>

			<?php if ( count( $events ) ) : ?>

				<?php foreach ( $events as $key => $event ) : ?>

					<article class="event">

						<a href="<?php echo $event['url'] ?>">
                                
                                <?php
                                $date = substr($event['date'], 0, -6);
                                $date = strtotime($date);
                                $date = date('l, M j, Y ', $date);
                                ?>
								<footer class="meta">
									<p class="date"><i class="icon-calendar"></i> <?php echo $date ?></p>
								</footer>

								<header>
									<h3><?php echo $event['title'] ?></h3>
								</header>

						</a>

					</article>

				<?php endforeach ?>

			<?php else : ?>

				<p>No events found.</p>

			<?php endif ?>

			<?php echo $after_widget ?>
		
		<?php
	}

	public function form( $instance ) {

		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Events', 'coenv' );
		$feed_url = $instance['feed_url'];
		$events_url = $instance['events_url'];
		$posts_per_page = isset( $instance['posts_per_page'] ) ? (int) $instance['posts_per_page'] : 5;
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'feed_url' ) ?>"><?php _e( 'Feed URL:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'feed_url' ) ?>" name="<?php echo $this->get_field_name( 'feed_url' ) ?>" value="<?php echo esc_attr( $feed_url ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'events_url' ) ?>"><?php _e( 'More link (URL):' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'events_url' ) ?>" name="<?php echo $this->get_field_name( 'events_url' ) ?>" value="<?php echo esc_attr( $events_url ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'posts_per_page' ) ?>">Number of events to show: </label>
				<input name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" type="text" size="3" value="<?php echo $posts_per_page ?>" />
			</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['feed_url'] = strip_tags( $new_instance['feed_url'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
		$instance['events_url'] = strip_tags( $new_instance['events_url'] );
		 
		return $instance;
	}

}


/**
 * Sidebar events Widget
 */
register_widget( 'CoEnv_Widget_Events_Sidebar' );
class CoEnv_Widget_Events_Sidebar extends WP_Widget {

	public function __construct() {
		$args = array(
			'classname' => 'widget widget-events-sidebar',
			'description' => __( 'Display a short list of Trumba calendar events.', 'coenv' )
		);
 
		parent::__construct(
			'trumba_events_sidebar', // base ID
			'Trumba Events (sidebar)', // name
			$args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$feed_url = apply_filters( 'feed_url', $instance['feed_url'] );
		$events_url = apply_filters( 'events_url', $instance['events_url'] );
		$posts_per_page = (int) $instance['posts_per_page'];

		if ( !isset( $feed_url ) || empty( $feed_url ) ) {
			return;
		}

		// get cached XML from WP transient API
        unset ($events_xml);
        $events_xml = get_transient( 'trumba_events_xml' );
        $ctx = stream_context_create(array('http'=>
                array(
                    'timeout' => 3,  //1200 Seconds is 20 Minutes
                    'ignore_errors' => true
                ),
                'ssl' => array('verify_peer' => false, 'verify_peer_name' => false),
            ));

            if ($events_xml = @file_get_contents( $feed_url, false, $ctx )) {
            } else {
                return;
            };

        $xml = new SimpleXmlElement($events_xml);
		
		$events = array();

		foreach ($xml->channel->item as $item) {     
			$events[] = array(
				'title' => $item->title,
				'date'	=> $item->category,
				'url'	=> $item->link
			);
		}

		if ( empty( $events ) ) {
			return;
		}

		$events = array_slice( $events, 0, $posts_per_page );

		?>
			<?php echo $before_widget ?>
			
				<?php echo $before_title ?>

					<span><a href="<?php echo $events_url; ?>"><?php echo $title ?></a></span>

				<?php echo $after_title ?>

			<?php if ( count( $events ) ) : ?>

				<?php foreach ( $events as $key => $event ) : ?>

					<article class="event">
                                <?php
                                $date = substr($event['date'], 0, -6);
                                $date = strtotime($date);
                                $date = date('l, M j, Y ', $date);
                                ?>
								<div class="meta">
									<p class="date"><a href="<?php echo $event['url'] ?>"><i class="icon-calendar"></i> <?php echo $date ?></a></p>
								</div>

								<header>
									<h3><a href="<?php echo $event['url'] ?>"><?php echo $event['title'] ?></a></h3>
								</header>
						</a>
					</article>
				<?php endforeach ?>

			<?php else : ?>

				<p>No events found.</p>

			<?php endif ?>
			<?php if ( $events_url != '' ) : ?>
				<div class="textwidget">              
					<p>
						<a class="more" href="<?php echo $events_url; ?>" title="View All Events"><span class="button">More events</span></a>
					</p>
				</div>
			<?php endif ?>
			<?php echo $after_widget ?>
		
		<?php
	}

	public function form( $instance ) {

		$title = isset( $instance['title'] ) ? $instance['title'] : __( 'Events', 'coenv' );
		if ( isset ($instance['feed_url']) ) {
			$feed_url = $instance['feed_url'];
		} else {
			$feed_url = NULL;
		}
		if ( isset ($instance['events_url']) ) {
			$events_url = $instance['events_url'];
		} else {
			$events_url = NULL;
		}
		$posts_per_page = isset( $instance['posts_per_page'] ) ? (int) $instance['posts_per_page'] : 5;
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'feed_url' ) ?>"><?php _e( 'Feed URL:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'feed_url' ) ?>" name="<?php echo $this->get_field_name( 'feed_url' ) ?>" value="<?php echo esc_attr( $feed_url ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'events_url' ) ?>"><?php _e( 'More link (URL):' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'events_url' ) ?>" name="<?php echo $this->get_field_name( 'events_url' ) ?>" value="<?php echo esc_attr( $events_url ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'posts_per_page' ) ?>">Number of events to show: </label>
				<input name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" type="text" size="3" value="<?php echo $posts_per_page ?>" />
			</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['feed_url'] = strip_tags( $new_instance['feed_url'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
		$instance['events_url'] = strip_tags( $new_instance['events_url'] );
		 
		return $instance;
	}

}


/**
 * Headlines Newsletter Widget
 */
register_widget( 'CoEnv_Widget_Newsletter' );

class CoEnv_Widget_Newsletter extends WP_Widget {
 
  public function __construct() {
		$args = array(
			'classname' => 'widget-link',
			'description' => __( 'Display a link to the Headlines Newsletter page.', 'coenv' )
		);
 
		parent::__construct(
			'newsletter_link', // base ID
			'Headlines Newsletter Link', // name
			$args
		);
	}
 
	public function form( $instance ) {
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( '<em>Headlines</em> Newsletter Archive', 'coenv' );
		}
        $newsletter_url = $instance['newsletter_url'];
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
            <p>
				<label for="<?php echo $this->get_field_name( 'newsletter_url' ) ?>"><?php _e( 'Newsletter Link (URL):' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'newsletter_url' ) ?>" name="<?php echo $this->get_field_name( 'newsletter_url' ) ?>" value="<?php echo esc_attr( $newsletter_url ) ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['newsletter_url'] = strip_tags( $new_instance['newsletter_url'] );
		 
		return $instance;
	}
 
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
        $newsletter_url = apply_filters( 'newsletter_url', $instance['newsletter_url'] );
        
        if ( !isset( $newsletter_url ) || empty( $newsletter_url ) ) {
			return;
		}
 
		echo $before_widget;
		?>
			
			<ul class='link'>
				<li><a href="<?php echo $newsletter_url; ?>" title="Headlines Newsletter Archive"><i class="icon-mail"> </i><?php echo $title ?></a></li>
			</ul>
 
		<?php
		echo $after_widget;
	}
 
}
 
/**
 * Related Posts Widget
 */
register_widget( 'CoEnv_Widget_Related_Posts' );

class CoEnv_Widget_Related_Posts extends WP_Widget {
 
  public function __construct()
	{
		$args = array(
			'classname' => 'related-posts-widget',
			'description' => __( 'Display a short list of posts by category.', 'coenv' )
		);
 
		parent::__construct(
			'related_posts', // base ID
			'Related Posts', // name
			$args
		);
	}
 
	public function form( $instance )
	{
		$cats = get_categories(array(
				'type' => 'post',
				'taxonomy' => array('topic')
			));
 
		if ( !isset( $cats ) || empty( $cats ) ) {
			?>
				<p>Please add some blog categories.</p>
			<?php
			return;
		}
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Latest Posts', 'coenv' );
		}
 
		if ( isset( $instance['posts_per_page'] ) ) {
			$posts_per_page = (int) $instance['posts_per_page'];
		} else {
			$posts_per_page = 2;
		}
 
		$category_id = $instance['category_id'];
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'posts_per_page' ) ?>">Number of posts to show: </label>
				<input name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" type="text" size="3" value="<?php echo $posts_per_page ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'category_id' ) ?>"><?php _e( 'Category:' ) ?></label>
				<select name="<?php echo $this->get_field_name( 'category_id' ) ?>">
					<option>Choose a category...</option>
					<?php foreach ( $cats as $cat ) : ?>
						<option value="<?php echo $cat->term_id ?>"<?php if ( $cat->term_id == $category_id ) echo ' selected' ?>><?php echo $cat->name ?></option>
					<?php endforeach ?>
                    
                    <option value="intranet-section"<?php if ( $category_id == 'intranet-section' ) echo ' selected' ?>>Intranet Section News</option>
				</select>
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
		$instance['category_id'] = $new_instance['category_id'];
 
		return $instance;
	}
 
	public function widget( $args, $instance )
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$posts_per_page = (int) $instance['posts_per_page'];
 
		$category_id = $instance['category_id'];
        $section = $category_id;
        
        if ($category_id == 'intranet-section') {
            $intranet_page = get_the_id();
            $pages = array_reverse(get_post_ancestors($intranet_page));
            if (count($pages) === 0) {
                return;
            } elseif (count($pages) === 1) {
                $ancestor_page_id = $intranet_page;
            } else {
                $ancestor_page_id = $pages[1];
            }
            $page_name = sanitize_title_with_dashes(get_the_title($ancestor_page_id));
            $category_id = get_term_by('slug', $page_name , 'topic');
            $category_id = $category_id->term_id;
            $related_post_type = array('post', 'intranet');
        } else {
            $related_post_type = 'post';
        }
        
        
 
        $related_posts = new WP_Query( array(
			'posts_per_page' => $posts_per_page,
			'post_type' => $related_post_type,
			'tax_query' => array(
                array(
                    'taxonomy' => 'topic',
                    'terms' => $category_id
                )
            ),
		) );

		  if ( $related_posts->have_posts() ) :
		echo $before_widget;
		?>
            <?php $term = get_term($category_id, 'topic'); ?>
                <?php $coenv_chosen = wp_list_pluck( $related_posts->posts, 'ID' );

                echo '<div class="related"><div class="related-news"><div class="related-heading">';
                if ($section == 'intranet-section') {
                echo '<div class="right"><a href="/intranet/?term=' . $term->slug . '">See More »</a></div>';
                echo '<a href="/intranet/?term=' . $term->slug . '"><h2 class="title">' . $title . ' in ' . $term->name . '</h2></a></div>';
                } else {
                echo '<div class="right"><a href="/news/topic/' . $term->slug . '">See More »</a></div>';
                echo '<a href="/news/topic/' . $term->slug . '"><h2 class="title">' . $title . ' in ' . $term->name . '</h2></a></div>';
                }
                echo '<div class="related-posts">';
                foreach( $coenv_chosen as $post):
                    setup_postdata($post);
                    echo '<div class="related-container">';
                        if ( has_post_thumbnail() ) {
                            echo '<div class="related-thumb">';
                            echo '<a href="' . get_permalink($post) . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
                            echo get_the_post_thumbnail($post, 'medium');
                            echo '</a>';
                            echo '</div>';
                        }
                    echo '<div class="related-article-title">';
                            echo '<h3>';
                            echo '<a href="' . get_permalink($post) . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">';
                            echo get_the_title($post);
                            echo '</a>';
                            echo '</h3>';
                    echo '</div>';
                echo '</div>';
                endforeach;
                    echo '<br style="clear:both" />';
                echo '</div>';
                echo '</div></div>';

                wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly
        ?>
            <!-- <//?php $term = get_term($category_id, 'topic'); ?>
			<//?php echo $before_title ?>
				<//?php echo $title . ' in ' . $term->name ?>
			<//?php echo $after_title ?>
					<//?php while ( $related_posts->have_posts() ) : $related_posts->the_post() ?>
						<li><a href="<//?php the_permalink() ?>"><//?php the_title() ?></a></li>
					<//?php endwhile ?>
                </ul> -->
		<?php
		echo $after_widget;
        endif;
 
		wp_reset_postdata();
	}
 
}

/**
 * Student Ambassadors Widget
 */
register_widget( 'CoEnv_Widget_Student_Ambassadors' );

class CoEnv_Widget_Student_Ambassadors extends WP_Widget {
 
  public function __construct()
	{
		$args = array(
			'classname' => 'student-ambassadors-widget',
			'description' => __( 'Display a short list of random student ambassadors.', 'coenv' )
		);
 
		parent::__construct(
			'related_posts', // base ID
			'Related Posts', // name
			$args
		);
	}
 
	public function form( $instance )
	{
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Student Ambassador Profiles', 'coenv' );
		}
 
		if ( isset( $instance['posts_per_page'] ) ) {
			$posts_per_page = (int) $instance['posts_per_page'];
		} else {
			$posts_per_page = 2;
		}
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'posts_per_page' ) ?>">Number of posts to show: </label>
				<input name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" type="text" size="3" value="<?php echo $posts_per_page ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
 
		return $instance;
	}
 
	public function widget( $args, $instance )
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$posts_per_page = (int) $instance['posts_per_page'];        
        
 
        $sa_args = array(
            'post_type' => 'student_ambassadors',
            'posts_per_page' => '6',
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'student_type',
                    'field'    => 'slug',
                    'terms'    => 'undergraduate-student',
                ),
            ),
		);
        

        $sa_query = new WP_Query( $sa_args );
        
        echo $before_widget; ?>
        <?php echo $before_title ?>

            <span><a href="/students/meet-our-students/undergraduate-ambassadors/">
                <?php 
                if ( $title == '' ){
                    echo 'Student Ambassadors';
                } else {
                    echo $title;
                } ?>
            </a></span>


        <?php echo $after_title;

        if ( $sa_query->have_posts()) {
                echo '<div class="ambassadors">';
                while ( $sa_query->have_posts() ) {
                    $sa_query->the_post();
                    $first_name = get_field('first_name');
                    $last_name = get_field('last_name');
                    $image = get_field('photo');
                    if( !empty($image) ) {
                        // vars
                        $alt = $image['alt'];

                        // thumbnail
                        $size = 'thumbnail';
                        $thumb = $image['sizes'][ $size ];
                    }
                    $name = $first_name . ' ' . $last_name;
                    echo '<a href="/students/meet-our-students/undergraduate-ambassadors/#bio-t-' . sanitize_title_with_dashes($name) . '" title="' . the_title_attribute( 'echo=0' ) . '" " rel="bookmark">';
                        echo '<div class="ambassador-container" >';
                        if ( $image ) {
                            echo '<div class="ambassador-thumb">';
                            echo '<img alt="' . $alt . '" src=' . $thumb . '>';
                            echo '</div>';
                        }	else {
                            echo '<div class="ambassador-thumb">';
                            echo '</div>';
                        }
                        echo '<div class="ambassador-name">';
                            echo '<h3>';
                                echo $first_name;
                            echo '</h3>';
                        echo '</div>';
                    echo '</div>';
                echo '</a>';
            }
            echo '<a href="/students/meet-our-students/undergraduate-ambassadors/" title="Browse more faculty in the College of the Environment" class="count" >';
            echo '<div class="ambassador-container">';
            echo '<div class="ambassador-thumb">';
            echo '<i class="icon-faculty-grid-alt-2"></i>';
            echo '</div>';
            if (empty($term)) {
                echo '<span class="number">All Ambassadors';
            } else {
                echo '<span class="number">+' . ($term->count - 6) . ' more';
            }
            echo '</span></div>';
            echo '</a>';
            echo '</div>';
        }
		echo $after_widget;
 
		wp_reset_postdata();
	}
 
}

/**
 * Graduate Student Profiles Widget
 */
register_widget( 'CoEnv_Widget_Graduate_Student_Profiles' );

class CoEnv_Widget_Graduate_Student_Profiles extends WP_Widget {
 
  public function __construct()
	{
		$args = array(
			'classname' => 'graduate-student-profiles-widget',
			'description' => __( 'Display a short list of random graduate student profiles.', 'coenv' )
		);
 
		parent::__construct(
			'related_posts', // base ID
			'Related Posts', // name
			$args
		);
	}
 
	public function form( $instance )
	{
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Graduate Student Profiles', 'coenv' );
		}
 
		if ( isset( $instance['posts_per_page'] ) ) {
			$posts_per_page = (int) $instance['posts_per_page'];
		} else {
			$posts_per_page = 2;
		}
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'posts_per_page' ) ?>">Number of posts to show: </label>
				<input name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" type="text" size="3" value="<?php echo $posts_per_page ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
 
		return $instance;
	}
 
	public function widget( $args, $instance )
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$posts_per_page = (int) $instance['posts_per_page'];        
        
 
        $sa_args = array(
           'post_type' => 'student_ambassadors',
            'posts_per_page' => '6',
            'orderby' => 'rand',
            'tax_query' => array(
                array(
                    'taxonomy' => 'student_type',
                    'field'    => 'slug',
                    'terms'    => 'graduate-student',
                ),
            ),
		);
        

        $sa_query = new WP_Query( $sa_args );
        
        echo $before_widget; ?>
        <?php echo $before_title ?>

            <span><a href="/students/meet-our-students/graduate-students/">
                <?php 
                if ( $title == '' ){
                    echo 'Featured Graduate Students';
                } else {
                    echo $title;
                } ?>
            </a></span>


        <?php echo $after_title;

        if ( $sa_query->have_posts()) {
                echo '<div class="ambassadors">';
                while ( $sa_query->have_posts() ) {
                    $sa_query->the_post();
                    $first_name = get_field('first_name');
                    $last_name = get_field('last_name');
                    $image = get_field('photo');
                    if( !empty($image) ) {
                        // vars
                        $alt = $image['alt'];

                        // thumbnail
                        $size = 'thumbnail';
                        $thumb = $image['sizes'][ $size ];
                    }
                    $name = $first_name . ' ' . $last_name;
                    echo '<a href="/students/meet-our-students/graduate-students/#bio-t-' . sanitize_title_with_dashes($name) . '" title="' . the_title_attribute( 'echo=0' ) . '" " rel="bookmark">';
                        echo '<div class="ambassador-container" >';
                        if ( $image ) {
                            echo '<div class="ambassador-thumb">';
                            echo '<img alt="' . $alt . '" src=' . $thumb . '>';
                            echo '</div>';
                        }	else {
                            echo '<div class="ambassador-thumb">';
                            echo '</div>';
                        }
                        echo '<div class="ambassador-name">';
                            echo '<h3>';
                                echo $first_name;
                            echo '</h3>';
                        echo '</div>';
                    echo '</div>';
                echo '</a>';
            }
            echo '<a href="/students/meet-our-students/graduate-students/" title="Browse more faculty in the College of the Environment" class="count" >';
            echo '<div class="ambassador-container">';
            echo '<div class="ambassador-thumb">';
            echo '<i class="icon-faculty-grid-alt-2"></i>';
            echo '</div>';
            if (empty($term)) {
                echo '<span class="number">All Featured Grad Students';
            } else {
                echo '<span class="number">+' . ($term->count - 6) . ' more';
            }
            echo '</span></div>';
            echo '</a>';
            echo '</div>';
        }
		echo $after_widget;
 
		wp_reset_postdata();
	}
 
}

/**
 * Postdoc Profiles Widget
 */
register_widget( 'CoEnv_Widget_Postdoc_Profiles' );

class CoEnv_Widget_Postdoc_Profiles extends WP_Widget {
 
  public function __construct()
	{
		$args = array(
			'classname' => 'widget-postdoc-profiles',
			'description' => __( 'Display a short list of random postdoc profiles.', 'coenv' )
		);
 
		parent::__construct(
			'related_posts', // base ID
			'Related Posts', // name
			$args
		);
	}
 
	public function form( $instance )
	{
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Postdoc Profiles', 'coenv' );
		}
 
		if ( isset( $instance['posts_per_page'] ) ) {
			$posts_per_page = (int) $instance['posts_per_page'];
		} else {
			$posts_per_page = 2;
		}
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'posts_per_page' ) ?>">Number of posts to show: </label>
				<input name="<?php echo $this->get_field_name( 'posts_per_page' ) ?>" type="text" size="3" value="<?php echo $posts_per_page ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
 
		return $instance;
	}
 
	public function widget( $args, $instance )
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$posts_per_page = (int) $instance['posts_per_page'];        
        
 
        $sa_args = array(
           'post_type' => 'student_ambassadors',
            'posts_per_page' => '4',
            'orderby' => 'rand',
			'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'student_type',
                    'field'    => 'slug',
                    'terms'    => 'postdoctoral-fellow',
                ),
            ),
		);
        

        $sa_query = new WP_Query( $sa_args );
        
        echo $before_widget; ?>
        <?php echo $before_title ?>

            <span><a href="/research/postdoctoral-fellows/meet-postdocs/">
                <?php 
                if ( $title == '' ){
                    echo 'Meet our Postdocs';
                } else {
                    echo $title;
                } ?>
            </a></span>


        <?php echo $after_title;

        if ( $sa_query->have_posts()) {
                echo '<div class="ambassadors">';
                while ( $sa_query->have_posts() ) {
                    $sa_query->the_post();
                    $first_name = get_field('first_name');
                    $last_name = get_field('last_name');
                    $image = get_field('photo');
                    if( !empty($image) ) {
                        // vars
                        $alt = $image['alt'];

                        // thumbnail
                        $size = 'thumbnail';
                        $thumb = $image['sizes'][ $size ];
                    }
                    $name = $first_name . ' ' . $last_name;
                    echo '<a href="/research/postdoctoral-fellows/meet-postdocs/#bio-t-' . sanitize_title_with_dashes($name) . '" title="' . the_title_attribute( 'echo=0' ) . '" " rel="bookmark">';
                        echo '<div class="ambassador-container" >';
                        if ( $image ) {
                            echo '<div class="ambassador-thumb">';
                            echo '<img alt="' . $alt . '" src=' . $thumb . '>';
                            echo '</div>';
                        }	else {
                            echo '<div class="ambassador-thumb">';
                            echo '</div>';
                        }
                        echo '<div class="ambassador-name">';
                            echo '<h3>';
                                echo $first_name;
                            echo '</h3>';
                        echo '</div>';
                    echo '</div>';
                echo '</a>';
            }
            echo '<a href="/research/postdoctoral-fellows/meet-postdocs/" class="count" >';
            echo '<div class="ambassador-container">';
            echo '<div class="ambassador-thumb">';
            echo '<i class="icon-faculty-grid-alt-2"></i>';
            echo '</div>';
            if (empty($term)) {
                echo '<span class="number">All Featured Grad Students';
            } else {
                echo '<span class="number">+' . ($term->count - 6) . ' more';
            }
            echo '</span></div>';
            echo '</a>';
            echo '</div>';
        }
		echo $after_widget;
 
		wp_reset_postdata();
	}
 
}

/**
 * Meet a Postdoc
 */
register_widget( 'CoEnv_Widget_Meet_Postdoc' );

class CoEnv_Widget_Meet_Postdoc extends WP_Widget {
 
  public function __construct()
	{
		$args = array(
			'classname' => 'meet-postdoc-widget',
			'description' => __( 'Display a single postdoc and information about them.', 'coenv' )
		);
 
		parent::__construct(
			'meet_postdoc', // base ID
			'Meet A Postdoc', // name
			$args
		);
	}
 
	public function form( $instance )
	{
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Meet a Postdoc', 'coenv' );
		}
 
		if ( isset( $instance['text'] ) ) {
			$text = $instance['text'];
		} else {
			$text = '';
		}
    
    if ( isset( $instance['button_url'] ) ) {
			$button_url = $instance['button_url'];
		} else {
			$button_url = '';
		}
      
    if ( isset( $instance['button_text'] ) ) {
			$button_text = $instance['button_text'];
		} else {
			$button_text = 'See more';
		}
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'text' ) ?>">Text to show: </label>
				<textarea name="<?php echo $this->get_field_name( 'text' ) ?>" cols="31" rows="5"><?php echo $text ?></textarea>
			</p>
      <p>
				<label for="<?php echo $this->get_field_name( 'button_url' ) ?>">Button URL: </label>
				<input class="widefat" name="<?php echo $this->get_field_name( 'button_url' ) ?>" type="url" value="<?php echo $button_url ?>" />
			</p>
      <p>
				<label for="<?php echo $this->get_field_name( 'button_text' ) ?>">Button Text: </label>
				<input class="widefat" name="<?php echo $this->get_field_name( 'button_text' ) ?>" type="text" value="<?php echo $button_text ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] = strip_tags( $new_instance['text'] );
    $instance['button_url'] = strip_tags( $new_instance['button_url'] );
    $instance['button_text'] = strip_tags( $new_instance['button_text'] );
 
		return $instance;
	}
 
	public function widget( $args, $instance )
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );   
        
 
        $sa_args = array(
            'post_type' => 'student_ambassadors',
            'posts_per_page' => '1',
            'orderby' => 'rand',
			'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'student_type',
                    'field'    => 'slug',
                    'terms'    => 'postdoctoral-fellow',
                ),
            ),
		);
        

        $sa_query = new WP_Query( $sa_args );
        
        echo $before_widget; ?>
        <?php echo $before_title ?>

            <span><a href="/research/postdoctoral-fellows/meet-postdocs/">
                <?php 
                if ( $title == '' ){
                    echo 'Meet a Postdoc';
                } else {
                    echo $title;
                } ?>
            </a></span>


        <?php echo $after_title;

        if ( $sa_query->have_posts()) {
                echo '<div class="ambassadors">';
                while ( $sa_query->have_posts() ) {
                    $sa_query->the_post();
                    $first_name = get_field('first_name');
                    $last_name = get_field('last_name');
                    $image = get_field('photo');
                    $unit = get_field('academic_unit');
                    if( !empty($image) ) {
                        // vars
                        $alt = $image['alt'];

                        // thumbnail
                        $size = 'homepage-column-standard';
                        $thumb = $image['sizes'][ $size ];
                    }
                    $name = $first_name . ' ' . $last_name;
                    echo '<a href="/research/postdoctoral-fellows/meet-postdocs/#bio-t-' . sanitize_title_with_dashes($name) . '" title="' . the_title_attribute( 'echo=0' ) . '" " rel="bookmark">';
                        echo '<div class="ambassador-container" >';
                        if ( $image ) {
                            echo '<div class="ambassador-thumb">';
                            echo '<img alt="' . $alt . '" src=' . $thumb . '>';
                            echo '</div>';
                        }	else {
                            echo '<div class="ambassador-thumb">';
                            echo '</div>';
                        }
                        echo '<div class="ambassador-name">';
                            echo '<h3>';
                                echo $first_name . ' ' . $last_name;
                            echo '</h3>';
                            echo '<h4>';
                                echo $unit[0]->name;
                            echo '</h4>';
                        echo '</div>';
                    echo '</div>';
                echo '</a>';
            }
            echo '<a href="/research/postdoctoral-fellows/meet-postdocs/" title="Browse more postdocs in the College of the Environment" class="count" >';
            echo '<div class="ambassador-container">';
            echo '<div class="ambassador-thumb">';
            echo '<i class="icon-faculty-grid-alt-2"></i>';
            echo '</div>';
            if (empty($term)) {
                echo '<span class="number">' . $instance['button_text'];
            } else {
                echo '<span class="number">+' . ($term->count - 6) . ' more';
            }
            echo '</span></div>';
            echo '</a>';
            echo '</div>';
        }
		echo $after_widget;
 
		wp_reset_postdata();
	}
 
}



/**
 * Podcast Widget
 */
register_widget( 'CoEnv_Widget_Podcast' );

class CoEnv_Widget_Podcast extends WP_Widget {
 
  public function __construct()
	{
		$args = array(
			'classname' => 'widget-podcast',
			'description' => __( 'Display the latest podcast episode and information about it when off season.', 'coenv' )
		);
 
		parent::__construct(
			'podcast', // base ID
			'Podcast', // name
			$args
		);
	}
 
	public function form( $instance )
	{
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( 'Podcast', 'coenv' );
		}
 
		if ( isset( $instance['text'] ) ) {
			$text = $instance['text'];
		} else {
			$text = '';
		}
    
    if ( isset( $instance['button_url'] ) ) {
			$button_url = $instance['button_url'];
		} else {
			$button_url = '/podcast';
		}
      
    if ( isset( $instance['button_text'] ) ) {
			$button_text = $instance['button_text'];
		} else {
			$button_text = 'All Episodes';
		}
 
		?>
			<p>
				<label for="<?php echo $this->get_field_name( 'title' ) ?>"><?php _e( 'Title:' ) ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" value="<?php echo esc_attr( $title ) ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_name( 'text' ) ?>">Text to show: </label>
				<textarea name="<?php echo $this->get_field_name( 'text' ) ?>" cols="31" rows="5"><?php echo $text ?></textarea>
			</p>
      <p>
				<label for="<?php echo $this->get_field_name( 'button_url' ) ?>">Button URL: </label>
				<input class="widefat" name="<?php echo $this->get_field_name( 'button_url' ) ?>" type="url" value="<?php echo $button_url ?>" />
			</p>
      <p>
				<label for="<?php echo $this->get_field_name( 'button_text' ) ?>">Button Text: </label>
				<input class="widefat" name="<?php echo $this->get_field_name( 'button_text' ) ?>" type="text" value="<?php echo $button_text ?>" />
			</p>
		<?php
	}
 
	public function update( $new_instance, $old_instance )
	{
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['text'] = strip_tags( $new_instance['text'] );
    $instance['button_url'] = strip_tags( $new_instance['button_url'] );
    $instance['button_text'] = strip_tags( $new_instance['button_text'] );
 
		return $instance;
	}
 
	public function widget( $args, $instance )
	{
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );   
        
 
        $pod_args = array(
            'post_type' => 'post',
            'posts_per_page' => '1',
			'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'story_type',
                    'field'    => 'term_id',
					'terms' => array ( 7239,7240,7242,7243,7244 ),
                ),
            ),
		);

        $pod_query = new WP_Query( $pod_args );
        
        echo $before_widget; ?>
        <?php echo $before_title ?>

            <span><a href="<?php echo $instance['button_url'] ?>">
                <?php 
                if ( $title == '' ){
                    echo 'Podcast';
                } else {
                    echo $title;
                } ?>
            </a></span>
			<a class="more" href="<?php echo $instance['button_url']; ?>" title="View All episodes"><?php echo $instance['button_text']; ?> &raquo;</a>


        <?php echo $after_title;
        if ( $pod_query->have_posts()) {
                echo '<div class="podcast-wrap">';
                while ( $pod_query->have_posts() ) {
                    $pod_query->the_post();
            }
			$pod_date = get_the_date();
			if( strtotime( $pod_date ) < strtotime('-1 months') ) {
				echo '<div class="podcast-promo-container off-season">';
				echo '<a class="podcast-title" href="/podcast"><h3><span class="microphone">
				<?xml version="1.0" encoding="UTF-8"?><svg id="microphone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 107.46 157.33"><defs><style>.cls-1{fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:11px;}</style></defs><g id="Layer_1-2"><rect class="cls-1" x="29.21" y="5.5" width="49.04" height="95.16" rx="24.52" ry="24.52"/><path class="cls-1" d="M101.96,73.71c0,27.5-21.59,49.79-48.23,49.79S5.5,101.21,5.5,73.71"/><line class="cls-1" x1="53.73" y1="123.5" x2="53.73" y2="151.83"/><line class="cls-1" x1="33.73" y1="151.83" x2="73.73" y2="151.83"/></g></svg>
				</span>FieldSound</h3>';
				echo '<p class="small-title">Listen now »</p></a>';
				echo '</div>';

			} else {
				echo '<div class="podcast-promo-container">';
				echo '<a href="' . get_permalink() . '">';
				the_post_thumbnail('large');
				echo '</a>';
				echo '<a class="podcast-title" href="/podcast"><h3><span class="microphone">
				<?xml version="1.0" encoding="UTF-8"?><svg id="microphone" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 107.46 157.33"><defs><style>.cls-1{fill:none;stroke:#fff;stroke-linecap:round;stroke-linejoin:round;stroke-width:11px;}</style></defs><g id="Layer_1-2"><rect class="cls-1" x="29.21" y="5.5" width="49.04" height="95.16" rx="24.52" ry="24.52"/><path class="cls-1" d="M101.96,73.71c0,27.5-21.59,49.79-48.23,49.79S5.5,101.21,5.5,73.71"/><line class="cls-1" x1="53.73" y1="123.5" x2="53.73" y2="151.83"/><line class="cls-1" x1="33.73" y1="151.83" x2="73.73" y2="151.83"/></g></svg>
				</span>FieldSound</h3></a>';
				echo '<a class="latest-episode" href="' . get_permalink() . '">';
				echo '<p class="small-title">Latest episode:</p>';
				echo '<h4 class="article__title"> ' . get_the_title() . '</h4></a>';
				echo '</div>';
			}
        }	
		echo $after_widget;
		return;

	}
}

?>
