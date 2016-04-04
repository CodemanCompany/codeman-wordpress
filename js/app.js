'use strict'

var app = angular.module( 'app', [ 'ngSanitize' ] )

.config( function() {
	$( document ).ready( function() {
		$( 'input:not( [ type = "checkbox" ], [ type = "radio" ], [ type = "submit" ] ), select, textarea' ).addClass( 'form-control' );
		// $( 'a[ href ^= "http" ], a[ href ^= "https" ] , a[ href *="files" ]' ).attr( 'target', '_blank' );
		// write
	} );
} );