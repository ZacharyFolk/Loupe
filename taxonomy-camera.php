<ul id='theThumbs'>
<?php
if ( have_posts() ) :  while ( have_posts() ) : the_post();
?>
<li>
	<a href="<?php the_permalink(); ?>">
		<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=60&h=60&zc=1" alt="<?php the_title(); ?>" />	
<?php	
	endwhile;  
endif;
echo '</ul>';
