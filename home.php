<?php
/**
 * Template Name: Home
 */
get_header(); ?>
<div id="tagThumbs"></div>
	<div class='loader'><img src='<?php bloginfo('template_url');?>/images/ajax-loader-000.gif'></div>	
	<div class="lightTable">
		<div class="floater hometagged">			
			<div id="leftBlock">
				<div id="featured" class="pics"> 					
					<?php 
					$args = array( 'post_type' => 'photo',
					'posts_per_page' => 50);								 
					$the_query = new WP_Query($args);
					while ($the_query->have_posts()) : $the_query->the_post();
						$featured = get_post_meta($post->ID, 'isFeatured', true);
						if ( $featured  ) {
					?>			
							<div class="featuredSlide">
								<a href="<?php the_permalink(); ?>">
								<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=500&h=500&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
								</a>
								<div class="homeCaption"><?php the_title();?></div>
							</div>							
						<?php } endwhile; ?>
				</div> <!-- featured -->
			</div>					
			<div id="rightBlock">
				<ul id="thumbNav">
					<?php
					$args = array('post_type' => 'photo',
					'posts_per_page' => 50);									 
					$the_query = new WP_Query($args);
					while ($the_query->have_posts()) : $the_query->the_post();
					$featured = get_post_meta($post->ID, 'isFeatured', true);
						if ( $featured  ) {
					?>
					<li class="recentThumbs">
					<a href="<?php the_permalink(); ?>">
					<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
					</a>
					</li>
					<?php } endwhile; ?>
				</ul>
	
			</div>
		</div> 
	</div> 
<script type="text/javascript">
jQuery(document).ready(function($){
	$('#featured').cycle(
		{
		fx: 'fade', speed: 300, timeout: 3000,
		allowPagerClickBubble: true, 
		pagerEvent: 'mouseover',
		pauseOnPagerHover:true,
		pause :1,
		pagerAnchorBuilder: function(idx,slide){
		return '#thumbNav li:eq(' + idx + ') a';
			}
		}
	);

});
</script>
<?php get_footer(); ?>