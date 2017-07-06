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

                        </header><!-- #header -->

    <div class="image-area small">
        
		<div class="container">
            
            <article class="first-section">
                <header class="article__header">
                    <div class="article__meta">
                         <h1 class="article__title small"><a  class="mobile" href="/students/">Students > </a><a href="students/future-students/future-undergrads/">Future Undergrads</a></h1>
                    </div>
                </header>
                <section class="article__content">
                    <p class="first-title">One College,<br> Many Paths</p>
                </section>
            </article>
            <div class="little-blurb">
                <p>With an entire environment-focused College to explore, you’ll be able to try new things and discover the right fit.</p>
            </div>
            
        </div>
            
        </div>

                    </div><!-- .container.header-container -->

                </div><!-- .banner-wrapper -->


	<section id="page" role="main" class="template-page future-undergrads front">
        
        
        <div>
        
		<div class="container">
            
            
            <?php get_template_part( 'partials/partial', 'future-undergrad-menu' ); ?>

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
        
<script type="text/javascript" src="/wp-content/plugins/accordion-shortcodes/accordion.min.js?ver=2.3.0"></script>
<script type="text/javascript">
/* <![CDATA[ */
var accordionShortcodesSettings = [{"id":"major","autoClose":false,"openFirst":false,"openAll":false,"clickToClose":true,"scroll":false}];
/* ]]> */
</script>