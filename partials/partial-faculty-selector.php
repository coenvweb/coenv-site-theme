<?php
/**
 * The Faculty Archive selector
 *
 * Shows for mobile views and no-js
 */
global $themes, $units, $faculty, $query_args;

?>

<header class="Faculty-list-header">

	<form action="" class="Faculty-selector">
		View faculty working in 
		<select class="Faculty-selector-theme" name="theme" id="theme-mobile">
			<option value="theme-all" data-url="<?php bloginfo('url') ?>/faculty/#unit-all">All research themes</option>
		  	<?php foreach ( $themes as $theme ) : ?>
                
		  		<option value="theme-<?php echo $theme['slug'] ?>"<?php if ( $query_args['theme'] == $theme['slug'] ) echo ' selected' ?> data-url="<?php echo $theme['url'] ?>"><?php echo $theme['name'] ?></option>
                
		  	<?php endforeach ?>
		</select>
        <label for="theme-mobile" style="display:none;">Research themes</label>
        <div style="margin-bottom: 10px;"></div>
		<select class="Faculty-selector-unit" name="unit" id="unit-mobile">
			<option value="unit-all" data-url="<?php bloginfo('url') ?>/faculty/#unit-all">All Schools/Departments</option>
			<?php foreach ( $units as $unit ) : ?>
				<?php
				$the_query = new WP_Query( array(
					'post_type' => 'faculty',
					'tax_query' => array(
						array(
							'taxonomy' => 'unit',
							'field' => 'slug',
							'terms' => $unit['slug']
						)
					)
				) );
			?>
				<?php if (!$the_query->found_posts == 0) : ?>
					<?php if ($unit['name'] == 'Marine Biology' || $unit['name'] == 'Cooperative Institute for Climate, Ocean, and Ecosystem Studies') {break; }; ?>
			  <option value="unit-<?php echo $unit['slug'] ?>"<?php if ( $query_args['unit'] == $unit['slug'] ) echo ' selected' ?> data-url="<?php echo $unit['url'] ?>"><?php echo $unit['name'] ?></option>
			<?php endif;?>
			<?php endforeach ?>
		</select>
        <label for="unit-mobile" style="display:none;">Research themes</label>

		<input type="submit" value="Submit">
	</form>

</header>
