<div id="careers-filter" class="careers-filter">

	<form role="search" method="get" class="search-form Form--inline" action="<?php echo home_url( '/' ); ?>">
	  <div class="field-wrap">
	  	<input type="hidden" name="post_type" value="post" />
	    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Search careers and funding" />
	    <button type="submit"><i class="icon-search"></i><span>Search</span></button>
	  </div>
	</form>
	<div class="input-item select-degree-level" data-url="<?php echo get_bloginfo('url'); ?>">
		<?php
			$queried_object = get_queried_object();  
			$archive_term_id = $queried_object->term_id;
			$cats = get_categories(array(
				'type' => 'careers',
				'taxonomy' => array('degree_level')
			));

				$output .= '<select name="category-dropdown">';
				$output .= '<option value="">Choose the degree level</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
					$selected = $archive_term_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="/' . $cat->taxonomy . '/' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					
				}
				}	
				$output .= '</select>';
				echo $output;
		?>
	</div>
	<div class="input-item select-location" data-url="<?php echo get_bloginfo('url'); ?>">
		<?php
			$queried_object = get_queried_object();  
			$archive_term_id = $queried_object->term_id;
			$cats = get_categories(array(
				'type' => 'careers',
				'taxonomy' => array('location_careers')
			));
				$output = null;
				$output .= '<select name="category-dropdown">';
				$output .= '<option value="">Choose the location</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
					$selected = $archive_term_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="/' . $cat->taxonomy . '/' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					
				}
				}	
				$output .= '</select>';
				echo $output;
		?>
	</div>
	<div class="input-item select-time-commitments" data-url="<?php echo get_bloginfo('url'); ?>">
		<?php
			$queried_object = get_queried_object();  
			$archive_term_id = $queried_object->term_id;
			$cats = get_categories(array(
				'type' => 'careers',
				'taxonomy' => array('time_commitments')
			));
				$output = null;
				$output .= '<select name="category-dropdown">';
				$output .= '<option value="">Choose the time commitment</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
					$selected = $archive_term_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="/' . $cat->taxonomy . '/' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					
				}
				}	
				$output .= '</select>';
				echo $output;
		?>
	</div>
	<div class="input-item select-organization" data-url="<?php echo get_bloginfo('url'); ?>">
		<?php
			$queried_object = get_queried_object();  
			$archive_term_id = $queried_object->term_id;
			$cats = get_categories(array(
				'type' => 'careers',
				'taxonomy' => array('organization')
			));
				$output = null;
				$output .= '<select name="category-dropdown">';
				$output .= '<option value="">Choose the organziation type</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
					$selected = $archive_term_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="/' . $cat->taxonomy . '/' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					
				}
				}	
				$output .= '</select>';
				echo $output;
		?>
	</div>
	<div class="input-item select-work-type" data-url="<?php echo get_bloginfo('url'); ?>">
		<?php
			$queried_object = get_queried_object();  
			$archive_term_id = $queried_object->term_id;
			$cats = get_categories(array(
				'type' => 'careers',
				'taxonomy' => array('work_type')
			));
				$output = null;
				$output .= '<select name="category-dropdown">';
				$output .= '<option value="">Choose the work type</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
					$selected = $archive_term_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="/' . $cat->taxonomy . '/' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					
				}
				}	
				$output .= '</select>';
				echo $output;
		?>
	</div>
	<div class="input-item select-educational-funding" data-url="<?php echo get_bloginfo('url'); ?>">
		<?php
			$queried_object = get_queried_object();  
			$archive_term_id = $queried_object->term_id;
			$cats = get_categories(array(
				'type' => 'careers',
				'taxonomy' => array('educational_funding')
			));
				$output = null;
				$output .= '<select name="category-dropdown">';
				$output .= '<option value="">Choose the funding type</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
					$selected = $archive_term_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="/' . $cat->taxonomy . '/' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					
				}
				}	
				$output .= '</select>';
				echo $output;
		?>
	</div>
	<div class="input-item select-units" data-url="<?php echo get_bloginfo('url'); ?>">
		<?php
			$queried_object = get_queried_object();  
			$archive_term_id = $queried_object->term_id;
			$cats = get_categories(array(
				'type' => 'careers',
				'taxonomy' => array('units')
			));
				$output = null;
				$output .= '<select name="category-dropdown">';
				$output .= '<option value="">Choose the degree</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
					$selected = $archive_term_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="/' . $cat->taxonomy . '/' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					
				}
				}	
				$output .= '</select>';
				echo $output;
		?>
	</div>
	<div class="input-item select-month">
			<select name="archive-dropdown">
				<option value="/careers/">Choose a month</option>
				<?php wp_get_archives(array(
					'type' => 'monthly',
					'format' => 'option'
				)) ?>
			</select>
	</div>
	<?php if (is_tax() || is_date()) { ?>
		<div class="results-text">
			<?php $coenv_post_count = $GLOBALS['wp_query']->found_posts;  ?>
			<?php if ($queried_object->taxonomy == 'topic') { ?>
				<p><?php echo $coenv_post_count; ?> news posts related to <span class="term-name"> <?php echo single_cat_title( '', true ); ?> </span></p>
				<p class="all-news"><a href="/news/" class="button">Return to News</a></p>
			<?php } elseif ($queried_object->taxonomy == 'story_type') { ?>
				<p><?php echo $coenv_post_count; ?> posts of type: <span class="term-name"> <?php echo single_cat_title( '', true ); ?> </span></p>
				<p class="all-news"><a href="/news/" class="button">Return to News</a></p>
			<?php } elseif (is_date()) { ?>
				<p><?php echo $coenv_post_count; ?> news posts from <span class="term-name"><?php echo single_month_title(' '); ?></span></p>
				<p class="all-news"><a href="/news/" class="button">Return to News</a></p>
			<?php } ?>
		</div>
	<?php } ?>
</div><!-- #blog-header -->
