<?php
get_header(); ?>		
<div id="viewer" class="viewer">
<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
<div id="infoPanel">
<div class="title"><?php the_title(); ?></div>
<div class="description"><?php the_content(); ?></div>
<p><?php the_tags(); ?></p>
</div>	
<?php if ( get_post_meta($post->ID, 'story', true) ) : ?>

     <?php echo get_post_meta($post->ID, 'story', true) ?>
   
<?php endif; ?>

<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<noscript>
<style type="text/css">
#controls{display:none}
#viewer img {width: 800px}
.imgContainer{margin: 0 auto; width: 800px}</style>
<?php  while ( have_posts() ) : the_post(); ?>
<div class="imgContainer">
<img src="<?php echo catch_that_image() ?>" />
</div>
<?php endwhile; ?>
</noscript>
</div> 
<?php get_footer(); ?>
