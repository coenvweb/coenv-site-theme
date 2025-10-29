<?php
/*
Template Name: Strategic Plan
*/

get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);
?>

	<section id="page" class="strategic-plan template-page">

		<div class="container">

			<?php if ( in_array( $post->post_type, array('page') ) ) : ?>

				<nav id="secondary-nav" class="side-col">

			<ul id="menu-secondary" class="menu">
                  <?php
                  $list_args = array(
                      'child_of' => $ancestor['id'],
                      'depth' => 3,
                      'title_li' => '<a href="' . $ancestor['permalink'] . '">' . $ancestor['title'] . '</a>',
                      'link_after' => '<i class="icon-arrow-right"></i>',
                      'walker' => new CoEnv_Secondary_Menu_Walker,
                      'sort_column' => 'menu_order' 
                  );
                  wp_list_pages($list_args);
                  ?>
	          </ul>

				</nav><!-- #secondary-nav.side-col -->

			<?php endif ?>

			<main id="main-col" class="main-col">

				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'article' ) ?>

					<?php endwhile ?>

				<?php endif ?>
          
            <div class="side-footer">
                <div class="hidden">
                    <?php if(current_user_can('ow_make_revision') && current_user_can('ow_make_revision_others')) { ?>
                        <?php echo do_shortcode('[ow_make_revision_link text="Make Revision" class="" type="text" post_id="'.get_the_ID().'"]'); ?>
                    <?php } ?>
                </div>
                <?php get_sidebar('footer') ?>
            </div>

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>
