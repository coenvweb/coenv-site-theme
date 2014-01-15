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
			<h1 class="Faculty-toolbox-title"><a href="<?php bloginfo('url') ?>/faculty/">Faculty</a></h1>
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

		</div><!-- .Faculty-toolbox-content -->

		<div class="Faculty-toolbox-footer">
			
		</div><!-- .Faculty-toolbox-footer -->

	</div>

</header>