<?php while ( have_posts() ) : the_post(); ?>
	<?php get_tags(); ?>
		<div class="tagImgBox">		
			<a href="<?php the_permalink(); ?>">
				<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo catch_that_image() ?>&w=200&h=200&zc=1" alt="<?php the_title(); ?>" class="tagInfoTrigger"/>
			</a>	
		</div>
<?php endwhile;  ?>