<?php
$ancestor_id = coenv_get_ancestor();

$ancestor = array(
	'id' => $ancestor_id,
	'permalink' => get_permalink( $ancestor_id ),
	'title' => get_the_title( $ancestor_id )
);

?>

<ul>
	<?php 
		wp_list_pages(array(
			'child_of' => $ancestor['id'],
			'sort_column' => 'menu_order',
			'depth' => 3,
			'title_li' => '<a href="' . $ancestor['permalink'] . '">' . $ancestor['title'] . '</a>',
			'link_after' => '<i class="icon-arrow-right"></i>'
		));
	?>
</ul>