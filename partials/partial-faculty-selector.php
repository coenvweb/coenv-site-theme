<?php
/**
 * The Faculty Archive selector
 *
 * Shows for mobile views
 */
global $themes, $units, $faculty, $query_args;
?>

<header class="Faculty-list-header">

	<form action="" class="Faculty-selector">
		View faculty working on 
		<select class="Faculty-selector-theme" name="theme">
			<option value="">any research theme</option>
		  	<?php foreach ( $themes as $theme ) : ?>
		  		<option value="<?php echo $theme->slug ?>"<?php if ( $query_args['theme'] == $theme->slug ) echo ' selected' ?>><?php echo $theme->name ?></option>
		  	<?php endforeach ?>
		</select>
		in
		<select class="Faculty-selector-unit" name="unit" >
			<option value="">any unit</option>
			<?php foreach ( $units as $unit ) : ?>
			  <option value="<?php echo $unit->slug ?>"<?php if ( $query_args['unit'] == $unit->slug ) echo ' selected' ?>><?php echo $unit->name ?></option>
			<?php endforeach ?>
		</select>

		<input type="submit" value="Submit">
	</form>

</header>