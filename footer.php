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
	var closed = 'close';
	var opened = 'open';	
	var tags = $('#tagList');
	var cats = $('#catList');	
	var tagPanelState = $.cookie('tagPanel');
	var tagPanelHistory = $.cookie('lastTag');
	var catPanelState = $.cookie('catPanel');
	var tagButton = $('.tagLink');
	var catButton = $('.galleryLink');

	var tagImage = $('.tagImgBox a');
	var tagThumbState = $.cookie('tagThumbPanel');
	var info = $('#infoPanel');	
	var infoPanelState = $.cookie('infoPanel');
	var infoButton = $('#infoLink');
	var main = $('#ajaxTable');
	var home = $('.floater');
	// bumps depending on what is open in menu
	var homeTagBump = ( 'hometagged' );
	var tagBump = ('tagged');
	var tagTeamBump = ('tagTeam');
	var catBump = ('catBump');
	
	var activeTags = 'activeTagClass';
	<?php $id = $_GET['tagP']; ?>
	var tagParam = '<?php echo $id; ?>';
	var state = $.cookie('panelState');

	if($.cookie('panelState') == undefined) {
		$.cookie('panelState', initialState);
		}
		


	$('.viewer').bind('contextmenu',function(e){
		 //	e.preventDefault();
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
		catTriangle.removeClass( opened );
	};
	
	catButton.click(function(){		
			if( $.cookie("catPanel") == "expanded") {
				$.cookie("catPanel", "collapsed");	
				catTriangle.removeClass( opened );
				catTriangle.addClass( closed );
					
			} else {
				$.cookie( "catPanel", "expanded" );			
				catTriangle.addClass( opened );
				catTriangle.removeClass( closed );
				
			}	catButton.toggleClass( activeTags );
				cats.slideToggle('fast');	
				//info.toggleClass( tagBump );
				//home.addClass( homeTagBump );
				
				return false;
			});
	if( catPanelState == initialState ){
		cats.hide();
		//info.removeClass( tagBump );
		//home.removeClass( homeTagBump );
		catTriangle.removeClass( opened );
		catTriangle.addClass( closed );
		
	};

	if( catPanelState == "expanded" ){
		cats.show();
	
		//info.addClass( tagBump );
		//home.addClass( homeTagBump );
		catTriangle.removeClass( closed );
		catTriangle.addClass( opened );
	//	main.addClass( tagBump );
	};
	
// tags 

	if( $.cookie( "tagPanel" ) == undefined ){
		$.cookie( "tagPanel", initialState );
		triangle.addClass( closed );
		triangle.removeClass( opened );
	};
	
	if( $.cookie( "lastTag" ) == undefined ){
		$.cookie( "lastTag", initialState);
	};
	
	if( tagPanelState == initialState ){
		tags.hide();
		info.removeClass( tagBump );
		home.removeClass( homeTagBump );
		triangle.removeClass( opened );
		triangle.addClass( closed );
		$('#tagThumbs').hide();
	};

	if(tagPanelState == "expanded" ){
		tags.show();
		$('#tagThumbs').show();
		info.addClass( tagBump );
		home.addClass( homeTagBump );
		triangle.removeClass( closed );
		triangle.addClass( opened );
		main.addClass( tagBump );

		var reLoadTagURL = "<?php bloginfo('url'); ?>/tag/" + tagParam + " .tagTable";

		function reLoadOpenTags(){
            //$('.lightTable').remove();
			$('.tagTable').detach();
			reloadThemOpenTags();
			}
			function reloadThemOpenTags(){	
			//rehideLoader();
			//$('.loader').fadeIn('fast');			
			$('#tagThumbs').load( reLoadTagURL,rehideTagLoader );
		    $('.tagTable').appendTo($('#ajaxTable'));
	
			};
			function rehideTagLoader(){
			//$('.loader').fadeOut('fast');		
			};
		reLoadOpenTags();
		}

	tagButton.click(function(){		
			if( $.cookie("tagPanel") == "expanded") {
				$.cookie("tagPanel", "collapsed");
				$.cookie("lastTag", "collapsed");			
				triangle.removeClass( opened );
				triangle.addClass( closed );
				$('.tagTable').remove();
				info.removeClass( tagTeamBump );			
			} else {
				$.cookie( "tagPanel", "expanded" );			
				triangle.addClass( opened );
				triangle.removeClass( closed );
				
			}	tagButton.toggleClass( activeTags );
				tags.slideToggle('fast');	
				info.toggleClass( tagBump );
				home.addClass( homeTagBump );
				
				return false;
			});


	$('#tagList li').each(function() {
        $(this).click(function() {
			// remove single image ui controls
			//imgCtrl.hide();	
			$(this).addClass('activeTag').siblings().removeClass('activeTag');
			$('#tagThumbs, .tagTable').show();
			info.addClass(tagTeamBump);
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
		info.addClass(tagTeamBump);	
		//alert(tagPanelHistory);  	
				
		var loadHistory = '<?php bloginfo( 'url' ); ?>/tag/'+ tagPanelHistory + ' .tagTable';
			$('.tagTable').detach();
			$('#tagThumbs').load( loadHistory );
		    $('.tagTable').appendTo($('#ajaxTable'));
	 };
	 	
// info
	
	if ( $.cookie( 'infoPanel' ) == undefined ){
		$.cookie( 'infoPanel', initialState );
		infoTri.addClass( closed );
		infoTri.removeClass( opened );
	};
	
	if( infoPanelState == 'collapsed' ){
		//info.hide();
		info.addClass ('infoClose');
		infoTri.removeClass( opened );
		infoTri.addClass( closed );
	};
		
	if( infoPanelState == 'expanded' ){
		//info.show();
		info.addClass ('infoOpen');
		infoTri.removeClass(closed);
		infoTri.addClass(opened);
		infoButton.addClass(activeTags);
	};
	
	infoButton.click( function(){
			if( $.cookie( 'infoPanel' ) == 'expanded' ) {
				$.cookie( 'infoPanel', 'collapsed' );
				infoButton.removeClass( activeTags );
				//google.maps.event.trigger(map, 'resize');  
			    info.removeClass ('infoOpen');
			    info.addClass ('infoClose');				
				infoTri.removeClass( opened );
				infoTri.addClass( closed );
			} else {
				$.cookie( 'infoPanel', 'expanded' );
				infoButton.addClass( activeTags );
			   // google.maps.event.trigger(map, 'resize');
			    info.removeClass ('infoClose');
			    info.addClass ('infoOpen');
				infoTri.removeClass( closed ); 
				infoTri.addClass( opened );

			}
			//info.slideToggle('fast');
			return false;
	});			


// MOVE THIS
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
					$('.tagTable').detach();
					$('#tagThumbs').load(reLoadURL,rehideLoader);
				    $('.tagTable').appendTo($('#ajaxTable'));
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
				    
		    
		 	
	});	//jQuery	
 
</script>
<?php wp_footer(); ?>
</body>
</html>