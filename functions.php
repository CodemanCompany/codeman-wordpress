<?php
//  ██████╗ ██████╗ ██████╗ ███████╗███╗   ███╗ █████╗ ███╗   ██╗
// ██╔════╝██╔═══██╗██╔══██╗██╔════╝████╗ ████║██╔══██╗████╗  ██║
// ██║     ██║   ██║██║  ██║█████╗  ██╔████╔██║███████║██╔██╗ ██║
// ██║     ██║   ██║██║  ██║██╔══╝  ██║╚██╔╝██║██╔══██║██║╚██╗██║
// ╚██████╗╚██████╔╝██████╔╝███████╗██║ ╚═╝ ██║██║  ██║██║ ╚████║
//  ╚═════╝ ╚═════╝ ╚═════╝ ╚══════╝╚═╝     ╚═╝╚═╝  ╚═╝╚═╝  ╚═══╝

// Init
// New Taxonomy
define( 'ARGS', [
	'hierarchical'		=>	true,
	'query_var'			=>	true,
	'rewrite'			=>	[ 'slug' => 'googlemaps' ],
	'show_admin_column'	=>	true,
	'show_ui'			=>	true,
] );

register_taxonomy( 'googlemaps', [ 'geolocation' ], ARGS );

// Config
define( 'INSTAGRAM_COUNT', 10 );
define( 'INSTAGRAM_TOKEN', '' );
define( 'MAPS_KEY', '' );
define( 'POSTS_PER_PAGE', 15 );
define( 'POSTS_PER_SIDEBAR', 6 );
define( 'TEMPLATE_PATH', get_template_directory() . '/' );

function codeman_wp_title( string $title, string $sep ): string {
	$title .= get_bloginfo( 'name', 'display' );

	$description = get_bloginfo( 'description', 'display' );
	if( $description && ( is_home() || is_front_page() ) )
		$title = "{$title} {$sep} {$description}";

	return $title;
}	// end function

// TODO: get_address()

function get_best_category( array $categories ) {;
	if( count( $categories ) === 1 )
		return ( object ) [
			'name'	=>	$categories[ 0 ] -> name,
			'slug'	=>	$categories[ 0 ] -> slug,
		];

	foreach( ( array ) $categories as $category )
		if( ! (
			$category -> slug == 'carousel' ||
			$category -> slug == 'sin-categoria'
		) )
			return ( object ) [
				'name'	=>	$category -> name,
				'slug'	=>	$category -> slug,
			];

	unset( $category );
	return false;
}	// end function

function get_subcategories( string $slug = NULL ): array {
	if( is_null( $slug ) )
		throw new Exception( 'Slug cannot be null.' );

	$categories = [];
	$parent = is_int( $slug ) ? $slug : get_category_by_slug( $slug );

	$params = [
		'exclude'		=>	0,
		'hide_empty'	=>	false,
		'order'			=>	'ASC',
		'orderby'		=>	'name',
		'parent'		=>	is_int( $slug ) ? $slug : $parent -> term_id,
	];

	foreach( get_categories( $params ) as $key => $category ) {
		$categories[] = ( object ) [
			'count'	=>	$category -> count,
			'id'	=>	$category -> term_id,
			'index'	=>	$key,
			'name'	=>	$category -> name,
			'parent'=>	$category -> category_parent,
			'slug'	=>	$category -> slug,
			'url'	=>	get_category_link( $category -> cat_ID ),
		];
	}	// end foreach
	unset( $key, $category );

	return $categories;
}	// end function

function get_config( array $params = NULL ): array {
	$is_singular = is_singular();

	if( isset( $params[ 'category__and' ] ) ) {
		$categories = explode( ',', $params[ 'category__and' ] );

		$ids = [];
		foreach( $categories as $category ) {
			$cat = get_category_by_slug( $category );
			$ids[] = $cat -> term_id;
		}	// end foreach
		unset( $category );
	}	// end if

	return [
		'category__and'		=>	$ids ?? NULL,
		'category_name'		=>	$params[ 'category_name' ] ?? NULL,
		'orderby'			=>	$params[ 'orderby' ] ?? NULL,
		'order'				=>	$params[ 'order' ] ?? NULL,
		'paged'				=>	$params[ 'paged' ] ?? 1,
		'post__not_in'		=>	$is_singular ? [ get_the_ID() ] : NULL,
		'post_status'		=>	'publish',
		'posts_per_page'	=>	$params[ 'posts_per_page' ] ?? POSTS_PER_PAGE,
		's'					=>	$params[ 's' ] ?? NULL,
		'tag'				=>	$params[ 'tag' ] ?? NULL,
		'tax_query'	=>	isset( $params[ 'googlemaps' ] ) ? [
			'relation'	=>	'AND',
			[
				'taxonomy'	=>	'googlemaps',
				'field'		=>	'slug',
				'include_children'	=>	false,
				'terms'		=>	$params[ 'googlemaps' ],
				// 'operator'	=>	'IN',
			],
		] : NULL,
	];
}	// end function

function get_custom( array $params = NULL ) {
	if( is_null( $params ) )
		throw new Exception( 'The parameters are incorrect.' );

	return is_null( $store = get_post_custom_values( $params[ 'key' ], $params[ 'id' ] ) ) ? NULL : $store[ 0 ];
}	// end function

function get_data( string $type = NULL, int $id = NULL ) {
	if( is_null( $type ) )
		throw new Exception( 'Wrong type.' );
	elseif( $type === 'category' ) {
		$categories = [];
		foreach( get_the_category( $id ) as $key => $category ) {
			$categories[] = ( object ) [
				'id'	=>	$category -> term_id,
				'index'	=>	$key,
				'name'	=>	$category -> name,
				'parent'=>	$category -> category_parent,
				'slug'	=>	$category -> slug,
				'url'	=>	get_category_link( $category -> cat_ID ),
			];
		}	// end foreach
		unset( $key, $category );
		return $categories;
	}	// end elseif

	return NULL;
}	// end function

function get_jwplayer( string $service = NULL ) {
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
		'images'	=>	$gallery[ 'src' ],
	];
	$gallery -> total = count( $gallery -> ids );

	foreach( $gallery -> images as $key => &$value ) {
		$value = ( object ) [
			'description'	=>	get_post( $gallery -> ids[ $key ] ) -> post_excerpt,
			'index'			=>	$key,
			'src'			=>	$value,
		];
	}	// end foreach
	unset( $key, $value, $gallery -> ids );

	return $gallery;
}	// end function

function get_image( bool $echo = TRUE ) {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium_large' )[ 0 ];

	if( ! $echo )
		return $image;

	echo $image;
}	// end function

function get_location( bool $echo = TRUE ) {
	$location = "http://{$_SERVER[ HTTP_HOST ]}{$_SERVER[ REQUEST_URI ]}";

	if( ! $echo )
		return $location;

	echo $location;
}	// end function

function get_open_graph() {
	if( is_single() )
		return get_publications( [ 'p' => get_the_ID() ] ) -> data[ 0 ];

	return false;
}	// end function

function get_publications( array $query = NULL ): stdClass {
	if( is_null( $query ) || ! is_array( $query = query_posts( $query ) ) )
		throw new Exception( 'The query is wrong.' );

	$posts = [];

	foreach( $query as $key => $post ) {
		$store = ( object ) [
			// TODO: Check
			// 'author'	=>	get_the_author( 1 ),
			'categories'=>	get_data( 'category', $post -> ID ),
			'content'	=>	strip_tags( trim( strstr( $post -> post_content, '<!--more-->', true ) ) ),
			'custom'	=>	[],
			'date'		=>	get_the_date( '', $post -> ID ),
			'field'		=>	( object ) [
				'audio'		=>	get_custom( [ 'id' => $post -> ID, 'key' => 'audio' ] ),
				'location'		=>	get_custom( [ 'id' => $post -> ID, 'key' => 'location' ] ),
				'video'		=>	get_custom( [ 'id' => $post -> ID, 'key' => 'video' ] ),
			],
			'format'	=>	get_post_format( $post -> ID ) ? : 'standard',
			'id'		=>	$post -> ID,
			'index'		=>	$key,
			'images'		=>	( object ) [
				'full'		=>	wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ), 'full' )[ 0 ],
				'large'		=>	wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ), 'large' )[ 0 ],
				'medium'	=>	wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ), 'medium' )[ 0 ],
				'medium_large'	=>	wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ), 'medium_large' )[ 0 ],
				'thumbnail'	=>	wp_get_attachment_image_src( get_post_thumbnail_id( $post -> ID ), 'thumbnail' )[ 0 ],
			],
			'modified'	=>	$post -> post_modified,
			'status'	=>	$post -> post_status,
			'tags'		=>	get_tags_codeman( $post -> ID, 'post_tag' ),
			'googlemaps'	=>	get_tags_codeman( $post -> ID, 'googlemaps' ),
			'title'		=>	$post -> post_title,
			'url'		=>	get_permalink( $post -> ID ),
		];
		// TODO: Check Remove
		$store -> category = get_best_category( $store -> categories );

		// filters
		$store -> content = $store -> content ? $store -> content : 'It does not have a description.';

		$posts[] = $store;
	}	// end foreach
	unset( $key, $post );

	return ( object ) [
		'data'	=>	$posts,
		'rows'	=>	count( $posts ),
	];
}	// end function

function get_publications_for( array $params = NULL ): stdClass {
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
	elseif( isset( $params ) )
		return get_publications( get_config( $params ) );
	else
		throw new Exception( 'Not found.' );
}	// end function

function get_search( bool $echo = TRUE ) {
	if( ! isset( $_GET[ 's' ] ) )
		return;

	if( ! $echo )
		return htmlentities( $_GET[ 's' ] );

	echo htmlentities( $_GET[ 's' ] );
}	// end function

function get_subterms( string $slug = NULL, string $taxonomy = NULL ): array {
	if( is_null( $slug ) )
		throw new Exception( 'Slug cannot be null.' );
	if( is_null( $taxonomy ) )
		throw new Exception( 'Taxonomy cannot be null.' );

	$terms = [];
	$parent = is_int( $slug ) ? $slug : get_term_by( 'slug', $slug, $taxonomy );

	$params = [
		'exclude'		=>	0,
		'hide_empty'	=>	false,
		'order'			=>	'ASC',
		'orderby'		=>	'name',
		'parent'		=>	is_int( $slug ) ? $slug : $parent -> term_id,
		'taxonomy'		=>	$taxonomy,
	];

	foreach( get_terms( $params ) as $key => $category ) {
		$terms[] = ( object ) [
			'count'	=>	$category -> count,
			'id'	=>	$category -> term_id,
			'index'	=>	$key,
			'name'	=>	$category -> name,
			'parent'=>	$category -> category_parent,
			'slug'	=>	$category -> slug,
			'url'	=>	get_category_link( $category -> term_id ),
		];
	}	// end foreach
	unset( $key, $category );

	return $terms;
}	// end function

function get_tags_codeman( int $id = NULL, string $taxonomy = NULL ): array {
	$tags = [];
	$data = wp_get_post_terms( $id, $taxonomy, [
		'orderby'	=>	'parent',
		'order'		=>	'ASC',
		'fields'	=>	'all',
	] );
	$data = ! $data ? [] : $data;
	
	foreach( $data as $key => $tag ) {
		$tags[] = ( object ) [
			'index'	=>	$key,
			'name'	=>	$tag -> name,
			'slug'	=>	$tag -> slug,
		];
	}	// end foreach
	unset( $key, $tag );

	return $tags;
}	// end function

function get_url( bool $echo = TRUE ) {
	if( ! $echo )
		return get_permalink();

	echo get_permalink();
}	// end function

function instagram() {
	$output = [
		'message'	=>	'Bad request',
		'status'	=>	'error',
	];

	if( $_SERVER[ 'REQUEST_METHOD' ] === 'GET' ) {
		$handler = curl_init();
		$url = 'https://api.instagram.com/v1/users/self/media/recent?access_token=' . INSTAGRAM_TOKEN . '&count=' . INSTAGRAM_COUNT;
		curl_setopt( $handler, CURLOPT_URL, $url );
		curl_setopt( $handler, CURLOPT_RETURNTRANSFER, 1 );

		$output = curl_exec( $handler ); 
		curl_close( $handler );
	}	// end if

	header( 'Content-Type: application/json' );
	echo json_encode( $output );
	exit;
}	// end function

function image_dir() {
	echo get_template_directory_uri() .'/img';
}	// end function

function is_draft(): bool {
	return is_user_logged_in() && is_preview();
}	// end function

function load_more() {
	$output = [
		'message'	=>	'Bad request',
		'status'	=>	'error',
	];

	if(
		$_SERVER[ 'REQUEST_METHOD' ] === 'GET' &&
		isset( $_GET[ 'page' ] ) &&
		! empty( $_GET[ 'page' ] ) &&
		// $_GET[ 'page' ] > 1	&&
		( ( $_GET[ 'page' ] - 1 ) * POSTS_PER_PAGE ) - wp_count_posts() -> publish < 0
	) {
		$categories = explode( ',', $_GET[ 'category' ] ?? NULL );

		$ids = [];
		foreach( $categories as $category ) {
			$cat = get_category_by_slug( $category );
			$ids[] = $cat -> term_id;
		}	// end foreach
		unset( $category );

		$data = get_publications( get_config( [
			'category__and'		=>	isset( $_GET[ 'category' ] ) ? $ids : NULL,
			'paged'				=>	$_GET[ 'page' ],
			'posts_per_page'	=>	POSTS_PER_PAGE,
		] ) );

		$output = [
			'data'	=>	$data -> data,
			'status'=>	'success',
			'rows'	=>	$data -> rows,
			'total'	=>	intval( wp_count_posts() -> publish ),
		];
	}	// end if

	header( 'Content-Type: application/json' );
	echo json_encode( $output );
	exit;
}	// end function

function my_page_menu_args( array $args ) {
	$args[ 'show_home' ] = TRUE;
	return $args;
}	// end function

function my_post_queries( WP_Query $query ) {
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

function send_contact() {
	header( 'Content-Type: application/json' );
	
	$output = [
		'message'	=>	'Bad request',
		'status'	=>	'error',
	];

	if(
		$_SERVER[ 'REQUEST_METHOD' ] === 'POST'
	) {
		
	}	// end function

	echo json_encode( $output );
	exit;
}	// end function

function send_mail( array $params = NULL ) {
	if(
		! is_array( $params ) ||
		! is_array( $params[ 'to' ] ?? NULL ) ||
		! is_string( $params[ 'subject' ] ?? NULL ) ||
		! is_string( $params[ 'template' ] ?? NULL ) ||
		! is_array( $params[ 'data' ] ?? NULL )
	)
		throw new Exception( 'The parameters are incorrect.' );

	foreach( $params[ 'to' ] as $email )
		if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) )
			throw new Exception( 'Invalid emails.' );
		
	unset( $email );

	$html = file_get_contents( TEMPLATE_PATH . pathinfo( $params[ 'template' ], PATHINFO_BASENAME ) );

	foreach ( $params[ 'data' ] as $key => $value )
		$html = str_replace( '{' . $key . '}', strip_tags( $value ), $html );

	unset( $key, $value );

	wp_mail( $params[ 'to' ], $params[ 'subject' ], $html );
}	// end function

function send_smtp_email( PHPMailer $phpmailer ) {
	$phpmailer -> isSMTP();
	$phpmailer -> Host = 'email-smtp.us-east-1.amazonaws.com';
	$phpmailer -> SMTPAuth = true;
	$phpmailer -> Port = '587';
	$phpmailer -> Username = '';
	$phpmailer -> Password = '';
	$phpmailer -> SMTPSecure = 'tls';
	$phpmailer -> From = 'wordpress@codeman.company';
	$phpmailer -> FromName = 'WordPress';
}	// end function

function wpdocs_set_html_mail_content_type() {
	return 'text/html';
}	// end function

add_action( 'phpmailer_init', 'send_smtp_email' );
add_action( 'pre_get_posts', 'my_post_queries' );
add_action( 'wp_ajax_instagram', 'instagram' );
add_action( 'wp_ajax_nopriv_instagram', 'instagram' );
add_action( 'wp_ajax_load_more', 'load_more' );
add_action( 'wp_ajax_nopriv_load_more', 'load_more' );

add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
add_filter( 'wp_page_menu_args', 'my_page_menu_args' );
add_filter( 'wp_title', 'codeman_wp_title', 10, 2 );

add_theme_support( 'post-formats', [ 'gallery' ] );
add_theme_support( 'post-thumbnails' );