<?php
/*
Template Name: Future Undergrad Subpage
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
                        <h2 class="article__title small"><a  class="mobile" href="/students/">Students > </a><a href="students/future-students/future-undergrads/">Future Undergrads</a></h2>
                    </div>
                </header>
                <section class="article__content">
                    <p class="first-title small">One College,<br> many paths</p>
                </section>
            </article>
            
        </div>
            
        </div>


                    </div><!-- .container.header-container -->

                </div><!-- .banner-wrapper -->

	<section id="page" role="main" class="template-page future-students">

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

                            <section class="article__content" id="content">
                                <h1 class="article__title"><?php the_title() ?></h1>
                                <?php the_content() ?>
                            </section>
                            
                        </article><!-- .article -->

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

    <script type="text/javascript" src="/wp-content/plugins/accordion-shortcodes/accordion.min.js?ver=2.3.0"></script>
<script type="text/javascript">
/* <![CDATA[ */
var accordionShortcodesSettings = [{"id":"content","autoClose":false,"openFirst":false,"openAll":false,"clickToClose":true,"scroll":false}];
/* ]]> */
</script>

<?php get_footer() ?>
