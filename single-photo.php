<?php get_header(); ?>
<?php if ( have_posts() ) :  while ( have_posts() ) : the_post(); ?>	
		<script src="<?php bloginfo( 'template_directory' ); ?>/scripts/jquery.paginate.js" type="text/javascript"></script>
<div id="infoPanel" style="display:none">
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=141020842607871";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<fb:like send="true" width="450" show_faces="false" font="tahoma" style="margin-top:10px"></fb:like>
<div class="description"><?php the_content(); ?></div>

</div>	

	<ul id="image_controls">
		<li><a href="#" class="previous"></a></li>
		<li><a href="#" class="zoom_in"></a></li>
		<li><a href="#" class="zoom_out"></a></li>
		<li><a href="#" class="next"></a></li>
		<li></li>
	</ul>
	
	<div id="viewer">
<!-- load image for those with js disabled -- move to the footer? -->
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
    var imgsrc = "<?php echo get_post_meta($post->ID, 'single_photo', true); ?>";
    // TODO: figure how to pass the source and this can be moved into a .js file
    	$(document).ready(function(){
    		loadMain(imgsrc);
    	});
    	
      	var loadMain = function(img){
      		
      	iv1 = $("#viewer").iviewer({
        src: img,
        update_on_resize: true,
   		zoom_delta: 1.2,
        onFinishLoad: function()
		    {
			    $('.loader').fadeOut('200');	
			    iv1.iviewer('zoom_by',-1);  // because drop shadow being cutoff in overflow
				$("#viewer img").fadeIn(400);
		    }
      	 	});
        };
                      
        $("#in").click(function(){ iv1.iviewer('zoom_by', 1);}); 
        $("#out").click(function(){ iv1.iviewer('zoom_by', -1); });  
		$('.loader').fadeIn('200');  				
				   
       
        $('.previous').click(function(e){
        
        });
        $('.zoom_in').click(function(e){
         iv1.iviewer('zoom_by', 2);
        });
        $('.zoom_out').click(function(e){
         iv1.iviewer('zoom_by', -2);
        });
        function openImageControls(){
        	$('#image_controls').animate({ marginTop: '35px'});	
        };
        
        function closeImageControls(){
        	$('#image_controls').stop().animate({ marginTop: '0px'});
        };
        
        var ctrlTimer;
        var galleryLI = $('#image_controls li');
    
        $('#image_controls')
        	.hover(function(){
        		clearTimeout($(this).data('timeout'));
        		$(this).stop().animate({ marginTop: '35px'}, 'fast');	
	        	}, function(){
	             var t = setTimeout(function(){
		            $('#image_controls').stop().animate({ marginTop: '0px'}, 'fast');	
        		}, 400);
        		$(this).data('timeout',t);
        		});  		   
        
        // move image if browser is resized
        function getCentered() {       
		  iv1.iviewer('fit'); 
		};
		
		// slight delay for UI responsiveness
		var resizeTimer;
		$(window).resize(function() {
    		clearTimeout(resizeTimer);
    		resizeTimer = setTimeout(getCentered, 100);    		
		});
		
	var singleGetThumbs = function(c, o , t){
			var div = c;
			var link = o;
			var linkName = link.id;
			var path = link.href;
			var loadIt = path + ' ' + t;
			var kids = $(div).children('div');
			var pre = kids[0];
			var target = kids[1];

			$(target).empty();
			$(pre).fadeIn('slow', function(){	
				$(target).load(loadIt,function(){
						$(pre).hide('slow', function(){
							$(target).fadeIn('fast');
								});
							});		
					});
				};
	// TODO : Add a timeout to make transitions smoother
	
var modalWindow = {
	parent:"body",
	windowId:null,
	content:null,
	width:null,
	height:null,
	close:function()
	{
		$(".modal-window").remove();
		$(".modal-overlay").remove();
	},
	open:function()
	{
		var modal = "";
		modal += "<div class=\"modal-overlay\"></div>";
		modal += "<div id=\"" + this.windowId + "\" class=\"modal-window\" style=\"width:" + this.width + "px; height:" + this.height + "px; margin-top:-" + (this.height / 2) + "px; margin-left:-" + (this.width / 2) + "px;\">";
		modal += this.content;
		modal += "</div>";	

		$(this.parent).append(modal);

		$(".modal-window").append("<a class=\"close-window\"></a>");
		$(".close-window").click(function(){modalWindow.close();});
		$(".modal-overlay").click(function(){modalWindow.close();});
	}
};

var opemModal = function(source)
{
	modalWindow.windowId = "myModal";
	modalWindow.width = "80%";
	modalWindow.height = "80%";
	modalWindow.content = "<iframe width='80%' height='80%' frameborder='0' scrolling='no' allowtransparency='true' src='" + source + "'></iframe>";  
    modalWindow.open();  
}
        </script>
	</div>      

<div id="singlePhotoMenu">
	<h2 class="perm"><?php the_title(); ?></h2>
	<div id="photoMeta">
<?php	
	$photoTxt = get_post_meta($post->ID, 'photowords', true); 
		if ($photoTxt){
			echo "<p>" . $photoTxt . "</p>";
		}
		
			$cam = get_the_terms($post->ID, 'camera');
			if($cam){
				echo '<div class="meta_cam"><ul class="folk"><li>Shot with a </li>';
				foreach ($cam as $camindex => $camitem):
					echo '<li class="camera"><a href="/camera/' . $camitem->name . '/"  onclick="singleGetThumbs(\'.meta_cam\', this, \'#theThumbs\'); return false;" id="' . $camitem->name . '">' . $camitem->name . '</a></li>';
				endforeach;
				echo '</ul>';
				echo '<div class="camPreload"></div><div class="camImageDiv"></div></div>';
			}	

			$cats = get_the_terms($post->ID, 'gallery');
			if($cats){
				echo '<div class="meta_cat"><ul class="folk"><li>Posted in: </li>';
				foreach ($cats as $catindex => $catitem):
					echo '<li class="galleryNames"><a href="/gallery/' . $catitem->name . '/" onclick="singleGetThumbs(\'.meta_cat\', this, \'#theThumbs\'); return false;" id="' . $catitem->name . '">' . $catitem->name . '</a></li>';
				endforeach;
				echo '</ul>';
				echo '<div class="catPreload"></div><div class="catImageDiv"></div></div>';
			}		
					
			$posttags = get_the_tags();
			if ($posttags) {
				echo '<div class="meta_tags"><ul class="folk"><li>Tagged with: </li>';		
			  foreach($posttags as $tag):
				  $tagName = $tag->name;
				  $tagNameUrl= str_replace(" ", "-", $tagName );	  
					echo '<li class="tagNames"><a href="/tag/' . $tagNameUrl . '/" onclick="singleGetThumbs(\'.meta_tags\', this, \'#theThumbs\'); return false;">' . $tagName . '</a></li>';
			  endforeach;
			  	echo '</ul>';
			  	echo '<div class="tagPreload"></div><div class="tagImageDiv"></div></div>';
			}

	$lat = get_post_meta($post->ID, 'latitude', true);
	$long = get_post_meta($post->ID, 'longitude', true);
	if ($lat !== '') { 
		$lat_long = $lat . ',' . $long;
		$mapImgSrc = "http://maps.googleapis.com/maps/api/staticmap?center=" . $lat_long . "&zoom=13&size=640x640&maptype=satellite&sensor=false";
		$mapImgSrcx2 = "http://maps.googleapis.com/maps/api/staticmap?center=" . $lat_long . "&zoom=13&size=640x640&maptype=satellite&sensor=false&scale=2";
		$mapGoogleLink = "http://maps.google.com/?ie=UTF&hq=&ll=" . $lat_long . "&z=14&output=embed";
		echo "<a href='". $mapGoogleLink . "' class='mapLink cbFull' target='_blank' onclick='openModal(this); return false;'><img src='" . $mapImgSrc . "' /></a>";
		echo "<a href='". $mapGoogleLink . "' class='cbFull'>View Map</a>"	
// inline style is for responsive size on map image
?>	
<style type="text/css">
	.mapLink { background-image: url(<?php echo $mapImgSrc; ?>);}
	/* for retina display 2x scale */
	@media only screen and (min--moz-device-pixel-ratio: 2),
		only screen and (-o-min-device-pixel-ration: 2/1),
		only screen and (-webkit-min-device-pixel-ratio: 2),
		only screen and (min-device-pixel-ratio: 2) {
			.mapLink{
				 background-image: url(<?php echo $mapImgSrcx2; ?>);
				 background-size: 640px 640px;
			}
		}
</style>
<?php } // end map ?>
	</div>
	<?php endwhile; 
	else: ?>	
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div>

<?php get_footer(); ?>
