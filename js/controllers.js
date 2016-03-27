'use strict'

app.controller( 'MainController', MainController );
app.controller( 'ContactController', ContactController );

function MainController( $scope, request, validate ) {
	$scope.loading = false;

	var data = {
		"action":	'load_more',
		"page":		2
	};

	$scope.loadMore = function( category ) {
		$scope.loading = true;

		data.category = category;

		request.get( request.url.controller.wordpress, data )
		.then( function( response ) {
			if( response.data.result === 'success' ) {
				$scope.data = response.data.data;
				data.page++;
			}	// end if

			$scope.loading = false;
		}, function( error ) {} )
	};

	$scope.share = function( event, content, url, network ) {
		event.preventDefault();

		if( ! url || ! network )
			return;

		var share = null;

		if( network === 'facebook' )
			share = 'https://www.facebook.com/sharer/sharer.php?u=' + url;
		else if( network === 'twitter' )
			share = 'https://twitter.com/share?via=graziamx&text=' + content + '&url=' + url;
		else
			return;

		var gadget = {
			"height":	300,
			"width":	600
		};

		var display = {
			"left":	( screen.width / 2 ) - ( gadget.width / 2 ),
			"top":	( screen.height / 2 ) - ( gadget.height / 2 )
		};

		window.open(
			encodeURI( share ),
			'',
			'menubar=no, toolbar=no, resizable=no, scrollbars=yes, height=' + gadget.height + ',width=' + gadget.width + ',left=' + display.left + ',top=' + display.top
		);
	};

	$scope.search = function( event, input ) {
		location.href = '/?s=' + input;
	};
}	// end function

function ContactController( $scope, $timeout, request, validate ) {
	$scope.validate = {};

	$scope.reset = function() {
		$scope.input = {};
		$scope.loading = false;
		$scope.status = {
			"email":	validate.status.clean,
			"message":	validate.status.clean,
			"name":		validate.status.clean,
			"recaptcha":validate.status.clean,
			"subject":	validate.status.clean
		};

		$scope.privacy = false;
	};

	$scope.reset();

	$scope.validate.email = function( input ) {
		if( validate.email( input ) )
			$scope.status.email = validate.status.success;

		else
			$scope.status.email = validate.status.error;
	};

	$scope.validate.message = function( input ) {
		if( validate.message( input ) )
			$scope.status.message = validate.status.success;

		else
			$scope.status.message = validate.status.error;
	};

	$scope.validate.name = function( input ) {
		if( validate.name( input ) )
			$scope.status.name = validate.status.success;

		else
			$scope.status.name = validate.status.error;
	};

	$scope.validate.subject = function( input ) {
		if( validate.subject( input ) )
			$scope.status.subject = validate.status.success;

		else
			$scope.status.subject = validate.status.error;
	};

	$scope.sanitize = function() {
		for( var index in $scope.input )
			$scope.input[ index ] = String( $scope.input[ index ] ).toLowerCase();
	};

	$scope.contact = function() {
		$scope.sanitize();
		
		$scope.input[ 'g-recaptcha-response' ] = angular.element( '#g-recaptcha-response' ).val();
		if( ! $scope.input[ 'g-recaptcha-response' ] ) {
			$scope.status.recaptcha = validate.status.error;
			return;
		}	// end if

		$scope.input.delivery = 'http://artezia.technology/delivery.html';
		$scope.input.thanks = 'http://artezia.technology/thanks.html';

		$scope.loading = true;
		request.contact( $scope.input )
		.then( function( response ) {
			$scope.alert = response.data;
			$scope.reset();
			grecaptcha.reset();
			$timeout( function() { $scope.alert = {}; }, 1000 * 25 );
		} );
	};
}	// end function