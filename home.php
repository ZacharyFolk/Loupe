<?php
get_header(); ?>

	<div id="container">
	
			<div class="lightTable">
				<div id="leftBlock">
					<div id="featured" class="pics"> 
						<?php $the_query = new WP_Query('category_name=featured&showposts=20');
						while ($the_query->have_posts()) : $the_query->the_post();?>
						<?php //getImage(1); ?>
						<div class="featuredSlide">
						<a href="<?php the_permalink(); ?>">
						<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo catch_that_image() ?>&w=500&h=500&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
						</a>
						<?php the_title(); ?>
						</div>
						<?php endwhile; ?>
					</div> <!-- featured -->
				</div>
				
				<div id="rightBlock">
				
					<h2 class="buttPad postTrigger">Recent Posts</h2>
					<ul id="recentPosts" class="clearfix">
					<?php $myposts = get_posts('numberposts=10');
						foreach($myposts as $post) :?>
						<li  class='recentThumbs'><a href="<?php the_permalink(); ?>">
						
						<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo catch_that_image() ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
						</a></li>
						<?php endforeach; ?>
					</ul>
					
					<h2 class="tagTrigger">Top Ten Tags</h2>
						<ul id="recentTags">
						<?php $ttargs = array(
						'orderby' => 'count',
						'order' => 'DESC',
						'number' => 10,
						);
						$tttags = get_tags( $ttargs );
						$topTenHTML = '<div class="post_tags">';
							foreach ($tttags as $tttag){
								$tttag_link = get_tag_link($tttag->term_id);		$topTenHTML .= "<li><a href='{$tttag_link}' title='{$tttag->name} Tag' class='{$tttag->slug}'></li>";
								$topTenHTML .= "{$tttag->name}</a>";
							}
							$topTenHTML .= '</div>';
							echo $topTenHTML;
						?>
						</ul>
					</div>

				</div> <!-- / rightBlock -->
			</div><!-- /lightTable -->

	</div><!-- #container -->
</div><!--- /main -->
</div><!-- /wrap -->
<script type="text/javascript">
jQuery(document).ready(function($){
$('#featured').cycle({fx: 'fade', speed: 2500});
});
</script>
<?php get_footer(); ?>
