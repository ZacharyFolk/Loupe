<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>
<div class="lightTable">
		<div class="floater">			
			<div id="leftBlock">
				<div id="featured" class="pics"> 					
				<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
							<div class="featuredSlide">
								<a href="<?php the_permalink(); ?>">
								<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=500&h=500&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
								</a>
								<?php the_title();?>
							</div>							
						<?php  endwhile; endif; ?>
				</div> <!-- featured -->
			</div>					
			<div id="rightBlock">
				<ul id="thumbNav">
				<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
					<li class="recentThumbs">
					<a class="" href="<?php the_permalink(); ?>">
					<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
					</a>
					</li>
					<?php  endwhile;  endif;?>
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
		pagerAnchorBuilder: function(idx,slide){
		return '#thumbNav li:eq(' + idx + ') a';
			}
		}
	);
});
</script>
<?php get_footer(); ?>
