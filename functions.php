<?php

define( 'POSTS_PER_PAGE', 15 );
define( 'POSTS_PER_SIDEBAR', 6 );

function codeman_wp_title( $title, $sep ) {
	$title .= get_bloginfo( 'name', 'display' );

	$description = get_bloginfo( 'description', 'display' );
	if( $description && ( is_home() || is_front_page() ) )
		$title = "{$title} {$sep} {$description}";

	return $title;
}	// end function

function get_config( $params = NULL ) {
	$is_singular = is_singular();
	return [
		'category_name'		=>	isset( $params[ 'category_name' ] ) ? $params[ 'category_name' ] : ( $is_singular ? get_data( 'category' )[ 0 ] -> slug : NULL ),
		'paged'				=>	isset( $params[ 'paged' ] ) ? $params[ 'paged' ] : 1,
		'post__not_in'		=>	$is_singular ? [ get_the_ID() ] : NULL,
		'post_status'		=>	'publish',
		'posts_per_page'	=>	isset( $params[ 'posts_per_page' ] ) ? $params[ 'posts_per_page' ] : POSTS_PER_PAGE
	];
}	// end function

function get_custom( $params = NULL ) {
	if( is_null( $params ) )
		throw new Exception( 'The parameters are incorrect.' );

	return is_null( $store = get_post_custom_values( $params[ 'key' ], $params[ 'id' ] ) ) ? NULL : $store[ 0 ];
}	// end function

function get_data( $type = NULL, $id = NULL ) {
	if( is_null( $type ) )
		throw new Exception( 'Wrong type.' );
	elseif( $type === 'category' ) {
		$categories = [];
		foreach( get_the_category( $id ) as $key => $category ) {
			$categories[] = ( object ) [
				'index'	=>	$key,
				'name'	=>	$category -> name,
				'slug'	=>	$category -> slug,
				'url'	=>	get_category_link( $category -> cat_ID )
			];
		}	// end foreach
		unset( $key, $category );
		return $categories;
	}	// end elseif

	return NULL;
}	// end function

function get_jwplayer( $service = NULL ) {
	if( is_null( $service ) )
		return;

	$video = get_custom( [ 'key' => 'video' ] );
	echo $video ? '<div id="botr_' . $video . '_' . $service . '_div"></div><script type="text/javascript" src="https://content.jwplatform.com/players/' . $video . '-' . $service . '.js"></script>' : '';
}	// end function

function get_gallery() {
	$gallery = get_post_gallery( get_the_ID(), false );

	if( ! $gallery )
		return false;

	$gallery = ( object ) [
		'ids'		=>	explode( ',', $gallery[ 'ids' ] ),
		'images'	=>	$gallery[ 'src' ]
	];
	$gallery -> total = count( $gallery -> ids );

	foreach( $gallery -> images as $key => &$value ) {
		$value = ( object ) [
			'description'	=>	get_post( $gallery -> ids[ $key ] ) -> post_excerpt,
			'index'			=>	$key,
			'src'			=>	$value
		];
	}	// end foreach
	unset( $key, $value, $gallery -> ids );

	return $gallery;
}	// end function

function get_image( $echo = TRUE ) {
	$image = current( get_attached_media( 'image' ) ) -> guid;

	if( ! $echo )
		return $image;

	echo $image;
}	// end function

function get_location( $echo = TRUE ) {
	$location = "http://{$_SERVER[ HTTP_HOST ]}{$_SERVER[ REQUEST_URI ]}";

	if( ! $echo )
		return $location;

	echo $location;
}	// end function

function get_publications( $query = NULL ) {
	if( is_null( $query ) || ! is_array( $query = query_posts( $query ) ) )
		throw new Exception( 'The query is wrong.' );

	$posts = [];

	foreach( $query as $key => $post ) {
		$category = get_the_category( $post -> ID )[ 0 ];
		$store = ( object ) [
			'category'	=>	get_data( 'category', $post -> ID ),
			'content'	=>	strstr( $post -> post_content, '<!--more-->', true ),
			'custom'	=>	[],
			'date'		=>	get_the_date( '', $post -> ID ),
			'field'		=>	( object ) [
				'audio'		=>	get_custom( [ 'id' => $post -> ID, 'key' => 'audio' ] ),
				'video'		=>	get_custom( [ 'id' => $post -> ID, 'key' => 'video' ] )
			],
			'id'		=>	$post -> ID,
			'index'		=>	$key,
			'image'		=>	current( get_attached_media( 'image', $post -> ID ) ) -> guid,
			'modified'	=>	$post -> post_modified,
			'status'	=>	$post -> post_status,
			'tags'		=>	get_the_tags( $post -> ID ),
			'title'		=>	$post -> post_title,
			'url'		=>	get_permalink( $post -> ID )
		];

		// filters
		$store -> content = $store -> content ? $store -> content : 'It does not have a description.';

		$posts[] = $store;
	}	// end foreach
	unset( $key, $post );

	return ( object ) [
		'data'	=>	$posts,
		'rows'	=>	count( $posts )
	];
}	// end function

function get_publications_for( $params = NULL ) {
	if( is_null( $params ) )
		throw new Exception( 'The parameters are not correct.' );
	elseif( isset( $params[ 'section' ] ) ) {
		if( $params[ 'section' ] === 'home' )
			return get_publications( get_config() );
		elseif( $params[ 'section' ] === 'sidebar' )
			return get_publications( get_config( [ 'posts_per_page' => POSTS_PER_SIDEBAR ] ) );
		else
			throw new Exception( 'This section is not found.' );
	}	// end elseif
	elseif( isset( $params[ 'number' ] ) ) {
		if( isset( $params[ 'category' ] ) )
			return get_publications( get_config( [
				'category_name'		=>	$params[ 'category' ],
				'posts_per_page'	=>	$params[ 'number' ]
			] ) );
		else
			return get_publications( get_config( [ 'posts_per_page' => $params[ 'number' ] ] ) );
	}	// end elseif
	elseif( isset( $params[ 'category' ] ) )
		return get_publications( get_config( [ 'category_name' => $params[ 'category' ] ] ) );
	else
		throw new Exception( 'Not found.' );
}	// end function

function get_search( $echo = TRUE ) {
	if( ! isset( $_GET[ 's' ] ) )
		return;

	if( ! $echo )
		return htmlentities( $_GET[ 's' ] );

	echo htmlentities( $_GET[ 's' ] );
}	// end function

function get_url( $echo = TRUE ) {
	if( ! $echo )
		return get_permalink();

	echo get_permalink();
}	// end function

function image_dir() {
	echo get_template_directory_uri() .'/img';
}	// end function

function is_draft() {
	return is_user_logged_in() && is_preview();
}	// end function

function load_more() {
	$store = [
		'message'	=>	'Bad request',
		'result'	=>	'error'
	];

	if(
		$_SERVER[ 'REQUEST_METHOD' ] === 'GET' &&
		isset( $_GET[ 'page' ] ) &&
		! empty( $_GET[ 'page' ] ) &&
		// $_GET[ 'page' ] > 1	&&
		( ( $_GET[ 'page' ] - 1 ) * POSTS_PER_PAGE ) - wp_count_posts() -> publish < 0
	) {
		$data = get_publications( get_config( [
			'category_name'		=>	$_GET[ 'category' ],
			'paged'				=>	$_GET[ 'page' ],
			'posts_per_page'	=>	POSTS_PER_PAGE
		] ) );

		$store = [
			'data'	=>	$data -> data,
			'result'=>	'success',
			'rows'	=>	$data -> rows,
			'total'	=>	intval( wp_count_posts() -> publish )
		];
	}	// end if

	header( 'Content-Type: application/json' );
	echo json_encode( $store );
	exit;
}	// end function

function my_page_menu_args( $args ) {
	$args[ 'show_home' ] = TRUE;
	return $args;
}	// end function

function my_post_queries( $query ) {
	if( ! is_admin() && $query -> is_main_query() ) {
		$query -> set( 'post_status', is_draft() ? 'draft' : 'publish' );

		// if( is_home() )
		// 	$query -> set( 'posts_per_page', POSTS_PER_PAGE );

		// elseif( is_category() )
		// 	$query -> set( 'posts_per_page', POSTS_PER_PAGE );

		// elseif( is_search() )
		// 	$query -> set( 'posts_per_page', POSTS_PER_PAGE );
		$query -> set( 'posts_per_page', POSTS_PER_PAGE );
	}	// end if
}	// end function

function send_smtp_email( $phpmailer ) {
	$phpmailer -> isSMTP();
	$phpmailer -> Host = 'HOST';
	$phpmailer -> SMTPAuth = true;
	$phpmailer -> Port = '587';
	$phpmailer -> Username = 'IAM_USER';
	$phpmailer -> Password = 'IAM_PASSWORD';
	$phpmailer -> SMTPSecure = 'tls';
	$phpmailer -> From = 'email';
	$phpmailer -> FromName = 'Name';
}	// end function

add_action( 'phpmailer_init', 'send_smtp_email' );
add_action( 'pre_get_posts', 'my_post_queries' );
add_action( 'wp_ajax_load_more', 'load_more' );
add_action( 'wp_ajax_nopriv_load_more', 'load_more' );

add_filter( 'wp_page_menu_args', 'my_page_menu_args' );
add_filter( 'wp_title', 'codeman_wp_title', 10, 2 );