app.component( 'contact', {
	"controller":	[ '$scope', 'request', 'validation', ( $scope, request, validation ) => {
		$scope.input = {};
		$scope.validation = validation;

		$scope.action = () => {
			if( $scope.form.$invalid ) {
				$scope.form.email.$pristine = false;
				$scope.form.message.$pristine = false;
				$scope.form.name.$pristine = false;
				$scope.form.subject.$pristine = false;
				$scope.form.tel.$pristine = false;
				return;
			}	// end if

			grecaptcha.ready( () => {
				grecaptcha.execute( '6LcWlosUAAAAANwj1zfKXKmOpfyQHczJiXvlwRBj', { "action": "homepage" } )
				.then( ( token ) => {
					Swal.fire( {
						"allowOutsideClick": false,
						"text": "Espere un momento por favor.",
						"title": "Enviando mensaje ...",
					} )
					Swal.showLoading();
		
					$scope.input[ 'g-recaptcha-response' ] = token;
					request.post( '/controller/contact.php', $scope.input, false )
					.then( ( response ) => {
						Swal.close();
		
						if( request.check( response ) ) {
							Swal.fire( {
								"confirmButtonText": "Aceptar",
								"icon": "success",
								"text": "Operación realizada con éxito.",
								"title": "Éxito",
							} );
						}	// end if
						else {
							Swal.fire( {
								"confirmButtonText": "Aceptar",
								"icon": "error",
								"text": "Por el momento no se puede realizar la operación, intente de nueva más tarde.",
								"title": "Atención",
							} );
						}	// end else
		
						$scope.reset();
					}, ( error ) => {} );
				} );
			} );
		};

		$scope.reset = () => {
			$scope.form.$setPristine();
			$scope.input = {};
		};
	} ],
	"templateUrl":	'/wp-content/themes/codeman-wordpress-2.2.7/component/contact.html',
} );

app.component( 'newsletter', {
	"controller":	[ '$scope', 'request', 'validation', ( $scope, request, validation ) => {
		$scope.input = {};
		$scope.validation = validation;

		$scope.action = () => {
			if( $scope.form.$invalid ) {
				$scope.form.email.$pristine = false;
				$scope.form.name.$pristine = false;
				return;
			}	// end if

			grecaptcha.ready( () => {
				grecaptcha.execute( '6LcWlosUAAAAANwj1zfKXKmOpfyQHczJiXvlwRBj', { "action": "homepage" } )
				.then( ( token ) => {
					Swal.fire( {
						"allowOutsideClick": false,
						"text": "Espere un momento por favor.",
						"title": "Realizando operación ...",
					} )
					Swal.showLoading();
		
					$scope.input[ 'g-recaptcha-response' ] = token;
					request.post( request.url.controller.wordpress + '?action=new_subscription', $scope.input, false )
					.then( ( response ) => {
						Swal.close();
		
						if( request.check( response ) ) {
							Swal.fire( {
								"confirmButtonText": "Aceptar",
								"icon": "success",
								"text": "Operación realizada con éxito.",
								"title": "Éxito",
							} );
						}	// end if
						else {
							Swal.fire( {
								"confirmButtonText": "Aceptar",
								"icon": "error",
								"text": "Por el momento no se puede realizar la operación, intente de nueva más tarde.",
								"title": "Atención",
							} );
						}	// end else
		
						$scope.reset();
					}, ( error ) => {} );
				} );
			} );
		};

		$scope.reset = () => {
			$scope.form.$setPristine();
			$scope.input = {};
		};
	} ],
	"templateUrl":	'/wp-content/themes/codeman-wordpress-2.2.7/component/newsletter.html',
} );

app.component( 'search', {
	"templateUrl":	'/wp-content/themes/codeman-wordpress-2.2.7/component/search.html',
} );