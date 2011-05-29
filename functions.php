<?php
/**
 *
 * Core Twentyten functions
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 * The Loupe functions and definitions
 * function my_init = safe loading of all of the scripts
 * function z_gallery_shortcode = custom output for [gallery] shorcode to work
 * with the jQuery gallery
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */


if ( ! isset( $content_width ) )
	$content_width = 640;

add_action( 'after_setup_theme', 'loupe_setup' );

if ( ! function_exists( 'loupe_setup' ) ):
/**

 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function loupe_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	//load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

//	$locale = get_locale();
//	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
//	if ( is_readable( $locale_file ) )
//		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();


}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'twentyten' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 2, located below the Primary Widget Area in the sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Secondary Widget Area', 'twentyten' ),
		'id' => 'secondary-widget-area',
		'description' => __( 'The secondary widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 3, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'First Footer Widget Area', 'twentyten' ),
		'id' => 'first-footer-widget-area',
		'description' => __( 'The first footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 4, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Second Footer Widget Area', 'twentyten' ),
		'id' => 'second-footer-widget-area',
		'description' => __( 'The second footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 5, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Third Footer Widget Area', 'twentyten' ),
		'id' => 'third-footer-widget-area',
		'description' => __( 'The third footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	// Area 6, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Fourth Footer Widget Area', 'twentyten' ),
		'id' => 'fourth-footer-widget-area',
		'description' => __( 'The fourth footer widget area', 'twentyten' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'loupe_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function loupe_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	// $tag_list = get_the_tag_list( '', ' | ' );
	//if ( $tag_list ) {
		//$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. ', 'loupe' );
	// } 
/*	 if ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ' | ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
	*/
}


endif;
//load jQuery and scripts
function my_init() {
	if (!is_admin()) {
		//wp_deregister_script('jquery');
		//wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', false, '1.3.2');
		wp_enqueue_script('jquery');
		wp_register_script('cookie',get_bloginfo('template_directory') . '/scripts/cookie.js', array('jquery'), '1.0',false);
		wp_enqueue_script('cookie');
		wp_register_script('cycle', get_bloginfo('template_directory') . '/scripts/cycle.js', array('jquery'), '1.0',false);
		wp_enqueue_script('cycle');
		wp_register_script('loupe', get_bloginfo('template_directory') .'/scripts/loupe.js', array('jquery'), '1.0',false);
		wp_enqueue_script('loupe');
		wp_register_script('history', get_bloginfo('template_directory') .'/scripts/history.js', array('jquery'), '1.0',false);
		wp_enqueue_script('history');
		if (is_single('gallery')) {
		wp_register_script('galleria', get_bloginfo('template_directory') . '2/scripts/galleria.js', array('jquery'), '2.0',false);
		wp_enqueue_script('galleria');
		}
		if (is_page('home')) {
		
		}

	}

	if (is_admin()) {
		wp_register_script('Gmaps', 'http://maps.google.com/maps/api/js?sensor=false', false, '3.0', false);
		wp_enqueue_script('Gmaps');
		
		wp_register_script('Zmaps', get_bloginfo('template_directory') .'/scripts/maps.js', array('Gmaps'), '1.0',false);
		wp_enqueue_script('Zmaps');
		
		wp_register_style('admin_css', get_bloginfo('template_directory') . '/css/adminstuff.css');
		wp_enqueue_style('admin_css');
		
	//	wp_register_style('ui_css', get_bloginfo('template_directory') . '/css/jquery-ui-1.8.13.custom.css');
	//	wp_enqueue_style('ui_css');		
		
	//	wp_register_script('ui',get_bloginfo('template_directory') . '/scripts/jquery-ui-1.8.13.custom.min.js', array('jquery'), '1.8',false);
	//	wp_enqueue_script('ui');
		
	//	wp_register_script('auto',get_bloginfo('template_directory') . '/scripts/geo_autocomplete.js', array('ui'), '2.1',false);
	//	wp_enqueue_script('auto');
		
		}

}
add_action('init', 'my_init');


//deactivate WordPress function
remove_shortcode('gallery', 'gallery_shortcode');

//activate own function
add_shortcode('gallery', 'z_gallery_shortcode');

function drop_tags()
{
    echo "<div id=\"dropTags\"><select>";
    echo "<option>Tags</option>\n";
    foreach (get_the_tags() as $tag)
    {
		
        echo "<option class=\"".$tag->slug."\">".$tag->name."</option>\n";
	
    }
    echo "</select></div>";
}



function z_gallery_shortcode($attr) {
	global $post, $wp_locale;
	static $instance = 0;
	$instance++;

	// Allow plugins/themes to override the default gallery template.
	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;

	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}

	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}
	if ( empty($attachments) )
		return '';
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}
	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = "gallery-{$instance}";
	$output = apply_filters('gallery_style', "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div id='$selector' class='gallery galleryid-{$id}'>");

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);

		$output .= "<{$itemtag} class='gallery-item'>";
		$output .= "
			<{$icontag} class='gallery-icon'>
				$link
			</{$icontag}>";
		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</{$captiontag}>";
		}
		$output .= "</{$itemtag}>";
		if ( $columns > 0 && ++$i % $columns == 0 )
			$output .= '<br style="clear: both" />';
	}
	$output .= "
			<br style='clear: both;' />
		</div>\n";
	return $output;
}


// AUTOMATICALLY EXTRACT THE FIRST IMAGE FROM THE POST 
/* http://bavotasan.com/tutorials/retrieve-the-first-image-from-a-wordpress-post/
function getImage($num) {
    global $more;
    $more = 1;
    $link = get_permalink();
    $content = get_the_content();
    $count = substr_count($content, '<img');
    $start = 0;
    for($i=1;$i<=$count;$i++) {
        $imgBeg = strpos($content, '<img', $start);
        $post = substr($content, $imgBeg);
        $imgEnd = strpos($post, '>');
        $postOutput = substr($post, 0, $imgEnd+1);
        $postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '',$postOutput);;
        $image[$i] = $postOutput;
        $start=$imgEnd+1;
    }
    if(stristr($image[$num],'<img')) { echo '<a href="'.$link.'">'.$image[$num]."</a>"; }
    $more = 0;
}
*/
// Get URL of first image in a post
//http://wordpress.org/support/topic/is-this-an-exploit-in-post-thumb-revisited

function catch_that_image() {
global $post, $posts;
$first_img = '';
ob_start();
ob_end_clean();
$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
$first_img = $matches [1] [0];
// no image found display default image instead
if(empty($first_img)){
$first_img = "";
}
return $first_img;
}



function bm_extract_string($start, $end, $original) {
$original = stristr($original, $start);
$trimmed = stristr($original, $end);
return substr($original, strlen($start), -strlen($trimmed));
}

function getFirstImage() {
$content = get_the_content();
$pic_string = bm_extract_string('src="','" ',$content);
list($width, $height, $type, $attr) = getimagesize($pic_string);
$link = get_permalink();
$title = get_the_title($post->post_title);
echo '<a href="'.$link.'" style="background:url('.$pic_string.'); display:block; width:'.$width.'px; height:'.$height.'px;" title="'.$title.'"></a>';
 $p = get_post($post_id);
			$template = get_bloginfo('template_url');
            echo "<li>";
			echo $p->post_content;
            echo "<a href='".get_permalink($post_id)."' title='". $p->post_title ."'>" . $p->post_title . "</a> ";
			echo "<a href='".get_permalink($post_id)."' title='". $p->post_title ."'> <img src='".$template."/scripts/timthumb.php?src=";
			echo favorite_image();
			echo "&w=140&h=120&zc=1&q=80' /></a>";
            wpfp_remove_favorite_link($post_id);
            echo "</li>";
			
			}
//return the first image, <img/> tag and all.
function first_image($width=100,$height=100,$zoomcrop=1){
	$timthumb_url = get_first_image($width, $height, $zoomcrop);
	if(isset($timthumb_url)){
		?>
		<a href="<?php the_permalink()?>" class="thumbnail" title="Links to: <?php the_title()?>">
			<img src="<?php echo $timthumb_url?>" alt="<?php the_title() ?>" class="thumbnail"/>
		</a>
		<?php
	}
}

//return just the src for the first image whether that be in the content or an attachment
function get_first_image($width=100,$height=100,$zoomcrop=1){
	$tn_src = get_first_content_image();
	if (!isset($tn_src)) //no image? try getting an attached image instead (native media galleries inserted into posts use attachments)
		$tn_src = get_first_attachment();

	if(isset($tn_src))
		$timthumb_url = get_bloginfo('template_url').'/scripts/timthumb.php?src='.$tn_src.'&h='.$height.'&w='.$width.'&zc='.$zoomcrop;
	else
		unset($timthumb_url);

	return $timthumb_url;
}

//return just the src for the first image buried in the post's textual content.
function get_first_content_image() {
	global $post, $posts;
	$first_img = '';
	$url = get_bloginfo('url');
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];

	$not_broken = @fopen("$first_img","r"); // checks if the image exists
	if(empty($first_img) || !($not_broken)){ //Defines a default image
		unset($first_img);
	}else{
		$first_img = str_replace($url, '', $first_img);
	}
	return $first_img;
}

//return just the src for the first image attachment
function get_first_attachment(){
	$querystr =
	"
		SELECT
				wp_posts.post_excerpt AS 'imageTitle'
			,	wp_posts.guid AS 'imageGuid'
		FROM
			wp_posts
		WHERE
				wp_posts.post_parent = ".get_the_ID()."
			AND	wp_posts.post_type = \"attachment\"
		ORDER BY \"menu_order\"
		LIMIT 1
	";
	global $wpdb;
	$url = get_bloginfo('url');

	$post_item = $wpdb->get_row($querystr);
	$first_attachment = $post_item->imageGuid;

	$not_broken = @fopen("$first_attachment","r"); // checks if the image exists
	if(empty($first_attachment) || !($not_broken)){ //Defines a default image
		unset($first_attachment);
	}else{
		$first_attachment = str_replace($url, '', $first_attachment);
	}

	return $first_attachment;
}

/*
// This is added in to remove image if it is added in post as well
add_filter( 'the_content', 'remove_first_image' );

// This is the function name
function remove_first_image($content) {
global $post, $posts;

// This is the preg replace that removes the first image

$content = preg_replace('/]+./',  ob_get_contents(),'',1);
return $content;
}

*/

// this is another attmept
function grab_image_attachment() {
$images =& get_children( 'post_type=attachment&post_mime_type=image' );

$videos =& get_children( 'post_type=attachment&post_mime_type=video/mp4' );

if ( empty($images) ) {
	// no attachments here
} else {
	foreach ( $images as $attachment_id => $attachment ) {
		echo wp_get_attachment_image( $attachment_id, 'full' );
	}
}

//  If you don't need to handle an empty result:

foreach ( (array) $videos as $attachment_id => $attachment ) {
	echo wp_get_attachment_link( $attachment_id );
}	
}

/* Define the custom box */

// WP 3.0+
// add_action('add_meta_boxes', 'myplugin_add_custom_box');

// backwards compatible
add_action('admin_init', 'myplugin_add_custom_box', 1);

/* Do something with the data entered */
add_action('save_post', 'myplugin_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function myplugin_add_custom_box() {
    add_meta_box( 'myplugin_sectionid', __( 'My Post Section Title', 'myplugin_textdomain' ), 
                'myplugin_inner_custom_box', 'post' );
    add_meta_box( 'myplugin_sectionid', __( 'My Post Section Title', 'myplugin_textdomain' ), 
                'myplugin_inner_custom_box', 'page' );
}

/* Prints the box content */
function myplugin_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

  // The actual fields for data entry
  echo '<label for="myplugin_new_field">' . __("Description for this field", 'myplugin_textdomain' ) . '</label> ';
  echo '<input type="text" id= "myplugin_new_field" name="myplugin_new_field" value="whatever" size="25" />';
}

/* When the post is saved, saves our custom data */
function myplugin_save_postdata( $post_id ) {

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }

  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
  // to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

  // OK, we're authenticated: we need to find and save the data

  $mydata = $_POST['myplugin_new_field'];

  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)

   return $mydata;
}

// wordpress 3.1 remove admin bar
add_filter( 'show_admin_bar', '__return_false' );

// custom fields - http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html

$meta_boxes = array(
   
    array(
        'id' => 'story',
        'title' => 'Description',
        'pages' => array('post', 'page' , 'link'), // custom post type
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => 'Describe the scene :',
                'id' => $prefix . 'textarea',
                'type' => 'textarea'
                
            )
        )
    ),
	
	
	 array(
        'id' => 'text-location',
        'title' => 'Location Data',
        'pages' => array('post', 'page', 'link'), // multiple post types
        'context' => 'normal',
        'priority' => 'high',
        'fields' => array(
            array(
                'name' => 'Text Location',
                'desc' => 'Enter location here',
                'id' => $prefix . 'text',
                'type' => 'text',
                'std' => ''
            )
        )
    )
);
foreach ($meta_boxes as $meta_box) {
    $my_box = new My_meta_box($meta_box);
}


class My_meta_box {

    protected $_meta_box;

    // create meta box based on given data
    function __construct($meta_box) {
        $this->_meta_box = $meta_box;
        add_action('admin_menu', array(&$this, 'add'));

        add_action('save_post', array(&$this, 'save'));
    }

    /// Add meta box for multiple post types
    function add() {
        foreach ($this->_meta_box['pages'] as $page) {
            add_meta_box($this->_meta_box['id'], $this->_meta_box['title'], array(&$this, 'show'), $page, $this->_meta_box['context'], $this->_meta_box['priority']);
        }
    }

    // Callback function to show fields in meta box
    function show() {
        global $post;

        // Use nonce for verification
        echo '<input type="hidden" name="mytheme_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';
    
        echo '<table class="form-table">';

        foreach ($this->_meta_box['fields'] as $field) {
            // get current post meta data
            $meta = get_post_meta($post->ID, $field['id'], true);
        
            echo '<tr>',
                    '<th style="width:20%"><label for="', $field['id'], '">', $field['name'], '</label></th>',
                    '<td>';
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" />',
                        '<br />', $field['desc'];
                    break;
                case 'textarea':
                    echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>',
                        '<br />', $field['desc'];
                    break;
                case 'select':
                    echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                    foreach ($field['options'] as $option) {
                        echo '<option', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                    }
                    echo '</select>';
                    break;
                case 'radio':
                    foreach ($field['options'] as $option) {
                        echo '<input type="radio" name="', $field['id'], '" value="', $option['value'], '"', $meta == $option['value'] ? ' checked="checked"' : '', ' />', $option['name'];
                    }
                    break;
                case 'checkbox':
                    echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                    break;
            }
            echo     '<td>',
                '</tr>';
        }
    
        echo '</table>';
    }

    // Save data from meta box
    function save($post_id) {
        // verify nonce
        if (!wp_verify_nonce($_POST['mytheme_meta_box_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // check permissions
        if ('page' == $_POST['post_type']) {
            if (!current_user_can('edit_page', $post_id)) {
                return $post_id;
            }
        } elseif (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        foreach ($this->_meta_box['fields'] as $field) {
            $old = get_post_meta($post_id, $field['id'], true);
            $new = $_POST[$field['id']];
    
            if ($new && $new != $old) {
                update_post_meta($post_id, $field['id'], $new);
            } elseif ('' == $new && $old) {
                delete_post_meta($post_id, $field['id'], $old);
            }
        }
    }
}


// http://thinkvitamin.com/code/create-your-first-wordpress-custom-post-type/

add_action('init', 'portfolio_register');
 
function portfolio_register() {
 
	$labels = array(
		'name' => _x('Photos', 'post type general name'),
		'singular_name' => _x('Portfolio Item', 'post type singular name'),
		'add_new' => _x('Add New', 'portfolio item'),
		'add_new_item' => __('Add New Portfolio Item'),
		'edit_item' => __('Edit Portfolio Item'),
		'new_item' => __('New Portfolio Item'),
		'view_item' => __('View Portfolio Item'),
		'search_items' => __('Search Portfolio'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		//'menu_icon' => get_stylesheet_directory_uri() . '/article16.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 4,
		'taxonomies' => array('post_tag','category'),
		'supports' => array('title','editor','comments','trackbacks','revisions','custom-fields','page-attributes','thumbnail', 'excerpt', 'tags')
	  ); 
 
	register_post_type( 'portfolio' , $args );
}



add_action("admin_init", "admin_init");
 
function admin_init(){ // add_meta_box( $id, $title, $callback, $page, $context, $priority ); 
  add_meta_box("year_completed-meta", "Year Completed", "year_completed", "portfolio", "side", "low");
  add_meta_box("map_meta", "Mapping Info", "map_meta", "portfolio", "normal", "high");
}
 
function year_completed(){
  global $post;
  $custom = get_post_custom($post->ID);
  $year_completed = $custom["year_completed"][0];
  ?>
  <label>Year:</label>
  <input name="year_completed" value="<?php echo $year_completed; ?>" />
  <?php
}
 
function map_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $latitude = $custom["latitude"][0];
  $longitude = $custom["longitude"][0];
  $producers = $custom["producers"][0];
  ?>
<div id="mapControls">
<div class="lat">
  <p><label for="lat">Latitude:</label><br />
  <input id="latitude"  name="latitude" value="<?php echo $latitude; ?>"></input></p>
 </div>
 <div class="lng">
  <p><label>Longitude:</label><br />
  <input id="longitude" name="longitude" value="<?php echo $longitude; ?>"></input></p>
 </div>
  <!-- <input type="text" value="" id="searchbox" style=" width:800px;height:30px; font-size:15px;"> -->
  	<?php
  	$lat = get_post_meta($post->ID, 'latitude', true);
if ($lat !== '') { ?>

  	<div class="cur1">Current lat : <?php echo $latitude; ?> long: <?php echo $longitude; ?></div>
 <? } ?>


 </div>
 <div class="clearfix" id="mapFix">&nbsp;</div>
  	<div id="map_canvas" style="width:98%; height:350px; margin-left: 10px;"></div>

  
  <?php
}



global $post;
	

$custom = get_post_custom($post->ID);

add_action('save_post', 'save_details');

function save_details(){
  global $post;

  update_post_meta($post->ID, "latitude", $_POST["latitude"]);
  update_post_meta($post->ID, "longitude", $_POST["longitude"]);
  update_post_meta($post->ID, "producers", $_POST["producers"]);
}


