<?php
get_header(); ?>		
<div id="viewer" class="viewer">
<noscript>
<style type="text/css">
#controls{display:none}
#viewer img {width: 800px}
.imgContainer{margin: 0 auto; width: 800px}</style>
<?php while ( have_posts() ) : the_post(); ?>
<div class="imgContainer">
<img src="<?php echo catch_that_image() ?>" />
</div>
<?php endwhile; ?>
</noscript>
</div> 
   
<?php get_footer(); ?>
