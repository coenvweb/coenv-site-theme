<?php
/**
 Template Name: Intranet Newsletter Archive Page
 * intranet-newsletter.php
 *
 * Template page used for the newsletter archive 
 */
get_header();

$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);

$banner = coenv_banner();


$args = array(
    'post_type' => 'newsletter',
    'meta_key' => 'newsletter_type',
    'meta_value' => 'headlines',
    'post_status' => 'publish',
    'order' => 'DESC',
    'posts_per_page' => -1,
);
$query = new WP_Query($args);
?>

	<section id="blog" role="main" class="template-page">

		<div class="container">

			<nav id="secondary-nav" class="side-col">

					<ul id="menu-secondary" class="menu">
					  <?php wp_list_pages( array(
						  'child_of' => $ancestor['id'],
						  'depth' => 3,
						  'title_li' => '<a href="' . $ancestor['permalink'] . '">' . $ancestor['title'] . '</a>',
						  'link_after' => '<i class="icon-arrow-right"></i>',
						  'walker' => new CoEnv_Secondary_Menu_Walker,
						  'sort_column' => 'menu_order'
					  ) ) ?>
                    </ul>

			</nav><!-- #secondary-nav.side-col -->

			<main id="main-col" class="main-col">
				<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>> 

					<header class="article__header">
							<h1 class="article__title"><?php the_title() ?></h1>
					</header>

					<section class="article__content">
                        <?php if($query->have_posts()) { ?>
                            <h3>Headlines Newsletters</h3>
                        <?php } ?>

                        <?php if($query->have_posts()) { ?>
                            <ul>
                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <?php
                                        $nl_link = get_the_permalink();
                                        $nl_title = get_the_title();
                                    ?>
                                    <li><a href="<?=$nl_link?>"><?=$nl_title?></a></li>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            </ul>
                        <?php } ?>

						<?php the_content() ?>

					</section>
				</article>
			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #blog -->

<?php get_footer() ?>
