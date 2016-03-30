<div id="blog-header" class="blog-header">

	<form role="search" method="get" class="search-form Form--inline" action="<?php echo home_url( '/' ); ?>">
	  <div class="field-wrap">
	  	<input type="hidden" name="post_type" value="post" />
        <label for="s">Search news</label>
	    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Search news" aria-label="Search" title="Search" />
	    <button type="submit"><i class="icon-search"></i><span>Search</span></button>
	  </div>
	</form>
	<div class="input-item select-category" data-url="<?php echo get_bloginfo('url'); ?>">
		<?php
			$queried_object = get_queried_object();  
			$archive_term_id = $queried_object->term_id;
			$cats = get_categories(array(
				'type' => 'post',
				'taxonomy' => array('topic')
			));
                
                $output = '<label for="category">Filter by Category</label>';
				$output .= '<select name="category-dropdown" id="category">';
				$output .= '<option value="">Choose a topic</option>';
				if ( !empty( $cats ) ) {	
				foreach ( $cats as $cat ) {
                    if (!term_is_ancestor_of(1232, $cat->term_id, 'topic') and ($cat->term_id != 1232)) {
					$selected = $archive_term_id == $cat->term_id ? ' selected="selected"' : '';
					$output .= '<option value="/news/' . $cat->taxonomy . '/' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';	
                    }
				}
				}	
				$output .= '</select>';
				echo $output;
		?>
	</div>
	<div class="input-item select-month">
        <label for="archive">Filter by Month</label>
			<select name="archive-dropdown" id="archive">
				<option value="/news/">Choose a month</option>
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
