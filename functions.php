<?php
/**
 *
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
		
	//	wp_register_script('loupe', get_bloginfo('template_directory') .'/scripts/loupe.js', array('jquery'), '1.0',false);
	//	wp_enqueue_script('loupe');
	wp_enqueue_script( 'Gmaps', 'http://maps.google.com/maps/api/js?sensor=false' );
		    wp_enqueue_script( 'maps_scripts',  get_bloginfo('template_directory') . '/scripts/maps.js' );
		wp_register_script('history', get_bloginfo('template_directory') .'/scripts/history.js', array('jquery'), '1.0',false);
		wp_enqueue_script('history');
	
	
	}

	 if (is_page('home')) {
		wp_register_script('cycle', get_bloginfo('template_directory') . '/scripts/cycle.js', array('jquery'), '1.0',false);
		wp_enqueue_script('cycle');
		}
	
	
    if (is_admin()) {
    	// move below this } when ready for maps 
		wp_register_script('Gmaps', 'http://maps.google.com/maps/api/js?sensor=false', false, '3.0', false);
		wp_enqueue_script('Gmaps');
		
		
        wp_register_style('admin_js', get_bloginfo('template_directory') . '/admin.js');
		wp_enqueue_script('admin_js');

		wp_register_script('Zmaps', get_bloginfo('template_directory') .'/scripts/maps.js', array('Gmaps'), '1.0', true);
		wp_enqueue_script('Zmaps');
		
			
		wp_register_style('admin_css', get_bloginfo('template_directory') . '/css/adminstuff.css');
		wp_enqueue_style('admin_css');

		
		}
	
}

add_action('wp_enqueue_scripts', 'my_init');
add_action( 'admin_print_scripts-post-new.php', 'portfolio_admin_script', 11 );
	function portfolio_admin_script() {
	global $post;
	global $post_type;
	if((get_post_type($post->ID) == 'portfolio') || ('portfolio' == $post_type)) {
	
			wp_enqueue_script( 'Gmaps', 'http://maps.google.com/maps/api/js?sensor=false&amp;libraries=places' );
		    wp_enqueue_script( 'maps_scripts',  get_bloginfo('template_directory') . '/scripts/maps.js' );
	}	
}

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


// wordpress 3.1 remove admin bar on frontend
add_filter( 'show_admin_bar', '__return_false' );

//http://wordpress.stackexchange.com/questions/13237/custom-post-type-tag-archives-dont-work-for-basic-loop

function post_type_tags_fix($request) {
    if ( isset($request['tag']) && !isset($request['post_type']) )
    $request['post_type'] = 'any';
    return $request;
} 
add_filter('request', 'post_type_tags_fix');

// http://thinkvitamin.com/code/create-your-first-wordpress-custom-post-type/

add_action('init', 'photo_register');
 
function photo_register() {
 
	$labels = array(
		'name' => _x('My Photos', 'post type general name'),
		'singular_name' => _x('Photo', 'post type singular name'),
		'add_new' => _x('Add New', 'photo item'),
		'add_new_item' => __('Add New Photo'),
		'edit_item' => __('Edit Photo'),
		'new_item' => __('New Photo'),
		'view_item' => __('View Photo'),
		'search_items' => __('Search Photos'),
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
		'supports' => array('title','comments','trackbacks','revisions','custom-fields','page-attributes','thumbnail', 'excerpt', 'tags')
	  ); 
 
	register_post_type( 'photo' , $args );
	register_taxonomy("Photos", array("photo"), array("hierarchical" => true, "label" => "Photos", "singular_label" => "Photo", "rewrite" => true));

	
}



add_action("admin_init", "admin_init");
add_action('save_post', 'save_details');

function admin_init(){ // add_meta_box( $id, $title, $callback, $page, $context, $priority ); 
  add_meta_box("media", "Media Type", "media", "photo", "side", "high");
  add_meta_box("map_meta", "Mapping Info", "map_meta", "photo", "normal", "high");
  add_meta_box("photo_meta", "Add a photograph", "photo_meta", "photo", "normal", "high");
}
 
function media(){
  global $post;
  $custom = get_post_custom($post->ID);
  $film = $custom["film"][0];
  $camera = $custom["camera"][0];
 
  ?>
  <label>Camera:</label>
  <input name="camera" value="<?php echo $camera; ?>" />
  
    <label>Film:</label>
  <input name="film" value="<?php echo $film; ?>" />
  
  <?php
}

function photo_meta(){
  global $post;
  $custom = get_post_custom($post->ID);
  $single_photo = $custom["single_photo"][0];
  ?>
  
  <div id="singleUpload">
  	<div class="sUcallback"> 
  		<img src="<?php echo $single_photo; ?>" width="200" /> 		
  	</div>
  	<div class="sUinput">
  		<input id="single_photo" name="single_photo" value="<?php echo $single_photo; ?>" />
  	</div>
  	<div class="sUbutton">
  	<input type="button" value="Upload" name="upload" id="upload_image_button" />
  	</div>
  </div>
  
  <?php
}


function map_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $latitude = $custom["latitude"][0];
  $longitude = $custom["longitude"][0];

  ?>
<div id="mapControls">
	
	<div class="latlong">
		<p><label for="lat">Latitude, Longitude:</label><br />
	  <input id="latlong"  name="latlong" value="<?php echo $latlong; ?>"></input></p>
	</div>
<div class="lat">
  <p><label for="lat">Latitude:</label><br />
  <input id="latitude"  name="latitude" value="<?php echo $latitude; ?>"></input></p>
 </div>
 <div class="lng">
  <p><label>Longitude:</label><br />
  <input id="longitude" name="longitude" value="<?php echo $longitude; ?>" ></input></p>
 </div>

  	<?php
  	$lat = get_post_meta($post->ID, 'latitude', true);
if ($lat !== '') { ?>
  	<div class="cur1">Current lat : <?php echo $latitude; ?> long: <?php echo $longitude; ?></div>
 <? } ?>
 </div>
   <input type="text" value="" id="searchTextField" style=" width:98%;height:30px; font-size:15px;" onKeyPress="return disableEnterKey(event)"> 
 <div class="clearfix" id="mapFix">&nbsp;</div>
  	<div id="map_canvas" style="width:98%; height:350px;"></div>
<script language="JavaScript">
function disableEnterKey(e)
		{
		     var key;     
		     if(window.event)
		          key = window.event.keyCode; //IE
		     else
		          key = e.which; //firefox     
		     return (key != 13);
		}
</script>
  <?php
}

function my_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_register_script('my-upload', get_bloginfo('template_url') . '/scripts/uploadScript.js', array('jquery','media-upload','thickbox'));
wp_enqueue_script('my-upload');
wp_enqueue_script( 'Gmaps', 'http://maps.google.com/maps/api/js?sensor=false&amp;libraries=places' );
wp_enqueue_script( 'maps_scripts',  get_bloginfo('template_directory') . '/scripts/maps.js' );			
}

function my_admin_styles() {
wp_enqueue_style('thickbox');
}
add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');




function save_details($post_id){
    global $post;
      update_post_meta($post_id, "single_photo", $_POST["single_photo"]);
	  update_post_meta($post_id, "latlong", $_POST["latlong"]);
	  update_post_meta($post_id, "latitude", $_POST["latitude"]);
	  update_post_meta($post_id, "longitude", $_POST["longitude"]);
	  update_post_meta($post_id, "camera", $_POST["camera"]);
	  update_post_meta($post_id, "film", $_POST["film"]);
   
}


  /*
  update_post_meta($post->ID, "single_photo", $_POST["single_photo"]);
  update_post_meta($post->ID, "latlong", $_POST["latlong"]);
  update_post_meta($post->ID, "latitude", $_POST["latitude"]);
  update_post_meta($post->ID, "longitude", $_POST["longitude"]);
  update_post_meta($post->ID, "camera", $_POST["camera"]);
  update_post_meta($post->ID, "film", $_POST["film"]);
}
*/
//return just the src for the first image attachment // used for tag thumbs v3
function get_first_attachment(){
	$querystr =
	"
	SELECT
	wp_posts.post_excerpt AS 'imageTitle',
	wp_posts.guid AS 'imageGuid'
	FROM
	wp_posts
	WHERE
	wp_posts.post_parent = ".get_the_ID()."
	AND wp_posts.post_type = \"attachment\"
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
?>
