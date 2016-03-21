<?php

function codeman_wp_title( $title, $sep ) {
	$title .= get_bloginfo( 'name', 'display' );

	$description = get_bloginfo( 'description', 'display' );
	if( $description && ( is_home() || is_front_page() ) )
		$title = "{$title} {$sep} {$description}";

	return $title;
}	// end function

function get_articles( $query = NULL, $template = FALSE ) {
	if( is_null( $query ) || ! $query = query_posts( $query ) )
		return 'false';

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
		$posts[] = $template ? get_piece( $store ) : $store;
	}	// end foreach
	unset( $post );

	return ( object ) [
		'data'	=>	$posts,
		'rows'	=>	count( $posts )
	];
}	// end function

function get_image( $id = NULL, $echo = TRUE ) {
	if( is_null( $id ) )
		return FALSE;

	$image = current( get_attached_media( 'image' ) ) -> guid;
	// echo wp_get_attachment_url( $id + 1 ) ? wp_get_attachment_url( $id + 1 ) : current( get_attached_media( 'image' ) ) -> guid;
	if( ! $echo )
		return $image;

	echo $image;
}	// end function

function get_gallery() {
	$images = get_attached_media( 'image' );
	$store = [];

	if( count( $images ) >= 2 ) {
		foreach( $images as $image ) {
			$store[] = $image -> guid;
		}	// end foreach
		unset( $image );

		return $store;
	}	// end if

	return FALSE;
}	// end function

function get_piece( $data = NULL ) {
	if( is_null( $data ) )
		return FALSE;

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
	return is_user_logged_in() && isset( $_GET[ 'p' ] ) && ! empty( $_GET[ 'p' ] );
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
		$_GET[ 'page' ] > 1	&&
		( ( $_GET[ 'page' ] - 1 ) * 15 ) - wp_count_posts() -> publish < 0
	) {
		$data = get_articles( 'post_status=publish&posts_per_page=15&paged=' . $_GET[ 'page' ] );

		$store = [
			'data'	=>	$data -> data,
			'result'=>	'success',
			'rows'	=>	$data -> rows,
			'total'	=>	intval( wp_count_posts() -> publish )
		];
	}	// end if

	header( 'Content-Type: application/json' );
	// echo json_encode( query_posts( '' ) );
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
			$query -> set( 'posts_per_page', 15 );

		elseif( is_category() )
			$query -> set( 'posts_per_page', 15 );

		elseif( is_search() )
			$query -> set( 'posts_per_page', 15 );
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