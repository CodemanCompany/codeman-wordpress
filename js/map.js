var center = new google.maps.LatLng( 19.3468849, -99.1696751 );
var map;
var marker;
var infoWindow;
var contentString;

function initialize() {
	map = new google.maps.Map( document.getElementById( 'map' ), {
		center:			center,
		mapTypeControl:	false,
		mapTypeId:		google.maps.MapTypeId.ROADMAP,
		zoom:			17,
		scrollwheel:	false,
		// styles:			[ {
		// 	'featureType':	'water',
		// 	'stylers':		[
		// 		{ 'visibility': 'on' },
		// 		{ 'color': '#428BCA' } ] },
		// 		{ 'featureType': 'landscape', 'stylers': [ { 'color': '#f2e5d4' } ] },
		// 		{ 'featureType': 'road.highway','elementType': 'geometry', 'stylers':[ { 'color': '#c5c6c6' } ] },
		// 		{ 'featureType': 'road.arterial', 'elementType':'geometry', 'stylers': [ { 'color': '#e4d7c6' } ] },
		// 		{ 'featureType': 'road.local', 'elementType': 'geometry', 'stylers': [ { 'color': '#fbfaf7' } ] },
		// 		{ 'featureType': 'poi.park', 'elementType': 'geometry', 'stylers': [ { 'color' : '#c5dac6' } ] },
		// 		{'featureType':'administrative','stylers':[{'visibility':'on'},{'lightness':33}]},{'featureType':'road'},{'featureType':'poi.park','elementType':'labels','stylers':[{'visibility':'on'},{'lightness':20}]},{},{'featureType':'road','stylers':[{'lightness':20}]
		// } ],
		zoomControl:	true
	} );

	contentString = 'Codeman';

	infoWindow = new google.maps.InfoWindow( { content: contentString } );

	marker = new google.maps.Marker( {
		icon:		'img/.png',
		position:	center,
		animation:	google.maps.Animation.BOUNCE,
		title:		'Codeman'
	} );

	marker.addListener( 'click', function() {
		infoWindow.open( map, marker );
	} );

	marker.setMap( map );
}	// end function

google.maps.event.addDomListener( window, 'load', initialize );