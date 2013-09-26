<?php
/**
 * The loop to call in tag thumbs
 *
 */
?>	
<ul id='theThumbs'>
<?php
global $wp;
$s_array = array('posts_per_page' => -1); // Change to how many posts you want to display 
$new_query = array_merge( $s_array, (array)$wp->query_vars );
query_posts($new_query);
if ( have_posts() ) :  while ( have_posts() ) : the_post();
?>
<li>
	<a href="<?php the_permalink(); ?>">
		<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=160&h=120&zc=1" alt="<?php the_title(); ?>" />	</a>
	</li>
<?php	
	endwhile; 
	 wp_reset_query(); 
endif;
echo '</ul>';