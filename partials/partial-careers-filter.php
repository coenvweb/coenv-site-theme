<div id="careers-filter" class="careers-filter">

	<form role="search" method="get" class="search-form Form--inline" action="<?php echo home_url( '/' ); ?>">
	  <div class="field-wrap">
	  	<input type="hidden" name="post_type" value="careers" />
	    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Search careers and funding" />
	    <button type="submit"><i class="icon-search"></i><span>Search</span></button>
	  </div>
	</form>
	<div class="input-item select-category" data-url="<?php echo get_bloginfo('url'); ?>">
        
        <?php 
        $customPostTaxonomies = get_object_taxonomies('careers');

        if(count($customPostTaxonomies) > 0) {
            foreach($customPostTaxonomies as $tax) {
                echo $tax;
                $args = array(
                    'show_option_all'    => 'All Categories',
                    'orderby' => 'name',
                    'show_count' => 0,
                    'pad_counts' => 0,
                    'child_of' => 1,
                    'hierarchical' => 1,
                    'taxonomy' => 'career_category',
                    'title_li' => ''
                );
                wp_list_categories( $args );
             }
        } ?>
        
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
