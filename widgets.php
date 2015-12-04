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
			
			<?php echo $before_title ?><span><?php echo $title; ?></span><?php echo $after_title ?>
 
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
		$events_xml = get_transient( 'trumba_events_xml' );
		if ( $events_xml === false || $events_xml === '' ) {
			$events_xml = file_get_contents( $feed_url );
			set_transient( 'trumba_events_xml', $events_xml, 1 * MINUTE_IN_SECONDS );
		}
		
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
                                   
						<a href="<?php echo $events_url; ?>" title="View All Events">More &raquo;</a>
					<?php endif ?>

				<?php echo $after_title ?>

			<?php if ( count( $events ) ) : ?>

				<?php foreach ( $events as $key => $event ) : ?>

					<article class="event">

						<a href="<?php echo $event['url'] ?>">
							<div>
                                
                                <?php
                                $date = substr($event['date'], 0, -6);
                                $date = strtotime($date);
                                $date = date('l, M j, Y ', $date);
                                ?>
								<footer class="meta">
									<p class="date"><i class="icon-calendar"></i> <?php echo $date ?></p>
								</footer>

								<header>
									<h1><?php echo $event['title'] ?></h1>
								</header>

							</div>
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
 * Insider Newsletter Widget
 */
register_widget( 'CoEnv_Widget_Newsletter' );

class CoEnv_Widget_Newsletter extends WP_Widget {
 
  public function __construct() {
		$args = array(
			'classname' => 'widget-link',
			'description' => __( 'Display a link to the Insider Newsletter archive page.', 'coenv' )
		);
 
		parent::__construct(
			'newsletter_link', // base ID
			'Insider Newsletter Link', // name
			$args
		);
	}
 
	public function form( $instance ) {
 
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = __( '<em>The Insider</em> Newsletter Archive', 'coenv' );
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
			
			<?php echo $before_title ?><span><?php echo $title; ?></span><?php echo $after_title ?>
 
			<ul class='link'>
				<li><a href="<?php echo $newsletter_url; ?>" title="The Insider Newsletter Archive"><i class="icon-mail"> </i><?php echo $title ?></a></li>
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
			$title = __( 'Related Posts', 'coenv' );
		}
 
		if ( isset( $instance['posts_per_page'] ) ) {
			$posts_per_page = (int) $instance['posts_per_page'];
		} else {
			$posts_per_page = 5;
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
			<?php echo $before_title ?>
				<?php echo $title . ' in ' . $term->name ?>
			<?php echo $after_title ?>
 
			
				<ul>
					<?php while ( $related_posts->have_posts() ) : $related_posts->the_post() ?>
						<li><a href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
					<?php endwhile ?>
                </ul>
		<?php
		echo $after_widget;
        endif;
 
		wp_reset_postdata();
	}
 
}

?>
