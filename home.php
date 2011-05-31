<?php
/**
 * Template Name: Home
 */
get_header(); ?>
	<div class="lightTable">
		<div class="floater">
			<div id="leftBlock">
				<div id="featured" class="pics"> 
						<?php 
						$args = array('category_name' => 'featured',
				              		'post_type' => array ('post','portfolio'),
							         'posts_per_page' => 20);
									 
						$the_query = new WP_Query($args);
						while ($the_query->have_posts()) : $the_query->the_post();?>
						<?php //getImage(1); ?>
					<div class="featuredSlide">
						<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_first_attachment() ?>&w=500&h=500&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
						</a>
						<?php the_title(); ?>
					</div>
						<?php endwhile; ?>
				</div> <!-- featured -->
			</div>		
			<div id="rightBlock">
			<ul id="thumbNav">
			<?php
			$args = array('category_name' => 'featured',
				              		'post_type' => array ('post','portfolio'),
							        'posts_per_page' => 20);
									 
						$the_query = new WP_Query($args);
						while ($the_query->have_posts()) : $the_query->the_post();?>
			<li class="recentThumbs">
			<a class="" href="<?php the_permalink(); ?>">
			<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_first_attachment() ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
			</a></li>
			<?php endwhile; ?>
			</ul>
			<!-- //	<h2>Recent Posts</h2>
				<ul id="recentPosts" class="clearfix">
				<?php $myposts = get_posts('numberposts=10');
						foreach($myposts as $post) :?>
					<li  class='recentThumbs'><a href="<?php the_permalink(); ?>">					
						<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo catch_that_image() ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
						</a>
					</li>
						<?php endforeach; ?>
				</ul>	
			//-->		
			</div>
		</div> 
	</div> 
<script type="text/javascript">
jQuery(document).ready(function($){
$('#featured').cycle(
{fx: 'fade', speed: 300, timeout: 3000,
allowPagerClickBubble: true, 
pagerEvent: 'mouseover',
pauseOnPagerHover:true,
pagerAnchorBuilder: function(idx,slide){
return '#thumbNav li:eq(' + idx + ') a';
}
});
});
</script>
<?php get_footer(); ?>