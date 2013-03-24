<?php
/**
 * @package WordPress
 * @subpackage Loupe
 * @since Loupe 1.0
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]><html <?php language_attributes(); ?> class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie ie9 lte9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" href="<?php bloginfo( 'template_directory' ); ?>/fonts/fonts.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<meta property="og:title" content="<?php wp_title( '|', true, 'right' ); ?>" />
	<meta porperty="og:site_name" content="Folk Photography" />
	<meta porperty="og:type" content="blog" />
	<?php // for facebook open graph
		if ( have_posts() ) :  while ( have_posts() ) : the_post(); 
		$single_image = get_post_meta($post->ID, 'single_photo', true); 
		$single_words = get_post_meta($post->ID, 'photowords', true); 
		$single_url = urlencode(get_permalink($post->ID));  
		//$fbmeta = '<meta property="og:description" content="';
		//$fbmeta .= $single_words ;
		//$fbmeta .='" />' ;
		$fbmeta = '<meta property="og:image" content="'; 
		$fbmeta .= $single_image ;
		$fbmeta .='" />';
	
		$fbmeta .= '<meta property="og:url" content="'; 
		$fbmeta .= $single_url;
		$fbmeta .='" />';
		echo $fbmeta;	
		endwhile; endif;?>
	
	<?php
		/* We add some JavaScript to pages with the comment form
		 * to support sites with threaded comments (when in use).
		 */
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		wp_head();
	?>
</head>
<body <?php body_class(); ?>>
<noscript>
 For full functionality of this site it is necessary to enable JavaScript.
 Here are the <a href="http://www.enable-javascript.com/" target="_blank">
 instructions how to enable JavaScript in your web browser</a>.
</noscript>

		<header role="banner">
			<h1><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="radiohead"><?php bloginfo( 'name' ); ?></a></h1>
		<!--//	<p><?php //bloginfo( 'description' ); ?></p> -->
			<nav>
				<ul class="gandhiR">
					<li class="navTags">Tags</li>
					<li>/</li>
					<li>About</li>
					<li>/</li>
					<li>Blog</li>
				</ul>
			</nav>
		</header>
			<section id="content" role="main">