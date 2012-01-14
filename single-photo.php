<?php get_header(); ?>		
<div id="tagThumbs"></div>
	<div class='loader'><img src='<?php bloginfo('template_url');?>/images/ajax-loader-000.gif'></div>
	<div class="tagTable" style="display:none">&nbsp;</div>
	<div id="ajaxTable">

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
 <script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBw1DpJdlyFiMUhy9yu1zThIK9AFa5zGac&sensor=true">
    </script>
    <script type="text/javascript">
        var lat = "<?php echo $lat;?>"; 
      	var lng = "<?php echo $long;?>";
      	var myLatlng = new google.maps.LatLng(lat,lng);
      function initialize() {
       	//console.log(latlng);
      	//wtf i cant load ltnlng in as variable or i get a blue screen
        var mapOptions = {
          center: myLatlng,
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP 
        };
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        
        var marker = new google.maps.Marker({
		    position: myLatlng,
		    title:"Hello World!"
		});
		marker.setMap(map);
      }
    </script>

<div id="map_canvas" style="width:100%; height:300px"></div>

<?php   } 

echo get_post_meta($post->ID, 'upload_image', true);

?>
<div class="description"><?php the_content(); ?></div>
<!--
<div class="link">url: <?php the_permalink(); ?></div>
-->

</div>	
<div id="viewer" class="viewer">
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
                  var iv1 = $("#viewer").iviewer({
                      src: "<?php echo get_post_meta($post->ID, 'single_photo', true); ?>",
                      update_on_resize: true,    
                      onMouseMove: function(coords) { },
                      onStartDrag: function(coords) { return true; }, //this image will not be dragged
                      onDrag: function(coords) { },
					  onFinishLoad: function()
	                    {
	                    $('.loader').fadeOut('200');	
						$("#viewer img").fadeIn(400);
	                    }
                  		});
                      
                           $("#in").click(function(){ iv1.iviewer('zoom_by', 1);}); 
                           $("#out").click(function(){ iv1.iviewer('zoom_by', -1); });  
						    $('.loader').fadeIn('200');
						
     //  $("#fit").click(function(){ object.fit();}); 
         //$("#orig").click(function(){  object.set_zoom(100); }); 
		 // console.log(this.img_object.display_width); //works*
				// console.log(object.img_object.display_width); //getting undefined.*
                   
        //      onFinishLoad: function()
                  //      {
			//	$("#viewer").data('viewer').setCoords(-500,-500);
                  //        this.setCoords(-0, -500);
                  //      }
//onMouseMove: function(object, coords) { },
//onStartDrag: function(object, coords) { return false; }, //this image will not be dragged
//onDrag: function(object, coords) { }
                 
            });
        </script>
        
</div> 
<?php get_footer(); ?>
