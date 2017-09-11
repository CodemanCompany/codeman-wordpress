'use strict'

var app = angular.module( 'app', [ 'ngSanitize', 'yaokiski' ] )

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

.controller( 'MainController', [ '$controller', '$scope', 'request', 'useful', function( $controller, $scope, request, useful ) {
	$controller( 'YaokiskiController', { "$scope": $scope } );

	$scope.loading = false;

	var data = {
		"action":	'load_more',
		"page":		2
	};

	$scope.loadMore = function( params ) {
		$scope.loading = true;

		if( params && params.categories )
			data.category = params.categories;

		if( params && params.s )
			data.s = params.s;

		request.get( request.url.controller.wordpress, data )
		.then( function( response ) {
			if( request.check( response ) ) {
				$scope.posts = useful.merge( $scope.posts || [], request.getData().data );
				data.page++;
			}	// end if

			$scope.loading = false;
		}, function( error ) {} )
	};
} ] );