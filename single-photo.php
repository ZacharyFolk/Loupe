<?php get_header(); ?>
<?php if ( have_posts() ) :  while ( have_posts() ) : the_post();
    $loc =  get_post_meta($post->ID, 'location', true);
    $lat = get_post_meta($post->ID, 'latitude', true);
    $long = get_post_meta($post->ID, 'longitude', true);
     ?>	
	<!-- //
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
//-->
<?php
	echo '<div id="theCloud" class="folk">';
    $arr = wp_tag_cloud(array(
    	'smallest' => 8,
    	'largest' => 34,
    	'unit' => 'px',
    	'number' => 50,
    	'format' => 'array', // flat, list, or array
    	'separator'          => '',         
    	'orderby' => 'name', // count
    	'link' => 'view',
    	'topic_count_text_callback' => tag_count_text,
    	'taxonomy' => 'post_tag',
    	'echo' => true, // set to false to return an array
    	'order' => 'RAND',// starting from A, or starting from highest count
    	'exclude' => '',  // ID's of tags to exclude, displays all except these
    	'include' => '',  // ID's of tags to include, displays none except these
    	'link' => 'view', // view = links to tag view; edit = link to edit tag
    	'taxonomy' => 'post_tag',  // post_tag, link_category, category
    	'echo'=> true   // set to false to return an array, not echo it
    	));
	foreach ($arr as $value) {
		// this cleans up the weird font sizes
					$ptr1 = strpos($value,'font-size:');
					$ptr2 = strpos($value,'px');
					$px = round(substr($value,$ptr1+10,$ptr2-$ptr1-10));
					$value = substr($value, 0, $ptr1+10) . $px . substr($value, $ptr2);
					$ptr1 = strpos($value, "class=");
					$value = substr($value, 0, $ptr1+7) . 'color-' . $px . ' ' . substr($value, $ptr1+7);
				echo ' ' . $value . ' ';
			}
echo '</div>';
?>
<div id="panelClose">CLOSE (X)</div>
<div id="map"></div>
<div id="ctrlPanel">
	<ul id="imageCtrl">
		<?php
$prev_post = get_previous_post();
$next_post = get_next_post();
if (!empty( $prev_post )): ?>
  <li><a href="<?php echo get_permalink( $prev_post->ID ); ?>" class="previous" title="<?php echo $prev_post->post_title; ?>"></a></li>
<?php endif; ?>
		<li><a href="#" class="zoom_out"></a></li>
		<li><a href="#" class="zoom_in"></a></li>
		<li><a href="#" class="more_info"></a></li></li>
		<li><a href="<?php echo get_permalink( $next_post->ID ); ?>" class="next" title="<?php echo $prev_post->post->post_title; ?>"></a></li>
	</ul>
	<ul id="mapCtrl">
		<li>[X] CLOSE MAP</li>
	</ul>
</div>
<div class="imgContainer" style="display:none">
	<img src="<?php echo get_post_meta($post->ID, 'single_photo', true); ?>" />
</div>	
<div id="viewer">

<!-- load image for those with js disabled -- move to the footer? -->
	<noscript>
    	<style type="text/css">
    	#controls{display:none}
    	#viewer img {width: 800px}
    	.imgContainer{margin: 0 auto; width: 800px}
    	</style>
    	<div class="imgContainer">
    		<img src="<?php echo get_post_meta($post->ID, 'single_photo', true); ?>" />
    	</div>
	</noscript>

<script type="text/javascript">
    var $ = jQuery;
    var imgsrc = "<?php echo get_post_meta($post->ID, 'single_photo', true); ?>";
    var $Xmap = $('#mapCtrl').hide();
    	$(document).ready(function(){
    		loadMain(imgsrc);
    		// hide stuff
    		$Xmap.hide();
    	});
    	
      	var loadMain = function(img){      		
      		iv1 = $("#viewer").iviewer({
	        src: img,
	        update_on_resize: true,
	   		zoom_delta: 1.2,
	        onFinishLoad: function()
			    {
				    $('.loader').fadeOut('200');	
				    iv1.iviewer('zoom_by',-1);  // because of drop shadow
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
        /*
        function openImageControls(){
        	$('#ctrlPanel').animate({ marginTop: '35px'});	
        };
        
        function closeImageControls(){
        	$('#ctrlPanel').stop().animate({ marginTop: '0px'});
        };
        
        var ctrlTimer;
        var galleryLI = $('#imageCtrl li');
    
        $('#ctrlPanel')
        	.hover(function(){
        		clearTimeout($(this).data('timeout'));
        		$(this).stop().animate({ marginTop: '35px'}, 'fast');	
	        	}, function(){
	             var t = setTimeout(function(){
		            $('#ctrlPanel').stop().animate({ marginTop: '0px'}, 'fast');	
        		}, 400);
        		$(this).data('timeout',t);
        		});  		   
        */
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
		
	var singleGetThumbs = function(c, o, t){
			console.log("singleGetThumbs(" + c + "," + o + "," + t +");");
			var div = c;
			var link = o;
			var par = $(link).parent();
			$(par).addClass('activeLink').siblings().removeClass('activeLink');
			console.log('c: ' + c + ' o: ' + o + ' t: ' + t + ' par: ' + par);
			//var linkName = link.id;
			var path = link.href;
			var loadIt = path + ' ' + t;
			var kids = $(div).children('div');
			var preview = kids[0];
			var pre  = $(preview).children('div');
			var preload = pre[0];
			var target = pre[1];
			console.log('kids: ' + kids + ' preview: ' + preview + ' pre: ' + pre + ' target: ' + target);
			$(target).hide();
			$(preload).fadeIn('slow', function(){	
				$(target).load(loadIt,function(){
						$(pre).hide('fast', function(){
							$(target).show();
								});
							});		
					});
				};
				
		var thumbsOnLoad = function(){		    
			var tagLink = $('li.tagNames a').first();
			var tagLink = tagLink[0];
            if(tagLink){
                singleGetThumbs('.meta_tags', tagLink , '#theThumbs');
		          }
		      }
		$(document).ready(function(){ 
        
		//thumbsOnLoad();	
		
		$('.navTags').click(function(){
			$(this).addClass('navActive');
			$('#theCloud').slideToggle('fast');
			
		});
		
		$('#panelClose').click(function(){
			$('#theCloud').slideUp();
		})
		 $('#theCloud a').click(function(e){
               e.preventDefault();
               $('li').removeClass('activeLink');
               $('a').removeClass('on');
               $(this).addClass('on');
               var loadTags = this + ' #theThumbs';              
               $('.tagImageDiv').hide();
               $('.tagPreload').fadeIn('slow', function(){  
                $('.tagImageDiv').load(loadTags, function(){
                        $('.tagPreload').hide('fast', function(){
                            $('.tagImageDiv').show();
                                });
                            });     
                    });
                });
                
          $('a.mapLink').click(function(e){
              e.preventDefault();              
              initLoader();
              // weird bug where google maps will not fill width until loaded a second time
              initLoader();
          });


         });	
         
         function slowZoom(num, z){
            for(var i=0;i<num;i++){
                 iv1.iviewer('zoom_by', z);
             }
         }
         
         function mapsLoaded() {
              <?php if($lat) {?>
              var map = new google.maps.Map2(document.getElementById("map"));
              map.setCenter(new google.maps.LatLng(<?php echo $lat . ',' . $long; ?> ), 13);
              var vw = $('#viewer').width();
              var vw = vw - 5; // because of box shadow
              var vh = $('#viewer').height();
             // console.log('vw : ' + vw + 'vh : ' + vh);
              slowZoom(2,1);
              $('#map').fadeIn();
              $('#map').css('width', vw).css('height',vh);
              $('#imageCtrl').hide();
              $Xmap.show();
              closeMap();	
              <?php } ?>
            }

           function loadMaps() {
              google.load("maps", "2", {"callback" : mapsLoaded});
                
            }

           
           function initLoader() {
              var script = document.createElement("script");
              script.src = "https://www.google.com/jsapi?callback=loadMaps";
              script.type = "text/javascript";
              document.getElementsByTagName("head")[0].appendChild(script);
            }
            
            function closeMap(){
            	$Xmap.click(function(){
            		$(this).hide();
            		slowZoom(2,-1);
            		$('#map').fadeOut();
            		$('#imageCtrl').show();
            	});
            }
            
            $("#map").hover(function() {
		       $(this).stop().animate({ opacity: 1 });
		    },function() {
		       $(this).stop().animate({ opacity: 0.7 });
		    });
   </script>
   
      <!--//  
<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/backStretch.js"></script> 
	//-->

</div>      

<div id="singlePhotoMenu">
    <div id="singlePhotoMenuContainer">
	<h2 class="perm"><?php the_title();  edit_post_link('edit', '<span class="editLink">', '</span>'); ?></h2>

	<div id="photoMeta">
<?php	
	$photoTxt = get_post_meta($post->ID, 'photowords', true); 
		if ($photoTxt){
			echo "<p>" . $photoTxt . "</p>";
        }
?>
<!-- // Template for Paypal ///
<form target="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="business" value="YPDZCGDZ4CF6S">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Prints">
<input type="hidden" name="button_subtype" value="products">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="cn" value="Add special instructions to the seller:">
<input type="hidden" name="no_shipping" value="2">
<input type="hidden" name="rm" value="1">
<input type="hidden" name="return" value="http://www.thanksforbuyingstuff.com">
<input type="hidden" name="cancel_return" value="http://www.thanksanyways.com">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="tax_rate" value="9.000">
<input type="hidden" name="weight" value="1">
<input type="hidden" name="weight_unit" value="lbs">
<input type="hidden" name="add" value="1">
<input type="hidden" name="bn" value="PP-ShopCartBF:btn_cart_SM.gif:NonHosted">
<table>
<tr><td><input type="hidden" name="on0" value="SIzes">SIzes</td></tr><tr><td><select name="os0">
    <option value="8 x 12">8 x 12 $65.00 USD</option>
    <option value="11 x 14">11 x 14 $80.00 USD</option>
    <option value="16 x 20">16 x 20 $140.00 USD</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="option_select0" value="8 x 12">
<input type="hidden" name="option_amount0" value="65.00">
<input type="hidden" name="option_select1" value="11 x 14">
<input type="hidden" name="option_amount1" value="80.00">
<input type="hidden" name="option_select2" value="16 x 20">
<input type="hidden" name="option_amount2" value="140.00">
<input type="hidden" name="option_index" value="0">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_cart_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
-->
    <?php
    	
	$cam = get_the_terms($post->ID, 'camera');
			if($cam){
				echo '<div class="meta_cam"><ul class="gandhiR"><li>Camera : </li>';
				foreach ($cam as $camindex => $camitem):
					echo '<li class="camera"><a href="/camera/' . $camitem->name . '/"  onclick="singleGetThumbs(\'.meta_cam\', this, \'#theThumbs\'); return false;" id="' . $camitem->name . '">' . $camitem->name . '</a></li>';
				endforeach;
				echo '</ul>';
				echo '<div class="preview"><div class="camPreload"></div><div class="tagImageDiv"></div></div>';
			}	
/* Just tags for now… 
			$cats = get_the_terms($post->ID, 'gallery');
			if($cats){
				echo '<div class="meta_cat"><ul class="folk"><li>Posted in: </li>';
				foreach ($cats as $catindex => $catitem):
					echo '<li class="galleryNames"><a href="/gallery/' . $catitem->name . '/" onclick="singleGetThumbs(\'.meta_cat\', this, \'#theThumbs\'); return false;" id="' . $catitem->name . '">' . $catitem->name . '</a></li>';
				endforeach;
				echo '</ul>';
				echo '<div class="catPreload"></div><div class="catImageDiv"></div></div>';
			}		
		*/			
			$posttags = get_the_tags();
			if ($posttags) {
				echo '<div class="meta_tags"><ul class="gandhiR"><li>Tagged with: </li>';		
			  foreach($posttags as $tag):
				  $tagName = $tag->name;
				  $tagNameUrl= str_replace(" ", "-", $tagName );	  
					echo '<li class="tagNames"><a href="' . get_bloginfo('url') . '/tag/' . $tagNameUrl . '/" onclick="singleGetThumbs(\'.meta_tags\', this, \'#theThumbs\'); return false;">' . $tagName . '</a></li>';
			  endforeach;
			  	echo '</ul>';
			  	echo '<div class="preview"><div class="tagPreload"></div><div class="tagImageDiv"></div></div>';
			}



    if ($loc !== '') {
        
        $lat_long = $lat . ',' . $long;
        $mapImgSrc = "http://maps.googleapis.com/maps/api/staticmap?center=" . $lat_long . "&zoom=13&size=640x640&maptype=satellite&sensor=false";
        $mapImgSrcx2 = "http://maps.googleapis.com/maps/api/staticmap?center=" . $lat_long . "&zoom=13&size=640x640&maptype=satellite&sensor=false&scale=2";
        $mapGoogleLink = "http://maps.google.com/?ie=UTF&hq=&ll=" . $lat_long . "&z=14&output=embed";
       // echo "<a href='". $mapGoogleLink . "' class='mapLink cbFull' target='_blank' onclick='openModal(this); return false;'><img src='" . $mapImgSrc . "' /></a>";
       echo "<div class='location_container'><h3 class='location'>Location : <a href='#' class='mapLink cbFull' target='_blank'>" . $loc . "</a></h3></div>"; 
      // echo "<a href='#' class='mapLink cbFull' target='_blank'><img src='" . $mapImgSrc . "' /></a>";
        // inline style is for responsive size on map image could do this with js instead?
          ?>     
       
        <?php   } // end map ?>  
	</div>
	<?php endwhile; 
	else: ?>	
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
            </div>
        </div>

<?php get_footer(); ?>
