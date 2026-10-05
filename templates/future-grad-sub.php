<?php
/*
Template Name: Future Graduate Students Subpage
*/
get_header();

$ancestor_id = coenv_get_ancestor();
$header_page_id = $ancestor_id;

if ( empty( get_field('future_students_header_image', $header_page_id) ) || empty( get_field('future_students_heading', $header_page_id) ) ) {
	$parent_id = wp_get_post_parent_id( get_the_ID() );
	if ( ! empty( $parent_id ) ) {
		$header_page_id = $parent_id;
	}
}

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);
?>

	<section id="page" role="main" class="template-page future-students front">

        <div>

		<div class="container">

            <nav id="secondary-nav" class="side-col">
                <ul id="menu-secondary" class="menu">
                    <?php
                    $list_args = array(
                        'child_of' => $ancestor['id'],
                        'depth' => 3,
                        'title_li' => '',
                        'echo' => 0,
                        'walker' => new CoEnv_Secondary_Menu_Walker,
                        'sort_column' => 'menu_order'
                    );
                    $secondary_nav_items = wp_list_pages($list_args);
                    echo '<li class="pagenav"><ul>' . $secondary_nav_items . '</ul></li>';
                    ?>
                </ul>

            </nav><!-- #secondary-nav.side-col -->

			<main id="main-col" class="main-col container">

            <div class="image-area small">

                <div class="container" style="background-image: url(<?php echo get_field('future_students_header_image', $header_page_id); ?>); background-size: cover; background-position: center; background-repeat: no-repeat;">

                    <article class="first-section">
                        <header class="article__header">
                            <div class="article__meta">
                                <h2 class="article__title small"><a class="mobile" href="/students/">Students > </a><a href="students/future-students/future-graduate-students/">Future Graduates</a></h2>
                            </div>
                        </header>
                        <section class="article__content">
                            <p class="first-title"><?php echo get_field('future_students_heading', $header_page_id); ?></p>
                        </section>
                    </article>

                </div>

            </div>

            <?php// get_template_part( 'partials/partial', 'future-grad-menu' ); ?>

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
