const app = angular.module( 'app', [ 'ngSanitize', 'yaokiski' ] )

.config( [ () => {
	$( document ).ready( () => {
		let go = $( '.go' );
		let page = $( 'html, body' );

		go.click( function( event ) {
			event.preventDefault();
			let id = $( this ).attr( 'data-href' );
			page.animate( { scrollTop: $( '#' + id ).offset().top }, 'fast' );
		} );
	} );
} ] )

.controller( 'MainController', [ '$controller', '$scope', 'request', 'useful', ( $controller, $scope, request, useful ) => {
	$controller( 'YaokiskiController', { "$scope": $scope } );

	$scope.loading = false;

	let data = {
		"action":	'load_more',
		"page":		2
	};

	$scope.loadMore = ( params ) => {
		$scope.loading = true;

		if( params && params.categories )
			data.category = params.categories;

		if( params && params.s )
			data.s = params.s;

		request.get( request.url.controller.wordpress, data )
		.then( ( response ) => {
			if( request.check( response ) ) {
				$scope.posts = useful.merge( $scope.posts || [], request.getData().data );
				data.page++;
			}	// end if

			$scope.loading = false;
		}, ( error ) => {} )
	};
} ] );