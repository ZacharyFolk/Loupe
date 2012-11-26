<?php
/**
 * Template Name: Home
 */
get_header(); ?>
<div id="tagThumbs"></div>
 
	<div class="lightTable">
		<div class="floater hometagged">						
			<ul id="thumbNav">
				<?php
					$args = array('post_type' => 'photo',
					'posts_per_page' => 50);									 
					$the_query = new WP_Query($args);
					while ($the_query->have_posts()) : $the_query->the_post();
					//$featured = get_post_meta($post->ID, 'isFeatured', true);
					//	if ( $featured  ) {
				?>
				<li class="homeThumbs">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=80&h=80&a=b&zc=1&q=80&s=1" alt="<?php the_title(); ?>" />
					</a>
				</li>
					<?php // } 
					endwhile; ?>
			</ul>
		</div> 
	</div> 
<?php get_footer(); ?>
<style type="text/css">
	#hoverPeek{
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
<script type="text/javascript">
	 
this.imagePreview = function(){	

	xOffset = 5;
	yOffset = 15;		
	var getHeight = $(document).height();
	//console.log(getHeight);
	var dim = document.body.getBoundingClientRect();
	var getWidth = dim.width;
	var getMid = (getHeight / 2);
	var midLow = getMid - 100;
	var midHigh = getMid + 100;
	var rc = (getWidth - 400); // right constraint
	var bc = (getHeight - 400); // bottom constraint
	//console.log(rightConstraint);	


	$(".homeThumbs a").hover(function(e){

			this.t = this.title;
			this.title = ""; // empty to prevent browser tooltip	
			var c = (this.t != "") ? "<br/>" + this.t : "";
			var s = $('img', this).attr('src');
		
			// split at /timthumb.php?src=
			var substr = s.split('=');
			var tt = substr[0];	// ../timthumb.php?src	
			var ss = substr[1].split('&'); 
			var srcImg = ss[0]; // the image path w/out params
			
			// todo ?  params could be populated from admin			
			var w = '200'; // width
			var h = '300'; // height
			var a = 'b'; //c, t, l, r, b, tl, tr, bl, br = crop alignment(center, top, left, right, bottom)
			var q = '80'; // quality : 0-100
			var zc = '0'; // zoom / crop : 0-3
			//var f = '' // filters 1-10 
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
			//$("body").append("<p id='hoverPeek'><img src='" + tt + "=" + srcImg + "&w=" + w + "&h=" + h + "&zc=" + zc + "&q=" + q + "' alt='Image preview' />"+ c +"</p>");								 
			// resource hog?
			//var s = $('img', this).attr('src', blur);
			
		$("body").append("<div id='hoverPeek'><img src='" + tt + "=" + srcImg + "&h=" + h + "&zc=" + zc + "&q=" + q + "' alt='Image preview' />"+ c +"</div>");
		
		// follow mouse and check for edges
			$(this).mousemove(function(e){
					var x = e.pageX;
					var y = e.pageY;
					var imgW = $('#hoverPeek img').width();
					// height is set in TT param
					// var imgH = $('#hoverPeek img').height();
					var imgM = h / 2;
					// check if too close to right edge, move img to left of cursor						
					if ( x > rc ){
						var xSpot = ( x - imgW ) - 50;
					} else {
					// default img to right of cursor
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
			//console.log('ySpot : ' + ySpot );
			});		

						
    },
	function(){
		this.title = this.t;	
		$("#hoverPeek").remove();
	// cool but resource hog ?
	//	var s = $('img', this).attr('src', s);
    });	
	
};

$(document).ready(function(){
	imagePreview();
	})
</script>