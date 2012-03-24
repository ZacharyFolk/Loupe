
<script type="text/javascript">

function initialize(){
	var myLatlng = new google.maps.LatLng(45.911450311152244, -123.96832638891601);
     var myOptions = {
     		zoom: 3,
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
 
 var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h1 id="firstHeading" class="firstHeading">Uluru</h1>'+
        '<div id="bodyContent">'+
        '<p><b>Uluru</b>, also referred to as <b>Ayers Rock</b>, is a large ' +
        'sandstone rock formation in the southern part of the '+
        'Northern Territory, central Australia. It lies 335&#160;km (208&#160;mi) '+
        'south west of the nearest large town, Alice Springs; 450&#160;km '+
        '(280&#160;mi) by road. Kata Tjuta and Uluru are the two major '+
        'features of the Uluru - Kata Tjuta National Park. Uluru is '+
        'sacred to the Pitjantjatjara and Yankunytjatjara, the '+
        'Aboriginal people of the area. It has many springs, waterholes, '+
        'rock caves and ancient paintings. Uluru is listed as a World '+
        'Heritage Site.</p>'+
        '<p>Attribution: Uluru, <a href="http://en.wikipedia.org/w/index.php?title=Uluru&oldid=297882194">'+
        'http://en.wikipedia.org/w/index.php?title=Uluru</a> '+
        '(last visited June 22, 2009).</p>'+
        '</div>'+
        '</div>';
        
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
    
 var marker = new google.maps.Marker({
 	position: new google.maps.LatLng(<?php echo $lat . ", " . $long ?>),
 	map: map,
 	title: 'f'
 });
 	
google.maps.event.addListener(marker, 'click', function() {
  infowindow.open(map,marker);
}); 


<?php endwhile;  ?>

<?php endif; ?>
}
</script>
	<div id="travel_map" ></div>
	