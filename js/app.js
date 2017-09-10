'use strict'

var app = angular.module( 'app', [ 'yaokiski' ] )

.config( [ function() {
	$( document ).ready( function() {
		var go = $( '.go' );
		var page = $( 'html, body' );
		
		go.click( function( event ) {
			event.preventDefault();
			var id = $( this ).attr( 'data-href' );
			page.animate( { scrollTop: $( '#' + id ).offset().top }, 'fast' );
		} );
	} );
} ] )

.controller( 'MainController', function( $controller, $scope ) {
	$controller( 'YaokiskiController', { "$scope": $scope } );
} );