<?php
/*
|---------------------------------------------------------------------------
| Register custom widgets
|---------------------------------------------------------------------------
*/

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
				<?php if (get_option('facebook')) { ?><li class="facebook"><a href="<?php echo get_option('facebook'); ?>" title="Become a fan of <?php bloginfo('name'); ?> on Facebook" target="_blank" rel="nofollow"><i class="icon-facebook"> </i>Facebook</a></li><?php } ?>
				<?php if (get_option('twitter')) { ?><li class="twitter"><a href="<?php echo get_option('twitter'); ?>" title="Follow <?php bloginfo('name'); ?> on Twitter" target="_blank" rel="nofollow"><i class="icon-twitter"> </i>Twitter</a></li><?php } ?>
				<?php if (get_option('google_plus')) { ?><li class="facebook"><a href="<?php echo get_option('google_plus'); ?>" title="View <?php bloginfo('name'); ?> Google+ profile" target="_blank" rel="nofollow"><i class="icon-googleplus"> </i> Google+</a></li><?php } ?>
                <?php if (get_option('instagram')) { ?><li class="instagram"><a href="<?php echo get_option('instagram'); ?>" title="Follow <?php bloginfo('name'); ?> on Instagram" target="_blank" rel="nofollow"><i class="icon-instagram"> </i>Instagram</a></li><?php } ?>
				<?php if (get_option('youtube')) { ?><li class="youtube"><a href="<?php echo get_option('youtube'); ?>" title="<?php bloginfo('name'); ?> You Tube Channel" target="_blank" rel="nofollow"><i class="icon-youtube"> </i>YouTube</a></li><?php } ?>
                <li class="email"><a href="/alumni-and-community/stay-connected" title="Subscribe to our email newsletter."><i class="icon-mail"> </i>Newsletter</a></li>
				<li class="feeds"><a href="/news/feed" title="UW College of the Environment RSS Feed"><i class="icon-rss"> </i> Feed</a></li>
				<?php if (get_option('uw_social')) { ?><li class="uw-social"><a href="<?php echo get_option('uw_social'); ?>" title="<?php bloginfo('name'); ?> on UW Social" target="_blank" rel="nofollow"><i class="icon-icon-uw"> </i>UW Social</a></li><?php } ?>
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
 * Undergrad Majors and Minors Widget
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

?>
