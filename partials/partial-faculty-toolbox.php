<?php
/**
 * The Faculty Archive toolbox
 */
global $themes, $units, $faculty;

$ordered_themes = $themes;
?>

<header class="Faculty-toolbox">

	<div class="Faculty-toolbox-inner Faculty-list-item-inner">

		<div class="Faculty-toolbox-header">
			<h1 class="Faculty-toolbox-title">
				<a href="<?php bloginfo('url') ?>/faculty/" class="Faculty-toolbox-title-link">Faculty</a>
				<a href="#" class="Faculty-toolbox-search-button"><i class="icon-search"></i> <span>Search</span></a>
			</h1>
		</div>

		<div class="Faculty-toolbox-content">
			
			<div class="Faculty-toolbox-roller">
				
				<div class="Faculty-toolbox-roller-header">
					<div class="Faculty-toolbox-roller-header-inner">
						<h2 class="Faculty-toolbox-roller-header-title">
							<span>Research themes:</span>
						</h2>
					</div>
				</div>

				<div class="Faculty-toolbox-roller-content">
					
					<div class="Faculty-toolbox-roller-items">
							
						<div class="Faculty-toolbox-roller-items-inner">

							<div class="Faculty-toolbox-roller-items-set">
								
								<div class="Faculty-toolbox-roller-item"><a href="<?php bloginfo('url') ?>/faculty/" data-theme="*">All Research Themes</a></div>
								
								<?php if ( !empty( $ordered_themes ) ) : ?>

									<?php foreach ( $ordered_themes as $theme ) : ?>		

										<div class="Faculty-toolbox-roller-item"><a href="<?php bloginfo('url') ?>/faculty/?theme=<?php echo $theme->slug ?>" data-theme="theme-<?php echo $theme->slug ?>"><?php echo $theme->name ?></a></div>

									<?php endforeach ?>

								<?php endif ?>

							</div><!-- .Faculty-toolbox-roller-items-set -->

						</div><!-- .Faculty-toolbox-roller-items-inner -->

					</div><!-- .Faculty-toolbox-roller-items -->

				</div><!-- .Faculty-toolbox-roller-content -->

			</div><!-- .Faculty-toolbox-roller -->

			<div class="Faculty-toolbox-form">
				
				<form action="">
					
					<select name="theme" class="Faculty-toolbox-theme-select">
						
						<option value="theme-all"></option>
	
						<?php foreach ( $themes as $theme ) : ?>

							<option value="theme-<?php echo $theme->slug ?>"><?php echo $theme->name ?></option>

						<?php endforeach ?>

					</select>

					<select name="unit" class="Faculty-toolbox-unit-select">
						
						<option value="unit-all"></option>
	
						<?php foreach ( $units as $unit ) : ?>

							<option value="unit-<?php echo $unit->slug ?>"><?php echo $unit->name ?></option>

						<?php endforeach ?>

					</select>

				</form>

			</div><!-- .Faculty-toolbox-form -->

		</div><!-- .Faculty-toolbox-content -->

		<div class="Faculty-toolbox-footer">
			
			<div class="Faculty-toolbox-feedback">

				<span class="Faculty-toolbox-feedback-number"><?php echo $faculty->post_count ?></span>

				<p class="Faculty-toolbox-feedback-message">College of the Environment Faculty Profiles</p>

			</div>

			<div class="Faculty-toolbox-toggle">

				<div class="Faculty-toolbox-toggle-inner">
					
					<a href="#"><i class="icon-search"></i> More search tools</a>

				</div>

			</div>

		</div><!-- .Faculty-toolbox-footer -->

	</div>

</header>