<?php
/**
 * @package WordPress
 * @subpackage Loupe
 * @since Loupe 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
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

<body>
<noscript>
 For full functionality of this site it is necessary to enable JavaScript.
 Here are the <a href="http://www.enable-javascript.com/" target="_blank">
 instructions how to enable JavaScript in your web browser</a>.
</noscript>

		<?php if (is_page('home') || is_page('tags') ) { ?>
	<div id="header">
		<div id="masthead">
				<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
				 <div class="sep">|</div>
			
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
				 <ul id="singleNav">
					<li class="sep">|</li>
					<li class="galleryLink">
					<a href="#">galleries</a> <span class="close"></span>
					</li>
					<li class="tagLink">
					<a href="?tags">tags </a><span class="close"></span>
					</li>
					<li class="sep">|</li>
				
						<li class="sep">|</li>
						
				
				</ul>
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
	
	<ul id="controls">
		<li class="zoom">Zoom : </li>
		<li class="zoom_out"><a id="out" href="#"> - </a></li>
		<li class="zoom_in"><a id="in" href="#"> + </a></li>
		<li>|</li>
	    <li id="infoLink"><a href="#">info</a> <span class="close"></span></li>
	  <!--    <a id="fit" href="#">100%</a>
	 <a id="orig" href="#">orig</a> -->
	</ul>
	<ul id="catList" style="display:none">
	<?php  wp_list_categories('orderby=name&title_li=') ?>
	</ul>
	
	<div id="tagList" style="display:none">
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
	    <?php } ?>