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
			<h2 class="Faculty-toolbox-title">
                Filter
			</h2>
		</div>

		<div class="Faculty-toolbox-content">

			<div class="Faculty-toolbox-form">

				<form action="">

					<div class="Faculty-toolbox-form-group">

						<label for="theme">Research themes</label>

						<div class="Faculty-toolbox-select-wrap" data-filter="theme">

							<select id="theme" name="theme" class="Faculty-toolbox-theme-select">

								<option value="theme-all" data-url="<?php bloginfo('url') ?>/faculty/">All Research Themes</option>

								<?php foreach ( $themes as $theme ) : ?>
                                <?php if (!$theme['count'] == 0) : ?>

									<option value="theme-<?php echo $theme['slug'] ?>" data-url="<?php bloginfo('url') ?>/faculty/?theme=<?php echo $theme['slug'] ?>"><?php echo $theme['name'] ?></option>
                            
                                <?php endif; ?>
								<?php endforeach; ?>

							</select>

							<button type="button" class="Faculty-toolbox-select-clear" data-filter="theme" aria-label="Clear research theme filter">
								<i class="icon-cross" aria-hidden="true"></i>
							</button>

						</div>

					</div>

					<div class="Faculty-toolbox-form-group">

						<label for="unit">School/department</label>

						<div class="Faculty-toolbox-select-wrap" data-filter="unit">

							<select id="unit" name="unit" class="Faculty-toolbox-unit-select">

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
									<option value="unit-<?php echo $unit['slug'] ?>" data-url="<?php bloginfo('url') ?>/faculty/?unit=<?php echo $unit['slug'] ?>"><?php echo $unit['name'] ?></option>
                  <?php endif; ?>
								<?php endforeach ?>

							</select>

							<button type="button" class="Faculty-toolbox-select-clear" data-filter="unit" aria-label="Clear school or department filter">
								<i class="icon-cross" aria-hidden="true"></i>
							</button>

						</div>

					</div>

					<div class="Faculty-toolbox-form-group">

						<label for="search">Search all faculty</label>

						<div class="field-wrap Faculty-toolbox-search-wrap">
    						<input class="Faculty-toolbox-search" type="text" value="<?php echo get_search_query() ?>" name="search" id="search" role="search" />
							<button type="submit" class="Faculty-toolbox-search-button" aria-label="Search faculty">
								<i class="icon-search Faculty-toolbox-search-button-icon Faculty-toolbox-search-button-icon--search" aria-hidden="true"></i>
								<i class="icon-cross Faculty-toolbox-search-button-icon Faculty-toolbox-search-button-icon--clear" aria-hidden="true"></i>
								<span class="Faculty-toolbox-search-button-spinner" aria-hidden="true"></span>
								<span class="Faculty-toolbox-search-button-label">Search</span>
							</button>
  						</div>

					</div>

				</form>

			</div><!-- .Faculty-toolbox-form -->

		</div><!-- .Faculty-toolbox-content -->

		<div class="Faculty-toolbox-footer">

			<div class="Faculty-toolbox-feedback">

				<span class="Faculty-toolbox-feedback-number"><?php echo $faculty->post_count ?></span>

				<p class="Faculty-toolbox-feedback-message">College of the Environment Faculty Profiles</p>

			</div>

		</div><!-- .Faculty-toolbox-footer -->

	</div>

</header>
