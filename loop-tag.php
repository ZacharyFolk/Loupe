<?php while ( have_posts() ) : the_post(); ?>

		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyten' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

<a href="<?php the_permalink(); ?>">
				<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo catch_that_image() ?>&w=140&h=120&zc=1&q=80" alt="<?php the_title(); ?>" />
				</a>

		</div><!-- #post-## -->




<?php endwhile;  ?>

