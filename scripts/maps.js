  window.onload = function () {
        initialize();
    }

  var map;
  var markersArray = [];
  var vlat;
  var vlong;
   function initialize() {	
   	    vlat = document.getElementById('latitude').value; 
        vlong = document.getElementById('longitude').value;        
        var latlng = new google.maps.LatLng(vlat, vlong);
    	
    	if ((vlat) == null || (vlat) == '') {
    		latlng = new google.maps.LatLng(-3.12313 , -62.2320, 11);
    	}
    	
      	var mapOptions = {
      		zoom: 9,
      		center: latlng,
      		mapTypeId: google.maps.MapTypeId.ROADMAP
      	};
      	   	
      	map = new google.maps.Map(document.getElementById("map_canvas"),
      		mapOptions);   
      	
      	var bikeLayer = new google.maps.BicyclingLayer();
      	bikeLayer.setMap(map);   
				 
      google.maps.event.addListener(map, 'click', function(event) {
      	addMarker(event.latLng);
      	document.getElementById("latitude").value = event.latLng.lat();
      	document.getElementById("longitude").value = event.latLng.lng();	
      });
      
        jQuery('#searchbox').click(function()
  		{
  		demo1();
  		});
  		
	/*  var marker = new google.maps.Marker({
     	position: latlng,
     	map: map,
     	title: "Location"
     });
 */
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
  
   function demo1() {
		jQuery('#searchbox').geo_autocomplete({
			select: function(_event, _ui) {
			if (_ui.item.viewport) map.fitBounds(_ui.item.viewport);
		}
		});
		}


/*
 * 
 * 		GEvent.addListener(map,'mousemove',function(point)
			{
			//	document.getElementById('latitude').value = point.lat()
			//	document.getElementById('lngspan').innerHTML = point.lng()	
			//	document.getElementById('latlong').innerHTML = point.lat() + ', ' + point.lng() 
			});
		
		GEvent.addListener(map,'click',function(overlay,point)
			{
		
			if (counter == 0) {
			map.addOverlay(new GMarker(point))
		
			counter ++;
			document.getElementById('latitude').value = point.lat()
			document.getElementById('longitude').value = point.lng()
			alert (counter);
			}	
			else {
				GMarker.setMap(null);
				delete GMarker;
				counter = 0;
				map.addOverlay(new GMarker(point))
				counter ++;
				alert (counter);
			document.getElementById('latitude').value = point.lat()
			document.getElementById('longitude').value = point.lng()
			}
		

			});  
			
*/