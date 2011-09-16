<?php
get_header(); ?>		
<div id="two_up" class="portrait">
<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>
<div id="infoPanel">
	<div class="title"><?php the_title(); ?></div>
	<div class="description"><?php the_content(); ?></div>
	<div class="link">url: <?php the_permalink(); ?></div>
	<p><?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?></p>
</div>

<div class="two_images">
	<?php
		global $post;
  $args = array( 
    'post_parent' => $post->ID, 
    'post_type' => 'attachment', 
    'post_mime_type' => 'image', 
    'orderby' => 'menu_order', 
    'order' => 'ASC', 
    'numberposts' => 2 );
   $images = get_posts($args);
   if ( $images ) {
    $i = 0;
	$z = 1;
    while($i <= 1){
    	$image = wp_get_attachment_url( $images[$i]->ID );
    echo "<img src='$image' class='image_$z' />";	
    	?>
   
    <?php
      $i++;
	  $z++;
    }
  }
 ?>
	 <script type="text/javascript">
    var image = "<?php echo $image ; ?>";
    var under700_<? echo $z ?> = "/wp-content/themes/Loupe/scripts/timthumb.php?src=<? echo $image ?>&w=340";
     var under900_<? echo $z ?> = "/wp-content/themes/Loupe/scripts/timthumb.php?src=<? echo $image ?>&w=440";
     var under1000_<? echo $z ?> = "/wp-content/themes/Loupe/scripts/timthumb.php?src=<? echo $image ?>&w=490";
     function imageresize() { 
       var contentwidth = $('#two_up').width();  
         if ((contentwidth) < '700'){	
		 	 console.log('under 700_<? echo $z ?>' + under700_<? echo $z ?>);	
			 $('img .image_<? echo $z ?>').attr('src', under700_<? echo $z ?>);
			 } else if ((contentwidth) < '900') {
			// console.log('under 900');			 
			 $('img .image_<? echo $z ?>').attr('src', under900_<? echo $z ?>);
			 }
			  else {
			  image;
			 }
	 }
    	</script>
    	
    		</div><!-- .gallery-thumb -->


<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div> 

 <script type="text/javascript">

	
	$(document).ready(function() {
	
	 imageresize();//Triggers when document first loads    	
	 $(window).bind("resize", function(){//Adjusts image when browser resized
	 imageresize();
	 });
 }); 
</script>
<?php get_footer(); ?>

