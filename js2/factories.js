'use strict'

app.factory( 'request', function( $http, url ) {
	var request = {};

	// imports
	request.url = url

	request.check = function( response ) {
		if ( ! response.data.status || response.data.status !== 'success' )
			return false;

		return true;
	};

	request.get = function( url, params ) {
		var object = null;
		try {
			this.url.isValid( url );
			object = $http( {
				"method":	"GET",
				"url":		url,
				"params":	params
			} );
		}	// end try

		catch( error ) {
			console.error( error.message );
		}	// end catch

		return object;
	};

	request.getData = function( response ) {
		return response.data || response || null;
	};

	request.isWarning = function( response ) {
		if( ! response.data.status || response.data.status !== 'warning' )
			return false;

		return true;
	};

	request.post = function( url, data ) {
		var object = null;

		try {
			this.url.isValid( url );
			this.youHaveparameters( data );

			object = $http( {
				"method":	"POST",
				"url":		url,
				"headers":	{ 'Content-Type': undefined },
				"data":		data,
				"transformRequest": function( data, headersGetter ) {
					var formData = new FormData();

					angular.forEach( data, function( value, key ) {
						formData.append( key, value );
					} );

					return formData;
				}
			});
		}	// end try

		catch( error ) {
			console.error( error.message );
		}	// end catch

		return object;
	};

	request.put = function( url, data ) {
		return $http.put( url, data );
	};

	request.youHaveparameters = function( params ) {
		if( ! params )
			throw new Error( 'No data.' );
	};

	return request;
} )

app.factory( 'url', function() {
	var url = {};

	url.isValid = function( url ) {
		if( ! url )
			throw new Error( 'Invalid URL in the Request.' );
	};

	url.controller = {
		"contact":		"http://ikniuyotl.dab.media/create",
		"test":			"test.php",
		"wordpress":	"/wp-admin/admin-ajax.php"
	};

	return url;
} )

app.factory( 'validate', function() {
	var validate = {};

	validate.pattern = {
		"email":	/^[a-zA-Z0-9.!#$%&’*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,
		"name":		/^(?=.*[aeiouáàäâãåąæāéèëêęėēíïìîįīóòöôõøœōúüùûū])(?=.*[bcdfghjklmnñpqrstvwxyz])[a-zñ áàäâãåąæāéèëêęėēíïìîįīóòöôõøœōúüùûū]{3,100}$/,
		"message":	/.{10,500}/,
		"subject":	/^(?=.*[(aeiouáàäâãåąæāéèëêęėēíïìîįīóòöôõøœōúüùûū)|(bcdfghjklmnñpqrstvwxyz)|(0-9)])[\w aeiouáàäâãåąæāéèëêęėēíïìîįīóòöôõøœōúüùûū]{3,100}$/,
		"tel":		/^\+?(\d{1,3})?[- .]?\(?(?:\d{2,3})\)?[- .]?\d{3,4}[- .]?\d{3,4}$/
	};

	validate.status = {
		"clean":	{},
		"error":	{ "class": 'has-feedback has-error', "icon": 'glyphicon glyphicon-remove', "status": false },
		"success":	{ "class": 'has-feedback has-success', "icon": 'glyphicon glyphicon-ok', "status": true }
	};

	validate.test = function( regex, input ) {
		return regex.test( String( input ).toLowerCase() );
	};

	validate.email = function( input ) {
		return this.test( this.pattern.email, input );
	};

	validate.message = function( input ) {
		return this.test( this.pattern.message, input );
	};

	validate.name = function( input ) {
		return this.test( this.pattern.name, input );
	};

	validate.subject = function( input ) {
		return this.test( this.pattern.subject, input );
	};

	validate.tel = function( input ) {
		return this.test( this.pattern.tel, input );
	};

	return validate;
} );