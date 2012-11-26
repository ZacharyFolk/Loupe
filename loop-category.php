	<ul id="theThumbs">		
<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
	<?php // get_tags(); ?>

	<li class="<?php the_ID(); ?>">
		<div class="<?php the_ID(); ?>_link" ><?php the_permalink(); ?></div>
				<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=80&h=80&zc=1" alt="<?php the_title(); ?>" class=""/>
	</li>

<?php endwhile;  ?><?php endif; ?>
	</ul>	
	