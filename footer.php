<?php
/**
 * @package WordPress
 * @subpackage Loupe
 * @since Loupe 0.1
 */
?>
</section><!-- #main -->
<!--//
<?php if ( ! is_home()){ ?>
<div class="thumbBox" >
	<?php
		$thumbPosts = new WP_Query();
		$thumbPosts->query('showposts=55');
		while ($thumbPosts->have_posts()) : $thumbPosts->the_post(); ?>
		<a href="<?php the_permalink(); ?>">
		<img class="nofotomoto" src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_first_attachment() ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
		</a>
	<?php endwhile; ?>
</div>
<?php } ?>
-->
	<footer>
		<?php edit_post_link('edit', '<p class="editLink">', '</p>'); ?>
		<p>
		&copy; <?php echo date("Y"); ?> Zachary Folk Photography | <a href="http://wordpress.org/" title="Semantic Personal Publishing Platform" rel="generator">Proudly powered by WordPress </a> and the Loupe 
		</p>
<!--//
	<?php if (! is_home()){ ?>
	 <div class="all">Show Recent Posts</div>
	<?php } ?>
-->
	<?php //if ( have_posts() ) while ( have_posts() ) : the_post();
	
//	wpfp_link();  ?> 
   
<?php // endwhile; // end of the loop. ?>

<div class="fb"> 
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
</div>
</footer><!-- #footer -->
<?php wp_footer(); ?>
</body>
</html>