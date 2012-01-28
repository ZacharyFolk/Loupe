<?php get_header(); ?>
<?php // watermark
	/*
	$SourceFile = get_post_meta($post->ID, 'single_photo', true);
	$DestinationFile = '/home/adminwt/folkphotography.com/temp/photo_wm.jpg';		
	$WaterMarkText = ' - Zachary Folk';
	
	watermarkImage ($SourceFile, $WaterMarkText, $DestinationFile);
	
	function watermarkImage ($SourceFile, $WaterMarkText, $DestinationFile) {
		   list($width, $height) = getimagesize($SourceFile);
		   $image_p = imagecreatetruecolor($width, $height);
		   $image = imagecreatefromjpeg($SourceFile);
		   imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
		   $black = imagecolorallocate($image_p, 0, 0, 0);
		   $font = '/home/adminwt/folkphotography.com/wp-content/themes/Loupe/fonts/SpecialElite.ttf';
		   
		   if ( $width > 600 ) { 
		   		$font_size = 20;
		   }
		   if ( $width < 600 ) { 
		   		$font_size = 10;
		   }
		   $pos_w = $width - 100;
		   $pos_h = $height - 50;
		   imagettftext($image_p, $font_size, 0, 100, $pos_h, $black, $font, $WaterMarkText);
			   if ($DestinationFile<>'') {
			      imagejpeg ($image_p, $DestinationFile, 100);
			   } else {
			      header('Content-Type: image/jpeg');
			      imagejpeg($image_p, null, 100);
			   };
		   imagedestroy($image);
		   imagedestroy($image_p);
		};
		
		function colorPalette($imageFile, $numColors, $granularity = 5) 
		{ 
		   $granularity = max(1, abs((int)$granularity)); 
		   $colors = array(); 
		   $size = @getimagesize($imageFile); 
		   if($size === false) 
		   { 
		      user_error("Unable to get image size data"); 
		      return false; 
		   } 
		   $img = @imagecreatefromjpeg($imageFile); 
		   if(!$img) 
		   { 
		      user_error("Unable to open image file"); 
		      return false; 
		   } 
		   for($x = 0; $x < $size[0]; $x += $granularity) 
		   { 
		      for($y = 0; $y < $size[1]; $y += $granularity) 
		      { 
		         $thisColor = imagecolorat($img, $x, $y); 
		         $rgb = imagecolorsforindex($img, $thisColor); 
		         $red = round(round(($rgb['red'] / 0x33)) * 0x33); 
		         $green = round(round(($rgb['green'] / 0x33)) * 0x33); 
		         $blue = round(round(($rgb['blue'] / 0x33)) * 0x33); 
		         $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue); 
		         if(array_key_exists($thisRGB, $colors)) 
		         { 
		            $colors[$thisRGB]++; 
		         } 
		         else 
		         { 
		            $colors[$thisRGB] = 1; 
		         } 
		      } 
		   } 
		   arsort($colors); 
		   return array_slice(array_keys($colors), 0, $numColors); 
		} 

*/
?>
<div id="tagThumbs"></div>
	<div class='loader'><img src='<?php bloginfo('template_url');?>/images/ajax-loader-000.gif'></div>
	<div class="tagTable" style="display:none">&nbsp;</div>
	<div id="ajaxTable">

<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>	
<div id="infoPanel">
<div class="title"><?php the_title(); 
//test color palette
/*
print_r($colors);
$palette = colorPalette($SourceFile, 10, 4); 
echo "<table>\n"; 
foreach($palette as $color) 
{ 
   echo "<tr><td style='background-color:#$color;width:2em;'>&nbsp;</td><td>#$color</td></tr>\n"; 
} 
echo "</table>\n";
*/
?></div>
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
     // 	initialize();
	//	var colors = $.cookie('colors');
                  	  iv1 = $("#viewer").iviewer({
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
<?php include('rcMenu.php'); ?>
<?php get_footer(); ?>
