<?php
/**
 * @package WordPress
 * @subpackage Loupe
 * @since Loupe 0.1
 */
?>
</section><!-- #main -->

<?php include('rcMenu.php'); ?>
		<footer role="contentinfo">
			<a href="<?php echo home_url( '/' ) ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<a href="http://wordpress.org/" title="Semantic Personal Publishing Platform" rel="generator">Proudly powered by WordPress </a>
		</footer><!-- footer -->
		
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	wp_footer();
?>
	</body>
</html>

<!-- #main -->
<!--//
<?php if ( ! is_home()){ ?>
<div class="thumbBox" >
	<?php
		$thumbPosts = new WP_Query();
		$thumbPosts->query('showposts=55');
		while ($thumbPosts->have_posts()) : $thumbPosts->the_post(); ?>
		<a href="<?php the_permalink(); ?>">
		<img class="nofotomoto" src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_first_attachment() ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
		</a>
	<?php endwhile; ?>
</div>
<?php } ?>
-->
<!--//
	<?php if (! is_home()){ ?>
	 <div class="all">Show Recent Posts</div>
	<?php } ?>
-->
	<?php //if ( have_posts() ) while ( have_posts() ) : the_post();
	
//	wpfp_link();  ?> 
   
<?php // endwhile; // end of the loop. ?>
<!--//
<div class="fb"> 
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
</div>
//-->



<script type="text/javascript">

$(document).ready(function(){


	$('#content').bind('contextmenu',function(e){
		 //	e.preventDefault();
		 console.log('original click' + e.pageX + ', ' + e.pageY );
			var $cmenu = $(this).next();	
			console.log($cmenu);		
			$('<div class="rc_overlay"></div>').css({
				left : '0px', 
				top : '0px',
				position: 'absolute', 
				width: '100%', 
				height: '100%', 
				zIndex: '100' 
				})			
				.click(function() {				
					$(this).remove();
					$cmenu.hide();
					})
				.bind('contextmenu' , function(e){	
					if((".rc_overlay").length>0)
						{	
							$(this).remove();						
							$('.rcmenu').css({ left: e.pageX, top: e.pageY, zIndex: '101' });	
							return false;						
							};							
					})
					.appendTo(document.body);
					
				$(this).next().css({ left: e.pageX, top: e.pageY, zIndex: '101' }).fadeIn('1000'); 	
				return false;
				 });
				 
		 $('.rcmenu').draggable({ handle: "#handle", containment: "#viewer", 
		 stop: function(event,ui){
		 	var Stoppos=$(this).position();
		 	console.log('stop : ' + Stoppos.left + ',' + Stoppos.top );
		 	 }
		 	 });
 		 $('.rcClose').click(function(){
 		 	$('.rc_overlay').remove();
 		 	$('.rcmenu').fadeOut();
 		 	
 		 	});
			 /*
			  * //generic first menu events
			  $('.rcmenu .first_li').live('click',function() {
				if( $(this).children().size() == 1 ) {
					alert($(this).children().text());
					$('.rcmenu').hide();
					$('.overlay').hide();
				}
			 });
 */
			$('.rcZin').live('click',function() { iv1.iviewer('zoom_by', 1); });
			$('.rcZout').live('click',function() { iv1.iviewer('zoom_by', -1); });
			$('.rcZ100').live('click',function() { iv1.iviewer('fit'); });
			 
	
			 $('.rcmenu .inner_li span').live('click',function() {
					alert($(this).text());
					//$('.rcmenu').hide();
					//$('.overlay').hide();
			 });

	
	$('#viewMap').click(function(){
		if($('.mapContainer').css('display') == "none"){
			$('.mapContainer').slideDown('fast');
			  document.getElementById('map_canvas').style.display="block";
	          initialize();
	        $(this).html('Close Map -');
	        } else {
	        $('.mapContainer').slideUp('fast');
	        document.getElementById('map_canvas').style.display="none";
	         $(this).html('&nbsp;View Map + ');        
        	}
		});			

	});	//jQuery	
 
</script>

<script type="text/javascript">
// help on hold
/*
$(document).ready(function(){
	var body = $('body');
	// Go to a random post -> jQuery animated help using setTimout.  
	var imgCtrl = $( '#controls');
	var panel = $('.thumbBox');	
	var initialState = 'collapsed';
	var activeClass = 'active';
	var triangle = $('.tagLink span');
	var catTriangle = $('.galleryLink span');
	var infoTri = $('#infoLink span');	
	var tags = $('#tagList');
	var cats = $('#catList');	
	
	var tagButton = $('.tagLink');
	var catButton = $('.galleryLink');
	var tagImage = $('.tagImgBox a');
	var tagThumbs = $('#tagThumbs');

	var info = $('#infoPanel');	

	var infoButton = $('#infoLink');
	var main = $('#ajaxTable');
	var home = $('.floater');
	var homeTagBump = ( 'hometagged' );
	var tagBump = ('tagged');

	var catBump = ('catBump');	
	var activeTags = 'activeTagClass';
	
	var helper = {
	
	 h1 : function(){
		$('.lHelp').fadeIn('3000');
		$('.previous').fadeIn('5000');
	
	},
	
	 h2 : function(){	
		$('.rHelp').fadeIn('3000');
		$('.next').fadeIn('5000');
	},
	
	 h3 : function(){
	// categories "galleries"
		catTriangle.addClass( 'open' ).removeClass( 'close' );
		tags.addClass( 'catBumpOne' );
		$('.tagTable').addClass( 'catBumpTwo' );
	},
	
	 h4 : function(){
	// tags
		tags.show();
		$('.tagLink a').css('color','#FFFFFF');
		tagThumbs.show();
		info.addClass( tagBump );
		home.addClass( homeTagBump );
		triangle.removeClass( 'close' );
		triangle.addClass( 'open' );
		main.addClass( tagBump );
		console.log ('you did it!');
	},
	
	 h5 : function(){
	// zoom
	$('.zoom').css('color','#FFFFFF');
	iv1.iviewer('zoom_by', 1);
	console.log('that worked too!!');
	},
	
	 h6 : function(){
	// info
	},
	
	 h7 : function(){
	// the end
	}
	
	}
	
	// add the stop button

	 var stopHelp = function(){
		//undo everything I just did
		};
		
	$('#stopHelp').click(function(){
		stopHelp();
		});
	
	
	
$('#helper').click(function(){
	//$("#viewer").empty(); 
	// load random background
	// global $wpdb;
	// $random_photo = $wpdb->get_var("SELECT meta_value FROM wp_postmeta WHERE meta_key like 'single_photo' ORDER BY RAND()");

	// better, if on home  nav to random photo post, else just run it where they are at. if in blog, remove help link.
	setTimeout(helper.h1, 0 );
	setTimeout(helper.h4, 2000 );
	setTimeout(helper.h5,4000);
	$('#stopHelp').slideUp('2000');
	});
});
*/
</script>
<?php wp_footer(); ?>
</body>
</html>