<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
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

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<!--[if !IE 7]>
	<style type="text/css">
		#wrap {display:table;height:100%}
	</style>
<![endif]-->

	<?php if (is_single() ) { ?>
	
<link href='http://fonts.googleapis.com/css?family=Crimson+Text&subset=latin' rel='stylesheet' type='text/css'>
 <script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/jquery.mousewheel.min.js" ></script>
     <script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/iViewer.js" ></script>
        <script type="text/javascript">
            var $ = jQuery;
            $(document).ready(function(){
				
                  $("#viewer").iviewer(
                       {
                       src: "<?php echo catch_that_image() ?>",    
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
			</div><!-- #masthead -->	
		</div><!-- #header -->

		<?php } elseif (is_archive() ) { ?>
	<div id="header">
		<div id="masthead">
			<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
			</div><!-- #masthead -->	
		</div><!-- #header -->
					
		<?php } else { ?> 
			<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
				
		<?php }?>
		<div id="topNav">
	<ul><li><a href="#">about</a></li>
	<li><a href="<?php echo home_url( '/' ); ?>tags">tags</a></li>
	<li><a href="#">favorites</a></li>
	</ul>
	</div>	
		<?php 
	if (is_single()){ ?>
	<div class="imageTitle">
<span class="blinky">_</span><div class="caption"></div>
<input class="hidden" type="text" id="userCaption"  value="<?php the_title(); ?>" /></div>
			
<?php drop_tags(); ?>

					
<ul id="controls">
	<li><a id="in" href="#">+</a></li>
    <li><a id="out" href="#">-</a></li>
  <!--    <a id="fit" href="#">100%</a>
 <a id="orig" href="#">orig</a> -->
	</ul>
    <?php } ?>
	

	
	
	

	
