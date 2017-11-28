(function($) {

/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function new_map( $el ) {
	
	// var
	var $markers = $el.find('.marker');
	
	var styledMapType = new google.maps.StyledMapType([
		{
			"featureType": "administrative",
			"elementType": "labels.text.fill",
			"stylers": [
				{
					"color": "#444444"
				}
			]
		},
		{
			"featureType": "administrative.country",
			"elementType": "labels.text",
			"stylers": [
				{
					"saturation": "18"
				},
				{
					"lightness": "-55"
				},
				{
					"visibility": "simplified"
				},
				{
					"color": "#4484a1"
				}
			]
		},
		{
			"featureType": "landscape",
			"elementType": "all",
			"stylers": [
				{
					"color": "#f2f2f2"
				},
				{
					"saturation": "28"
				},
				{
					"lightness": "42"
				},
				{
					"gamma": "2.01"
				},
				{
					"weight": "1"
				}
			]
		},
		{
			"featureType": "poi",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "all",
			"stylers": [
				{
					"saturation": -100
				},
				{
					"lightness": 45
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "simplified"
				}
			]
		},
		{
			"featureType": "road.arterial",
			"elementType": "labels.icon",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "transit",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "all",
			"stylers": [
				{
					"color": "#aaced9"
				},
				{
					"visibility": "on"
				}
			]
		}
	]);

	// vars
	var args = {
		zoom		: 6,
		center		: new google.maps.LatLng(0, 0),
		mapTypeControlOptions: {
			mapTypeIds: ['styled_map']
		},
		disableDefaultUI: true,
		draggable: false,
		gestureHandling: 'none'		
	};
	
	// create map
	var map = new google.maps.Map( $el[0], args);

	map.mapTypes.set('styled_map', styledMapType);
	map.setMapTypeId('styled_map');
	
	
	// add a markers reference
	map.markers = [];
	
	
	// add markers
	$markers.each(function(){
		
    	add_marker( $(this), map );
		
	});
	
	
	// center map
	center_map( map );
	
	
	// return
	return map;
	
}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

    var iconActive = {
		url: $marker.attr('data-active'),
		size: new google.maps.Size(20, 20),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(10, 10)
	};

    var iconInActive = {
		url: $marker.attr('data-inactive'),
		size: new google.maps.Size(20, 20),
		origin: new google.maps.Point(0, 0),
		anchor: new google.maps.Point(10, 10)
	};

	var marker = new google.maps.Marker({
		position	: latlng,
        icon        : iconInActive,
		map			: map
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {
			$.each(map.markers, function(i, marker) {
				marker.setIcon(iconInActive);
			});
			$('.map-box, .icon').stop().fadeOut(100, function() {
                $(this).html($marker.html()).stop().fadeIn(600);
            });
			marker.setIcon(iconActive);
		});
		google.maps.event.addListener(marker, 'mouseover', function() {
			$.each(map.markers, function(i, marker) {
				marker.setIcon(iconInActive);
			});
			$('.map-box, .icon').stop().fadeOut(100, function() {
                $(this).html($marker.html()).stop().fadeIn(600);
            });
			marker.setIcon(iconActive);
		});
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {
	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/
// global var
var map = null;

$(document).ready(function(){

	$('.acf-map').each(function(){

		// create map
		map = new_map( $(this) );

	});

	var size = window.innerWidth;
	$(window).resized(function() {
		if(size < 800 && window.innerWidth >= 800) {
			center_map(map);
			size = window.innerWidth;
		}
		if(size >= 1020 && window.innerWidth < 1020) {
			center_map(map);
			size = window.innerWidth;
		}
		if(size >= 800 && window.innerWidth < 800) {
			center_map(map);
			size = window.innerWidth;
		}
	});

	$(window).on( "orientationchange", function(e) {
		center_map(map);
	});
});

})(jQuery);

(function($) {
    var uniqueCntr = 0;
    $.fn.resized = function (waitTime, fn) {
        if (typeof waitTime === "function") {
            fn = waitTime;
            waitTime = 250;
        }
        var tag = "resizeTimer" + uniqueCntr++;
        this.resize(function () {
            var self = $(this);
            var timer = self.data(tag);
            if (timer) {
                clearTimeout(timer);
            }
            timer = setTimeout(function () {
                self.removeData(tag);
                fn.call(self[0]);
            }, waitTime);
            self.data(tag, timer);
        });
    }
})(jQuery);
