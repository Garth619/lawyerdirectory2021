var map;
//var markerBounds;
function initMap() {

    var styledMapType = new google.maps.StyledMapType(
        [{
            "featureType": "administrative",
            "elementType": "all",
            "stylers": [{
                "visibility": "on"
            }, {
                "hue": "#ff0000"
            }]
        }, {
            "featureType": "administrative",
            "elementType": "labels",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "administrative",
            "elementType": "labels.text",
            "stylers": [{
                "color": "#5100ff"
            }]
        }, {
            "featureType": "administrative",
            "elementType": "labels.text.fill",
            "stylers": [{
                "visibility": "on"
            }, {
                "color": "#18146a"
            }]
        }, {
            "featureType": "administrative",
            "elementType": "labels.text.stroke",
            "stylers": [{
                "visibility": "on"
            }, {
                "color": "#ffffff"
            }]
        }, {
            "featureType": "landscape",
            "elementType": "all",
            "stylers": [{
                "visibility": "on"
            }, {
                "color": "#d1e8ff"
            }]
        }, {
            "featureType": "landscape",
            "elementType": "labels",
            "stylers": [{
                "visibility": "on"
            }]
        }, {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [{
                "visibility": "on"
            }, {
                "color": "#76bbfe"
            }]
        }, {
            "featureType": "poi",
            "elementType": "labels",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "road",
            "elementType": "all",
            "stylers": [{
                "visibility": "on"
            }, {
                "color": "#ffffff"
            }]
        }, {
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [{
                "lightness": 50
            }, {
                "visibility": "simplified"
            }]
        }, {
            "featureType": "road",
            "elementType": "labels",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "water",
            "elementType": "all",
            "stylers": [{
                "visibility": "on"
            }, {
                "color": "#ffffff"
            }]
        }], {
            name: 'Styled Map'
        });
        
        
		var lat_number = parseFloat(my_mapdata.map_current_city_latitude);
    var long_number = parseFloat(my_mapdata.map_current_city_longitude);
	

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(lat_number,long_number),
        mapTypeId: 'roadmap'
    });
    
    markerBounds = new google.maps.LatLngBounds();
	
		
		var script = document.createElement('script');
		
		script.src = '' +my_mapdata.current_domain+ '/wp-json/mapping/v1/location/'+my_mapdata.map_current_city+'/'+my_mapdata.map_current_pa+'/'+my_mapdata.map_paged+'?_jsonp=eqfeed_callback';
    
		//console.log(script.src);
    
    document.getElementsByTagName('head')[0].appendChild(script);

    //Associate the styled map with the MapTypeId and set it to display.
    map.mapTypes.set('styled_map', styledMapType);
    map.setMapTypeId('styled_map');
    
}

// Loop through the results array and place a marker for each
// set of coordinates.
window.eqfeed_callback = function(myJsonFile) {
    for (var i = 0; i < myJsonFile.length; i++) {


        //loops through the longitude and latitude data
        
        
        var latlngcensus = myJsonFile[i].Latlong[0];
        
        if(latlngcensus == null) {
	        
        } else {
	        
				var arr2 = Object.values(latlngcensus);
        
				var newww = arr2.toString();
				
				var split = newww.split(",");
				
				//console.log(split);
				
				var arr = split.map(Number);
				
				//var latLng = new google.maps.LatLng(34.02605, -118.28397);

        var latLng = new google.maps.LatLng(arr[1], arr[0]);
        
				
				var featuredPost = myJsonFile[i].Featured_lawyer;

       
        var circleImg = ''+my_mapdata.current_domain+'/wp-content/themes/ilawsuit/images/red-circle.svg';
        var featuredImg = ''+my_mapdata.current_domain+'/wp-content/themes/ilawsuit/images/map_icon.svg';
				
				
				var featuredProfileimg = myJsonFile[i].Featured_post_image;
        
        var displayImg = featuredPost === true ? featuredImg : circleImg;
	        		
	        		
				var lawyerTitle = myJsonFile[i].Title;
        var address = myJsonFile[i].Full_address;
        var streetaddress = myJsonFile[i].Street_address;
        var city = myJsonFile[i].City;
        var state = myJsonFile[i].State;
        var zipcode = myJsonFile[i].Zip_code;
        var phone = myJsonFile[i].Phone;
        var tel_href = myJsonFile[i].Tel_href;
        var viewprofile = myJsonFile[i].Permalink;
        

        var marker = new google.maps.Marker({
            position: latLng,
            map: map,
            icon: {url:displayImg, scaledSize: new google.maps.Size(35, 35)}
        });

        // premiere profile tooltip
        
        var contentStringfeatured = "<div class='map_tooltip featured'><div class='map_tooltip_left'><img src='"+featuredProfileimg+"' /></div><div class='map_tooltip_right'><h3>"+lawyerTitle+"</h3><p><a href='"+viewprofile+"'>"+streetaddress+', '+city+', '+state+' '+zipcode+"</a></p><p><a href='tel:"+tel_href+"'>"+phone+"</a></p><p><a class='map_view_profile' href='"+viewprofile+"'>View Profile</a></div></div>";
        
        // basic profile with the full address text area filled out (without street address text area)
        
        var contentString = "<div class='map_tooltip regular'><h3>"+lawyerTitle+"</h3><p><a href='"+viewprofile+"'>"+address+"</a></p><p><a href='tel:"+tel_href+"'>"+phone+"</a></p><p><a class='map_view_profile' href='"+viewprofile+"'>View Profile</a></div>";
        
        // basic profile with the street address text area line filled out in the claim file form, this overrides the full address text area
        
        var contentStringstreet = "<div class='map_tooltip regular'><h3>"+lawyerTitle+"</h3><p><a href='"+viewprofile+"'>"+streetaddress+' '+city+', '+state+' '+zipcode+"</a></p><p><a href='tel:"+tel_href+"'>"+phone+"</a></p><p><a class='map_view_profile' href='"+viewprofile+"'>View Profile</a></div>";
        
        // if the streetaddress has a value then assign contentStringstreet to the contentStringbasic var and push it through to the featured vs unfeatured tooltip info below. else just show the full address text input line with contentString 
        
        var contentStringbasic = !streetaddress ? contentString : contentStringstreet;
            
        // if the post is a featured post and equals true then contentStringfeatured becomes the customTooltip var, else contentStringbasic becomes the customTooltip var
        
        var customTooltip = featuredPost === true ? contentStringfeatured : contentStringbasic;

        var infoWindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'click', (function(marker) {
            var content = customTooltip;
            return function() {
                infoWindow.setContent(content);
                infoWindow.open(map, marker);
                //toggleBounce;
            }
        })(marker));

/*
        function toggleBounce() {
            if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        }
*/
				//markerBounds.extend(latLng);
			}
    }
   // map.fitBounds(markerBounds);
}
