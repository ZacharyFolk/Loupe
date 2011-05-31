<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
	wp_head();
?>
<!--[if !IE 7]>
	<style type="text/css">
		#wrap {display:table;height:100%}
	</style>
<![endif]-->
	<?php if (is_single() ) { ?>

<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/jquery.mousewheel.min.js" ></script>
<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/iViewer.js" ></script>

<script type="text/javascript">
    var $ = jQuery;
      $(document).ready(function(){
		var colors = $.cookie('colors');
                  $("#viewer").iviewer(
                       {
                       src: "<?php echo get_first_attachment() ?>",    
                       zoom: 70,
                       initCallback: function ()
                       {
                           var object = this;
                           $("#in").click(function(){ object.zoom_by(1);}); 
                           $("#out").click(function(){ object.zoom_by(-1);}); 
						   
						
     //  $("#fit").click(function(){ object.fit();}); 
         //$("#orig").click(function(){  object.set_zoom(100); }); 
		 // console.log(this.img_object.display_width); //works*
				// console.log(object.img_object.display_width); //getting undefined.*
                       },
					     onFinishLoad: function()
                    {
	$("#viewer img").fadeIn(400);
                    }
        //      onFinishLoad: function()
                  //      {
			//	$("#viewer").data('viewer').setCoords(-500,-500);
                  //        this.setCoords(-0, -500);
                  //      }
//onMouseMove: function(object, coords) { },
//onStartDrag: function(object, coords) { return false; }, //this image will not be dragged
//onDrag: function(object, coords) { }
                  });
            });
        </script>
	<?php } ?>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAAROWEqURhKzwCcde7FfovARTyRiL7IE6hyITZU8V5EzKicC6EOBTs38fFe23Dc5VFbtYGUPUQg8qeGw" type="text/javascript"></script>
<body <?php body_class(); ?>>
<script type="text/javascript">
function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}
var x = readCookie('colors')
if (x == 'middleGrey') {
	document.body.className +=" "+'c2f2'
}
if (x == 'white') {
	document.body.className +=" "+'cfff'
}
if (x == 'black') {
	document.body.className +=" "+'c000'
}
</script>


		<?php if (is_home() || is_page('tags') ) { ?>
	<div id="header">
		<div id="masthead">
				<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
				 <div class="sep">|</div>
				 <div class="tagLink">
				 tags
				</div>
		</div><!-- #masthead -->

	</div><!-- #header -->		
		<?php } elseif (is_single() ) { ?>
	<div id="header">
		<div id="masthead">
				<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
				 	 <div class="sep">|</div>
				 <div class="tagLink">
				tags <span class="close"></span>
				</div>
				<div class="sep">|</div>
			
				<div class="editLink">
					categories
				</div>		
					<div class="sep">|</div>
				<div class="editLink">
					<?php edit_post_link('edit', '<p>', '</p>'); ?>
				</div>
			</div><!-- #masthead -->
			
		</div><!-- #header -->

		<?php } elseif (is_archive() ) { ?>
	<div id="header">
		<div id="masthead">
			<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1> <div class="sep">|</div>
				 <div class="tagLink">
				tags
				</div>
			</div><!-- #masthead -->
		</div><!-- #header -->				
		<?php } else { ?> 
			<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1> 
				 
				 <div class="sep">|</div>
				 <div class="tagLink">
				tags <span class="close"></span>
				</div>
			</div><!-- #masthead -->
							
		<?php }?>
		<!-- //  <div id="topNav">
	<ul><li><a href="#">about</a></li>
	<li><a href="<?php // echo home_url( '/' ); ?>tags">tags</a></li>
	<li><a href="#">favorites</a></li>
	</ul>
	</div>	 // -->
		<?php 
	if (is_single()){ ?>
	<div class="imageTitle">
<span class="blinky">_</span><div class="caption"></div>
<input class="hidden" type="text" id="userCaption"  value="<?php the_title(); ?>" /></div>
			
<?php // drop_tags(); ?>
	
<ul id="controls">
	<li class="zoom">Zoom : </li>
	<li class="zoom_out"><a id="out" href="#"> - </a></li>
	<li class="zoom_in"><a id="in" href="#"> + </a></li>
	<li>|</li>
    <li id="infoLink">info <span class="close"></span></li>
  <!--    <a id="fit" href="#">100%</a>
 <a id="orig" href="#">orig</a> -->
	</ul>
    <?php } ?>
	<div id="tagList">
	<?php $tagArgs = array(
						'orderby' => 'name',
						'order' => 'ASC',
						'number' => 50,
						);
						$theTags = get_tags( $tagArgs );
						$tagListHTML = '<ul class="post_tags">';
							foreach ($theTags as $theTag){
							$tagLink = get_tag_link($theTag->term_id);		
							$tagListHTML .= "<li class='count-{$theTag->count}' id='{$theTag->slug}'><a href='#{$theTag->name}' title='{$theTag->name} Tag' class='{$theTag->slug}'>{$theTag->name}</a></li>
							<li> | </li>";
								}
							$tagListHTML .= '</ul>';
							echo $tagListHTML;
	?>
	</div>
	<div id="tagThumbs"></div>
	<div class='loader'><img src='<?php bloginfo('template_url');?>/images/ajax-loader-000.gif'></div>
	<div id="ajaxTable">
