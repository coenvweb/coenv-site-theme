<?php
/**
 * The Faculty Archive toolbox
 */
global $themes;
global $units;
global $selected_theme_key;
global $selected_theme;

// reorder $themes alphabetically
// starting with $selected_theme
$ordered_themes = array();

// add themes starting from selected
for ( $i = $selected_theme_key; $i < count( $themes ); $i++ ) {
	$ordered_themes[] = $themes[ $i ];
}

// add themes from beginning to selected
for ( $i = 0; $i < $selected_theme_key; $i++ ) {
	$ordered_themes[] = $themes[ $i ];
}

?>
<header class="faculty-toolbox jsIsotopeItem">

	<div class="faculty-toolbox-header">

		<h1><a href="<?php bloginfo('url') ?>/faculty/">Faculty</a></h1>

	</div><!-- .faculty-toolbox-header -->

	<div class="faculty-toolbox-tools">

		<div class="faculty-toolbox-inner">

			<div class="theme-roller">

				<div class="interaction-layer"></div>

				<div class="theme-roller-inner">

					<?php if ( !empty( $ordered_themes ) ) : ?>

						<?php foreach ( $ordered_themes as $theme ) : ?>

							<?php $origin = $theme->slug == $selected_theme->slug ? ' origin' : ''; ?>

							<div class="theme-roller-item<?php// echo $origin ?>" data-number="<?php echo $theme->count ?>" data-theme="theme-<?php echo $theme->slug ?>"><?php echo $theme->name ?></div>

						<?php endforeach ?>

					<?php endif ?>

				</div><!-- .theme-roller-inner -->

			</div><!-- .theme-roller -->

			<div class="faculty-toolbox-explore">

				<form action="">
          <select id="select-theme" name="theme" data-placeholder="Choose theme">
          	<option>All research themes</option>
              <?php foreach ( $themes as $theme ) : ?>
                  <option value="theme-<?php echo $theme->slug ?>"><?php echo $theme->name ?></option>
              <?php endforeach ?>
          </select>
          <label for="select-theme">Research themes</label>

          <select id="select-unit" name="unit" data-placeholder="Choose school/department">
              <option>All schools/departments</option>
              <?php foreach ( $units as $unit ) : ?>
                  <option value="<?php echo $unit->slug ?>"><?php echo $unit->name ?></option>
              <?php endforeach ?>
          </select>
          <label for="select-unit">School/department</label>

          <div class="input-wrap search-form">
              <input name="s" type="text" placeholder="<?php echo esc_attr(__('Search our faculty')); ?>" value="<?php the_search_query(); ?>">
              <input type="hidden" name="post_type" value="faculty" /> <!-- important! -->
              <button type="submit"><span>Search</span></button>
          </div><!-- .input-wrap -->
          <label>Search</label>
      </form>

			</div><!-- .faculty-toolbox-explore -->

		</div><!-- .faculty-toolbox-inner -->

	</div><!-- .faculty-toolbox-tools -->

	<div class="faculty-toolbox-footer">

		<div class="faculty-toolbox-feedback">
			<p><span class="feedback-number">104</span> Faculty are working on <a class="feedback-theme" href="#">Climate change</a></p>
		</div><!-- .faculty-toolbox-feedback -->

		<div class="faculty-toolbox-more-search-tools">
			<a href="#"><i class="icon-search"></i>More search tools<i class="icon-arrow-right"></i></a>
		</div><!-- .faculty-toolbox-more-search-tools -->

	</div><!-- .faculty-toolbox-footer -->

</header><!-- .faculty-toolbox -->