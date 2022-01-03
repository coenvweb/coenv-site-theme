<?php  
/**
 * An individual article
 */
?>
<article id="post-<?php the_ID() ?>" <?php post_class( 'article' ) ?>>

	<header class="article__header" id="#share-<?php the_ID() ?>">
        <div class="article__meta">
   		<?php if ( !is_page() && !is_singular('intranet') ) : ?>
			<div class="share align-right" data-article-id="<?php the_ID(); ?>" data-article-title="<?php echo get_the_title(); ?>"
			data-article-shortlink="<?php echo wp_get_shortlink(); ?>"
			data-article-permalink="<?php echo the_permalink(); ?>"><a href="#"><i class="icon-share"></i>Share</a>
            </div>
			<div class="post-info">
				<time class="article__time" datetime="<?php get_the_date( '' ); ?>"><?php echo get_the_date('M j, Y'); ?></time>
				<?php coenv_post_cats($post->ID); ?>
			</div>
		<?php endif ?>

		<?php if ( is_page() || is_single() ) : ?>
      <!--<div class="post-info subtitle"><p><?php echo get_field('feature_label'); ?></p></div>-->
			<h1 class="article__title"><?php the_title() ?></h1>
		<?php else : ?>
			<h1 class="article__title"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title() ?></a></h1>
		<?php endif ?>

	</header>

	<section class="article__content" id="content">

		<?php the_content() ?>

		<?php if ( !is_page() && get_field('story_link_url') ) { ?>
        <?php if ( strpos(get_field('story_link_url'),"environment.") ) {
          $env_target = '_self';
        } else {
          $env_target = '_blank';
        }
        ?>
				<a href="<?php the_field('story_link_url'); ?>" class="button" target="<?php echo $env_target; ?>"><?php the_field('story_source_name'); ?> »</a>

		<?php } ?>


    <?php 
        $page_contacts = get_field('page_contacts', get_the_ID());

      if( $page_contacts ): ?>
        <div class="page-contacts">
        <h2 class="small-contact-title">
        <?php
        $page_contact_title = get_field('contact_title');
         if ($page_contact_title) {
            echo $page_contact_title;
        } elseif (count($page_contacts) > 1) {
            echo 'Dean\'s Office Contacts:';
        } else {
            echo 'Dean\'s Office Contact:';
        };
        ?>
        </h2>
        <?php foreach( $page_contacts as $page_contact): // variable must be called $post (IMPORTANT) ?>
            <?php setup_postdata($post); ?>
            <?php get_template_part( 'partials/partial', 'staff' ) ?>
        <?php endforeach; ?>
        <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
        </div>
    <?php endif; ?>
	</section>
		
    <?php remove_filter( 'the_title', 'wptexturize' );
    remove_filter( 'the_excerpt', 'wptexturize' ); ?>

</article><!-- .article -->