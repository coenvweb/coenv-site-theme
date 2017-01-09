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
                <a href="<?php bloginfo('url') ?>/faculty/" class="Faculty-toolbox-title-link">Faculty <span>Profiles</span></a>
				<a href="#" class="Faculty-toolbox-toggle">

					<div class="Faculty-toolbox-toggle-search">
						<i class="icon-search"></i> <span>Search</span>
					</div>

					<div class="Faculty-toolbox-toggle-roller">
						<i class="icon-arrow-left-2"></i> <span>Themes</span>
					</div>
				</a>
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

					<div class="Faculty-toolbox-roller-items mCustomScrollbar Faculty-toolbox-roller-items-inner Faculty-toolbox-roller-items-set" >

								<div class="Faculty-toolbox-roller-item"><a href="<?php bloginfo('url') ?>/faculty/" data-theme="*">All Research Themes</a></div>

								<?php if ( !empty( $ordered_themes ) ) : ?>

									<?php foreach ( $ordered_themes as $theme ) : ?>

										<div class="Faculty-toolbox-roller-item"><a href="<?php echo $theme['url'] ?>" data-theme="theme-<?php echo $theme['slug'] ?>"><?php echo $theme['name'] ?></a></div>

									<?php endforeach ?>

								<?php endif ?>

					</div><!-- .Faculty-toolbox-roller-items -->

				</div><!-- .Faculty-toolbox-roller-content -->

			</div><!-- .Faculty-toolbox-roller -->

			<div class="Faculty-toolbox-form">

				<form action="">

					<div class="Faculty-toolbox-form-group">

						<select id="theme" name="theme" class="Faculty-toolbox-theme-select">

							<option value="theme-all" data-url="<?php bloginfo('url') ?>/faculty/#theme-all">All Research Themes</option>

							<?php foreach ( $themes as $theme ) : ?>
                                <?php if (!$theme['count'] == 0) : ?>

								<option value="theme-<?php echo $theme['slug'] ?>" data-url="<?php echo $theme['url'] ?>"><?php echo $theme['name'] ?></option>
                            
                                <?php endif; ?>
							<?php endforeach ?>

						</select>

						<label for="theme">Research themes</label>

					</div>

					<div class="Faculty-toolbox-form-group">

						<select id="unit" name="unit" class="Faculty-toolbox-unit-select">

							<option value="unit-all" data-url="<?php bloginfo('url') ?>/faculty/#unit-all">All Schools/Departments</option>

							<?php foreach ( $units as $unit ) : ?>

								<option value="unit-<?php echo $unit['slug'] ?>" data-url="<?php echo $unit['url'] ?>"><?php echo $unit['name'] ?></option>

							<?php endforeach ?>

						</select>

						<label for="unit">School/department</label>

					</div>

					<div class="Faculty-toolbox-form-group">

						<div class="field-wrap">
    						<input class="Faculty-toolbox-search" type="text" value="<?php echo get_search_query() ?>" name="search" id="search" aria-role="Faculty Search" />
    						<button type="submit"><i class="icon-search"></i><span>Search</span></button>
  						</div>

						<label for="search">Search all faculty</label>

					</div>

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
