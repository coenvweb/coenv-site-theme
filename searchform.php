<form role="search" method="get" class="search-form Form--inline" action="<?php echo home_url( '/' ); ?>">
  <div class="field-wrap">
    <?php if(get_query_var('post_type') != "") { ?>
        <input type="hidden" name="post_type" value="<?php get_query_var('post_type') ?>" />
    <?php } ?>
	<input type="text" value="<?php echo get_search_query() ?>" name="s" placeholder="Search this site" aria-label="Search" title="Search"/>
    <button type="submit"><i class="icon-search"></i><span>Search</span></button>
  </div>
</form>
