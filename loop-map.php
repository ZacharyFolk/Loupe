
<script type="text/javascript">

var infowindow = null;
var markers = [];

function initialize(){
	var getBrowserHeight = $(document).height();
	$('#travel_map').css('height',getBrowserHeight);
	var myLatlng = new google.maps.LatLng(45.911450311152244, -123.96832638891601);
     var myOptions = {
     		zoom: 5,
     		center: myLatlng,
     		mapTypeId: google.maps.MapTypeId.ROADMAP
        };
	
	var map = new google.maps.Map(document.getElementById('travel_map'), myOptions);

	<?php if ( have_posts() ) :  while ( have_posts() ) : the_post();
		$my_post = get_post($post_id);
		$mapTitle  = $my_post->post_title;
		$lat = get_post_meta($post->ID, 'latitude', true); 
		$long = get_post_meta($post->ID, 'longitude', true);
		$tturl = bloginfo('template_url') . '/scripts/timthumb.php?src=';
	 	?>
 
 	var contentString = 'test';
        
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
    
	 var marker = new google.maps.Marker({
	 	position: new google.maps.LatLng(<?php echo $lat . ", " . $long ?>),
	 	map: map,
	 	html: '<?php echo the_title(); ?><br /><img src="<?php bloginfo('template_url'); ?>/scripts/timthumb.php?src=<?php echo get_post_meta($post->ID, 'single_photo', true); ?>&w=240&h=240&zc=1"  />'
	 });
 	
 	markers.push(marker);
	google.maps.event.addListener(marker, 'click', function() {
	  infowindow.setContent(this.html);
	  infowindow.open(map,this);
	}); 

<?php endwhile;  ?>
<?php endif; ?>
}

</script>

	<div id="travel_map" ></div>
	