<?php
/**
 * Template Name: Home
 */
get_header(); ?>
<div id="results" style="display:none">
</div>

<div id="tagThumbs"></div>
	<div class="lightTable">
		<div class="floater hometagged">						
			<ul id="thumbNav">
				<?php
					$args = array(
					'post_type' => 'photo',
					'orderby' => 'rand',
					'posts_per_page' => -1); // display all	
													 
					$the_query = new WP_Query($args);
					while ($the_query->have_posts()) : $the_query->the_post();
					//$featured = get_post_meta($post->ID, 'isFeatured', true);
					//	if ( $featured  ) {
						
				?>
				
				<li class="homeThumbs">
					<a href="<?php the_permalink(); ?>"
						data-tags="<?php $posttags = get_the_tags();
if ($posttags) {
  foreach($posttags as $tag) {
    echo $tag->name . ' '; 
  }
} ?>"
						title="<?php the_title(); ?>">
					<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=80&h=80&a=b&zc=1&q=80&s=1" alt="<?php the_title(); ?>" />
					</a>
				</li>
					<?php // } 
					endwhile; ?>
			</ul>
		</div> 
	</div> 
	<style type="text/css">
		#hoverPeek{ /* this only works when inline ?! why cant this be part of stylesheet?? */
       position:absolute;
       border:3px solid #999;
       background:#fff;
       padding:25px 15px;
       display:none;
       color:#fff;
       -webkit-box-shadow: 0 12px 16px -6px black;
          -moz-box-shadow: 0 12px 16px -6px black;
               box-shadow: 0 12px 16px -6px black;
       }
	</style>
<?php get_footer(); ?>

<script type="text/javascript">
	var $ = jQuery; 
			function loadMain(img){      		
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
		$('.navTags').click(function(e){
			e.preventDefault();
			$(this).addClass('navActive');
			$('#theCloud').slideToggle('fast');
			
		});
		
		$('#theCloud a').on('click', function(e){
 		 	 e.preventDefault();
 		 	// TODO : DRY THIS UP!
 		 	var home = $('.lightTable');
 			var loader = $('#preLoader');
               $('li').removeClass('activeLink');
               $('a').removeClass('on');
               $(this).addClass('on');
               $(home).fadeOut('fast',function(){ 
 				$(loader).fadeIn(); 
 				});
 				if(!$('#viewer').html() == ''){
 					$('#viewer').empty().fadeOut('fast');
 				}
               var loadTags = this + ' #theThumbs'; 
               
                $('#results').load(loadTags, function(){
                       $(loader).fadeOut('fast',function(){
                            $('#results').fadeIn('fast', function(){
                            $('#theThumbs a').on('click', function(e){
 								e.preventDefault();
 					
 								var imgLink = $(this).attr('href'); 	
 								history.pushState(null,'title', imgLink);
 								var currUrl = location.href;	
 								$('#results').empty().fadeOut();
 								$(home).fadeOut('fast',function(){ 
 						 			$(loader).fadeIn(); 
 				 		// load all elements required from single-photo.php
 				 					$(this).after('<div id="singlePhotoMenu"></div>').after('<div id="viewer"></div>'); 
								});
								
								 		$('#results').load(currUrl + ' .imgContainer', function(){
 			var imgSrc = $('.imgContainer img').attr('src');		
 			//$('#content').load(imgLink + '  #viewer', function(){
 				$(loader).fadeOut('fast',function(){
 					loadMain(imgSrc);
 				});		
 			//});
 		});
 		
 							});
                		});
              		});
                            });     
				});



		$('#panelClose').click(function(){
			$('#theCloud').slideUp();
		})
		
    this.imagePreview = function(){	
	// off set pop-up from mouse location 
	xOffset = 5;
	yOffset = 15;		
	var getHeight = $(document).height();

	var dim = document.body.getBoundingClientRect();
	var getWidth = dim.width;
	var getMid = (getHeight / 2);
	var midLow = getMid - 100;
	var midHigh = getMid + 100;
	var rc = (getWidth - 400); // right constraint
	var tc = 400;
	var bc = (getHeight - 400); // bottom constraint
//	console.log('getHeight : ' + getHeight + ' \ngetWidth : ' + getWidth + '\ngetMid : ' + getMid + '\nmidLow : ' + midLow + '\nmidHigh : ' + midHigh + '\nrc : ' + rc + '\nbc : ' + bc );	

	$(".homeThumbs a").hover(function(e){
			 var tags = this.dataset.tags;
			 console.log(tags);
			this.t = this.title;

			this.title = ""; // empty to prevent browser tooltip	
			var c = (this.t != "") ? "<p class='perm'>" + this.t  + "</p><p>Tagged with : " + tags + "</p>" : "";
			var s = $('img', this).attr('src');
			// split at /timthumb.php?src=
			var substr = s.split('=');
			var tt = substr[0];	// ../timthumb.php?src	
			var ss = substr[1].split('&'); 
			var srcImg = ss[0]; // the image path w/out params
			
		 	//console.log('tt : ' + tt + '\nss : ' + ss + '\nsrcImg : ' + srcImg);
			// todo ?  params could be populated from admin			
			var w = '200'; // width
			var h = '200'; // height
			var a = 'c'; //c, t, l, r, b, tl, tr, bl, br = crop alignment(center, top, left, right, bottom)
			var q = '80'; // quality : 0-100
			var zc = '1'; // zoom / crop : 0-3
			// var f = '' // filters 1-10 
			// 1 : Invert
			// 2 : Grayscale
			// 3,arg(+/-0) : Brightness
			// 4, arg(+/-0) : Contrast
			// 5, arg(RGBA) : Colorize / Tint
			// 6 : Edge Detect
			// 7 : Emboss
			// 8 : Gaussian Blur
			// 9 : Selective Blur
			// 10 : Sketchy
			// 11 : Smooth
			var cc = '#ffffff' // Canvas Color
			//var ct = 'true(1)' // Canvas Transparency
			// to add a filter : 
			// var blur = s + "&f=8";
			// remove all cropping 
			//$("body").append("<p id='hoverPeek'><img src='" + tt + "=" + srcImg + "&w=" + w + "&h=" + h + "&zc=" + zc + "&f=" + f + "&q=" + q + "' alt='Image preview' />"+ c +"</p>");								 
			// resource hog?
			//var s = $('img', this).attr('src', blur);
		$("body").append("<div id='hoverPeek'>loading...</div>");	
		$("#hoverPeek").html("<img src='" + tt + "=" + srcImg + "&h=" + h  + "&w=" + w + "&zc=" + zc + "&q=" + q + "' alt='Image preview' />"+ c );
		
		// follow mouse and check for edges
			$(this).mousemove(function(e){
					var x = e.pageX;
					var y = e.pageY;
					//var imgW = $('#hoverPeek img').width();
					var imgW = w;
				// console.log ('imgW : ' + imgW );
					// height is set in TT param
					// var imgH = $('#hoverPeek img').height();
					var imgM = h / 2;
					// check if too close to right edge, move img to left of cursor		
				//	console.log( 'rc : ' + rc);				
					if ( x > rc ){
						var xSpot = ( x - imgW ) - 50;
					} else if ( x === rc){
					    var xSpot = ( x + yOffset );
					} else if ( x < rc ){
					//  img to right of cursor
						var xSpot = ( x + yOffset );
					}
					// check if mouse has entered middle of browser height
					if (( y >= midLow && y <= midHigh ) && !( y > bc )){						
						var ySpot = ( y - imgM );						
					}
					// check if too close to bottom, move img to top of cursor if true
					if ( y > bc )  {
						var ySpot =( y - h ) - 50;

					} else {
						var ySpot = ( y - xOffset );
					}
			 $("#hoverPeek").css("top", ySpot + "px").css("left", xSpot + "px").fadeIn("fast");
			// console.log('ySpot : ' + ySpot + '\nxSpot : ' + xSpot);
			 
			 
			 });		

						
    },
	function(){
		this.title = this.t;	
		$("#hoverPeek").remove();
	// cool but resource hog ?
	//	var s = $('img', this).attr('src', s);
		
    }).click(function(e){
 		e.preventDefault();
 		var home = $('.lightTable');
 		var loader = $('#preLoader');
 		$("#hoverPeek").remove();
 		var imgLink = $(this).attr('href'); 	
 		history.pushState(null,'title', imgLink);
 		var currUrl = location.href;	
 			$(home).fadeOut('fast',function(){ 
 				 $(loader).fadeIn(); 
 				 // load all elements required from single-photo.php
 				 $(this).after('<div id="singlePhotoMenu"></div>').after('<div id="viewer"></div>'); 
 				 
 			});
 		$('#results').load(currUrl + ' .imgContainer', function(){
 			var imgSrc = $('.imgContainer img').attr('src');		
 			//$('#content').load(imgLink + '  #viewer', function(){
 				$(loader).fadeOut('fast',function(){
 					loadMain(imgSrc);
 				});		
 			//});
 		});
		// load image controls
 		$('#ctrlPanel').load(imgLink + ' #imageCtrl', function(){
 			// load info panel
 			$('#singlePhotoMenu').load(imgLink +' #singlePhotoMenuContainer');
 			$('.more_info').click(function(){
 				$(this).parent('li').addClass('ON');
 				$('#photoMeta').slideDown('fast');
 				
 			})
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
 		});
 		
 		

 		console.log(imgLink);   	
    });	

    

      
    function getCentered() {       
		  iv1.iviewer('fit'); 
		};
		
		// slight delay for UI responsiveness
		var resizeTimer;
		$(window).resize(function() {
    		clearTimeout(resizeTimer);
    		resizeTimer = setTimeout(getCentered, 100);    		
		});
};

$(document).ready(function(){
	var baseUrl = '<?php bloginfo('url'); ?>/';
	//better ? http://html5doctor.com/history-api/
	window.onpopstate = function(event){
		 currUrl = location.href;
		if (currUrl == baseUrl){
			loadHome();
		} else {
		console.log('woot');
		}
	
		console.log("location: " + document.location + ", state: " + JSON.stringify(event.state));
		console.log('curr : ' + currUrl + ' base : ' + baseUrl);
		console.log(typeof(currUrl));
		console.log(typeof(baseUrl));
	};
	imagePreview();
});

    function loadHome(){
    	$('#viewer').fadeOut('fast',function(){
    		$(this).empty();
    		$('.lightTable').fadeIn('fast');
    	});
    	
    };
    
    // TODO :  Module pattern http://www.theroadtosiliconvalley.com/technology/javascript-module-pattern/
</script>
