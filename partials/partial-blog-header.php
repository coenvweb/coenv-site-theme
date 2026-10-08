<div id="blog-header" class="blog-header">
	<?php
		$queried_object = get_queried_object();
		$current_topic_id = ( is_tax('topic') && isset( $queried_object->term_id ) ) ? $queried_object->term_id : 0;
		$current_search = get_query_var('s');
		$news_base_url = home_url('/about/news/');
	?>

	<form role="search" method="get" class="search-form Form--inline" action="<?php echo $news_base_url; ?>">
	  <div class="field-wrap Faculty-toolbox-search-wrap">
        <label for="s">Search news</label>
	    <input type="text" value="<?php echo $current_search; ?>" name="s" id="s" placeholder="Search news" aria-label="Search" title="Search" />
	    <button type="submit" class="Faculty-toolbox-search-button" aria-label="Search news">
	    	<i class="icon-search Faculty-toolbox-search-button-icon Faculty-toolbox-search-button-icon--search" aria-hidden="true"></i>
	    	<i class="icon-cross Faculty-toolbox-search-button-icon Faculty-toolbox-search-button-icon--clear" aria-hidden="true"></i>
	    	<span class="Faculty-toolbox-search-button-label">Search</span>
	    </button>
	  </div>
	</form>
	<div class="input-item select-category" data-news-url="<?php echo $news_base_url; ?>">
		<?php
			$cats = get_categories(array(
				'type' => 'post',
				'taxonomy' => array('topic')
			));
                
				$output = '<label for="category">Filter by Category</label>';
				$output .= '<div class="Faculty-toolbox-select-wrap">';
				$output .= '<select name="category-dropdown" id="category">';
				$output .= '<option value="">Choose a topic</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
                    if (!term_is_ancestor_of(1232, $cat->term_id, 'topic') and ($cat->term_id != 1232)) {
					$selected = $current_topic_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="' . home_url('/about/news/topic/' . $cat->slug . '/') . '" ' . $selected . '>' . $cat->name . '</option>';	
                    }
				}
				}	
				$output .= '</select>';
				$output .= '<button type="button" class="Faculty-toolbox-select-clear" aria-label="Clear category filter"><i class="icon-cross" aria-hidden="true"></i></button>';
				$output .= '</div>';
				echo $output;
		?>
	</div>
	<div class="input-item select-month">
        <label for="archive">Filter by Month</label>
			<div class="Faculty-toolbox-select-wrap">
				<select name="archive-dropdown" id="archive">
					<option value="/about/news/">Choose a month</option>
					<?php wp_get_archives(array(
						'type' => 'monthly',
						'format' => 'option'
					)) ?>
				</select>
				<button type="button" class="Faculty-toolbox-select-clear" aria-label="Clear month filter"><i class="icon-cross" aria-hidden="true"></i></button>
			</div>
	</div>
	<?php $coenv_post_count = $wp_query->found_posts;  ?>
	<?php if (is_tax() || is_date()) { ?>
		<div class="results-text">
			<?php if ($queried_object->taxonomy == 'topic') { ?>
				<p><?php echo $coenv_post_count; ?> news posts related to <span class="term-name"> <?php echo single_cat_title( '', true ); ?> </span></p>
				<p class="all-news"><a href="/about/news/" class="button">Return to News</a></p>
			<?php } elseif ($queried_object->taxonomy == 'story_type') { ?>
				<p><?php echo $coenv_post_count; ?> posts of type: <span class="term-name"> <?php echo single_cat_title( '', true ); ?> </span></p>
				<p class="all-news"><a href="/about/news/" class="button">Return to News</a></p>
			<?php } elseif (is_date()) { ?>
				<p><?php echo $coenv_post_count; ?> news posts from <span class="term-name"><?php echo single_month_title(' '); ?></span></p>
				<p class="all-news"><a href="/about/news/" class="button">Return to News</a></p>
			<?php } ?>
		</div>
	<?php } ?>
    <?php if (!empty(get_query_var('s'))) { ?>
		<div class="results-text">
            <p><?php if (!empty($coenv_post_count)) {echo $coenv_post_count;} else {echo '0';}; ?> news posts related to <span class="term-name"> <?php echo get_query_var('s'); ?> </span></p>
				<p class="all-news"><a href="/about/news/" class="button">Return to News</a></p>
        </div>
    <?php } ?>
</div><!-- #blog-header -->
