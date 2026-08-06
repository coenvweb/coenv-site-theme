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
                <a href="<?php bloginfo('url') ?>/faculty/" class="Faculty-toolbox-title-link">Filter</a>
			</h2>
		</div>

		<div class="Faculty-toolbox-content">

			<div class="Faculty-toolbox-form">

				<form action="">

					<div class="Faculty-toolbox-form-group">

						<select id="theme" name="theme" class="Faculty-toolbox-theme-select">

							<option value="theme-all" data-url="<?php bloginfo('url') ?>/faculty/#theme-all">All Research Themes</option>

							<?php foreach ( $themes as $theme ) : ?>
                                <?php if (!$theme['count'] == 0) : ?>

								<option value="theme-<?php echo $theme['slug'] ?>" data-url="<?php echo $theme['url'] ?>"><?php echo $theme['name'] ?></option>
                            
                                <?php endif; ?>
							<?php endforeach; ?>

						</select>

						<label for="theme">Research themes</label>

					</div>

					<div class="Faculty-toolbox-form-group">

						<select id="unit" name="unit" class="Faculty-toolbox-unit-select">

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
                    <option value="unit-<?php echo $unit['slug'] ?>" data-url="<?php echo $unit['url'] ?>"><?php echo $unit['name'] ?></option>
                  <?php endif; ?>
							<?php endforeach ?>

						</select>

						<label for="unit">School/department</label>

					</div>

					<div class="Faculty-toolbox-form-group">

						<div class="field-wrap">
    						<input class="Faculty-toolbox-search" type="text" value="<?php echo get_search_query() ?>" name="search" id="search" role="search" />
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
