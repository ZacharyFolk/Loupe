<?php
get_header(); ?>		
<div id="viewer" class="viewer">
<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>	
<div id="infoPanel">
<div class="title"><?php the_title(); ?></div>
<div class="theInfoTagList">
<p>Tagged with : <?php the_tags('<ul id="infoTags" ><li>','</li><li>','</li></ul>'); ?></p>
</div>
<?php 
$lat = get_post_meta($post->ID, 'latitude', true);
$long = get_post_meta($post->ID, 'longitude', true);
if ($lat !== '') {
 ?>	
<script type="text/javascript">
  function initialize() {
	    var latlng = new google.maps.LatLng(<?php echo $lat;?>,<?php echo $long;?>);
	    
	    var mapOptions = {
	      zoom: 11,
	      center: latlng,
	      disableDefaultUI: true,
	      panControl: false,
		  zoomControl: true,
	      scaleControl: false,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
	    
	    var map = new google.maps.Map(document.getElementById( "map_canvas" ),  mapOptions); 	
	  	var marker = new google.maps.Marker({
	  		position: latlng,
	  		map: map,
	  		title: "<?php the_title(); ?>"
	  	});
  	}

</script>

 <div id="map_canvas" style="width:100%; height:300px"></div>
 <script>initialize();</script>
<?php   } 

echo get_post_meta($post->ID, 'upload_image', true);

?>
<div class="description"><?php the_content(); ?></div>
<!--
<div class="link">url: <?php the_permalink(); ?></div>
-->

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
<div class="imgContainer">
<img src="<?php echo get_post_meta($post->ID, 'single_photo', true); ?>" />
</div>
</noscript>

<script type="text/javascript">
    var $ = jQuery;
      $(document).ready(function(){
	//	var colors = $.cookie('colors');
                  $("#viewer").iviewer(
                       {
                       src: "<?php echo get_post_meta($post->ID, 'single_photo', true); ?>",    
                       zoom: "fit",
    
                       initCallback: function ()
                       {
                           var object = this;
                           $("#in").click(function(){ object.zoom_by(1);}); 
                           $("#out").click(function(){ object.zoom_by(-1);}); 
						    $('.loader').fadeIn('200');
						
     //  $("#fit").click(function(){ object.fit();}); 
         //$("#orig").click(function(){  object.set_zoom(100); }); 
		 // console.log(this.img_object.display_width); //works*
				// console.log(object.img_object.display_width); //getting undefined.*
                       },
					     onFinishLoad: function()
                    {
                    $('.loader').fadeOut('200');	
					$("#viewer img").fadeIn(400);
                    }
        //      onFinishLoad: function()
                  //      {
			//	$("#viewer").data('viewer').setCoords(-500,-500);
                  //        this.setCoords(-0, -500);
                  //      }
//onMouseMove: function(object, coords) { },
//onStartDrag: function(object, coords) { return false; }, //this image will not be dragged
//onDrag: function(object, coords) { }
                  });
            });
        </script>
        
</div> 
<?php get_footer(); ?>
