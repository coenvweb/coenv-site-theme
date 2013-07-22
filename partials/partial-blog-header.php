<div id="blog-header">

	<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	  <div class="input-wrap">
	  	<input type="hidden" name="post_type" value="post" />
	    <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Search this site" />
	    <button type="submit"><i class="icon-search"></i><span>Search</span></button>
	  </div>
	</form>

	<div class="input-item select-category" data-url="<?php echo get_bloginfo('url') . '/news/category/' ?>">
		<?php
			$cats = get_categories(array(
				'type' => 'post',
				'taxonomy' => 'category'
			));

			if ( !empty( $cats ) ) {
				$output .= '<select name="category-dropdown">';
				foreach ( $cats as $cat ) { 
					$output .= '<option value="' . $cat->slug . '">' . $cat->name . '</option>';
				}
				$output .= '</select>';
			}
			echo $output;
		?>
	</div>

	<div class="input-item select-month">
		<select name="archive-dropdown">
			  <option value=""><?php echo esc_attr( __( 'Browse by month' ) ); ?></option> 
			  <?php 
			  	wp_get_archives( array( 
			  		'type' => 'monthly', 
			  		'format' => 'option', 
			  		'show_post_count' => 1,
			  	)); 
			  ?>
			</select>
	</div>
	
</div><!-- #blog-header -->