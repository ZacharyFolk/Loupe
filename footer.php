<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
</div><!-- #main -->
<?php if (! is_home()){ ?>
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
	<div id="footer" role="contentinfo">
	<?php if (! is_home()){ ?>
	 <div class="all">Show Recent Posts</div>
	<?php } ?>
	<?php //if ( have_posts() ) while ( have_posts() ) : the_post();
	
//	wpfp_link();  ?> 
   
<?php // endwhile; // end of the loop. ?>
<!--
		 <div class="fb"> 
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
</div>
-->
	</div><!-- #footer -->

</div><!-- #wrapper -->

    </div>
  </div>
</div>

<script type="text/javascript">
var $ = jQuery;

$(document).ready(function(){

	var imgCtrl = $('#controls');
	var panel = $('.thumbBox');
	var button = $('.all');
	var initialState = "collapsed";
	var activeClass = "active";
	var visibleText = "hide recent posts";
	var hiddenText = "show recent posts";
	var triangle = $('.tagLink span');
	var infoTri = $('#infoLink span');
	var closed = "close";
	var opened = "open";	
	var tags = $('#tagList');	
	var tagPanelState = $.cookie("tagPanel");
	var tagButton = $('.tagLink');
	var tagThumbs = $('.tagTable');
	var tagImage = $('.tagImgBox a');
	var tagThumbState = $.cookie("tagThumbPanel");
	var info = $('#infoPanel');	
	var infoPanelState = $.cookie("infoPanel");
	var infoButton = $('#infoLink');
	var main = $('#ajaxTable');
	var tagBump = ("tagged");
	var tagTeamBump = ("tagTeam");
	var activeTags = "activeTagClass";
	<?php $id = $_GET['tagP']; ?>
	var tagParam = "<?php echo $id; ?>";
	var state = $.cookie("panelState");

	if($.cookie("panelState") == undefined) {
		$.cookie("panelState", initialState);
		}

	if(state == "collapsed") {
			panel.hide();
			button.text(hiddenText);
			button.addClass(activeClass);
		}
		
	button.click(function(){
			if($.cookie("panelState") == "expanded") {
				$.cookie("panelState", "collapsed");
				button.text(hiddenText);
				button.addClass(activeClass);
			} else {
				$.cookie("panelState", "expanded");
				button.text(visibleText);
				button.removeClass(activeClass);
			}
			panel.slideToggle("slow");
			return false;
	});		

// tags 

	if($.cookie("tagPanel") == undefined){
		$.cookie("tagPanel", initialState);
		triangle.addClass(closed);
		triangle.removeClass(opened);
		}
	
	if(tagPanelState == "collapsed"){
		tags.hide();
		info.removeClass(tagBump);
		triangle.removeClass(opened);
		triangle.addClass(closed);
		}

	if(tagPanelState == "expanded"){
		tags.show();
		info.addClass(tagBump);
		triangle.removeClass(closed);
		triangle.addClass(opened);
		main.addClass(tagBump);

		var reLoadTagURL = '<?php bloginfo( 'url' ); ?>/tag/'+ tagParam + ' .tagTable';

		function reLoadOpenTags(){
            //$('.lightTable').remove();
			$('.tagTable').detach();
			reloadThemOpenTags();
			}
			function reloadThemOpenTags(){	
			//rehideLoader();
			//$('.loader').fadeIn('fast');			
			$('#tagThumbs').load(reLoadTagURL,rehideTagLoader);
		    $('.tagTable').appendTo($('#ajaxTable'));
	
			};
			function rehideTagLoader(){
			//$('.loader').fadeOut('fast');		
			};
		reLoadOpenTags ();
		}

	tagButton.click(function(){		
			if($.cookie("tagPanel") == "expanded") {
				$.cookie("tagPanel", "collapsed");			
				triangle.removeClass(opened);
				triangle.addClass(closed);
				$('.tagTable').remove();
				info.removeClass(tagTeamBump);			
			} else {
				$.cookie("tagPanel", "expanded");			
				triangle.addClass(opened);
				triangle.removeClass(closed);
			}			
				tagButton.toggleClass(activeTags);
				tags.slideToggle("fast");	
				info.toggleClass(tagBump);
				tagThumbs.slideToggle("fast");	
				return false;
			});


	$('#tagList li').each(function() {
        $(this).click(function() {
			// remove single image ui controls
			//imgCtrl.hide();	
			$('.tagTable').show();
			info.addClass(tagTeamBump);
			var tagName = $(this).attr("id");
			var tagURL = '<?php bloginfo( 'url' );?>/tag/' + tagName;
			var toLoad = '<?php bloginfo( 'url' ); ?>/tag/'+ tagName + ' .tagTable';	
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
		 		var lastTagCookie = $.cookie("lastTag");
		 		var tagParamURL = up +"?tagP=" + lastTagCookie;
		 		window.location = tagParamURL;
		 		
		 	}
		<? } ?>
	 });

// info
	
	if($.cookie("infoPanel") == undefined){
		$.cookie("infoPanel", initialState);
		infoTri.addClass(closed);
		infoTri.removeClass(opened);
		}
	if(infoPanelState == "collapsed"){
		info.hide();
		infoTri.removeClass(opened);
		infoTri.addClass(closed);
		}
		
	if(infoPanelState == "expanded"){
		info.show();
		infoTri.removeClass(closed);
		infoTri.addClass(opened);
		}
	
	infoButton.click(function(){
			if($.cookie("infoPanel") == "expanded") {
				$.cookie("infoPanel", "collapsed");
				infoButton.removeClass(activeTags);
				infoTri.removeClass(opened);
				infoTri.addClass(closed);
			} else {
				$.cookie("infoPanel", "expanded");
				infoButton.addClass(activeTags);
				infoTri.addClass(opened);
				infoTri.removeClass(closed);
			}
			info.slideToggle("fast");
			return false;
	});	
	
				
/*	var recPanel = $('ul#recentPosts');
	var tagPanel = $('ul#recentTags');
	var postButton = $('h2.postTrigger');
	var tagButton = $('h2.tagTrigger');
	var initialState = "collapsed";
	var activeClass = "active";
	var visibleText = "HIDE RECENT POSTS";
	var hiddenText = "VIEW RECENT POSTS";
	var visibleTagText = "HIDE TOP TEN TAGS";
	var hiddenTagText = "SHOW TOP TEN TAGS";

	if($.cookie("postPanelState") == undefined) {
		$.cookie("postPanelState", initialState);
		}
	var state = $.cookie("postPanelState");
		/* if(state == "collapsed") {
			recPanel.hide('fast'); 
			postButton.text(hiddenText);
			postButton.removeClass(activeClass);
		}
		postButton.click(function(){
			if($.cookie("postPanelState") == "expanded") {
				$.cookie("postPanelState", "collapsed");
				postButton.text(hiddenText);
				postButton.removeClass(activeClass);
			} else {
				$.cookie("postPanelState", "expanded");
				postButton.text(visibleText);
				postButton.addClass(activeClass);
			}
		/*	recPanel.slideToggle("fast");
			return false;
		});
			 */
	/*	var state = $.cookie("tagPanelState");
		if(state == "collapsed") {
			tagPanel.hide('fast');
			tagButton.text(hiddenTagText);
			tagButton.removeClass(activeClass);
		}
		tagButton.click(function(){
			if($.cookie("tagPanelState") == "expanded") {
				$.cookie("tagPanelState", "collapsed");
				tagButton.text(hiddenTagText);
				tagButton.removeClass(activeClass);
			} else {
				$.cookie("tagPanelState", "expanded");
				tagButton.text(visibleTagText);
				tagButton.addClass(activeClass);
			}
			tagPanel.slideToggle("fast");
			return false;
		});
		*/		
			
});	

$.history.init(function(hash){
        if(hash == "") {
            // initialize your app
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
    { unescape: ",/" });
</script>
<?php wp_footer(); ?>
</body>
</html>