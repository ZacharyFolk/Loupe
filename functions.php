<?php
/**
 *
 * @since The Loupe 0.1
 * The Loupe functions and definitions
 */


if ( ! isset( $content_width ) )
	$content_width = 640;

add_action( 'after_setup_theme', 'loupe_setup' );

if ( ! function_exists( 'loupe_setup' ) ):

function loupe_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

}
endif;

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function loupe_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'loupe_remove_recent_comments_style' );

if ( ! function_exists( 'loupe_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function loupe_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'loupe' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'loupe' ), get_the_author() ),
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
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'loupe' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'loupe' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'loupe' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;



function loupe_filter_wp_title( $title, $separator ) {
	// Don't affect wp_title() calls in feeds.
	if ( is_feed() )
		return $title;

	// The $paged global variable contains the page number of a listing of posts.
	// The $page global variable contains the page number of a single post that is paged.
	// We'll display whichever one applies, if we're not looking at the first page.
	global $paged, $page;

	if ( is_search() ) {
		// If we're a search, let's start over:
		$title = sprintf( __( 'Search results for %s', 'loupe' ), '"' . get_search_query() . '"' );
		// Add a page number if we're on page 2 or more:
		if ( $paged >= 2 )
			$title .= " $separator " . sprintf( __( 'Page %s', 'loupe' ), $paged );
		// Add the site name to the end:
		$title .= " $separator " . get_bloginfo( 'name', 'display' );
		// We're done. Let's send the new title back to wp_title():
		return $title;
	}

	// Otherwise, let's start by adding the site name to the end:
	$title .= get_bloginfo( 'name', 'display' );

	// If we have a site description and we're on the home/front page, add the description:
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title .= " $separator " . $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title .= " $separator " . sprintf( __( 'Page %s', 'loupe' ), max( $paged, $page ) );

	// Return the new title to wp_title():
	return $title;
}
add_filter( 'wp_title', 'loupe_filter_wp_title', 10, 2 );



//load scripts
//wp_register_script( $handle, $src, $deps, $ver, $in_footer );

add_action( 'wp_enqueue_scripts', 'load_scripts' );

function load_scripts() {		
	if ( ! is_admin() ) {				
		wp_register_script( 'modernizr', get_template_directory_uri() .  '/scripts/modernizr-latest.js', false);
		wp_enqueue_script( 'modernizr' );
		wp_register_script( 'ui', get_template_directory_uri() . '/scripts/jqueryui.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'ui' );
		wp_register_script( 'wheel', get_template_directory_uri() . '/scripts/jquery.mousewheel.min.js', array( 'ui' ), false, true );
		wp_enqueue_script( 'wheel' );	
		wp_register_script( 'viewer', get_template_directory_uri() . '/scripts/iViewer.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'viewer' );						
		wp_register_script( 'cookie', get_template_directory_uri() . '/scripts/cookie.js', array('jquery'), false, true );
		wp_enqueue_script( 'cookie' );
		wp_register_script( 'cycle', get_template_directory_uri() . '/scripts/cycle.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'cycle' );
	/*	wp_register_script( 'Gmaps', 'http://maps.googleapis.com/maps/api/js?key=AIzaSyAO4akxImeh2-g3XNOpcSYgKZXiOeR6220&sensor=true', array(), false, true );
		wp_enqueue_script ( 'Gmaps' );	
	 	wp_register_script( 'maps_front',  get_template_directory_uri() . '/scripts/mapFront.js', array( 'Gmaps' ), false, false );
		wp_enqueue_script ( 'maps_front' );	
	*/		
		wp_register_script( 'history', get_template_directory_uri() . '/scripts/history.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'history' );				
	}
	if ( is_page ( 'home' ) ) {
		wp_register_script( 'cycle', get_template_directory_uri() . '/scripts/cycle.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_script( 'cycle' );
	}
	/*
	 * 
	 * 
<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/jquery.mousewheel.min.js" ></script>
<script type="text/javascript" src="<?php bloginfo('template_url');?>/scripts/iViewer.js" ></script>
	 * 
	 * 
	wp_register_script( 'plugins', get_template_directory_uri() . '/scripts/plugins.js', array(), false, true );
	wp_enqueue_script( 'plugins' );		
	 
	 * */
}

function my_admin_scripts() {
	wp_enqueue_script( 'media-upload' );
	wp_enqueue_script( 'thickbox' );
	wp_enqueue_script( 'Gmaps', 'http://maps.google.com/maps/api/js?sensor=false&amp;libraries=places' );
	wp_register_script( 'image_upload', get_template_directory_uri() . '/scripts/uploadScript.js', array( 'jquery', 'media-upload', 'thickbox' ) );
	wp_enqueue_script( 'image_upload' );
	wp_enqueue_script( 'maps_scripts', get_template_directory_uri() . '/scripts/maps.js' );
	wp_enqueue_script( 'maps_scripts' );
	wp_register_script( 'exif', get_template_directory_uri() .  '/scripts/exifGrab.js', array( 'jquery' ) );
	wp_enqueue_script( 'exif' );			
}

function my_admin_styles() {
	wp_register_style( 'admin-style', get_template_directory_uri() . '/css/adminstuff.css' );
	wp_enqueue_style( 'admin-style' );
	wp_enqueue_style( 'thickbox' );
	}

	add_action( 'admin_print_scripts', 'my_admin_scripts' );
	add_action( 'admin_print_styles', 'my_admin_styles' );
/*
function portfolio_admin_script() {
	global $post;
	global $post_type;
	if((get_post_type($post->ID) == 'portfolio') || ('portfolio' == $post_type)) {
		wp_enqueue_script( 'Gmaps', 'http://maps.google.com/maps/api/js?sensor=false&amp;libraries=places' );
		wp_enqueue_script( 'maps_scripts',  get_template_directory_uri() . '/scripts/maps.js' );
	}	
}
*/
//deactivate WordPress function
remove_shortcode( 'gallery', 'gallery_shortcode' );

//activate own function
add_shortcode( 'gallery', 'z_gallery_shortcode' );

//************** Register sidebars and widgetized areas.

function loupe_widgets_init() {
	 register_sidebar(array(
    'name' => __('Primary Sidebar (Posts)', 'loupe'),
    'id' => 'sidebar-1',
	'before_widget' =>'',
	'after_widget' => '',
	'before_title' => '<div class="widgetTitle">',
	'after_title' => '</div>',
	));
	}
add_action( 'widgets_init', 'loupe_widgets_init' );

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

function printExifData() {
	global $post;
	$custom = get_post_custom( $post->ID );
	$single_photo = $custom["single_photo"][0];
	$exif = read_exif_data( $single_photo );	
		while(list($k,$v)=each($exif)) {	
		if($k=="DateTimeOriginal") {
			$datetime = $v;
			list($fulldate, $fulltime) = explode(' ', $datetime, 2);
			list($year, $monthnum, $day) = explode(':', $fulldate, 3);
			list($hour, $minute, $second) = explode(':', $fulltime, 3);
			$num[0] = "/01/";
			$num[1] = "/02/";
			$num[2] = "/03/";
			$num[3] = "/04/";
			$num[4] = "/05/";
			$num[5] = "/06/";
			$num[6] = "/07/";
			$num[7] = "/08/";
			$num[8] = "/09/";
			$num[9] = "/10/";
			$num[10] = "/11/";
			$num[11] = "/12/";
			$alpha[0] = "January";
			$alpha[1] = "February";
			$alpha[2] = "March";
			$alpha[3] = "April";
			$alpha[4] = "May";
			$alpha[5] = "June";
			$alpha[6] = "July";
			$alpha[7] = "August";
			$alpha[8] = "September";
			$alpha[9] = "October";
			$alpha[10] = "November";
			$alpha[11] = "December";
			$month = preg_replace($num, $alpha, $monthnum);
				if ($hour >=13) {
				$cleanhour = $hour -12; 
				}
			echo "Taken: $day $month $year at $cleanhour:$minute "; 
				if ($hour >=13) { echo "PM"; } else { echo "AM"; } echo "<br>\n"; 
			}
			if($k=="Make") { echo "Camera: "; if($v!="Canon") { echo "$v ";} }
			if($k=="Model") { echo "$v<br>\n"; }
			if($k=="ExposureTime") { $exposure = $v;
			if($exposure != "")
			{
			$exposure2 = split("/",$exposure);
			if(count($exposure2) == 2)
			{
			$exposure = round($exposure2[0]/$exposure2[1],2);
			if($exposure < 1) $exposure = '1/'.round($exposure2[1]/$exposure2[0],0);
			}
			$exposure = "$lang_exposure $exposure";
			}
			echo "Shutter Speed: $exposure sec<br>\n"; }
			if($k=="FNumber") { $fstop = $v;
			if($fstop != "")
			{
			$fstop = split("/",$fstop);
			if(count($fstop) == 2) $fstop = round($fstop[0]/$fstop[1],2);
			$focal = "$lang_focal $fstop";
			}
			echo "Aperture: f/$fstop<br>\n"; }
			if($k=="ISOSpeedRatings") { echo "ISO Speed: $v<br>\n"; }
			if($k=="FocalLength") { $focal = $v;
			if($focal != "")
			{
			$focal = split("/",$focal);
			if(count($focal) == 2) $focal = round($focal[0]/$focal[1],2);
			$focal = "$lang_focal $focal mm";
			}
		echo "Focal Length: $focal<br>\n"; }
		}
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

	extract(shortcode_atts( array (
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
	), $attr) );

	$id = intval( $id );
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty( $include ) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty( $exclude ) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}
	if ( empty( $attachments ) )
		return '';
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}
	$itemtag = tag_escape($itemtag);
	$captiontag = tag_escape($captiontag);
	$columns = intval($columns);
	$itemwidth = $columns > 0 ? floor(100/$columns) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = "gallery-{$instance}";
	$output = apply_filters( 'gallery_style', "
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
		$link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link( $id, $size, true, false );

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
add_filter( 'request', 'post_type_tags_fix' );

// http://thinkvitamin.com/code/create-your-first-wordpress-custom-post-type/

add_action( 'init', 'photo_register' );
 
function photo_register() {
	$labels = array(
		'name' => _x( 'My Photos', 'post type general name' ),
		'singular_name' => _x( 'Photo', 'post type singular name' ),
		'add_new' => _x( 'Add New', 'photo item' ),
		'add_new_item' => __( 'Add New Photo' ),
		'edit_item' => __( 'Edit Photo' ),
		'new_item' => __( 'New Photo' ),
		'view_item' => __( 'View Photo' ),
		'search_items' => __( 'Search Photos' ),
		'not_found' =>  __( 'Nothing found' ),
		'not_found_in_trash' => __( 'Nothing found in Trash' ),
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
		'taxonomies' => array( 'post_tag', 'category' ),
		'supports' => array( 'title', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'thumbnail', 'excerpt', 'tags' )
		); 
 
	register_post_type( 'photo' , $args );
	register_taxonomy( 'Photos', array( 'photo' ), array( 'hierarchical' => true, 'label' => 'Photos', 'singular_label' => 'Photo', 'rewrite' => true ) );
}

	add_action( 'admin_init', 'admin_init' );
	add_action( 'save_post', 'save_details' );

function admin_init(){ // add_meta_box( $id, $title, $callback, $page, $context, $priority ); 
	  add_meta_box( 'media', 'Media Type', 'media', 'photo', 'side', 'high' );
	  add_meta_box( 'photowords', 'Words', 'photowords', 'photo', 'normal', 'high' );
	  add_meta_box( 'photo_meta', 'Add a photograph', 'photo_meta', 'photo', 'normal', 'high' );
	  add_meta_box( 'map_meta', 'Map It', 'map_meta', 'photo', 'normal', 'high' );
	}
 
function media(){
	global $post;
	$custom = get_post_custom($post->ID);
	$film = $custom["film"][0];
	$camera = $custom["camera"][0]; 
	$single_photo = $custom["single_photo"][0];?>
		
	<div style="width: 100%" class="clearfix">
		<div class="mediaRow">
		<label>Camera:</label>
		<input name="camera" value="<?php echo $camera; ?>" />
		</div>
		
		<div class="mediaRow">
		<label>Film:</label>
		<input name="film" value="<?php echo $film; ?>" />
		</div>
		
		
<?php 

if ( $single_photo ) { printExifData(); } ?>

	</div>
	
<?php }

function photo_meta(){
	global $post;
	$custom = get_post_custom( $post->ID );
	$single_photo = $custom["single_photo"][0];
	$isFeatured = $custom["isFeatured"][0];
?>

	<div id="singleUpload" class="clearfix">
		<div class="sUcallback"> 
	  		<img src="<?php echo $single_photo; ?>" width="200" exif="true" class="cbImg"/> 

		</div>
	  	<div class="sUinput">	  
	  		<input id="single_photo" name="single_photo" value="<?php echo $single_photo; ?>" />
	  	</div>
	  	<div class="sUbutton">
	  		<input type="button" value="Upload" name="upload" id="upload_image_button" />
	  	</div>
	  	<div class="sUcheckbox">
	  		<label class="selectit"> 
	  			<?php if ( $isFeatured == 1 ) {?> 
	  			<input id="isFeatured" type="checkbox" checked="yes" name="isFeatured" value="1"> Featured Photo? 
	  			<?php } else { ?> 
	  			<input id="isFeatured" type="checkbox" name="isFeatured" value="1"> Featured Photo? 
	  			<?php } ?> 
	  		</label> 
	</div>  
<?php }


function photowords(){
	global $post;
	$custom = get_post_custom($post->ID);
	$photowords = $custom["photowords"][0];
?>	
	<div style="width: 100%" >
		<div class="photoText">
		<textarea name="photowords" value="<?php echo $photowords; ?>" style="width: 100%">
			<?php echo $photowords; ?>
		</textarea>
		</div>
	
<?php }


function map_meta() {
  global $post;
  $custom = get_post_custom( $post->ID );
  $latitude = $custom["latitude"][0];
  $longitude = $custom["longitude"][0];
  ?>

   <input type="text" value="" id="searchTextField" style="width:98%; height:30px; font-size:15px;" onKeyPress="return disableEnterKey(event)" />
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix" id="mapFix">
		<div id="map_canvas" style="width:98%; height:350px;"></div>
	</div>
	
	<div id="mapControls">
		
		<div class="lat">
		  <p><label for="lat">Latitude:</label>
		  <input id="latitude"  name="latitude" value="<?php echo $latitude; ?>"></input></p>
		</div>
		<div class="lng">
		  <p><label>Longitude:</label>
		  <input id="longitude" name="longitude" value="<?php echo $longitude; ?>" ></input></p>
		</div>
 	</div>
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
<?php }

function save_details( $post_id ){
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	global $post;
	update_post_meta($post_id, "single_photo", $_POST["single_photo"]);
	update_post_meta($post_id, "isFeatured", $_POST["isFeatured"]);
	update_post_meta($post_id, "photowords", $_POST["photowords"]); 
	//update_post_meta($post_id, "latlong", $_POST["latlong"]);
	update_post_meta($post_id, "latitude", $_POST["latitude"]);
	update_post_meta($post_id, "longitude", $_POST["longitude"]);
	update_post_meta($post_id, "camera", $_POST["camera"]);
	update_post_meta($post_id, "film", $_POST["film"]); 
}

add_action("manage_posts_custom_column",  "photo_custom_columns");
add_filter("manage_edit-photo_columns", "photo_edit_columns");
 
function photo_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "title" => "Photo Title",
    "photo" => "Photo",
    "tags" => "Tags",
    "categories" => "Categories",
    "featured" => "Featured?",
    "date" => "Date"
  );
 
  return $columns;
}
function photo_custom_columns($column){
  global $post;
 
  switch ($column) {
  	
    case "photo":
	$custom = get_post_custom();
    $phoVar = $custom["single_photo"][0];
	echo '<img src="' . $phoVar . '" width="100" />'; 
    break; 
	
	case "featured":
	$featured = get_post_meta($post->ID, 'isFeatured', true);
	if ($featured == 1) {
	echo "Yes";
	}
	break;
  
  }
}

// for category archives
add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
  if(is_category() || is_tag()) {
    $post_type = get_query_var('post_type');
	if($post_type)
	    $post_type = $post_type;
	else
	    $post_type = array('post','photo'); // replace cpt to your custom post type
    $query->set('post_type',$post_type);
	return $query;
    }
}

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
	$url = get_bloginfo( 'url' );
	$post_item = $wpdb->get_row( $querystr );
	$first_attachment = $post_item->imageGuid;
	$not_broken = @fopen("$first_attachment","r"); // checks if the image exists
	if( empty( $first_attachment ) || !( $not_broken ) ){ //Defines a default image
	unset( $first_attachment );
	}else{
	$first_attachment = str_replace( $url, '', $first_attachment );
	}
	return $first_attachment;
	}
?>
