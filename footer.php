<?php
/**
 * @package WordPress
 * @subpackage Loupe
 * @since Loupe 0.1
 */
?>
</div><!-- #main -->
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
	<div id="footer" role="contentinfo">
		
						<?php edit_post_link('edit', '<p class="editLink">', '</p>'); ?>
				
		<p>
		&copy; <?php echo date("Y"); ?> Zachary Folk Photography | <a href="http://wordpress.org/" title="Semantic Personal Publishing Platform" rel="generator">Proudly powered by WordPress </a> and the Loupe 
		</p>
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

	</div><!-- #footer -->

</div><!-- #wrapper -->
    </div>
  </div>
</div>

<script type="text/javascript">
var $ = jQuery;

$(document).ready(function(){
	var imgCtrl = $( '#controls');
	var panel = $('.thumbBox');	
	var initialState = 'collapsed';
	var activeClass = 'active';
	var triangle = $('.tagLink span');
	var catTriangle = $('.galleryLink span');
	var infoTri = $('#infoLink span');	
	var tags = $('#tagList');
	var cats = $('#catList');	
	var tagPanelState = $.cookie('tagPanel');
	var tagPanelHistory = $.cookie('lastTag');
	var catPanelState = $.cookie('catPanel');
	var tagButton = $('.tagLink');
	var catButton = $('.galleryLink');
	var tagImage = $('.tagImgBox a');
	var tagThumbs = $('#tagThumbs');
	var tagThumbState = $.cookie('tagThumbPanel');
	var info = $('#infoPanel');	
	var infoPanelState = $.cookie('infoPanel');
	var infoButton = $('#infoLink');
	var main = $('#ajaxTable');
	var home = $('.floater');
	// bumps depending on what is open in menu
	var homeTagBump = ( 'hometagged' );
	var tagBump = ('tagged');

	var catBump = ('catBump');	
	var activeTags = 'activeTagClass';
	<?php $id = $_GET['tagP']; ?>
	var tagParam = '<?php echo $id; ?>';
	var state = $.cookie('panelState');

	if($.cookie('panelState') == undefined) {
		$.cookie('panelState', initialState);
		}

	// panel hid with margin because bug with google maps not properly rendering in hidden div
	//info.addClass ('infoClose');
	
<?php if (is_single()) { ?>
	navInit();
	
	var getHeight = $(document).height();
	//console.log(getHeight);
	var getWidth = $(document).width();
	//console.log(getWidth);
	
	var rightConstraint = ( getWidth - 50 );
	//console.log(rightConstraint);	
	$(document).mousemove(function(e){
	//	console.log(e.pageX +', ' + e.pageY);
		
		if (e.pageX < 50){
		//console.log('leftin');
			if(previous){
		$('.previous').fadeIn();
		
			$('.previous').click(function(){
				window.location = previous;
				});
			}
			} else if (( e.pageX > 50) && (e.pageX < rightConstraint)) {
				$('.previous, .next').fadeOut();
			//console.log('leftout');
			} else if ( e.pageX > rightConstraint ){
				if(next){
				$('.next').fadeIn();
				$('.next').click(function(){
				window.location = next;
				});
				}
			//	console.log('rightin');
			}
	});
<? } ?>
	$('.viewer').bind('contextmenu',function(e){
		 //	e.preventDefault();
		 console.log('original click' + e.pageX + ', ' + e.pageY );
			var $cmenu = $(this).next();			
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
 
 
			$(".first_li , .sec_li, .inner_li span").hover(function () {
				$(this).css({backgroundColor : '#E0EDFE' , cursor : 'pointer'});
			if ( $(this).children().size() >0 )
					$(this).find('.inner_li').show();	
					$(this).css({cursor : 'default'});
			}, 
			function () {
				$(this).css('background-color' , '#fff' );
				$(this).find('.inner_li').hide();
			});
 
// categories
	if( $.cookie( "catPanel" ) == undefined ){
		$.cookie( "catPanel", initialState );
		catTriangle.addClass( closed );
		catTriangle.removeClass( 'open' );
		tags.removeClass( 'catBumpOne' );
		info.removeClass( 'catInfoBump' );
		$('.tagTable').removeClass( 'catBumpTwo' );
	};
	
	$('.galleryLink').click(function(){		
			if( $.cookie("catPanel") == "expanded") {
					//close categories
					$.cookie("catPanel", "collapsed");	
					catTriangle.removeClass( 'open' ).addClass( 'close' );
					catButton.removeClass( activeTags );
					tags.removeClass( 'catBumpOne' );
					$('.tagTable').removeClass( 'catBumpTwo' );
					info.removeClass( 'catInfoBump catTagInfoBump catTagInfoTagBump tagCatInfoBump tagTeam' );
	
						if( $.cookie("tagPanel") == "expanded" )
							{
								info.addClass( 'tagged' );
							} 						
					} else {
						$.cookie( "catPanel", "expanded" );			
						catTriangle.addClass( 'open' ).removeClass( 'close' );
						catButton.addClass( activeTags );
						tags.addClass( 'catBumpOne' );
						$('.tagTable').addClass( 'catBumpTwo' );
					
						if( $.cookie("tagPanel") == "expanded" )
						{
							info.addClass( 'catTagInfoBump' );
						}; 
						if( $.cookie( "lastTag" ) !== initialState ){
							info.addClass ('catTagInfoTagBump');
						};
						if( $.cookie("tagPanel") == "collapsed" ) 
						{
							info.addClass( 'catInfoBump' );
						};
					}	
					cats.slideToggle('fast');
					//tags.toggleClass( 'catBumpOne' );	
					//info.toggleClass( tagBump );
					//home.addClass( homeTagBump );
					
					return false;
				});
				
	if( catPanelState == initialState ){
		cats.hide();
		//info.removeClass( tagBump );
		//home.removeClass( homeTagBump );
		catTriangle.removeClass( 'open' ).addClass( 'close' );
		catButton.removeClass( activeTags );
		tags.removeClass( 'catBumpOne' );
		$('.tagTable').removeClass( 'catBumpTwo' );
		

		
	};

	if( catPanelState == "expanded" ){
		cats.show();
		catTriangle.removeClass( 'close' ).addClass( 'open' );
		catButton.addClass( activeTags );
		tags.addClass( 'catBumpOne' );
		$('.tagTable').addClass( 'catBumpTwo' );
		info.addClass( 'catInfoBump' );
		if( $.cookie( "lastTag" ) !== initialState ){
			info.addClass ('catTagInfoTagBump');
			};
	};
	
// tags 
		
	if( $.cookie( "tagPanel" ) == undefined ){
		$.cookie( "tagPanel", initialState );
		triangle.addClass( 'close' ).removeClass( 'open' );
		tagButton.removeClass(activeTags);

	};
	
	if( $.cookie( "lastTag" ) == undefined ){
		$.cookie( "lastTag", initialState);
	};
	
	if( tagPanelState == initialState ){
		tags.hide();	
		tagButton.removeClass(activeTags);
		info.removeClass( tagBump );
		home.removeClass( homeTagBump );
		triangle.removeClass( 'open' );
		triangle.addClass( 'close' );
		$('#tagThumbs').hide();
	};

	if(tagPanelState == "expanded" ){
		tagButton.addClass(activeTags);
		tags.show();
		$('#tagThumbs').show();
		info.addClass( tagBump );
		home.addClass( homeTagBump );
		triangle.removeClass( 'close' );
		triangle.addClass( 'open' );
		main.addClass( tagBump );
		theLastTag = $.cookie('lastTag');
	//	var reLoadTagURL = "<?php bloginfo('url'); ?>/tag/" + tagParam + " .tagTable";
		if (theLastTag != "collapsed" ){ 
				
			var reLoadTagURL = "<?php bloginfo('url'); ?>/tag/" + theLastTag + " .tagTable";
			
			
		}
		function reLoadOpenTags(){
            //$('.lightTable').remove();
			$('.tagTable').detach();
			reloadThemOpenTags();
			}
			function reloadThemOpenTags(){	
			//rehideLoader();
			//$('.loader').fadeIn('fast');			
			$('#tagThumbs').load( reLoadTagURL,loadCallback );
			
		 //   $('.tagTable').appendTo($('#ajaxTable'));
		   // if  ( catPanelState == "expanded" ) {
			//	$('.tagTable').addClass( 'catBumpTwo' );
				//}
			};
			function loadCallback(){
				if( catPanelState == "expanded" ){
					$('.tagTable').addClass( 'catBumpTwo' );
				}
			//$('.loader').fadeOut('fast');		
			};
		reLoadOpenTags();
		}

//main menu Tags
	tagButton.click(function(){		
			if( 
			// close tag list
				$.cookie("tagPanel") == "expanded") {
					$.cookie("tagPanel", "collapsed");	
					tagButton.removeClass(activeTags);
					$.cookie("lastTag", "collapsed");			
					triangle.removeClass( 'open' );
					triangle.addClass( 'close' );
					$('.tagTable').remove();
					info.removeClass('tagged');
					info.removeClass('tagCatInfoBump catTagInfoBump catTagInfoTagBump tagTeam');		
					if( $.cookie("catPanel") == "expanded" )
					{
						info.addClass( 'catInfoBump' );	
					} 
				// expand tag list		
				} else {
					$.cookie( "tagPanel", "expanded" );			
					triangle.addClass( 'open' ).removeClass( 'close' );
					tagButton.addClass(activeTags);
					if( $.cookie("catPanel") == "expanded" )
					{
						info.addClass( 'tagCatInfoBump' );
					};
					
					if( $.cookie("catPanel") == "collapsed" ) 
					{
						info.addClass( 'tagged' );
					}				
				}	
				tags.slideToggle('fast');					
				return false;
			});

	$('#tagList li').each(function() {
        $(this).click(function() {
			// remove single image ui controls
			//imgCtrl.hide();	
			$(this).addClass('activeTag').siblings().removeClass('activeTag');
			$('#tagThumbs, .tagTable').show();
			info.addClass('tagTeam');
			if( $.cookie("catPanel") == "expanded" )
				{
					info.addClass('catTagInfoTagBump');
				}
			var tagName = $(this).attr("id");
			var tagURL = '<?php bloginfo('url');?>/tag/' + tagName;
			var toLoad = '<?php bloginfo('url'); ?>/tag/'+ tagName + ' .tagTable';	
			$.cookie("lastTag",tagName);
         //  $('.lightTable').hide();			
			function loadThemTags(){	
			//$('.loader').fadeIn('fast');
					
			$('#tagThumbs').load(toLoad,hideLoader);
			};
			
			function hideLoader(){
			//$('.loader').fadeOut('fast');
			$('.tagTable').fadeIn('slow'); 
		if( $.cookie("catPanel") == "expanded" )
				{
			$('.tagTable').addClass( 'catBumpTwo' );	
				}			
			};
						
			<?php if(empty($_GET)) { ?> 	
			loadThemTags();
			<?php } else { ?>
			
				loadThemTags();
			<?php } ?>
		//  return false;
        });
 	});
	 
	 $('#tagImgBox li').live("click", function(){ 	
	 	var uc = $(this).attr('class');
	 	var uc = uc + "_link";
	 	var up = $('.' + uc).html(); 		
	 	var curTagHash = window.location.hash;
	 	<?php if(empty($_GET)) { ?> 			
	 	    var noHash = curTagHash.replace(/^.*#/, '');
			var hash_param = noHash.replace(/\s/g, '-');
			var tagParamURL = up +"?tagP=" + hash_param;
	 		window.location = tagParamURL;
			<?php } else { ?>		
				if($.cookie("lastTag") == "null") {				
					var tagParamURL = up +"?tagP=" + tagParam;
			 		window.location = tagParamURL;	 		
				 } else {
				 		var tagParamURL = up +"?tagP=" + tagPanelHistory;
				 		window.location = tagParamURL;		 		
				 	}
				<? } ?>
	 		});
	 		
	 if ( tagPanelHistory !== initialState ) {
		info.addClass('tagTeam');	
		//alert(tagPanelHistory);  	
				
		var loadHistory = '<?php bloginfo( 'url' ); ?>/tag/'+ tagPanelHistory + ' .tagTable';
			//$('.tagTable').detach();
		//	$('#tagThumbs').load( loadHistory, function(){
		//		$('.tagTable').appendTo($('#ajaxTable'));
		//		if ( catPanelState == "expanded" ) {
		//		$('.tagTable').addClass( 'catBumpTwo' );
		//		}
				//});
		 
		
	 };
	 	
// info
	
	if ( $.cookie( 'infoPanel' ) == undefined ){
		$.cookie( 'infoPanel', initialState );
		infoTri.addClass( 'close' );
		infoTri.removeClass( 'open' );
	};
	
	if( infoPanelState == 'collapsed' ){
		info.hide();
		// moved to start info.addClass ('infoClose');
		infoTri.removeClass( 'open' );
		infoTri.addClass( 'close' );
	};
		
	if( infoPanelState == 'expanded' ){
	 	info.show();
//		info.addClass ('infoOpen');
		infoTri.removeClass( 'close' );
		infoTri.addClass('open');
		infoButton.addClass(activeTags);
	};
	

		
		
	infoButton.click( function(){
			if( $.cookie( 'infoPanel' ) == 'expanded' ) {
				$.cookie( 'infoPanel', 'collapsed' );
				infoButton.removeClass( activeTags );
				info.hide();
				//google.maps.event.trigger(map, 'resize');  
			    info.removeClass ('infoOpen');
		 //	    info.addClass ('infoClose');				
		 		infoTri.removeClass( 'open' );
				infoTri.addClass( 'close' );
			} else {
				$.cookie( 'infoPanel', 'expanded' );
				infoButton.addClass( activeTags );
				info.show();
			   // google.maps.event.trigger(map, 'resize');
			//    info.removeClass ('infoClose');
			//    info.addClass ('infoOpen');
				infoTri.removeClass( 'close' ); 
				infoTri.addClass( 'open' );
				if(( $.cookie('catPanel') == "expanded" ) && ( $.cookie('tagPanel') == "expanded" ))
					{
						info.addClass( 'tagCatInfoBump' );
					} 

			}
			//info.slideToggle('fast');
			return false;
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


// Update this with https://github.com/cowboy/jquery-hashchange
	$.history.init(function(hash){
		        if(hash == '') {
		            // remove
		        } else {
				var tagHash = window.location.hash;
				var noHash = tagHash.replace(/^.*#/, '');
				var Hash = noHash.replace(/\s/g, '-');
				var reLoadURL = '<?php bloginfo( 'url' ); ?>/tag/'+ Hash + ' .tagTable';
		
				function reLoad(){		
		
		            //$('.lightTable').remove();
//					$('.tagTable').detach();
//					$('#tagThumbs').load(reLoadURL,rehideLoader);
//				    $('.tagTable').appendTo($('#ajaxTable'));
//				    $('.tagTable').addClass( 'catBumpTwo' );
					}
					function reloadThemTags(){	
					//rehideLoader();
					//$('.loader').fadeIn('fast');			

					};
					function rehideLoader(){
					//$('.loader').fadeOut('fast');		
					};
				reLoad ();
		        }
		    },
		    { unescape: ',/' });

    var tagDiv = $('div#tagList');
	var tagUl = $('ul.post_tags');	
	//var tagDivWidth = tagDiv.width();
	var winWidth = $(window).width();
	//var winWidth2 = winWidth * 2;
	var tagDivWidth = winWidth - 20;
	var lastLi = tagUl.find('li:last-child');
  //  var width = 0;
          
	tagDiv.css({overflow: 'hidden' });
/*
        $('ul li').each(function() {
         width += $(this).outerWidth();
        });
 */
	tagDiv.mousemove(function(e){
       tagUl.css({ marginLeft: '20px' });
		var ulWidth = lastLi[0].offsetLeft + lastLi.outerWidth();    
		var left = (e.pageX - tagDiv.offset().left) * (ulWidth-tagDivWidth) / tagDivWidth;
	//	console.log (e.pageX);

          tagDiv.scrollLeft(left);
          
   //console.log('ulWidth : ' + ulWidth + ' | tagDivWidth : ' + tagDivWidth +  ' | left : ' + left + ' | width : ' + width );
		});
				    
	if ((tagPanelState == "expanded") && (catPanelState == "expanded" ))
		{	
		  
		//  	$('.tagTable').addClass( 'catBumpTwo' );
		 
		};		    
		 	
	});	//jQuery	
 
</script>

<script type="text/javascript">
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

</script>
<?php wp_footer(); ?>
</body>
</html>