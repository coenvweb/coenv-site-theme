<?php
/**
 Template Name: Student Ambassador Page
 *
 * The main page template edited for ambassador profiles
 */
get_header();

//Search terms
$coenv_search_terms_raw = isset($_GET['st']) ? $_GET['st'] : '';
$coenv_search_terms = $coenv_search_terms_raw;

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
                
                <article id="post-<?php the_ID() ?>" <?php post_class( 'article student-ambassadors' ) ?>>
                    
                    <header class="article__header">
                        <h1 class="article__title"><?php the_title() ?></h1>
                    </header>                 
                    
                    <?php

                        $args = array(
                            'post_type'     =>  'student_ambassadors',
                            'post_status'   =>  'publish',
                            'orderby'       =>  'title',
                            'order'         =>  'ASC',
                            'posts_per_page' => -1,
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'student_type',
                                    'field'    => 'slug',
                                    'terms'    => 'undergraduate-student',
                                ),
                            ),
                        );
                        
                        // Search filters
                        if ($coenv_search_terms) :
                            $meta_query = array(
                                'relation' => 'OR',
                                array(
                                    'key' => 'class',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'majors_and_minors_0_major__minor',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'majors_and_minors_0_other_major',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'majors_and_minors_0_concentration',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),                                
                                array(
                                    'key' => 'majors_and_minors_1_major__minor',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'majors_and_minors_1_other_major',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'majors_and_minors_1_concentration',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),                                
                                array(
                                    'key' => 'majors_and_minors_2_major__minor',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'majors_and_minors_2_other_major',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'majors_and_minors_2_concentration',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'last_school',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'hometown',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'first_name',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'last_name',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                                array(
                                    'key' => 'response',
                                    'compare' => 'LIKE',
                                    'value' => $coenv_search_terms
                                ),
                            );
                            $args['meta_query'] = $meta_query;
                        endif;
                        
                        $query = new WP_Query( $args );
                    ?>

                   <section class="article__content accordion" id="bio">
                       <div class="intranet-summary">
                            <?php the_content(); ?>
                       </div>

                       <form role="search" method="get" class="search-form Form--inline" id="post-search" action="/students/meet-our-students/undergraduate-ambassadors/">
                          <div class="field-wrap">
                            <input type="text" name="st" id="st" placeholder="Search for keywords (out of state, oceanography, ROTC, etc.)" value="<?php echo $coenv_search_terms_raw ?>" />
                            <button type="submit"><i class="icon-search"></i><span>Search</span></button>
                          </div>
                        </form>
                       
                       <?php if ($coenv_search_terms): // Category filter ?>
                        <div class="panel">
                            <div class="left">Ambassador(s) matching <strong>"<?php echo $coenv_search_terms; ?>"</strong></div>
                            <a class="right" href="<?php echo the_permalink(); ?>"><i class="icon-cross"></i></a>
                        </div>
                        <?php endif; ?>
            
                   <?php
                        
                        if ($query->have_posts()) {
                        } else {
                            echo '<p>No ambassadors found matching your search, try again.</p>';
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

