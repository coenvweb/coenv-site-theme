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
        
        <div class="image-area">
        
		<div class="container">
            <div id="top-tab" class="side-col">

                <ul class="menu">
                    <li class="pagenav parent_page_item current_page_parent"><a href="http://environment.uw.dev/students/">Students</a></li>
                </ul>

            </div><!-- #secondary-nav.side-col -->
            
            <article class="first-section" ?>>
                <header class="article__header">
                    <div class="article__meta">
                        <h1 class="article__title"><?php the_title() ?></h1>
                    </div>
                </header>
                <section class="article__content">
                    <p class="first-title">One College,<br> Many Paths</p>
                </section>
            </article>
            <div class="other-side">
                <p class="side-text">What’s it like to be a UW College of the Environment undergrad?
 
It’s waking long before dawn breaks onboard a research vessel in search of Puget Sound marine life. It’s trekking into the Cascade Mountains to explore volcanoes and rock formations that reveal our planet’s history. It’s exploring the sustainability of our natural resources through the perspectives of the people and communities that depend on them. It’s developing computer models that inform climate predictions.
 
With an entire environment-focused College to explore, you’ll be able to try new things and discover the right fit. Your experiences will be exciting. Challenging. Uniquely your own.</p>
            </div>
            
        </div>
            
        </div>
        <div>
        
		<div class="container">
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
                <section class="article__content majors-minors accordion" id="bio">
                <?php

                // check if the repeater field has rows of data
                if( have_rows('majors_and_minors') ):

                    // loop through the rows of data
                    while ( have_rows('majors_and_minors') ) : the_row();

                        // display a sub field value
                        get_template_part( 'partials/partial', 'major-minor' );

                    endwhile;

                else :

                    // no rows found

                endif;

                ?>
                </section>

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>
        
<script type="text/javascript" src="http://environment.uw.dev/wp-content/plugins/accordion-shortcodes/accordion.min.js?ver=2.3.0"></script>
<script type="text/javascript">
/* <![CDATA[ */
var accordionShortcodesSettings = [{"id":"bio","autoClose":false,"openFirst":false,"openAll":false,"clickToClose":true,"scroll":false}];
/* ]]> */
</script>