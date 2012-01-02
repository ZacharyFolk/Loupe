function initialize() {
  		var map;
  		var markersArray = [];
  		var vlat;
  		var vlong;
        var mapOptions = {
          center: new google.maps.LatLng(-33.8688, 151.2195),
          zoom: 13,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
        var map = new google.maps.Map(document.getElementById('map_canvas'),
          mapOptions);

        var input = document.getElementById('searchTextField');
        var autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var marker = new google.maps.Marker({
          map: map
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
          infowindow.close();
          var place = autocomplete.getPlace();
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport); 
            var huh = map.getCenter();
           document.getElementById("latlong").value = place.geometry.location;
	       document.getElementById("longitude").value = huh.lng();
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  
			
          }

          var image = new google.maps.MarkerImage(
              place.icon,
              new google.maps.Size(71, 71),
              new google.maps.Point(0, 0),
              new google.maps.Point(17, 34),
              new google.maps.Size(35, 35));
          marker.setIcon(image);
          marker.setPosition(place.geometry.location);
			
          var address = '';
          if (place.address_components) {
            address = [(place.address_components[0] &&
                        place.address_components[0].short_name || ''),
                       (place.address_components[1] &&
                        place.address_components[1].short_name || ''),
                       (place.address_components[2] &&
                        place.address_components[2].short_name || '')
                      ].join(' ');
          }

          infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
          infowindow.open(map, marker);
        });
	
	
	 google.maps.event.addListener(map, 'click', function( e ) {
	       placeMarker (e.latLng,map);
	     
	      });
	      
function placeMarker(position,map){
		deleteOverlays();infowindow.close();
	      var marker = new google.maps.Marker({
          position: position,
          map: map
        });
        map.panTo(position); 
        markersArray.push(marker);
        document.getElementById("latlong").value = position.lat();
      }
		      
function addMarker(latLng) {
	deleteOverlays();
    marker = new google.maps.Marker({
      position: latLng,
      map: map
    });
    markersArray.push(marker);
  }
 
 // Removes the overlays from the map, but keeps them in the array
  function clearOverlays() {
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(null);
      }
    }
  }
 
  // Shows any overlays currently in the array
  function showOverlays() {
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(map);
      }
    }
  }
 
  // Deletes all markers in the array by removing references to them
  function deleteOverlays() {
    if (markersArray) {
      for (i in markersArray) {
        markersArray[i].setMap(null);
      }
      markersArray.length = 0;
    }
  }

      }
      google.maps.event.addDomListener(window, 'load', initialize);