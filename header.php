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
<link href='http://fonts.googleapis.com/css?family=Crimson+Text&subset=latin' rel='stylesheet' type='text/css'>

</head>

<body <?php body_class(); ?>>


	<div id="header">
		<div id="masthead">
		<?php if (is_home() ) { ?>
				<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
		<?php } elseif (is_single() ) { ?>
				<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
		
		
		<?php } elseif (is_archive() ) { ?>
			<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
		 <div class="entry-utility">
						<?php loupe_posted_in(); ?>
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-utility -->
					
		<?php } else { ?> 
			<h1 id="site-title">
					<span>
						<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</span>
				 </h1>
				
		<?php }?>
			
		</div><!-- #masthead -->
		
		<?php 
	if (is_single()){ ?>
	<div class="imageTitle">

<span class="blinky">_</span><div class="caption"></div>

<input class="hidden" type="text" id="userCaption"  value="<?php the_title(); ?>" /></div><div class=""></div>
	<span style="position: absolute; width: 200px; top: 0px; right: 100px;">
	<a id="in" href="#">+</a>
    <a id="out" href="#">-</a>
    <a id="fit" href="#">100%</a>
 <!--  <a id="orig" href="#">orig</a> -->
	</span>
    <?php } ?>
	
	</div><!-- #header -->
	
	
<div id="outer">
  <div id="middle">
    <div id="inner">
<div id="wrap">
	<div id="main">
	
