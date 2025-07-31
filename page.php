<?php
/**
 * page.php
 *
 * The main page template
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);
?>
	<div class="content-area">
		<!-- Main content -->
		<main class="main" id="main-content" role="main">
			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post() ?>
					<?php get_template_part( 'partials/partial', 'article' ) ?>
				<?php endwhile ?>
			<?php endif ?>
		</main>
		
		<!-- Secondary Navigation -->
		<nav class="nav" role="navigation" aria-label="Section navigation">
			<?php
			$ancestor_id = coenv_get_ancestor('ID');
			$current_page_id = get_the_ID();
			
			if ($ancestor_id) {
				// Display the ancestor title as section heading
				$ancestor_title = get_the_title($ancestor_id);
				echo '<h2>' . esc_html($ancestor_title) . '</h2>';
				
				// Get all direct children of the ancestor (top-level pages in this section)
				$top_level_pages = get_pages(array(
					'parent' => $ancestor_id,
					'sort_column' => 'menu_order',
					'post_status' => 'publish'
				));
				
				if (!empty($top_level_pages)) {
					echo '<ul>';
					
					foreach ($top_level_pages as $page) {
						$is_current = ($page->ID == $current_page_id);
						
						// Check if this page has children
						$children = get_pages(array(
							'parent' => $page->ID,
							'sort_column' => 'menu_order',
							'post_status' => 'publish'
						));
						$has_children = !empty($children);
						
						$classes = array();
						if ($is_current) $classes[] = 'current-page';
						if ($has_children) $classes[] = 'has-children';
						
						$class_attr = !empty($classes) ? ' class="' . implode(' ', $classes) . '"' : '';
						
						echo '<li' . $class_attr . '>';
						echo '<a href="' . get_permalink($page->ID) . '"';
						if ($is_current) {
							echo ' aria-current="page"';
						}
						echo '>' . esc_html($page->post_title) . '</a>';
						
						// Only show children if this is the current page
						if ($is_current && $has_children) {
							echo '<ul class="sub-menu">';
							foreach ($children as $child) {
								$is_current_child = ($child->ID == $current_page_id);
								
								// Check if child has children
								$grandchildren = get_pages(array(
									'parent' => $child->ID,
									'post_status' => 'publish'
								));
								$child_has_children = !empty($grandchildren);
								
								$child_classes = array();
								if ($is_current_child) $child_classes[] = 'current-page';
								if ($child_has_children) $child_classes[] = 'has-children';
								
								$child_class_attr = !empty($child_classes) ? ' class="' . implode(' ', $child_classes) . '"' : '';
								
								echo '<li' . $child_class_attr . '>';
								echo '<a href="' . get_permalink($child->ID) . '"';
								if ($is_current_child) {
									echo ' aria-current="page"';
								}
								echo '>' . esc_html($child->post_title) . '</a>';
								echo '</li>';
							}
							echo '</ul>';
						}
						
						echo '</li>';
					}
					
					echo '</ul>';
				} else {
					// Show message if no subpages exist
					echo '<p>No pages in this section.</p>';
				}
			} else {
				// Fallback if no ancestor is found
				echo '<h2>Navigation</h2>';
				echo '<p>No section navigation available.</p>';
			}
			?>
		</nav>
		
		<?php get_sidebar() ?>
	</div>

<?php get_footer() ?>