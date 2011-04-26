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
		<img class="nofotomoto" src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo catch_that_image() ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
		</a>
	<?php endwhile; ?>
</div>
<?php } ?>
	<div id="footer" role="contentinfo">
	<ul id="colorPick">
	<li><a class="box_000" href="#black">&nbsp;</a></li>
	<li><a class="box_2f2" href="#2f">&nbsp;</a></li>
	<li><a class="box_fff" href="#white">&nbsp;</a></li>
	</ul>
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
<?php if (! is_home()){ ?>
<script type="text/javascript">
var $ = jQuery;

$(document).ready(function(){

var panel = $('.thumbBox');
var button = $('.all');
var initialState = "collapsed";
var activeClass = "active";
var visibleText = "hide recent posts";
var hiddenText = "show recent posts";

if($.cookie("panelState") == undefined) {
	$.cookie("panelState", initialState);
	}
var state = $.cookie("panelState");
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
	
  var tagPanel = $('#tagList');
	$('.tagLink').click(function(){
	
		tagPanel.slideToggle('fast');
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
*/
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
</script>
<?php } ?>	
<?php
	wp_footer();
?>
</body>
</html>
