<?php
/**
 * student ambassadors
 *
 * The main page template edited for ambassador profiles
 */
get_header();

//Search terms
$coenv_search_terms = isset($_GET['st']) ? $_GET['st'] : '';
$coenv_search_terms = urlencode(htmlentities($coenv_search_terms));

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
                    
                    <section class="article__content">
                        <div class="intranet-summary">
                            <?php the_content(); ?>
                        </div>
                    </section>
                    
                    <form role="search" method="get" class="search-form Form--inline" action="/students/meet-our-students/student-ambassadors/">
                      <div class="field-wrap">
                        <input type="text" name="st" id="st" placeholder="Search" />
                        <button type="submit"><i class="icon-search"></i><span>Search</span></button>
                      </div>
                    </form>

	               <section class="article__content accordion" id="bio">
                   <?php
                        
                        // First Placement Query
                        $args = array(
                            'post_type'     =>  'student_ambassadors',
                            'post_status'   =>  'publish',
                            'orderby'		=>  'name',
                            'order'			=>  'ASC',
                            'posts_per_page' => -1,
                        );
                        
                        // Search filters
                        if ($coenv_search_terms) :
                            $args['s'] = $coenv_search_terms;
                        endif;
                        
                        $query = new WP_Query( $args );
                        
                        if ($query->have_posts()) {
                            echo '<h2>' . $term->name . '</h2>';
                        }
                
                        while ( $query->have_posts() ) : $query->the_post();
                             include( locate_template( 'partials/partial-student-ambassador.php', false, false ));
                        endwhile;
                        
                    ?>
                       
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
