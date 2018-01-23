<?php
// Dates
$coenv_year = isset($_GET['coenv-year']) ? $_GET['coenv-year'] : '';
$coenv_month = isset($_GET['coenv-month']) ? $_GET['coenv-month'] : '';
$coenv_year = urlencode(htmlentities($coenv_year));
$coenv_month = urlencode(htmlentities($coenv_month));
$coenv_date = $coenv_month . '/' . $coenv_year;

//Categories
$coenv_cat_term_1 = isset($_GET['term']) ? $_GET['term'] : '';
$coenv_cat_term_1 = urlencode(htmlentities($coenv_cat_term_1));
$coenv_cat_term_1_arr = get_term_by('slug',$coenv_cat_term_1,'topic');
if ($coenv_cat_term_1_arr) {
    $coenv_cat_term_1_val = $coenv_cat_term_1_arr->name;
    $coenv_cat_term_1_id = $coenv_cat_term_1_arr->term_id;
}

//Tags
$coenv_cat_tag_1 = isset($_GET['tag']) ? $_GET['tag'] : '';
$coenv_cat_tag_1 = urlencode(htmlentities($coenv_cat_tag_1));
$coenv_cat_tag_1_arr = get_term_by('slug',$coenv_cat_tag_1,'post_tag');
if ($coenv_cat_tag_1_arr) {
    $coenv_cat_tag_1_val = $coenv_cat_tag_1_arr->name;
}

//Search terms
$coenv_search_terms = isset($_GET['st']) ? $_GET['st'] : '';
$coenv_search_terms = urlencode(htmlentities($coenv_search_terms));

?>

<article>
                    <div id="blog-header" class="blog-header">
                        <h4 class="filter-title">Filter Intranet Posts:</h4>
                        <form role="search" method="get" class="search-form Form--inline" action="<?php echo home_url( '/' ); ?>">
                            <div class="field-wrap">
                                <input type="hidden" name="post_type" value="intranet" />
                                <label for="s">Search Intranet Posts</label>
                                <input type="text" value="<?php echo get_search_query() ?>" name="s" id="s" placeholder="Search Intranet Posts" />
                                <button type="submit"><i class="icon-search"></i><span>Search</span></button>
                            </div>
                        </form>
                    <div class="input-item select-category" data-url="<?php echo get_bloginfo('url'); ?>">
                        <?php
                            $cats = get_categories(array(
                                'type' => array('post', 'intranet'),
                                'taxonomy' => array('topic')
                            ));
                                $output = '<label for="intranet-topic-select">Topic select</label><select name="category-dropdown" id="intranet-topic-select">';
                                $output .= '<option value="/intranet/">Choose a topic</option>';
                                if ( !empty( $cats ) ) {	
                                foreach ( $cats as $cat ) {
                                    if (term_is_ancestor_of(1239, $cat->term_id, 'topic') && ($cat->slug !== 'diversity-equity-and-inclusion') && (!term_is_ancestor_of(2437, $cat->term_id, 'topic'))){
                                    if (isset($coenv_cat_term_1_id)) {
                                        $selected = $coenv_cat_term_1_id == $cat->term_id ? ' selected="selected"' : '';} else {
                                        $selected = '';
                                    }
                                    $output .= '<option value="/intranet/?term=' . $cat->slug . '" ' . $selected . '>' . $cat->name . '</option>';					                    }
                                }
                                }	
                                $output .= '</select>';
                                echo $output;
                        ?>
                    </div>
                    <div class="input-item select-month">
                    <label for="date-filter">Date select</label>
			<?php coenv_base_date_filter('intranet',$coenv_month,$coenv_year); // Date filter ?>
                    </div>
                </div><!-- #blog-header -->
                </article>