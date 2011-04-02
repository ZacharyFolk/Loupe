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
		<?php 
	if (is_single()){ ?>
	<div class="thumbBox" >
	<?php
$thumbPosts = new WP_Query();
$thumbPosts->query('showposts=55');
while ($thumbPosts->have_posts()) : $thumbPosts->the_post(); ?>
<a href="<?php the_permalink(); ?>">
<img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo catch_that_image() ?>&w=80&h=80&a=b&zc=1&q=80" alt="<?php the_title(); ?>" />
</a>
<?php endwhile;
?>

	
	</div>
    <?php } ?>
	<div id="footer" role="contentinfo">
	
	<ul id="colorPick">
	<li><a class="box_000" href="#black">&nbsp;</a></li>
	<li><a class="box_2f2" href="#2f">&nbsp;</a></li>
	<li><a class="box_fff" href="#white">&nbsp;</a></li>
	</ul>
	<?php if (is_single()){  ?>
	 <div class="all">Hide</div>
	 <?php } ?>
	 
	 <div class="fb">
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php the_permalink(); ?>&amp;layout=standard&amp;show_faces=false&amp;width=450&amp;action=like&amp;font=arial&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe>
</div>
	</div><!-- #footer -->

</div><!-- #wrapper -->

    </div>
  </div>
</div>
<script type="text/javascript">
var $ = jQuery;

$(document).ready(function(){
var colors = $.cookie('colors');
<?php if (is_single()){ ?>
var panel = $('.thumbBox');
var button = $('.all');
var initialState = "collapsed";
var activeClass = "active";
var visibleText = "hide";
var hiddenText = "show";

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
<?php } ?>	
<?php if (is_home()){ ?>
	var recPanel = $('ul#recentPosts');
	var postButton = $('h2.postTrigger');
	var initialState = "collapsed";
	var activeClass = "active";
	var visibleText = "HIDE RECENT POSTS";
	var hiddenText = "VIEW RECENT POSTS";
	

	if($.cookie("postPanelState") == undefined) {
		$.cookie("postPanelState", initialState);
		}
	var state = $.cookie("postPanelState");
		if(state == "collapsed") {
			recPanel.hide('fast');
			postButton.text(hiddenText);
			postButton.addClass(activeClass);
		}
		postButton.click(function(){
			if($.cookie("postPanelState") == "expanded") {
				$.cookie("postPanelState", "collapsed");
				postButton.text(hiddenText);
				postButton.addClass(activeClass);
			} else {
				$.cookie("postPanelState", "expanded");
				postButton.text(visibleText);
				postButton.removeClass(activeClass);
			}
			recPanel.slideToggle("fast");
			return false;
		});
<?php } ?>			
		
	$(".box_2f2").click(function(){
		$('body').removeClass('c000 cfff c2f2');
		$('body').addClass('c2f2');
		$.cookie('colors','middleGrey');
		return false;
		});
	$(".box_fff").click(function(){
		$('body').removeClass('c000 cfff c2f2');
		$('body').addClass('cfff');
		$.cookie('colors','white');
		return false;
		});
	$(".box_000").click(function(){
		$('body').removeClass('c000 cfff c2f2');
		$('body').addClass('c000');
		$.cookie('colors','black');
		return false;
		});
	if(colors == 'middleGrey')
	{
	$('body').addClass('c2f2');
	}
	if (colors == 'white')
	{
	$('body').addClass('cfff');
	}
	if(colors == 'black')
	{
	$('body').addClass('c000');
	}

	
});	



</script>
		<?php 
	if (is_single()){ ?>
<script type="text/javaScript">

setInterval ( "cursorAnimation()", 700 );

function cursorAnimation()
{
  jQuery(".blinky").animate(
  {
    opacity: 0
  }, "fast", "swing").animate(
  {
    opacity: 1
  }, "fast", "swing");
}

var captionLength = 0;
var caption = "";

function TypingEffect()
{
  caption = $("input#userCaption").val();
  type();
}
function type()
{
  $('div.caption').html(caption.substr(0, captionLength++ ));
  if(captionLength < caption.length+1)
  {
    setTimeout("type()", 300);
  }
  else
  {
    captionLength = 0;
    caption = "";
  }
}

setTimeout(TypingEffect, "1000")
</script>
<?php } ?>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
