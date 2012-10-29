<?php get_header(); ?>
<div id="tagThumbs"></div>
	<div class='loader'><img src='<?php bloginfo('template_url');?>/images/ajax-loader-001.gif'></div>
	<div class="tagTable" style="display:none">&nbsp;</div>
	<div id="ajaxTable">

<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>	
<div id="infoPanel" style="display:none">
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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=141020842607871";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<fb:like send="true" width="450" show_faces="false" font="tahoma" style="margin-top:10px"></fb:like>

<div class="theInfoTagList">
<?php $photoTxt = get_post_meta($post->ID, 'photowords', true); 
		if ($photoTxt){
			echo "<p>" . $photoTxt . "</p>";
		}
	?>

<?php the_tags('<ul id="infoTags" ><li>Tagged with : </li> <li>','</li><li>','</li></ul>'); ?>
<?php $camera = get_post_meta($post->ID, 'camera', true);
	if ($camera){
		echo "<p>Camera : " . $camera . "</p>";
	} 
?>
<?php $film = get_post_meta($post->ID, 'film', true);
	if ($film){
		echo "<p>Film : " . $film . "</p>";
	} 
?>

<?php 	echo get_the_category_list('Galleries:','','');  ?>
<ul id="infoTags">
	<li>Galleries :</li>
	<?php
		foreach((get_the_category()) as $category) {
			$category_id = get_cat_ID( $category->cat_name );
			$category_link = get_category_link( $category_id );
			echo '<li><a href="'.$category_link.'">'.$category->cat_name.'</a></li>';
	} ?>
</ul>


</div>
<?php 
$lat = get_post_meta($post->ID, 'latitude', true);
$long = get_post_meta($post->ID, 'longitude', true);
if ($lat !== '') {
 ?>	
 <div id="viewMap">&nbsp;View Map + </div>
 <script type="text/javascript"      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBw1DpJdlyFiMUhy9yu1zThIK9AFa5zGac&sensor=true">
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
<div class="mapContainer">
<div id="map_canvas" style="width:510px; height:300px"></div>
</div>
<?php   } 

echo get_post_meta($post->ID, 'upload_image', true);

?>
<div class="description"><?php the_content(); ?></div>
<!--
<div class="link">url: <?php the_permalink(); ?></div>
-->

</div>	

<div id="viewer" class="viewer">
<div class="previous">
	<div class="arrowL"></div>
</div>
<div class="next">
	<div class="arrowR"></div>
</div>
	<?php if ( get_post_meta($post->ID, 'story', true) ) : ?>
	
	     <?php echo get_post_meta($post->ID, 'story', true) ?>
	   
	<?php endif; 

	
	$PhotoName = the_title(); 

	$SourceFile = get_post_meta($post->ID, 'single_photo', true);
	$DestinationFile = '/home/adminwt/folkphotography.com/temp/watermarked/';
	$DestinationFile .= $PhotoName;
	$DestinationFile .= '.jpg';		
	$WaterMarkText = 'folkphotography.com';
	echo $DestinationFile;
	//watermarkImage ($SourceFile, $WaterMarkText, $DestinationFile);
	
	



	endwhile; else: ?>
	
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
      	
      	var randomimage = "<?php 
      	global $wpdb; 
		$random_photo = $wpdb->get_var("SELECT meta_value FROM wp_postmeta WHERE meta_key like 'single_photo' ORDER BY RAND()"); ?>";
		console.log(randomimage);      	
      	 navInit =  function(){
			 previous = '<?php custom_post_link( '%link','',TRUE, '', TRUE ); ?>';
			 next = '<?php custom_post_link( '%link','',TRUE, '', FALSE ); ?>';
			console.log ( previous + next );	
 	 };
      	<?php// if ($lat !== '') { ?>
    	//initialize();
    	<?php //} 
    	//moved initialize to .click(function)?>
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
