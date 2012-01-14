	<ul id="tagImgBox">		
<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
	<?php // get_tags(); ?>

	<li class="<?php the_ID(); ?>">
		<div class="<?php the_ID(); ?>_link" style="display:none"><?php the_permalink(); ?></div>
				<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=80&h=80&zc=1" alt="<?php the_title(); ?>" class="tagInfoTrigger"/>
	</li>

<?php endwhile;  ?><?php endif; ?>
	</ul>	
	<script> 	$('#tagThumbs img').each(function(){
 		$(this).click(function(){
 		var uc = $(this).attr('class');
 		var uc = uc + "_link";
 	    var up = $('.' + uc).html();
 		alert (up);
 		});
 	});</script>