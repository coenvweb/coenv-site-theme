<article class="story">

	<div class="inner">

		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink() ?>" class="img">
				<?php the_post_thumbnail( 'medium' ) ?>
			</a>
		<?php endif ?>

		<div class="content">
			<h1><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
			<?php the_excerpt() ?>
            <a href="<?php the_permalink() ?>" class="button">Read more »</a>
		</div>

	</div><!-- .inner -->

</article>