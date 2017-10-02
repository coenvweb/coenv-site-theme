<?php
/*
Template Name: Future Graduate Subpage
*/
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);
?>

                        </header><!-- #header -->

    <div class="image-area smaller">
        
		<div class="container">
            
            <article class="first-section">
                <header class="article__header">
                    <div class="article__meta">
                        <h2 class="article__title small"><a  class="mobile" href="/students/">Students > </a><a href="students/future-students/future-graduate-students/">Future Graduate Students</a></h2>
                    </div>
                </header>
                <section class="article__content">
                    <p class="first-title small">One College,<br> Many Paths</p>
                </section>
            </article>
            
        </div>
            
        </div>


                    </div><!-- .container.header-container -->

                </div><!-- .banner-wrapper -->

	<section id="page" role="main" class="template-page future-students">

        <div>
        
		<div class="container">
            
            <?php get_template_part( 'partials/partial', 'future-grad-menu' ); ?>

			<main id="main-col" class="main-col">
                
                
				<?php if ( have_posts() ) : ?>

					<?php while ( have_posts() ) : the_post() ?>

						<?php  
                        /**
                         * An individual article
                         */
                        ?>
                        <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

                            <section class="article__content">
                                <h1 class="article__title"><?php the_title() ?></h1>
                                <?php the_content() ?>
                            </section>
                            
                        </article><!-- .article -->

					<?php endwhile ?>

				<?php endif ?>
                

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>