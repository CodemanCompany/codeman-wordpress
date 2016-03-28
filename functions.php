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

function get_custom( $key ) {
	return get_post_custom_values( $key )[ 0 ];
}	// end function

function get_jwplayer( $service = NULL ) {
	if( is_null( $service ) )
		return;

	$video = get_custom( 'video' );
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
		$value = [
			'description'	=>	get_post( $gallery -> ids[ $key ] ) -> post_excerpt,
			'src'			=>	$value
		];
	}	// end foreach
	unset( $key, $value );

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

// TODO: Check, external
function get_piece( $data = NULL ) {
	if( is_null( $data ) )
		return FALSE;

	// TODO: Standard
	return
	"<article class=\"card\" data-ng-click=\"go( '{$data -> url}' )\">
		<div class=\"content\">
			<div class=\"category\"><a href=\"{$data -> category-> url}\">{$data -> category-> name}</a></div>
			<div class=\"card-image\">
				<img class=\"img-responsive\" src=\"{$data -> image}\" alt=\"\" />
			</div>
			<div class=\"card-content\">
				<h2><a href=\"{$data -> url}\">{$data -> title}</a></h2>
				<p>{$data -> content}</p>
				<br />
				<div><a class=\"shared\" href=\"#\">COMPARTIR</a></div>
			</div>
		</div>
	</article>";
}	// end function

function get_publications( $query = NULL, $template = FALSE ) {
	if( is_null( $query ) || ! is_array( $query = query_posts( $query ) ) )
		throw new Exception( 'The query is wrong.' );

	$posts = [];

	foreach( $query as $post ) {
		$store = ( object ) [
			'id'		=>	$post -> ID,
			'image'		=>	current( get_attached_media( 'image', $post -> ID ) ) -> guid,
			'title'		=>	$post -> post_title,
			'content'	=>	strstr( $post -> post_content, '<!--more-->', true ),
			'category'	=>	( object ) [
				'name'	=>	get_the_category( $post -> ID )[ 0 ] -> name,
				'url'	=>	get_category_link( get_the_category( $post -> ID )[ 0 ] -> cat_ID )
			],
			'date'		=>	get_the_date( '', $post -> ID ),
			'url'		=>	get_permalink( $post -> ID ),
			'modified'	=>	$post -> post_modified,
			'status'	=>	$post -> post_status
		];

		if( ! is_null( $video = get_post_custom_values( 'video', $post -> ID ) ) )
			$store -> video = $video[ 0 ];

		$store -> content = $store -> content ? $store -> content : 'It does not have a description.';
		$posts[] = $template === TRUE ? get_piece( $store ) : $store;
	}	// end foreach
	unset( $post );

	return ( object ) [
		'data'	=>	$posts,
		'rows'	=>	count( $posts )
	];
}	// end function

function get_publications_for( $section = NULL, $template = NULL ) {
	if( is_null( $section ) )
		throw new Exception( 'It is not specified a section.' );
	elseif( $section === 'home' )
		return get_publications( 'post_status=publish&posts_per_page=' . POSTS_PER_PAGE . '&paged=1', $template );
	elseif( $section === 'publication' ) {
		$config = [
			'paged'				=>	1,
			'post__not_in'		=>	[ get_the_ID() ],
			'post_status'		=>	'publish',
			'posts_per_page'	=>	POSTS_PER_SIDEBAR
		];
		return get_publications( $config, $template );
	}	// end elseif
	else
		throw new Exception( 'This section is not found.' );
}	// end if

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
		$category = isset( $_GET[ 'category' ] ) && ! empty( $_GET[ 'category' ] ) ? '&category_name=' . $_GET[ 'category' ] : NULL;
		$data = get_publications( 'post_status=publish&posts_per_page=' . POSTS_PER_PAGE . '&paged=' . $_GET[ 'page' ] . $category );

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

		if( is_home() )
			$query -> set( 'posts_per_page', POSTS_PER_PAGE );

		elseif( is_category() )
			$query -> set( 'posts_per_page', POSTS_PER_PAGE );

		elseif( is_search() )
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