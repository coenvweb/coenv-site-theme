<?php
/*
Template Name: Full width
*/
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);
?>

	<section id="page" role="main" class="template-page future-undergrads">
        
		<div class="container">
            <div id="top-tab" class="side-col">

                <ul class="menu">
                    <li class="pagenav parent_page_item current_page_parent"><a href="http://environment.uw.dev/students/">Students</a></li>
                </ul>

            </div><!-- #secondary-nav.side-col -->
            
            <nav id="arrow-nav" class="second-nav">

                <ul id="menu-secondary" class="arrow-menu">
                    <li class="arrow-button arrow-1 active"><a href="http://environment.uw.dev/students/">Prepare</a></li>
                    <li class="arrow-button arrow-2"><a href="http://environment.uw.dev/students/">Visit</a></li>
                    <li class="arrow-button arrow-3"><a href="http://environment.uw.dev/students/">Apply</a></li>
                </ul>

            </nav><!-- #secondary-nav.side-col -->

			<?php if ( in_array( $post->post_type, array('page') ) ) : ?>
            
                <sidebar id="sidebar" class="side-col right-col">

                    <p>stuff here</p>

				</sidebar>

			<?php endif ?>

			<main id="main-col" class="main-col">
                
                
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php get_template_part( 'partials/partial', 'article' ) ?>

					<?php endwhile ?>

				<?php endif ?>

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>