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
	  add_meta_box("photo_meta", "Add a photograph", "photo_meta", "photo", "normal", "high");
	  add_meta_box("map_meta", "Map It", "map_meta", "photo", "normal", "high");
	}
 
function media(){
  global $post;
  $custom = get_post_custom($post->ID);
  $film = $custom["film"][0];
  $camera = $custom["camera"][0]; ?>
 
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
  $exif = wp_read_image_metadata( $single_photo ); 
  
  ?>
  
  <div id="singleUpload" class="clearfix">
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
<?php }

function map_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $latitude = $custom["latitude"][0];
  $longitude = $custom["longitude"][0];

  ?>

   <input type="text" value="" id="searchTextField" style=" width:98%;height:30px; font-size:15px;" onKeyPress="return disableEnterKey(event)"> 
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
  <?php
}
function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', get_bloginfo('template_url') . '/scripts/uploadScript.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
	wp_register_script('exif', get_bloginfo('template_url') . '/scripts/exifGrab.js', array('jquery'));
	wp_enqueue_script('exif');
	wp_enqueue_script( 'Gmaps', 'http://maps.google.com/maps/api/js?sensor=false&amp;libraries=places' );
	wp_enqueue_script( 'maps_scripts',  get_bloginfo('template_directory') . '/scripts/maps.js' );			
}

function my_admin_styles() {
	wp_register_style('admin-style', get_bloginfo('template_url') . '/css/adminstuff.css');
	wp_enqueue_style('admin-style');
	wp_enqueue_style('thickbox');
	}

	add_action('admin_print_scripts', 'my_admin_scripts');
	add_action('admin_print_styles', 'my_admin_styles');


function save_details($post_id){
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    global $post;
      update_post_meta($post_id, "single_photo", $_POST["single_photo"]);
	  update_post_meta($post_id, "latlong", $_POST["latlong"]);
	  update_post_meta($post_id, "latitude", $_POST["latitude"]);
	  update_post_meta($post_id, "longitude", $_POST["longitude"]);
	  update_post_meta($post_id, "camera", $_POST["camera"]);
	  update_post_meta($post_id, "film", $_POST["film"]); 
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
