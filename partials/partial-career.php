<article id="post-<?php the_ID() ?>" <?php post_class( 'career' ) ?>>

	<header class="article__header">
        <div class="article__meta">
			<div class="share align-right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
			data-article-shortlink="<?php echo the_permalink(); ?>"
			data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="icon-share"></i>Share</a>
            </div>
			<div class="post-info">
                Posted: 
				<time class="article__time" datetime="<?php echo get_the_date('Y-m-d h:i:s') ?>"><?php echo get_the_date('M j, Y') ?></time>

                <?php
                date_default_timezone_set('America/Los_Angeles');
				$deadline = get_post_meta( get_the_ID(), '_expiration-date', true );
				$timestamp = time();
				$timeexpired = (int) strtotime(do_shortcode('[postexpirator type="full"]'));
				
				if ( $timeexpired < $timestamp ) {

					$expired = 'expired';

				} elseif ( $deadline > ($timestamp + 63072000) ) {

					$expired = 'openuntilfilled';

				} else {

					$expired = 'current';
				}
                
                ?>
                 | <span class="deadline <?php echo $expired; ?>">

                <?php if ($expired == 'current') { ?>
                	Deadline: <time class="article__time" datetime="<?php echo date('Y-m-d h:i:s', $timestamp) ?>"><?php echo date('M j, Y', $timeexpired) ?></time>
                <?php } elseif ($expired == 'openuntilfilled') { ?>
                	Deadline: Open Until Filled
                <?php } else { ?>
                	Deadline passed (<time class="article__time expired" datetime="<?php echo date('Y-m-d h:i:s', $timestamp) ?>"><?php echo date('M j, Y', $timeexpired) ?></time>)
                <?php } ?>               	
            	</span>
            </div>
		</div>

		<?php if ( is_single() ) : ?>
			<h1 class="article__title"><?php the_title() ?></h1>
		<?php else : ?>
			<h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h2>
		<?php endif;
		$career_tags = get_the_terms($post->ID,'career_post_tag');
		if ( $career_tags && ! is_wp_error( $career_tags ) ) : 
		foreach ( $career_tags as $tag ) {
			$career_tag_links .= '<a href="/students/career-resources/career-funding-opportunities/?tag=' . $tag->slug . '" title="' . $tag->name . '">' . $tag->name . '</a>, ';
		}
		?>
		<div class="career-terms" style="float: left; clear: both;">
		<?php echo rtrim($career_tag_links,', '); ?>
		</div>
		<?php endif; ?>
		<?php if (current_user_can( 'edit_career', get_the_ID() ) ) { echo '<a class="button" href="/wordpress/wp-admin/post.php?post='. get_the_ID() . '&action=edit">Edit this post</a>'; } ?>
	</header>
	
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->

<!--



 

-->