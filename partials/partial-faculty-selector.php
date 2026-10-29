<?php
/**
 * The Faculty Archive selector
 *
 * Shows for mobile views and no-js
 */
global $themes, $units, $faculty, $query_args;

?>

<header class="Faculty-list-header">

	<div class="Faculty-selector-inner">

		<div class="Faculty-selector-header">
			<h2 class="Faculty-selector-title">Filter</h2>
		</div>

		<div class="Faculty-selector-content">
			<form action="" class="Faculty-selector Faculty-toolbox-form">

				<div class="Faculty-toolbox-form-group">
					<label for="theme-mobile">Research themes</label>
					<div class="Faculty-toolbox-select-wrap">
						<select class="Faculty-selector-theme Faculty-toolbox-theme-select" name="theme" id="theme-mobile">
							<option value="theme-all" data-url="<?php bloginfo('url') ?>/faculty/">All research themes</option>
							<?php foreach ( $themes as $theme ) : ?>
								<option value="theme-<?php echo $theme['slug'] ?>"<?php if ( isset( $query_args['theme'] ) && $query_args['theme'] == $theme['slug'] ) echo ' selected' ?> data-url="<?php bloginfo('url') ?>/faculty/?theme=<?php echo $theme['slug'] ?>"><?php echo $theme['name'] ?></option>
							<?php endforeach ?>
						</select>


							<button type="button" class="Faculty-toolbox-select-clear" data-filter="theme" aria-label="Clear research theme filter">
								<i class="icon-cross" aria-hidden="true"></i>
							</button>
					</div>
				</div>

				<div class="Faculty-toolbox-form-group">
					<label for="unit-mobile">School/department</label>
					<div class="Faculty-toolbox-select-wrap">
						<select class="Faculty-selector-unit Faculty-toolbox-unit-select" name="unit" id="unit-mobile">
							<option value="unit-all" data-url="<?php bloginfo('url') ?>/faculty/">All Schools/Departments</option>
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
									<option value="unit-<?php echo $unit['slug'] ?>"<?php if ( isset( $query_args['unit'] ) && $query_args['unit'] == $unit['slug'] ) echo ' selected' ?> data-url="<?php bloginfo('url') ?>/faculty/?unit=<?php echo $unit['slug'] ?>"><?php echo $unit['name'] ?></option>
								<?php endif; ?>
							<?php endforeach ?>
						</select>


							<button type="button" class="Faculty-toolbox-select-clear" data-filter="unit" aria-label="Clear school or department filter">
								<i class="icon-cross" aria-hidden="true"></i>
							</button>
					</div>
				</div>

				<div class="Faculty-selector-submit-wrap">
					<button type="submit" class="Faculty-selector-submit">Apply filters</button>
				</div>

			</form>
		</div>

	</div>

</header>
