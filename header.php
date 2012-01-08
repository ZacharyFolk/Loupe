<!DOCTYPE html>
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
	<?php if (is_single() ) { ?>

<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/jquery.mousewheel.min.js" ></script>
<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/iViewer.js" ></script>


	<?php } ?>
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
				 <div class="tagLink">
				<a href="?tags">tags </a><span class="close"></span>
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
				<a href="?tags">tags </a><span class="close"></span>
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
	<div class="tagTable" style="display:none">&nbsp;</div>
	<div id="ajaxTable">
