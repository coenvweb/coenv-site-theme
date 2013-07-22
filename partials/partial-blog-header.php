<div id="blog-header">

	<form action="">

		<div class="input-item">

			<div class="input-wrap">
				<input type="text" name="s" placeholder="Search..." value="<?php echo get_search_query() ?>" />
				<button type="submit"><i class="icon-search"></i><span>Submit</span></button>
			</div>

			<?php echo get_search_query() ?>

		</div><!-- .input-item -->

		<div class="input-item select-category">

			<?php
				wp_dropdown_categories( array(
					'show_option_all' => 'Browse by category'
				) );
			?>

		</div><!-- .input-item -->

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

		</div><!-- .input-item -->
	</form>
	
</div><!-- #blog-header -->