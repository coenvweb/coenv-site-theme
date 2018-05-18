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

	<section id="page" role="main" class="template-page">

		<div class="container">

			<?php if ( in_array( $post->post_type, array('page') ) ) : ?>

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

			<?php endif ?>

			<main id="main-col" class="main-col">
                
                <article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>
                    
                    <header class="article__header">
                        <h1 class="article__title"><?php the_title() ?></h1>
                    </header>

	               <section class="article__content" >
                     <div class="page-contacts accordion" id="bio">
                   <?php
                        $terms = get_terms( 'team', array(
                        'hide_empty' => 0
                    ) );
                $i = 0;

                    foreach( $terms as $term ) {
                        
                        // First Placement Query
                        $args = array(
                            'post_type'     =>  'staff',
                            'post_status'   =>  'publish',
                            'meta_key'		=>  'placement',
                            'meta_query' => array(
                                array(
                                    'key' => 'placement',
                                    'value' => 2,
                                    'compare' => '<='
                                )
                            ),
                            'orderby'		=>  'meta_value_num',
                            'order'			=>  'ASC',
                            'posts_per_page' => -1,
                            'team'          =>  $term->slug
                        );
                        $query = new WP_Query( $args );

                        echo '<h2>' . $term->name . '</h2>';
                
                        while ( $query->have_posts() ) : $query->the_post();
                             include( locate_template( 'partials/partial-staff.php', false, false ));
                        endwhile;
                        

                        // Last Name Alpha Query
                        $args = array(
                            'post_type'     =>  'staff',
                            'post_status'   =>  'publish',
                            'meta_query' => array(
                                array(
                                    'key' => 'placement',
                                    'value' => 3,
                                    'compare' => '='
                                )
                            ),
                            'orderby'		=>  'name',
                            'order'			=>  'ASC',
                            'posts_per_page' => -1,
                            'team'          =>  $term->slug,
                        );
                        add_filter( 'posts_orderby' , 'posts_orderby_lastname' );
                        $query = new WP_Query( $args );
                        remove_filter( 'posts_orderby' , 'posts_orderby_lastname' );
                
                        while ( $query->have_posts() ) : $query->the_post();
                            include( locate_template( 'partials/partial-staff.php', false, false ));
                            $i++;
                        endwhile;
                        wp_reset_postdata();
                    } ?>
                       </div>
                    </section>
                    
                </article>
                
            <div class="side-footer">
                <?php get_sidebar('contact') ?>
            </div>

			</main><!-- .main-col -->

			<div class="side-col">
				<?php get_sidebar() ?>
			</div><!-- .side-col -->

		</div><!-- .container -->

	</section><!-- #page -->

<?php get_footer() ?>

<script type="text/javascript" src="<?php echo content_url(); ?>/plugins/accordion-shortcodes/accordion.min.js?ver=2.3.0"></script>
<script type="text/javascript">
/* <![CDATA[ */
var accordionShortcodesSettings = [{"id":"bio","autoClose":false,"openFirst":false,"openAll":false,"clickToClose":true,"scroll":false}];
/* ]]> */
</script>
