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
		View faculty working on 
		<select class="Faculty-selector-theme" name="theme">
			<option value="theme-all" data-url="<?php bloginfo('url') ?>/faculty/#unit-all">All research themes</option>
		  	<?php foreach ( $themes as $theme ) : ?>
		  		<option value="theme-<?php echo $theme['slug'] ?>"<?php if ( $query_args['theme'] == $theme['slug'] ) echo ' selected' ?> data-url="<?php echo $theme['url'] ?>"><?php echo $theme['name'] ?></option>
		  	<?php endforeach ?>
		</select>
		in
		<select class="Faculty-selector-unit" name="unit" >
			<option value="unit-all" data-url="<?php bloginfo('url') ?>/faculty/#unit-all">All Units</option>
			<?php foreach ( $units as $unit ) : ?>
			  <option value="unit-<?php echo $unit['slug'] ?>"<?php if ( $query_args['unit'] == $unit['slug'] ) echo ' selected' ?> data-url="<?php echo $unit['url'] ?>"><?php echo $unit['name'] ?></option>
			<?php endforeach ?>
		</select>

		<input type="submit" value="Submit">
	</form>

</header>